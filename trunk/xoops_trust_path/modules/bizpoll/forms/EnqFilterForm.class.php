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

define('BIZPOLL_ENQ_SORT_KEY_ENQ_ID', 1);
define('BIZPOLL_ENQ_SORT_KEY_TITLE', 2);
define('BIZPOLL_ENQ_SORT_KEY_CAT_ID', 3);
define('BIZPOLL_ENQ_SORT_KEY_UID', 4);
define('BIZPOLL_ENQ_SORT_KEY_TYPE', 5);
define('BIZPOLL_ENQ_SORT_KEY_PUB_UNIXTIME', 6);
define('BIZPOLL_ENQ_SORT_KEY_END_UNIXTIME', 7);
define('BIZPOLL_ENQ_SORT_KEY_CHOICES', 8);
define('BIZPOLL_ENQ_SORT_KEY_DESCRIPTION', 9);
define('BIZPOLL_ENQ_SORT_KEY_OPTION', 10);
define('BIZPOLL_ENQ_SORT_KEY_REG_UNIXTIME', 11);
define('BIZPOLL_ENQ_SORT_KEY_DEFAULT', BIZPOLL_ENQ_SORT_KEY_ENQ_ID);

/**
 * Bizpoll_EnqFilterForm
**/
class Bizpoll_EnqFilterForm extends Bizpoll_AbstractFilterForm
{
    /**
     * @var  string[]
     * 
     * @public
    **/
    var $mSortKeys = array(
        BIZPOLL_ENQ_SORT_KEY_ENQ_ID => 'enq_id',
        BIZPOLL_ENQ_SORT_KEY_TITLE => 'title',
        BIZPOLL_ENQ_SORT_KEY_CAT_ID => 'cat_id',
        BIZPOLL_ENQ_SORT_KEY_UID => 'uid',
        BIZPOLL_ENQ_SORT_KEY_TYPE => 'type',
        BIZPOLL_ENQ_SORT_KEY_PUB_UNIXTIME => 'pub_unixtime',
        BIZPOLL_ENQ_SORT_KEY_END_UNIXTIME => 'end_unixtime',
        BIZPOLL_ENQ_SORT_KEY_CHOICES => 'choices',
        BIZPOLL_ENQ_SORT_KEY_DESCRIPTION => 'description',
        BIZPOLL_ENQ_SORT_KEY_OPTION => 'option',
        BIZPOLL_ENQ_SORT_KEY_REG_UNIXTIME => 'reg_unixtime'
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
        return BIZPOLL_ENQ_SORT_KEY_DEFAULT;
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
    
        if (($value = $root->mContext->mRequest->getRequest('enq_id')) !== null) {
            $this->mNavi->addExtra('enq_id', $value);
            $this->_mCriteria->add(new Criteria('enq_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('title')) !== null) {
            $this->mNavi->addExtra('title', $value);
            $this->_mCriteria->add(new Criteria('title', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('cat_id')) !== null) {
            $this->mNavi->addExtra('cat_id', $value);
            $this->_mCriteria->add(new Criteria('cat_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
            $this->mNavi->addExtra('uid', $value);
            $this->_mCriteria->add(new Criteria('uid', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('type')) !== null) {
            $this->mNavi->addExtra('type', $value);
            $this->_mCriteria->add(new Criteria('type', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('pub_unixtime')) !== null) {
            $this->mNavi->addExtra('pub_unixtime', $value);
            $this->_mCriteria->add(new Criteria('pub_unixtime', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('end_unixtime')) !== null) {
            $this->mNavi->addExtra('end_unixtime', $value);
            $this->_mCriteria->add(new Criteria('end_unixtime', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('reg_unixtime')) !== null) {
            $this->mNavi->addExtra('reg_unixtime', $value);
            $this->_mCriteria->add(new Criteria('reg_unixtime', $value));
        }
    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
