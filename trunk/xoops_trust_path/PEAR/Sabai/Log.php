<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Log
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

define('SABAI_LOG_NONE', 0);
define('SABAI_LOG_INFO', 1);
define('SABAI_LOG_WARN', 4);
define('SABAI_LOG_FATAL', 8);
define('SABAI_LOG_ERROR_PHPNOTICE', 32);
define('SABAI_LOG_ERROR_PHPWARNING', 64);
define('SABAI_LOG_ERROR_PHPFATAL', 128);
define('SABAI_LOG_ERROR_PHP', 224);
define('SABAI_LOG_ERROR_ALL', 232);
define('SABAI_LOG_ALL', 255);

/**
 * Sabai_Log_Writer
 */
require 'Sabai/Log/Writer.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Log
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Log
{
    /**
     * @access private
     * @var int
     */
    var $_logLevel;
    /**
     * @access protected
     * @var array
     */
    var $_logWriters = array();

    /**
     * Gets a singleton
     *
     * @return Sabai_Log
     * @static
     * @staticvar $instance Sabai_Log
     */
    function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new Sabai_Log();
        }
        return $instance;
    }

    /**
     * @static
     * @param string $msg
     * @param string $file
     * @param string $line
     */
    function info($msg, $file = 'unknown', $line = 'unknown')
    {
        $log =& Sabai_Log::getInstance();
        $log->addLog($msg, SABAI_LOG_INFO, $file, $line);
    }

    /**
     * @static
     * @param string $msg
     * @param string $file
     * @param string $line
     */
    function warn($msg, $file = 'unknown', $line = 'unknown')
    {
        $log =& Sabai_Log::getInstance();
        $log->addLog($msg, SABAI_LOG_WARN, $file, $line);
    }

    /**
     * @static
     * @param string $msg
     * @param string $file
     * @param string $line
     */
    function fatal($msg, $file = 'unknown', $line = 'unknown')
    {
        $log =& Sabai_Log::getInstance();
        $log->addLog($msg, SABAI_LOG_FATAL, $file, $line);
    }

    /**
     * Registers a log writer
     *
     * @static
     * @param Sabai_LogWriter $logWriter
     * @param bool $append
     */
    function writer(&$logWriter, $append = true)
    {
        $log =& Sabai_Log::getInstance();
        if ($append) {
            $log->addLogWriter($logWriter);
        } else {
            $log->setLogWriter($logWriter);
        }
    }

    /**
     * Gets/sets the current log level
     *
     * @static
     * @return string
     * @param string $charset
     */
    function level($level = null)
    {
        $log =& Sabai_Log::getInstance();
        $ret = $log->getLogLevel();
        if (!empty($level)) {
            $log->setLogLevel($level);
        }
        return $ret;
    }

    /**
     * @return int
     */
    function getLogLevel()
    {
        return $this->_logLevel;
    }

    /**
     * @param int $level
     */
    function setLogLevel($level)
    {
        $this->_logLevel = $level;
    }

    /**
     * Adds a log writer
     *
     * @param Sabai_LogWriter $logWriter
     */
    function addLogWriter(&$logWriter)
    {
        $this->_logWriters[] =& $logWriter;
    }

    /**
     * Sets a log writer as the only one
     *
     * @param Sabai_LogWriter $logWriter
     */
    function setLogWriter(&$logWriter)
    {
        $this->_logWriters = array(&$logWriter);
    }

    /**
     * @param string $msg
     * @param int $level
     * @param string $file
     * @param string $line
     */
    function addLog($msg, $level = SABAI_LOG_INFO, $file = 'unknown', $line = 'unknown')
    {
        if ($this->getLogLevel() & $level) {
            foreach (array_keys($this->_logWriters) as $i) {
                $this->_logWriters[$i]->writeLog($msg, $level, $file, $line);
            }
        }
    }
}