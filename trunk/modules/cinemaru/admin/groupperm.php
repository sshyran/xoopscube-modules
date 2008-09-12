<?php

require_once( '../../../include/cp_header.php' ) ;
require_once( 'mygrouppermform.php' ) ;

// for "Duplicatable"
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;


if( ! empty( $_POST['submit'] ) ) {

		// Ticket Check
		if ( ! $xoopsGTicket->check( true , 'myblocksadmin' ) ) {
				redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
		}

		include( "mygroupperm.php" ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/groupperm.php" , 1 , _AM_CINEMARU_DBUPDATED );
		exit ;
}

require_once('../constants.php');

$item_list = array(
		constant($constpref.'_GROUPPERM_INSERTABLE') => _AM_GPERM_G_INSERTABLE ,
		constant($constpref.'_GROUPPERM_SUPERINSERT') => _AM_GPERM_G_SUPERINSERT ,
		constant($constpref.'_GROUPPERM_EDITABLE') => _AM_GPERM_G_EDITABLE ,
		constant($constpref.'_GROUPPERM_SUPEREDIT') => _AM_GPERM_G_SUPEREDIT ,
		constant($constpref.'_GROUPPERM_TOUCHOTHERS') => _AM_GPERM_G_TOUCHOTHERS,
		constant($constpref.'_GROUPPERM_TAGINSERTABLE') => _AM_GPERM_G_TAGINSERTABLE,
		constant($constpref.'_GROUPPERM_TAGDELETABLE') => _AM_GPERM_G_TAGDELETABLE,
		constant($constpref.'_GROUPPERM_VALID') => _AM_GPERM_G_VALID,
		constant($constpref.'_GROUPPERM_DELCOMMENT') => _AM_GPERM_G_DELCOMMENT,
		constant($constpref.'_GROUPPERM_INSERTCOMMENT') => _AM_GPERM_G_INSERTCOMMENT,
		constant($constpref.'_GROUPPERM_SHOWCOMMENT') => _AM_GPERM_G_SHOWCOMMENT,
		constant($constpref.'_GROUPPERM_REPORT') => _AM_GPERM_G_REPORT,
		constant($constpref.'_GROUPPERM_REPORT_LIST') => _AM_GPERM_G_REPORT_LIST,
		   
		) ;

$form = new MyXoopsGroupPermForm( _AM_GROUPPERM , $xoopsModule->mid() , 'cinemaru_global' , _AM_GROUPPERMDESC ) ;
foreach( $item_list as $item_id => $item_name) {
		$form->addItem( $item_id , $item_name ) ;
}

xoops_cp_header();
include( './mymenu.php' ) ;
echo $form->render() ;
xoops_cp_footer();

?>
