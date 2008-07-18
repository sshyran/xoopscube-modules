<?php
class Xigg_Main_PostTrackback extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$context->request->isPost()) {
            $this->_sendError(_('Invalid method'));
        }
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->get('allow_trackbacks') || !$node->isReadable($context->user)) {
            $this->_sendError(_('Invalid node'));
        }
        $tb =& $node->createTrackback();
        if ((!$url = $context->request->getAsStr('url')) || !preg_match('#^https?://[\-\w\.]+\.+\w+(:\d+)?(/([\w/_\.\-\+\?&=%\^~,]*)?)?$#i', $url)) {
            $this->_sendError(_('Invalid URL'));
        }
        $excerpt = Sabai_I18N::strcutMore(mb_convert_encoding($context->request->getAsStr('excerpt', ''), SABAI_CHARSET, array(SABAI_CHARSET, 'UTF-8')), 500);
        $title = mb_convert_encoding($context->request->getAsStr('title', $url), SABAI_CHARSET, array(SABAI_CHARSET, 'UTF-8'));
        $blog_name = mb_convert_encoding($context->request->getAsStr('blog_name', ''), SABAI_CHARSET, array(SABAI_CHARSET, 'UTF-8'));
        $tb->set('url', $url);
        $tb->set('title', $title);
        $tb->set('blog_name', $blog_name);
        $tb->set('excerpt', $excerpt);
        $tb->markNew();
        $plugins_manager =& $context->application->locator->getService('PluginManager');
        $plugins_manager->dispatch('SubmitTrackback', array(&$tb));
        if (!$tb->commit()) {
            $this->_sendError(_('Failed posting trackback'));
        } else {
            $this->_sendSuccess();
        }
    }

    function _sendError($errorMsg)
    {
        $payload = sprintf('<?xml version="1.0" encoding="utf-8"?><response><error>1</error><message>%s</message></response>',
                           h(mb_convert_encoding($errorMsg, 'UTF-8', SABAI_CHARSET)));
        $this->_sendPayload($payload);
    }

    function _sendSuccess()
    {
        $this->_sendPayload('<?xml version="1.0" encoding="utf-8"?><response><error>0</error></response>');
    }

    function _sendPayload($payload)
    {
        header('Content-type: application/xml; charset=utf-8');
        header('Content-Length: ' . strlen($payload));
        echo $payload;
        exit;
    }
}