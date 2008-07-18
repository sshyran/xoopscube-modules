<?php
class Xigg_Model_VoteForm extends Xigg_Model_VoteFormBase
{
    function _onInit($params)
    {
        // things that should be applied to all forms should come here (e.g., add validators)
        // following columns should not be changed via form
        $this->removeElements(array('userid'));
    }

    function _onEntity(&$entity)
    {
        // things that should be applied to a specific entity form should come here
    }
}