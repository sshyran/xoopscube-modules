<?php
if( !isset($mode) ){
  include_once '../../../mainfile.php' ;
}



$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
$mydirpath = dirname( dirname( __FILE__ ) ) ;
require $mydirpath.'/mytrustdirname.php' ;



if( @$mode=='form' || (!empty($_POST['submit'])&&!empty($_POST['embed_dir'])&&!empty($_POST['item_field'])&&!empty($_POST['item_id'])&&!empty($_POST['filequery'])) ){
  require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/embed_form.php' ;
}elseif( @$mode=='display' ){
  require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/embed_display.php' ;
}
?>