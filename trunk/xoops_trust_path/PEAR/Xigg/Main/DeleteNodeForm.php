<?php
class Xigg_Main_DeleteNodeForm extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        if ($node->isPublished()) {
            if (!$context->user->hasPermission('article delete any published')) {
                if (!$node->isOwnedBy($context->user) || !$context->user->hasPermission('article delete own published')) {
                    $context->response->setError(_('You are not allowed to delete this published article'), array('base' => '/node/' . $node->getId()));
                    return;
                }
            }
        } else {
            if (!$context->user->hasPermission('article delete any unpublished')) {
                if (!$node->isOwnedBy($context->user) || !$context->user->hasPermission('article delete own unpublished')) {
                    $context->response->setError(_('You are not allowed to delete this article'), array('base' => '/node/' . $node->getId()));
                    return;
                }
            }
        }
        $node_form =& $node->toTokenForm('Node_delete');
        $node_form->removeElements(array('Tags', 'status', 'source_title', 'source', 'title', 'body', 'allow_comments', 'allow_trackbacks'));
        if ($context->request->isPost()) {
            if ($node_form->validateValues($context->request->getAll())) {
                $node->markRemoved();
                if ($node->commit()) {
                    $context->response->setSuccess(_('Node deleted successfully'));
                    return;
                }
            }
        }
        $node_form->onView();
        $context->response->setVars(array('node_form' => &$node_form,
                                 'node'      => &$node));
    }
}