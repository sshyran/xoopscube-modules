<?php
/**
 * @version $Id: CategoryFilter.class.php 281 2008-02-23 09:49:31Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(dirname(__FILE__))).'/lib/Filter.php';
require_once dirname(dirname(dirname(__FILE__))).'/lib/perm.php';

if(!class_exists('CategoryFilter')) {
class CategoryFilter extends myAbstractFilterForm {
    var $cid_ = null;
    
    function fetch()
    {
//        $this->cid_ = $this->getPositiveIntger('cid');
//        $this->perms_ = $this->getPositiveIntger('perms');
    }

    function getCriteria($start=0,$limit=0)
    {
        $criteria = $this->getDefaultCriteria($start, $limit);

        if($this->cid_) {
            if(is_array($this->cid_))
                $criteria->add(new Criteria('cid', '('.implode(',',$this->cid_).')', 'IN'));
            else
                $criteria->add(new Criteria('cid',$this->cid_));
        }
        return ($criteria);
    }

    function &getDefaultCriteria($start=0, $limit=0)
    {
        $criteria = new CriteriaCompo();
        if($limit > 0) {
            $criteria->setStart($start);
            $criteria->setLimit($limit);
        }

        $criteria->setSort('weight');
        $criteria->setOrder('ASC');
        
        return $criteria;
    }
    
}

class CategoryPublicFilter extends CategoryFilter {
    var $cid_ = null;
    var $perms_ = null;
    
    function fetch()
    {
//        $this->cid_ = $this->getPositiveIntger('cid');
//        $this->perms_ = $this->getPositiveIntger('perms');
    }

    function getCriteria($start=0, $limit=0)
    {
        $criteria = parent::getCriteria($start,$limit);
        if($this->cid_)
            $criteria->add(new Criteria('cid',$this->cid_));
        
        return $criteria;
    }

    function &getExtra()
    {
        // set array
        $ret=array();
        if($this->cid_)
            $ret['cid'] = $this->cid_;

        if($this->approve_)
            $ret['perms'] = $this->perms_;

        return $ret;
    }

}

}

$filter_class_name = $mydirname.'CategoryFilter';
if( ! class_exists($filter_class_name) ) {
eval('
class '. $filter_class_name .' extends CategoryFilter {
    var $mydirname_; 
    function '. $filter_class_name .'() {
        $this->mydirname_ = "'.$mydirname.'";
    }

    function getInstance()
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new '. $filter_class_name .'();
        }
        return $instance;
    }
}
');
}

?>