<?php
//mod:2008.5.30

///////////////////////////////////////////////////////////////////////////////////////////////////
class XmobileCouponsPluginAbstract extends XmobilePlugin
{
	function __construct( $mydirname )
	{
		XmobilePlugin::XmobilePlugin();

		$this->initVar('lid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('cid', XOBJ_DTYPE_TXTBOX, '', true);
		$this->initVar('title', XOBJ_DTYPE_TXTBOX, '', true, 255);
		$this->initVar('starttime', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('endtime', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('uid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('status', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('regidate', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('hits', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('embed', XOBJ_DTYPE_TXTBOX, '', true, 255);

		$this->setKeyFields(array('lid'));
		$this->setAutoIncrementField('lid');
	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////
class XmobileCouponsPluginHandlerAbstract extends XmobilePluginHandler
{
	var $mydirname = '' ;
	var $mytrustdirname = 'coupons' ;

	var $item_id_fld = 'lid';
	var $item_cid_fld = 'cid' ;
	var $item_title_fld = 'title';
	var $item_date_fld = 'regidate';
	var $item_start_fld = 'starttime';
	var $item_end_fld = 'endtime';
	var $item_status_fld = 'status';
	var $item_uid_fld = 'uid';
	var $item_hits_fld = 'hits';
	var $item_embed_fld = 'embed';

	var $category_id_fld = 'cid';
	var $category_pid_fld = 'pid';
	var $category_title_fld = 'title';
	var $category_order_fld = 'corder';

	////////////////////////////////////////////////////////////////////////
	function __construct( $mydirname , $db )
	{
		global $xoopsConfig ;

		XmobilePluginHandler::XmobilePluginHandler($db);
		if( ! preg_match( '/^[a-zA-Z0-9_-]+$/' , $mydirname ) ) {
			trigger_error( 'invalid plugin name' , E_USER_ERROR ) ;
		}
		$this->moduleDir = $mydirname ;
		$this->mydirname = $mydirname ;

		$this->itemTableName = $mydirname .'_coupons';
		$this->textTableName = $mydirname .'_text';
		$this->categoryTableName = $mydirname .'_cat';
		//$this->db = $db ;
	}
	////////////////////////////////////////////////////////////////////////
	function setItemCriteria()
	{
		$this->item_criteria =& new CriteriaCompo();
		$this->item_criteria->add(new Criteria($this->item_status_fld ,0,     '>'));
		$this->item_criteria->add(new Criteria($this->item_start_fld  ,time(),'<'));
		$this->item_criteria->add(new Criteria($this->item_end_fld    ,time(),'>'));
		$this->item_criteria->setSort($this->item_end_fld);
		$this->item_criteria->setOrder('ASC');
	}

	function getItemList()
	{
		$this->setNextViewState('detail');
		//$this->setBaseUrl();
		$this->setItemParameter();
		$this->setItemListPageNavi();

		// debug
		$this->utils->setDebugMessage(__CLASS__, 'getList criteria', $this->item_criteria->render());

		$itemObjectArray = $this->getObjects($this->item_criteria);
		if (!$itemObjectArray)
		{
			// debug
			$this->utils->setDebugMessage(__CLASS__, 'getList Error', $this->getErrors());
		}

		if (count($itemObjectArray) == 0) // 表示するデータ無し
		{
			$this->controller->render->template->assign('lang_no_item_list',_MD_XMOBILE_NO_DATA);
			return false;
		}

		$item_list = array();
		$i = 1 ;
		foreach($itemObjectArray as $itemObject)
		{
			$id = $itemObject->getVar($this->item_id_fld);
			$title = $itemObject->getVar($this->item_title_fld);
			$url_parameter = XOOPS_URL."/modules/".$this->moduleDir."/index.php?page=mobile&amp;lid=".$id ;
			$date = '';
			if (!is_null($this->item_date_fld))
			{
				$date = strftime('%Y-%m-%d',$itemObject->getVar($this->item_date_fld));
			}
			$item_list[$i]['key'] = $i ; // アクセスキー用の番号、1から開始
			$item_list[$i]['title'] = $this->adjustTitle($title);
			$item_list[$i]['url'] = $url_parameter;
			$item_list[$i++]['date'] = $date;
		}
		return $item_list;
	}

	function getRecentList()
	{
		global $xoopsModuleConfig;

		if ($xoopsModuleConfig['show_recent_title'] == 0)
		{
			return false;
		}

		$this->setNextViewState('detail');
		//$this->setBaseUrl();
		$this->setItemParameter();
		if (!is_null($this->item_date_fld))
		{
			$this->item_criteria->setSort($this->item_date_fld);
			$this->item_criteria->setOrder('DESC');
			$this->item_criteria->setLimit($xoopsModuleConfig['recent_title_row']);
		}

		// debug
		$this->utils->setDebugMessage(__CLASS__, 'getRecentList criteria', $this->item_criteria->render());

		if (!$itemObjectArray = $this->getObjects($this->item_criteria))
		{
			$this->utils->setDebugMessage(__CLASS__, 'getRecentlist Error', $this->getErrors());
		}

		if (count($itemObjectArray) == 0) // 表示するデータ無し
		{
			$this->controller->render->template->assign('lang_no_item_list',_MD_XMOBILE_NO_DATA);
			return false;
		}

		$recent_list = array();
		$i = 1 ;
		foreach($itemObjectArray as $itemObject)
		{
			$id = $itemObject->getVar($this->item_id_fld);
			$title = $itemObject->getVar($this->item_title_fld);
			$url_parameter = XOOPS_URL."/modules/".$this->moduleDir."/index.php?page=mobile&amp;lid=".$id ;
			$date = '';
			if (!is_null($this->item_date_fld))
			{
				$date = strftime('%Y-%m-%d %H:%M',$itemObject->getVar($this->item_date_fld));
			}
			$recent_list[$i]['key'] = $i ;
			$recent_list[$i]['title'] = $this->adjustTitle($title);
			$recent_list[$i]['url'] = $url_parameter;
			$recent_list[$i++]['date'] = $date;
		}
		return $recent_list;
	}

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

		if(count($itemObjectArray) == 0) // 表示するデータ無し
		{
			$this->controller->render->template->assign('lang_no_item_list',_MD_XMOBILE_NO_DATA);
			return false;
		}

		$itemObject = $itemObjectArray[0];

		if(!is_object($itemObject))
		{
			return false;
		}

		$this->item_id = $itemObject->getVar($this->item_id_fld);
		$rURL = XOOPS_URL ."/modules/". $this->moduleDir ."/index.php?page=mobile&lid=". $this->item_id ;
		header('Location: '.$rURL);
		exit();
	}

}

?>