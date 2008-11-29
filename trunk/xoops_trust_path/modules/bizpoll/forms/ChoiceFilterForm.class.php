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

define('BIZPOLL_CHOICE_SORT_KEY_CHOICE_ID', 1);
define('BIZPOLL_CHOICE_SORT_KEY_TITLE', 2);
define('BIZPOLL_CHOICE_SORT_KEY_ENQ_ID', 3);
define('BIZPOLL_CHOICE_SORT_KEY_UID', 4);
define('BIZPOLL_CHOICE_SORT_KEY_WEIGHT', 5);
define('BIZPOLL_CHOICE_SORT_KEY_DESCRIPTION', 6);
define('BIZPOLL_CHOICE_SORT_KEY_DEFAULT', BIZPOLL_CHOICE_SORT_KEY_CHOICE_ID);

/**
 * Bizpoll_ChoiceFilterForm
**/
class Bizpoll_ChoiceFilterForm extends Bizpoll_AbstractFilterForm
{
    /**
     * @var  string[]
     * 
     * @public
    **/
    var $mSortKeys = array(
        BIZPOLL_CHOICE_SORT_KEY_CHOICE_ID => 'choice_id',
        BIZPOLL_CHOICE_SORT_KEY_TITLE => 'title',
        BIZPOLL_CHOICE_SORT_KEY_ENQ_ID => 'enq_id',
        BIZPOLL_CHOICE_SORT_KEY_UID => 'uid',
        BIZPOLL_CHOICE_SORT_KEY_WEIGHT => 'weight',
        BIZPOLL_CHOICE_SORT_KEY_DESCRIPTION => 'description'
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
        return BIZPOLL_CHOICE_SORT_KEY_DEFAULT;
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
    
        if (($value = $root->mContext->mRequest->getRequest('choice_id')) !== null) {
            $this->mNavi->addExtra('choice_id', $value);
            $this->_mCriteria->add(new Criteria('choice_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('title')) !== null) {
            $this->mNavi->addExtra('title', $value);
            $this->_mCriteria->add(new Criteria('title', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('enq_id')) !== null) {
            $this->mNavi->addExtra('enq_id', $value);
            $this->_mCriteria->add(new Criteria('enq_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
            $this->mNavi->addExtra('uid', $value);
            $this->_mCriteria->add(new Criteria('uid', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('weight')) !== null) {
            $this->mNavi->addExtra('weight', $value);
            $this->_mCriteria->add(new Criteria('weight', $value));
        }
    
        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}

?>
