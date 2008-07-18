<?php
if (!class_exists('Sabai')) exit();

class Xigg_Plugin_dpSyntaxHighlighter extends Xigg_Plugin
{
    function onMainEnter(&$context)
    {
        $this->_onEnter($context);
    }

    function _onEnter(&$context)
    {
        if (empty($this->_params['brushes'])) {
            return;
        }
        $context->response->addJSFoot('dp.SyntaxHighlighter.ClipboardSwf = "'. $context->request->getScriptUriDir() .'/plugins/dpSyntaxHighlighter/Scripts/clipboard.swf";');
        $js = sprintf('dp.SyntaxHighlighter.HighlightAll("code", %s, %s);', $this->_params['showGutters'] ? 'true' : 'false', $this->_params['showControls'] ? 'true' : 'false');
        $context->response->addJSHead($js);
        $context->response->addJSHeadAjax($js);
        $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/dpSyntaxHighlighter/Scripts/shCore.js', true);
        foreach (explode('|', $this->_params['brushes']) as $brush) {
            $context->response->addJSFile(sprintf('%s/plugins/dpSyntaxHighlighter/Scripts/shBrush%s.js', $context->request->getScriptUriDir(), $brush), true);
        }
        $context->response->addCSSFile($context->request->getScriptUriDir() . '/plugins/dpSyntaxHighlighter/Styles/SyntaxHighlighter.css');
    }

    function onHTMLPurifierConfigure(&$config, &$context)
    {
        $htmlDef =& $config->getHTMLDefinition(true);
        $htmlDef->addElement(
          'pre',
          'Inline',
          'Inline',
          'Common',
          array(
            'name'  => 'Enum#code',
            'class' => 'Text'
          )
        );
    }
}