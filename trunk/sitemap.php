<?php

/******* CONFIGURATION (edit them as you like) *************/

define( 'D3PIPES_SITEMAP_DIRNAME' , 'd3pipes' ) ; // set dirname (string)


/******* end of CONFIGURATION *************/

$pipe_id = intval( @$_GET['pipe_id'] ) ;

if( ! empty( $_SERVER['REQUEST_URI'] ) ) {
	$_SERVER['REQUEST_URI'] = str_replace( basename( __FILE__ ) , 'modules/'.D3PIPES_SITEMAP_DIRNAME.'/index.php?page=xml&style=sitemap&pipe_id='.$pipe_id , $_SERVER['REQUEST_URI'] ) ;
} else {
	$_SERVER['REQUEST_URI'] = 'modules/'.D3PIPES_SITEMAP_DIRNAME.'/index.php?page=xml&style=sitemap&pipe_id='.$pipe_id ;
}
$_SERVER['PHP_SELF'] = $_SERVER['REQUEST_URI'] ;
$_GET = array( 'page' => 'xml' , 'style' => 'sitemap' , 'pipe_id' => $pipe_id ) ;
chdir( './modules/'.D3PIPES_SITEMAP_DIRNAME.'/' ) ;
require dirname(__FILE__).'/modules/'.D3PIPES_SITEMAP_DIRNAME.'/index.php' ;

?>