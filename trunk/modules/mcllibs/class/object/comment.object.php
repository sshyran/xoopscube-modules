<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class McllibsCommentObject extends XoopsSimpleObject
{
  public function __construct()
  {
    $this->initVar('com_modid', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('com_itemid', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('com_id', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('com_text', XOBJ_DTYPE_TEXT, '', false);
    $this->initVar('com_uid', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('com_name', XOBJ_DTYPE_STRING, '', true);
    $this->initVar('com_ip', XOBJ_DTYPE_STRING, '0.0.0.0', true);
    $this->initVar('com_time', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('com_status', XOBJ_DTYPE_INT, '0', true);
    $this->initVar('com_xcode', XOBJ_DTYPE_INT, '0', true);
  }
}
?>