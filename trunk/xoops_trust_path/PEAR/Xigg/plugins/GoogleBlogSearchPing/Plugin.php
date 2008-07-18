<?php
class Xigg_Plugin_GoogleBlogSearchPing extends Xigg_Plugin
{
    function onSubmitNodeSuccess(&$node, $isEdit, &$context)
    {
        if ($isEdit) {
            return;
        }
        require_once 'XML/RPC.php';
        $params = array(new XML_RPC_Value(mb_convert_encoding($this->_params['blogName'],
                                                              'UTF-8',
                                                              array(SABAI_CHARSET, 'UTF-8'))),
                        new XML_RPC_Value($this->_params['blogURL']),
                        new XML_RPC_Value($context->request->createUri(array('base' => '/node/' . $node->getId()))),
                        new XML_RPC_Value($context->request->createUri(array('base' => '/rss'))));
        $msg =& new XML_RPC_Message('weblogUpdates.extendedPing', $params);
        $client =& new XML_RPC_Client('/ping/RPC2', 'blogsearch.google.co.jp');
        if (!$res = $client->send($msg)) {
            echo 'Communication error: ' . $client->errstr;
        } elseif ($res->faultCode()) {
            echo 'Fault Code: ' . $res->faultCode() . "\n";
            echo 'Fault Reason: ' . $res->faultString() . "\n";
        }
    }
}