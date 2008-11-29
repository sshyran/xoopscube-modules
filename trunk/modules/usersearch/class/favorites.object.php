<?php
class UsersearchFavoritesObject extends XoopsSimpleObject
{
  public function __construct()
  {
    $this->initVar('id', XOBJ_DTYPE_INT, 0, true);
    $this->initVar('mid', XOBJ_DTYPE_INT, 0, true);
    $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
    $this->initVar('fuid', XOBJ_DTYPE_INT, 0, true);
    $this->initVar('weight', XOBJ_DTYPE_INT, 0, true);
  }
}
?>
