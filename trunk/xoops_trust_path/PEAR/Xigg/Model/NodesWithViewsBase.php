<?php
/*
This file has been generated by the Sabai scaffold script. Do not edit this file directly.
*/

require_once 'Sabai/Model/EntityCollection/Decorator/ForeignEntities.php';

class Xigg_Model_NodesWithViewsBase extends Sabai_Model_EntityCollection_Decorator_ForeignEntities
{
    function Xigg_Model_NodesWithViewsBase(&$collection)
    {
        parent::Sabai_Model_EntityCollection_Decorator_ForeignEntities('view_node_id', 'View', 'view_node_id', $collection);
    }
}