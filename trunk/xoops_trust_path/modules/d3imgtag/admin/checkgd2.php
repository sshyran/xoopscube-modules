<?php
include("admin_header.php");

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';
d3imgtag_opentable() ;

restore_error_handler() ;
error_reporting( E_ALL ) ;

if( imagecreatetruecolor(200,200) ) {
	echo _AM_D3IMGTAG_MB_GD2SUCCESS ;
}

d3imgtag_closetable() ;
xoops_cp_footer();

?>