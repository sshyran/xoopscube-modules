<?php
$root = XCube_Root::getSingleton();
if (is_object($root->mContext->mUser) && $root->mContext->mUser->isInRole('Site.GuestUser')) {
  define('_MI_MYFRIEND_NAME', 'About the initial registration');
} else {
  define('_MI_MYFRIEND_NAME', 'MyFriend');
}

define('_MI_MYFRIEND_GROUP', 'Users Group');
define('_MI_MYFRIEND_GROUP_DESC', 'Group of user who uses it with SNS');

define('_MI_MYFRIEND_BLOCK_NAME', 'Newly arrived block');
define('_MI_MYFRIEND_SUB_SEARCH', 'User search');
define('_MI_MYFRIEND_SUB_FAVORITES', 'Favorites Users');

define('_MI_MYFRIEND_DELDAYS', 'Deletion days');
define('_MI_MYFRIEND_DELDAYS_DESC', 'The days when the invitation person is deleted.');
define('_MI_MYFRIEND_INSTALL_ERROR', 'This module doesn\'t operate if it is not PHP5.0 or later.');
?>