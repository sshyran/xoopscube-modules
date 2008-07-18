<?php

if( empty( $_POST['body_editor'] ) ) {
	$body_editor = @$xoopsModuleConfig['body_editor'] ;
} else {
	$body_editor = $_POST['body_editor'] ;
}

if( $body_editor == 'common_fckeditor' ) {

	// FCKeditor in common/fckeditor/
	$pico_wysiwyg_header = '
		<script type="text/javascript" src="'.XOOPS_URL.'/common/fckeditor/fckeditor.js"></script>
		<script type="text/javascript"><!--
			function fckeditor_exec() {
				var oFCKeditor = new FCKeditor( "'.$pico_wysiwygs['name'].'" , "100%" , "500" , "Default" );
				
				oFCKeditor.BasePath = "'.XOOPS_URL.'/common/fckeditor/";
				
				oFCKeditor.ReplaceTextarea();
			}
		// --></script>
	' ;
	$pico_wysiwyg_body = '<textarea id="'.$pico_wysiwygs['name'].'" name="'.$pico_wysiwygs['name'].'">'.htmlspecialchars($pico_wysiwygs['value'],ENT_QUOTES).'</textarea><script>fckeditor_exec();</script>' ;

} else if( $body_editor == 'common_spaw' && file_exists( XOOPS_ROOT_PATH.'/common/spaw/spaw_control.class.php' ) ) {

	// older spaw in common/spaw/
	include XOOPS_ROOT_PATH.'/common/spaw/spaw_control.class.php' ;
	ob_start() ;
	$sw = new SPAW_Wysiwyg( $pico_wysiwygs['name'] , $pico_wysiwygs['value'] ) ;
	$sw->show() ;
	$pico_wysiwyg_body = ob_get_contents() ;
	$pico_wysiwyg_header = '' ;
	ob_end_clean() ;

} else {

	// normal (xoopsdhtmltarea)
	$pico_wysiwyg_body = '' ;
	$pico_wysiwyg_header = '' ;

}

?>