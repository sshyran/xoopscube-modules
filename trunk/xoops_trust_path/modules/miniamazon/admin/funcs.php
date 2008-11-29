<?php

function display_edit_form( $cat_array , $form_title , $action )
{
	global $cattree ; 
	$myts =& MyTextSanitizer::getInstance();

	extract( $cat_array ) ;

	// Beggining of XoopsForm
	$form = new XoopsThemeForm( $form_title , 'MainForm' , '' ) ;

	// Hidden
	$form->addElement( new XoopsFormHidden( 'action' , $action ) ) ;
	$form->addElement( new XoopsFormHidden( 'cid' , $cid ) ) ;

	// Title
	$form->addElement( new XoopsFormText( _MD_A_MINIAMAZON_CAT_TH_TITLE , 'ctitle' , 30 , 50 , $myts->htmlSpecialChars( $ctitle ) ) , true ) ;

	//表示順
	$form->addElement( new XoopsFormText( _MD_A_MINIAMAZON_CAT_TH_ORDER , 'corder' , 30 , 50 , $corder ) , true ) ;

	// Parent Category
	ob_start() ;
	$cattree->makeMySelBox( "ctitle" , "ctitle" , $pid , 1 , 'pid' ) ;
	$cat_selbox = ob_get_contents() ;
	ob_end_clean() ;
	$form->addElement( new XoopsFormLabel( _MD_A_MINIAMAZON_CAT_TH_PARENT , $cat_selbox ) ) ;

	// Buttons
	$button_tray = new XoopsFormElementTray( '' , '&nbsp;' ) ;
	$button_tray->addElement( new XoopsFormButton( '' , 'submit' , _SUBMIT, 'submit' ) ) ;
	$button_tray->addElement( new XoopsFormButton( '' , 'reset' , _CANCEL, 'reset' ) ) ;
	$form->addElement( $button_tray ) ;

	// Ticket
	$GLOBALS['xoopsGTicket']->addTicketXoopsFormElement( $form , __LINE__ ) ;

	// End of XoopsForm
	$form->display();
}


function mysql_get_sql_set( $cols )
{
	$myts =& MyTextSanitizer::getInstance();

	$ret = "" ;

	foreach( $cols as $col => $types ) {

		list( $field , $lang , $essential ) = explode( ':' , $types ) ;

		// Undefined col is regarded as ''
		$data = empty( $_POST[ $col ] ) ? '' : $myts->stripSlashesGPC( $_POST[ $col ] ) ;

		// Check if essential 
		if( $essential && ! $data ) {
			die( sprintf( "Error: %s is not set" , $col ) ) ;
		}

		// Language
		switch( $lang ) {
			case 'N' :	// Number (remove ,)
				$data = str_replace( "," , "" , $data ) ;
				break ;
			case 'J' :	// Japanese
				$data = mb_convert_kana( $data , "KV" ) ;
				break ;
			case 'E' :	// English
				// $data = mb_convert_kana( $data , "as" ) ;
				$data = $data ;
				break ;
		}

		// DataType
		switch( $field ) {
			case 'A' :	// textarea
				$data = addslashes( $data ) ;
				$ret .= "$col='$data'," ;
				break ;
			case 'I' :	// integer
				$data = intval( $data ) ;
				$ret .= "$col='$data'," ;
				break ;
			case 'F' :	// float
				$data = doubleval( $data ) ;
				$ret .= "$col='$data'," ;
				break ;
			default :	// varchar (default)
				if( $field < 1 ) $field = 255 ;
				if( function_exists( 'mb_strcut' ) ) $data = mb_strcut( $data , 0 , $field ) ;
				$data = addslashes( $data ) ;
				$ret .= "$col='$data'," ;
		}
	}

	// Remove ',' in the tale of sql
	$ret = substr( $ret , 0 , -1 ) ;

	return $ret ;
}

//カテゴリ削除時にカテゴリ以下のアイテムを削除
function delete_items( $whr )
{
	global $xoopsDB , $table_items ;//,$mid ;

	$prs = $xoopsDB->query("SELECT lid FROM $table_items WHERE $whr" ) ;
	while( list( $lid ) = $xoopsDB->fetchRow( $prs ) ) {
		$xoopsDB->query( "DELETE FROM $table_items WHERE lid=$lid" ) or die( "DB error: DELETE photo table." ) ;
	}
}

?>