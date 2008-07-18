<?php
class Xigg_Plugin_Akismet extends Xigg_Plugin
{
    function onSubmitComment(&$comment, $isReply, &$context)
    {
        $identity =& $context->user->getIdentity();
        $content = array('author'       => $identity->getName(),
                         'body'         => $comment->get('body'),
	                     'permalink'    => $context->request->createUri(array('base' => '/node/' . $comment->getVar('node_id'))));
        if ($this->_isSpam($context, $content)) {
            // prevent comment from being added to the database
            $comment->markRemoved();
	    }
    }

    function onSubmitTrackback(&$trackback, &$context)
    {
        $content = array('author'       => $trackback->get('blog_name'),
        				 'website'      => $trackback->get('url'),
                         'body'         => $trackback->get('excerpt'),
	                     'permalink'    => $context->request->createUri(array('base' => '/node/' . $trackback->getVar('node_id'))));
        if ($this->_isSpam($context, $content)) {
            // prevent comment from being added to the database
            $trackback->markRemoved();
	    }
    }

    function _isSpam(&$context, $content)
    {
    	require_once dirname(__FILE__) . '/akismet.class.php';
        $akismet =& new Akismet(dirname($context->request->getScriptUri()), $this->_params['apikey'], $content);
        if ($akismet->errorsExist()) {
            if ($akismet->isError('AKISMET_INVALID_KEY')) {
            } elseif ($akismet->isError('AKISMET_RESPONSE_FAILED')) {
	        } elseif ($akismet->isError('AKISMET_SERVER_NOT_FOUND')) {
            } else {
            }
            return true;
        }
        return $akismet->isSpam();
    }
}