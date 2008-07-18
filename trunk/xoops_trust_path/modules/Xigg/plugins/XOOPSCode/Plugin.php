<?php
class Xigg_Plugin_XOOPSCode extends Xigg_Plugin
{
    function onHTMLizeNodeTeaser($id, $contentSyntax, &$teaser, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'XOOPSCode') {
            $teaser = $this->_sanitizeText($teaser);
            $autoParagraph = $linkify = false;
        }
    }

    function onHTMLizeNodeBody($id, $contentSyntax, &$body, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'XOOPSCode') {
            $body = $this->_sanitizeText($body);
            $autoParagraph = $linkify = false;
        }
    }

    function onHTMLizeCommentBody($id, $contentSyntax, &$body, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'XOOPSCode') {
            $body = $this->_sanitizeText($body);
            $autoParagraph = $linkify = false;
        }
    }

    function onShowNodeForm(&$form, $isEdit, &$context)
    {
        $syntax =& $form->getElement('content_syntax');
        $syntax->addOption('XOOPSCode', 'XOOPSCode');
        if (!$syntax->getValue()) {
            $syntax->setValue('XOOPSCode');
        } else {
            if ($syntax->getValue() == 'XOOPSCode') {
                require_once dirname(__FILE__) . '/ShowNodeFormTextarea.php';
                $form->addElement(new Xigg_Plugin_XOOPSCode_ShowNodeFormTextarea($form->getElement('teaser')),
                                  $form->getElementLabel('teaser'));
                $form->addElement(new Xigg_Plugin_XOOPSCode_ShowNodeFormTextarea($form->getElement('body')),
                                  $form->getElementLabel('body'));
            }
        }
    }

    function onShowCommentForm(&$form, $isEdit, &$context)
    {
        if ($form->hasElement('content_syntax')) {
            $syntax =& $form->getElement('content_syntax');
            $syntax->addOption('XOOPSCode', 'XOOPSCode');
            if (!$syntax->getValue()) {
                $syntax->setValue('XOOPSCode');
            } else {
                if ($syntax->getValue() == 'XOOPSCode') {
                    require_once dirname(__FILE__) . '/ShowNodeFormTextarea.php';
                    $form->addElement(new Xigg_Plugin_XOOPSCode_ShowNodeFormTextarea($form->getElement('body')),
                                      $form->getElementLabel('body'));
                }
            }
        }
    }

    function _sanitizeText($text)
    {
        $sanitizer =& MyTextSanitizer::getInstance();
        // allow HTML including images since it will be purified by HTMLPurifier ;-)
        $text = $sanitizer->displayTarea($text, 1, 1, 1, 1, 1);
        return $text;
    }
}