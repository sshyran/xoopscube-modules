<?php
/**
 * @version $Id: modinfo.php 624 2010-02-15 07:43:09Z hodaka $
 * @author kuri <kuri@keynext.co.jp>
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3blog' ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// <--- BASIC PROPERTY --->
define ( $constpref.'_BASIC_MODULE_NAME','d3blog' );
define ( $constpref.'_BASIC_MODULE_NAME_DSC','A simple d3-type blog module.' );


// <--- SUBMENU PROPERTY --->
define ( $constpref.'_SUBMENU_POST','post' );
define ( $constpref.'_SUBMENU_MY_BLOG','my blog' );
define ( $constpref.'_SUBMENU_ARCHIVES','archives' );

// <--- ADMENU PROPERTY --->
define ( $constpref.'_ADMENU_CATEGORY_MANAGER','Categories' );
define ( $constpref.'_ADMENU_PERMISSION_MANAGER','Permissions' );
define ( $constpref.'_ADMENU_APPROVAL_MANAGER','Approval' );
define ( $constpref.'_ADMENU_IMPORT_MANAGER','Import' );
define ( $constpref.'_ADMENU_CSS_MANAGER','CSS manager' );
define ( $constpref.'_ADMENU_MYLANGADMIN','Languages' ) ;
define ( $constpref.'_ADMENU_MYTPLSADMIN','Templates' ) ;
define ( $constpref.'_ADMENU_MYBLOCKSADMIN','Blocks' ) ;
define ( $constpref.'_ADMENU_MYPREFERENCES','Preferences' ) ;

// <--- BLOCKS PROPERTY --->
define ( $constpref.'_CALENDAR', 'Blog calendar');
define ( $constpref.'_CALENDAR_DESC', 'Monthly calendar');
define ( $constpref.'_CATEGORY_LIST', 'Category list');
define ( $constpref.'_CATEGORY_LIST_DESC', 'Category list with counts');
define ( $constpref.'_ARCHIVE_LIST', 'Archives');
define ( $constpref.'_ARCHIVE_LIST_DESC', 'Retrieve archives');
define ( $constpref.'_LATEST_ENTRIES','Latest entries');
define ( $constpref.'_LATEST_ENTRIES_DESC','Latest entries list');
define ( $constpref.'_LATEST_TRACKBACKS','Latest trackbacks');
define ( $constpref.'_LATEST_TRACKBACKS_DESC','Latest trackbacks list');
define ( $constpref.'_LATEST_COMMENTS','Latest comments');
define ( $constpref.'_LATEST_COMMENTS_DESC','Latest comments list');
define ( $constpref.'_BLOGGERS_LIST', 'Bloggers');
define ( $constpref.'_BLOGGERS_LIST_DESC', 'List of bloggers');

// <--- CFG PROPERTY --->
define ( $constpref.'_WYSIWYG','Wysiwyg editor' );
define ( $constpref.'_WYSIWYG_DSC','FCKeditor and Quicktag are allowed only to HTML allowed users. (Image uploading only by admins.)' );
define ( $constpref.'_NO_WYSIWYG','Xoops Default' );
define ( $constpref.'_WYSIWYG_FCK','FCK Editor' );
define ( $constpref.'_WYSIWYG_QUICKTAG','Quick Tag' );
define ( $constpref.'_PERM_BY','Entry-by privilege' );
define ( $constpref.'_PERM_BY_DSC','Select groups to be able to view.<br />Remember that u also must give privilege by the permission manager.' );
define ( $constpref.'_PERMED','Default groups' );
define ( $constpref.'_PERMED_DSC','Default groups while an entry-by permission system is on.<br /><span style="font-weight:bold;color:#009;">Module updating is required after you added a new group.</span>' );
define ( $constpref.'_EXCERPTOK','Can read a title and an excerpt' );
define ( $constpref.'_EXCERPTOK_DSC','Even forbidden groups can read a title and an excerpt.' );
define ( $constpref.'_NUMPERPAGE','Number per page' );
define ( $constpref.'_NUMPERPAGE_DSC','' );
define ( $constpref.'_CAT_ICON','Category path' );
define ( $constpref.'_CAT_ICON_DSC','' );
define ( $constpref.'_MAX_FEED','Maxmum rdf feeds' );
define ( $constpref.'_MAX_FEED_DSC','' );
define ( $constpref.'_RSSICON','Show RSS feed icon' );
define ( $constpref.'_RSSICON_DSC','Edit templates where to place.' );
define ( $constpref.'_AVATAR','Show an avatar' );
define ( $constpref.'_AVATAR_DSC','' );
define ( $constpref.'_LOGOPATH','Module logo path' );
define ( $constpref.'_LOGOPATH_DSC','to display logo in RSS. (Absolute path required).' );
define ( $constpref.'_INCREMENT','Add user\'s hits when he/she posted a new entry.' );
define ( $constpref.'_INCREMENT_DSC','' );
define ( $constpref.'_URL_CHOICE','Enable to select Updateping servers.' );
define ( $constpref.'_URL_CHOICE_DSC','You can select updating servers on editing an entry.' );
define ( $constpref.'_MAX_URLS','Maximum of updating servers' );
define ( $constpref.'_MAX_URLS_DSC','' );
define ( $constpref.'_UPDATEPING','Updateping urls' );
define ( $constpref.'_UPDATEPING_DSC','Seperate each by break.');
define ( $constpref.'_UPDATEPING_SERVERS',"http://ping.bloggers.jp/rpc/\nhttp://ping.myblog.jp/\nhttp://blog.goo.ne.jp/XMLRPC" );
define ( $constpref.'_TBAPPROVAL','Trackback approval' );
define ( $constpref.'_TBAPPROVAL_DSC','' );
define ( $constpref.'_TBTICKET','Trackback ticket' );
define ( $constpref.'_TBTICKET_DSC','Javascript must be on. Default lifetime is one day.' );
define ( $constpref.'_NOT_ADMIN','Trackback notification' );
define ( $constpref.'_NOT_ADMIN_DSC','Notify an admin when trackback was received.' );
define ( $constpref.'_SPAMCHECK','Spam check' );
define ( $constpref.'_SPAMCHECK_DSC','Choose multiple options.' );
define ( $constpref.'_NOSPAMCHECK','No spam chacke' );
define ( $constpref.'_REFERENCE','Need references to my blog' );
define ( $constpref.'_NONAME','Reject trackback without blog name and title' );
define ( $constpref.'_WORLDLIST','Banned words' );
define ( $constpref.'_BANNEDWORD','Banned words' );
define ( $constpref.'_BANNEDWORD_DSC','Each must be seperated by break.' );
define ( $constpref.'_BANNEDWORDS', "drugs\nhydrocodone\npharma\nsex\nsmoking\nviagra" );
define ( $constpref.'_REGEX','Regex pattern check' );
define ( $constpref.'_REGEXCHECK','Regex' );
define ( $constpref.'_REGEXCHECK_DSC','Will check blog name, title, excerpt and url. Each must be seperated by line-break.' );
define ( $constpref.'_DNSBL','DNSBL CHECK' );
define ( $constpref.'_DNSBLSRV','DNSBL servers' );
define ( $constpref.'_DNSBLSRV_DSC','Will reject if the sender is registered in blacklists. Each must be seperated.' );
define ( $constpref.'_DNSBL_DSC','Will reject if the sender is registered as a spammer. Each must be seperated by break.' );
define ( $constpref.'_DNSBL_SERVERS', "niku.2ch.net\nlist.dsbl.org\nbl.spamcop.net\nsbl-xbl.spamhaus.org\nall.rbl.jp\nopm.blitzed.org\nbsb.empty.us\nbsb.spamlookup.net");
define ( $constpref.'_SURBL','URL Check in text' );
define ( $constpref.'_SURBLSRV','SURBL servers' );
define ( $constpref.'_SURBLSRV_DSC','Will reject if the urls in blog name, title and excerpt are registered as a spammer. Each must be seperated.' );
define ( $constpref.'_SURBL_DSC','Will reject if the urls in blog name, title and excerpt are registered as a spammer. Each must be seperated.' );
define ( $constpref.'_SURBL_SERVERS',"multi.surbl.org" );
define ( $constpref.'_LANGCHECK','Language letters check' );
define ( $constpref.'_PATTERN','Only available in multibytes use.' );
define ( $constpref.'_PATTERN_DSC','Edit your characteristic letter regex in language/yours/modinfo.php.' );
define ( $constpref.'_REGEX_PATTERN','' );
define ( $constpref.'_LETTERS','Minimum letters' );
define ( $constpref.'_LETTERS_DSC','Minimum multibytes length in summary of a title, a blog name and an excerpt.' );
define ( $constpref.'_DYNAMICCSS','Dynamic css' );
define ( $constpref.'_DYNAMICCSS_DSC','On will be recommende when editing css. <br />You can write down css.files after editing css templates.
' );
define ( $constpref.'_ORIGINAL_COM','Use a d3blog original comment system' );
define ( $constpref.'_ORIGINAL_COM_DSC','Can limit comment reply privilege to the bloggers.' );
define ( $constpref.'_REJECTREPLY','Only the bloggers can post a comment' );
define ( $constpref.'_REJECTREPLY_DSC','Options below are valid in any comment systems.' );
define ( $constpref.'_FIGUREHANDLER','MAKE FigureHandler ACTIVE' );
define ( $constpref.'_FIGUREHANDLER_DSC','d3blog converts [fig] tag to figure markups. The javascript can layout figures based on image size.<br />Keep it off if you are not familiar with handling themes or css styling.' );
define ( $constpref.'_COM_AGENT','Select comments system' );
define ( $constpref.'_COM_AGENT_DSC','Select forum module name if you choose d3forum comment integration.' );
define ( $constpref.'_NO_COM_AGENT','d3blog comment system' );
define ( $constpref.'_COM_AGENTID','Forum_id' );
define ( $constpref.'_COM_AGENTID_DSC','Don\'t fail to define the forum_id if you choose d3forum comment integration.' );

// <--- NOTIFY PROPERTY --->
define ( $constpref.'_NOTIFY_GLOBAL','Module global' );
define ( $constpref.'_NOTIFY_GLOBAL_DSC','Notification option in module global' );
define ( $constpref.'_NOTIFY_ENTRY','Current entry' );
define ( $constpref.'_NOTIFY_ENTRY_DSC','Notification option in a current entry.' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED','When a new and unapproved entry was posted.' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_CAP','Notify if a new and unapproved entry posted.' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_DSC','When a new and unapproved entry was posted.' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_SBJ','[{X_SITENAME}] {X_MODULE}: A new and un-approved entry was posted.' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED','When a new entry published.' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_DSC','Notify when a new entry published.' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_CAP','Notify when a new entry published.' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: A new entry was published.' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED','When a new and un-approved trackback was received.' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_CAP','Notify when a new and un-approved trackback was received.' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_DSC','When a new and un-approved trackback was received.' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_SBJ','[{X_SITENAME}] {X_MODULE}: A new and un-approved trackback was received.' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED','When a new trackback was received.' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_CAP','Notify when a new trackback was received.' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_DSC','When a new trackback was received.' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: A new rackback was received.' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED','When a new entry was approved.' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_CAP','Notify when this entry was approved.' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_DSC','When this entry was approved.' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: Your entry was approved.' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK','When a new trackback to this entry was received' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_DSC','Notify when a new trackback was received to this entry.' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_CAP','Notify when a new trackback was received to this entry.' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_SBJ','[{X_SITENAME}] {X_MODULE}: A new trackback was received.' );
define ( $constpref.'_NOTIFY_COMMENT','New comment' );
define ( $constpref.'_NOTIFY_COMMENT_CAP','Notify when a new comment was posted.' );
define ( $constpref.'_NOTIFY_COMMENT_DSC','When a new comment was posted to this entry.' );
define ( $constpref.'_NOTIFY_COMMENT_SBJ','[{X_SITENAME}] {X_MODULE}: A new comment was posted.' );

}
?>
