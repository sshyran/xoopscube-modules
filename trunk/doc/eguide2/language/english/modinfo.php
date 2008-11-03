<?php
// $Id: modinfo.php,v 1.19 2008-07-20 07:03:06 nobu Exp $
// Module Info

if (defined('_MI_EGUIDE_NAME')) return;

// The name of this module
define("_MI_EGUIDE_NAME","Event Guide");

// A brief description of this module
define("_MI_EGUIDE_DESC","Event Detail display and Reservation system");

// Names of blocks for this module (Not all module has blocks)
define("_MI_EGUIDE_MYLIST","Reserved Events");
define("_MI_EGUIDE_SUBMIT","New Event");
define("_MI_EGUIDE_COLLECT","Settings collection");
define("_MI_EGUIDE_REG","Notify me of new events");
define("_MI_EGUIDE_HEADLINE","Event Guide");
define("_MI_EGUIDE_HEADLINE_DESC","Upcomming Recent Event List");
define("_MI_EGUIDE_HEADLINE2","New Events");
define("_MI_EGUIDE_HEADLINE2_DESC","Newer Posted Event List");
define("_MI_EGUIDE_CATBLOCK","Event Category");
define("_MI_EGUIDE_CATBLOCK_DESC","Choose event category");

define("_MI_EGUIDE_EVENTS","Events");
define("_MI_EGUIDE_NOTIFIES","Notify Users");
define("_MI_EGUIDE_CATEGORY","Categories");
define("_MI_EGUIDE_SUMMARY","Summary");
define("_MI_EGUIDE_CATEGORY_MARK","Category - ");
define("_MI_EGUIDE_ABOUT","About eguide");

// Configuration variable for this module
define("_MI_EGUIDE_POSTGROUP","Group allowed to post Events");
define("_MI_EGUIDE_POSTGROUP_DESC","Set a group with permissions to publish and manage its own events.");
define("_MI_EGUIDE_NOTIFYADMIN","Notify site Administrators");
define("_MI_EGUIDE_NOTIFYADMIN_DESC","A notification by email is sent to admin when a New Event is registered");
define("_MI_EGUIDE_NOTIFY_ALWAYS","Always");
define("_MI_EGUIDE_NOTIFYGROUP","Admin Group for Notification");
define("_MI_EGUIDE_NOTIFYGROUP_DESC","The admin group to send an email notification.");
define("_MI_EGUIDE_NEEDPOSTAUTH","New Event subject to Admin group approval?");
define("_MI_EGUIDE_NEEDPOSTAUTH_DESC","All New Events require Admin group approval.");
define("_MI_EGUIDE_MAX_LISTITEM","Display additional items in list");
define("_MI_EGUIDE_MAX_LISTITEM_DESC","Display items entry order additional form");
define("_MI_EGUIDE_MAX_LISTLINES","Display list items in a page");
define("_MI_EGUIDE_MAX_LISTLINES_DESC","How many item lines in a page");
define("_MI_EGUIDE_MAX_EVENT","Display events in top page");
define("_MI_EGUIDE_MAX_EVENT_DESC","Number of listed events in top page");
define("_MI_EGUIDE_SHOW_EXTENTS","Show Multiple Entry");
define("_MI_EGUIDE_SHOW_EXTENTS_DESC","When an Event has multiple entries:<br /> YES - display all entries.<br />NO - Only show recent entries.");
define("_MI_EGUIDE_USER_NOTIFY","User requested notification of new event");
define("_MI_EGUIDE_USER_NOTIFY_DESC","YES - Enable notification mail, NO - disable.");
define("_MI_EGUIDE_MEMBER","Event entry need to LOGIN");
define("_MI_EGUIDE_MEMBER_DESC","Only login user can be reservation event. (Not use email address)");
define("_MI_EGUIDE_ORDERCONF","Has confirm page");
define("_MI_EGUIDE_ORDERCONF_DESC","Display confirm page when reservation submit");
define("_MI_EGUIDE_CLOSEBEFORE","Close Time Before (min)");
define("_MI_EGUIDE_CLOSEBEFORE_DESC","Event entry close time before setting minits.");
define("_MI_EGUIDE_LAB_PERSONS","Additional item options");
define("_MI_EGUIDE_LAB_PERSONS_DESC","Additional item optional settings, like a field label for how many persons.<br /> Example: 'label_persons=Persons'.<br />For more details, read page 'About Eguide'.");
define("_MI_EGUIDE_DATE_FORMAT","Date Format");
define("_MI_EGUIDE_DATE_FORMAT_DESC","Open Event Date(Time) display format. Using PHP date function format.");
define("_MI_EGUIDE_DATE_FORMAT_DEF","D, d M Y");
define("_MI_EGUIDE_EXPIRE_AFTER","Expire Time");
define("_MI_EGUIDE_EXPIRE_AFTER_DESC","Event expired on top page when after event start time in minites.");
define("_MI_EGUIDE_PERSONS","Persons default value");
define("_MI_EGUIDE_PERSONS_DESC","Reservation persons in event post form");
define("_MI_EGUIDE_PLUGINS","Use Other module plugins");
define("_MI_EGUIDE_PLUGINS_DESC","Internal Control accept entry form other modules");
define("_MI_EGUIDE_COMMENT","Allow Comments");
define("_MI_EGUIDE_COMMENT_DESC","Allow comments to event");
define("_MI_EGUIDE_MARKER","Current entry level mark");
define("_MI_EGUIDE_MARKER_DESC","The mark mean how many in current entry. Show mark correspond percentage.<br />(xx,yy mean less than xx% showup yy. And '0,yy' mean out of date mark)");
define("_MI_EGUIDE_MARKER_DEF","0,[Close]\n50,[Vacant]\n100,[Many]\n101,[Full]\n");
define("_MI_EGUIDE_TIME_DEFS","Time Table Labels");
define("_MI_EGUIDE_TIME_DEFS_DESC","Set starting time in Settings page. e.g.: 08:00,14:00,16:00");
define("_MI_EGUIDE_EXPORT_LIST","Item List in export reservations");
define("_MI_EGUIDE_EXPORT_LIST_DESC","Item `name' or `number' seperated comma(,). Asterisk(*) mean left items. e.g.: 3,4,0,2,*");
// Templates
define("_MI_EGUIDE_INDEX_TPL", "Event Guide Top page list");
define("_MI_EGUIDE_EVENT_TPL", "Detail of Event");
define("_MI_EGUIDE_ENTRY_TPL", "Reservation Entry");
define("_MI_EGUIDE_EVENT_PRINT_TPL", "Detail of Event for Print");
define("_MI_EGUIDE_RECEIPT_TPL", "Reservations List");
define("_MI_EGUIDE_ADMIN_TPL", "Event Entry Form");
define("_MI_EGUIDE_RECEIPT_PRINT_TPL", "Reservations List for Print");
define("_MI_EGUIDE_EVENT_ITEM_TPL", "Item of Event Show up");
define("_MI_EGUIDE_EVENT_CONF_TPL", "Event Confirmation Form");
define("_MI_EGUIDE_EVENT_LIST_TPL", "Reserved Event List");
define("_MI_EGUIDE_EVENT_CONFIRM_TPL", "Reservation Confirmation");
define("_MI_EGUIDE_EDITDATE_TPL", "Edit Open Date");
define("_MI_EGUIDE_COLLECT_TPL", "Reservation settings");
define("_MI_EGUIDE_EXCEL_TPL", "Excel (XML) file format in exporting");

// Notifications
define('_MI_EGUIDE_GLOBAL_NOTIFY', 'Global Module');
define('_MI_EGUIDE_GLOBAL_NOTIFY_DESC', 'Notification in Event Guide module');
define('_MI_EGUIDE_CATEGORY_NOTIFY', 'Current category');
define('_MI_EGUIDE_CATEGORY_NOTIFY_DESC', 'Notification of a category in Event Guide module');
define('_MI_EGUIDE_CATEGORY_BOOKMARK', 'Current event');
define('_MI_EGUIDE_CATEGORY_BOOKMARK_DESC', 'Notifcation of a current event in Event Guide module');

define('_MI_EGUIDE_NEWPOST_SUBJECT', 'New Event - {EVENT_TITLE}');
define('_MI_EGUIDE_NEWPOST_NOTIFY', 'New event post');
define('_MI_EGUIDE_NEWPOST_NOTIFY_CAP', 'Notify when a new event is posted');
define('_MI_EGUIDE_CNEWPOST_NOTIFY', 'New event post in category');
define('_MI_EGUIDE_CNEWPOST_NOTIFY_CAP', 'Notify when a new event id posted in current category');

// for altsys
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Templates');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Blocks');
    define('_MD_A_MYMENU_MYPREFERENCES','Preferences');
}
?>