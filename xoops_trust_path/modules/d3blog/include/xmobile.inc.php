<?php
/**
 * @version $Id: xmobile.inc.php 631 2010-06-23 04:36:31Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// アクセス権限 0：権限なし、1：一覧閲覧許可、2：詳細閲覧許可、4：投稿許可、8：編集許可
if(!defined('XMOBILE_NOPERM')) define('XMOBILE_NOPERM', 0);
if(!defined('XMOBILE_CAN_READ_LIST')) define('XMOBILE_CAN_READ_LIST', 1);
if(!defined('XMOBILE_CAN_READ_DETAIL')) define('XMOBILE_CAN_READ_DETAIL', 2);
if(!defined('XMOBILE_CAN_POST')) define('XMOBILE_CAN_POST', 4);
if(!defined('XMOBILE_CAN_EDIT')) define('XMOBILE_CAN_EDIT', 8);

$mytrustdirpath = dirname(dirname( __FILE__ ));

$pluginName = ucfirst($mydirname);

require dirname(dirname(__FILE__)).'/include/prepend.inc.php';

$myModule = call_user_func(array($mydirname, 'getInstance'));

$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php';
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' );
require_once( $langmanpath );
$langman =& D3LanguageManager::getInstance();
$langman->read( 'main.php' , $mydirname , $mytrustdirname );

if( ! class_exists('XmobileD3blogPluginBase')){

class XmobileD3blogPluginBase extends XmobilePlugin
{
    function XmobileD3blogPluginBase()
    {
        // call parent constructor
        XmobilePlugin::XmobilePlugin();

        // define object elements
        $this->initVar("bid", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("cid", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("title", XOBJ_DTYPE_TXTBOX, null, true, 255, true);
        $this->initVar("excerpt", XOBJ_DTYPE_TXTAREA, null, true);
        $this->initVar("body", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("dohtml", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("dobr", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("groups", XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar("comments", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("counter", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("trackbacks", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("approved", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("notified", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("published", XOBJ_DTYPE_INT, time(), false);
        $this->initVar("modified", XOBJ_DTYPE_INT, time(), false);
        $this->initVar("created", XOBJ_DTYPE_INT, time(), false);
        $this->initVar("uid", XOBJ_DTYPE_INT, 0, true);

        // define primary key
        $this->setKeyFields(array('bid'));
        $this->setAutoIncrementField('bid');

    }

    function assignSanitizerElement()
    {
        $this->initVar('dosmiley',XOBJ_DTYPE_INT,1);
        $this->initVar('doxcode',XOBJ_DTYPE_INT,1);
    }

    function initFormElements()
    {
        if(!$this->isNew())
        {
            $this->assignEditFormElement(array('name'=>'bid','type'=>'hidden','value'=>'bid'));
            $this->_formCaption = _EDIT;
        }
        else
        {
            $this->_formCaption = _CREATE;
        }
        $this->assignEditFormElement(array('name'=>'uid','type'=>'hidden','value'=>'uid'));
        $this->assignEditFormElement(array('name'=>'cid','type'=>'hidden','value'=>'cid'));
        $this->assignEditFormElement(array('name'=>'title','type'=>'text','title'=>_MD_XMOBILE_TITLE, 'value'=>'title', 'size'=>64, 'maxlength'=>255));

        return true;
    }
}

class XmobileD3blogPluginHandlerBase extends XmobilePluginHandler
{
    var $mydirname_ = '';
    var $body_;
    var $moduleDir = '';
    var $categoryTableName = '';
    var $itemTableName = '';

    var $category_id_fld = 'cid';
    var $category_pid_fld = 'pid';
    var $category_title_fld = 'name';
    var $category_order_fld = 'weight';

    var $item_id_fld = 'bid';
    var $item_cid_fld = 'cid';
    var $item_title_fld = 'title';
    var $item_description_fld = 'excerpt';
    var $item_order_fld = 'published';
    var $item_date_fld = 'published';
    var $item_uid_fld = 'uid';
    var $item_hits_fld = 'counter';
    var $item_comments_fld = 'comments';

    var $item_order_sort = 'DESC';

    var $d3blog_perm = 0;
    var $new_id = 0;

    function XmobileD3blogPluginHandlerBase($db)
    {
        XmobilePluginHandler::XmobilePluginHandler($db);
        $this->mydirname_ = '';
        if(!preg_match("/^\w+$/", $this->mydirname_))
        {
            trigger_error('Invalid pluginName');
            exit();
        }
        $this->moduleDir = $this->mydirname_;
        $this->categoryTableName = $this->moduleDir.'_category';
        $this->itemTableName = $this->moduleDir.'_entry';
        $this->ticket = new XoopsGTicket;
        $this->d3blog_perm = 0;
    }

    function setModulePerm($gperm_name='module_read')
    {
        $user =& $this->sessionHandler->getUser();

        $pluginState = $this->controller->getPluginState();
        if($pluginState == 'default')
        {
            $this->modulePerm = true;
        }
        else
       {
            $this->modulePerm = $this->utils->getModulePerm($user, $this->mid, $gperm_name);
            if($this->modulePerm && !$this->d3blogPerm($user, 'blog_perm_view'))
            {
                $this->modulePerm = false;
            }
        }
        $this->d3blog_perm = ($this->modulePerm)? 1 : 0;
        if($this->d3blog_perm && $this->d3blogPerm($user, array('blog_perm_edit', 'blog_editor'))) {
            $this->d3blog_perm = XMOBILE_CAN_POST;
        }

        // debug
        $this->utils->setDebugMessage(__CLASS__, 'modulePerm', $this->modulePerm);
        $this->utils->setDebugMessage(__CLASS__, 'd3blogPerm', $this->d3blog_perm);
    }

    /**
     * @brief original permission check of d3blog
     */
    function d3blogPerm($user, $gperm_name) {
        if(is_array($gperm_name)) {
        	return count(array_intersect($this->userPerm($user), $gperm_name));
        } else {
            return in_array($gperm_name, $this->userPerm($user));
        }
    }

    function userPerm($user) {
        static $__user_perm_cache__;
        if(is_object($user)) {
            $uid = $user->uid();
        } else {
            $uid = 0;
        }

        if(!isset($__user_perm_cache__[$uid])) {
            if(is_object($user)) {
                $groups =& $user->getGroups();
            } else {
                $groups = array(XOOPS_GROUP_ANONYMOUS);
            }
            $groupperm_handler =& xoops_gethandler('groupperm');
            $criteria = new criteriaCompo(new criteria('gperm_itemid', 0));
            $criteria->add(new criteria('gperm_modid', $this->mid));
            $criteria->add(new criteria('gperm_groupid', '('.implode(',', $groups).')', 'IN'));
            $objs =& $groupperm_handler->getObjects($criteria);

            $perms = array();
            if(count($objs)) {
                foreach($objs as $obj) {
                    $perms[] = $obj->getVar('gperm_name');
                }
            }
            $__user_perm_cache__[$uid] = array_unique($perms);
        }
        return $__user_perm_cache__[$uid];
    }

    function checkEntryAccess($id=0)
    {
        // CURRENT USER'S INFO
        $user =& $this->sessionHandler->getUser();

        // check if user has an editing perm
        if($this->d3blogPerm($user, array('blog_perm_edit', 'blog_editor')))
            $this->d3blog_perm = XMOBILE_CAN_POST;

        if(!empty($id)) {
            $itemObject = $this->get($id);
            if(is_object($itemObject) && $this->d3blog_perm >= XMOBILE_CAN_POST) {
                if($this->sessionHandler->getUid() == $itemObject->getVar('uid') || $this->d3blogPerm($user, 'blog_editor') ) {
                    $this->d3blog_perm = XMOBILE_CAN_EDIT;
                }
            }
        }

        // debug
        $this->utils->setDebugMessage(__CLASS__, 'checkEntryAccess', $this->d3blog_perm);
    }

    function setItemCriteria()
    {
    	$myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $myts =& MyTextSanitizer::getInstance();

        // CURRENT USER'S INFO
        $user =& $this->sessionHandler->getUser();
        if(is_object($user)) {
            $uid = $user->getVar('uid');
        } else {
            $uid = 0;
        }

        $entry_handler =& $myModule->getHandler('entry');

        $this->item_criteria = new criteriaCompo();
        if($this->d3blog_perm < XMOBILE_CAN_POST || !$this->d3blogPerm($user, array('blog_editor'))) {
            $approval_criteria = new CriteriaCompo(new Criteria('approved', 1));
            $approval_criteria->add(new Criteria('published', time(), '<='));
            $this->item_criteria->add($approval_criteria);
        }

        // permission by entry
        if($myModule->getConfig('perm_by_entry')) {
            if(is_object($user)) {
                $usergroup =& $user->getGroups();
            } else {
                $usergroup = array(XOOPS_GROUP_ANONYMOUS);
            }

            $eperm_criteria = new CriteriaCompo(new criteria('groups', '%|0|%', 'like'), 'OR');
            foreach($usergroup as $group) {
                $eperm_criteria->add(new Criteria('groups', '%|'.$group.'|%', 'like'), 'OR');
            }
            if($myModule->getConfig('can_read_excerpt')) {
                $eperm_criteria->add(new criteria('body', '', '<>'), 'OR');
            }
            $this->item_criteria->add($eperm_criteria);
        }
    }

    function getEditView()
    {
        $this->setNextViewState('confirm');
        $this->setBaseUrl();
        $this->setCategoryParameter();
        $entry_type = htmlspecialchars($this->utils->getGetPost('entry_type', ''), ENT_QUOTES);
        $this->controller->render->template->assign('item_detail',$this->renderEntryForm($entry_type));
    }

    function getConfirmView()
    {
        $this->setNextViewState('detail');
        $this->setBaseUrl();
        $this->setCategoryParameter();
        $entry_type = htmlspecialchars($this->utils->getGetPost('entry_type', ''), ENT_QUOTES);
        $this->controller->render->template->assign('item_detail',$this->saveEntry($entry_type));
    }

    function getItemDetail()
    {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));

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
        $this->body_ = $itemObject->getVar('body');
        $url_parameter = $this->getBaseUrl();
        $itemObject->assignSanitizerElement();

        $detail4html = '';
        $detail4html .= _MD_XMOBILE_ITEM_DETAIL.'<br />';
        // タイトル
        if(!is_null($this->item_title_fld))
        {
            $title = $itemObject->getVar($this->item_title_fld);
            $detail4html .= _MD_XMOBILE_TITLE.$title.'<br />';
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
        // 詳細
        $description = '';
        if(!is_null($this->item_description_fld))
        {
            $description = $itemObject->getVar($this->item_description_fld);

            // 前半後半分割
            $show_letterhalf = intval($this->utils->getGet('show_latterhalf', 0));

            if($itemObject->getVar('groups') == '|0|') {
            	$member_handler =& xoops_gethandler('member');
                $groups = array_keys($member_handler->getGroupList());
            } else {
                $groups = array_filter(explode('|', $itemObject->getVar('groups')));
            }
        	// CURRENT USER'S INFO
            $user =& $this->sessionHandler->getUser();
            if(is_object($user)) {
                $usergroup = $user->getGroups();
            } else {
                $usergroup = array(XOOPS_GROUP_ANONYMOUS);
            }

        	$isPermedGroup = count(array_intersect($groups, $usergroup))? true : false;
//			$moduleConfig = call_user_func(array($this->mydirname_, 'getModuleConfig'), $this->mid);

        	if(!$show_letterhalf)
            {
                $ext = 'cid='.$this->category_id.'&bid='.$this->item_id.'&show_latterhalf=1';
                $read_next_url = $this->utils->getLinkUrl($this->controller->getActionState(),$this->controller->getViewState(),$this->controller->getPluginState(),$this->sessionHandler->getSessionID(),$ext);
                if(!empty($this->body_)) {
                	if(!$myModule->getConfig('perm_by_entry') || $isPermedGroup) {
                    	$division_next_string = '<br /><a href="'.$read_next_url.'">'._MD_D3BLOG_LANG_READ_MORE.'</a>';
                    	$description .= $division_next_string;
                	} else {
                		$division_next_string = '<br />'._MD_D3BLOG_LANG_CANT_READ_FARTHER;
                    	$description .= $division_next_string;
                	}
                }
            }
            else
            {
                if(!empty($this->body_) && (!$myModule->getConfig('perm_by_entry') || $isPermedGroup)) {
          			$description .= $this->body_;
                }
            }

            $detail4html .= _MD_XMOBILE_CONTENTS.'<br />';
            $detail4html .= $description.'<br />';
        }
        // その他の表示フィールド
        if(count($this->item_extra_fld) > 0)
        {
            foreach($this->item_extra_fld as $key=>$caption)
            {
                if($itemObject->getVar($key))
                {
                    $detail4html .= $caption;
                    $detail4html .= $itemObject->getVar($key).'<br />';
                }
            }
        }
        return $detail4html;
    }

    function getEditLink($id=0)
    {
        $this->checkEntryAccess($id);

        if($this->d3blog_perm < XMOBILE_CAN_POST)
        {
            return '';
        }
        $edit_link = '';
        if($id != 0 && $this->d3blog_perm > XMOBILE_CAN_POST)
        {
            $edit_url = $this->utils->getLinkUrl($this->controller->getActionState(),'edit',$this->controller->getPluginState(),$this->sessionHandler->getSessionID());
            $delete_url = $this->utils->getLinkUrl($this->controller->getActionState(),'edit',$this->controller->getPluginState(),$this->sessionHandler->getSessionID());
            $edit_link .= '<a href="'.$edit_url.'&amp;entry_type=edit_entry&amp;bid='.$id.'">'._EDIT.'</a>&nbsp;';
            $edit_link .= '<a href="'.$delete_url.'&amp;entry_type=delete_entry&amp;bid='.$id.'">'._DELETE.'</a>';
            $edit_link .= '<hr />';
        }
        $add_url = $this->utils->getLinkUrl($this->controller->getActionState(),'edit',$this->controller->getPluginState(),$this->sessionHandler->getSessionID());
        $edit_link .= '<a href="'.$add_url.'&amp;entry_type=new_entry&amp;cid='.$this->category_id.'">'._MD_XMOBILE_POSTNEW.'</a>&nbsp;';
        return $edit_link;
    }

    function getCommentLink($id)
    {
        if(!is_null($this->item_comments_fld))
        {
            include_once XOOPS_ROOT_PATH.'/modules/xmobile/class/Comments.class.php';
            $xmobile_comment = new XmobileComments($this->controller,$this,$id,$this->category_id,$this->itemDetailPageNavi->getStart());
            $comment_link = $xmobile_comment->makeCommentLink();
            if($comment_link)
            {
                $com_count = $xmobile_comment->com_count;
                $this->updateCommentCount($id, $com_count);
                return $comment_link;
            }
        }
    }

    function renderEntryForm($entry_type)
    {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $myts =& MyTextSanitizer::getInstance();
        global $xoopsModuleConfig;

        // GET MODULE INFORMATION
//		$moduleConfig = call_user_func(array($this->mydirname_, 'getModuleConfig'), $this->mid);

		$entry_handler =& $myModule->getHandler('entry');

        $cat_id = intval($this->utils->getGetPost('cid', 0));
        $blog_id = intval($this->utils->getGetPost('bid', 0));
        $session_id = $this->sessionHandler->getSessionID();
        $uid = $this->sessionHandler->getUid();
        $user =& $this->sessionHandler->getUser();

        $this->checkEntryAccess($blog_id);

        if($this->d3blog_perm < XMOBILE_CAN_POST)
        {
            return false;
        }

        $baseUrl = preg_replace('/&amp;/i','&',$this->baseUrl);

        $entry_form = '';
        $entry_form .= '<form action="'.$baseUrl.'" method="post">';
        $entry_form .= '<div class="form">';
        $entry_form .= $this->ticket->getTicketHtml();
        $entry_form .= '<input type="hidden" name="HTTP_REFERER" value="'.$this->baseUrl.'" />';
        $entry_form .= '<input type="hidden" name="'.session_name().'" value="'.session_id().'" />';
        $entry_form .= '<input type="hidden" name="bid" value="'.$blog_id.'" />';
        $entry_form .= '<input type="hidden" name="op" value="save" />';

        switch ($entry_type)
        {
            case 'new_entry':
				$entry =& $entry_handler->create();

				$entry->setVar('uid', $uid);
                $entry->setVar('dohtml', $this->d3blogPerm($user, 'allow_html')? 1 : 0);
                $entry->setVar('dobr', $this->d3blogPerm($user, 'allow_html')? 0 : 1);
                $entry->setVar('approved', $this->d3blogPerm($user, 'blog_autoapprove')? 1 : 0);
                $entry->setVar('notified', $this->d3blogPerm($user, 'blog_autoapprove')? 1 : 0);
                $entry->setVar('cid', $cat_id);
                $entry->setVar('groups', '|'.implode('|', is_array($myModule->getConfig('default_groups'))? $myModule->getConfig('default_groups') : array('1')).'|');
                break;

            case 'edit_entry':
				$entry = $entry_handler->get($blog_id);
                if(!$entry)
                    return false;
                break;

            case 'delete_entry':
				$entry = $entry_handler->get($blog_id);
                if(!$entry)
                    return false;

                $entry_form .= _MD_XMOBILE_ITEM_DETAIL.'<br />';
                $entry_form .= _MD_XMOBILE_TITLE.':';
                $entry_form .= $entry->getVar('title', 'e').'<hr />';
                $entry_form .= $entry->getVar('excerpt', 'e').'<hr />';
                $entry_form .= _MD_XMOBILE_CONTRIBUTOR.'&nbsp;'.$user->getVar('uname').'<br />';
                $entry_form .= _MD_XMOBILE_DATE.'&nbsp;'.strftime('%Y-%m-%d %H:%M', $entry->getVar('published', 'e')).'<br />';
                $entry_form .= _MD_XMOBILE_ASK_DELETE_THIS.'<hr />';
                $entry_form .= '<input type="hidden" name="bid" value="'.$blog_id.'" />';
                $entry_form .= '<input type="hidden" name="entry_type" value="delete_entry" />';
                $entry_form .= '<input type="submit" name="submit" value="'._DELETE.'" />&nbsp;';
                $entry_form .= '<input type="submit" name="cancel" value="'._CANCEL.'" />';
                $entry_form .= '</div>';
                $entry_form .= '</form>';
                return $entry_form;
                break;
        }

        $entry_form .= _MD_XMOBILE_CATEGORY.'<br />';

        $criteria = null;

        $entry_form .= $this->categoryTree->makeMySelBox($cat_id,null,null,$criteria).'<br />';
        $entry_form .= '<input type="hidden" name="entry_type" value="'.$entry_type.'" />';
        $entry_form .= '<input type="hidden" name="uid" value="'.$uid.'" />';
        $entry_form .= _MD_XMOBILE_TITLE.'<br />';
        $entry_form .= '<input type="text" name="title" value="'.$entry->getVar('title', 'e').'" /><br />';
        $entry_form .= _MD_XMOBILE_MESSAGE.'<br />';
        $entry_form .= '<textarea rows="'.$xoopsModuleConfig['tarea_rows'].'" cols="'.$xoopsModuleConfig['tarea_cols'].'" name="contents">'.$entry->getVar('excerpt', 'e').$entry->getVar('body', 'e').'</textarea><br />';
        $entry_form .= '<input type="submit" name="submit" value="'._SUBMIT.'" />&nbsp;';
        $entry_form .= '<input type="submit" name="cancel" value="'._CANCEL.'" />';
        $entry_form .= '</div>';
        $entry_form .= '</form>';

        return $entry_form;
    }

    function saveEntry($entry_type)
    {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $myts =& MyTextSanitizer::getInstance();
        // CURRENT USER'S INFO
        $user =& $this->sessionHandler->getUser();

        $entry_handler =& $myModule->getHandler('entry');

        $cat_id = intval($this->utils->getPost('cid', 0));
        $blog_id = intval($this->utils->getPost('bid', 0));
        $user_id = $this->sessionHandler->getUid();
        $title = $myts->makeTboxData4Save($this->utils->getPost('title', ''));
        $contents = $myts->makeTareaData4Save($this->utils->getPost('contents', ''));

        if(isset($_POST['cancel']))
        {
            $baseUrl = XMOBILE_URL.'/?act=plugin&view=default&plg='.$this->moduleDir.'&sess='.$this->sessionHandler->getSessionID();
            header('Location: '.$baseUrl);
            exit();
        }

        //チケットの確認
        if(!$ticket_check = $this->ticket->check(true,'',false))
        {
            return _MD_XMOBILE_TICKET_ERROR;
        }

        $this->checkEntryAccess($blog_id);

        switch ($entry_type)
        {
            case 'new_entry':

                if($this->d3blog_perm < XMOBILE_CAN_POST)
                {
                    return false;
                }

                $entry =& $entry_handler->create();

                $entry->setVar('uid', $user_id);
                $entry->setVar('dohtml', $this->d3blogPerm($user, 'allow_html')? 1 : 0);
                $entry->setVar('dobr', $this->d3blogPerm($user, 'allow_html')? 0 : 1);
                $entry->setVar('approved', $this->d3blogPerm($user, 'blog_autoapprove')? 1 : 0);
                $entry->setVar('notified', $this->d3blogPerm($user, 'blog_autoapprove')? 1 : 0);
                $entry->setVar('cid', $cat_id);
                $entry->setVar('title', $title);
                // divide contents into excerpt and body by separator
                $entry->divideContents($contents);
                $entry->setVar('groups', '|'.implode('|', is_array($myModule->getConfig('default_groups'))? $myModule->getConfig('default_groups') : array('1')).'|');

                if(FALSE != $entry_handler->insert($entry)) {
                    $body = _MD_XMOBILE_INSERT_SUCCESS;
                    
                    // increment blogger's posts
                    if(is_object($user) && $entry->getVar('approved') && $myModule->getConfig('increment_userpost')) {
                        $user->incrementPost();
                    }
                    
                } else {
                    $body = _MD_XMOBILE_INSERT_FAILED;
                }

                break;

            case 'edit_entry':

                if($this->d3blog_perm < XMOBILE_CAN_EDIT)
                {
                    return false;
                }

				$entry = $entry_handler->get($blog_id);
                if(is_object($entry)) {
                    $entry->setVar('modified', time());
                    $entry->setVar('cid', $cat_id);
                    $entry->setVar('title', $title);
                    // divide contents into excerpt and body by separator
                    $entry->divideContents($contents);

                    if(False != $entry_handler->insert($entry)) {
                        $body = _MD_XMOBILE_INSERT_SUCCESS;
                        
                        // increment blogger's posts
                        if($entry->getVar('approved') && $entry->vars['approved']['changed'] && $myModule->getConfig('increment_userpost')) {
                            if(is_object($user) && $entry->getVar('uid') > 0) {
                                if($entry->getVar('uid') == $user->getVar('uid')) {
                                    $user->incrementPost();
                                } else {
                                    $member_handler =& xoops_gethandler('member');
                                    $blogger = $member_handler->getUser($this->uid());
                                    if(is_object($blogger)) {
                                        $blogger->incrementPost();
                                   }
                                }
                            }
                        }
                        
                        break;
                    }
                }
                $body = _MD_XMOBILE_INSERT_FAILED;

                break;

            case 'delete_entry':

                if($this->d3blog_perm < XMOBILE_CAN_EDIT)
                {
                    return false;
                }

				$entry = $entry_handler->get($blog_id);
                if(is_object($entry)) {
                    if($entry_handler->delete($entry)) {
                        $body = _MD_XMOBILE_DELETE_SUCCESS;
                        
                        // discrement blogger's posts
                        if($myModule->getConfig('increment_userpost') && $entry->getVar('uid') > 0 && $entry->getVar('approved')) {
                            $member_handler =& xoops_gethandler('member');
                            if(is_object($user) && $user->getVar('uid') == $entry->getVar('uid')) {
                                $member_handler->updateUserByField($user, 'posts', $user->getVar('posts') - 1);
                            } else {
                                $blogger = $member_handler->getUser($entry->getVar('uid'));
                                if(is_object($blogger)) {
                                    $member_handler->updateUserByField($blogger, 'posts', $blogger->getVar('posts') - 1);
                                }
                            }
                        }
                        
                        break;
                    }
                }
                $body = _MD_XMOBILE_DELETE_FAILED;

                break;

        }
        return $body;
    }
}
}

$pluginClassName = 'Xmobile'.$pluginName.'Plugin';
if( ! class_exists($pluginClassName) ) {
eval('
class '. $pluginClassName .' extends XmobileD3blogPluginBase {
    var $mydirname_;
    function '. $pluginClassName .'() {
        $this->Xmobiled3blogPluginBase();
        $this->mydirname_ = "'.$mydirname.'";
    }
}
');
eval('
class '. $pluginClassName .'Handler extends XmobileD3blogPluginHandlerBase {
    var $mydirname_;
    function '. $pluginClassName .'Handler($db) {
        XmobilePluginHandler::XmobilePluginHandler($db);
        $this->mydirname_ = "'.$mydirname.'";
        if(!preg_match("/^\w+$/", $this->mydirname_))
        {
            trigger_error("Invalid pluginName");
            exit();
        }
        $this->moduleDir = $this->mydirname_;
        $this->categoryTableName = $this->moduleDir."_category";
        $this->itemTableName = $this->moduleDir."_entry";
        $this->ticket = new XoopsGTicket;
		 $this->d3blog_perm = 0;
    }
}
');
}
?>
