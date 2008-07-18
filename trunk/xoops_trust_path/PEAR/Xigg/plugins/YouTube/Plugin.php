<?php
class Xigg_Plugin_YouTube extends Xigg_Plugin
{
    function onHTMLPurifierInit(&$HTMLPurifier, &$context)
    {
        if (!$context->user->hasPermission('youtube embed')) {
            return;
        }
        require_once dirname(__FILE__) . '/HTMLPurifierFilter.php';
        $filter =& new Xigg_Plugin_YouTube_HTMLPurifierFilter(
                     $this->_params['width'],
                     $this->_params['height'],
                     $this->_params['showRelatedVideos']);
        $HTMLPurifier->addFilter($filter);
    }

    function onRolePermissions(&$permissions, &$context)
    {
        $permissions[$this->_name] = array(
                                      'youtube embed' => $this->_('Embed YouTube videos'),
                                     );
    }
}