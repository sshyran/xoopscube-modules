<?php

require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
require_once dirname(dirname(__FILE__)).'/include/common_functions.php' ;
require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;
require_once dirname(dirname(__FILE__)).'/include/import_functions.php' ;
require_once dirname(dirname(__FILE__)).'/include/history_functions.php' ;
require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;
$myts =& MyTextSanitizer::getInstance() ;
$db =& Database::getInstance() ;


//
// transaction stage
//

// extras output
if( ! empty( $_POST['extras_output'] ) && is_array( @$_POST['action_selects'] ) ) {
	$extra_rows = array() ;
	$columns = array( 'id' => 0 , 'content_id' => 0 , 'type' => '' , 'created' => '' , 'modified' => '' ) ;
	foreach( $_POST['action_selects'] as $extra_id => $value ) {
		if( empty( $value ) ) continue ;
		$extra_id = intval( $extra_id ) ;
		$extra_row = $db->fetchArray( $db->query( "SELECT ce.*,o.vpath,o.subject AS content_subject FROM ".$db->prefix($mydirname."_content_extras")." ce LEFT JOIN ".$db->prefix($mydirname."_contents")." o ON o.content_id=ce.content_id WHERE content_extra_id=$extra_id" ) ) ;
		$data = unserialize( $extra_row['data'] ) ;
		if( ! is_array( $data ) ) $data = array( $extra_row['data'] ) ;
		$extra_rows[] = array(
			'id' => intval( $extra_row['content_extra_id'] ) ,
			'content_id' => intval( $extra_row['content_id'] ) ,
			'type' => $extra_row['extra_type'] ,
			'created' => formatTimestamp( $extra_row['created_time'] ) ,
			'modified' => formatTimestamp( $extra_row['modified_time'] ) ,
		) + $data ;
		$columns += $data ;
	}

	$out = '' ;
	foreach( array_keys( $columns ) as $col ) {
		$out .= '"'.str_replace('"','""',$col).'",' ;
	}
	$out = substr( $out , 0 , -1 ) . "\n" ;

	if( function_exists( 'easiestml' ) ) {
		$out = easiestml( $out ) ;
	}

	foreach( $extra_rows as $extra_row ) {
		foreach( array_keys( $columns ) as $col ) {
			$val = pico_admin_make_summary4extras( @$extra_row[$col] ) ;
			$out .= '"' . str_replace( '"' , '""' , $val ) . '",' ;
		}
		$out = substr( $out , 0 , -1 ) . "\n" ;
	}

	if( function_exists( 'mb_convert_encoding' ) ) {
		$out = mb_convert_encoding( $out , _MD_PICO_CSVENCODING , _CHARSET ) ;
	}

	header ('Content-Type: application/force-download');
	header ('Content-Disposition: attachment; filename='.$mydirname.'_extras_'.date('Ymd').'.csv');
	header ('Content-Description: File Transfer');
	echo $out ;
	exit ;
}

// extras delete
if( ! empty( $_POST['extras_delete'] ) && ! empty( $_POST['action_selects'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'pico_admin' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	foreach( $_POST['action_selects'] as $extra_id => $value ) {
		if( empty( $value ) ) continue ;
		$extra_id = intval( $extra_id ) ;
		$db->query( "DELETE FROM ".$db->prefix($mydirname."_content_extras")." WHERE content_extra_id=$extra_id" ) ;
	}

	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=extras" , 3 , _MD_A_PICO_MSG_DELETED ) ;
	exit ;
}


// extras delete

//
// form stage
//

$extra_id = intval( @$_GET['extra_id'] ) ;
$whr_extra_id = $extra_id ? "ce.content_extra_id=$extra_id" : '1' ;

// fetch extras
$ers = $db->query( "SELECT ce.*,o.vpath,o.subject AS content_subject FROM ".$db->prefix($mydirname."_content_extras")." ce LEFT JOIN ".$db->prefix($mydirname."_contents")." o ON o.content_id=ce.content_id WHERE $whr_extra_id ORDER BY ce.created_time DESC" ) ;

$extras4assign = array() ;
while( $extra_row = $db->fetchArray( $ers ) ) {
	$data = unserialize( $extra_row['data'] ) ;
	if( empty( $data ) ) $data = $extra_row['data'] ;
	$extra4assign = array(
		'id' => intval( $extra_row['content_extra_id'] ) ,
		'link' => pico_common_make_content_link4html( $xoopsModuleConfig , $extra_row ) ,
		'extra_type_formatted' => str_replace( '::' , '<br />' , htmlspecialchars( $extra_row['extra_type'] , ENT_QUOTES ) ) ,
		'created_time_formatted' => formatTimestamp( $extra_row['created_time'] ) ,
		'data' => $data ,
		'data_summary_short_raw' => xoops_substr( pico_admin_make_summary4extras( $data ) , 0 , 100 ) ,
		'data_summary_raw' => pico_admin_make_summary4extras( $data ) ,
	) ;
	$extras4assign[] = $extra4assign + $extra_row ;
}


//
// display stage
//

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_name' => $xoopsModule->getVar('name') ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$xoopsModuleConfig['images_dir'] ,
	'mod_config' => $xoopsModuleConfig ,
	'extras' => $extras4assign ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'pico_admin') ,
) ) ;
if( $extra_id ) {
	$tpl->display( 'db:'.$mydirname.'_admin_extras_detail.html' ) ;
} else {
	$tpl->display( 'db:'.$mydirname.'_admin_extras.html' ) ;
}
xoops_cp_footer();


//
// local function stage
//

function pico_admin_make_summary4extras( $data )
{
	$ret = '' ;
	if( is_array( $data ) ) {
		if( is_string( @$data[0] ) || empty( $data ) ) {
			// linear
			$ret = implode( ',' , $data ) ;
		} else {
			foreach( $data as $key => $val ) {
				$ret .= pico_admin_easiestml( $key ) . ':' . pico_admin_make_summary4extras( $val ) . "\n" ;
			}
		}
	} else {
		$ret = $data ;
	}
	
	return $ret ;
}


function pico_admin_easiestml( $s )
{
	if( function_exists( 'easiestml' ) ) {
		return easiestml( $s ) ;
	} else {
		return $s ;
	}
}


?>