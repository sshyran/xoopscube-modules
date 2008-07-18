<?php
class Xigg_Model_Comment extends Xigg_Model_CommentBase
{
    var $_autoParagraphBody = false;
    var $_linkifyBody = false;

    function Xigg_Model_Comment(&$model)
    {
        parent::Xigg_Model_CommentBase($model);
    }

    function HTMLize(&$pluginsManager)
    {
        $body = $this->get('body');
        $pluginsManager->dispatch('HTMLizeCommentBody', array($this->getId(),
                                                              $this->get('content_syntax'),
                                                              &$body,
                                                              &$this->_autoParagraphBody,
                                                              &$this->_linkifyBody));
        $this->set('body_html', $body);
    }

    function purifyHTML(&$purifier)
    {
        $purifier->config->set('AutoFormat', 'AutoParagraph', $this->_autoParagraphBody);
        $purifier->config->set('AutoFormat', 'Linkify', $this->_linkifyBody);
        if (SABAI_CHARSET != 'UTF-8') {
            $html = preg_replace('/&([a-zA-Z0-9]{2,8};)/', '&amp;\\1', $this->get('body_html'));
            $html = mb_convert_encoding($purifier->purify(mb_convert_encoding($html, 'UTF-8', SABAI_CHARSET)), SABAI_CHARSET, 'UTF-8');
            $this->set('body_html', preg_replace('/&amp\;([a-zA-Z0-9]{2,8};)/', '&\\1', $html));
        } else {
            $this->set('body_html', $purifier->purify($this->get('body_html')));
        }
    }
}

class Xigg_Model_CommentRepository extends Xigg_Model_CommentRepositoryBase
{
    function Xigg_Model_CommentRepository(&$model)
    {
        parent::Xigg_Model_CommentRepositoryBase($model);
    }
}