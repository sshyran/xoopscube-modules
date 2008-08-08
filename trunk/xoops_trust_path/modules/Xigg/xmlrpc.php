<?php
require dirname(__FILE__) . '/common.php';
require 'Xigg/XMLRPCServer.php';
$server =& new Xigg_XMLRPCServer($xigg, 'xigg_xoops_xmlrpc_login_user');
$server->service();

function xigg_xoops_xmlrpc_login_user($username, $password)
{
    global $xoopsModule;
    $user =& SabaiXOOPS::getUserByLogin($username, $password, $xoopsModule);
    return $user;
}