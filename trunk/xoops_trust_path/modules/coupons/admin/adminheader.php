<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

require_once dirname(dirname(__FILE__))."/class/gtickets.php";
require_once dirname(dirname(__FILE__))."/include/functions.php" ;

$mydirurl = XOOPS_URL . "/modules/$mydirname" ;


//DB table
$table_coupons    = $xoopsDB->prefix( $mydirname."_coupons" ) ;
$table_cat      = $xoopsDB->prefix( $mydirname."_cat" ) ;
$table_text     = $xoopsDB->prefix( $mydirname."_text" ) ;

//category instance
require_once dirname(dirname(__FILE__))."/class/categories.class.php" ;
//$categories =& couponsCategoriesClass::getInstance( $table_cat ) ;
$categories = new couponsCategoriesClass( $table_cat ) ;


//coupons instance
require_once dirname(dirname(__FILE__))."/class/coupons.class.php" ;
$coupons = new Coupons( $mydirname ) ;
$isadmin = $xoopsUser->isAdmin( $xoopsModule->getVar('mid') ) ;
$coupons->setPerm( $isadmin , $isadmin , $isadmin , $isadmin , $isadmin , $isadmin , $xoopsUser->uid() , $isadmin ) ;
//$addfield = $xoopsModuleConfig['addfield'] ? true : false ;
//$coupons->setAddField( $addfield ) ;


$constprefMI = '_MI_' . strtoupper( $mydirname ) ;

$myts =& MyTextSanitizer::getInstance();

?>