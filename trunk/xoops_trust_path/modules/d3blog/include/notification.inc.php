<?php
/**
 * @version $Id: notification.inc.php 281 2008-02-23 09:49:31Z hodaka $
 * @brief override global notification trigger event funtion 
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

require_once XOOPS_ROOT_PATH . '/kernel/notification.php';

class MyXoopsNotificationHandler extends XoopsNotificationHandler
{
    var $template_dir_;

    function MyXoopsNotificationHandler(&$db)
    {
        parent::XoopsNotificationHandler(&$db);
        $this->template_dir_ = '';
    }
    
    function triggerEvent ($category, $item_id, $event, $extra_tags=array(), $user_list=array(), $module_id=null, $omit_user_id=null)
    {
        if (!isset($module_id)) {
            global $xoopsModule;
            $module =& $xoopsModule;
            $module_id = is_object($xoopsModule) ? $xoopsModule->getVar('mid') : 0;
        } else {
            $module_handler =& xoops_gethandler('module');
            $module =& $module_handler->get($module_id);
        }

        // Check if event is enabled
        $config_handler =& xoops_gethandler('config');
        $mod_config =& $config_handler->getConfigsByCat(0,$module->getVar('mid'));
        if (empty($mod_config['notification_enabled'])) {
            return false;
        }
        $category_info =& notificationCategoryInfo ($category, $module_id);
        $event_info =& notificationEventInfo ($category, $event, $module_id);

        if (!in_array(notificationGenerateConfig($category_info,$event_info,'option_name'),$mod_config['notification_events']) && empty($event_info['invisible'])) {
            return false;
        }

        if (!isset($omit_user_id)) {
            global $xoopsUser;
            if (is_object($xoopsUser)) {
                $omit_user_id = $xoopsUser->getVar('uid');
            } else {
                $omit_user_id = 0;
            }
        }
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('not_modid', intval($module_id)));
        $criteria->add(new Criteria('not_category', $category));
        $criteria->add(new Criteria('not_itemid', intval($item_id)));
        $criteria->add(new Criteria('not_event', $event));
        $mode_criteria = new CriteriaCompo();
        $mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDALWAYS), 'OR');
        $mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE), 'OR');
        $mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT), 'OR');
        $criteria->add($mode_criteria);
        if (!empty($user_list)) {
            $user_criteria = new CriteriaCompo();
            foreach ($user_list as $user) {
                $user_criteria->add (new Criteria('not_uid', $user), 'OR');
            }
            $criteria->add($user_criteria);
        }
        $notifications =& $this->getObjects($criteria);
        if (empty($notifications)) {
            return;
        }

        // Add some tag substitutions here

        $not_config = $module->getInfo('notification');
        $tags = array();
        if (!empty($not_config)) {
            if (!empty($not_config['tags_file'])) {
                $tags_file = XOOPS_ROOT_PATH . '/modules/' . $module->getVar('dirname') . '/' . $not_config['tags_file'];
                if (file_exists($tags_file)) {
                    include_once $tags_file;
                    if (!empty($not_config['tags_func'])) {
                        $tags_func = $not_config['tags_func'];
                        if (function_exists($tags_func)) {
                            $tags = $tags_func($category, intval($item_id), $event);
                        }
                    }
                }
            }
            // RMV-NEW
            if (!empty($not_config['lookup_file'])) {
                $lookup_file = XOOPS_ROOT_PATH . '/modules/' . $module->getVar('dirname') . '/' . $not_config['lookup_file'];
                if (file_exists($lookup_file)) {
                    include_once $lookup_file;
                    if (!empty($not_config['lookup_func'])) {
                        $lookup_func = $not_config['lookup_func'];
                        if (function_exists($lookup_func)) {
                            $item_info = $lookup_func($category, intval($item_id));
                        }
                    }
                }
            }
        }
        $tags['X_ITEM_NAME'] = !empty($item_info['name']) ? $item_info['name'] : '[' . _NOT_ITEMNAMENOTAVAILABLE . ']';
        $tags['X_ITEM_URL']  = !empty($item_info['url']) ? $item_info['url'] : '[' . _NOT_ITEMURLNOTAVAILABLE . ']';
        $tags['X_ITEM_TYPE'] = !empty($category_info['item_name']) ? $category_info['title'] : '[' . _NOT_ITEMTYPENOTAVAILABLE . ']';
        $tags['X_MODULE'] = $module->getVar('name');
        $tags['X_MODULE_URL'] = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/';
        $tags['X_NOTIFY_CATEGORY'] = $category;
        $tags['X_NOTIFY_EVENT'] = $event;

//        $template_dir = $event_info['mail_template_dir'];
        $template_dir = $this->template_dir_;
        $template = $event_info['mail_template'] . '.tpl';
        $subject = $event_info['mail_subject'];

        foreach ($notifications as $notification) {
            if (empty($omit_user_id) || $notification->getVar('not_uid') != $omit_user_id) {
                // user-specific tags
                //$tags['X_UNSUBSCRIBE_URL'] = 'TODO';
                // TODO: don't show unsubscribe link if it is 'one-time' ??
                $tags['X_UNSUBSCRIBE_URL'] = XOOPS_URL . '/notifications.php';
                $tags = array_merge ($tags, $extra_tags);

                $notification->notifyUser($template_dir, $template, $subject, $tags);
            }
        }
    }

}
?>