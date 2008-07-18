<?php
/**
 * @version $Id: category_manager.php 313 2008-02-29 12:52:07Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
require_once $mytrustdirpath.'/include/gticket.php';
require_once $mytrustdirpath.'/include/form/CategoryEditForm.class.php';

$xoopsGTicket = new xoopsGTicket();

$id = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : 0;

$cat_handler =& $myModule->getHandler('category');

// if 'delete the category' requested
if(isset($_POST['delete'])) {
    // check ticket
    if (!$xoopsGTicket->check(true,'d3blog_admin'))
        die($xoopsGTicket->getErrors());

    $obj = $cat_handler->get($id);
    if(!is_object($obj)) {
        redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=category_manager', 2, _MD_A_D3BLOG_ERROR_NO_SUCH_CATEGORY);
        exit();
    }
    if($cat_handler->delete($obj)) {
        redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=category_manager', 1, sprintf(_MD_A_D3BLOG_MESSAGE_DELETE_SUCCESSED, $obj->getVar('name')));
        exit();
    } else {
        redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=category_manager', 2, sprintf(_MD_A_D3BLOG_MESSAGE_DELETE_FAILED, $obj->getVar('name')));
        exit();
    }
}

$category = $cat_handler->get($id);
if(!is_object($category)) {
    $category =& $cat_handler->create();
}

$editform = new CategoryEditForm($mydirname);
  
$init = $editform->init($category);
switch($init) {
case MYACTIONFORM_POST_SUCCESS:
    $editform->update($category);

    if(!$cat_handler->insert($category)) {
        redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=category_manager', 2, _MD_A_D3BLOG_MESSAGE_DBUPDATE_FAILED);
        exit();
    }
    redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=category_manager', 1, _MD_A_D3BLOG_MESSAGE_DBUPDATE_SUCCESS);
    break;

case MYACTIONFORM_INIT_FAIL:
case MYACTIONFORM_INIT_SUCCESS:
    break;
}

// for category box
$categories =& $cat_handler->getChildTreeArray();

$imagepath = '';
$images = array();
if($myModule->getConfig('categoryicon_path')) {
    // remove trailing slash
    $imagepath = preg_replace("|^(.+)/$|", "$1", $myModule->getConfig('categoryicon_path'));

    // for imgurl box
    $images_array = XoopsLists::getImgListAsArray( $myModule->getConfig('categoryicon_path') );
    foreach($images_array as $img){
        $images[] = htmlspecialchars($img, ENT_QUOTES);
    }
}

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';

$tpl = new XoopsTpl();

$tpl->assign( array(
    'form_error' => ($init==MYACTIONFORM_INIT_FAIL)? $editform->getHtmlErrors() : '',
    'form' => get_object_vars($editform),
    'category' => $category->getStructure(),
    'mymid' => $myModule->module_id,
    'myname' => $myModule->module_name,
    'mydirname' => $mydirname4show,
    'mod_url' => XOOPS_URL.'/modules/'.$mydirname4show,
    'categories' => $categories,
    'images' => $images,
    'imagepath' => htmlspecialchars(str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $imagepath), ENT_QUOTES),
    'imagebasename' => basename(str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $myModule->getConfig('categoryicon_path'))),
    'imagedirname' => dirname(str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $myModule->getConfig('categoryicon_path'))),

    'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3blog_admin') )
);
$tpl->display('db:'.$mydirname.'_admin_category_manager.html');
xoops_cp_footer();

?>