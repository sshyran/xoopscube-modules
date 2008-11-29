<?php
require_once dirname(dirname(__FILE__))."/include/functions.php" ;
require_once dirname(dirname(__FILE__))."/class/PresentLocation.php" ;


//TREEMENU BLOCK -----------------------------------------------------------------------
function b_treemenu_show( $options ) {
	global $xoopsDB , $xoopsUser , $xoopsTpl ;

	//OPITIONS
	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$this_template = empty( $options[1] ) ? 'db:'.$mydirname.'_block_display.html' : trim( $options[1] ) ;

	//table
	$table_menu = $xoopsDB->prefix( $mydirname."_menu" ) ;
	$table_access = $xoopsDB->prefix( $mydirname."_access" ) ;

	//CHECK $table_access
	$acetblsql = "SELECT count(*) FROM $table_access " ;
	list( $acs_tbl ) = $xoopsDB->fetchRow($xoopsDB->query($acetblsql));
	if( $acs_tbl == 0 ) return ;	//"Permissions of Menu" is necessary

	// Get present locationisubidj
	$subid = empty($_GET['tmid']) ? "" : intval($_GET['tmid']) ;
	$subid = ( empty($subid) && empty($_GET['subid']) ) ? "" : intval($_GET['subid']) ;

	$PL =& PresentLocation :: getInstance() ;
	$PL->setting($mydirname);
//	var_dump(@$PL->subid[$mydirname]);
	if( empty($subid) ){
		if( empty($PL->subid[$mydirname]) ){
			$PL->search() ;
		}
		$subid = $PL->subid[$mydirname] ;
	}

	// get module config 
	$config = treemenuGetConfig( $mydirname );

	// GET flow  
	$flow = '0';
	$blockid = '';
	if( !empty($subid) ){
		$sql = "SELECT blockid,flow FROM $table_menu WHERE subid=$subid";//. $PL->subid[$mydirname] ;
		$result = $xoopsDB->query($sql);
		$vals = $xoopsDB->fetchArray($result);
		$flow = $vals['flow'] .'-'. $subid;//$PL->subid[$mydirname] ;	// ADD $subid
		$blockid = $vals['blockid'];	//present block location
	}

	$block = array();
	// Tree Menu Display ////////////////////////////////////
	$wheres = array();
	if ( $config['viewtype'] == 2 ) {		// It displays it under the selected menu. [default]
		$flowids = explode("-", $flow);
		$tempflow = $flowids[0];
		$wheres[] = '`flow` = "' . $tempflow . '"';
		for ($i = 1; $i < count($flowids); $i++) {
			$wheres[] = '`flow` LIKE "%-'.$flowids[$i].'"';
		}
	}
	if ( $config['viewtype'] == 3 ) {	// The same block in present location is displayed all
		$wheres[] = " hiera=0 ";
		if( !empty($blockid) ) $wheres[] = " blockid=$blockid ";
	}
	$sql = "SELECT * FROM $table_menu " ;
	if (count($wheres) > 0) {
		$sql.= ' WHERE '.join(" OR ",$wheres) .' ';
	}
	$sql.= 'ORDER BY `sortnum` ASC';

	//$hiera_a = array();
	if ( $result = $xoopsDB->query($sql) ) {
		if ($config['viewtype'] == 4) {
			$flows = explode("-",$flow);
		}
		while($vals = $xoopsDB->fetchArray($result)) {
			$sql = "SELECT visible FROM $table_access WHERE subid=". $vals['subid'] ." AND ".$PL->gwhr;
			$rslt= $xoopsDB->query($sql);
			$visible = 0;
			while( $row=$xoopsDB->fetchArray($rslt) ){
				$visible += $row['visible'];
			}
			if( $visible < 1 ) continue ;

			if ($config['viewtype'] == 4) {
				$myflows = explode("-",$vals['flow']);
				$myflows = array_diff($myflows, $flows);	//get gap
				$diffcount = count($myflows);
				if ($diffcount > 1) continue;
			}

			$target = 0 ;
			$url = $vals['url'] ;
			if( strpos($url,"//")>0 ){
				$target = $config['targetblank'] ? 1 : 0 ;
			}else{
				$url = XOOPS_URL . $url ;
			}
			$hereblock = ( $vals['blockid'] == $blockid ) ? 1 : 0 ;
			$here = ( $vals['subid'] == $subid ) ? 1 : 0 ;

			$block['list'][] = array(
					'title'   => htmlspecialchars( $vals['title'] , ENT_QUOTES ),
					'url'     => htmlspecialchars( tmCodeDecode($url) , ENT_QUOTES ) , 
					'depth'   => $vals['hiera'] ,
					'subid'   => $vals['subid'] ,
					'target'  => $target ,
					'hereblk' => $hereblock ,
					'here'    => $here ,
					'blockid' => $vals['blockid'] ,
			);
			//$hiera_a[ $vals['hiera'] ] = $vals['hiera'];
		}
	}

	if( empty( $options['disable_renderer'] ) ) {
		//JS, CSS
		$xoops_module_header = $xoopsTpl->get_template_vars("xoops_module_header") ;
		$cssfile = XOOPS_URL.'/modules/'.$mydirname.'/index.php?act=css' ;
		$css = '<link rel="stylesheet" type="text/css" media="all" href="'.$cssfile.'" />' ;
		if( !empty($xoops_module_header) && strstr( $xoops_module_header , $cssfile ) ){
			$css = '' ;
		}
		$xoopsTpl->assign( 'xoops_module_header' , $css . $xoops_module_header );
		//Template
		$tpl =& new XoopsTpl();
		$tpl->assign( 'block' , $block );
		$tpl->assign( 'mydirname' , $mydirname );
		//$tpl->assign( 'hiera' , $hiera_a );
		//if( defined('XOOPS_CUBE_LEGACY') ) $tpl->assign( 'xcl' , 1 );
		$ret['content'] = $tpl->fetch( $this_template );
		return $ret;
	}else{
		return $block;
	}

}




//SITEMAP BLOCK --------------------------------------------------------------------
function b_sitemap_show( $options ){
	global $xoopsTpl ;

	//OPITIONS
	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$open = empty( $options[1] ) ? 0 : 1 ;
	$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_sitemap.html' : trim( $options[2] ) ;

	//CREATE MENU
	$sitemapmenu = sitemapMakeMenu( $mydirname );

	if( empty( $options['disable_renderer'] ) ) {
		//JS, CSS
		$xoops_module_header = $xoopsTpl->get_template_vars("xoops_module_header") ;
		$cssfile = XOOPS_URL.'/modules/'.$mydirname.'/index.php?act=css' ;
		$css = '<link rel="stylesheet" type="text/css" media="all" href="'.$cssfile.'" />' ;
		if( !empty($xoops_module_header) && strstr( $xoops_module_header , $cssfile ) ){
			$css = '' ;
		}
		$xoopsTpl->assign( 'xoops_module_header' , '<script type="text/javascript" src="'.XOOPS_URL.'/modules/'.$mydirname.'/index.php?act=javascript"></script>'. $css . $xoops_module_header );
		//Template ---------------
		$tpl =& new XoopsTpl();
		$tpl->assign( 'block' , $sitemapmenu[0] );
		$tpl->assign( 'mydirname' , $mydirname );
		$tpl->assign( 'open' , $open );
		//$tpl->assign( 'hiera' , $sitemapmenu[1] );
		$ret['content'] = $tpl->fetch( $this_template );
		return $ret;
	}else{
		return $sitemapmenu[0] ;
	}

}

function b_sitemap_edit( $options ){
	//OPITIONS
	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$open = empty( $options[1] ) ? 0 : 1 ;
	$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_sitemap.html' : trim( $options[2] ) ;

    //OPEN or CLOSE
    $ocheck0 = $ocheck1 = '' ;
    $ochk = "ocheck$open" ;
    $$ochk = "CHECKED='CHECKED'";

    $form = "
      <input type='hidden' name='options[0]' value='".htmlspecialchars($mydirname,ENT_QUOTES)."' />
      ". _MB_TREEMENU2_SITEMAP_BLOCK_OPENCLOSE ."
      <input type='radio' name='options[1]' value='1' $ocheck1 />". _YES ."&nbsp;
      <input type='radio' name='options[1]' value='0' $ocheck0 />". _NO."&nbsp;
      <br />
      ". _MB_TREEMENU2_TEMPLATE ."
      <input type='text' size='60' name='options[2]' value='".htmlspecialchars($this_template,ENT_QUOTES)."' />
      <br />\n" ;

    return $form;

}
?>
