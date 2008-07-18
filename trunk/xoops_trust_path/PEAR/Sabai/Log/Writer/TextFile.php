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
 * @subpackage Writer
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Log_Writer_TextFile extends Sabai_Log_Writer
{
    /**
     * Enter description here...
     *
     * @var string
     * @access protected
     */
    var $_logFile;
    /**
     * Enter description here...
     *
     * @var bool
     * @access protected
     */
    var $_clear;
    /**
     * Enter description here...
     *
     * @var array
     * @access protected
     */
    var $_logs = array();

    /**
     * Constructor
     *
     * @param string $logFile
     * @param bool $clear
     * @return Sabai_Log_Writer_TextFile
     */
    function Sabai_Log_Writer_TextFile($logFile, $clear = true)
    {
        $this->_logFile = $logFile;
        $this->_clear = $clear;
        register_shutdown_function(array(&$this, 'shutdown'));
    }

    /**
     * Buffers a log message
     *
     * @param string $msg
     * @param int $level
     * @param string $file
     * @param int $line
     */
    function writeLog($msg, $level, $file, $line)
    {
        switch ($level) {
        case SABAI_LOG_INFO:
            $prefix = 'Info';
            break;
        case SABAI_LOG_WARN:
            $prefix = 'Warning';
            break;
        case SABAI_LOG_FATAL:
            $prefix = 'Error';
            break;
        case SABAI_LOG_ERROR_PHPNOTICE:
            $prefix = 'PHP Notice';
            break;
        case SABAI_LOG_ERROR_PHPWARNING:
            $prefix = 'PHP Warning';
            break;
        case SABAI_LOG_ERROR_PHPFATAL:
            $prefix = 'PHP Fatal error';
            break;
        default:
            $prefix = 'Unknown';
            break;
        }
        $this->_logs[] = sprintf("%s:  %s in file %s on line %s\n", $prefix, $msg, $file, $line);
    }

    /**
     * Logs all the messages in the buffer to a file
     *
     */
    function shutdown()
    {
        $mode = $this->_clear ? 'w' : 'a';
        if ($fp = fopen($this->_logFile, $mode)) {
            fwrite($fp, implode('', $this->_logs));
            fclose($fp);
        }
    }
}