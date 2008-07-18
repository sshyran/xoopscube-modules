<?php
class Xigg_Main_PublishNodeForm extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$node =& $this->_parent->getNodeById($context, 'node_id')) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        if (!$context->user->hasPermission('article publish any')) {
            if (!$node->isOwnedBy($context->user) || !$context->user->hasPermission('article publish own')) {
                $context->response->setError(_('Permission denied'), array('base' => '/node/' . $node->getId()));
                return;
            }
        }
        $node_form =& $node->toTokenForm('Node_publish');
        $node_form->removeElements(array('Tags', 'status', 'source', 'source_title', 'title', 'body', 'allow_comments', 'allow_trackbacks'));
        if ($context->request->isPost()) {
            if ($node_form->validateValues($context->request->getAll())) {
                $node->publish();
                if ($node->commit()) {
                    $context->response->setSuccess(_('News item published successfully'), array('base' => '/node/' . $node->getId()));
                    return;
                }
            }
        }
        $node_form->onView();
        $context->response->setVars(array('node_form' => &$node_form,
                                 'node'      => &$node));
    }
}