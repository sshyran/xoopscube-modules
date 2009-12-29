<?php
/**
 * @version $Id: TrackbackFilter.class.php 313 2008-02-29 12:52:07Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(dirname(__FILE__))).'/lib/Filter.php';

if(!class_exists('TrackbackFilter')) {
class TrackbackFilter extends myAbstractFilterForm {
    var $mydirname_;
    
//    function TrackbackFilter($dirname) {
//    	$this->mydiname_ = $dirname;
//    }

    function fetch()
    {
//        $this->mid_ = '';
    }

    function getCriteria($start=0, $limit=0)
    {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $criteria = $this->getDefaultCriteria($start, $limit);

        global $currentUser;
        if(!$currentUser->isEditor($myModule->module_id))
            $criteria->add(new criteria('approved', 1));

        return ($criteria);
    }

    function getDefaultCriteria($start=0, $limit=0)
    {
        $criteria = new CriteriaCompo();
        if($limit > 0) {
            $criteria->setStart($start);
            $criteria->setLimit($limit);
        }

        $criteria->setSort('created');
        $criteria->setOrder('DESC');
        
        return $criteria;
    }
    
}

}

$filter_class_name = $mydirname.'TrackbackFilter';
if( ! class_exists($filter_class_name) ) {
eval('
class '. $filter_class_name .' extends TrackbackFilter {
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