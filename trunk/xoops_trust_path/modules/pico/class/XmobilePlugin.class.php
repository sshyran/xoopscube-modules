<?php

//////////////////////////////////////////////////////////////////////////
class XmobilePicoPluginAbstract extends XmobilePlugin
{
	function __construct( $mydirname )
	{
		// call parent constructor
		XmobilePlugin::XmobilePlugin();

		// define object elements
		$this->initVar('content_id', XOBJ_DTYPE_INT, 0 , true);
		$this->initVar('vpath', XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar('cat_id', XOBJ_DTYPE_INT, 0 , true);
		$this->initVar('weight', XOBJ_DTYPE_INT, 0 , true);
		$this->initVar('created_time', XOBJ_DTYPE_INT, 0 , true ) ;
		$this->initVar('modified_time', XOBJ_DTYPE_INT, 0 , true ) ;
		$this->initVar('poster_uid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('modifier_uid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('subject', XOBJ_DTYPE_TXTBOX, '', true, 255);
		$this->initVar('visible', XOBJ_DTYPE_INT, 1 , true ) ;
		$this->initVar('viewed', XOBJ_DTYPE_INT, 0 , true ) ;
		$this->initVar('filters', XOBJ_DTYPE_TXTBOX, '', true, 255 ) ;
		$this->initVar('comments_count', XOBJ_DTYPE_INT, 0 , true ) ;
		$this->initVar('body', XOBJ_DTYPE_TXTAREA, '', true);

		// define primary key
		$this->setKeyFields(array('content_id'));
		$this->setAutoIncrementField('content_id');
	}
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
class XmobilePicoPluginHandlerAbstract extends XmobilePluginHandler
{
	var $mydirname = '' ;
	var $mytrustdirname = 'pico' ;
	var $cat_ids_can_read ;
	var $category_permissions ;
	var $is_module_top = false ;

  ////////////////////////////////////////////////////////////////////////
	function __construct( $mydirname , $db )
	{
		XmobilePluginHandler::XmobilePluginHandler( $db ) ;
		if( ! preg_match( '/^[a-zA-Z0-9_-]+$/' , $mydirname ) ) {
			trigger_error( 'invalid plugin name' , E_USER_ERROR ) ;
		}

		// module parameters
		$this->mydirname = $mydirname ;
		$this->moduleDir = $mydirname ;
		$this->categoryTableName = $mydirname . '_categories' ;
		$this->itemTableName = $mydirname . '_contents' ;

		// category parameters
		$this->category_id_fld = 'cat_id';
		$this->category_pid_fld = 'pid';
		$this->category_title_fld = 'cat_title';
		$this->category_order_fld = 'cat_weight';
		$this->category_criteria = null;

		// item parameters
		$this->item_id_fld = 'content_id';
		$this->item_cid_fld = 'cat_id';
		$this->item_title_fld = 'subject';
		$this->item_description_fld = 'body';
		$this->item_order_fld = 'weight';
		$this->item_date_fld = 'created_time';
		$this->item_uid_fld = 'poster_uid';
		$this->item_hits_fld = 'viewed';
		$this->item_comments_fld = 'comments_count';
		$this->item_extra_fld = array();
		$this->item_order_sort = 'ASC';
		$this->item_criteria = null;

	}
  ////////////////////////////////////////////////////////////////////////
	function prepare(&$controller)
	{
		parent::prepare($controller) ;

		// permissions
		$this->cat_ids_can_read = pico_common_get_categories_can_read( $this->mydirname , $this->sessionHandler->uid ) ;
		$this->category_permissions = pico_main_get_category_permissions_of_current_user( $this->mydirname , $this->sessionHandler->uid ) ;
	}
  ////////////////////////////////////////////////////////////////////////
	function setCategoryCriteria()
	{
		$this->category_criteria =& new CriteriaCompo();
		$this->category_criteria->add( new Criteria( 'cat_id' , '('.implode(',',$this->cat_ids_can_read).')' , 'IN' ) ) ;
	}
  ////////////////////////////////////////////////////////////////////////
	function setItemCriteria()
	{
		$this->item_criteria =& new CriteriaCompo();
		$this->item_criteria->add( new Criteria('created_time', time(), '<=') ) ;
		$this->item_criteria->add( new Criteria('visible', 1) ) ;
		$this->item_criteria->add( new Criteria( 'cat_id' , '('.implode(',',$this->cat_ids_can_read).')' , 'IN' ) ) ;
		if( ! empty( $this->is_module_top ) ) {
			$this->item_criteria->add( new Criteria( 'cat_id', 0 ) ) ;
		}
		$this->item_criteria->setSort($this->item_order_fld);
		$this->item_criteria->setOrder($this->item_order_sort);
		// ignore module setting (bug?)
		$GLOBALS['xoopsModuleConfig']['title_order_sort'] = null ;
	}
  ////////////////////////////////////////////////////////////////////////
	function getDefaultView()
	{
		parent::getDefaultView() ;

		$this->is_module_top = true ;

		// clear recent item list
		// $this->controller->render->template->assign('recent_item_list','');

		// append item list in cat_id=0 only if contents exists just under 0
		$item_list = $this->getItemList() ;
		if( $item_list ) {
			$this->controller->render->template->assign('item_list',$item_list) ;
			$this->controller->render->template->assign('item_list_page_navi',$this->itemListPageNavi->renderNavi());
		} else {
			$this->controller->render->template->assign('lang_no_item_list','') ;
		}
	}
  ////////////////////////////////////////////////////////////////////////
  // full override
	function getItemDetail()
	{
		// debug
		$this->utils->setDebugMessage(__CLASS__, 'getItemDetail criteria', $this->item_criteria->render());
		// 一意のidではなくcriteriaで検索する為、オブジェクトの配列が返される
		if(!$itemObjectArray = $this->getObjects($this->item_criteria))
		{
			// debug
			$this->utils->setDebugMessage(__CLASS__, 'getItemDetail Error', $this->getErrors());
		}

		$itemObject = @$itemObjectArray[0];

		if(!is_object($itemObject))
		{
			return false;
		}

		$this->item_id = $itemObject->getVar($this->item_id_fld);
		$url_parameter = $this->getBaseUrl();
		//$itemObject->assignSanitizerElement();

		$detail4html = '';
		$detail4html .= _MD_XMOBILE_ITEM_DETAIL.'<br />';
		// タイトル
		if(!is_null($this->item_title_fld))
		{
			$detail4html .= _MD_XMOBILE_TITLE;
			$detail4html .= $itemObject->getVar($this->item_title_fld).'<br />';
		}
		// ユーザ名
		if(!is_null($this->item_uid_fld))
		{
			$uid = $itemObject->getVar($this->item_uid_fld);
			$uname = $this->getUserLink($uid);
			$detail4html .= _MD_XMOBILE_CONTRIBUTOR.$uname.'<br />';
		}
		// 日付・時刻
		if(!is_null($this->item_date_fld))
		{
			$date = $itemObject->getVar($this->item_date_fld);
			$detail4html .= _MD_XMOBILE_DATE.$this->utils->getDateLong($date).'<br />';
			$detail4html .= _MD_XMOBILE_TIME.strftime('%H:%M',$date).'<br />';
		}
		// ヒット数
		if(!is_null($this->item_hits_fld))
		{
			$detail4html .= _MD_XMOBILE_HITS.$itemObject->getVar($this->item_hits_fld).'<br />';
			// ヒットカウントの増加
			$this->increaseHitCount($this->item_id);
		}
		// コメント
		if(!is_null($this->item_comments_fld))
		{
			$detail4html .= _MD_XMOBILE_COMMENT.$itemObject->getVar($this->item_comments_fld).'<br />';
		}
		// 詳細
		if( ! empty( $this->category_permissions[ $this->category_id ]['can_readfull'] ) ) {
			$content4assign = $this->picoGetContent4Assign() ;
			$detail4html .= _MD_XMOBILE_CONTENTS.'<br />';
			$detail4html .= $content4assign['body'].'<br />';
		}

		return $detail4html;
	}
  ////////////////////////////////////////////////////////////////////////
	function getCatList()
	{
		$cat_list = parent::getCatList() ;
		if( ! is_array( $cat_list ) ) return $cat_list ;
		$ret = array() ;
		foreach( $cat_list as $cat ) {
			if( preg_match( '/cat_id\=([0-9]+)$/' , $cat['url'] , $regs ) && in_array( $regs[1] , $this->cat_ids_can_read ) ) {
				$ret[] = $cat ;
			}
		}

		return $ret ;
	}
  ////////////////////////////////////////////////////////////////////////
	function picoGetContent4Assign()
	{
		$db =& Database::getInstance();
		$mydirname = $this->mydirname ;
		$content_id = intval( $this->item_id ) ;
	
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($mydirname);
		$config_handler =& xoops_gethandler('config');
		$configs = $config_handler->getConfigList( $module->mid() ) ;
	
		// categories can be read by current viewer (check by category_permissions)
		$whr_read4content = 'o.`cat_id` IN (' . implode( "," , pico_common_get_categories_can_read( $mydirname , $this->sessionHandler->uid ) ) . ')' ;
	
		$sql = "SELECT o.content_id FROM ".$db->prefix($mydirname."_contents")." o WHERE ($whr_read4content) AND o.content_id='$content_id' AND o.visible AND o.created_time <= UNIX_TIMESTAMP()" ;
		if( ! $result = $db->query( $sql ) ) return array() ;
		if( ! $db->getRowsNum( $result ) ) return array() ;

		list( $content_id ) = $db->fetchRow( $result ) ;

		// assigning
		$content4assign = pico_common_get_content4assign( $mydirname , $content_id , $configs , array() , true ) ;

		// convert links from relative to absolute (wraps mode only)
		if( $configs['use_wraps_mode'] ) {
			$parsed_url = parse_url( XOOPS_URL ) ;
			$path = strlen( @$parsed_url['path'] ) > 1 ? $parsed_url['path'] : '' ;
			$content_url = $path.'/modules/'.$mydirname.'/'.$content4assign['link'] ;
			$wrap_base_url = substr( $content_url , 0 , strrpos( $content_url , '/' ) ) ;
			$pattern = "/(href|src)\=(\"|\')?(?![a-z]+:|\/|\#)([^, \r\n\"\(\)'<>]+)/i" ;
			$replacement = "\\1=\\2$wrap_base_url/\\3" ;
			$content4assign['body'] = preg_replace( $pattern , $replacement , $content4assign['body'] ) ;
		}

		return $content4assign ;
	}



//////////////////////////////////////////////////////////////////////////

}

?>