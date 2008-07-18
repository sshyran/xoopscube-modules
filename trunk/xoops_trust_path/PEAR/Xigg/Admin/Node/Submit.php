<?php
class Xigg_Admin_Node_Submit extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ($category_id = $context->request->getAsInt('category_id', false)) {
            $error_url = $success_url = array('base' => '/category/' . $category_id);
        } elseif ($tag_id = $context->request->getAsInt('tag_id', false)) {
            $error_url = $success_url = array('base' => '/tag/' . $tag_id);
        } else {
            $error_url = $success_url = array('base' => '/node');
        }
        if (!$context->request->isPost()) {
            $context->response->setError(_('Invalid request'), $error_url);
            return;
        }
        if (!$nodes = $context->request->getAsArray('nodes')) {
            $context->response->setError(_('Invalid request'), $error_url);
            return;
        }
        if (!$token_value = $context->request->getAsStr('_TOKEN', false)) {
            $context->response->setError(_('Invalid request'), $error_url);
            return;
        }
        require_once 'Sabai/Validator/Token.php';
        $validator =& new Sabai_Validator_Token('Admin_node_submit');
        if (!$validator->validate($token_value)) {
            $context->response->setError(_('Invalid request'), $error_url);
            return;
        }
        foreach (array('publish', 'hide', 'unhide', 'delete') as $action) {
            if ($context->request->getAsBool($action, false)) {
                break;
            }
        }
        switch ($action) {
            case 'publish':
                if (false === $num = $this->_publish($context, $nodes)) {
                    $context->response->setError(_('Could not publish selected nodes'), $error_url);
                } else {
                    $context->response->setSuccess(Sabai_I18N::__('%d node(s) published successfully', $num), $success_url);
                }
                break;
            case 'hide':
                if (false === $num = $this->_hide($context, $nodes)) {
                    $context->response->setError(_('Could not hide selected nodes'), $error_url);
                } else {
                    $context->response->setSuccess(Sabai_I18N::__('%d node(s) hidden successfully', $num), $success_url);
                }
                break;
            case 'unhide':
                if (false === $num = $this->_unhide($context, $nodes)) {
                    $context->response->setError(_('Could not unhide selected nodes'), $error_url);
                } else {
                    $context->response->setSuccess(Sabai_I18N::__('%d node(s) unhidden successfully', $num), $success_url);
                }
                break;
            case 'delete':
                if (false === $num = $this->_delete($context, $nodes)) {
                    $context->response->setError(_('Could not delete selected nodes'), $error_url);
                } else {
                    $context->response->setSuccess(Sabai_I18N::__('%d node(s) deleted successfully', $num), $success_url);
                }
                break;
            default:
                $context->response->setError(_('Invalid request'), $error_url);
        }
    }

    function _publish(&$context, $nodes)
    {
        $model =& $context->application->locator->getService('Model');
        $node_r =& $model->getRepository('Node');
        $criteria_status =& Sabai_Model_Criteria::createValue('node_status', XIGG_NODE_STATUS_PUBLISHED, '!=');
        $criteria =& Sabai_Model_Criteria::createComposite(array(&$criteria_status));
        $criteria->addAnd(Sabai_Model_Criteria::createIn('node_id', $nodes));
        $nodes =& $node_r->fetchByCriteria($criteria);
        while ($node =& $nodes->getNext()) {
            $node->publish();
        }
        return $model->commit();
    }

    function _hide(&$context, $nodes)
    {
        $model =& $context->application->locator->getService('Model');
        $node_r =& $model->getRepository('Node');
        $criteria_hidden =& Sabai_Model_Criteria::createValue('node_hidden', 1, '!=');
        $criteria =& Sabai_Model_Criteria::createComposite(array(&$criteria_hidden));
        $criteria->addAnd(Sabai_Model_Criteria::createIn('node_id', $nodes));
        $nodes =& $node_r->fetchByCriteria($criteria);
        while ($node =& $nodes->getNext()) {
            $node->hide();
        }
        return $model->commit();
    }

    function _unhide(&$context, $nodes)
    {
        $model =& $context->application->locator->getService('Model');
        $node_r =& $model->getRepository('Node');
        $criteria_hidden =& Sabai_Model_Criteria::createValue('node_hidden', 1);
        $criteria =& Sabai_Model_Criteria::createComposite(array(&$criteria_hidden));
        $criteria->addAnd(Sabai_Model_Criteria::createIn('node_id', $nodes));
        $nodes =& $node_r->fetchByCriteria($criteria);
        while ($node =& $nodes->getNext()) {
            $node->unhide();
        }
        return $model->commit();
    }

    function _delete(&$context, $nodes)
    {
        $model =& $context->application->locator->getService('Model');
        $node_r =& $model->getRepository('Node');
        $nodes =& $node_r->fetchByCriteria(Sabai_Model_Criteria::createIn('node_id', $nodes));
        while ($node =& $nodes->getNext()) {
            $node->markRemoved();
        }
        return $model->commit();
    }
}