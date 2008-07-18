<?php
if (!class_exists('Sabai')) exit();

class Xigg_Plugin_LinkBubbler extends Xigg_Plugin
{
    function onMainEnter(&$context)
    {
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/LinkBubbler/js/linkbubbler.js', true);
        $context->response->addJSHead('LinkBubbler.init();');
        $context->response->addJSHeadAjax('LinkBubbler.init();');
    }
}