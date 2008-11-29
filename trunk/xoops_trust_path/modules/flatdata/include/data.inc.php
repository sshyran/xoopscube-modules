<?php
$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname($mydirname);

if( ! $module->getVar('isactive') ){
	return ;
}

global $xoopsUser ;
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


//--------------------------------------------------------------------
eval('
    function '.$mydirname.'_new( $limit=0, $offset=0)
    {
        return flatdata_new_base( "'.$mydirname.'" , $limit, $offset );
    }
');

//--------------------------------------------------------------------
if( ! function_exists( 'flatdata_new_base' ) ) 
{

	function flatdata_new_base($mydirname, $limit=0, $offset=0)
	{
		$MOD_URL  = XOOPS_URL .'/modules/'. $mydirname ;

		require_once XOOPS_TRUST_PATH ."/modules/flatdata/class/fields.class.php" ;
		$fields = new flatdataFieldsClass( $mydirname ) ;
		$fidarr = $fields->getFidArray();
		$disp_fid = 0 ;//FID to display

		require_once XOOPS_TRUST_PATH."/modules/flatdata/class/flatdata.class.php" ;
		$flatdata = new Flatdata( $mydirname ) ;
		$flatdata->setOrder('D');//regidata DESC
		$datas = $flatdata->getDatas( $fidarr , $limit , $offset );

		$ret = array() ;
		for( $i=0 ; $i<count($datas); $i++ ){
			$title = ( $disp_fid != 0 ) ? " : ".$datas[$i]['data'][$disp_fid] : '' ;
			$ret[$i] = array(
			  'link'  => $MOD_URL .'/index.php?did='. $datas[$i]['did'] ,
			  'title' => " ID:" . $datas[$i]['did'] . $title ,
			//  'hits'  => $row['hits'] ,
			  'time'  => $datas[$i]['regidate'] ,
			  'id'    => $datas[$i]['did'] ,
			  'uid'   => $datas[$i]['uid'] ,
			) ;
		}

		return $ret;
	}

}
//--------------------------------------------------------------------

?>