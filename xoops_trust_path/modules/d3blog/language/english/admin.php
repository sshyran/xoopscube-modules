<?php
/**
 * @version $Id: admin.php 421 2008-04-16 12:30:59Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// <--- LANG PROPERTY --->
define ( '_MD_A_D3BLOG_LANG_EDIT','EDIT' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_MANAGER','Category manager' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_LIST','Category list' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_NAME','Category name' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_PARENT','Parent category' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_WEIGHT','Weight' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_IMAGE','Category image' );
define ( '_MD_A_D3BLOG_LANG_REGISTER_ANDOR_EDIT_CATEGORY','Register and/or edit category' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_GLOBAL','Overall categories' );
define ( '_MD_A_D3BLOG_LANG_PERMISSION_MANAGER','Permissions' );
define ( '_MD_A_D3BLOG_LANG_GROUP_NAME','Group name' );
define ( '_MD_A_D3BLOG_LANG_SELECT_INPORTMODULE','Select import module' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_MANAGER','Approval manager' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_SUMMARY','A list of un-approved entries and trackbacks' );
define ( '_MD_A_D3BLOG_LANG_ENTRY_TITLE','Entry title' );
define ( '_MD_A_D3BLOG_LANG_BLOG_TITLE','Blog title' );
define ( '_MD_A_D3BLOG_LANG_ENTRY_DATE','Posted date' );
define ( '_MD_A_D3BLOG_LANG_COMMENTER','Poster/commenter' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE','Approval type' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_ENTRY','Entry approval' );
define ( '_MD_A_D3BLOG_LANG_CREATE_DATE','Posted date' );
define ( '_MD_A_D3BLOG_LANG_BLOG_NAME_INBOUND','Blog name of trackback' );
define ( '_MD_A_D3BLOG_LANG_BLOG_EXCERPT_INBOUND','Excerpt' );
define ( '_MD_A_D3BLOG_LANG_TRACKBACK_DATE_INBOUND','Trackback date' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_COMMENT','Comment' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_TRACKBACK','Trackback' );
define ( '_MD_A_D3BLOG_LANG_COMMENTS','Comment/Excerpt' );
define ( '_MD_A_D3BLOG_LANG_COMMENT_DATE','Comment date' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL','APPROVAL' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_NAME','Template name' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_TYPE','Template type' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_FILE','Template file' );
define ( '_MD_A_D3BLOG_LANG_CSS_FILE','CSS file' );
define ( '_MD_A_D3BLOG_LANG_WRITE_CSS_FILE','Write down CSS file' );

// <--- MESSAGE PROPERTY --->
define ( '_MD_A_D3BLOG_MESSAGE_DBUPDATE_SUCCESS','DB update has been successfully done.' );
define ( '_MD_A_D3BLOG_MESSAGE_DBUPDATE_FAILED','Error occurred while DB updating.' );
define ( '_MD_A_D3BLOG_MESSAGE_DELETE_SUCCESSED','Deleted %s successfully.' );
define ( '_MD_A_D3BLOG_MESSAGE_DELETE_FAILED','Failed to delete %s.' );
define ( '_MD_A_D3BLOG_MESSAGE_IMPORTDONE','Importing has been successfully finished.' );
define ( '_MD_A_D3BLOG_MESSAGE_MIGHT_REWRITE_LINKPATH','</br />Remember to re-write link paths in comments.' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_UPDATE_SUCCESS','Updating of %s has been successfully finished.' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_DELETE_SUCCESS','Deleting of %s has been successfully finished.' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_UPDATE_FAILED','Failed to update %s.' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_DELETE_FAILED','Failed to delete %s.' );
define ( '_MD_A_D3BLOG_MESSAGE_ARE_YOU_SURE_TO_OVERWRITE_CSSFILE','Are you sure to overwrite css files?' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_OPEN_CSS_DIR','Failed to open the directory %s.' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_DIR','Failed to open the directory %s with write permission.' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_FILE','Style sheet %s does not have a writable permission.' ); 
define ( '_MD_A_D3BLOG_MESSAGE_NOT_CSS_FILE','%s is not a css file. Delete this file manually.' ); 
define ( '_MD_A_D3BLOG_MESSAGE_YOU_MUST_PREPARE_CSS_DIRECTORY','Invalid operation. Check and prepare css directory.' ); 
define ( '_MD_A_D3BLOG_MESSAGE_CSS_FILES_SUCCESSFULLY_WRITTEN','CSS files have been successfully written.' );

// <--- ERROR PROPERTY --->
define ( '_MD_A_D3BLOG_ERROR_WRONG_PID','You choose a wrong parent category (or DB collapse).' );
define ( '_MD_A_D3BLOG_ERROR_NAME_REQUIRED','Category name is required.' );
define ( '_MD_A_D3BLOG_ERROR_NAME_SIZEOVER','A category name length is longer than %s.' );
define ( '_MD_A_D3BLOG_ERROR_WRONG_IMGURL','Image url\'s format is illegal.' );
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_CATEGORY','No such a category.' );
define ( '_MD_A_D3BLOG_ERROR_INVALIDMID', 'Wrong mid. No such a module.');
define ( '_MD_A_D3BLOG_ERROR_SQLONIMPORT', 'DB ACCESS(SQL) ERROR OCCURED.');
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_TEMPLATE_SET','Invalid template set.' );
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_TEMPLATE_FILE','%s is an invalid template file.' );

// <--- FORMAT PROPERTY --->
define ( '_MD_A_D3BLOG_FORMAT_CSS_DIRECTORY','CSS directory is %s.' );

// <--- PERMDESC PROPERTY --->
define ( '_MD_A_D3BLOG_PERMDESC_CAN_VIEW_BLOG','Can view' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_EDIT_BLOG','Can edit' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_APPROVE_BLOG_SELF','Auto-approve' );
define ( '_MD_A_D3BLOG_PERMDESC_ALLOW_HTML','HTML allowed' );
define ( '_MD_A_D3BLOG_PERMDESC_EDITOR','Editor' );

$xoopsModule =& XoopsModule::getByDirname($mydirname);
define ( '_MD_A_D3BLOG_CONFIG', $xoopsModule->getVar('name').'Configuration');
define ( '_MD_A_D3BLOG_PREFERENCES', _PREFERENCES);
define ( '_MD_A_D3BLOG_PREFERENCESDSC', 'Configure module\'s global preferences');
define ( '_MD_A_D3BLOG_GO', _GO);
define ( '_MD_A_D3BLOG_CANCEL', _CANCEL);
define ( '_MD_A_D3BLOG_DELETE', _DELETE);
define ( '_MD_A_D3BLOG_MODIFY', 'Modify');
define ( '_MD_A_D3BLOG_TITLE', 'Title');

// <--- STRUCTURE PROPERTY --->
define ( '_MD_A_D3BLOG_H2_IMPORTFROM', 'Import manager');
define ( '_MD_A_D3BLOG_H3_IMPORTDATABASE', 'Copy database table');
define ( '_MD_A_D3BLOG_H3_IMPORTCOM', 'Import comments and event notifications');
define ( '_MD_A_D3BLOG_H3_SYNCHRONIZE', 'Re-calculate comments and trackbacks count');
define ( '_MD_A_D3BLOG_LABEL_SELECTMODULE', 'Modules importable');
define ( '_MD_A_D3BLOG_LABEL_SELECTDIRECTORY', 'Directory importable');
define ( '_MD_A_D3BLOG_LANG_SELECT_IMPORTMODULE', 'Select import module');
define ( '_MD_A_D3BLOG_BTN_DOIMPORT', 'Start to import');
define ( '_MD_A_D3BLOG_BTN_DOSYNCHRONIZE', 'Start re-calculate');
define ( '_MD_A_D3BLOG_CONFIRM_DOIMPORT', 'Are you sure to import database tables?');
define ( '_MD_A_D3BLOG_CONFIRM_DOCOMIMPORT', 'Are you sure to import comments and notifications?');
define ( '_MD_A_D3BLOG_CONFIRM_DOSYNCHRONIZE', 'Are you sure to re-caliculate?');
define ( '_MD_A_D3BLOG_HELP_IMPORTFROM', '<p>Table data are <strong>copied</strong> from importable module. Importable module\'s table data are kept until uninstalling.</p>'.
    '<p><strong style="padding-right:1em">NOTICE </strong>Configurations of blocks, templates and module preferences are not imported.</p>');
define('_MD_A_D3BLOG_HELP_COMIMPORT', '<p>Comments and event notifications configs are moved to this module.</p>'.
    '<p><strong style="padding-right:1em">NOTICE </strong>Re-caliculate both this module and export modules.</p>');
define('_MD_A_D3BLOG_HELP_SYNCHRONIZE', '<p>Re-caliculate comments and trackbacks.</p>'.
    '<p><strong style="padding-right:1em">NOTICE </strong>Highly recommended after database was editted by phpMyAdmin etc.</p>');
define ( '_MD_A_D3BLOG_H2_CSSMANAGER','Stylesheet Management' );
define ( '_MD_A_D3BLOG_H3_WRITE_CSSFILE','Write CSS Files' );
define ( '_MD_A_D3BLOG_HELP_CSSMANAGER', '<p>You can overwrite css files from the templates. Check the right templates and click "WRITE CSS FILE".</p>'.
    '<p><strong style="padding-right:1em">NOTICE</strong>The templates of the current template set are automatically checked if younger than the css files.</p>');

?>