<?php
class Xigg_Main_Index extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $this->_parent->forward('/node', $context);
    }
}