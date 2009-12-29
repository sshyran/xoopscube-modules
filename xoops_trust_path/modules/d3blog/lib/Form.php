<?php
/**
@file
@version $Id: Form.php 483 2008-07-02 01:04:13Z hodaka $
*/

if(!class_exists('myAbstractFormObject')) {

define ( "MYACTIONFORM_INIT_FAIL", '__error__myactionform_init_fail__' );
define ( "MYACTIONFORM_INIT_SUCCESS", '__myactionform_init_success__' );
define ( "MYACTIONFORM_POST_SUCCESS", '__myactionform_post_success__' );

/**
 *
 */
class myAbstractFormObject {
    var $msg_; 
    var $err_render_=null;

    function myAbstractFormObject() {
        $this->msg_=array();
        $this->err_render_=new myFormErrorRender();
    }

    /**
     * @param $msg
     * @return none
     */
    function addError($msg) {
        $this->msg_[]=$msg;
    }

    /**
     *
     */
    function isError() {
        return count($this->msg_);
    }

    /**
     * @return string
     */
    function getHtmlErrors() {
        $this->err_render_->init($this);
        return $this->err_render_->render();
    }

    /**
     * @param $numValue
     * @param $min
     * @param $max
     * @return bool
     */
    function validateInRange($numValue,$min,$max) {
        return ($numValue>=$min && $numValue<=$max);
    }

    /**
     * @param $string
     * @param $max
     * @return bool
     */
    function validateMaxLength($string,$max) {
        return (strlen($string)<=$max);
    }

    /**
     * @param $string
     * @param $max
     * @return bool
     */
    function validateMinLength($string,$min) {
        return (strlen($string)>=$min);
    }

    function validatePositive($value) {
        return (intval($value)>0);
    }

    function validateHttpUrl($value) {
        return (strpos($value,"http://")===0 or strpos($value,"https://")===0);
    }

    function validateMimeImage($value) {
        return getimagesize($value);
    }

    function getPositive($value) {
        $ret=intval($value);
        if($ret<=0)
            return 0;
        else
            return $ret;
    }
}

/**
 * @deprecated 
 */
/*class myAbstractForm extends myAbstractFormObject {
    var $data_;
    
    function init($data=null) {
        if($data) {
            $this->data_=&$data;
        }
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $this->doPost($data);
            return count($this->msg_) ? MYACTIONFORM_INIT_FAIL : MYACTIONFORM_POST_SUCCESS;
        }
        elseif($_SERVER['REQUEST_METHOD']=='GET') {
            $this->doGet($data);
            return count($this->msg_) ? MYACTIONFORM_INIT_FAIL : MYACTIONFORM_INIT_SUCCESS;
        }
        else {
            return MYACTIONFORM_INIT_FAIL;
        }
        
    }

    function doGet($data) { }

    function doPost($data) { }

    function initSelf() {
        $dmy=null;
        return $this->init($dmy);
    }
}*/
/*
class myAbstractActionForm extends myAbstractFormObject {
}
*/
/**
 *
 */
/*class myActionForm extends myAbstractForm {
    function init($master) {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $this->fetch();
            return count($this->msg_) ? MYACTIONFORM_INIT_FAIL : MYACTIONFORM_POST_SUCCESS;
        }
        else {
            return MYACTIONFORM_INIT_SUCCESS;
        }
    }

    function fetch() {
    }

    function load(&$master) {
    }

    function update(&$master) {
    }
}*/

class myActionFormEx extends myAbstractFormObject {
    function myActionFormEx() {
    	parent::myAbstractFormObject();
    }
    
    function init(&$master) {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $this->fetch($master);
            return count($this->msg_) ? MYACTIONFORM_INIT_FAIL : MYACTIONFORM_POST_SUCCESS;
        }
        else {
            $this->load($master);
            return count($this->msg_) ? MYACTIONFORM_INIT_FAIL : MYACTIONFORM_INIT_SUCCESS;
        }
    }

    function fetch(&$master)
    {
        $this->load($master);
    }

}

class myFormErrorRender {
    var $form_=null;

    function init($form) {
        $this->form_=$form;
    }

    function render() {
        $ret ="<ul>";
        foreach($this->form_->msg_ as $m) {
            $ret.=@sprintf("<li style=\"list-style:none;color:#F00\">%s</li>\n",$m);
        }
        $ret .="</ul>";
        return $ret;
    }
}

}
?>
