<?php

///////////////////////////////////////////////////////////////////////////////////////////////////
class XmobileMiniamazonPluginAbstract extends XmobilePlugin
{
	function __construct( $mydirname )
	{
		// call parent constructor
		XmobilePlugin::XmobilePlugin();
		// define object elements
		$this->initVar('lid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('cid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('uid', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('description', XOBJ_DTYPE_TXTAREA, '', true);
		$this->initVar('stats', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('regdate', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('clicks', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('ASIN', XOBJ_DTYPE_TXTBOX, '', true, 20);
		$this->initVar('title', XOBJ_DTYPE_TXTBOX, '', true, 255);
		$this->initVar('MediumImage', XOBJ_DTYPE_TXTBOX, '', true, 255);
		$this->initVar('IsAdult', XOBJ_DTYPE_INT, '0', true);
		// define primary key
		$this->setKeyFields(array('lid'));
		$this->setAutoIncrementField('lid');
	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////
class XmobileMiniamazonPluginHandlerAbstract extends XmobilePluginHandler
{
	var $mytrustdirname = 'miniamazon' ;

	var $category_id_fld = 'cid';
	var $category_pid_fld = 'pid';
	var $category_title_fld = 'ctitle';
	var $category_order_fld = 'cid';

	var $item_id_fld = 'lid';
	var $item_cid_fld = 'cid';
	var $item_title_fld = 'title';
	var $item_date_fld = 'regdate';
	var $item_uid_fld = 'uid';
	var $item_hits_fld = 'clicks';
	var $item_desc_fld = 'description';
	var $item_asin_fld = 'ASIN';
	var $item_adult_fld = 'IsAdult';
	var $item_image_fld = 'MediumImage';

	var $item_order_fld = 'regdate';
	var $item_order_sort = 'DESC';
	////////////////////////////////////////////////////////////////////////
	function __construct( $mydirname , $db )
	{
		global $xoopsConfig ;

		XmobilePluginHandler::XmobilePluginHandler($db);
		if( ! preg_match( '/^[a-zA-Z0-9_-]+$/' , $mydirname ) ) {
			trigger_error( 'invalid plugin name' , E_USER_ERROR ) ;
		}
		$this->moduleDir = $mydirname ;
		$this->categoryTableName = $mydirname .'_cat';
		$this->itemTableName = $mydirname .'_items';
		//module config
		$module_handler =& xoops_gethandler('module');
		$xoopsModule =& $module_handler->getByDirname($mydirname);
		$config_handler = & xoops_gethandler('config');
		$moduleConfig = & $config_handler->getConfigsByCat( 0, $xoopsModule->getVar('mid') );
		$this->comment_allow = $moduleConfig['comment_allow'];
		$this->comment_dirname = $moduleConfig['comment_dirname'];
		$this->comment_forum_id = $moduleConfig['comment_forum_id'];
		//language
		$this->language = $xoopsConfig['language'];
	//global $xoopsUser;
	//if( $xoopsUser ) var_dump($mydirname);
	}
	////////////////////////////////////////////////////////////////////////
	function setItemCriteria()
	{
		$this->item_criteria =& new CriteriaCompo();
		$this->item_criteria->add(new Criteria('stats',0,'>'));
	}
	////////////////////////////////////////////////////////////////////////
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
		$url_parameter = $this->getBaseUrl();

		$detail4html = '';
		$detail4html .= _MD_XMOBILE_ITEM_DETAIL.'<br />';
		$id      = $itemObject->getVar($this->item_id_fld);
		$isadult = $itemObject->getVar($this->item_adult_fld) ;
		$asin    = $itemObject->getVar($this->item_asin_fld);
		$asso_id = $this->moduleConfig['associate_id'];

		//amazon mobile URL
		$aUrl = "";
		if( !empty($asin) && !empty($asso_id) ){
			$aUrl = "http://www.amazon.co.jp/gp/aw/rd.html?ie=UTF8&dl=1&uid=NULLGWDOCOMO&lc=msn&a={$asin}&at={$asso_id}&url=%2Fgp%2Faw%2Fd.html";
		}
		
		// タイトル
		$title = '';
		if(!is_null($this->item_title_fld))
		{
			$detail4html .= _MD_XMOBILE_TITLE;
			$title = $itemObject->getVar($this->item_title_fld);
			$title = $this->cutString($title) ;
			if( empty($aUrl) ){
				$detail4html .= $title .'<br />';
			}else{
				$detail4html .= '<a href="'. $aUrl.'">'.$title .'</a><br />';
			}
		}
		// ユーザ名
		if(!is_null($this->item_uid_fld))
		{
			$uid = $itemObject->getVar($this->item_uid_fld);
			$uname = $this->getUserLink($uid);
			$detail4html .= _MD_XMOBILE_CONTRIBUTOR . $uname.'<br />';
		}
		// 日付・時刻
		if(!is_null($this->item_date_fld))
		{
			$date = $itemObject->getVar($this->item_date_fld);
			$detail4html .= _MD_XMOBILE_LASTUPDATED_DATE.strftime('%Y-%m-%d %H:%M',$date).'<br />';
		}
		
		if( !empty($this->comment_allow) && !empty($this->comment_dirname) && !empty($this->comment_forum_id) && !isset($_GET['comid']) ){
			// ヒット数
			if(!is_null($this->item_hits_fld))
			{
				$detail4html .= _MD_XMOBILE_HITS . $itemObject->getVar($this->item_hits_fld).'<br />';
				// ヒットカウントの増加
				$this->increaseHitCount($this->item_id);
			}

			// 画像の表示
			$image = $itemObject->getVar($this->item_image_fld);
			if(!is_null($asin))
			{
				if( $isadult ){
					$imgurl = XOOPS_URL."/modules/".$this->moduleDir."/images/warning40.gif";
				}else{
					if( empty($image) ){
						$imgurl = XOOPS_URL."/modules/".$this->moduleDir."/images/noimage40.gif";
					}else{
						$imgurl = "http://images.amazon.com/images/P/{$asin}.09.THUMBZZZ.jpg";
					}
				}
				$detail4html .= '<img src="'. $imgurl .'" /><br />';
			}
		
			// descriptin
			if(!is_null($this->item_desc_fld))
			{
				$desc = $itemObject->getVar($this->item_desc_fld);
				if( !empty($desc) ){
					$detail4html .= _MD_XMOBILE_CONTENTS.'<br />';
					$detail4html .= strip_tags($desc) .'<br />';
				}
			}
			else
			{
				// debug
				$this->utils->setDebugMessage(__CLASS__, 'myalbumDescObject Error', $myalbumDescHandler->getErrors());
			}
		}

		//comment integration
		if( !empty($this->comment_allow) && !empty($this->comment_dirname) && !empty($this->comment_forum_id) ){
			require_once( XOOPS_TRUST_PATH.'/modules/'. $this->mytrustdirname .'/include/xmobile_comment_functions.php' ) ;
			require_once( XOOPS_TRUST_PATH.'/modules/'. $this->mytrustdirname .'/language/'. $this->language .'/main.php' ) ;
			$params = array( 
				'dirname'        => $this->moduleDir ,
				'link_id'        => $this->item_id ,
				'id'             => $this->item_id ,
				'subject'        => $title ,
				'class'          => 'maD3commentContent' ,
				'mytrustdirname' => $this->mytrustdirname ,
			 );
			$datas = xm_d3forum_display_comment( $this->comment_dirname , $this->comment_forum_id , $params  ) ;
			$com_posts = $datas[0];
			if( count($com_posts) > 0 ){
				$baseurl  = XOOPS_URL ."/modules/xmobile/?act=plugin&amp;view=detail&amp;plg=". $this->moduleDir ;
				$baseurl .= "&amp;lid=". $this->item_id ."&amp;cid=". $itemObject->getVar($this->item_cid_fld);
				$pagePerItem = 3 ;
				$counter = count($com_posts) ;
				$pageNum = isset($_GET['cp']) ? intval($_GET['cp'])-1 : 0 ; 
				if( isset($_GET['comid']) ){ 
					$post = $datas[1][$_GET['comid']];
					//var_dump($post);
					$pageNum = intval($post['sno']/$pagePerItem);
					$_GET['cp'] = $pageNum+1;
				}
				$start = $pageNum * $pagePerItem ;
				$end = $start + $pagePerItem ;
				$end = ( $end>$counter ) ? $counter : $end ;
				
				$detail4html .= "<hr />Comment(". $counter .")<br />" ;
				//comment page navi
				if( count($com_posts)>$pagePerItem ){
					$cPageNum = ceil(count($com_posts)/$pagePerItem);
					for( $i=0 ; $i<$cPageNum ; $i++ ){
						$page = $i+1;
						if( !isset($_GET['cp']) && $page==1 ){
							$detail4html .= "<b>(1)</b> ";
						}elseif( @$_GET['cp']==$page ){
							$detail4html .= "<b>(". $page .")</b> ";
						}else{
							$detail4html .= "<a href='{$baseurl}&amp;cp={$page}'>". $page ."</a> ";
						}
					}
					$detail4html .= "<br />";
				}
				//comment list
				$itemNum = $counter - $pageNum * $pagePerItem ;
				for( $i=$start ; $i<$end ; $i++ ){
					$detail4html .= ( $com_posts[$i]['id']==@$_GET['comid'] ) ? _MD_MINIAMAZON_XM_CURRENT : _MD_MINIAMAZON_XM_COM_ITEM ;
					$detail4html .= $itemNum . '- ';
					$detail4html .= "<a href='{$baseurl}&amp;comid=". $com_posts[$i]['id'] ;
					if( isset($_GET['cp']) ) $detail4html .="&amp;cp=". intval($_GET['cp']) ;
					$detail4html .= "'>";
					$detail4html .= $this->cutString($com_posts[$i]['subject']) ;
					$detail4html .= "</a><br />";
					$itemNum--;
				}
				//comment 
				if( isset($_GET['comid']) ){
					if(isset($datas[1][$_GET['comid']])) {
						$post = $datas[1][$_GET['comid']];
						$detail4html .= " <br />";
						$detail4html .= $this->cutString($post['subject'],30) ."<br />";
						  $postname = empty($post['guest_name']) ? $post['guest_name'] : $post['poster_uname'] ;
						  $postname = empty($postname) ? _GUESTS : $postname ;
						$detail4html .= _MD_XMOBILE_CONTRIBUTOR . $postname ."<br />";
						$detail4html .= _DATE . $post['post_time_formatted'] ."<br />";
						  $post_text = strip_tags($post['post_text']);
						  $myts =& MyTextSanitizer::getInstance();
						  $post_text = $myts->nl2Br($post_text);
						  $post_text = preg_replace( '/(<br \/>){2,}/' , '<br />' , $post_text ) ;
						$detail4html .= $post_text ."<br />";
						//parent
						if( $post['pid']>0 ){
							$detail4html .= " - ". _MD_MINIAMAZON_XM_PARENT ;
							$detail4html .= "<a href='{$baseurl}&amp;comid=". $post['pid'] ;
							$detail4html .= "'>". _MD_MINIAMAZON_XM_PARENT_I ."</a><br />";
						}
						//child
						if( isset($datas[2][$_GET['comid']]) && count($datas[2][$_GET['comid']])>0){
							$detail4html .= " - ". _MD_MINIAMAZON_XM_CHILD ;
							$children = $datas[2][$_GET['comid']];
							for( $i=0 ; $i<count($children); $i++ ){
								$detail4html .= "<a href='{$baseurl}&amp;comid=". $children[$i] ;
								$detail4html .= "'>". _MD_MINIAMAZON_XM_CHILD_I ."</a> ";
							}
							$detail4html .= "<br />" ;
						}
						//Previous and Next
						if( count($com_posts)>1 ){
							$detail4html .= " - " ;
							$detail4html .= ( $post['sno']==0 ) ? '' : "<a href='{$baseurl}&amp;comid=". $com_posts[ $post['sno']-1 ]['id'] . "'>". _MD_MINIAMAZON_XM_PREVIOUS ."</a> " ;
							$detail4html .= ( $post['sno']==(count($com_posts)-1) ) ? '' : "<a href='{$baseurl}&amp;comid=". $com_posts[ $post['sno']+1 ]['id'] . "'>". _MD_MINIAMAZON_XM_NEXT ."</a> " ;
						}
					}
				}
			}
		}

		return $detail4html;
	}
	////////////////////////////////////////////////////////////////////////
	function cutString( $title , $num=20 ){
		if( function_exists('mb_strlen') && function_exists('mb_strcut') ){
			if( mb_strlen($title)>intval($num/2) ) $title = mb_strcut($title,0,$num).'..';
		}else{
			if( strlen($title)>intval($num) ) $title = substr($title,0,$num).'..';
		}
		return $title ;
	}
	////////////////////////////////////////////////////////////////////////
	//カテゴリ一覧の取得	//戻り値は配列
	function getCatList()
	{
		$this->setNextViewState('list');
		$this->setBaseUrl();
		$this->setCategoryParameter();

		if(!is_null($this->category_pid_fld) || is_null($this->category_id))
		{
			$categoryArray = $this->categoryTree->getFirstChild($this->category_id);
		}
		else
		{
			$categoryArray = false;
		}

		// カテゴリのパンくずを表示
		if( @$_GET['cid']=="0" ){
			$this->controller->render->template->assign('cat_path','<a href="'.XOOPS_URL.'/modules/xmobile/?act=plugin&amp;view=list&amp;plg=miniamazon&amp;cid=0">NONE</a><br />');
			$categoryArray = false;
		}else{
			$this->controller->render->template->assign('cat_path',$this->getCatPathFromId($this->category_id));
		}

		if(!is_array($categoryArray))
		{
			return false;
		}

		$subcategory_count = count($categoryArray);
		if($subcategory_count == 0) // 表示するデータ無し
		{
			return false;
		}

		if(!is_null($this->category_id))
		{
			$item_count = $this->getItemCountById();
		}
		else
		{
			$item_count = 0;
		}

		if($item_count > 0)
		{
			$use_accesskey = false;
		}
		else
		{
			$use_accesskey = true;
		}

		// debug
		$this->utils->setDebugMessage(__CLASS__, 'getCatList subcategory_count', $subcategory_count);
		$this->utils->setDebugMessage(__CLASS__, 'getCatList item_count', $item_count);

		$cat_list = array();
		$i = 0;
		$number = 1 ;// アクセスキー用の番号、1から開始
		foreach($categoryArray as $category)
		{
			$id = $category[$this->category_id_fld];
			$title = $category[$this->category_title_fld];
			$url_parameter = $this->getBaseUrl();

			if(!is_null($this->category_pid_fld))
			{
				$pid = $category[$this->category_pid_fld];
				$url_parameter .= '&amp;'.$this->category_pid_fld.'='.$pid;
			}
			if(!is_null($this->category_id_fld))
			{
				$url_parameter .= '&amp;'.$this->category_id_fld.'='.$id;
			}
			$cat_list[$i]['key'] = $number;
			$cat_list[$i]['title'] = $this->adjustTitle($title);
			$cat_list[$i]['url'] = $url_parameter;
			$cat_list[$i]['item_count'] = sprintf(_MD_XMOBILE_NUMBER, $this->getChildItemCountById($id));
			$i++;
			$number++;
		}

		//category none
		if( !isset($_GET['pid']) ){
			$this->setItemCriteria();
			$criteria =& $this->item_criteria;
			$criteria->add(new Criteria($this->item_cid_fld,0,'='));
			$itemCount = $this->getCount($criteria);
			if( $itemCount > 0 ){
				$url_parameter = $this->getBaseUrl();
				$url_parameter .= /*'&amp;'.$this->category_pid_fld.'=0'.*/ '&amp;'.$this->category_id_fld.'=0';
				$cat_list[$i]['key'] = $number;
				$cat_list[$i]['title'] = "NONE";
				$cat_list[$i]['url'] = $url_parameter;
				$cat_list[$i]['item_count'] = sprintf( _MD_XMOBILE_NUMBER , $itemCount );
			}
		}
		
		return $cat_list;
	}
	////////////////////////////////////////////////////////////////////////
	function addItemCriteria()
	{
		global $xoopsModuleConfig;
		if(!is_object($this->item_criteria))
		{
			return;
		}
		if(!is_null($this->item_cid_fld) && !is_null($this->category_id) && ($this->category_id != 0 ||@$_GET['cid']=="0") )//NE+
		{
			$this->item_criteria->add(new Criteria($this->item_cid_fld, $this->category_id));
		}
		if(!is_null($this->item_order_fld))
		{
			$this->item_criteria->setSort($this->item_order_fld);
		}
		if(is_null($this->item_order_sort))
		{
			$this->item_order_sort = $xoopsModuleConfig['title_order_sort'];
		}
		$this->item_criteria->setOrder($this->item_order_sort);
	}
	////////////////////////////////////////////////////////////////////////
	function getCategoryExtraArg()
	{
		// $extraの値はgetLinkUrl()でhtmlspecialchars()を掛けられるので&amp;ではなく&と記述しておく
		$extra = '';
		if(!is_null($this->category_pid_fld) && !is_null($this->category_pid))
		{
			$extra .= '&'.$this->category_pid_fld.'='.$this->category_pid;
		}
		if(!is_null($this->category_id_fld) && !is_null($this->category_id) && @$_GET['cid']=="0" )//NE+
		{
			$extra .= '&'.$this->category_id_fld.'='.$this->category_id;
		}
		$extra = preg_replace('/^\&/','',$extra);
		$category_extra_arg = $this->utils->getLinkUrl($this->controller->getActionState(),$this->controller->getViewState(),$this->controller->getPluginState(),$this->sessionHandler->getSessionID(),$extra);

		return $category_extra_arg;
	}



}
?>