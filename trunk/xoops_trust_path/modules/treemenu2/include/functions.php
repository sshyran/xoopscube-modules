<?php
require_once dirname(dirname(__FILE__))."/class/PresentLocation.php" ;

//function sitemapMakeMenu( $acs_tbl , $mydirname , $configs , $addwhr='' ){
function sitemapMakeMenu( $mydirname , $google=false , $nopl=false ){
	global $xoopsDB, $xoopsUser ;

	$PL =& PresentLocation :: getInstance() ;
	$PL->setting($mydirname);

	$subid = "" ;
	if( ! $nopl ){
		if( empty($PL->subid[$mydirname])  ){
			$PL->search();
		}
		$subid = $PL->subid[$mydirname] ;
	}

	$table_menu = $xoopsDB->prefix( $mydirname."_menu" ) ;
	$table_access = $xoopsDB->prefix( $mydirname."_access" ) ;

	//present block
	$blockid = '';
	if ( !empty($subid) ) {
		$sql = "SELECT blockid,flow FROM $table_menu WHERE subid=". $subid ;
		$result = $xoopsDB->query($sql);
		$vals = $xoopsDB->fetchArray($result);
		$blockid = $vals['blockid'] ;
	}

	//check content of $table_access 
	$acstblsql = "SELECT count(*) FROM $table_access";
	list( $acs_tbl ) = $xoopsDB->fetchRow($xoopsDB->query($acstblsql));
	if( $acs_tbl == 0 ) return ;	//"Permissions of Menu" is necessary
	
	//GROUP
	$addwhr = '';
	if( $google != true && is_object( @$xoopsUser ) ) {
		$member_handler =& xoops_gethandler( 'member' ) ;
		$groups = $member_handler->getGroupsByUser( $xoopsUser->getVar('uid') ) ;
	} else {
		$groups = array( XOOPS_GROUP_ANONYMOUS );
	}
	$addwhr = ' ( groupid='. join(' OR groupid=',$groups) .' ) ';

	//module config
	$config = treemenuGetConfig( $mydirname );


	$ret = false;
	// Get menu ////////////////////////////////////
	$list = array();
	$hiera_a = array();
	$b_home = array();
	$sql = "SELECT * FROM $table_menu ORDER BY sortnum ASC" ;
	if ($result = $xoopsDB->query($sql)) {
		while($vals = $xoopsDB->fetchArray($result)) {
			//check permission 
			$visisql = "SELECT visible FROM $table_access WHERE subid=". $vals['subid'] ." AND $addwhr ";
			$rslt= $xoopsDB->query($visisql);
			$visible = 0;
			while( $row=$xoopsDB->fetchArray($rslt) ){
				$visible += $row['visible'];
			}
			if( $visible < 1 ) continue ;

			$target = 0 ;
			$url = $vals['url'] ;
			if( strpos($url,"//")>0 ){
				$target = $config['targetblank'] ? 1 : 0 ;
			}else{
				$url = XOOPS_URL . $url ;
			}
			$home = ( $url == XOOPS_URL."/" && $vals['hiera']==0 ) ? 1 : 0 ;
			if( @$b_home[ $vals['blockid'] ]==1 && $home==0 ) $home = 1 ;	//the under hierarcy of home is flag 1

			//login or logout or userinfo etc....access file in root directry
			$tempurl = str_replace( XOOPS_URL."/", '', $url );
			$s_posi = strpos( $tempurl , "/" );
			$p_posi = strpos( $tempurl , "+" );	// for Simplified URLs ?
			if( $target == 0 && $home == 0 && empty($s_posi) && empty($s_posi) ) $home = 2 ;
			if( @$b_home[ $vals['blockid'] ]==2 && $home==0 ) $home = 2 ;	//the under hierarcy of usermenu is flag 2

			$b_home[ $vals['blockid'] ] = $home;

			$hereblock = ( $vals['blockid'] == $blockid ) ? 1 : 0 ;
			$here = ( $vals['subid'] == $subid ) ? 1 : 0 ;

			$list[ $vals['blockid'] ][] = array(
				'subid'   => $vals['subid'],
				'sortnum' => $vals['sortnum'],
				'flag'    => $vals['flag'],
				'flow'    => htmlspecialchars( $vals['flow'] , ENT_QUOTES ),
				'title'   => htmlspecialchars( $vals['title'] , ENT_QUOTES ),
				'url'     => htmlspecialchars( tmCodeDecode($url) , ENT_QUOTES ),
				'depth'   => $vals['hiera'],
				'blockid' => $vals['blockid'],
				'target'  => $target,
				'home'    => $home,
				'here'    => $here,
				'hereblk' => $hereblock,
			);
			$hiera_a[ $vals['hiera'] ] = $vals['hiera'];
		}
		return array( $list , $hiera_a );
	}
	return $ret;
}

// Get Modules Config
function treemenuGetConfig( $mydirname ){
	$module_handler =& xoops_gethandler('module');
	$config_handler =& xoops_gethandler('config');
	$module =& $module_handler->getByDirname($mydirname);
	$config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	return $config;
}


function tmCodeDecode($text){
	$patterns[] = "/javascript:/si";
	$replacements[] = "java script:";
	$patterns[] = "/about:/si";
	$replacements[] = "about :";
	$ret = preg_replace($patterns, $replacements, $text);
	return $ret;
}

?>