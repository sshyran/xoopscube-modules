<?php
/**
 * @version $Id: session.php 281 2008-02-23 09:49:31Z hodaka $
 */

if(!defined('D3BLOG_SESSION_PREFIX'))
    define('D3BLOG_SESSION_PREFIX','__d3blog__');

/**
 * @param $name session name
 * @param $value value
 */
class D3blogSession {

    function register($name, $value) {
        $name = D3BLOG_SESSION_PREFIX.$name;
        $_SESSION[$name] = serialize($value);
    }

    /**
     * @param $name session name
     * @return void value of session
     */
    function get($name) {
        $name = D3BLOG_SESSION_PREFIX.$name;
        if(isset($_SESSION[$name]))
            return unserialize($_SESSION[$name]);
        else
            return false;
    }

    /**
     * @param string $name session name
     * @return boolean true if exists or false if not
     */
    function is_registered($name){
        $name = D3BLOG_SESSION_PREFIX.$name;
        return isset($_SESSION[$name]);
    }

    /**
     * @param string $name session name
     */
    function unregister($name){
        $name = D3BLOG_SESSION_PREFIX.$name;
        unset($_SESSION[$name]);
    }

}

?>