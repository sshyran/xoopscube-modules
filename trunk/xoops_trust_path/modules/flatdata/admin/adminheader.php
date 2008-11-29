<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

require_once dirname(dirname(__FILE__))."/class/gtickets.php";
require_once dirname(dirname(__FILE__))."/include/functions.php" ;

$mydirurl = XOOPS_URL . "/modules/$mydirname" ;


//field instance
require_once dirname(dirname(__FILE__))."/class/fields.class.php" ;
$fields = new flatdataFieldsClass( $mydirname ) ;


$constprefMI = '_MI_' . strtoupper( $mydirname ) ;

//$myts =& MyTextSanitizer::getInstance();

?>