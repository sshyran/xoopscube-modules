<?php
if (!class_exists('Sabai')) exit();

class Xigg_Plugin_ExternalLink extends Xigg_Plugin
{
    function onMainEnter(&$context)
    {
        $this->_onEnter($context);
    }

    function onAdminEnter(&$context)
    {
        $this->_onEnter($context);
    }

    function _onEnter(&$context)
    {
        $js = sprintf("\$\$('#Xigg a[href^=\"http\"]:not([href*=\"%2\$s\"])').each(function(anchor) {
  anchor.writeAttribute('target', '_blank');
  if (!anchor.firstDescendant() || anchor.firstDescendant().tagName.toLowerCase() != 'img') {
    anchor.setStyle({background: \"url('%1\$s/plugins/ExternalLink/external_link.gif') no-repeat right top\", paddingRight: \"12px\"});
  }
});", $context->request->getScriptUriDir(), $this->_params['localhost']);
        $context->response->addJSHead($js);
        $context->response->addJSHeadAjax($js);
    }
}