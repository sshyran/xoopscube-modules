<?php
// === option begin ===
$category_option = '';
//�\������J�e�S���[�ԍ����J���}(,)�ŋ�؂��ċL���B�󗓂Ȃ�S�J�e�S���[�\���B
// --- option end ---

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' ) ;

$mydirname = basename( dirname(  dirname( __FILE__ ) ) ) ;
$mydirpath = dirname( dirname( __FILE__ ) ) ;
require $mydirpath.'/mytrustdirname.php' ; // set $mytrustdirname

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/whatsnew.inc.php' ;

?>