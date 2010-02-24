<?php

$dirname = basename(dirname(dirname(dirname(__FILE__))));
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);

include_once 'common.php';

$modinfo_consts = array(
    '_MODULE_NAME' => 'XOOPS general database',
    '_MODULE_DESC' => 'Is a generic database module can change the configuration of the items from the interface. ',
    '_TEMP_INDEX' => 'Search Page',
    '_TEMP_ADD' => 'Registration page',
    '_TEMP_UPDATE' => 'Page updated',
    '_TEMP_DELETE' => 'Delete page',
    '_TEMP_DETAIL' => 'Page Description',
    '_MENU_ADD' => 'Register',
    '_ITEM_MANAGE_MENU' => 'Project Management',
    '_SEARCH_NUM' => 'Number one search results displayed per page',
    '_DATE_FORMAT' => 'Date format',
    '_DATE_FORMAT_DESC' => 'Date first written in the form of the function of one argument. ',
    '_MANAGE_GROUPS' => 'Data management group',
    '_MANAGE_GROUPS_DESC' => 'User who belongs to data management group, you can remove all registration data update. ',
    '_ADD_GROUPS' => 'Group to allow the registration of data (multiple selection)',
    '_ADD_GUEST' => 'Registration data to allow a guest user',
    '_AUTO_UPDATE' => 'File to enable automatic updates templates',
    '_AUTO_UPDATE_DESC' => 'If you enable this feature to work slowly. <br /> only between the template file to be updated frequently. ',
    '_DETAIL_IMAGE_WIDTH' => 'Width of the screen image to display details (px)',
    '_LIST_IMAGE_WIDTH' => 'Width of the screen image to appear in the list (px)',
    '_NEW_BLOCK' => 'Block new registration',
    '_NTF_GLOBAL' => 'New registration',
    '_NTF_GLOBAL_DESC' => 'Event notification for a new registration',
    '_NTF_CHANGE' => 'Individual registration',
    '_NTF_CHANGE_DESC' => 'Remove event notification update on',
    '_NTF_ADD_TITLE' => 'Event notification registration',
    '_NTF_ADD_DESC' => 'Notification event that occurs when new information has been registered',
    '_NTF_ADD_CAPTION' => 'Notification when new information has been registered. ',
    '_NTF_ADD_SUBJECT' => 'New information has been registered',
    '_NTF_UPDATE_TITLE' => 'Event notification update',
    '_NTF_UPDATE_DESC' => 'Notification event occurs when an updated registration information',
    '_NTF_UPDATE_CAPTION' => 'Notification when registration information is updated. ',
    '_NTF_UPDATE_SUBJECT' => 'Has been updated registration information',
    '_NTF_DELETE_TITLE' => 'Delete Event Notification',
    '_NTF_DELETE_DESC' => 'Notification event occurs when the information is no longer registered',
    '_NTF_DELETE_CAPTION' => 'Notification when registration information is deleted. ',
    '_NTF_DELETE_SUBJECT' => 'Registration information was deleted',
    '_MBSTRING_DISABLE_ERR' => 'Mbstring module is not available. To run this module successfully, mbstring modules must be installed. ',
    '_GD_DISABLE_ERR' => 'Gd not using the module. To process the image in this module, gd you need to install the module. ',
    '_GD_NOT_SUPPORTED_ERR' => 'Gd module GIF / JPEG / PNG images do not support reading and writing. To process the image in this module, gd module GIF / JPEG / PNG must be supported to read and write image. '
);

foreach ($modinfo_consts as $key => $value) {
    if (!defined('_MI_' . $affix . $key)) {
        define('_MI_' . $affix . $key, $value);
    }
}

?>