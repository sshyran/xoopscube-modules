<?php
class Xigg_Model_Plugin extends Xigg_Model_PluginBase
{
    function Xigg_Model_Plugin(&$model)
    {
        parent::Xigg_Model_PluginBase($model);
    }

    function getParams()
    {
        return unserialize($this->get('params'));
    }

    function setParams($params)
    {
        $this->set('params', serialize($params));
    }

    function canUninstall()
    {
        return (bool)$this->get('can_uninstall');
    }
}

class Xigg_Model_PluginRepository extends Xigg_Model_PluginRepositoryBase
{
    function Xigg_Model_PluginRepository(&$model)
    {
        parent::Xigg_Model_PluginRepositoryBase($model);
    }
}