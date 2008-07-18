<?php
/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   SabaiGettext
 * @package    SabaiGettext
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/gpl-license.php GNU GPL
 * @link       http://sourceforge.net/projects/sabai
 * @since      Class available since Release 0.1.0
 */
class SabaiGettext_Converter
{
    /**
     * Enter description here...
     *
     * @var gettext_reader
     * @access protected
     */
    var $_reader;
    /**
     * Enter description here...
     *
     * @var string
     * @access protected
     */
    var $_codeset;

    /**
     * Constructor
     *
     * @param gettext_reader $reader
     * @param string $codeset
     * @return SabaiGettext_Converter
     */
    function SabaiGettext_Converter(&$reader, $codeset)
    {
        $this->_reader =& $reader;
        $this->_codeset = $codeset;
    }

    /**
     * Translates a message
     *
     * @param string $message
     * @return string
     */
    function translate($message)
    {
        return $this->_convert($this->_reader->translate($message));
    }

    /**
     * Translates a message
     *
     * @param string $single
     * @param string $plural
     * @param int $number
     * @return string
     */
    function ngettext($single, $plural, $number)
    {
        return $this->_convert($this->_reader->ngettext($single, $plural, $number));
    }

    /**
     * Converts the given string to the encoding set by bind_textdomain_codeset.
     *
     * @access protected
     * @param string $string
     */
    function _convert($string) {
        return mb_convert_encoding($string, $this->_codeset, 'auto');
    }
}