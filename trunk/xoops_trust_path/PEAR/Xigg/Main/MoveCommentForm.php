<?php
class Xigg_Main_MoveCommentForm extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$comment_id = $context->request->getAsInt('comment_id')) {
            $context->response->setError(_('Invalid comment'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $comment_r =& $model->getRepository('Comment');
        if (!$comment =& $comment_r->fetchById($comment_id)) {
            $context->response->setError(_('Invalid comment'));
            return;
        }
        if (!$context->user->hasPermission('comment move any')) {
            if (!$comment->isOwnedBy($context->user) || !$context->user->hasPermission('comment move own')) {
                $context->response->setError(_('You are not allowed to move this comment'), array('base' => '/comment/' . $comment->getId()));
                return;
            }
        }
        require_once 'Sabai/Form.php';
        require_once 'Sabai/Form/Element/InputText.php';
        require_once 'Sabai/Form/Decorator/Token.php';
        $form =& new Sabai_Form();
        $form->addElement(new Sabai_Form_Element_InputText('move_to', 5, 10));
        $form =& new Sabai_Form_Decorator_Token($form, 'Comment_move');
        if ($context->request->isPost()) {
            if ($form->validateValues($context->request->getAll())) {
                $comment->setVar('parent', $form->getValueFor('move_to'));
                if ($model->commit()) {
                    $context->response->setSuccess(_('Comment moved successfully'), array('base' => '/comment/' . $comment->getId(), 'fragment' => 'comment' . $comment->getId()));
                    return;
                } else {

                }
            }
        }
        $form->onView();
        $node =& $comment->get('Node');
        $context->response->setVars(array('comment_form' => &$form,
                                 'comment'      => &$comment,
                                 'node'         => &$node));
    }
}