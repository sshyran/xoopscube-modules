<?php
if (!class_exists('Sabai')) exit();

require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_CoolTips_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_CoolTips_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Enables the CoolTips javascript library. See http://www.wildbit.com/labs/cooltips/ for details of the javascript library.');
        $this->_requiredPlugins = array('prototype');
        $this->_params = array('jsInit'  => array(
                                              'type'     => 'textarea',
                                              'required' => true,
                                              'label'    => $this->_('Javascript code to intialize the CoolTips library. See http://www.wildbit.com/labs/cooltips/ for details.'),
                                              'default'  => '$$("#Xigg a.help", "#Xigg span.help", "#Xigg form input.help").each(function(ele) {
  if (ele.title) new Tooltip(ele, {backgroundColor: "#eee", opacity: 0.9});
});
',
                                            ));
    }
}