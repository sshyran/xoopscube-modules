<?php
if( !($editperm || $delperm) ){
	redirect_header($mydirurl."/",2,_NOPERM);
	exit();
}

$did = isset($_GET['did']) ? intval($_GET['did']) : 0 ;
$did = isset($_POST['did']) ? intval($_POST['did']) : $did ;
$fidarr = $fields->getFidArray();
$data = $flatdata->getData( $did , $fidarr ) ;



//----------------------------------------------------------------------
if (!empty($_POST['edit'])) {
	if( !($data && ($isadmin || ($editperm && $data['uid']==$uid))) ){
		redirect_header($mydirurl."/",2,_NOPERM);
		exit();
	}
	if( ! $xoopsGTicket->check( true , 'flatdata_edit' ) ) {
		redirect_header($mydirurl."/",3,$xoopsGTicket->getErrors());
		exit();
	}
	$flatdata->update($did,$fidarr);
	if( defined('XOOPS_CUBE_LEGACY') && $did ){
		$data = $flatdata->getData( $did , $fidarr ) ;
		$data['mydirname'] = $mydirname ;
		XCube_DelegateUtils::call('Flatdata.Event.Edit.Update',$data);//$data is array
	}
	redirect_header($mydirurl."/",2,_MD_MODIFY_FIN);
	exit();
}
//----------------------------------------------------------------------
if( isset($_POST['deldata']) && $_POST['deldata']==1 ){
	if( !($data && ($isadmin || ($delperm && $data['uid']==$uid))) ){
		redirect_header($mydirurl."/",2,_NOPERM.__LINE__);
		exit();
	}
	if( ! $xoopsGTicket->check( true , 'flatdata_edit' ) ) {
		redirect_header($mydirurl."/",3,$xoopsGTicket->getErrors());
		exit();
	}
	$flatdata->delete($did) ;
	if( defined('XOOPS_CUBE_LEGACY') && $data ){
		$data['mydirname'] = $mydirname ;
		XCube_DelegateUtils::call('Flatdata.Event.Edit.Delete',$data);//old $data is array
	}
	redirect_header($mydirurl."/",2,_MD_DELETE_FIN);
	exit();
}
//----------------------------------------------------------------------



$allfields = $fields->getAllFields();

if( count($allfields)<1 || empty($data) ){
	redirect_header($mydirurl."/",2,_MD_CANT_GET_DATA);
}

//----------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_edit.html';
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign( 'fields' , $allfields );
$xoopsTpl->assign( 'data' , $data );

$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign('gticket',$xoopsGTicket->getTicketHtml(__LINE__,1800,'flatdata_edit'));

include XOOPS_ROOT_PATH.'/footer.php';
//----------------------------------------------------------------------
?>