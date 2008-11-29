<?php

$icon_fullpath = dirname(__FILE__) .'/icon.png' ;

header("Content-type: image/png");


if( function_exists( 'imagecreatefrompng' ) && function_exists( 'imagecolorallocate' ) && function_exists( 'imagestring' ) && function_exists( 'imagepng' ) ) {

	$im = imagecreatefrompng( $icon_fullpath ) ;
	
	//dirname
	$color = imagecolorallocate( $im , 0 , 0 , 0 ) ; // black
	$px = ( 92 - 6 * strlen( $mydirname ) ) / 2 ;
	imagestring( $im ,2 , $px , 35 , $mydirname , $color ) ;

	imagepng( $im ) ;
	imagedestroy( $im ) ;

} else {
	readfile( $icon_fullpath ) ;
}

?>