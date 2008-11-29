<?php
// Module Info
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3imgtag' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","IMGTagD3");

// A brief description of this module
define($constpref."_DESC","Creates an advanced image gallery where users can submit, view, rate and leave comments on images.");

// Names of blocks for this module (Not all module has blocks)
define( $constpref."_BNAME_RECENT","Recent Images");
define( $constpref."_BNAME_HITS","Top Images");
define( $constpref."_BNAME_RANDOM","Random Image");
define( $constpref."_BNAME_RECENT_P","Recent Images with thumbnails");
define( $constpref."_BNAME_HITS_P","Top Images with thumbnails");

// Config Items	@remove _CFG_
define( $constpref."_PHOTOSPATH" , "Path to Images" ) ;
define( $constpref."_DESCPHOTOSPATH" , "Path from the directory installed XOOPS.<br />(The first character must be '/'. The last character should not be '/'.)<br />This directory's permission is 777 or 707 in unix." ) ;
define( $constpref."_THUMBSPATH" , "Path to thumbnails" ) ;
define( $constpref."_DESCTHUMBSPATH" , "Same as 'Path to images'." ) ;
//define( $constpref."_USEIMAGICK" , "Use ImageMagick for treating images" ) ;
//define( $constpref."_DESCIMAGICK" , "Not use ImageMagick cause Not work resize or rotate the main photo, and make thumbnails by GD.<br />You'd better use ImageMagick if you can." ) ;
define( $constpref."_IMAGINGPIPE" , "Image processor" ) ;
define( $constpref."_DESCIMAGINGPIPE" , "Almost all PHP environments can use GD. But GD is functionally inferior than 2 other packages.<br />It is best to use ImageMagick or NetPBM if you can." ) ;
define( $constpref."_FORCEGD2" , "Force GD2 conversion" ) ;
define( $constpref."_DESCFORCEGD2" , "Even if the GD is a bundled version of PHP, it force GD2(truecolor) conversion.<br />Some configured PHP fails to create thumbnails in GD2<br />This configuration is significant only when using GD" ) ;
define( $constpref."_IMAGICKPATH" , "Path of ImageMagick" ) ;
define( $constpref."_DESCIMAGICKPATH" , "Although the full path to 'convert' should be written, leave it blank in most environments.<br />This configuration is significant only when using ImageMagick" ) ;
define( $constpref."_NETPBMPATH" , "Path of NetPBM" ) ;
define( $constpref."_DESCNETPBMPATH" , "Alhough the full path to 'pnmscale' should be written, leave it blank in most environments.<br />This configuration is significant only when using NetPBM" ) ;
define( $constpref."_POPULAR" , "Hits to be Popular" ) ;
define( $constpref."_NEWDAYS" , "Days between displaying icon of 'new'&'update'" ) ;
define( $constpref."_NEWPHOTOS" , "Number of Photos as New on Top Page" ) ;
define( $constpref."_DEFAULTORDER" , "Default order in category's view" ) ;
define( $constpref."_PERPAGE" , "Displayed Photos per Page" ) ;
define( $constpref."_DESCPERPAGE" , "Input selectable numbers separated with '|'<br />eg) 10|20|50|100" ) ;
define( $constpref."_ALLOWNOIMAGE" , "Allow a submit without images" ) ;
define( $constpref."_MAKETHUMB" , "Make Thumbnail Image" ) ;
define( $constpref."_DESCMAKETHUMB" , "When you change 'No' to 'Yes', You'd better 'Redo thumbnails'." ) ;
define( $constpref."_MAKEPREVIEW" , "Make Preview Image" );
define( $constpref."_DESCMAKEPREVIEW" , "When you change 'No' to 'Yes', You'd better 'Redo thumbnails'." );
//define( $constpref."_THUMBWIDTH" , "Thumb Image Width" ) ;
//define( $constpref."_DESCTHUMBWIDTH" , "The height of thumbs will be decided from the width automatically." ) ;
define( $constpref."_THUMBSIZE" , "Size of thumbnails (pixel)" ) ;
define( $constpref."_THUMBRULE" , "Calculation rule for building thumbnails" ) ;
define( $constpref."_WIDTH" , "Max photo width" ) ;
define( $constpref."_DESCWIDTH" , "This means the photo's width to be resized.<br />If you use GD without truecolor, this means the limitation of width." ) ;
define( $constpref."_HEIGHT" , "Max photo height" ) ;
define( $constpref."_DESCHEIGHT" , "This means the photo's height to be resized.<br />If you use GD without truecolor, this means the limitation of height." ) ;
define( $constpref."_FSIZE" , "Max file size" ) ;
define( $constpref."_DESCFSIZE" , "The limitation of the size of uploading file.(bytes)" ) ;
define( $constpref."_MIDDLEPIXEL" , "Max image size in single view" ) ;
define( $constpref."_DESCMIDDLEPIXEL" , "Specify (width)x(height)<br />(eg. 480x480)" ) ;
define( $constpref."_ADDPOSTS" , "The number added User's posts by posting a photo." ) ;
define( $constpref."_DESCADDPOSTS" , "Normally, 0 or 1. Under 0 mean 0" ) ;
define( $constpref."_CATONSUBMENU" , "Register top categories into submenu" ) ;
define( $constpref."_NAMEORUNAME" , "Poster name displayed" ) ;
define( $constpref."_DESCNAMEORUNAME" , "Select which 'name' is displayed" ) ;
define( $constpref."_VIEWCATTYPE" , "Type of view in category" ) ;
define( $constpref."_COLSOFTABLEVIEW" , "Number of columns in table view" ) ;
define( $constpref."_ALLOWEDEXTS" , "File extensions that can be uploaded" ) ;
define( $constpref."_DESCALLOWEDEXTS" , "Input extensions with separator '|'. (eg 'jpg|jpeg|gif|png') .<br />All characters must be lowercase. Don't insert periods or spaces<br />Never add php or phtml etc." ) ;
define( $constpref."_ALLOWEDMIME" , "MIME Types can be uploaded" ) ;
define( $constpref."_DESCALLOWEDMIME" , "Input MIME Types with separator '|'. (eg 'image/gif|image/jpeg|image/png')<br />If you want to be checked by MIME Type, leave this blank" ) ;
define( $constpref."_USESITEIMG" , "Use [siteimg] in ImageManager Integration" ) ;
define( $constpref."_DESCUSESITEIMG" , "The Integrated Image Manager input [siteimg] instead of [img].<br />You have to hack module.textsanitizer.php for each module to enable tag of [siteimg]" ) ;

define( $constpref."_OPT_USENAME" , "Handle Name" ) ;
define( $constpref."_OPT_USEUNAME" , "Login Name" ) ;

define( $constpref."_OPT_CALCFROMWIDTH" , "width:specified  height:auto" ) ;
define( $constpref."_OPT_CALCFROMHEIGHT" , "width:auto  width:specified" ) ;
define( $constpref."_OPT_CALCWHINSIDEBOX" , "put in specified size squre" ) ;

define( $constpref."_OPT_VIEWLIST" , "List View" ) ;
define( $constpref."_OPT_VIEWTABLE" , "Table View" ) ;


// Sub menu titles
define( $constpref."_TEXT_SMNAME1","Submit");
define( $constpref."_TEXT_SMNAME2","Popular");
define( $constpref."_TEXT_SMNAME3","Top Rated");
define( $constpref."_TEXT_SMNAME4","My Photos");

// Names of admin menu items
define( $constpref."_D3IMGTAG_ADMENU0","Submitted Images");
define( $constpref."_D3IMGTAG_ADMENU1","Manage Images");
define( $constpref."_D3IMGTAG_ADMENU2","Manage Categories");
define( $constpref."_D3IMGTAG_ADMENU_GPERM","Global Permissions");
define( $constpref."_D3IMGTAG_ADMENU3","Check Configuration & Environment");
define( $constpref."_D3IMGTAG_ADMENU4","Batch Register");
define( $constpref."_D3IMGTAG_ADMENU5","Rebuild Thumbnails");
//define( $constpref."_D3IMGTAG_ADMENU_IMPORT","Import Images");
//define( $constpref."_D3IMGTAG_ADMENU_EXPORT","Export Images");
define( $constpref.'_ADMENU_MYLANGADMIN','Languages');
define( $constpref.'_ADMENU_MYTPLSADMIN','Templates');
define( $constpref.'_ADMENU_MYBLOCKSADMIN','Blocks/Permissions');
define( $constpref.'_ADMENU_MYPREFERENCES','Preferences');


// Text for notifications
define( $constpref.'_GLOBAL_NOTIFY', 'Global');
define( $constpref.'_GLOBAL_NOTIFYDSC', 'Global notification options with IMGTag');
define( $constpref.'_CATEGORY_NOTIFY', 'Category');
define( $constpref.'_CATEGORY_NOTIFYDSC', 'Notification options that apply to the current photo category');
define( $constpref.'_PHOTO_NOTIFY', 'Photo');
define( $constpref.'_PHOTO_NOTIFYDSC', 'Notification options that apply to the current photo');

define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFY', 'New Photo');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYCAP', 'Notify me when any new photos are posted');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYDSC', 'Receive notification when a new photo description is posted.');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New photo');

define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFY', 'New Photo');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYCAP', 'Notify me when a new photo is posted to the current category');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYDSC', 'Receive notification when a new photo description is posted to the current category');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New photo');


// KickassAMD Added Constants
define($constpref."_CHECKREFERER", "Hotlink Protection");
define($constpref."_CHECKREFERERDESC", "Enable to this to help prevent hotlinking images.<br>*This will disallow users posting your gallery images on other websites.");
define($constpref."__REFERERS", "Allowed sites to hotlink your images.");
define($constpref."__REFERERSDESC", "Sites in this list will be able to link to your images. Sites seperated by |<br><b>Make sure you include your website!!</b>.");
define($constpref."_DATEFORMAT", "Image date format.");
define($constpref."_DATEFORMATDESC", "Date format used for image post date. See <a href='http://www.php.net/date/'>PHP Date</a>");
define($constpref."_PREVIEWSIZE" , "Size of preview images (pixel)");
define($constpref."_PREVIEWRULE" , "Calc rule for building preview images.");
define($constpref."_AJAX", "Enable AJAX Features");
define($constpref."_AJAXDESC", "Enables dynamic AJAX animation features.");
define($constpref."_MINFILE", "Minimal Filename Length");
define($constpref."_MINFILEDESC", "Minimal lenght of random filename. Recommended option: 10");
define($constpref."_MAXFILE", "Maximum Filename Length");
define($constpref."_MAXFILEDESC", "Maximum length for random filename. Recommended option: 50");
define($constpref."_FILERULE", "Random Filename Seed");
define($constpref."_FILERULEDESC", "Seed to use when generated random filename.");
define($constpref."_BADREFCHECK", "Hotlink action.");
define($constpref."_BADREFCHECKDESC", "Action to take when a image is hotlinked.");
define($constpref."_BADREFTXT", "Hotlink notice text.");
define($constpref."_BADREFTXTDESC", "Text to display on image, or redirect notice when image is hotlinked.");
define($constpref."_PREVIEWSPATH" , "Path to previews");
define($constpref."_DESCPREVIEWSPATH" , "Same as 'Path to photos'.");
//define($constpref."_POPULAR", "Number of views for image to become popular.");
define($constpref."_EXINFO", "Enable extended image info.");
define($constpref."_EXINFODESC", "Shows image filesize and resolution with image information.");
define($constpref."_SHARE", "Enable image sharing.");
define($constpref."_SHAREDESC", "Allow users to share images on other websites.");
define($constpref."_WATER", "Enable image WaterMark");
define($constpref."_WATERDESC", "Adds custom text on image (a watermark).");
define($constpref."_WATERVALUE", "Text to display.");
define($constpref."_WATERVALUEDESC", "Text to display as watermark.");
define($constpref."_WATERSIZE", "Size of text.");
define($constpref."_WATERSIZEDESC", "Size of text 1 - 100");
define($constpref."_WATERPOS", "Posistion of watermark");
define($constpref."_WATERPOSDESC", "Posistion on image that watermark will show.");
define($constpref."_WATERFONT", "Font type.");
define($constpref."_WATERFONTDESC", "Font type to use on text.<br> * Add your own truetype fonts to the font folder within the imgtag dir. If you add new fonts, you must 'update' the module to update font list.");
define($constpref."_DELETEBATCH", "Delete Images During Batch Run.");
define($constpref."_DELETEBATCHDESC", "Enable this to delete images as they are imported during batch image processing.");
define($constpref."_AJAXEFFECT", "AJAX Effect Strength");
define($constpref."_AJAXEFFECTDESC", "AJAX animation effects level");

}

?>