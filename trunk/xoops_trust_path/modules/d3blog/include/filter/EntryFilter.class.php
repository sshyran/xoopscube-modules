<?php
/**
 * @version $Id: EntryFilter.class.php 466 2008-06-08 08:18:40Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(dirname(__FILE__))).'/lib/Filter.php';
require_once dirname(dirname(dirname(__FILE__))).'/lib/perm.php';

if(!class_exists('EntryFilter')) {
class EntryFilter extends myAbstractFilterForm {
    var $bid_ = null;
    var $cid_ = null;
    var $uid_ = null;
    var $cids_ = null;
    var $date_ = null;
    // extra
    var $perpage_ = null;
    var $start_ = 0;
    var $extra_uri_ = null;
    var $subtitle_ = null;
    var $breadcrumbs_info_ = null;
    var $mydirname_;
    var $feeder_ = null;
        
    function EntryFilter() {
        $this->fetch();
        $this->err_render_ = new myFormErrorRender();
    }
    
    function fetch()
    {
        $this->start_ = isset($_GET['start']) ? intval($_GET['start']) : 0;
        $this->cid_ = isset($_GET['cid']) ? intval($_GET['cid']) : null;
        $this->uid_ = isset($_GET['uid']) ? intval($_GET['uid']) : null;
        $this->date_ = isset($_GET['date']) ? $_GET['date'] : null;
        // extra
        $this->extra_uri_ = '';
        $this->subtitle_ = '';
        $this->breadcrumbs_info_ = array();
        $this->feeder_ = array();
    }

    function &getCriteria($start=0, $limit=0)
    {
        global $currentUser;
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $myts =& d3blogTextSanitizer::getInstance();
        $liason = '';
        $subtitle = array();
        
        $criteria =& $this->getDefaultCriteria($start, $limit);

        if($this->date_) {
            $length = strlen(($this->date_));
            $date = null;
            if(preg_match("/(\d{4})?(\d{2})?(\d{2})?/", $this->date_, $matches)) {
                if(isset($matches[1])) {
                    $date = $matches[1];
                    if(isset($matches[2])) {
                        $date .= $matches[2];
                        if(isset($matches[3])) {
                            $date .= $matches[3];
                        }
                    }
                }
            }
            if($length != strlen($date) || empty($date) || !checkdate(isset($matches[2])? intval($matches[2]) : 1, isset($matches[3])? intval($matches[3]) : 1, intval($matches[1]))) {
                $this->addError(sprintf(_MD_D3BLOG_ERROR_DATE_FORMAT_ILLEGAL, $myts->htmlSpecialChars($this->date_)));
                return false;
                break;
            }        
        
            $criteria->add( new criteria(sprintf('left(from_unixtime(published + %d) + 0, %d)', $currentUser->timeoffset(), $length) , strval($date)));
            
            $this->extra_uri_ .= $liason.'date='.strval($date);
            $liason = '&amp';
                    
            $subtitle[] = sprintf(_MD_D3BLOG_LANG_ENTRIES_IN_PERIOD, $date);
        
            $this->breadcrumbs_info_[] = array(
                'name' => sprintf(_MD_D3BLOG_LANG_ENTRIES_IN_PERIOD, $date),
                'url' => sprintf('%s/modules/%s/index.php?date=%s', XOOPS_URL, $this->mydirname_, strval($date))
            );        
        }

        if($this->cid_) {
            
            $cat_handler =& $myModule->getHandler('category');
            $category = $cat_handler->get(intval($this->cid_));
            if(!$category) {
                $this->addError(sprintf(_MD_D3BLOG_ERROR_NO_SUCH_CATEGORY, intval($this->cid_)));
                return false;
            }
            
            $cat_ids =& $cat_handler->getAllChildId(intval($this->cid_));
            array_unshift($cat_ids, intval($this->cid_));
            $criteria->add(new Criteria('cid', '('.implode(',',$cat_ids).')', 'IN'));
            
            $this->extra_uri_ .= $liason.'cid='.intval($this->cid_);
        
            $subtitle[] = sprintf(_MD_D3BLOG_LANG_ENTRIES_OF_CATEGORY, $category->getVar('name'));

            $cat_array =& $cat_handler->getNicePathArrayFromId(intval($this->cid_),
                            sprintf('%s/modules/%s/index.php', XOOPS_URL, $this->mydirname_));
            $this->breadcrumbs_info_ = array_merge($this->breadcrumbs_info_, $cat_array);
           
            // what feeder
            $this->feeder_ = array(
                'lang' => sprintf(_MD_D3BLOG_LANG_WHAT_CATEGORY_ENTRY, $category->getVar('name')),
                'uri' => '&amp;cid='.intval($this->cid_)
            );           
        }
      
        if($this->uid_) {
            $blogger = new XoopsUser(intval($this->uid_));
            if(!$blogger) {
                $this->addError(sprintf(_MD_D3BLOG_ERROR_NO_SUCH_USER, intval($this->uid_)));
                return false;
            }
          
            $criteria->add(new Criteria('uid', intval($this->uid_)));
            
            $this->extra_uri_ .= $liason.'uid='.intval($this->uid_);
            $liason = '&amp';
            
            $subtitle[] = sprintf(_MD_D3BLOG_LANG_ENTRIES_OF, $blogger->uname());
        
            $this->breadcrumbs_info_[] = array(
                'name'=> sprintf(_MD_D3BLOG_LANG_ENTRIES_OF, $blogger->uname()),
                'url' => sprintf('%s/modules/%s/index.php?uid=%d', XOOPS_URL, $this->mydirname_, intval($this->uid_))
            );
                
            // what feeder
            $this->feeder_ = array(
                'lang' => sprintf(_MD_D3BLOG_LANG_WHOS_ENTRY, $blogger->uname()),
                'uri' => '&amp;uid='.intval($this->uid_)
            );
        }

        $subtitle = array_reverse($subtitle);
        $this->subtitle_ = $myts->htmlSpecialChars(implode('>', $subtitle));
        return $criteria;

    }

    function &getDefaultCriteria($start=0, $limit=0, $prefix='')
    {
        global $currentUser;
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $myts =& d3blogTextSanitizer::getInstance();
        
        $uid = $currentUser->uid();

        // basic retrieval permission
        $criteria = new CriteriaCompo();
        
        $prefix = $myts->addSlashes($prefix);
        // check if user is an editor
        if(!$currentUser->isEditor($myModule->module_id)) {
            $owner_criteria = new CriteriaCompo();
            $owner_criteria->add(new Criteria('uid', $uid, '=', $prefix));
            $approval_criteria = new CriteriaCompo(new Criteria('approved', 1, '=', $prefix));
            $approval_criteria->add(new Criteria('published', time(), '<=', $prefix));
            $owner_criteria->add($approval_criteria, 'OR');
            $criteria->add($owner_criteria);
        }

        if($limit > 0) {
            $criteria->setStart($start);
            $criteria->setLimit($limit);
        }

        return $criteria;
    }
    
}

}

$filter_class_name = $mydirname.'EntryFilter';
if( ! class_exists($filter_class_name) ) {
eval('
class '. $filter_class_name .' extends EntryFilter {
    var $mydirname_; 
    function '. $filter_class_name .'() {
        parent::EntryFilter();
        $this->mydirname_ = "'.$mydirname.'";
    }

    function &getInstance()
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