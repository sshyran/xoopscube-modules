<?php

$dirname = basename(dirname(dirname(dirname(__FILE__))));
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);

include_once 'common.php';

$block_consts = array(
    '_SHOW_NUM' => 'ɽ�����',
    '_ADD_DATE' => '��Ͽ����',
    '_UNAME'    => '��Ͽ�桼��̾',
    '_FILE'     => '�ե�����'
);

foreach ($block_consts as $key => $value) {
    if (!defined('_MB_' . $affix . $key)) {
        define('_MB_' . $affix . $key, $value);
    }
}

?>