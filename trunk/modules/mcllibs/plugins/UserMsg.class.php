<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_UserMsg
{
  public $mXCodePriority = 50;
  
  public function getXCodePatterns()
  {
    $patterns[] = "/\[user\=(['\"]?)([0-9]{1,5})\\1\](.*)\[\/user\]/esU";
    $replacements[0][] = $replacements[1][] = "MCLXCode_UserMsg::_chkuser('\\3', '\\2')";
    
    $patterns[] = "/\[user\](.*)\[\/user\]/esU";
    $replacements[0][] = $replacements[1][] = "MCLXCode_UserMsg::_chkuser('\\1')";
    
    $patterns[] = "/\[guest\](.*)\[\/guest\]/esU";
    $replacements[0][] = $replacements[1][] = "MCLXCode_UserMsg::_chkuser('\\1', '-1')";
    
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public static function _chkuser($msg, $id = 0)
  {
    $root = XCube_Root::getSingleton();
    if ($root->mContext->mUser->isInRole('Site.RegisteredUser') && $id > 0) {
      $uid = $root->mContext->mXoopsUser->get('uid');
      if ( $uid == intval($id) ) {
        return $msg;
      }
    } elseif ($root->mContext->mUser->isInRole('Site.RegisteredUser') && $id == 0) {
      return $msg;
    } elseif (!$root->mContext->mUser->isInRole('Site.RegisteredUser') && $id == -1) {
      return $msg;
    }
    return "";
  }
}
?>
