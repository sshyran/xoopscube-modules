<?php

// get menu 
$sitemapmenu = sitemapMakeMenu( $mydirname , false , true );


//width % per one column
//$column_w = intval( 100 / $xoopsModuleConfig['columns'] ) -3 ;


//hiera
/*
$maxhiera = max($sitemapmenu[1]);	
$hiera = array();
for( $i=0; $i<=$maxhiera; $i++ ){
	$indent = ($i==0) ? 37 : 25 ; 	//for text-indent
	$hiera[$i] = $i * 12 + $indent;	//margin-left
}
*/


//-------------------------------------------------
$xoopsOption["template_main"] = $mydirname ."_sitemap.html" ;
include_once XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign( 'list' , $sitemapmenu[0] );	
$xoopsTpl->assign( 'tm_sitemap_col' , intval($xoopsModuleConfig['columns']) );
//$xoopsTpl->assign( 'tm_sitemap_col_p' , $column_w );
$xoopsTpl->assign( 'popup' , constant($constpref."_POPUPWIN") );
$xoopsTpl->assign( 'selfurl' , XOOPS_URL . "/modules/$mydirname/" );
$xoopsTpl->assign( 'hiera' , $sitemapmenu[1] );
include_once XOOPS_ROOT_PATH."/footer.php";

?>
