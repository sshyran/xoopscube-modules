<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_ErrorHandler
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
 * @package    Sabai_ErrorHAndler
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_ErrorHandler_Default extends Sabai_ErrorHandler
{
    /**
     * @var bool
     * @access protected
     */
    var $_displayMethod = '_displayErrorNone';
    /**
     * @var bool
     * @access protected
     */
    var $_logMethod = '_logErrorNone';

    /**
     * Constructor
     *
     * @return Sabai_ErrorHandler_Default
     */
    function Sabai_ErrorHandler_Default()
    {
        if (false != (bool)ini_get('display_errors')) {
            if (false != (bool)ini_get('html_errors') && !in_array(php_sapi_name(), array('cli', 'cgi'))) {
                $this->_displayMethod = '_displayErrorHTML';
            } else {
                $this->_displayMethod = '_displayError';
            }
        }
        if (false != (bool)ini_get('log_errors')) {
            $this->_logMethod = '_logError';
        }
    }

    /**
     * Handles a PHP error
     *
     * @param int $level
     * @param string $msg
     * @param string $file
     * @param int $line
     * @param array $context
     */
    function _handlePHPError($level, $msg, $file, $line, $context)
    {
        if ($level == E_USER_ERROR || error_reporting() & $level) {
            switch ($level) {
            case E_NOTICE:
            case E_USER_NOTICE:
                $this->_handleError($level, $msg, $file, $line, $context, 'Notice', SABAI_LOG_ERROR_PHPNOTICE);
                break;
            case E_WARNING:
            case E_USER_WARNING:
                $this->_handleError($level, $msg, $file, $line, $context, 'Warning', SABAI_LOG_ERROR_PHPWARNING);
                break;
            default:
            case E_USER_ERROR:
                $this->_handleError($level, $msg, $file, $line, $context, 'Fatal error', SABAI_LOG_ERROR_PHPFATAL);
                $this->_handleFatalError($msg, $file, $line, $context);
                break;
            }

        }
    }

    /**
     * Handles a PHP Error
     *
     * @access protected
     * @param int $level
     * @param string $msg
     * @param string $file
     * @param int $line
     * @param array $context
     * @param string $levelStr
     */
    function _handleError($level, $msg, $file, $line, $context, $levelStr, $logLevel)
    {
        $log =& Sabai_Log::getInstance();
        $log->addLog($msg, $logLevel, $file, $line);
        $this->{$this->_displayMethod}($level, $msg, $file, $line, $context, $levelStr);
        $this->{$this->_logMethod}($level, $msg, $file, $line, $context, $levelStr);
    }

    /**
     * Displays no error
     *
     * @param int $level
     * @param string $msg
     * @param string $file
     * @param int $line
     * @param array $context
     * @param string $levelStr
     */
    function _displayErrorNone($level, $msg, $file, $line, $context, $levelStr)
    {
    }

    /**
     * Displays an error message
     *
     * @param int $level
     * @param string $msg
     * @param string $file
     * @param int $line
     * @param array $context
     * @param string $levelStr
     */
    function _displayError($level, $msg, $file, $line, $context, $levelStr)
    {
        printf("%s: %s in file %s on line %d\n", $levelStr, h($msg), $file, $line);
    }

    /**
     * Displays an error message in HTML
     *
     * @param int $level
     * @param string $msg
     * @param string $file
     * @param int $line
     * @param array $context
     * @param string $levelStr
     */
    function _displayErrorHTML($level, $msg, $file, $line, $context, $levelStr)
    {
        printf('<br /><span style="font-weight:bold">%s</span>: %s in file <span style="font-weight:bold">%s</span> on line <span style="font-weight:bold">%d</span><br />', $levelStr, h($msg), $file, $line);
    }

    /**
     * Logs no error
     *
     * @param int $level
     * @param string $msg
     * @param string $file
     * @param int $line
     * @param array $context
     * @param string $levelStr
     */
    function _logErrorNone($level, $msg, $file, $line, $context, $levelStr)
    {
    }

    /**
     * Logs an error
     *
     * @param int $level
     * @param string $msg
     * @param string $file
     * @param int $line
     * @param array $context
     * @param string $levelStr
     */
    function _logError($level, $msg, $file, $line, $context, $levelStr)
    {
        error_log(sprintf('PHP %s:  %s in file %s on line %d', $levelStr, $msg, $file, $line), 0);
    }

    /**
     * Handles a fatal PHP error
     *
     * @param string $msg
     * @param string $file
     * @param int $line
     * @param array $context
     */
    function _handleFatalError($msg, $file, $line, $context)
    {
        exit();
    }
}