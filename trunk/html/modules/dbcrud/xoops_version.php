<?php

$dirname = basename(dirname(__FILE__));
$mydirpath = basename( dirname( dirname( __FILE__ ) ) ) ;
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);

// Basic informations
$modversion['name'] = constant('_MI_' . $affix . '_MODULE_NAME');
$modversion['version'] = 0.1;
$modversion['description'] = constant('_MI_' . $affix . '_MODULE_DESC');
$modversion['credits'] = 't.kishimoto';
$modversion['author'] = 't.kishimoto';
$modversion['official'] = 0;
$modversion['image']       = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = $dirname;
$modversion['help'] = '';
$modversion['license'] = 'GPL';

// Admin settings
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Menus
$modversion['hasMain'] = 1;
global $xoopsUser;
if (!isset($module_handler)) $module_handler =& xoops_gethandler('module');
$xgdbModule =& $module_handler->getByDirname($dirname);
if ($xgdbModule != false) {
    if (!isset($config_handler)) $config_handler =& xoops_gethandler('config');
    $xgdbModuleConfig =& $config_handler->getConfigsByCat(0, $xgdbModule->getVar('mid'));
    if (count($xgdbModuleConfig) > 0) {
        if (is_object($xoopsUser)) {
            $gids = $xoopsUser->getGroups();
            foreach ($gids as $gid) {
                if (in_array($gid, $xgdbModuleConfig[$dirname . '_add_gids'])) {
                    $modversion['sub'][1]['name'] = constant('_MI_' . $affix . '_MENU_ADD');
                    $modversion['sub'][1]['url'] = 'add.php';
                    break;
                }
            }
        } else {
            if ($xgdbModuleConfig[$dirname . '_add_guest'] || in_array(3, $xgdbModuleConfig[$dirname . '_add_gids'])) {
                $modversion['sub'][1]['name'] = constant('_MI_' . $affix . '_MENU_ADD');
                $modversion['sub'][1]['url'] = 'add.php';
            }
        }
    }
}

// Tables

// Templates

// General settings
$modversion['config'][] = array(
    'name'        => $dirname . '_result_num',
    'title'       => '_MI_' . $affix . '_SEARCH_NUM',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '10'
);
$modversion['config'][] = array(
    'name'        => $dirname . '_date_format',
    'title'       => '_MI_' . $affix . '_DATE_FORMAT',
    'description' => '_MI_' . $affix . '_DATE_FORMAT_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'Y-m-d H:i'
);
$modversion['config'][] = array(
    'name'        => $dirname . '_manage_gids',
    'title'       => '_MI_' . $affix . '_MANAGE_GROUPS',
    'description' => '_MI_' . $affix . '_MANAGE_GROUPS_DESC',
    'formtype'    => 'group_multi',
    'valuetype'   => 'array',
    'default'     => array('1')
);
$modversion['config'][] = array(
    'name'        => $dirname . '_add_gids',
    'title'       => '_MI_' . $affix . '_ADD_GROUPS',
    'description' => '',
    'formtype'    => 'group_multi',
    'valuetype'   => 'array',
    'default'     => array('1')
);
$modversion['config'][] = array(
    'name'        => $dirname . '_add_guest',
    'title'       => '_MI_' . $affix . '_ADD_GUEST',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0'
);
$modversion['config'][] = array(
    'name'        => $dirname . '_auto_update',
    'title'       => '_MI_' . $affix . '_AUTO_UPDATE',
    'description' => '_MI_' . $affix . '_AUTO_UPDATE_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0'
);
$modversion['config'][] = array(
    'name'        => $dirname . '_detail_image_width',
    'title'       => '_MI_' . $affix . '_DETAIL_IMAGE_WIDTH',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '300'
);
$modversion['config'][] = array(
    'name'        => $dirname . '_list_image_width',
    'title'       => '_MI_' . $affix . '_LIST_IMAGE_WIDTH',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '50'
);

// Blocks
$modversion['blocks'][1]['file'] = 'blocks.php';
$modversion['blocks'][1]['name'] = constant('_MI_' . $affix . '_NEW_BLOCK');
$modversion['blocks'][1]['description'] = '';
$modversion['blocks'][1]['show_func'] = $dirname . '_xgdb_new_show';
$modversion['blocks'][1]['edit_func'] = $dirname . '_xgdb_new_edit';
$modversion['blocks'][1]['options'] = '5';
$modversion['blocks'][1]['template'] = $dirname . '_xgdb_new_block.html';

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'detail.php';
$modversion['comments']['itemName'] = 'id';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.php';
$modversion['search']['func'] = $dirname . '_xgdb_search';

// Notifications
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.php';
$modversion['notification']['lookup_func'] = $dirname . '_xgdb_notify';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = constant('_MI_' . $affix . '_NTF_GLOBAL');
$modversion['notification']['category'][1]['description'] = constant('_MI_' . $affix . '_NTF_GLOBAL_DESC');
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php');

$modversion['notification']['category'][2]['name'] = 'change';
$modversion['notification']['category'][2]['title'] = constant('_MI_' . $affix . '_NTF_CHANGE');
$modversion['notification']['category'][2]['description'] = constant('_MI_' . $affix . '_NTF_CHANGE_DESC');
$modversion['notification']['category'][2]['subscribe_from'] = array('detail.php');
$modversion['notification']['category'][2]['item_name'] = 'id';

$modversion['notification']['event'][1]['name'] = 'add';
$modversion['notification']['event'][1]['title'] = constant('_MI_' . $affix . '_NTF_ADD_TITLE');
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['description'] = constant('_MI_' . $affix . '_NTF_ADD_DESC');
$modversion['notification']['event'][1]['caption'] = constant('_MI_' . $affix . '_NTF_ADD_CAPTION');
$modversion['notification']['event'][1]['mail_template'] = 'notify_add';
$modversion['notification']['event'][1]['mail_subject'] = constant('_MI_' . $affix . '_NTF_ADD_SUBJECT');

$modversion['notification']['event'][2]['name'] = 'update';
$modversion['notification']['event'][2]['title'] = constant('_MI_' . $affix . '_NTF_UPDATE_TITLE');
$modversion['notification']['event'][2]['category'] = 'change';
$modversion['notification']['event'][2]['description'] = constant('_MI_' . $affix . '_NTF_UPDATE_DESC');
$modversion['notification']['event'][2]['caption'] = constant('_MI_' . $affix . '_NTF_UPDATE_CAPTION');
$modversion['notification']['event'][2]['mail_template'] = 'notify_update';
$modversion['notification']['event'][2]['mail_subject'] = constant('_MI_' . $affix . '_NTF_UPDATE_SUBJECT');

$modversion['notification']['event'][3]['name'] = 'delete';
$modversion['notification']['event'][3]['title'] = constant('_MI_' . $affix . '_NTF_DELETE_TITLE');
$modversion['notification']['event'][3]['category'] = 'change';
$modversion['notification']['event'][3]['description'] = constant('_MI_' . $affix . '_NTF_DELETE_DESC');
$modversion['notification']['event'][3]['caption'] = constant('_MI_' . $affix . '_NTF_DELETE_CAPTION');
$modversion['notification']['event'][3]['mail_template'] = 'notify_delete';
$modversion['notification']['event'][3]['mail_subject'] = constant('_MI_' . $affix . '_NTF_DELETE_SUBJECT');

// Events
$modversion['onInstall'] = 'include/oninstall.php';
$modversion['onUpdate'] = 'include/onupdate.php';
$modversion['onUninstall'] = 'include/onuninstall.php';

?>
