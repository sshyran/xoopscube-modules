<?php

/**
 * @author $Author$ 
 * @version $Id$
 *
 */

function display_edit_form( $cx_array , $form_title , $action )
{
	$myts =& MyTextSanitizer::getInstance();

	extract( $cx_array ) ;

	// Beggining of XoopsForm
	$form = new XoopsThemeForm( $form_title , 'MainForm2' , '' ) ;

	// Hidden
	$form->addElement( new XoopsFormHidden( 'action' , $action ) ) ;
	$form->addElement( new XoopsFormHidden( 'cxid' , $cxid ) ) ;

	// cxTitle
	$form->addElement( new XoopsFormText( _AM_XCSEARCH_CXTITLE , 'cxtitle' , 50 , 128 , $myts->htmlSpecialChars( $cxtitle ) ) , true ) ;
	// cxValue
	$form->addElement( new XoopsFormText( _AM_XCSEARCH_CXVALUE , 'cxvalue' , 50 , 40 , $myts->htmlSpecialChars( $cxvalue ) ) , true ) ;
	// cxOrder
	$form->addElement( new XoopsFormText( _AM_XCSEARCH_CXORDER , 'cxorder' , 30 , 10 , intval( $cxorder ) ) , true ) ;

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

?>