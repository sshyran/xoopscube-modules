<?php
require_once 'ad_funcs.php';

$selfurl = XOOPS_URL."/modules/$mydirname/admin/index.php?act=makemenu";

//number of ADDURI 
$sql = "SELECT * FROM $table_addurl";
$result = $xoopsDB->query($sql);
while( $row = $xoopsDB->fetchArray($result) ){
	@$addurl[$row['subid']]++;
}

//GROUP
$member_handler =& xoops_gethandler('member');
$glist = $member_handler->getGroupList();
$i=0;
foreach( $glist as $k=>$v ){
	$grouplist[$i]['id'] = $k;
	$grouplist[$i++]['name'] = $v;
}



$notcorrect = ( isset($_GET['nf']) && $_GET['nf']==1 ) ? _MA_TREEMENU_NOFLOW : '' ;
// Condition branching /////////////////////////////////////
// INSERT
if ( isset($_POST['insert']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$title = isset($_POST['title']) ? $myts->stripSlashesGPC(trim($_POST['title'])) : "";
	$url = isset($_POST['url']) ? $myts->stripSlashesGPC(trim($_POST['url'])) : "";
	if ( $title != "" && $url != "" ) {
		$sql ="SELECT max(sortnum) FROM $table_menu";
		list( $maxnum ) = $xoopsDB->fetchRow($xoopsDB->query($sql));	//get last sort number
		$maxnum++;

		$url = checkURL( $url );
		$title = addslashes($title);
		$url = addslashes($url);
		$sql = "INSERT INTO  $table_menu  (`title`, `url`, `flow`, `sortnum`, `blockid`, `hiera`, `flag` ) VALUES ('$title', '$url', '0', $maxnum , 0 , 0, 0 )";
		if( ! $xoopsDB->query($sql) ){	//CHECK
			redirect_header( $selfurl ,1, 'DB insert Erorr' );
			exit();
		}
		//Group Access
		$grp = $_POST['grp'];
		$subid =  $xoopsDB->getInsertId();
		for( $i=0; $i<count($grouplist) ; $i++ ){
			$gid =  $grouplist[$i]['id'];
			$visible = isset($grp[$gid]) ? 1 : 0 ;
			$sql = "INSERT INTO  $table_access  (`subid`, `groupid`, `visible` ) VALUES ( $subid, $gid, $visible )";
			$xoopsDB->query($sql) or die( "DB Error: TABEL ACCESS insert " ) ;
		}
		//Postprocessing
		renumberS();
		renumberB();
		$nf = ( ! makeFlow() )  ? "&amp;nf=1" : '' ;
		redirect_header( $selfurl.$nf , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
		exit();
	}else{
		$notcorrect .= _MA_TREEMENU_NO_TITLE ;
	}
}
// HIERARCY TO RIGHT 
if ( isset($_POST['right']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$subid = intval($_POST['right']);
	$sql = "SELECT hiera FROM $table_menu WHERE subid=$subid";
	list( $hiera ) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	$sql = "UPDATE $table_menu SET hiera='". ++$hiera ."' WHERE subid=$subid";
	$xoopsDB->query($sql) or die( "DB Error: change hierarchy" ) ;
	renumberB();
	$nf = ( ! makeFlow() )  ? "&amp;nf=1" : '' ;
	redirect_header( $selfurl.$nf , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
	exit();
}
// HIERARCY TO LEFT
if ( isset($_POST['left']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$subid = intval($_POST['left']);
	$sql = "SELECT hiera FROM $table_menu WHERE subid=$subid";
	list( $hiera ) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	if( $hiera > 0 ){
		$sql = "UPDATE $table_menu SET hiera='". --$hiera ."' WHERE subid=$subid";
		$xoopsDB->query($sql) or die( "DB Error: change hierarchy" ) ;
		renumberB();
		$nf = ( ! makeFlow() )  ? "&amp;nf=1" : '' ;
		redirect_header( $selfurl.$nf , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
		exit();
	}else{
		$notcorrect .= _MA_TREEMENU_NOT_MOVE ;
	}
}
// UP row
if ( isset($_POST['up']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$subid = intval($_POST['up']);
	$sql = "SELECT sortnum FROM $table_menu WHERE subid=$subid";
	list( $sortnum ) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	if( $sortnum > 1 ){
		$sql = "SELECT subid FROM $table_menu WHERE sortnum=".($sortnum-1);
		list( $b_subid ) = $xoopsDB->fetchRow($xoopsDB->query($sql));
		$sql = "UPDATE $table_menu SET sortnum=$sortnum WHERE subid=$b_subid";
		$xoopsDB->query($sql) or die( "DB Error: sort" ) ;
		$sql = "UPDATE $table_menu SET sortnum=". ($sortnum-1) ." WHERE subid=$subid";
		$xoopsDB->query($sql) or die( "DB Error: up sort" ) ;
		renumberS();
		renumberB();
		$nf = ( ! makeFlow() )  ? "&amp;nf=1" : '' ;
		redirect_header( $selfurl.$nf , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
		exit();
	}else{
		echo "UP:".$_POST['up'];
		$notcorrect = _MA_TREEMENU_NOT_MOVE ;
	}
}
// DOWN row
if ( isset($_POST['down']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$subid = intval($_POST['down']);
	$sql = "SELECT sortnum FROM $table_menu WHERE subid=$subid";
	list( $sortnum ) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	$sql = "SELECT subid FROM $table_menu WHERE sortnum=".($sortnum+1);
	list( $a_subid ) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	$sql = "UPDATE $table_menu SET sortnum=$sortnum WHERE subid=$a_subid";
	if( $xoopsDB->query($sql) ){	//CHECK
		$sql = "UPDATE $table_menu SET sortnum=". ($sortnum+1) ." WHERE subid=$subid";
		$xoopsDB->query($sql) or die( "DB Error: down sort" ) ;
		renumberS();
		renumberB();
		$nf = ( ! makeFlow() )  ? "&amp;nf=1" : '' ;
		redirect_header( $selfurl.$nf , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
		exit();
	}else{
		$notcorrect = _MA_TREEMENU_NOT_MOVE ;
	}
}
// UP block
if ( isset($_POST['bup']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$blockid = intval($_POST['bup']);
	if( $blockid > 1 ){
		$sql = "SELECT subid FROM $table_menu WHERE blockid=$blockid ORDER BY sortnum ASC";
		$upblock_result = $xoopsDB->query($sql)  ;
		$sql = "UPDATE $table_menu SET blockid=$blockid WHERE blockid=".($blockid-1);
		$xoopsDB->query($sql) or die( "DB Error: up block sort -1" ) ;
		while( $row = $xoopsDB->fetchArray($upblock_result) ){
			$sql = "UPDATE $table_menu SET blockid=".($blockid-1)." WHERE subid=".$row['subid'];
			$xoopsDB->query($sql) or die( "DB Error: up block sort -2" ) ;
		}
		renumberS_forblock();
		renumberB();
		redirect_header( $selfurl , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
		exit();
	}else{
		$notcorrect = _MA_TREEMENU_NOT_MOVE ;
	}
}
// DOWN block
if ( isset($_POST['bdown']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$blockid = intval($_POST['bdown']);
	$sql = "SELECT subid FROM $table_menu WHERE blockid=$blockid ORDER BY sortnum ASC";
	$downblock_result = $xoopsDB->query($sql);
	$sql = "UPDATE $table_menu SET blockid=$blockid WHERE blockid=".($blockid+1);
	if( $xoopsDB->query($sql) ){	//
		while( $row = $xoopsDB->fetchArray($downblock_result) ){
			$sql = "UPDATE $table_menu SET blockid=".($blockid+1)." WHERE subid=".$row['subid'];
			$xoopsDB->query($sql) or die( "DB Error: down block sort " ) ;
		}
		renumberS_forblock();
		renumberB();
		redirect_header( $selfurl , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
		exit();
	}else{
		$notcorrect = _MA_TREEMENU_NOT_MOVE ;
	}
}
// DELETE row
if ( !empty($_POST['deleteid']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$deleteid = intval($_POST['deleteid']);
	$sql = "DELETE FROM $table_menu WHERE subid=$deleteid";
	$xoopsDB->query($sql) or die( "DB Error: delete" ) ;
	renumberS();
	renumberB();
	redirect_header( $selfurl , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
	exit();
}
// DELETE block
if ( !empty($_POST['deletebid']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$deletebid = intval($_POST['deletebid']);
	$sql = "DELETE FROM $table_menu WHERE blockid=$deletebid";
	$xoopsDB->query($sql) or die( "DB Error: delete" ) ;
	renumberS();
	renumberB();
	redirect_header( $selfurl , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
	exit();
}
// SORT block
if( !empty($_POST['blocksort']) ){
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$blocksort = $_POST['block_sort'] ;//array
	$bnum = count($blocksort);
	for( $i=1; $i<=$bnum; $i++ ){
		$temp_blockid = ($blocksort[$i]<=0) ? 1 + $bnum : intval($blocksort[$i]) + $bnum ;
		$sql = "UPDATE $table_menu SET blockid=$temp_blockid WHERE blockid=$i";
		$xoopsDB->query($sql) or die( "DB Error: block sort " ) ;
	}
	renumberS_forblock();
	renumberB();
	redirect_header( $selfurl , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
	exit();
}


//-----------------------------------------------------------------------

//js files check
$jsfiles = ( file_exists(XOOPS_ROOT_PATH."/common/lib/prototype.js") && file_exists(XOOPS_ROOT_PATH."/common/lib/scriptaculous.js") ) ? 1 : 0 ;

// UA
$ieopera = ( /*stristr( $_SERVER['HTTP_USER_AGENT'] , 'MSIE' ) ||*/ stristr( $_SERVER['HTTP_USER_AGENT'] , 'Opera' ) ) ? 1 : 0 ;


$sql ="SELECT * FROM $table_menu ORDER BY sortnum ASC";
$result = $xoopsDB->query($sql);

$baseindent = 12;	//
$menus2 = array();	//$menus = 
while ( $vals = $xoopsDB->fetchArray($result) ) {
	$title = htmlspecialchars( $vals['title'] , ENT_QUOTES );
	$subid = $vals['subid'];
	$url = $vals['url'] ;
	if( !strpos($vals['url'],"//") ){
		$url = XOOPS_URL . $vals['url'] ;
	}
	
	$menus2[$vals['blockid']][] = array(	// = $menus[]
		'subid'         => $subid ,
		'title'         => $title ,
		'url'           => htmlspecialchars( tmCodeDecode($url) , ENT_QUOTES ) ,
		'sortnum'       => $vals['sortnum'] ,
		'hiera'         => $vals['hiera'] ,
		'flow'          => htmlspecialchars($vals['flow'], ENT_QUOTES ) ,
		'flag'          => $vals['flag'] ,
		'blockid'       => $vals['blockid'] ,
		'indent'        => $baseindent * $vals['hiera'] ,
		'del_bconfirm'  => "confirm('" . sprintf( _MA_TREEMENU_BLOCK_DELCONFIRM , $vals['blockid'] ) . "')" ,
		'addurl'        => @$addurl[$subid] ,
		'del_confirm'   => "confirm('" . sprintf( _MA_TREEMENU_DELCONFIRM , $title ) . "')"
	);
	
}

//-----------------------------------------------------------------------
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';
$tpl =& new D3Tpl() ;
$tpl->assign( array(
	'modulename' => $xoopsModule->getVar('name') ,
	'notcorrect' => $notcorrect ,
	'menus2'     => $menus2 ,
	'jsfiles'    => $jsfiles ,
	'ieopera'    => $ieopera ,
	'grouplist'  => $grouplist ,
	'selfurl'    => $selfurl ,
	'gticket'    => $GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ ),
) ) ;
$tpl->display( "db:{$mydirname}_admin_makemenu.html" ) ;
xoops_cp_footer();
exit();
//-----------------------------------------------------------------------

?>
