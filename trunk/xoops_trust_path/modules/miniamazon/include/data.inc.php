<?php
// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'blocks_common.php' , $mydirname , $mytrustdirname , false ) ;
$langman->read( 'blocks_each.php' , $mydirname , $mytrustdirname , false ) ;

$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname($mydirname);

if( $module->getVar('isactive') ){


// --- eval begin ---
eval( '
function '.$mydirname.'_new( $limit=0, $offset=0)
{
	return miniamazonD3_new_base( "'.$mydirname.'" , $limit, $offset );
}
' ) ;
// --- eval end ---


// --- miniamazon_new_base begin ---
if( ! function_exists( 'miniamazonD3_new_base' ) ) 
{

function miniamazonD3_new_base($mydirname, $limit=0, $offset=0)
{
	global $xoopsDB ;
	$myts =& MyTextSanitizer::getInstance();

	$constpref = '_MB_' . strtoupper( $mydirname ) ;

	$MOD_PATH = XOOPS_ROOT_PATH .'/modules/'. $mydirname;
	$MOD_URL  = XOOPS_URL       .'/modules/'. $mydirname;

	//DB table
	$table_items = $xoopsDB->prefix( $mydirname."_items" ) ;
	$table_cat   = $xoopsDB->prefix( $mydirname."_cat" ) ;

	$sql = "SELECT lid, cid, title, clicks, uid, regdate, description FROM $table_items WHERE stats>0 ORDER BY regdate DESC";

	$result = $xoopsDB->query( $sql , $limit , $offset ) ;
	$ret = array() ;

	while( $row = $xoopsDB->fetchArray($result) ) 
	{
		if( $row['cid']==0 ){
			$ctitle = constant($constpref.'_LANG_NO_CATEGORY');
		}else{
			$sql = "SELECT ctitle FROM $table_cat WHERE cid=".$row['cid'];
			list($ctitle) = $xoopsDB->fetchRow($xoopsDB->query($sql));
		}

		$desc = strip_tags($myts->displayTarea($row['description'], 0, 0, 1, 1, 0));
		$desc = $myts->nl2Br($desc);
		$desc = preg_replace( '/(<br \/>){2,}/' , '<br />' , $desc ) ;

		$ret[] = array(
			'link'        => $MOD_URL .'/index.php?lid='. $row['lid'] ,
			'cat_link'    => $MOD_URL .'/index.php?cid='. $row['cid'] ,
			'title'       => htmlspecialchars($row['title'],ENT_QUOTES) ,
			'cat_name'    => htmlspecialchars($ctitle,ENT_QUOTES) ,
			'hits'        => $row['clicks'] ,
			'time'        => $row['regdate'] ,
			'id'          => $row['lid'] ,
			'uid'         => $row['uid'] ,
			'description' => $desc,
		) ;
	}

	return $ret;
}

}
// --- miniamazon_new_base end ---

} //END of if( $module->getVar('isactive') )
?>