<?php
//include_once dirname(__FILE__) . '/include/version.php';


// images/module_icon_custom.png がある場合はそれを表示する
if( file_exists( $mydirpath.'/images/module_icon_custom.png' ) ) {
	$use_custom_icon = true ;
	$icon_fullpath = $mydirpath.'/images/module_icon_custom.png' ;
} else {	//ない場合は白紙アイコンに書き込み表示する
	$use_custom_icon = false ;
	$icon_fullpath = dirname(__FILE__) .'/images/module_icon.png' ;
}


//------------------------------------------
header("Content-type: image/png");


if( ! $use_custom_icon && function_exists( 'imagecreatefrompng' ) && function_exists( 'imagecolorallocate' ) && function_exists( 'imagestring' ) && function_exists( 'imagepng' ) ) {

	$im = imagecreatefrompng( $icon_fullpath ) ;
	
	//module root dirname
	$color = imagecolorallocate( $im , 0 , 0 , 0 ) ; // black
	$px = ( 92 - 6 * strlen( $mydirname ) ) / 2 ;
	imagestring( $im ,2 , $px , 35 , $mydirname , $color ) ;

	imagepng( $im ) ;
	imagedestroy( $im ) ;

} else {
	readfile( $icon_fullpath ) ;
}

?>