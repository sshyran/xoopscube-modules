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

define('BIZFORUM_TOPIC_SORT_KEY_TOPIC_ID', 1);
define('BIZFORUM_TOPIC_SORT_KEY_TOPIC_TITLE', 2);
define('BIZFORUM_TOPIC_SORT_KEY_CAT_ID', 3);
define('BIZFORUM_TOPIC_SORT_KEY_UID', 4);
define('BIZFORUM_TOPIC_SORT_KEY_GUEST_NAME', 5);
define('BIZFORUM_TOPIC_SORT_KEY_EXTERNAL_LINK', 6);
define('BIZFORUM_TOPIC_SORT_KEY_BODYTEXT', 7);
define('BIZFORUM_TOPIC_SORT_KEY_OPTION', 8);
define('BIZFORUM_TOPIC_SORT_KEY_REG_UNIXTIME', 9);
define('BIZFORUM_TOPIC_SORT_KEY_LAST_ID', 10);
define('BIZFORUM_TOPIC_SORT_KEY_LAST_UNIXTIME', 11);
define('BIZFORUM_TOPIC_SORT_KEY_DEFAULT', '-'.BIZFORUM_TOPIC_SORT_KEY_LAST_UNIXTIME);

/**
 * Bizforum_TopicFilterForm
**/
class Bizforum_TopicFilterForm extends Bizforum_AbstractFilterForm
{
    /**
     * @var  string[]
     * 
     * @public
    **/
    var $mSortKeys = array(
        BIZFORUM_TOPIC_SORT_KEY_TOPIC_ID => 'topic_id',
        BIZFORUM_TOPIC_SORT_KEY_TOPIC_TITLE => 'topic_title',
        BIZFORUM_TOPIC_SORT_KEY_CAT_ID => 'cat_id',
        BIZFORUM_TOPIC_SORT_KEY_UID => 'uid',
        BIZFORUM_TOPIC_SORT_KEY_GUEST_NAME => 'guest_name',
        BIZFORUM_TOPIC_SORT_KEY_EXTERNAL_LINK => 'external_link',
        BIZFORUM_TOPIC_SORT_KEY_BODYTEXT => 'bodytext',
        BIZFORUM_TOPIC_SORT_KEY_OPTION => 'option',
        BIZFORUM_TOPIC_SORT_KEY_REG_UNIXTIME => 'reg_unixtime',
        BIZFORUM_TOPIC_SORT_KEY_LAST_ID => 'last_id',
        BIZFORUM_TOPIC_SORT_KEY_LAST_UNIXTIME => 'last_unixtime'
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
        return BIZFORUM_TOPIC_SORT_KEY_DEFAULT;
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
    
        if (($value = $root->mContext->mRequest->getRequest('topic_id')) !== null) {
            $this->mNavi->addExtra('topic_id', $value);
            $this->_mCriteria->add(new Criteria('topic_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('topic_title')) !== null) {
            $this->mNavi->addExtra('topic_title', $value);
            $this->_mCriteria->add(new Criteria('topic_title', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('cat_id')) !== null) {
            $this->mNavi->addExtra('cat_id', $value);
            $this->_mCriteria->add(new Criteria('cat_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
            $this->mNavi->addExtra('uid', $value);
            $this->_mCriteria->add(new Criteria('uid', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('guest_name')) !== null) {
            $this->mNavi->addExtra('guest_name', $value);
            $this->_mCriteria->add(new Criteria('guest_name', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('external_link')) !== null) {
            $this->mNavi->addExtra('external_link', $value);
            $this->_mCriteria->add(new Criteria('external_link', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('reg_unixtime')) !== null) {
            $this->mNavi->addExtra('reg_unixtime', $value);
            $this->_mCriteria->add(new Criteria('reg_unixtime', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('last_id')) !== null) {
            $this->mNavi->addExtra('last_id', $value);
            $this->_mCriteria->add(new Criteria('last_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('last_unixtime')) !== null) {
            $this->mNavi->addExtra('last_unixtime', $value);
            $this->_mCriteria->add(new Criteria('last_unixtime', $value));
        }
    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
