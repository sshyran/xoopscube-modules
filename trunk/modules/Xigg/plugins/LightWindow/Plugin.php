<?php
if (!class_exists('Sabai')) exit();

class Xigg_Plugin_LightWindow extends Xigg_Plugin
{
    function onMainEnter(&$context)
    {
        $this->_onEnter($context);
    }

    function _onEnter(&$context)
    {
        $js = sprintf('lightwindowInit("%s/plugins/LightWindow");', $context->request->getScriptUriDir());
        $context->response->addJSHead($js);
        $context->response->addJSHeadAjax($js);
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/LightWindow/javascript/lightwindow.js', true);
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/LightWindow/javascript/lightwindowInit.js', true);
        $context->response->addCSSFile($context->request->getScriptUriDir() . '/plugins/LightWindow/css/lightwindow.css');
    }
}