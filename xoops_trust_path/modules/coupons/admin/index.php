<?php

//altsys preferences
if( file_exists( XOOPS_TRUST_PATH .'/libs/altsys/mypreferences.php' ) ) {
	include XOOPS_TRUST_PATH .'/libs/altsys/mypreferences.php' ;
}else{
	die( 'install the latest altsys' ) ;
}
exit();

?>