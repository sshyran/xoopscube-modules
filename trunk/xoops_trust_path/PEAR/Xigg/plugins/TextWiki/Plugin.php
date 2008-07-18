<?php
class Xigg_Plugin_TextWiki extends Xigg_Plugin
{
    function &getTextWiki()
    {
        static $textWiki;
        if (!isset($textWiki[0])) {
            require_once 'PEAR.php';
            require_once 'Text/Wiki.php';
            $textWiki = array();
            $textWiki[0] =& Text_Wiki::singleton('Default', null);
            $textWiki[0]->deleteRule('Wikilink');
            $textWiki[0]->deleteRule('Freelink');
            $textWiki[0]->deleteRule('phplookup');
		    $textWiki[0]->setFormatConf('Xhtml', 'translate', HTML_SPECIALCHARS);
		    $textWiki[0]->setRenderConf('Xhtml', 'toc', 'css_list', 'tocList');
		    $textWiki[0]->setRenderConf('Xhtml', 'toc', 'css_item', 'tocItem');
		    $textWiki[0]->setRenderConf('Xhtml', 'toc', 'title', _('<strong>Table of Contents</strong>'));
        }
        return $textWiki[0];
    }

    function onHTMLizeNodeTeaser($id, $contentSyntax, &$teaser, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'Text_Wiki') {
            $textWiki =& Xigg_Plugin_TextWiki::getTextWiki();
            $textWiki->setParseConf('heading', 'id_prefix', 'Xigg-toc-teaser' . $id . '-');
            $teaser = $textWiki->transform($teaser, 'Xhtml');
            // auto paragraph and linkify features are provided by Text_Wiki
            $autoParagraph = $linkify = false;
        }
    }

    function onHTMLizeNodeBody($id, $contentSyntax, &$body, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'Text_Wiki') {
            $textWiki =& Xigg_Plugin_TextWiki::getTextWiki();
            $textWiki->setParseConf('heading', 'id_prefix', 'Xigg-toc-body' . $id . '-');
            $body = $textWiki->transform($body, 'Xhtml');
            // auto paragraph and linkify features are provided by Text_Wiki
            $autoParagraph = $linkify = false;
        }
    }
/*
    function onHTMLizeCommentBody($id, $contentSyntax, &$body, &$autoParagraph, &$linkify, &$context)
    {
        if ($contentSyntax == 'Text_Wiki') {
            // prefix toc ids with comment id
            $textWiki =& Xigg_Plugin_TextWiki::getTextWiki();
            $prev_id = $textWiki->getParseConf('heading', 'id_prefix');
            $textWiki->setParseConf('heading', 'id_prefix', 'Xigg-toc-comment' . $id . '-');
            $body = $textWiki->transform($body, 'Xhtml');
            // auto paragraph and linkify features are provided by Text_Wiki
            $autoParagraph = $linkify = false;
        }
    }
*/
    function onShowNodeForm(&$form, $isEdit, &$context)
    {
        $syntax =& $form->getElement('content_syntax');
        $syntax->addOption('Text_Wiki', $this->_('Text_Wiki'));
        if ($syntax->getValue() == 'Text_Wiki') {
            require_once dirname(__FILE__) . '/ShowNodeFormTextarea.php';
            $form->addElement(new Xigg_Plugin_TextWiki_ShowNodeFormTextarea(
                                $form->getElement('teaser'),
                                10),
                              $form->getElementLabel('teaser'));
            $form->addElement(new Xigg_Plugin_TextWiki_ShowNodeFormTextarea($form->getElement('body')),
                              $form->getElementLabel('body'));
        }
    }
/*
    function onShowCommentForm(&$form, $isEdit, &$context)
    {
        if ($form->hasElement('content_syntax')) {
            $syntax =& $form->getElement('content_syntax');
            $syntax->addOption('Text_Wiki', 'Text_Wiki');
            if ($syntax->getValue() == 'Text_Wiki') {
                require_once dirname(__FILE__) . '/ShowNodeFormTextarea.php';
                $form->addElement(new Xigg_Plugin_TextWiki_ShowNodeFormTextarea(
                                    $form->getElement('body')),
                                  $form->getElementLabel('body'));
            }
        }
    }
*/
}