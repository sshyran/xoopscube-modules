<?php
$redirect  = isset($_POST['flatdata_filequery']) ? $myts->stripSlashesGPC($_POST['flatdata_filequery']) : '' ;
$redirect  = preg_replace( '/[^a-zA-Z0-9\.\?=&_-]/' , '' , $redirect ) ;
$embed_dir = isset($_POST['flatdata_embed_dir']) ? $myts->stripSlashesGPC($_POST['flatdata_embed_dir']) : '' ;
$embed_dir = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $embed_dir ) ;
if( !in_array($embed_dir,$sp_embed_dir) ){
	$redirect = "modules/$embed_dir/".$redirect ;
}
//$redirect = htmlspecialchars(flatdata_urlCheckReplace($redirect),ENT_QUOTES) ;//TODO


$fidarr = $fields->getFidArray();
$did = isset($_POST['flatdata_did']) ? intval($_POST['flatdata_did']) : 0 ;


//permission check
if( !$isadmin ){
	if( in_array($embed_dir,$sp_embed_dir) ){
		if( $_POST['item_id']!=$uid || $uid==0 ){
			redirect_header( XOOPS_URL."/".$redirect ,2, _NOPERM );
			exit() ;
		}
	}elseif( !empty($_POST['submit']) || !empty($_POST['submit1']) ){
		if( !$postperm ){
			redirect_header( XOOPS_URL."/".$redirect ,2, _NOPERM );
			exit() ;
		}
	}elseif( !empty($_POST['edit']) ){
		$data = $flatdata->getData( $did , $fidarr );
		if( !($editperm && $data['uid']==$uid) ){
			redirect_header( XOOPS_URL."/".$redirect ,2, _NOPERM );
			exit() ;
		}
	}elseif( isset($_POST['flatdata_deldata']) && $_POST['flatdata_deldata']==1 ){
		$data = $flatdata->getData( $did , $fidarr );
		if( !($delperm && $data['uid']==$uid) ){
			redirect_header( XOOPS_URL."/".$redirect ,2, _NOPERM );
			exit() ;
		}
	}else{
		redirect_header( XOOPS_URL."/".$redirect ,2, _NOPERM );
		exit() ;
	}
}




//gticket check
if ( ! $xoopsGTicket->check( true , 'flatdata_embed_submit' ) ) {
	redirect_header( XOOPS_URL."/".$redirect ,3,$xoopsGTicket->getErrors());
	exit();
}

//----------------------------------------------------------------------
if( isset($_POST['flatdata_deldata']) && $_POST['flatdata_deldata']==1 ){
	$flatdata->delete($did);
	redirect_header( XOOPS_URL."/".$redirect ,2, _MD_DELETE_FIN );
	exit();
}
//----------------------------------------------------------------------
if (!empty($_POST['submit'])||!empty($_POST['submit1'])||!empty($_POST['edit'])) {
	if( ! $flatdata->embed_preCheck($fidarr) ){
		redirect_header(XOOPS_URL."/".$redirect,2,_MD_NO_DATA);
		exit();
	}

	if( isset($_POST['submit']) || isset($_POST['submit1']) ){
		$flatdata->embedData() ;
		$flatdata->insert($fidarr);
		$msg = _MD_RECEIVED ;
	}elseif( isset($_POST['edit']) ){
		$flatdata->update($did,$fidarr);
		$msg = _MD_MODIFY_FIN ;
	}
	redirect_header( XOOPS_URL."/".$redirect ,2, $msg );
	exit();
}else{
	redirect_header( XOOPS_URL."/".$redirect ,2, _NOPERM );
	exit() ;
}
//----------------------------------------------------------------------

?>