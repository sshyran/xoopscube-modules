<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_I18N
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
 * @package    Sabai_I18N
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_I18N
{
    /**
     * Defines or returns the current locale
     *
     * @return mixed string if locale is already set, false if failed to set
     * @param mixed $locales string or array
     * @static
     * @staticvar $locale
     */
    function locale($locales = 0)
    {
        static $locale = false;
        // locale can be set only once
        if (!$locale) {
            foreach ((array)$locales as $_locale) {
                if (setlocale(LC_ALL, $_locale)) {
                    $locale = $_locale;
                    @putenv('LANG=' . $locale);
                    @putenv('LANGUAGE=' . $locale);
                    Sabai_Log::info(sprintf('Locale set as %s', $locale), __FILE__, __LINE__);
                    break;
                }
            }
        }
        return $locale;
    }

    /**
     * Gets the language code
     *
     * @return string
     * @param mixed $locales string or array
     * @static
     */
    function lang($locales = 0)
    {
        $locale = explode('.', Sabai_I18N::locale($locales));
        return str_replace('_', '-', $locale[0]);
    }

    /**
     * Cuts a string to a desired length
     *
     * @param string $str
     * @param int $start
     * @param int $length
     * @return string
     * @static
     */
    function strcut($str, $start, $length)
    {
        return mb_strcut($str, $start, $length, SABAI_CHARSET);
    }

    /**
     * Cuts a string into a desirede length with a text attached at the end
     *
     * @param string $str
     * @param int $length
     * @param int $start
     * @param string $more
     * @return string
     * @static
     */
    function strcutMore($str, $length, $start = 0, $more = '...')
    {
        if (strlen($str) <= $length) {
            return $str;
        } else {
            if (0 >= $strlen = $length - strlen($more)) {
                return Sabai_I18N::strcut($str, $start, $length);
            }
            return Sabai_I18N::strcut($str, $start, $strlen) . $more;
        }
    }

    /**
     * Translates formatted langauge string
     *
     * @param string $msgid
     * @param array $params
     * @return string
     */
    function __($msgid, $params)
    {
        return call_user_func_array('sprintf', array_merge(array(_($msgid)), (array)$params));
    }
}

if (!function_exists('bindtextdomain')) {
    /**
     * SabaiGettext
     */
    require 'SabaiGettext.php';
}

if (!function_exists('mb_convert_encoding')) {
    function mb_convert_encoding($str, $to, $from = null)
    {
        return $str;
    }

    function mb_strcut($str, $start, $length = null, $encoding = null)
    {
        return substr($str, $start, $length);
    }
}