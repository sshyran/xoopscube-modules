<?php
//  ------------------------------------------------------------------------ //
// $Id: admin.php 0003 12:31 2008/04/09 avtx30 $
//  ------------------------------------------------------------------------ //

// D3DOWNLOADS FILEMANAGER
define("_MD_D3DOWNLOADS_H2FILEMANAGER","Files");
define("_MD_D3DOWNLOADS_NEWADDFILE","Add a download");
define("_MD_D3DOWNLOADS_TH_VISIBLE","Visible");
define("_MD_D3DOWNLOADS_TH_CANCOMMENT","Comment");
define("_MD_D3DOWNLOADS_TH_CATEGORY","Category");
define("_MD_D3DOWNLOADS_TH_BROKEN","File broken");
define("_MD_D3DOWNLOADS_TH_HITS","Hits");
define("_MD_D3DOWNLOADS_TH_RATING","Rating");
define("_MD_D3DOWNLOADS_TH_COMMENTS","Comments");
define("_MD_D3DOWNLOADS_VOTES"," votes");
define("_MD_D3DOWNLOADS_LABEL_FILECHECKED","Checked downloads");
define("_MD_D3DOWNLOADS_CONFIRM_DELETE","Are you sure you want to delete?");
define("_MD_D3DOWNLOADS_LABEL_CATEGORYSELECT","Select category");
define("_MD_D3DOWNLOADS_TOTAL_FIlE_NUM","There are total %s reports");
define("_MD_D3DOWNLOADS_CATEGORY_FIlE_NUM","There are %s downloads under this category");
define("_MD_D3DOWNLOADS_BTN_MOVE","Move");
define("_MD_D3DOWNLOADS_MOVEED","Move Done");
define("_MD_D3DOWNLOADS_NO_MOVEED","Select destination category");
define("_MD_D3DOWNLOADS_CONFIRM_MOVE","Are you sure you want to move? Note that you have to move category's screenshot image manually if you use them.");

// D3DOWNLOADS APPROVALMANAGER
define("_MD_D3DOWNLOADS_H2APROVALLIST","New downloads waiting for approval");
define("_MD_D3DOWNLOADS_H2MODFILELIST","Edited downloads waiting for approval");
define("_MD_D3DOWNLOADS_APPROVAL","Approval");
define("_MD_D3DOWNLOADS_SUBMIT_APPROVAL","Download for approval");
define("_MD_D3DOWNLOADS_SUBMIT_APPROVED","Approved");
define("_MD_D3DOWNLOADS_UNAPROVALNUM","Unapproved downloads: %s");
define("_MD_D3DOWNLOADS_NOWDATA","Content before approval");

// D3DOWNLOADS CATEGORY MANAGER
define("_MD_D3DOWNLOADS_H2CATEGORYMANAGER","Categories");
define("_MD_D3DOWNLOADS_NEWCATEGORY","Add a new category");
define("_MD_D3DOWNLOADS_TH_ID","ID");
define("_MD_D3DOWNLOADS_TH_TITLE","Title");
define("_MD_D3DOWNLOADS_TH_WEIGHT","Weight");
define("_MD_D3DOWNLOADS_TH_CONTENTSACTIONS","Action");
define("_MD_D3DOWNLOADS_LABEL_CATEGORYCHECKED","Checked categories");
define("_MD_D3DOWNLOADS_BTN_DELETE","Delete");
define("_MD_D3DOWNLOADS_CATEGORYEDITTITLE","Edit Category");
define("_MD_D3DOWNLOADS_CATEGORYTITLE","Title");
define("_MD_D3DOWNLOADS_CATEGORYIMGURL","URL of category image");
define("_MD_D3DOWNLOADS_CATEGORYIMGURLDESC","Image width will be set to 70 pixels.");
define("_MD_D3DOWNLOADS_CATEGORYSHOTSDIR","Directory for screenshots");
define("_MD_D3DOWNLOADS_CATEGORYSHOTSDIRDESC","Set path after XOOPS url.<br />For example : images/shots/ (without the first /, with the last /)");
define("_MD_D3DOWNLOADS_CATEGORYSHOTSDIRHELP","Optional. If skip, images under %s directory will be used as screenshots.");
define("_MD_D3DOWNLOADS_CATWEIGHT","Weight");
define("_MD_D3DOWNLOADS_MAINCATEGORY","Main Category");
define("_MD_D3DOWNLOADS_HELP_CATEGORY_DEL","Note: If you delete a category, all data and its sub-categories will be deleted.");
define("_MD_D3DOWNLOADS_CONFIRM_CATEGORY_DEL","Are you sure to delete this category? All data and sub-categories will be deleted!");
define("_MD_D3DOWNLOADS_SUBMIT_MESSAGE","Submit form description");
define("_MD_D3DOWNLOADS_SUBMIT_MESSAGE_HELP","Input description to display at the top of the submit form for users who are not webmasters. Input is optional. If blank then default description will be displayed.");

// D3DOWNLOADS USER ACCESS
define("_MD_D3DOWNLOADS_H2USERACCESS","Category Permissions");
define("_MD_D3DOWNLOADS_TH_GROUPID","Group ID");
define("_MD_D3DOWNLOADS_TH_GROUPNAME","Group Name");
define("_MD_D3DOWNLOADS_TH_CAN_READ","Read");
define("_MD_D3DOWNLOADS_TH_CAN_POST","Post");
define("_MD_D3DOWNLOADS_TH_CAN_EDIT","Edit");
define("_MD_D3DOWNLOADS_TH_CAN_DELETE","Delete");
define("_MD_D3DOWNLOADS_TH_POST_AUTO_APPROVED","Auto-appove(Submit)");
define("_MD_D3DOWNLOADS_TH_EDIT_AUTO_APPROVED","Auto-appove(Edit)");
define("_MD_D3DOWNLOADS_TH_CAN_HTML","Allow HTML");
define("_MD_D3DOWNLOADS_HELP_USERACCESS","Note: Edit, Delete, Auto-Approval, HTML settings for guest users will be ignored even you set them.<br />  These settings will be functional with registered users.<br />&#8251;  Webmasters can edit/delete/upload regardless of these settings.<br />Please input either uid or uname when you newly add the user.<br />The user can erase it from the list by removing the Read. ");
define("_MD_D3DOWNLOADS_HELP_USERACCESS_PID","Note: Vew, Submit settings will be inherited from parent category.");

// D3DOWNLOADS IMPORT
define("_MD_D3DOWNLOADS_H2_IMPORTFROM","Import");
define("_MD_D3DOWNLOADS_BTN_DOIMPORT","Do Import");
define("_MD_D3DOWNLOADS_LABEL_SELECTMODULE","Select module");
define("_MD_D3DOWNLOADS_CONFIRM_DOIMPORT","Are you sure you want to import?");

//_MD_D3DOWNLOADS_HELP_IMPORTFROM
define("_MD_D3DOWNLOADS_HELP_IMPORTFROM","Current version can import from other d3downloads, mydownloads, wfdownloads v3.10 or above. It tries at best effort to import everything correctly but may be not completed. Note that if you do import, <b>current data in this module will be deleted completely!</b> And if you import from mydownloads or wfdownloads, permissions to categories will be reset. Don't forget to set permissions yourself after importing.");
define("_MD_D3DOWNLOADS_FILE_IMPORT_HELP","If you import from other d3downloads instances, create directory <i>%s</i> with write permission first. Uploaded files will be copied to it at best effort. Uploaded files may not be copied completely depends on environments. Please check carefully after importing.");
define("_MD_D3DOWNLOADS_FILE_CONFIGERROR_HELP","If you import from other d3downloads instances, create directory <i>%s</i> with write permission first. Uploaded files will be copied to it.");
define("_MD_D3DOWNLOADS_FILE_CONFIGERROR","Create a directory for upload with write permission first!");
define("_MD_D3DOWNLOADS_IMPORTDONE","Import Done");
define("_MD_D3DOWNLOADS_ERR_INVALIDMID","Cannot import from that module");
define("_MD_D3DOWNLOADS_SQLONIMPORT","Import failed. Source tables and destionation tables may be different in structure. Please update your modules to latest ones or check tables yourself.");
define("_MD_D3DOWNLOADS_FILE_NO_IMPORT","Only database was imported. Uploaded files could not be imported.");
define("_MD_D3DOWNLOADS_H2_UPDATEFROM","Update (0.01 -> 0.02)");
define("_MD_D3DOWNLOADS_BTN_UPDATE","Update");
define("_MD_D3DOWNLOADS_HELP_UPDATEFROM","From version 0.02 options for single downloads (HTML, smileys, line break, BB Code) were selectable but if you upgrade from version 0.01 those options will not be available. Please press Update button once to have smileys, line break, and BB Code options available. Only HTML option will not be available, you need to set it at edit forms. Sorry for this inconvenience.");
define("_MD_D3DOWNLOADS_UPDATEDONE","Update Done");
define("_MD_D3DOWNLOADS_SQLONUPDATE","Update failed");

// D3DOWNLOADS CONFIG_CHECK
define("_MD_D3DOWNLOADS_H2_CONFIG_CHECK","Upload Environment Check");
// define("_MD_D3DOWNLOADS_MAXFILESIZE","Max size of file for uploading %s (bytes)");
// define("_MD_D3DOWNLOADS_MAXFILESIZE","Max size of file for uploading %s (KB)");
// define("_MD_D3DOWNLOADS_MAXFILESIZE","Upload Size (KB)");
define("_MD_D3DOWNLOADS_PHPINI_CHECK","Check php.ini directives");
define("_MD_D3DOWNLOADS_UPLOADDIR_CHECK","Check upload directory");
define("_MD_D3DOWNLOADS_UPLOADDIR_CONFIFG","Upload directory");

// add photosite
define("_MD_D3DOWNLOADS_TH_CAN_UPLOAD","Allow UPLOAD");
define('_MD_D3DOWNLOADS_TH_UID','User ID');
define('_MD_D3DOWNLOADS_TH_UNAME','User Name');
define('_MD_D3DOWNLOADS_IMGURL_CHECK','URL of category image is not valid');
define('_MD_D3DOWNLOADS_IMGURL_TOOLONG','Please enter URL of category image in one-byte characters with length up to %s');
define('_MD_D3DOWNLOADS_SHOTSDIR_CHECK','Directory for screenshots is not valid');
define('_MD_D3DOWNLOADS_SHOTSDIR_TOOLONG','Please enter Directory for screenshots in one-byte characters with length up to %s');
define('_MD_D3DOWNLOADS_CAT_WEIGHT_TOOLONG','Please enter Weight in one-byte characters with length up to %s');

?>
