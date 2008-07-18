<?php
/**
 * gettext_reader
 */
require 'SabaiGettext/php-gettext/gettext.php';
/**
 * Other classes required for php-gettext
 */
require 'SabaiGettext/php-gettext/streams.php';

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
 * @version    0.1.9a2
 * @since      Class available since Release 0.1.0
 */
class SabaiGettext
{
    /**
     * Array of text domain names
     *
     * @var array
     * @access protected
     */
    var $_textDomains = array();
    /**
     * The default text domain
     *
     * @var string
     * @access protected
     */
    var $_defaultTextDomain;
    /**
     * Array of gettext reader objects
     *
     * @var array
     * @access protected
     */
    var $_readers = array();

    /**
     * Gets a singlegon
     *
     * @return SabaiGettext
     * @static
     * @staticvar $instance Singleton
     */
    function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new SabaiGettext();
        }
        return $instance;
    }

    /**
     * Gets an instance of gettext reader
     *
     * @param string $textDomain
     * @param int $category
     * @param bool $useCache
     * @return gettext_reader
     * @staticvar $categories
     */
    function &getReader($textDomain = null, $category = LC_MESSAGES, $useCache = true) {
        static $categories = array(LC_ALL      => 'LC_ALL',
                                   LC_COLLATE  => 'LC_COLLATE',
                                   LC_CTYPE    => 'LC_CTYPE',
                                   LC_MONETARY => 'LC_MONETARY',
                                   LC_NUMERIC  => 'LC_NUMERIC',
                                   LC_TIME     => 'LC_TIME',
                                   LC_MESSAGES => 'LC_MESSAGES');
        $category = !isset($categories[$category]) ? LC_MESSAGES : $category;
        $textDomain = empty($textDomain) ? $this->_defaultTextDomain : $textDomain;
	    if (!isset($this->_readers[$textDomain][$category])) {
		    $base = isset($this->_textDomains[$textDomain]['path']) ? $this->_textDomains[$textDomain]['path'] : '.';
		    $path = sprintf('%s/%s/%s/%s.mo', $base, setlocale($category, '0'), $categories[$category], $textDomain);
		    if (file_exists($path)) {
		        $reader =& new gettext_reader(new FileReader($path), $useCache);
		    } else {
			    $reader =& new gettext_reader(null, $useCache);
		    }
		    // use auto encoding converter if codeset is defined
		    /*if (isset($this->_textDomains[$textDomain]['codeset'])) {
		        if (function_exists('mb_convert_encoding')) {
		            require_once 'SabaiGettext/Converter.php';
		            $reader =& new SabaiGettext_Converter($reader, $this->_textDomains[$textDomain]['codeset']);
		        } else {
		            trigger_error('Function mb_convert_encoding() required to use the auto encoding converter', E_USER_WARNING);
		        }
		    }*/
		    $this->_readers[$textDomain][$category] =& $reader;
	    }
	    return $this->_readers[$textDomain][$category];
    }

    /**
     * Sets the path for a domain.
     *
     * @param string $textDomain
     * @param string $path
     */
    function setTextdomainPath($textDomain, $path) {
	    $this->_textDomains[$textDomain]['path'] = $path;
	    // unset readers for the domain to reflect the change
	    unset($this->_readers[$textDomain]);
    }

    /**
     * Specify the character encoding in which the messages from the DOMAIN message catalog will be returned.
     *
     * @param string $textDomain
     * @param string $codeset
     */
    function setTextdomainCodeset($textDomain, $codeset) {
	    $this->_textDomains[$textDomain]['codeset'] = $codeset;
	    // unset readers for the domain to reflect the change
	    unset($this->_readers[$textDomain]);
    }

    /**
     * Sets the default domain.
     *
     * @param string $textDomain
     */
    function setDefaultTextdomain($textDomain) {
	    $this->_defaultTextDomain = $textDomain;
    }
}

function bindtextdomain($textDomain, $path) {
    $gettext =& SabaiGettext::getInstance();
	return $gettext->setTextdomainPath($textDomain, $path);
}

function bind_textdomain_codeset($textDomain, $codeset) {
    $gettext =& SabaiGettext::getInstance();
	return $gettext->setTextdomainCodeset($textDomain, $codeset);
}

function textdomain($textDomain) {
    $gettext =& SabaiGettext::getInstance();
	return $gettext->setDefaultTextdomain($textDomain);
}

function gettext($message) {
    $gettext =& SabaiGettext::getInstance();
    $reader =& $gettext->getReader();
	return $reader->translate($message);
}

function _($message) {
	return gettext($message);
}

function ngettext($single, $plural, $number) {
    $gettext =& SabaiGettext::getInstance();
	$reader =& $gettext->getReader();
	return $reader->ngettext($single, $plural, $number);
}

function dgettext($textDomain, $message) {
    $gettext =& SabaiGettext::getInstance();
    $reader =& $gettext->getReader($textDomain);
	return $reader->translate($message);
}

function dngettext($textDomain, $single, $plural, $number) {
    $gettext =& SabaiGettext::getInstance();
    $reader =& $gettext->getReader($textDomain);
	return $reader->ngettext($single, $plural, $number);
}

function dcgettext($textDomain, $message, $category) {
    $gettext =& SabaiGettext::getInstance();
    $reader =& $gettext->getReader($textDomain, $category);
	return $reader->translate($message);
}

function dcngettext($textDomain, $single, $plural, $number, $category) {
    $gettext =& SabaiGettext::getInstance();
    $reader =& $gettext->getReader($textDomain, $category);
	return $reader->ngettext($single, $plural, $number);
}