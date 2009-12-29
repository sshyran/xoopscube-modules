<?php
/**
 * @version $Id$
 * @author kuri <kuri@keynext.co.jp>
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3blog' ;

$constpref = '_MB_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// calendar
define($constpref.'_LANG_PREVMONTH', '&laquo;');
define($constpref.'_LANG_NEXTMONTH', '&raquo;');
define($constpref.'_LANG_PREVYEAR', '&laquo;');
define($constpref.'_LANG_NEXTYEAR', '&raquo;');
define($constpref.'_LANG_PREVMONTH_TITLE', 'Pev Month');
define($constpref.'_LANG_NEXTMONTH_TITLE', 'Next Month');
define($constpref.'_LANG_PREVYEAR_TITLE', 'Prev Year');
define($constpref.'_LANG_NEXTYEAR_TITLE', 'Next Year');
define($constpref.'_LANG_THIS_MONTH_TITLE', 'This month\'s archives');
define($constpref.'_LANG_SUNDAY', 'Su');
define($constpref.'_LANG_MONDAY', 'Mo');
define($constpref.'_LANG_TUESDAY', 'Tu');
define($constpref.'_LANG_WEDNESDAY', 'We');
define($constpref.'_LANG_THURSDAY', 'Th');
define($constpref.'_LANG_FRIDAY', 'Fr');
define($constpref.'_LANG_SATURDAY', 'Sa');

// latest entries
define($constpref.'_LANG_CATEGORY', 'Category');
define($constpref.'_LANG_TITLE', 'Title');
define($constpref.'_LANG_ENTRIES', 'Latest entries');
define($constpref.'_LANG_ENTRIES_FOR', '%s\'s entries');
define($constpref.'_LANG_AUTHOR', 'Author');
define($constpref.'_LANG_COMMENTS', 'Comments');
define($constpref.'_LANG_POSTED', 'Date posted');
define($constpref.'_LANG_COUNTER', 'Hits');
define($constpref.'_LANG_BLOGTOP', 'To %s\'s top');
define($constpref.'_LANG_READMORE', '...read more');

// archives
define($constpref.'_LANG_SORT_ARCHIVE', 'Retrieve archives');
define($constpref.'_LANG_MOREARCHIVES', 'View archives');

// bloggers list
define($constpref.'_LANG_READ_ENTRIES_OF_BLOGGER', 'Read %s\'s entries');

// trackback
define($constpref.'_LANG_TRACKBACKS', 'Trackbacks'); //eng
define($constpref.'_LANG_TRACKBACKS_FOR', 'Trackback to %s');
define($constpref.'_LANG_TB_TITLE', 'Trackback title');
define($constpref.'_LANG_TB_ENTRYTITLE', 'Trackback entry');
define($constpref.'_LANG_TB_BLOGNAME', 'Blog name');
define($constpref.'_LANG_TB_POSTED', 'Date');

// comments
define($constpref.'_LANG_COM_TITLE', 'Comment title');
define($constpref.'_LANG_COM_UNAME', 'User name');
define($constpref.'_LANG_COM_ENTRYTITLE', 'Entry title');
define($constpref.'_LANG_COM_POSTED', 'Date');

// table summary
define($constpref.'_SUMMARY_COMMENTS_LIST', 'THIS IS A TABLE THAT SHOWS COMMENTS.');
define($constpref.'_SUMMARY_CALENDAR', 'THIS IS A CALENDAR BOX THAT SHOWS DAILY ENTRIES. CAN GO BACK AND FORTH BY MONTHLY OR YEARLY.');
define($constpref.'_SUMMARY_LATEST_BLOGS', 'THIS IS A TABLE TAHT SHOWS LATEST BLOG ENTRIES.');
define($constpref.'_SUMMARY_LATEST_CONTENTS', 'THIS IS A TABLE TAHT SHOWS LATEST COMMENTS.');
define($constpref.'_SUMMARY_LATEST_TRACKBACKS', 'THIS IS A TABLE TAHT SHOWS LATEST TRACKBACKS.');

}
?>