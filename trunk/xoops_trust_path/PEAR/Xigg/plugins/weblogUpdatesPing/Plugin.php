<?php
class Xigg_Plugin_weblogUpdatesPing extends Xigg_Plugin
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
                        new XML_RPC_Value($context->request->createUri(array('base' => '/node/' . $node->getId()))));
        $msg =& new XML_RPC_Message('weblogUpdates.ping', $params);
        foreach ((array)$this->_params['servers'] as $server) {
            if (!is_array($server)) {
                $server = parse_url($server);
            }
            $client =& new XML_RPC_Client(@$server['path'], $server['scheme'] . '://' .  $server['host'], @$server['port']);
            if (!$res = $client->send($msg)) {
                trigger_error('XML-RPC error: ' . $client->errstr, E_USER_NOTICE);
                continue;
            }
            if ($res->faultCode()) {
                trigger_error('XML-RPC error: ' . $res->faultString() . '(' . $res->faultCode() . ')', E_USER_NOTICE);
                continue;
            }
        }
    }
}