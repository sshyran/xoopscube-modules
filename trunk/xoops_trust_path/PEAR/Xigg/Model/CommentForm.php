<?php
class Xigg_Model_CommentForm extends Xigg_Model_CommentFormBase
{
    function _onInit($params)
    {
        // forllowing properties should not be changed via form
        $this->removeElements(array('Parent', 'body_cache', 'userid'));
        $this->validatesPresenceOf('title', _('You must enter title for the comment'), _(' '));
        $this->validatesPresenceOf('body', _('You must enter something to comment'), _(' '));
        // set content_syntax options
        $status =& $this->getElement('content_syntax');
        $status->addOption('HTML', 'HTML');
    }

    function _onEntity(&$entity)
    {
        // things that should be applied to a specific entity form should come here
    }
}