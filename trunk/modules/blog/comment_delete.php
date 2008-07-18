<?php
/**
 * @version $Id: comment_delete.php 40 2007-07-21 06:21:54Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require '../../mainfile.php' ;
if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH in mainfile.php' ) ;

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
require $mydirpath.'/mytrustdirname.php' ; // set $mytrustdirname

$_GET['page'] = basename( __FILE__ , '.php');
require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/main.php' ;

?>