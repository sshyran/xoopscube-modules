<?php
if( !$postperm ){
	redirect_header($mydirurl."/",2,_NOPERM);
	exit();
}



//----------------------------------------------------------------------
if ( !empty($_POST['submit']) || !empty($_POST['submit1']) ) {
	if( ! $xoopsGTicket->check( true , 'flatdata_submit' ) ) {
		redirect_header($mydirurl."/",3,$xoopsGTicket->getErrors());
		exit();
	}
	$fidarr = $fields->getFidArray();
	if( ! $flatdata->embed_preCheck($fidarr) ){
		redirect_header($mydirurl."/index.php?page=submit",2,_MD_NO_DATA);
		exit();
	}
	$did = $flatdata->insert($fidarr);
	if( defined('XOOPS_CUBE_LEGACY') && $did ){
		$data = $flatdata->getData( $did , $fidarr ) ;
		$data['mydirname'] = $mydirname ;
		XCube_DelegateUtils::call('Flatdata.Event.Submit.Insert',$data);//$data is array
	}
	redirect_header($mydirurl."/",2,_MD_RECEIVED);
	exit();
}
//----------------------------------------------------------------------





$allfields = $fields->getAllFields();
if( count($allfields)<1 ){
	redirect_header($mydirurl."/",2,_MD_NO_FIELD);
}
//----------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_submit.html';
include XOOPS_ROOT_PATH."/header.php";
if( !empty($allfields) ){
	$xoopsTpl->assign( 'fields' , $allfields );
}
$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign('gticket',$xoopsGTicket->getTicketHtml(__LINE__,1800,'flatdata_submit'));
include XOOPS_ROOT_PATH.'/footer.php';
//----------------------------------------------------------------------
?>