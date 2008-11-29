<?php
/**
 * @file
 * @package bizforum
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once BIZFORUM_TRUST_PATH . '/class/AbstractFilterForm.class.php';

define('BIZFORUM_POST_SORT_KEY_POST_ID', 1);
define('BIZFORUM_POST_SORT_KEY_UID', 2);
define('BIZFORUM_POST_SORT_KEY_GUEST_NAME', 3);
define('BIZFORUM_POST_SORT_KEY_P_ID', 4);
define('BIZFORUM_POST_SORT_KEY_TOPIC_ID', 5);
define('BIZFORUM_POST_SORT_KEY_BODYTEXT', 6);
define('BIZFORUM_POST_SORT_KEY_REG_UNIXTIME', 7);
define('BIZFORUM_POST_SORT_KEY_DEFAULT', BIZFORUM_POST_SORT_KEY_POST_ID);

/**
 * Bizforum_PostFilterForm
**/
class Bizforum_PostFilterForm extends Bizforum_AbstractFilterForm
{
    /**
     * @var  string[]
     * 
     * @public
    **/
    var $mSortKeys = array(
        BIZFORUM_POST_SORT_KEY_POST_ID => 'post_id',
        BIZFORUM_POST_SORT_KEY_UID => 'uid',
        BIZFORUM_POST_SORT_KEY_GUEST_NAME => 'guest_name',
        BIZFORUM_POST_SORT_KEY_P_ID => 'p_id',
        BIZFORUM_POST_SORT_KEY_TOPIC_ID => 'topic_id',
        BIZFORUM_POST_SORT_KEY_BODYTEXT => 'bodytext',
        BIZFORUM_POST_SORT_KEY_REG_UNIXTIME => 'reg_unixtime'
    );

    /**
     * getDefaultSortKey
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function getDefaultSortKey()
    {
        return BIZFORUM_POST_SORT_KEY_DEFAULT;
    }

    /**
     * fetch
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function fetch()
    {
        parent::fetch();
    
        $root =& XCube_Root::getSingleton();
    
        if (($value = $root->mContext->mRequest->getRequest('post_id')) !== null) {
            $this->mNavi->addExtra('post_id', $value);
            $this->_mCriteria->add(new Criteria('post_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
            $this->mNavi->addExtra('uid', $value);
            $this->_mCriteria->add(new Criteria('uid', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('guest_name')) !== null) {
            $this->mNavi->addExtra('guest_name', $value);
            $this->_mCriteria->add(new Criteria('guest_name', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('p_id')) !== null) {
            $this->mNavi->addExtra('p_id', $value);
            $this->_mCriteria->add(new Criteria('p_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('topic_id')) !== null) {
            $this->mNavi->addExtra('topic_id', $value);
            $this->_mCriteria->add(new Criteria('topic_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('reg_unixtime')) !== null) {
            $this->mNavi->addExtra('reg_unixtime', $value);
            $this->_mCriteria->add(new Criteria('reg_unixtime', $value));
        }
    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
