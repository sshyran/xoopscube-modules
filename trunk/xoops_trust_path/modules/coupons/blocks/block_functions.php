<?php

//require_once dirname(dirname(__FILE__))."/include/functions.php" ;
require_once dirname(dirname(__FILE__))."/class/coupons.class.php" ;

//-----------------------------------------------------------------------
if( ! function_exists( 'b_coupons_top_show' )) {

function b_coupons_top_show($options) {
  global $xoopsDB;
  $mydirname = empty( $options[0] ) ? basename(dirname(dirname(__FILE__))) : $options[0] ;
  $order = empty( $options[1] ) ? 0 : intval($options[1]) ;
  $num = empty( $options[2] ) ? 10 : intval($options[2]) ;
  $category = empty( $options[3] ) ? '' : trim($options[3]) ;
  $this_template = empty( $options[4] ) ? 'db:'.$mydirname.'_block_coupons.html' : trim( $options[4] ) ;

  $constpref = '_MB_' . strtoupper( $mydirname );

  //ORDER
  switch( $order ){
    case 0:
      $sql_order = " ORDER BY l.regidate DESC " ;
      break;
    case 1:
      $sql_order = " ORDER BY l.endtime ASC " ;
      break;
    case 2:
      $sql_order = " ORDER BY rand() " ;
      break;
    default:
      $sql_order = "" ;
  }

  //CATEGORY
  $cat_where = "" ;
  if( !empty($category) ){
    $cats = explode( ',' , $category ) ;
    $cats = array_map( 'intval' , $cats ) ;
    foreach( $cats as $cid ){
      if( $cat_where != "" ) $cat_where .= " OR ";
      $cat_where .= " cid=$cid " ;
    }
  }
  if( $cat_where != "" ) $cat_where = " ( $cat_where ) AND " ;

  $coupons = new Coupons( $mydirname ) ;
  $coupons->setWhere( $cat_where .' l.status>0 AND l.starttime<'.time().' AND l.endtime>'.time().' AND ') ;
  $coupons->setOrder( $sql_order ) ;
  $coupon_data = $coupons->getCoupons( 0 , 0 , $num , 0 ) ;

  if(count($coupon_data)>0){
    $block = array() ;
    $block['coupons'] = $coupon_data ;

    if( empty( $options['disable_renderer'] ) ) {
      require_once XOOPS_ROOT_PATH.'/class/template.php' ;
      $tpl =& new XoopsTpl() ;
      $tpl->assign( 'block' , $block ) ;
      $tpl->assign( 'lang_limitdate' , constant($constpref.'_LANG_LIMITDATE') ) ;
      $tpl->assign( 'myurl' , XOOPS_URL."/modules/$mydirname" ) ;
      $ret['content'] = $tpl->fetch( $this_template ) ;
      return $ret ;
    } else {
      return $block ;
    }
  }

}

}//END IF

//OPTION
//0-dir :$mydirname
//1-order : 0=regidate(desc), 1=endtime(asc), 2=random
//2-number : 10
//3-category : empty=default
//4-template

if( ! function_exists( 'b_coupons_top_edit' )) {

  function b_coupons_top_edit($options) {
    global $xoopsDB;
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname(__FILE__))) : $options[0] ;
    $order = empty( $options[1] ) ? 0 : intval($options[1]) ;
    $num = empty( $options[2] ) ? 10 : intval($options[2]) ;
    $category = empty( $options[3] ) ? '' : trim($options[3]) ;
    $this_template = empty( $options[4] ) ? 'db:'.$mydirname.'_block_coupons.html' : trim( $options[4] ) ;

    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

    //ORDER
    $ocheck0 = $ocheck1 = $ocheck2 = '' ;
    $ochk = "ocheck$order" ;
    $$ochk = "CHECKED='CHECKED'";

    $form = "
      <input type='hidden' name='options[0]' value='".htmlspecialchars($mydirname,ENT_QUOTES)."' />
      ". _MB_COUPONS_ORDER ."
      <input type='radio' name='options[1]' value='0' $ocheck0 />". _MB_COUPONS_ORDER_DATE ."&nbsp;
      <input type='radio' name='options[1]' value='1' $ocheck1 />". _MB_COUPONS_ORDER_ENDTIME ."&nbsp;
      <input type='radio' name='options[1]' value='2' $ocheck2 />". _MB_COUPONS_ORDER_RANDOM ."&nbsp;
      <br />
      ". _MB_COUPONS_DISP ."
      <input type='text' name='options[2]' value='$num' /><br />
      ". _MB_COUPONS_CATEGORY ."
      <input type='text' name='options[3]' value='".htmlspecialchars($category,ENT_QUOTES)."' />
      ". _MB_COUPONS_CATEGORY_DESC ."
      <br />
      ". _MB_COUPONS_TEMPLATE ."
      <input type='text' size='60' name='options[4]' value='".htmlspecialchars($this_template,ENT_QUOTES)."' />
      <br />\n" ;

    return $form;
  }

}//END IF
?>
