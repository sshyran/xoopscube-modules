<?php
/**
 * @version $Id: object.php 316 2008-03-01 12:44:36Z hodaka $
 */

if(!class_exists('myXoopsObject')) {
require_once dirname(dirname(__FILE__)).'/include/d3blogTextSanitizer.class.php';
class myTableInfomation {
    var $tablenames_;
    var $primarykeys_;
    var $fields_;
    var $extras_;
    var $pk_num_;
    var $merge_;

    function myTableInfomation ( $tbl, $pk, $merge=null, $exts=null, $fields="*" ) {
        if(is_array($tbl))
            $this->tablenames_=&$tbl;
        else {
            $this->tablenames_=array();
            $this->tablenames_[]=&$tbl;
        }

        if(is_array($pk))
            $this->primarykeys_=&$pk;
        else {
            $this->primarykeys_=array();
            $this->primarykeys_[]=&$pk;
        }

        if($merge!==null)
            $this->merge_=$merge;

        if($fields!==null) {
            if(is_array($fields)) {
                $this->fields_=&$fields;
            }
            else {
                $this->fields_=array();
                $this->fields_[]=&$fields;
            }
        }

        if($exts!==null) {
            if(is_array($exts)) {
                $this->extras_=&$exts;
            }
            else {
                $this->extras_=array();
                $this->extras_[]=&$exts;
            }
        }

        $this->pk_num_=count($this->primarykeys_);
    }
}

class myXoopsObject extends XoopsObject {
    function &getArray($type='s') {
        $ret=array();
        foreach (array_keys($this->vars) as $key ) {
            if($type)
                $ret[$key]=$this->getVar($key,$type);
            else
                $ret[$key]=$this->getVar($key,$type);
        }
        return $ret;
    }

    function &getStructure($type='s') {
        $ret =& $this->getArray($type);
        return $ret;
    }

    function assignVars($var_arr,$strip=false)
    {
        foreach($var_arr as $key=>$value) {
            if(get_magic_quotes_gpc() && $strip) {
                $value=&stripslashes($value);
                $this->assignVar($key,$value);
            }
            else {
                $this->assignVar($key,$value);
            }
        }

        // $this->cleanVars();
    }

    function _stripSlashesGPC($value)
    {
        return get_magic_quotes_gpc() ? stripslashes($value) : $value;
    }

    function setVar($key,$value,$not_gpc=false)
    {
        if(!empty($key) && isset($value) && isset($this->vars[$key])) {
            $this->vars[$key]['value'] = $not_gpc ? $value : $this->_stripSlashesGPC($value);
            $this->vars[$key]['not_gpc'] = true;
            $this->vars[$key]['changed'] = true;
            $this->setDirty();
        }
    }

    function &getVar($key, $format = 's')
    {
        $ret = $this->vars[$key]['value'];
        switch ($this->vars[$key]['data_type']) {

        case XOBJ_DTYPE_TXTBOX:
            switch (strtolower($format)) {
            case 's':
            case 'show':
            case 'e':
            case 'edit':
                $ts =& d3blogTextSanitizer::getInstance();
                $ret = $ts->htmlSpecialChars($ret);
                return $ret;
                break 1;
            case 'p':
            case 'preview':
            case 'f':
            case 'formpreview':
                $ts =& d3blogTextSanitizer::getInstance();
                $ret = $ts->htmlSpecialChars($ts->stripSlashesGPC($ret));
                return $ret;
                break 1;
            case 'n':
            case 'none':
            default:
                break 1;
            }
            break;
        case XOBJ_DTYPE_TXTAREA:
            switch (strtolower($format)) {
            case 's':
            case 'show':
                $ts =& d3blogTextSanitizer::getInstance();
                $html = !empty($this->vars['dohtml']['value']) ? 1 : 0;
                $xcode = (!isset($this->vars['doxcode']['value']) || $this->vars['doxcode']['value'] == 1) ? 1 : 0;
                $smiley = (!isset($this->vars['dosmiley']['value']) || $this->vars['dosmiley']['value'] == 1) ? 1 : 0;
                $image = (!isset($this->vars['doimage']['value']) || $this->vars['doimage']['value'] == 1) ? 1 : 0;
                $br = (!isset($this->vars['dobr']['value']) || $this->vars['dobr']['value'] == 1) ? 1 : 0;
                $ret = $ts->displayTarea($ret, $html, $smiley, $xcode, $image, $br);
                return $ret;
                break 1;
            case 'e':
            case 'edit':
                $ret = htmlspecialchars($ret, ENT_QUOTES);
                return $ret;
                break 1;
            case 'p':
            case 'preview':
                $ts =& d3blogTextSanitizer::getInstance();
                $html = !empty($this->vars['dohtml']['value']) ? 1 : 0;
                $xcode = (!isset($this->vars['doxcode']['value']) || $this->vars['doxcode']['value'] == 1) ? 1 : 0;
                $smiley = (!isset($this->vars['dosmiley']['value']) || $this->vars['dosmiley']['value'] == 1) ? 1 : 0;
                $image = (!isset($this->vars['doimage']['value']) || $this->vars['doimage']['value'] == 1) ? 1 : 0;
                $br = (!isset($this->vars['dobr']['value']) || $this->vars['dobr']['value'] == 1) ? 1 : 0;
                $ret = $ts->previewTarea($ret, $html, $smiley, $xcode, $image, $br);
                return $ret;
                break 1;
            case 'f':
            case 'formpreview':
                $ts =& MyTextSanitizer::getInstance();
                $ret = htmlspecialchars($ts->stripSlashesGPC($ret), ENT_QUOTES);
                return $ret;
                break 1;
            case 'n':
            case 'none':
            default:
                break 1;
            }
            break;
        case XOBJ_DTYPE_ARRAY:
            $ret = unserialize($ret);
            break;
        case XOBJ_DTYPE_SOURCE:
            switch (strtolower($format)) {
            case 's':
            case 'show':
                break 1;
            case 'e':
            case 'edit':
                $ret = htmlspecialchars($ret, ENT_QUOTES);
                return $ret;
                break 1;
            case 'p':
            case 'preview':
                $ts =& d3blogTextSanitizer::getInstance();
                $ret = $ts->stripSlashesGPC($ret);
                return $ret;
                break 1;
            case 'f':
            case 'formpreview':
                $ts =& d3blogTextSanitizer::getInstance();
                $ret = htmlspecialchars($ts->stripSlashesGPC($ret), ENT_QUOTES);
                return $ret;
                break 1;
            case 'n':
            case 'none':
            default:
                break 1;
            }
            break;
        default:
            if ($this->vars[$key]['options'] != '' && $ret != '') {
                switch (strtolower($format)) {
                case 's':
                case 'show':
                    $selected = explode('|', $ret);
                    $options = explode('|', $this->vars[$key]['options']);
                    $i = 1;
                    $ret = array();
                    foreach ($options as $op) {
                        if (in_array($i, $selected)) {
                            $ret[] = $op;
                        }
                        $i++;
                    }
                    $ret = implode(', ', $ret);
                    return $ret;
                case 'e':
                case 'edit':
                    $ret = explode('|', $ret);
                    break 1;
                default:
                    break 1;
                }

            }
            break;
        }
        return $ret;
    }


}

class myXoopsObjectHandler extends XoopsObjectHandler {
    var $db_;
    var $_classname_=null;
    var $_tableinfo_=null;

    function myXoopsObjectHandler($db,$classname=null) {
        $this->db_=&$db;

        if($this->_classname_==null)
            $this->_classname_=$classname;
        if($this->_tableinfo_==null)
            $this->_tableinfo_ = call_user_func(array($classname,'getTableInfo'));
    }

    function _cacheInstance($obj) {
        global $__myobject__cache__;
        if(is_object($obj)){
            $classname=strtolower(get_class($obj));
            $pk_count=count($this->_tableinfo_->primarykeys_);
            if($pk_count==1)
                $__myobject__cache__[$classname][$obj->getVar($this->_tableinfo_->primarykeys_[0])]=&$obj;
            else {
                if(!isset($__myobject_cache__[$classname]))
                    $__myobject_cache__[$classname]=array();
                elseif(!is_array($__myobject_cache__[$classname]))
                    $__myobject_cache__[$classname]=array();

                $p =& $__myobject__cache__[$classname];
                for($i=0;$i<$pk_count;$i++) {
                    $keyname=$obj->getVar($this->_tableinfo_->primarykeys_[$i]);
                    if($i==($pk_count-1)) {
                        $p[$keyname]=&$obj;
                    }
                    else {
                        if(!isset($p[$keyname]))
                            $p[$keyname]=array();
                        $p=&$p[$keyname];
                    }
                }
            }
        }
    }

    function _resetCacheAll() {
        global $__myobject__cache__;
        $__myobject__cache__=array();
    }

    function &create($isNew=true) {
        $obj=null;
        if(class_exists($this->_classname_)) {
            $obj=new $this->_classname_();
            if($isNew)
                $obj->setNew();
        }
        return $obj;
    }

    function get() {
        global $__myobject__cache__;

        if($this->_tableinfo_->pk_num_!=func_num_args())
            return null;

        if($this->_tableinfo_->pk_num_==1) {
            $value=func_get_arg(0);
            if(isset($__myobject__cache__[$this->_classname_][$value])) {
                return $__myobject__cache__[$this->_classname_][$value];
            }
            else {
                $criteria=new Criteria($this->_tableinfo_->primarykeys_[0],
                    $value, "=");
                $obj=$this->_get($this->_tableinfo_,$criteria);
                $this->_cacheInstance($obj);
                return $obj;
            }
        }
        else {
            if(isset($__myobject__cache__[$this->_classname_])) {
                if(is_array($__myobject__cache__[$this->_classname_])) {
                    $p=&$__myobject__cache__[$this->_classname_];
                    for($i=0;$i<$this->_tableinfo_->pk_num_;$i++) {
                        if($i==($this->_tableinfo_->pk_num_ - 1)) {
                            if(isset($p[func_get_arg($i)])) {
                                return $p[func_get_arg($i)];
                            }
                        }
                        else {
                            if(is_array($p[func_get_arg($i)]))
                                $p=&$p[func_get_arg($i)];
                            else
                                break;
                        }
                    }
                }
            }

            $criteria = new CriteriaCompo();
            for($i=0;$i<$this->_tableinfo_->pk_num_;$i++) {
                $val=func_get_arg($i);
                $criteria->add(new Criteria($this->_tableinfo_->primarykeys_[$i],$val));
            }
            $obj=&$this->_get($this->_tableinfo_,$criteria);
            $this->_cacheInstance($obj);
            return $obj;
        }
    }

    function _get($tinfo,$criteria) {
        $sql="SELECT ".implode(",",$tinfo->fields_)." FROM ".implode(",",array_map(array($this->db_,'prefix'),$tinfo->tablenames_));
        if($tinfo->merge_)
            $sql.=" WHERE ".$tinfo->merge_." AND ".$criteria->render();
        else
            $sql.=" ".$criteria->renderWhere();

//      myFrame::debug($sql);

        if(!$result=$this->db_->query($sql))
            return false;

        if($this->db_->getRowsNum($result)==1) {
            if($row=$this->db_->fetchArray($result)) {
                $obj = new $this->_classname_();
                $obj->assignVars($row);
                $obj->unsetNew();
                return $obj;
            }
        }

        return null;
    }

    function &getObjects($criteria=null,$id_as_key='',$order=null) {
        global $__myobject__cache__;

        $objects =& $this->_getObjects($this->_tableinfo_,$criteria,$order);
        foreach($objects as $o) {
            $this->_cacheInstance($o);
        }

        if($id_as_key)
            return $__myobject__cache__[strtolower($this->_classname_)];
        else
            return $objects;
    }

    function getOne($criteria,$force=false) {
        $objs =& $this->getObjects($criteria);
        if(count($objs) == 1 or ($force && count($objs)))
            if(is_object($objs[0])) return $objs[0];

        return false;
    }

    function &getCount($criteria=null) {
        global $__myobject__cache__;

        $ret = $this->_getCount($this->_tableinfo_,$criteria);
        return $ret;
    }

    function &_getObjects($tinfo,$criteria,$order) {
        $ret=array();
        $whereflag=false;

        $limit = $start = 0;

        $sql="SELECT ".implode(",",$tinfo->fields_)." FROM ".implode(",",array_map(array($this->db_,'prefix'),$tinfo->tablenames_));
        if($tinfo->merge_) {
            $sql.=" WHERE ".$tinfo->merge_;
            $whereflag=true;
        }

        if(isset($criteria) && is_subclass_of($criteria,'criteriaelement')) {
            if($whereflag)
                $sql.=" AND ".$criteria->render();
            else
                $sql.=' '.$criteria->renderWhere();

            if($criteria->getSort()!='')
                $sql.=' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            elseif($order!=null)
                $sql.=' ORDER BY '.$order;

            $limit=$criteria->getLimit();
            $start=$criteria->getStart();
        }
        elseif($order!=null)
            $sql.=' ORDER BY '.$order;

        $result=$this->db_->query($sql,$limit,$start);
        if(!$result){ return $ret; }

        while($row=$this->db_->fetchArray($result)) {
            $obj = new $this->_classname_();
            $obj->assignVars($row);
            $obj->unsetNew();
            $ret[]=&$obj;
            unset($obj);
        }

        return $ret;
    }

    function _getCount($tinfo,$criteria=null) {
        $whereflag=false;

        $sql="SELECT COUNT(*) c FROM ".implode(",",array_map(array($this->db_,'prefix'),$tinfo->tablenames_));
        if($tinfo->merge_) {
            $sql.=" WHERE ".$tinfo->merge_;
            $whereflag=true;
        }

        if(isset($criteria) && is_subclass_of($criteria,'criteriaelement')) {
            if($whereflag)
                $sql.=" AND ".$criteria->render();
            else
                $sql.=" ".$criteria->renderWhere();
        }

        $result=$this->db_->query($sql);
        if(!$result){ return false; }

        $ret=$this->db_->fetchArray($result);

        return $ret['c'];
    }

    function insert(&$obj,$force=false) {
        return $this->_insert($this->_tableinfo_,$obj,$force);
    }

    function _insert(&$tinfo,&$obj,$force=false) {
        if(strtolower(get_class($obj)) != strtolower($this->_classname_))
            return false;

        if(!$obj->isDirty()) return true;
        if(!$obj->cleanVars()) return true;

        foreach($obj->cleanVars as $key => $value) {
            $vars{$key} = $value;
        }

        $new_flag=false;

        if($obj->isNew()) {
            $new_flag=true;
            $sql = $this->_insert_new($tinfo,$obj,$vars);
        }
        else {
            $sql = $this->_insert_update($tinfo,$obj,$vars);
        }

        if($force!=false) {
            $result=$this->db_->queryF($sql);
        }
        else {
            $result=$this->db_->query($sql);
        }

        if(defined("__MYFRAME__DEBUG__"))
            print $sql;

        if(!$result){
//var_dump(mysql_error());
            return false;
        }

        if($new_flag && $tinfo->pk_num_>0 ) {
            $id = $this->db_->getInsertId();
            $obj->setVar($tinfo->primarykeys_[0],$id);
        }

        return true;
    }

    function _insert_new(&$tinfo,&$obj,&$vars) {
        $fileds=array();
        $values=array();
        $arr = $this->_makeVars4sql($obj,$vars);
        foreach(array_keys($arr) as $name) {
            $fields[]=$name;
            $values[]=$arr[$name];
        }
        $q=sprintf("INSERT INTO %s ( %s ) VALUES ( %s )",
            $this->db_->prefix($tinfo->tablenames_[0]),
            implode(",",$fields),
            implode(",",$values));

        return $q;
    }

    function _insert_update(&$tinfo,&$obj,&$vars) {
        $set_lists=array();
        $pk_lists=array();
        $values=array();
        $arr = $this->_makeVars4sql($obj,$vars);
        foreach(array_keys($arr) as $name) {
            if(in_array($name,$tinfo->primarykeys_)) {
                $pk_lists[]=$name."=".$arr[$name];
            }
            else {
                $set_lists[]=$name."=".$arr{$name};
            }
        }
        $q=sprintf("UPDATE %s SET %s WHERE %s",
            $this->db_->prefix($tinfo->tablenames_[0]),
            implode(",",$set_lists),
            implode(" AND ",$pk_lists));

        return $q;
    }

    function &_makeVars4sql(&$obj,&$vars) {
        $ret=array();
        foreach(array_keys($obj->vars) as $v) {
            switch($obj->vars[$v]['data_type']) {
                case XOBJ_DTYPE_TXTBOX:
                case XOBJ_DTYPE_TXTAREA:
                case XOBJ_DTYPE_URL:
                case XOBJ_DTYPE_EMAIL:
                case XOBJ_DTYPE_ARRAY:
                case XOBJ_DTYPE_OTHER:
                case XOBJ_DTYPE_SOURCE:
                    $ret[$v]=$this->db_->quoteString($vars[$v]);
                    break;
                default:
                    $ret[$v]=$vars[$v];
            }
        }
        return $ret;
    }

    function delete(&$obj,$force=false) {
        // create criteria
        $criteria = new CriteriaCompo();
        foreach($this->_tableinfo_->primarykeys_ as $pk) {
            $criteria->add(new Criteria($pk,$obj->getVar($pk)));
        }
        return $this->deletes($criteria,$force);
    }

    function deletes($criteria,$force=false) {
        $sql = "DELETE FROM ".$this->db_->prefix($this->_tableinfo_->tablenames_[0])." ".$criteria->renderWhere();

        if($force)
            return $this->db_->queryF($sql);
        else
            return $this->db_->query($sql);
    }

}

}
?>