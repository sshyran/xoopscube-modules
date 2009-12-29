<?php
/**
 * @version $Id: tb.php 281 2008-02-23 09:49:31Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// for people choicing a pm method. 
@$_SERVER['HTTP_REFERER'] = 'http://example.com/';

require '../../mainfile.php' ;
if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH in mainfile.php' ) ;

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
require $mydirpath.'/mytrustdirname.php' ; // set $mytrustdirname

$_GET['page'] = basename( __FILE__ , '.php');
require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/main.php' ;

?>