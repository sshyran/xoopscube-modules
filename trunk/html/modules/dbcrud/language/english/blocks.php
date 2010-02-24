<?php

$dirname = basename(dirname(dirname(dirname(__FILE__))));
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);

include_once 'common.php';

$block_consts = array(
    '_SHOW_NUM' => 'Number display',
    '_ADD_DATE' => 'Registered',
    '_UNAME' => 'User name registration',
    '_FILE' => 'File'
);

foreach ($block_consts as $key => $value) {
    if (!defined('_MB_' . $affix . $key)) {
        define('_MB_' . $affix . $key, $value);
    }
}

?>