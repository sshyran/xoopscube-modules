<?php
class Xigg_Main_SubmitNodeForm extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        $node =& $model->create('Node');
        $node_form =& $this->_getNodeForm($node, $context);
        $context->response->setVar('node_form_action', '/submit');
        if ($category_id = $context->request->getAsInt('category_id', false)) {
            $category_r =& $model->getRepository('Category');
            if ($category =& $category_r->fetchById($category_id)) {
                $node_form->setValueFor('Category', $category->getId());
            }
        }
        $plugin_mngr =& $context->application->locator->getService('PluginManager');
        if ($context->request->isPost()) {
            $node_form->setValues($context->request->getAll());
            if ($context->request->getAsStr('change_syntax')) {
                // need to convert encoding since AJAX with Form.serialize() comes with UTF-8
                if (SABAI_CHARSET != 'UTF-8') {
                    foreach (array('title', 'teaser', 'body', 'tagging') as $node_form_k) {
                        $node_form->setValueFor($node_form_k,
                                                mb_convert_encoding($node_form->getValueFor($node_form_k),
                                                                    SABAI_CHARSET,
                                                                    array(SABAI_CHARSET, 'UTF-8')));
                    }
                }
            } elseif ($context->request->getAsStr('preview_form')) {
                $node_form->validate();
                if ($node_form->isValid()) {
                    $node->applyForm($node_form);
                    $node->HTMLize($plugin_mngr);
                    $node->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                    $context->response->setVarRef('node_preview', $node);
                }
            } elseif ($context->request->getAsStr('submit_form')) {
                $node_form->validate();
                if ($node_form->isValid()) {
                    $plugin_mngr->dispatch('SubmitNodeForm', array(&$node_form, /*$isEdit*/ false));
                    $node->applyForm($node_form);
                    $node->assignUser($context->user);
                    if (!$context->application->config->get('useUpcomingFeature') || $context->user->hasPermission(array('article publish own', 'publish any article'))) {
                        $node->publish(time() + 2);
                    }
                    $node->markNew();
                    $plugin_mngr->dispatch('SubmitNode', array(&$node, /*$isEdit*/ false));
                    $node->HTMLize($plugin_mngr);
                    $node->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                    if ($node->commit()) {
                        // do auto tagging after success
                        if ($tagging = $node_form->getValueFor('tagging')) {
                            $node->linkTagsByStr($tagging);
                        }
                        $context->response->setSuccess(_('Node submitted successfully'), array('base' => '/node/' . $node->getId()));
                        $plugin_mngr->dispatch('SubmitNodeSuccess', array(&$node, /*$isEdit*/ false));
                        return;
                    }
                }
            }
        }
        $node_form->onView();
        $plugin_mngr->dispatch('ShowNodeForm', array(&$node_form, /*$isEdit*/ false));
        $context->response->setVarRef('node_form', $node_form);
    }

    function _validateSource($source, &$context)
    {
        $model =& $context->application->locator->getService('Model');
        $source = trim(trim($source), '&' . _(' '));
        if (strlen($source)) {
            $node_r =& $model->getRepository('Node');
            $criteria =& Sabai_Model_Criteria::createString('node_source', $source, '^');
            if ($node_r->countByCriteria($criteria) > 0) {
                return false;
            }
        }
        return true;
    }

    function &_getNodeForm(&$node, &$context)
    {
        $node_form =& $node->toTokenForm('Node_submit');
        $node_form->removeElements(array('Tags', 'status'));
        // need the source_title element so that it's value loaded automaticlly
        $node_form->hideElement('source_title');
        if (!$context->user->hasPermission('article edit priority')) {
            $node_form->removeElement('priority');
        }
        if (!$context->user->hasPermission('article edit views')) {
            $node_form->removeElement('views');
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
        $node_form->removeElements(array('teaser_html', 'body_html'));
        $node_form->validatesWithCallback('source', _('The source has been quoted already'), array(&$this, '_validateSource'), array(&$context));
        return $node_form;
    }
}