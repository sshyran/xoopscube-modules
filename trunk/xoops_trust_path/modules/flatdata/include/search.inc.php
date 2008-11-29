<?php
global $xoopsUser ;

$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname($mydirname);
$config_handler =& xoops_gethandler('config');
$mid = $module->getVar('mid');
$config =& $config_handler->getConfigsByCat(0,$mid);

$embed_dispperm = intval($config['embed_disp_perm']) ;
$isadmin = false ;
if( is_object($xoopsUser) ){
	$isadmin = $xoopsUser->isAdmin($mid) ;
}

if( $embed_dispperm==1 && !$isadmin ){
	return ;
}


eval( '
function '. $mydirname .'_search( $keywords , $andor , $limit , $offset , $userid )
{
	return flatdata_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}
' ) ;


if( ! function_exists( 'flatdata_search_base' ) ) 
{
	function flatdata_search_base( $mydirname, $queryarray, $andor, $limit, $offset, $userid ){
		require_once XOOPS_TRUST_PATH ."/modules/flatdata/class/fields.class.php" ;
		$fields = new flatdataFieldsClass( $mydirname ) ;
		$fidarr = $fields->getFidArray();
		$disp_fid = 0 ;//FID to display

		require_once XOOPS_TRUST_PATH."/modules/flatdata/class/flatdata.class.php" ;
		$flatdata = new Flatdata( $mydirname ) ;
		$flatdata->setAllSearch( $queryarray , $andor , $userid ) ;
		$flatdata->setOrder('D');//regidata DESC
		$datas = $flatdata->getDatas( $fidarr , $limit , $offset );

		$ret = array();
	 	for( $i=0 ; $i<count($datas); $i++ ){
	 		$title = ( $disp_fid != 0 ) ? " : ".$datas[$i]['data'][$disp_fid] : '' ;
			$ret[$i]['image'] = "images/flatdata.png";
			$ret[$i]['link']  = "index.php?did=".$datas[$i]['did'] ;
			$ret[$i]['title'] = " ID:" . $datas[$i]['did'] . $title ;
			$ret[$i]['time']  = $datas[$i]['regidate'];
			$ret[$i]['uid']   = $datas[$i]['uid'];
		}
		return $ret;
	}
}
?>
