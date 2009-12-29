<?php
/**
 * @version $Id: function.d3blogCount.php 609 2009-05-23 03:00:50Z hodaka $
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     d3blogCount
 * Author:   hodaka
 * Purpose:
 * Input:
 *    Examples: <{d3blogCount dirname=DIRECTORY [var=NAME] [category=l,m,n] [blogger=10,15,18]}>
 * Output
 *    <{$(DIRECTORY.'Entries'|NAME)}>
 * -------------------------------------------------------------
 */
function smarty_function_d3blogCount($params, &$smarty) {
    $count = 0;
    $mydirname = @$params['dirname'];
    $categories = @$params['category'];
    $bloggers = @$params['blogger'];
    $assignvar = @$params['var'];

    if(preg_match('/[0-9a-zA-Z_-]/', $mydirname)) {
        $mytrustdirname = '' ;
        @include XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/mytrustdirname.php' ;
        @include_once XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/prepend.inc.php';
        $myModule = call_user_func(array($mydirname, 'getInstance'));

        if($GLOBALS['currentUser']->blog_perm($myModule->module_id)) {
            $entry_handler =& $myModule->getHandler('entry');
            $criteria =& $entry_handler->getCriteria();
            $criteria =& $entry_handler->entryPermCriteria($criteria);
            if(isset($categories)) {
                $categories = preg_replace('/[^0-9,]/', '', $categories);
                $criteria->add(new criteria('cid', '('.$categories.')', 'IN'));
            }
            if(isset($bloggers)) {
                $bloggers = preg_replace('/[^0-9,]/', '', $bloggers);
                $criteria->add(new criteria('uid', '('.$bloggers.')', 'IN'));
            }
            $count = $entry_handler->getCount($criteria);
        }
    }

    if(!empty($assignvar)) {
        $assignvar = preg_replace('/[^0-9a-zA-Z_-]/', '', $assignvar);
    } else {
        $assignvar = htmlspecialchars($mydirname, ENT_QUOTES).'Entries';
    }
    $smarty->assign($assignvar, $count);

}
?>