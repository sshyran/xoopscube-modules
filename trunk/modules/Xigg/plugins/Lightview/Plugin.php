<?php
if (!class_exists('Sabai')) exit();

class Xigg_Plugin_Lightview extends Xigg_Plugin
{
    function onMainEnter(&$context)
    {
        $this->_onEnter($context);
    }

    function _onEnter(&$context)
    {
        $context->response->addJSHead('Lightview.updateViews();');
        $context->response->addJSHeadAjax('Lightview.updateViews();');
        $context->response->addJSFoot(sprintf('Lightview.images = "%s/plugins/Lightview/images/lightview/";', $context->request->getScriptUriDir()), 'foot');
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/Lightview/js/lightview.js', true);
        $context->response->addCSSFile($context->request->getScriptUriDir() . '/plugins/Lightview/css/lightview.css');
    }
}