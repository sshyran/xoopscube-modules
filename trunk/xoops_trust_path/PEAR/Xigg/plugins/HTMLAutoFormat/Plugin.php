<?php
class Xigg_Plugin_HTMLAutoFormat extends Xigg_Plugin
{
    function onHTMLizeNodeTeaser($id, $contentSyntax, &$teaser, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'HTML_AutoFormat') {
            $autoParagraph = $linkify = true;
        }
    }

    function onHTMLizeNodeBody($id, $contentSyntax, &$body, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'HTML_AutoFormat') {
            $autoParagraph = $linkify = true;
        }
    }

    function onHTMLizeCommentBody($id, $contentSyntax, &$body, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'HTML_AutoFormat') {
            $autoParagraph = $linkify = true;
            //$body = preg_replace('/\n(\w)/', '<br />\\1', $body);
/*            if (preg_match('/\n((\>).*\n)(?!(\>))/Us', "\n" . $body)) {
            	$body = substr(preg_replace('/\n(\>)+\s/', '<br />\\0', "\n" . $body), 1);
				//$body = '<blockquote>' . preg_replace('/\n(\>)+\s/', "\n", "\n" . $body . "\n") . '</blockquote>';
			}*/
        }
    }

    function onShowNodeForm(&$form, $isEdit, &$context)
    {
        $syntax =& $form->getElement('content_syntax');
        $syntax->addOption('HTML_AutoFormat', $this->_('HTML AutoFormat'));
    }

    function onShowCommentForm(&$form, $isEdit, &$context)
    {
        if ($form->hasElement('content_syntax')) {
            $syntax =& $form->getElement('content_syntax');
            $syntax->addOption('HTML_AutoFormat', $this->_('HTML AutoFormat'));
        }
    }
}