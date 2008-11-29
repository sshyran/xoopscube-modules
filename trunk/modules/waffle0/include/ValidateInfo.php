<?php

if (defined('__VALIDATEINFO_PHP__')) {
    return;
}

define('__VALIDATEINFO_PHP__', '1');

class ValidateInfo
{
    var $post;
    var $error_message;
    var $error_message_key;
     
    function ValidateInfo()
    {
	$this->error_message = array();
	$this->error_message_key = array();
    }
     
    function set_post($post)
    {
	$this->post = $post;
    }
     
    function get_post()
    {
	return $this->post;
    }
    
    function set_post_data($key, $value)
    {
	$this->post[$key] = $value;
    }
     
    /**
     *  * @return true:validate OK, false: error
     *  */
    function error()
    {
	if (0 < count($this->error_message)) {
	    return true;
	} else {
	    return false;
	}
    }
     
    function set_error($key, $message)
    {
	$this->error_message[] = $message;
	$this->error_message_key[$key] = $message;
    }
     
    function get_error()
    {
	return $this->error_message;
    }
     
    function get_error_key()
    {
	return $this->error_message_key;
    }
}

?>
