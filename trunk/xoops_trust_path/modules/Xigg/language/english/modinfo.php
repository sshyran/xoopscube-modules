<?php
$const_prefix = '_MI_' . strtoupper($module_dirname);

if (!defined($const_prefix)) {
define($const_prefix, 1);

define($const_prefix . '_NAME', 'Xigg(' . $module_dirname . ')');
define($const_prefix . '_DESC', 'Xigg module for XOOPS powered by Sabai Framework');

// Blocks
define($const_prefix . '_BNAME_CATEGORIES', 'Categories');
define($const_prefix . '_BDESC_CATEGORIES', 'Categories block');
define($const_prefix . '_BNAME_TAG_CLOUD', 'Tags');
define($const_prefix . '_BDESC_TAG_CLOUD', 'Tag cloud');
define($const_prefix . '_BNAME_RECENT_NODES', 'Recent Articles');
define($const_prefix . '_BDESC_RECENT_NODES', 'Shows recent articles');
define($const_prefix . '_BNAME_RECENT_COMMENTS', 'Recent Comments');
define($const_prefix . '_BDESC_RECENT_COMMENTS', 'Shows recent comments');
define($const_prefix . '_BNAME_RECENT_TRACKBACKS', 'Recent Trackbacks');
define($const_prefix . '_BDESC_RECENT_TRACKBACKS', 'Shows recent trackbacks');
define($const_prefix . '_BNAME_RECENT_VOTES', 'Recent Votes');
define($const_prefix . '_BDESC_RECENT_VOTES', 'Shows recent votes');
define($const_prefix . '_BNAME_RECENT_NODES2', 'Recent Articles 2');
define($const_prefix . '_BDESC_RECENT_NODES2', 'Shows recent and top voted articles');

// Admin menu
define($const_prefix . '_ADMENU_CATEGORIES', 'Categories');
define($const_prefix . '_ADMENU_NODES', 'Articles');
define($const_prefix . '_ADMENU_TAGS', 'Tags');
define($const_prefix . '_ADMENU_PLUGINS', 'Plugins');
define($const_prefix . '_ADMENU_ROLES', 'Roles');
define($const_prefix . '_ADMENU_XROLES', 'Assign roles by group');
define($const_prefix . '_ADMENU_USERS', 'Users');

define($const_prefix . '_SMENU_SUBMIT', 'Submit Article');
define($const_prefix . '_SMENU_COMMENTS', 'Comments');
define($const_prefix . '_SMENU_TAGCLOUD', 'Tag Cloud');

define($const_prefix . '_C_SITETITLE', 'Site title');
define($const_prefix . '_C_SITEDESC', 'Site description');
define($const_prefix . '_C_GVOTEALLOWED', 'Guest users are allowed to vote on articles');
define($const_prefix . '_C_GVOTEALLOWEDD', 'Selecting "Yes" will allow any user to vote on articles irrespective of the role permission settings.');
define($const_prefix . '_C_GCOMALLOWED', 'Guest users are allowed to post comments');
define($const_prefix . '_C_GCOMALLOWEDD', 'Selecting "Yes" will allow any user to post comments irrespective of the role permission settings.');
define($const_prefix . '_C_NUMNODES', 'Number of articles to display on top page');
define($const_prefix . '_C_NUMCOMS', 'Number of comments to display in one page');
define($const_prefix . '_C_NUMTBS', 'Number of trackbacks to display in one page');
define($const_prefix . '_C_NUMVOTES', 'Number of votes to display in one page');
define($const_prefix . '_C_UTIME', 'Length of time a user can edit own comment');
define($const_prefix . '_C_UTIME_OPT1', 'Edit not allowed');
define($const_prefix . '_C_UTIME_OPT2', '1 hour');
define($const_prefix . '_C_UTIME_OPT3', '2 hours');
define($const_prefix . '_C_UTIME_OPT4', '1 day');
define($const_prefix . '_C_UTIME_OPT5', '2 days');
define($const_prefix . '_C_UTIME_OPT6', '1 week');
define($const_prefix . '_C_UTIME_OPT7', '10 days');
define($const_prefix . '_C_UTIME_OPT8', '30 days');
define($const_prefix . '_C_NUMVPOP', 'Number of votes required for an article to become popular');
define($const_prefix . '_C_UPCOMING', 'Use the upcoming article feature');
define($const_prefix . '_C_UPCOMINGD', 'If disabled, all articles will be published as soon as it is submitted.');
define($const_prefix . '_C_VOTING', 'Use the voting feature');
define($const_prefix . '_C_VOTINGD', 'If enabled, registered users would be able to vote for each article');
define($const_prefix . '_C_PERIOD', 'The default period to display articles on top page');
define($const_prefix . '_C_PERIOD_OPT1', 'Newest first (all period)');
define($const_prefix . '_C_PERIOD_OPT2', 'Top voted first (24 hours)');
define($const_prefix . '_C_PERIOD_OPT3', 'Top voted first (1 week)');
define($const_prefix . '_C_PERIOD_OPT4', 'Top voted first (1 month)');
define($const_prefix . '_C_PERIOD_OPT5', 'Top voted first (all period)');
define($const_prefix . '_C_PERIOD_OPT6', 'Newly commented first');
define($const_prefix . '_C_PERIOD_OPT7', 'Last active first');
define($const_prefix . '_C_TOPTITLE', 'Page title of Xigg top page');
define($const_prefix . '_C_HPURL', 'Homepage URL');
define($const_prefix . '_C_COMMENT', 'Use the comment feature');
define($const_prefix . '_C_COMMENTD', 'Enable this feature to allow comments to be posted for each article.');
define($const_prefix . '_C_TBACK', 'Use the trackback feature');
define($const_prefix . '_C_TBACKD', 'Enable this feature to allow trackbacks to be received for each article.');
define($const_prefix . '_C_SHOWVC', 'Display view count for each article');
}