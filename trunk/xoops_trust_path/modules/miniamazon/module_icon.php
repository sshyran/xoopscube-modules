<?php

include_once dirname(__FILE__) . '/include/version.php';


// images/module_icon_custom.png がある場合はそれを表示する
if( file_exists( $mydirpath.'/images/module_icon_custom.png' ) ) {
	$use_custom_icon = true ;
	$icon_fullpath = $mydirpath.'/images/module_icon_custom.png' ;
} else {	//ない場合は白紙アイコンに書き込み表示する
	$use_custom_icon = false ;
	$icon_fullpath = dirname(__FILE__) .'/images/module_icon.png' ;
}



header("Content-type: image/png");


if( ! $use_custom_icon && function_exists( 'imagecreatefrompng' ) && function_exists( 'imagecolorallocate' ) && function_exists( 'imagestring' ) && function_exists( 'imagepng' ) ) {

	$im = imagecreatefrompng( $icon_fullpath ) ;
	
	//dirname
	$color = imagecolorallocate( $im , 0 , 0 , 0 ) ; // black
	$px = ( 92 - 6 * strlen( $mydirname ) ) / 2 ;
	imagestring( $im ,2 , $px , 34 , $mydirname , $color ) ;
	
	//version
	$color = imagecolorallocate( $im , 180 , 100 , 0 ) ; 
	$px = ( 48 - 4 * strlen( $miniamazon_version ) ) / 2 ;
	imagestring( $im , 1 , 48+$px , 25 , $miniamazon_version , $color ) ;

	imagepng( $im ) ;
	imagedestroy( $im ) ;

} else {
	readfile( $icon_fullpath ) ;
}

?>