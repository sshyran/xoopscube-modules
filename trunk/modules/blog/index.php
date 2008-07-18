<?php
/**
 * @version $Id: index.php 40 2007-07-21 06:21:54Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require '../../mainfile.php' ;
if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH in mainfile.php' ) ;

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
$mydirurl = XOOPS_URL.'/modules/'.$mydirname;

require $mydirpath.'/mytrustdirname.php' ; // set $mytrustdirname

if( @$_GET['mode'] == 'admin' ) {
    require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/admin.php' ;
} else {
    require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/main.php' ;
}

?>