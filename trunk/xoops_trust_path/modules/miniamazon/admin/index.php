<?php
//$mytrustdirname = basename( dirname(dirname( __FILE__ )) ) ;
//$mytrustdirpath = dirname(dirname( __FILE__ )) ;


include 'adminheader.php';




define( 'OMITMYMENU' , 1);
include 'mymenu.php';

//��ʐݒ�
header( 'Location:'. $adminmenu[count($adminmenu)-1]['link'] );

?>