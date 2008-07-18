<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @link
 * @since      File available since Release 0.1.1
*/

require 'Sabai/Log.php';
require 'Sabai/ErrorHandler.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @link
 * @version    0.1.9a2
 * @since      Class available since Release 0.1.1
 */
class Sabai
{
    /**
     * Initializes session and other required libraries
     *
     * @param int $logLevel
     * @param string $charset
     * @static
     */
    function start($logLevel = SABAI_LOG_ERROR_ALL, $charset = 'UTF-8')
    {
        static $started = false;
        if (!$started) {
            set_magic_quotes_runtime(0);
            if (!session_id() && PHP_SAPI != 'cli') {
                @ini_set('session.use_only_cookies', 1);
                @ini_set('session.use_trans_sid', 0);
                @session_start();
            }
            define('SABAI_CHARSET', $charset);
            Sabai_ErrorHandler::initDefault();
            Sabai_Log::level($logLevel);
            $started = true;
        }
    }
}

/**
 * Basic(and not complete) pluralization of a string
 *
 * @param string $str
 * @return string
 */
function pluralize($str)
{
    switch (strtolower(substr($str, -1))) {
    case 'y':
        return substr($str, 0, -1) . 'ies';
    case 's':
        return $str . 'es';
    default:
        return $str . 's';
    }
}

/**
 * Alias for htmlspecialchars()
 *
 * @param string $str
 * @param int $quoteStyle
 * @return string
 */
function h($str, $quoteStyle = ENT_QUOTES)
{
    return htmlspecialchars($str, $quoteStyle, SABAI_CHARSET);
}

/**
 * Echos out the result of h()
 *
 * @param string $str
 * @param int $quoteStyle
 * @return string
 */
function _h($str, $quoteStyle = ENT_QUOTES)
{
    echo h($str, $quoteStyle);
}

/**
 * HTML friendly var_dump()
 *
 * @param mixed $var
 */
function var_dump_html($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

/**
 * Checks if running PHP5
 *
 * @return bool
 */
function is_php5()
{
    return version_compare('5.0.0', phpversion(), '<=');
}

if (!is_php5()) {
    // Add PHP4 compatible clone function
    eval('
        function clone(&$object)
        {
            return $object;
        }
    ');
}

// array_intersect_key() from PHP5.1.0rc1
if (!function_exists('array_intersect_key')) {
    /**
     * PHP4 compatible array_intersect_key() function
     *
     * @return array
     */
    function array_intersect_key()
    {
        $ret = $array_keys = array();
        $array_args = func_get_args();
        foreach ($array_args as $i => $array_arg) {
            $array_keys[$i] = array_keys($array_arg);
        }
        foreach (call_user_func_array('array_intersect', $array_keys) as $key) {
            $ret[$key] = $array_args[0][$key];
        }
        return $ret;
    }
}

/**
 * Checks whether a file can be included with include()/require()
 *
 * @param string $filename
 * @return bool
 */
function is_includable($filename)
{
    $ret = false;
    if (false !== $fp = fopen($filename, 'r', true)) {
        $ret = true;
        fclose($fp);
    } else {
        if (!in_array('.', explode(PATH_SEPARATOR, get_include_path()))) {
            $ret = file_exists($filename);
        }
    }
    return $ret;
}