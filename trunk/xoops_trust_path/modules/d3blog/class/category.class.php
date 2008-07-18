<?php
/**
 * @version $Id: category.class.php 398 2008-03-26 02:20:50Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

if( ! class_exists('d3blogCategoryObjectBase')){

require_once dirname(dirname(__FILE__)).'/lib/object.php';
require_once dirname(dirname(__FILE__)).'/include/filter/CategoryFilter.class.php';

class d3blogCategoryObjectBase extends myXoopsObject {
    function d3blogCategoryObjectBase($id=null)
    {
        $this->initVar('cid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('pid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, '', true, 255, true);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('imgurl', XOBJ_DTYPE_TXTBOX, '', false, 150, false);
        $this->initVar('created', XOBJ_DTYPE_INT, time(), false);

        if ( is_array ( $id ) )
            $this->assignVars ( $id );
    }

    // Database Connect Model
//    function &getTableInfo()
//    {
//    }
    
    function &getStructure($type='s')
    {
        $ret =& parent::getStructure($type);

        return $ret;
    }
    
    function cid() {
        return $this->getVar('cid');
    }

    function pid() {
        return $this->getVar('pid');
    }

    function name() {
        return $this->getVar('name');
    }
    
    function weight() {
        return $this->getVar('weight');
    }

    function imgurl() {
        return $this->getVar('imgurl');
    }

    function renderImgurl() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $imagepath = preg_replace("|^(.+)/$|", "$1", $myModule->getConfig('categoryicon_path'));
        $imageurl = htmlspecialchars(str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $imagepath), ENT_QUOTES);
        if($this->imgurl()) {
            return sprintf('<img src="%s/%s" alt="%s" style="vertical-align:bottom" />', $imageurl, $this->imgurl(), $this->name());
        } else {
            return null;
        }
    }

}

class d3blogCategoryObjectHandlerBase extends myXoopsObjectHandler
{
    var $filter_;

    function &getDefaultCriteria() {
        // get category thru filter
        $this->filter_ = call_user_func(array($this->mydirname_.'CategoryFilter', 'getInstance'));
        $criteria =& $this->filter_->getDefaultCriteria();
        return $criteria;           
    }

    function &getCriteria() {
        // get category thru filter
        $this->filter_ = call_user_func(array($this->mydirname_.'CategoryFilter', 'getInstance'));
        $this->filter_->cid_ = $this->getPermId();
        $criteria =& $this->filter_->getDefaultCriteria();
        return $criteria;           
    }

    function &getAll() {
        static $__all_categories_cache__;
        
        if(!isset($__all_categories_cache__)) {
            $__all_categories_cache__ = array();
            $criteria = new criteriaCompo();
            $criteria->setSort('weight');
            $objs =& $this->getObjects($criteria);
            foreach($objs as $obj) {
                $__all_categories_cache__[$obj->cid()] = $obj;
            }
        }
        return $__all_categories_cache__;
    }

    function &getById($sel_id) {
        $return = array();
        $catsall =& $this->getAll();
        $cat =& $catsall[intval($sel_id)];
        if($cat)
            $return =& $cat->getStructure();

        return $return;
    }

    /**
     * @param int $sel_id category id
     * @param bool $include_children True returns counts with children altogether
     * @return int $ret counts of entries belonging to the category id
     */
    function &getCountByCategory($sel_id, $include_children=true) {
        static $__count_by_cid_cache__;        

        if(!isset($__count_by_cid_cache__[$this->mydirname_])) {
            $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
            
        	$db =& Database::getInstance();
            $sql = sprintf('SELECT cid, count(bid) as count FROM %s ',
                    $db->prefix($this->mydirname_.'_entry'));
            
            $entry_handler =& $myModule->getHandler('entry');
			$default_criteria =& $entry_handler->getDefaultCriteria();
            // CRITERIA WITH AN ENTRY PERMISSION
            $criteria =& $entry_handler->entryPermCriteria($default_criteria);
            $sql .= $criteria->renderWhere();
            $sql .= ' GROUP BY cid ORDER BY cid';
            $result = $db->query($sql);
            
            $__count_by_cid_cache__[$this->mydirname_] = array();
            $all_categories =& $this->getAll();
            
            $counts = array();
            if($result) {
                while(list($cid, $count) = $db->fetchRow($result)) {
                	$counts[$cid] = $count;
                }
            }
            foreach($all_categories as $key=>$obj) {
                if(!in_array($key, array_keys($counts))) {
                    $__count_by_cid_cache__[$this->mydirname_][$key] = 0;
                } else {
                    $__count_by_cid_cache__[$this->mydirname_][$key] = $counts[$key];
                }
            }
        }

        // return summary of this children
        if(!$include_children) {
            if(isset($__count_by_cid_cache__[$this->mydirname_][$sel_id]))
                return $__count_by_cid_cache__[$this->mydirname_][$sel_id];
            else
                return 0;
        } else {
            $ids =& $this->getAllChildId(intval($sel_id));
            $ids[] = intval($sel_id);
            $return = 0;
            foreach($ids as $id) {
                $return += $__count_by_cid_cache__[$this->mydirname_][$id];
            }
            return $return;
        }        
    }

    /**
     * @brief get all child ids from the category
     */
    function &getAllChildId($sel_id, $idarray=array())
    {
        $categories = $this->getAll();
        if(!count($categories))
            return $idarray;
    
        foreach($categories as $id=>$category) {
            if($sel_id == $category->pid()) {
                $idarray[] = intval($id);
                $idarray = $this->getAllChildId($id, $idarray);            
            }
        }

        return $idarray;  
    }
   
    /**
     * @brief get all child ids from the category with key
     */
    function &getAllChildIds($sel_id=0, $idarray=array())
    {
        $categories = $this->getAll();
        if(!count($categories))
            return $idarray;
    
        foreach($categories as $id=>$category) {
            if($sel_id == $category->pid()) {
                $idarray[$id] = $category->name();
                $idarray = $this->getAllChildIds($id, $idarray);            
            }
        }

        return $idarray;
    }
        
    /**
     * provides category select box
     */
    function &getChildTreeArray($sel_id=0, $idarray=array(), $r_prefix='')
    {
        $categories = $this->getAll();

        if(!count($categories))
            return $idarray;
        
        foreach($categories as $id=>$category) {
            if($sel_id == $category->pid()) {
                $row =& $category->getStructure();
                $row['prefix'] = $r_prefix."--";
                $row['level'] = strval(strlen($row['prefix']) / 2);
                $idarray[$category->cid()] = $row;
                $idarray = $this->getChildTreeArray($category->cid(), $idarray, $row['prefix']);
            }
        }
        
        return $idarray;    
    }                

    /**
     * renders a category tree for a category list block.
     * $level points each depth, usefull for selecters.
     */
    function &renderCategoryTree($include_children=true, $sel_id=0, $tree='', $level=0) {
        $level++;
        $categories = $this->getAll();
        $mydirname4show = htmlspecialchars($this->mydirname_, ENT_QUOTES);
        $classselecter = ($level == 1)? $mydirname4show.'BlockCategory' : $mydirname4show.'BlockCatChild';
        $tree .= "\n".str_pad('', ($level - 1) * 2, "\t").'<ul class="'.$classselecter.'">'."\n";
        foreach($categories as $id => $category) {
        	if($category->getVar('pid') == $sel_id) {
                $count =& $this->getCountByCategory($id, $include_children);
                $tree .= str_pad('', ($level - 1) * 2 + 1, "\t").'<li>'.$category->renderImgurl().'<a href="'.sprintf("%s/modules/%s/index.php?cid=%d", XOOPS_URL, $mydirname4show, intval($id)).'">'.$category->name().'</a>('.$count.')';
                if($this->haveChild($id)) {
                    $tree = $this->renderCategoryTree($include_children, $id, $tree, $level);
                    $tree .= str_pad('', ($level - 1) * 2 + 1, "\t");
                }
                $tree .= '</li>'."\n";
            }
        }
        $tree .= str_pad('', ($level - 1) * 2, "\t").'</ul>'."\n";
        return $tree;
    }

    function haveChild($sel_id) {
    	static $__all_parents_cache__;
        
        if(!isset($__all_parents_cache__)) {
            $__all_parents_cache__ = array();
            $categories = $this->getAll();

            foreach($categories as $id => $category) {
                $__all_parents_cache__[$category->pid()][] = $id;
            }
        }
        return in_array($sel_id, array_keys($__all_parents_cache__));
    }

    /**
     * @brief get path from the category
     */
    function getNicePathArrayFromId($sel_id, $funcURL, $path=array())
    {
        $categories = $this->getAll();
        if(!count($categories))
            return $path;
            
        if(array_key_exists($sel_id, $categories)) {
            $liason = (ereg("\?", $funcURL))?'&amp;':'?';
            $category =& $categories[$sel_id];
            $path[] = array('url'=>$funcURL.$liason.'cid='.intval($sel_id), 'name'=>$category->name(), 'catimg'=>$category->imgurl());
            $path = $this->getNicePathArrayFromId($category->pid(), $funcURL, $path);
        }            
         
        return $path;
    }

    /**
     * @brief search category structure from id
     */
    function getStructureFromId( $sel_id, $patharray=array())
    {
        $categories = $this->getAll();
        if(!count($categories))
            return $patharray;

        if(array_key_exists($sel_id, $categories)) {
            $category =& $categories[$sel_id];
            $patharray[] = array('name'=>$category->name(), 'cid'=>intval($sel_id));
            $patharray = $this->getStructureFromId($category->pid(), $patharray);
        }
        
        return array_reverse($patharray, true);    
    }

    //returns an array of ALL parent ids for a given id($sel_id)
    function getAllParentId($sel_id, $idarray = array())
    {
        $categories = $this->getAll();
        if(!count($categories))
            return $idarray;
        
        if(array_key_exists($sel_id, $categories)) {
            $category =& $categories[$sel_id];
            $idarray[] = $category->pid();
            $idarray = $this->getAllParentId($category->pid(), $idarray); 
        }
        
        return $idarray;
    }

    //returns an array of SELF AND ALL PARENTS STRUCTURE for a given id($sel_id)
    function getAllParents($sel_id, $idarray = array())
    {
        $categories = $this->getAll();
        if(!count($categories))
            return $idarray;
        
        if(array_key_exists($sel_id, $categories)) {
            $category =& $categories[$sel_id];
            array_unshift($idarray, $category->getStructure());
            $idarray = $this->getAllParents($category->pid(), $idarray);
        }
        
        return $idarray;
    }


    function delete(&$obj,$force=false)
    {
        // delete all child categories with entries, trackback, comments, notifications belonged to
       
        // get this module
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $entry_handler =& $myModule->getHandler('entry'); 

        $cid = $obj->cid();
        $childIds =& $this->getAllChildIds($cid);
        // First, we delete child categories
        foreach(array_keys($childIds) as $id) {
            // delete entries belonged to this child category
            $entry_handler->deleteByCat($id);
        
            // delete this category
            $category =& $this->get($id);
            parent::delete($category, $force);
            unset($category);
        }

        // delete gperm belonging to those categories
        $gperm_handler =& xoops_gethandler('groupperm');
        $criteria = new criteriaCompo(new criteria('gperm_modid', $myModule->module_id));
        $criteria->add(new criteria('gperm_itemid', '('.implode(',', array_keys($childIds)).')'), 'IN');
        $gperm_handler->deleteAll($criteria);
            
        // delete notifications related with those categories
        $notify_handler =& xoops_gethandler('notification');
        foreach(array_keys($childIds) as $catid) {
            $notify_handler->unsubscribeByItem ($myModule->module_id, 'category', $catid);
            $notify_handler->unsubscribeByItem ($myModule->module_id, 'trackback_category', $catid);
        }

        // And delete all this category
        $entry_handler->deleteByCat($obj->cid());
        //$criteria = new criteriaCompo(new criteria('gperm_itemid', $id));
        //$criteria->add(new criteria('gperm_modid', $mid));
        //$gperm_handler->deleteAll($criteria);

        return parent::delete($obj, $force);
    }
}
}

if( ! class_exists($object_class_name) ) {
eval('
class '. $object_class_name .' extends d3blogCategoryObjectBase {
    var $mydirname_;
    function '. $object_class_name .'($id=null) {
        $this->d3blogCategoryObjectBase();
        $this->mydirname_ = "'.$mydirname.'";
    }
    function getTableInfo() {
        $tinfo = new myTableInfomation("'.$mydirname.'_category", "cid");
        return ($tinfo);
    }
}
');
eval('
class '. $object_class_name .'Handler extends d3blogCategoryObjectHandlerBase {
    var $mydirname_;
    function '. $object_class_name .'Handler($db) {
        parent::myXoopsObjectHandler($db, "'. $object_class_name .'");
        $this->mydirname_ = "'.$mydirname.'";
    }
}
');
}

?>