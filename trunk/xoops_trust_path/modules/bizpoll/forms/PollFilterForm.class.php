<?php
/**
 * @file
 * @package bizpoll
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once BIZPOLL_TRUST_PATH . '/class/AbstractFilterForm.class.php';

define('BIZPOLL_POLL_SORT_KEY_POLL_ID', 1);
define('BIZPOLL_POLL_SORT_KEY_ENQ_ID', 2);
define('BIZPOLL_POLL_SORT_KEY_UID', 3);
define('BIZPOLL_POLL_SORT_KEY_NAME', 4);
define('BIZPOLL_POLL_SORT_KEY_CHOICE_ID', 5);
define('BIZPOLL_POLL_SORT_KEY_IP', 6);
define('BIZPOLL_POLL_SORT_KEY_COMMENT', 7);
define('BIZPOLL_POLL_SORT_KEY_REG_UNIXTIME', 8);
define('BIZPOLL_POLL_SORT_KEY_DEFAULT', BIZPOLL_POLL_SORT_KEY_POLL_ID);

/**
 * Bizpoll_PollFilterForm
**/
class Bizpoll_PollFilterForm extends Bizpoll_AbstractFilterForm
{
    /**
     * @var  string[]
     * 
     * @public
    **/
    var $mSortKeys = array(
        BIZPOLL_POLL_SORT_KEY_POLL_ID => 'poll_id',
        BIZPOLL_POLL_SORT_KEY_ENQ_ID => 'enq_id',
        BIZPOLL_POLL_SORT_KEY_UID => 'uid',
        BIZPOLL_POLL_SORT_KEY_NAME => 'name',
        BIZPOLL_POLL_SORT_KEY_CHOICE_ID => 'choice_id',
        BIZPOLL_POLL_SORT_KEY_IP => 'ip',
        BIZPOLL_POLL_SORT_KEY_COMMENT => 'comment',
        BIZPOLL_POLL_SORT_KEY_REG_UNIXTIME => 'reg_unixtime'
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
        return BIZPOLL_POLL_SORT_KEY_DEFAULT;
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
    
        if (($value = $root->mContext->mRequest->getRequest('poll_id')) !== null) {
            $this->mNavi->addExtra('poll_id', $value);
            $this->_mCriteria->add(new Criteria('poll_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('enq_id')) !== null) {
            $this->mNavi->addExtra('enq_id', $value);
            $this->_mCriteria->add(new Criteria('enq_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
            $this->mNavi->addExtra('uid', $value);
            $this->_mCriteria->add(new Criteria('uid', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('name')) !== null) {
            $this->mNavi->addExtra('name', $value);
            $this->_mCriteria->add(new Criteria('name', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('choice_id')) !== null) {
            $this->mNavi->addExtra('choice_id', $value);
            $this->_mCriteria->add(new Criteria('choice_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('ip')) !== null) {
            $this->mNavi->addExtra('ip', $value);
            $this->_mCriteria->add(new Criteria('ip', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('reg_unixtime')) !== null) {
            $this->mNavi->addExtra('reg_unixtime', $value);
            $this->_mCriteria->add(new Criteria('reg_unixtime', $value));
        }
    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
