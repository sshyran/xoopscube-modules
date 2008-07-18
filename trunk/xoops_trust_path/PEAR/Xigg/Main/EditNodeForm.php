<?php
class Xigg_Main_EditNodeForm extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        if ($node->isPublished()) {
            if (!$context->user->hasPermission('article edit any published')) {
                if (!$node->get('allow_edit')) {
                    $context->response->setError(_('This news item has been frozen by the administration'), array('base' => '/node/' . $node->getId()));
                    return;
                }
                if (!$node->isOwnedBy($context->user) || !$context->user->hasPermission('article edit own published')) {
                    $context->response->setError(_('You are not allowed to edit this published article'), array('base' => '/node/' . $node->getId()));
                    return;
                }
            }
        } else {
            if (!$context->user->hasPermission('article edit any unpublished')) {
                if (!$node->get('allow_edit')) {
                    $context->response->setError(_('This news item has been frozen by the administration'), array('base' => '/node/' . $node->getId()));
                    return;
                }
                if (!$node->isOwnedBy($context->user) || !$context->user->hasPermission('article edit own unpublished')) {
                    $context->response->setError(_('You are not allowed to edit this article'), array('base' => '/node/' . $node->getId()));
                    return;
                }
            }
        }
        $node_form =& $this->_getNodeForm($node, $context);
        $plugin_mngr =& $context->application->locator->getService('PluginManager');
        if ($context->request->isPost()) {
            $node_form->setValues($context->request->getAll());
            if ($context->request->getAsStr('change_syntax')) {
                // need to convert encoding since AJAX with Form.serialize() comes with UTF-8
                if (SABAI_CHARSET != 'UTF-8') {
                    foreach (array('title', 'teaser', 'body', 'teaser_html', 'body_html', 'source_title', 'tagging') as $node_form_k) {
                        if ($node_form->hasElement($node_form_k)) {
                            $node_form->setValueFor($node_form_k,
                                                    mb_convert_encoding($node_form->getValueFor($node_form_k),
                                                    SABAI_CHARSET,
                                                    array(SABAI_CHARSET, 'UTF-8')));
                        }
                    }
                }
            } elseif ($context->request->getAsStr('preview_form')) {
                $node_form->validate();
                if ($node_form->isValid()) {
                    $node->applyForm($node_form);
                    if ($node_form->hasElement('teaser_html') && $node_form->hasElement('body_html')) {
                        if ($context->request->getAsBool('teaser_html_regenerate')) {
                            $node->HTMLizeTeaser($plugin_mngr);
                        } else {
                            $context->response->setVar('teaser_html_regenerate', false);
                        }
                        if ($context->request->getAsBool('body_html_regenerate')) {
                            $node->HTMLizeBody($plugin_mngr);
                        } else {
                            $context->response->setVar('body_html_regenerate', false);
                        }
                        $node->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                        // set purified HTML back to the form
                        $node_form->setValueFor('teaser_html', $node->get('teaser_html'));
                        $node_form->setValueFor('body_html', $node->get('body_html'));
                    } else {
                        $node->HTMLize($plugin_mngr);
                        $node->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                    }
                    $context->response->setVarRef('node_preview', $node);
                }
            } elseif ($context->request->getAsStr('submit_form')) {
                $node_form->validate();
                if ($node_form->isValid()) {
                    $node->applyForm($node_form);
                    $plugin_mngr->dispatch('SubmitNode', array(&$node, /*$isEdit*/ true));
                    if ($node_form->hasElement('teaser_html') && $node_form->hasElement('body_html')) {
                        if ($context->request->getAsBool('teaser_html_regenerate')) {
                            $node->HTMLizeTeaser($plugin_mngr);
                        }
                        if ($context->request->getAsBool('body_html_regenerate')) {
                            $node->HTMLizeBody($plugin_mngr);
                        }
                    } else {
                        $node->HTMLize($plugin_mngr);
                    }
                    if ($context->request->getAsBool('published_update')) {
                        $node->publish(time());
                    }
                    // always purify HTML before commit
                    $node->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                    if ($node->commit()) {
                        // do auto tagging after success
                        $node->unlinkTags();
                        if ($tagging = $node_form->getValueFor('tagging')) {
                            $node->linkTagsByStr($tagging);
                        }
                        $context->response->setSuccess(_('Node updated successfully'), array('base' => '/node/' . $node->getId()));
                        $plugin_mngr->dispatch('SubmitNodeSuccess', array(&$node, /*$isEdit*/ true));
                        return;
                    }
                }
            }
        }
        $node_form->onView();
        $plugin_mngr->dispatch('ShowNodeForm', array(&$node_form, /*$isEdit*/true));
        if ($context->request->getAsBool('published_update', false)) {
            $context->response->setVar('published_update', true);
        }
        $context->response->setVars(array(
                                      'node_form' => &$node_form,
                                      'node'      => &$node));
    }

    function &_getNodeForm(&$node, &$context)
    {
        $node_form =& $node->toTokenForm('Node_edit');
        $node_form->removeElements(array('Tags', 'status'));
        if (!$context->user->hasPermission('article edit source title')) {
            $node_form->removeElement('source_title');
        }
        if (!$context->user->hasPermission('article edit priority')) {
            $node_form->removeElement('priority');
        }
        if (!$context->user->hasPermission('article edit views')) {
            $node_form->removeElement('views');
        }
        if (!$context->user->hasPermission('article edit published')) {
            $node_form->removeElement('published');
        }
        if (!$context->user->hasPermission('article allow edit')) {
            $node_form->removeElement('allow_edit');
        }
        if (!$context->user->hasPermission('article allow comments')) {
            $node_form->removeElement('allow_comments');
        }
        if (!$context->user->hasPermission('article allow trackbacks')) {
            $node_form->removeElement('allow_trackbacks');
        }
        if (!$context->user->hasPermission('article hide')) {
            $node_form->removeElement('hidden');
        }
        if (!$context->user->hasPermission('article edit html')) {
            $node_form->removeElements(array('teaser_html', 'body_html'));
        }
        return $node_form;
    }
}