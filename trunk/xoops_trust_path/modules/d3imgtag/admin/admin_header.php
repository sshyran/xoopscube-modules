<?php
require_once XOOPS_ROOT_PATH.'/include/cp_header.php';
include dirname(dirname(__FILE__)).'/include/read_configs.php';
include_once dirname(dirname(__FILE__)).'/include/functions.php';
include_once dirname(dirname(__FILE__)).'/include/gtickets.php';

global $xoopsDB ;
if(isset($_GET['lid'])) {
	$lid = intval($_GET['lid' ]);
	$result = $xoopsDB->query("SELECT submitter FROM $table_photos where lid=$lid",0);
	list($submitter) = $xoopsDB->fetchRow($result);
} else {
	$submitter = $xoopsUser ;
}

if(! $isadmin) {
	redirect_header(XOOPS_URL."/" , 3 , _NOPERM);
	exit;
}

?>