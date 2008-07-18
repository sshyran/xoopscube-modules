<?php
if (!class_exists('Sabai')) exit();

class Xigg_Plugin_prototype extends Xigg_Plugin
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
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/prototype/js/prototype.js');
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/prototype/js/scriptaculous.js?load=builder,effects', true);
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/prototype/js/prototype.tidbits.js', true);
    }
}