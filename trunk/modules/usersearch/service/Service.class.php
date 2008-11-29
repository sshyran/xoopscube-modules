<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class Usersearch_Return extends XCube_Object
{
  public function getPropertyDefinition()
  {
    $ret = array(
      S_PUBLIC_VAR('object udata'),
      S_PUBLIC_VAR('object pagenavi'),
    );
    return $ret;
  }
}

class Usersearch_ReturnArray extends XCube_ObjectArray
{
  public function getClassName()
  {
    return 'Usersearch_Return';
  }
}

class Usersearch_Favorites extends XCube_Object
{
  public function getPropertyDefinition()
  {
    $ret = array(
      S_PUBLIC_VAR('object udata'),
    );
    return $ret;
  }
}

class Usersearch_FavoritesArray extends XCube_ObjectArray
{
  public function getClassName()
  {
    return 'Usersearch_Favorites';
  }
}

class Usersearch_Service extends XCube_Service
{
  public $mServiceName = 'Usersearch_Service';
  public $mNameSpace = 'Usersearch';
  public $mClassName = 'Usersearch_Service';
  
  public function prepare()
  {
    $this->addType('Usersearch_Return');
    $this->addType('Usersearch_ReturnArray');
    $this->addType('Usersearch_Favorites');
    $this->addType('Usersearch_FavoritesArray');
    $this->addFunction(S_PUBLIC_FUNC('Usersearch_ReturnArray getUserList(string uname, int stype, string url, int page)'));
    $this->addFunction(S_PUBLIC_FUNC('Usersearch_FavoritesArray getFavorites(int mid)'));
    $this->addFunction(S_PUBLIC_FUNC('Usersearch_FavoritesArray getFavoritesUsers(int mid)'));
    $this->addFunction(S_PUBLIC_FUNC('bool addFavorites(int mid, int fuid, int weight)'));
    $this->addFunction(S_PUBLIC_FUNC('bool edtFavorites(int id, int weight)'));
    $this->addFunction(S_PUBLIC_FUNC('bool delFavorites(int id)'));
  }
  
  private function _loadlibs()
  {
    require_once XOOPS_MODULE_PATH.'/usersearch/class/PageNavi.class.php';
    require_once XOOPS_MODULE_PATH.'/usersearch/class/tablehandler.class..php';
    require_once XOOPS_MODULE_PATH.'/usersearch/class/users.object.php';
  }
  
  public function getUserList()
  {
    $root = XCube_Root::getSingleton();
    $uname = $root->mContext->mRequest->getRequest('uname');
    $stype = $root->mContext->mRequest->getRequest('stype');
    $url   = $root->mContext->mRequest->getRequest('url');
    $page   = $root->mContext->mRequest->getRequest('page');
    $uid = $root->mContext->mXoopsUser->get('uid');
    if ( $page < 1 ) {
      $page = 5;
    }
    
    switch ($stype) {
      case 0: $t = 'LIKE'; $s = $uname.'%';     break;
      case 1: $t = 'LIKE'; $s = '%'.$uname;     break;
      case 2: $t = 'LIKE'; $s = '%'.$uname.'%'; break;
      case 3: 
      default: $t = '=';    $s = $uname;         break;
    }
    
    $this->_loadlibs();
    $hand = new UsersearchTableObjectHandler('users', 'uid', 'UsersearchUsersObject');
    $mPagenavi = new UsersearchPageNavi($hand);
    $mPagenavi->setPagenum($page);
    $mPagenavi->addCriteria(new WhereElement(_WHERE_FIELD_STRING, 'uname', $s, $t));
    $mPagenavi->addCriteria(new WhereElement(_WHERE_FIELD_INT, 'uid', $uid, '<>'));
    $mPagenavi->setUrl($url);
    $mPagenavi->addSort('uname');
    $mPagenavi->fetch();
    $mPagenavi->mNavi->addExtra('uname', $uname);
    $mPagenavi->mNavi->addExtra('searchtype', $stype);
    $mPagenavi->mNavi->addExtra('dosearch', 1);
    
    $modObj = $hand->getObjects($mPagenavi->getCriteria());
    if ( count($modObj) > 0 ) {
      return array('udata' => $modObj, 'pagenavi' => $mPagenavi->mNavi);
    } else {
      return false;
    }
  }
  
  private function _loadfavolibs()
  {
    require_once XOOPS_MODULE_PATH.'/usersearch/class/tablehandler.class..php';
    require_once XOOPS_MODULE_PATH.'/usersearch/class/favorites.object.php';
  }
  
  public function getFavorites()
  {
    $this->_loadfavolibs();
    $root = XCube_Root::getSingleton();
    $uid = $root->mContext->mXoopsUser->get('uid');
    $mid = $root->mContext->mRequest->getRequest('mid');
    
    $this->_loadlibs();
    $hand = new UsersearchTableObjectHandler('usersearch_favorites', 'id', 'UsersearchFavoritesObject');
    $where = new WhereComp(new WhereElement(_WHERE_FIELD_INT, 'uid', $uid));
    $where->addOrder('weight');
    if ( $mid > 0 ) {
      $w = new WhereTray();
      $w->add(new WhereElement(_WHERE_FIELD_INT, 'mid', $mid));
      $w->add(new WhereElement(_WHERE_FIELD_INT, 'mid', 0), 'OR');
      $where->add($w);
    }
    $where->addOrder('weight');
    return $hand->getObjects($where);
  }
  
  public function getFavoritesUsers()
  {
    $ret = false;
    $fuid = $this->getFavorites();
    if ( is_array($fuid) ) {
      $this->_loadlibs();
      $hand = new UsersearchTableObjectHandler('users', 'uid', 'UsersearchUsersObject');
      foreach ( $fuid as $fuser ) {
        $ret[] = array('userobj' => $hand->get($fuser->get('fuid')), 'fobj' => $fuser);
      }
    }
    return $ret;
  }
  
  public function addFavorites()
  {
    $this->_loadfavolibs();
    $root = XCube_Root::getSingleton();
    $uid = $root->mContext->mXoopsUser->get('uid');
    $mid = $root->mContext->mRequest->getRequest('mid');
    $fuid = $root->mContext->mRequest->getRequest('fuid');
    $weight = $root->mContext->mRequest->getRequest('weight');
    
    $hand = new UsersearchTableObjectHandler('usersearch_favorites', 'id', 'UsersearchFavoritesObject');
    $obj = $hand->create();
    $obj->set('uid', $uid);
    $obj->set('mid', $mid);
    $obj->set('fuid', $fuid);
    $obj->set('weight', $weight);
    return $hand->insert($obj, true);
  }
  
  public function edtFavorites()
  {
    $this->_loadfavolibs();
    $root = XCube_Root::getSingleton();
    $id = $root->mContext->mRequest->getRequest('id');
    $weight = $root->mContext->mRequest->getRequest('weight');
    
    $hand = new UsersearchTableObjectHandler('usersearch_favorites', 'id', 'UsersearchFavoritesObject');
    $obj = $hand->get($id);
    $obj->set('weight', $weight);
    return $hand->insert($obj, true);
  }
  
  public function delFavorites()
  {
    $this->_loadfavolibs();
    $root = XCube_Root::getSingleton();
    $id = $root->mContext->mRequest->getRequest('id');
    
    $hand = new UsersearchTableObjectHandler('usersearch_favorites', 'id', 'UsersearchFavoritesObject');
    $obj = $hand->get($id);
    return $hand->delete($obj, true);
  }
}
?>