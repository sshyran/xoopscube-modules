<?php
/**
 * @version $Id: pical.inc.php 227 2007-11-18 02:59:26Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' ) ;

$mydirname = basename(dirname(dirname(__FILE__)));
$mydirpath = dirname(dirname(__FILE__));
require $mydirpath.'/mytrustdirname.php';

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/pical.inc.php' ;

?>