<?php

// Index (Categories)
define( "_AM_D3IMGTAG_H3_FMT_CATEGORIES" , "Categories Manager (%s)" ) ;
define( "_AM_D3IMGTAG_CAT_TH_TITLE" , "Name" ) ;
define( "_AM_D3IMGTAG_CAT_TH_PHOTOS" , "Images" ) ;
define( "_AM_D3IMGTAG_CAT_TH_OPERATION" , "Operation" ) ;
define( "_AM_D3IMGTAG_CAT_TH_IMAGE" , "Banner" ) ;
define( "_AM_D3IMGTAG_CAT_TH_PARENT" , "Parent" ) ;
define( "_AM_D3IMGTAG_CAT_TH_IMGURL" , "URL of Banner" ) ;
define( "_AM_D3IMGTAG_CAT_MENU_NEW" , "Creating a category" ) ;
define( "_AM_D3IMGTAG_CAT_MENU_EDIT" , "Editing a category" ) ;
define( "_AM_D3IMGTAG_CAT_INSERTED" , "A category is added" ) ;
define( "_AM_D3IMGTAG_CAT_UPDATED" , "The category is modified" ) ;
define( "_AM_D3IMGTAG_CAT_BTN_BATCH" , "Apply" ) ;
define( "_AM_D3IMGTAG_CAT_LINK_MAKETOPCAT" , "Create a new category on top" ) ;
define( "_AM_D3IMGTAG_CAT_LINK_ADDPHOTOS" , "Add a image into this category" ) ;
define( "_AM_D3IMGTAG_CAT_LINK_EDIT" , "Edit this category" ) ;
define( "_AM_D3IMGTAG_CAT_LINK_MAKESUBCAT" , "Create a new category under this category" ) ;
define( "_AM_D3IMGTAG_CAT_FMT_NEEDADMISSION" , "%s images are needed to be admitted" ) ;
define( "_AM_D3IMGTAG_CAT_FMT_CATDELCONFIRM" , "%s will be deleted with its sub-categories, images, comments. OK?" ) ;


// Admission
define( "_AM_D3IMGTAG_H3_FMT_ADMISSION" , "Admitting images (%s)" ) ;
define( "_AM_D3IMGTAG_TH_SUBMITTER" , "Submitter" ) ;
define( "_AM_D3IMGTAG_TH_TITLE" , "Title" ) ;
define( "_AM_D3IMGTAG_TH_DESCRIPTION" , "Description" ) ;
define( "_AM_D3IMGTAG_TH_CATEGORIES" , "Category" ) ;
define( "_AM_D3IMGTAG_TH_DATE" , "Last update" ) ;


// Photo Manager
define( "_AM_D3IMGTAG_H3_FMT_PHOTOMANAGER" , "Image Manager (%s)" ) ;
define( "_AM_D3IMGTAG_TH_BATCHUPDATE" , "Update checked photos collectively" ) ;
define( "_AM_D3IMGTAG_OPT_NOCHANGE" , "- NO CHANGE -" ) ;
define( "_AM_D3IMGTAG_JS_UPDATECONFIRM" , "The checked items will be updated. OK?" ) ;


// Module Checker
define( "_AM_D3IMGTAG_H3_FMT_MODULECHECKER" , "IMGTagD3 Module Health checker (%s)" ) ;

define( "_AM_D3IMGTAG_H4_ENVIRONMENT" , "Environment Check" ) ;
define( "_AM_D3IMGTAG_H4_SIZECHECK" , "Total Disk Space Usage (This only measures fullsize images.)" );
define( "_AM_D3IMGTAG_MB_PHPDIRECTIVE" , "PHP directive" ) ;
define( "_AM_D3IMGTAG_MB_BOTHOK" , "Both ok" ) ;
define( "_AM_D3IMGTAG_MB_NEEDON" , "Need on" ) ;


define( "_AM_D3IMGTAG_H4_TABLE" , "Table Check" ) ;
define( "_AM_D3IMGTAG_MB_PHOTOSTABLE" , "Photos table" ) ;
define( "_AM_D3IMGTAG_MB_DESCRIPTIONTABLE" , "Descriptions table" ) ;
define( "_AM_D3IMGTAG_MB_CATEGORIESTABLE" , "Categories table" ) ;
define( "_AM_D3IMGTAG_MB_VOTEDATATABLE" , "Votedata table" ) ;
define( "_AM_D3IMGTAG_MB_COMMENTSTABLE" , "Comments table" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFPHOTOS" , "Number of Photos" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFDESCRIPTIONS" , "Number of Descriptions" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFCATEGORIES" , "Number of Categories" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFVOTEDATA" , "Number of Votedata" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFCOMMENTS" , "Number of Comments" ) ;


define( "_AM_D3IMGTAG_H4_CONFIG" , "Config Check" ) ;
define( "_AM_D3IMGTAG_MB_PIPEFORIMAGES" , "Pipe for images" ) ;
define( "_AM_D3IMGTAG_MB_DIRECTORYFORPHOTOS" , "Directory for Fullsize Images" ) ;
define( "_AM_D3IMGTAG_MB_DIRECTORYFORTHUMBS" , "Directory for Thumbnails" ) ;
define( "_AM_D3IMGTAG_MB_DIRECTORYFORPREVIEWS"  , "Directory for Preview Images" );
define( "_AM_D3IMGTAG_ERR_LASTCHAR" , "Error: The last charactor should not be '/'" ) ;
define( "_AM_D3IMGTAG_ERR_FIRSTCHAR" , "Error: The first charactor should be '/'" ) ;
define( "_AM_D3IMGTAG_ERR_PERMISSION" , "Error: You first have to create and chmod 777 this directory by ftp or shell." ) ;
define( "_AM_D3IMGTAG_ERR_NOTDIRECTORY" , "Error: This is not a directory." ) ;
define( "_AM_D3IMGTAG_ERR_READORWRITE" , "Error: This directory is not writable nor readable. You should change the permission of the directory to 777." ) ;
define( "_AM_D3IMGTAG_ERR_SAMEDIR" , "Error: Photos Path should not be the same as Thumbs Path" ) ;
define( "_AM_D3IMGTAG_LNK_CHECKGD2" , "Check that 'GD2'is working correctly under your GD bundled with PHP" ) ;
define( "_AM_D3IMGTAG_MB_CHECKGD2" , "If the page linked to from here doesn't display correctly, you should not use your GD in truecolor mode." ) ;
define( "_AM_D3IMGTAG_MB_GD2SUCCESS" , "Checking For GD2... <b>Success!</b><br />Perhaps, you can use GD2 (truecolor) in this environment." ) ;


define( "_AM_D3IMGTAG_H4_PHOTOLINK" , "Image Link Check" ) ;
define( "_AM_D3IMGTAG_MB_NOWCHECKING" , "Now, checking ..." ) ;
define( "_AM_D3IMGTAG_FMT_PHOTONOTREADABLE" , "Main image (%s) is not readable." ) ;
define( "_AM_D3IMGTAG_FMT_THUMBNOTREADABLE" , "Thumbnail (%s) is not readable." ) ;
define( "_AM_D3IMGTAG_FMT_NUMBEROFDEADPHOTOS" , "%s dead photo files have been found." ) ;
define( "_AM_D3IMGTAG_FMT_NUMBEROFDEADTHUMBS" , "%s thumbnails should be rebuilt." ) ;
define( "_AM_D3IMGTAG_FMT_NUMBEROFREMOVEDTMPS" , "%s garbage files have been removed." ) ;
define( "_AM_D3IMGTAG_LINK_REDOTHUMBS" , "Rebuild thumbnails" ) ;
define( "_AM_D3IMGTAG_LINK_TABLEMAINTENANCE" , "Maintain tables" ) ;



// Redo Thumbnail
define( "_AM_D3IMGTAG_H3_FMT_RECORDMAINTENANCE" , "IMGTagD3 image maintenance (%s)" ) ;

define( "_AM_D3IMGTAG_FMT_CHECKING" , "checking %s ..." ) ;

define( "_AM_D3IMGTAG_FORM_RECORDMAINTENANCE" , "Maintenance of photos like remaking thumbnails etc." ) ;

define( "_AM_D3IMGTAG_MB_FAILEDREADING" , "Failed reading." ) ;
define( "_AM_D3IMGTAG_MB_CREATEDTHUMBS" , "Re-Created a thumbnail & preview images." ) ;
define( "_AM_D3IMGTAG_MB_BIGTHUMBS" , "Failed making a thumnail or preview image. copied main image." ) ;
define( "_AM_D3IMGTAG_MB_BIGPREVIEW" , "Failed making a preview image! Copied main image." );
define( "_AM_D3IMGTAG_MB_SKIPPED" , "Skipped." ) ;
define( "_AM_D3IMGTAG_MB_SIZEREPAIRED" , "(Repaired size fields of the record.)" ) ;
define( "_AM_D3IMGTAG_MB_RECREMOVED" , "This record has been removed." ) ;
define( "_AM_D3IMGTAG_MB_PHOTONOTEXISTS" , "Main photo does not exist." ) ;
define( "_AM_D3IMGTAG_MB_PHOTORESIZED" , "Main photo was resized." ) ;

define( "_AM_D3IMGTAG_TEXT_RECORDFORSTARTING" , "Begin at image id ..." ) ;
define( "_AM_D3IMGTAG_TEXT_NUMBERATATIME" , "Number of records processed at a time" ) ;
define( "_AM_D3IMGTAG_LABEL_DESCNUMBERATATIME" , "<b>Warning</b> Too large a number may lead to server time out." ) ;

define( "_AM_D3IMGTAG_RADIO_FORCEREDO" , "Force recreating even if a thumbnail & preview image exists" ) ;
define( "_AM_D3IMGTAG_RADIO_REMOVEREC" , "Remove records that don't link to a main photo" ) ;
define( "_AM_D3IMGTAG_RADIO_RESIZE" , "Resize bigger photos than the pixels specified in current preferences" ) ;

define( "_AM_D3IMGTAG_MB_FINISHED" , "Finished" ) ;
define( "_AM_D3IMGTAG_LINK_RESTART" , "Restart" ) ;
define( "_AM_D3IMGTAG_SUBMIT_NEXT" , "Next" ) ;

define( "_AM_D3IMGTAG_MB_CHECKTTF" , "<b>Check For FreeType Capabilities</b>" );
define( "_AM_D3IMGTAG_MB_CHECKTTFSUCCESS" , "<span style='color:#009900'>--> PHP Freetype is installed.</span>" );
define( "_AM_D3IMGTAG_MB_CHECKTTFFAILED" , "<span style='color:#FF0000'>--> Freetype is not installed, Watermark may not work properly!</span>" );



// Batch Register
define( "_AM_D3IMGTAG_H3_FMT_BATCHREGISTER" , "IMGTagD3 batch register (%s)" ) ;
define( "_AM_D3IMGTAG_H3_FMT_BATCHREGISTERNOTICE" , "Try not to do more then 100 images at once. May lead to server time-outs and incorrect user post counts." );


// GroupPerm Global
define( "_AM_D3IMGTAG_ALBM_GROUPPERM_GLOBAL" , "Global Permissions" ) ;
define( "_AM_D3IMGTAG_ALBM_GROUPPERM_GLOBALDESC" , "Configure group's priviledges for this module" ) ;
define( "_AM_D3IMGTAG_ALBM_GPERMUPDATED" , "Permissions have been changed successfully" ) ;


?>