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
class Sabai_Log_Writer_HTML extends Sabai_Log_Writer
{
    /**
     * Constructor
     *
     * @param bool $disablePHPDisplayErrors
     * @return Sabai_Log_Writer_HTML
     */
    function Sabai_Log_Writer_HTML($disablePHPDisplayErrors = true)
    {
        if ($disablePHPDisplayErrors) {
            ini_set('display_errors', 0);
        }
    }

    /**
     * Displays a log message as HTML
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
            $prefix = '<span style="font-weight:bold;color:#66ff00">Info</span>';
            break;
        case SABAI_LOG_WARN:
            $prefix = '<span style="font-weight:bold;color:#ffcc00">Warning</span>';
            break;
        case SABAI_LOG_FATAL:
            $prefix = '<span style="font-weight:bold;color:#ff0033">Error</span>';
            break;
        case SABAI_LOG_ERROR_PHPNOTICE:
            $prefix = '<span style="font-weight:bold;color:#66ff00">PHP Notice</span>';
            break;
        case SABAI_LOG_ERROR_PHPWARNING:
            $prefix = '<span style="font-weight:bold;color:#ffcc00">PHP Warning</span>';
            break;
        case SABAI_LOG_ERROR_PHPFATAL:
            $prefix = '<span style="font-weight:bold;color:#ff0033">PHP Fatal error</span>';
            break;
        default:
            $prefix = '<span style="font-weight:bold">Unknown</span>';
            break;
        }
        printf('<br />%s:  %s in file <span style="font-weight:bold">%s</span> on line <span style="font-weight:bold">%s</span><br />', $prefix, h($msg), $file, $line);
    }
}