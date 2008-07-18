<?php
if (!class_exists('Sabai')) exit();

class Xigg_Plugin_CoolTips extends Xigg_Plugin
{
    function onMainEnter(&$context)
    {
        $this->_onEnter($context);
    }

    function _onEnter(&$context)
    {
        $context->response->addJSHead($this->_params['jsInit']);
        $context->response->addJSHeadAjax($this->_params['jsInit']);
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/CoolTips/js/tooltips.js', true);
        $context->response->addCSSFile($context->request->getScriptUriDir() . '/plugins/CoolTips/css/tooltips.css');
    }
}