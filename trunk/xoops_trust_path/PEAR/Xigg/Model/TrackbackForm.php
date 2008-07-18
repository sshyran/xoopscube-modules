<?php
class Xigg_Model_TrackbackForm extends Xigg_Model_TrackbackFormBase
{
    function _onInit()
    {
        // things that should be applied to all forms should come here (e.g., add validators)
        $this->validatesURLOf('url', _('Invalid source URL'));
    }

    function _onEntity(&$entity)
    {
        // things that should be applied to a specific entity form should come here
    }
}