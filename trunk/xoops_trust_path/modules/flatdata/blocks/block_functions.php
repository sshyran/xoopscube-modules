<?php

require_once dirname(dirname(__FILE__))."/class/fields.class.php" ;
require_once dirname(dirname(__FILE__))."/class/flatdata.class.php" ;



//-----------------------------------------------------------------------
if( ! function_exists( 'b_flat_top_show' )) {

  function b_flatdata_top_show($options) {
	//global $xoopsDB;
	$mydirname = empty( $options[0] ) ? basename(dirname(dirname(__FILE__))) : $options[0] ;
	$order = empty( $options[1] ) ? 0 : intval($options[1]) ;
	$num = empty( $options[2] ) ? 10 : intval($options[2]) ;
	$field = empty( $options[3] ) ? 0 : intval($options[3]) ;
	$category = empty( $options[4] ) ? 0 : intval($options[4]) ;
	$this_template = empty( $options[5] ) ? 'db:'.$mydirname.'_block_flatdata.html' : trim( $options[5] ) ;

	$constpref = '_MB_' . strtoupper( $mydirname );

	if( empty($field) ){
		$fields = new flatdataFieldsClass( $mydirname ) ;
		$allfields = $fields->getAllFields() ;
		if( count($allfields)>0 ){
			$field = $allfields[0]['fid'] ;
		}
	}

	//ORDER
	//0=D:regidate DESC, 1=C:regidate ASC, 2=B:DID DESC, 3=A:DID ASC, 4=R:random, 5=F:hits DESC, 6=E:hits ASC
	$order_arr = array(0=>'D',1=>'C',2=>'B',3=>'A',4=>'R',5=>'F',6=>'E') ;
	$ord = ( isset($order_arr[$order]) ) ? $order_arr[$order] : "D" ;
	/*switch( $order ){
		case 0:
			$ord = "D" ;
			break;
		case 1:
			$ord = "C" ;
			break;
		case 2:
			$ord = "B" ;
			break;
		case 3:
			$ord = "A" ;
			break;
		case 4:
			$ord = "R" ;
			break;
		case 5:
			$ord = "F" ;
			break;
		case 6:
			$ord = "E" ;
			break;
		default:
			$ord = "D" ;
	}*/

	$flatdata = new Flatdata( $mydirname ) ;
	$flatdata->setOrder($ord) ;
	$datas = $flatdata->getDatas( array($field) , $num );

	//category(XCAT)
	$catTitleArr = NULL ;
	if( $category==1 ){
		$handler =& xoops_gethandler('config');
		$moduleConfig =& $handler->getConfigsByDirname( $mydirname );
		if( defined('XOOPS_CUBE_LEGACY') && /*$moduleConfig['use_xcat'] &&*/ $moduleConfig['xcat_cat_gr']>0 && file_exists(XOOPS_ROOT_PATH."/modules/xcat/xoops_version.php") ){
			$root =& XCube_Root::getSingleton();
			$service = $root->mServiceManager->getService("Xcat_CatService");
			$client = $root->mServiceManager->createClient($service);
			$catTitleArr = $client->call('getTitleList', array('gr_id'=>intval($moduleConfig['xcat_cat_gr'])));
		}
	}

	if(count($datas)>0){
		$block = array() ;
		$block['datas'] = $datas ;
		if( empty( $options['disable_renderer'] ) ) {
			require_once XOOPS_ROOT_PATH.'/class/template.php' ;
			$tpl =& new XoopsTpl() ;
			$tpl->assign( 'block' , $block ) ;
			$tpl->assign( 'field' , $field ) ;
			$tpl->assign( 'catTitleArr' , $catTitleArr ) ;
			$tpl->assign( 'myurl' , XOOPS_URL."/modules/$mydirname" ) ;
			$ret['content'] = $tpl->fetch( $this_template ) ;
			return $ret ;
		} else {
			$block['field'] = $field ;
			$block['catTitleArr'] = $catTitleArr ;
			return $block ;
		}
	}

  }

}//END IF



if( ! function_exists( 'b_flatdata_top_edit' )) {

	function b_flatdata_top_edit($options) {
		//global $xoopsDB;
		$mydirname = empty( $options[0] ) ? basename(dirname(dirname(__FILE__))) : $options[0] ;
		$order = empty( $options[1] ) ? 0 : intval($options[1]) ;
		$num = empty( $options[2] ) ? 10 : intval($options[2]) ;
		$field = empty( $options[3] ) ? '' : trim($options[3]) ;
		$category = empty( $options[4] ) ? 0 : intval($options[4]) ;
		$this_template = empty( $options[5] ) ? 'db:'.$mydirname.'_block_flatdata.html' : trim( $options[5] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		//ORDER
		$ocheck0 = $ocheck1 = $ocheck2 = $ocheck3 = $ocheck4 = $ocheck5 = $ocheck6 = '' ;
		$ochk = "ocheck$order" ;
		$$ochk = "CHECKED='CHECKED'" ;

		//field
		$fields = new flatdataFieldsClass( $mydirname ) ;
		$allfields = $fields->getAllFields();
		$fieldselect = "<select name='options[3]'>" ;
			foreach( $allfields as $f ){
				$fieldselect.= "<option value='".$f['fid']."'>".$f['fname']."</option>" ;
			}
		$fieldselect.= "</select>" ;

		//category
		$option_cat0 = $option_cat1 = '' ;
		$option_c = "option_cat".$category ;
		$$option_c = "CHECKED='CHECKED'" ;

		$form = "
			<input type='hidden' name='options[0]' value='".htmlspecialchars($mydirname,ENT_QUOTES)."' />
			". _MB_FLATDATA_ORDER ."
			<input type='radio' name='options[1]' value='0' $ocheck0 /> ". _MB_FLATDATA_ORDER_DATE_DESC ."&nbsp;
			<input type='radio' name='options[1]' value='1' $ocheck1 /> ". _MB_FLATDATA_ORDER_DATE_ASC ."&nbsp;
			<input type='radio' name='options[1]' value='2' $ocheck2 /> ". _MB_FLATDATA_ORDER_ID_DESC ."&nbsp;
			<input type='radio' name='options[1]' value='3' $ocheck3 /> ". _MB_FLATDATA_ORDER_ID_ASC ."&nbsp;
			<input type='radio' name='options[1]' value='4' $ocheck4 /> ". _MB_FLATDATA_ORDER_RANDOM ."&nbsp;
			<input type='radio' name='options[1]' value='5' $ocheck5 /> ". _MB_FLATDATA_ORDER_HITS_DESC ."&nbsp;
			<input type='radio' name='options[1]' value='6' $ocheck6 /> ". _MB_FLATDATA_ORDER_HITS_ASC ."&nbsp;
			<br />
			". _MB_FLATDATA_DISP ."
			<input type='text' name='options[2]' value='$num' /><br />
			". _MB_FLATDATA_FIELD ."
			$fieldselect
			<br />
			". _MB_FLATDATA_CATEGORY ."
			<input type='radio' name='options[4]' value='1' $option_cat1 />". _YES ."&nbsp;
			<input type='radio' name='options[4]' value='0' $option_cat0 />". _NO ."&nbsp;
			<br />
			". _MB_FLATDATA_TEMPLATE ."
			<input type='text' size='60' name='options[5]' value='".htmlspecialchars($this_template,ENT_QUOTES)."' />
			<br />\n" ;

		return $form;
	}

}//END IF

//-- category block -------------------------------------------------------------
if( ! function_exists( 'b_flat_categ_show' )) {
	function b_flatdata_categ_show($options) {
		$mydirname = empty( $options[0] ) ? basename(dirname(dirname(__FILE__))) : $options[0] ;
		$count = empty( $options[1] ) ? 0 : $options[1] ;
		$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_flatdata.html' : trim( $options[2] ) ;

		$handler =& xoops_gethandler('config');
		$moduleConfig =& $handler->getConfigsByDirname( $mydirname );
		
		//category(XCAT)
		$cattree = NULL ;
		if( defined('XOOPS_CUBE_LEGACY') && /*$moduleConfig['use_xcat'] &&*/ $moduleConfig['xcat_cat_gr']>0 && file_exists(XOOPS_ROOT_PATH."/modules/xcat/xoops_version.php") ){
			$root =& XCube_Root::getSingleton();
			$service = $root->mServiceManager->getService("Xcat_CatService");
			$client = $root->mServiceManager->createClient($service);
			$cattree = $client->call('getTree', array('gr_id'=>intval($moduleConfig['xcat_cat_gr'])));
		}

		$countByCat = NULL ;
		if( $cattree && $count ){
			$flatdata = new Flatdata( $mydirname ) ;
			$countByCat = $flatdata->countByCategory($cattree,true);
		}

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl =& new XoopsTpl() ;
		$tpl->assign( 'cattree' , $cattree ) ;
		$tpl->assign( 'countByCat' , $countByCat ) ;
		$tpl->assign( 'myurl' , XOOPS_URL."/modules/$mydirname" ) ;
		$ret['content'] = $tpl->fetch( $this_template ) ;
		return $ret ;
	}
}

if( ! function_exists( 'b_flatdata_categ_edit' )) {
	function b_flatdata_categ_edit($options) {
		$mydirname = empty( $options[0] ) ? basename(dirname(dirname(__FILE__))) : $options[0] ;
		$count = empty( $options[1] ) ? 0 : intval($options[1]) ;
		$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_fd_categ.html' : trim( $options[2] ) ;

		//category count option
		$option_cbc0 = $option_cbc1 = '' ;
		$option = "option_cbc".$count ;
		$$option = "CHECKED='CHECKED'" ;

		$form = "
			<input type='hidden' name='options[0]' value='".htmlspecialchars($mydirname,ENT_QUOTES)."' />
			". _MB_FLATDATA_COUNTBYCAT ."
			<input type='radio' name='options[1]' value='0' $option_cbc0 />". _NO ."
			<input type='radio' name='options[1]' value='1' $option_cbc1 />". _YES ."<br />\n
			". _MB_FLATDATA_TEMPLATE ."
			<input type='text' size='60' name='options[2]' value='".htmlspecialchars($this_template,ENT_QUOTES)."' />
			<br />\n" ;
		return $form;
	}
}

?>
