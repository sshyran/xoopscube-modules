<?php
class UsersearchUsersObject extends XoopsSimpleObject
{
  public function __construct()
  {
    $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
    $this->initVar('name', XOBJ_DTYPE_STRING, null, false, 60);
    $this->initVar('uname', XOBJ_DTYPE_STRING, null, true, 25);
    $this->initVar('email', XOBJ_DTYPE_STRING, null, true, 60);
    $this->initVar('url', XOBJ_DTYPE_STRING, null, false, 100);
    $this->initVar('user_avatar', XOBJ_DTYPE_STRING, null, false, 30);
    $this->initVar('user_regdate', XOBJ_DTYPE_INT, null, false);
    $this->initVar('user_icq', XOBJ_DTYPE_STRING, null, false, 15);
    $this->initVar('user_from', XOBJ_DTYPE_STRING, null, false, 100);
    $this->initVar('user_sig', XOBJ_DTYPE_TXTAREA, null, false, null);
    $this->initVar('user_viewemail', XOBJ_DTYPE_INT, 0, false);
    $this->initVar('actkey', XOBJ_DTYPE_STRING, null, false);
    $this->initVar('user_aim', XOBJ_DTYPE_STRING, null, false, 18);
    $this->initVar('user_yim', XOBJ_DTYPE_STRING, null, false, 25);
    $this->initVar('user_msnm', XOBJ_DTYPE_STRING, null, false, 100);
    $this->initVar('pass', XOBJ_DTYPE_STRING, null, false, 32);
    $this->initVar('posts', XOBJ_DTYPE_INT, null, false);
    $this->initVar('attachsig', XOBJ_DTYPE_INT, 0, false);
    $this->initVar('rank', XOBJ_DTYPE_INT, 0, false);
    $this->initVar('level', XOBJ_DTYPE_INT, 0, false);
    $this->initVar('theme', XOBJ_DTYPE_STRING, null, false);
    $this->initVar('timezone_offset', XOBJ_DTYPE_FLOAT, null, false);
    $this->initVar('last_login', XOBJ_DTYPE_INT, 0, false);
    $this->initVar('umode', XOBJ_DTYPE_STRING, null, false);
    $this->initVar('uorder', XOBJ_DTYPE_INT, 1, false);
    $this->initVar('notify_method', XOBJ_DTYPE_STRING, 1, false);
    $this->initVar('notify_mode', XOBJ_DTYPE_STRING, 0, false); 
    $this->initVar('user_occ', XOBJ_DTYPE_STRING, null, false, 100);
    $this->initVar('bio', XOBJ_DTYPE_TXTAREA, null, false, null);
    $this->initVar('user_intrest', XOBJ_DTYPE_STRING, null, false, 150);
    $this->initVar('user_mailok', XOBJ_DTYPE_INT, 1, false);
  }
}
?>
