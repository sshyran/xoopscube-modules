<?php
require_once dirname(dirname( __FILE__ ))."/include/functions.php";

// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) return ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$fd_trust_dirname = basename(dirname(dirname(__FILE__))) ;
$langman->read( 'main.php' , $cp_dir , $fd_trust_dirname ) ;



//-----------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------
function flatdata_embed_display( $fd_dir , $embed_dir , $item_field , $item_id , $params )
{
	global $xoopsUser , $xoopsConfig ;// $xoopsDB ,

	$mydirname = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $fd_dir ) ;
	require dirname(dirname( __FILE__ ))."/main/header.php";
	//----------------------------------------------------------------------

	// check the flatdata exists and isactive
	if( ! is_object( $xoopsModule ) || ! $xoopsModule->getVar('isactive') ) {
		return ;
	}

	// check permission of "module_read" of flatdata
	$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
	$groups = is_object( $xoopsUser ) ? $xoopsUser->getGroups() : array( XOOPS_GROUP_ANONYMOUS ) ;
	if( ! $moduleperm_handler->checkRight( 'module_read' , $xoopsModule->getVar('mid') , $groups ) ) {
		return ;
	}

	//permission check
	if( !$isadmin ){
		if( in_array($embed_dir,$sp_embed_dir) ){
			if( $embed_dispperm==1 ){
				if( $item_id!=$uid ) return ;
			}
		}
	}

	//----------------------------------------------------------------------
	$fidarr = $fields->getFidArray('list');
	$flatdata->setEmbedWhere("[$embed_dir][$item_field][$item_id]%");
	$data = $flatdata->getDatas( $fidarr , 0 ) ;
	$use_count = 0 ;
	$count = intval(count(@$data)) ;
	if( $params['count']==1 ){
		$use_count = true ;
	}else{
		if( count($data)<1 ) return ;

		//field data empty check
		$counter = 0 ;
		for( $i=0; $i<count($fidarr); $i++ ){
			if(!empty($data[0]['data'][$i])){
				$counter++ ;
				break ;
			}
		}
		if( $counter==0 ) return;
	}

	$allfields = $fields->getAllFields();
	if( count($allfields)<1 ) return ;
	//----------------------------------------------------------------------
	require_once XOOPS_ROOT_PATH.'/class/template.php';
	$tpl = new XoopsTpl();
	$tpl->assign( 'fields' , $allfields );
	$tpl->assign('data',@$data);
	$tpl->assign('count',$count);
	$tpl->assign('use_count',$use_count);
	$tpl->assign( $basic_assign );
	$tpl->display('db:'.$mydirname."_embed_display.html");
	//----------------------------------------------------------------------
}



//-----------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------
function flatdata_embed_form( $fd_dir , $embed_dir , $item_field , $item_id , $mode , $preload=0 , $params )
{
	global $xoopsUser , $xoopsConfig ; // $xoopsDB , $xoopsGTicket ,

	$mydirname = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $fd_dir ) ;
	require dirname(dirname( __FILE__ ))."/main/header.php";
	//----------------------------------------------------------------------
	$allfields = $fields->getAllFields();
	if( count($allfields)<1 ) return ;

	$pathArray = parse_url( xoops_getenv('REQUEST_URI') ) ;
	$querystring = empty($pathArray['query']) ? '' : '?'.$pathArray['query'] ;
	if( basename($pathArray['path']) == $embed_dir ){
		$filequery = $querystring ;
	}else{
		$filequery = basename($pathArray['path']). $querystring ;
	}
	$filequery = preg_replace( '/[^a-zA-Z0-9\.\?=&_-]/' , '' , $filequery ) ;

	//get data 
	$fidarr = $fields->getFidArray('list');
	$flatdata->setEmbedWhere("[$embed_dir][$item_field][$item_id]%");
	$data = $flatdata->getDatas( $fidarr );

	$post_multi = (isset($params['post']) && $params['post']=='multi') ? true : false ;

	//permission check
	if( !$isadmin ){
		if( $embed_dir=='register.php' ){
			if( count($data)>0 ){
				if( $item_id!=$uid || $uid==0 ) return ;
			}
		}elseif( $embed_dir=='edituser.php' || $embed_dir=='userinfo.php' ){
			if( $item_id!=$uid || $uid==0 ) return ;
		}else{
			if( count($data)>0 && ! $post_multi ){
				if( ! $editperm ) return ;
				if( $data[0]['uid']!=$uid ) return ;
			}else{
				if( ! $postperm ) return ;
			}
		}
	}

	if( isset($_SESSION['flatdata_confirm']) ){
		$data[0] = flatdata_getDataForConfirm($fidarr,$mydirname) ;
	}

	//check
	$preload_file = XOOPS_ROOT_PATH ."/preload/FlatdataEmbeddataInsert.class.php" ;
	//$template_file = ( ($embed_dir=='edituser.php' || $embed_dir=='register.php' || $preload==1 ) && file_exists($preload_file) && defined('XOOPS_CUBE_LEGACY') ) ? $mydirname."_embed_form_noformtag.html" : $mydirname."_embed_form.html" ;
	$formtag = ( ($embed_dir=='edituser.php' || $embed_dir=='register.php' || $preload==1 ) && file_exists($preload_file) && defined('XOOPS_CUBE_LEGACY') ) ? false : true ;

	//---------------------------------------------------------------
	require_once XOOPS_ROOT_PATH.'/class/template.php';
	$tpl = new XoopsTpl();
	$tpl->assign( 'fields' , $allfields );
	if( count($data)>0 ) $tpl->assign( 'data' , $data ) ;

	$tpl->assign( $basic_assign );
	$tpl->assign( 'gticket' , $GLOBALS['xoopsGTicket']->getTicketHtml(__LINE__,1800,'flatdata_embed_submit') );/* $xoopsGTicket*/
	$tpl->assign( 'formtag' , $formtag ) ;
	$tpl->assign('basedata',array(
		'fd_dir'     => $mydirname ,
		'embed_dir'  => htmlspecialchars($embed_dir,ENT_QUOTES) ,
		'item_field' => htmlspecialchars($item_field,ENT_QUOTES) ,
		'item_id'    => $item_id ,
		'filequery'  => $filequery ,
		'post_multi' => $post_multi ,
		'formtag'    => $formtag ,//TODO delete
	  ));
	//$tpl->display('db:'.$template_file);
	$tpl->display('db:'. $mydirname .'_embed_form.html');
	//---------------------------------------------------------------
}


//-----------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------
function flatdata_getDataForConfirm($fidarr,$mydirname)
{
	$post = unserialize($_SESSION['flatdata_confirm']) ;
	$data = array() ;
	for( $i=0; $i<count($fidarr); $i++ ){
		$fid = $fidarr[$i] ;
		$f_name = $mydirname ."_field". $fid ;
		$f = "field". $fid ;
		$temp = isset($post[$f_name]) ? flatdata_receiveData($post[$f_name]) : "" ;
		if( empty($temp) ){
			$temp = isset($post[$f]) ? flatdata_receiveData($post[$f]) : "" ;
		}
		$data['data'][$fid] = htmlspecialchars($temp,ENT_QUOTES) ;
	}
	$data['cat_id'] = intval($post['cat_id']) ;
	unset($_SESSION['flatdata_confirm']) ;
	return $data ;
}

function flatdata_receiveData( $data )
{
	$myts = & MyTextSanitizer::getInstance() ;
	$data = $myts->stripSlashesGPC($data) ;
	$data = preg_replace( 
		array("/\[field/si","/\[\/field/si") , 
		array("[ field","[ /field") ,
		$data 
	);
	return $data ;
}

?>