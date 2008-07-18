<?php
class Xigg_Plugin_ServicesTrackback extends Xigg_Plugin
{
    function onSubmitTrackback(&$trackback, &$context)
    {
        require_once 'Services/Trackback.php';
        $data = array('id'            => $trackback->getTempId(),
                      'host'          => $_SERVER['REMOTE_ADDR'],
                      'title'         => $trackback->getLabel(),
                      'blog_name'     => $trackback->get('blog_name'),
                      'url'           => $trackback->get('url'),
                      'excerpt'       => $trackback->get('excerpt'),
                      'trackback_url' => $context->request->createUri(array('base' => '/node/' . $trackback->getVar('node_id'))));
        $tb =& Services_Trackback::create();
        $tb->receive($data);
        if (!empty($this->_params['Wordlist'])) {
            $res = $tb->createSpamCheck('Wordlist', array('sources' => explode('|', $this->_params['Wordlist_words'])));
            if (PEAR::isError($res)) {
            }
        }
        if (!empty($this->_params['Regex'])) {
            $res = $tb->createSpamCheck('Regex', array('sources' => explode('|', $this->_params['Regex_formats'])));
            if (PEAR::isError($res)) {
            }
        }
        if (!empty($this->_params['DNSBL'])) {
            $res = $tb->createSpamCheck('DNSBL', array('sources' => (array)$this->_params['DNSBL_hosts']));
            if (PEAR::isError($res)) {
            }
        }
        if (!empty($this->_params['SURBL'])) {
            $res = $tb->createSpamCheck('SURBL', array('sources' => (array)$this->_params['SURBL_hosts']));
            if (PEAR::isError($res)) {
            }
        }
        if ($tb->checkSpam()) {
            // spam
            $trackback->markRemoved();
        }
    }
}