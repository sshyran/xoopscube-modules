<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_User
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.7
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_User
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.7
 */
class Sabai_User_Identity
{
    var $_id;
    var $_name;
    var $_email;
    var $_profileUrl;
    var $_url;
    var $_image;

    /**
     * Constructor
     *
     * @param string $id
     * @return Sabai_User_Identity
     */
    function Sabai_User_Identity($id = '')
    {
        $this->_id = $id;
    }

    /**
     * Returns the string identifier of this identity
     *
     * @return string
     */
    function getId()
    {
        return $this->_id;
    }

    /**
     * Gets the display name of this identity
     *
     * @return string
     */
    function getName()
    {
        return $this->_name;
    }

    /**
     * Sets the display name of this identity
     *
     * @param string $name
     */
    function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Gets the email address of this identity
     *
     * @return string
     */
    function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the email address of this identity
     *
     * @param string $email
     */
    function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Gets the website URL of this identity
     *
     * @return string
     */
    function getURL()
    {
        return $this->_Url;
    }

    /**
     * Sets the website URL of this identity
     *
     * @param string $url
     */
    function setURL($url)
    {
        $this->_url = $url;
    }

    /**
     * Gets the profile URL of this identity
     *
     * @return string
     */
    function getProfileURL()
    {
        return $this->_profileUrl;
    }

    /**
     * Sets the profile URL of this identity
     *
     * @param string $url
     */
    function setProfileURL($url)
    {
        $this->_profileUrl = $url;
    }

    /**
     * Gets the image url of this identity
     *
     * @return string
     */
    function getImage()
    {
        return $this->_image;
    }

    /**
     * Sets the image url of this identity
     *
     * @param string $image
     */
    function setImage($image)
    {
        $this->_image = $image;
    }

    /**
     * Gets the HTML link of this identity
     *
     * @return string
     * @param string $target
     */
    function getHTMLLink($target = '_self')
    {
        $name = !empty($this->_name) ? $this->_name : $this->_id;
        if (!empty($this->_profileUrl)) {
            return sprintf('<a href="%1$s" target="%2$s">%3$s</a>', $this->_profileUrl, h($target), h($name));
        }
        return h($name);
    }

    /**
     * Gets the image HTML link of this identity
     *
     * @return string
     * @param int $width
     * @param int $height
     * @param string $target
     */
    function getHTMLImageLink($width = 16, $height = 16, $target = '_self')
    {
        if (!$image = $this->getImage()) {
            return '';
        }
        $name = !empty($this->_name) ? $this->_name : $this->_id;
        if (!empty($this->_profileUrl)) {
            return sprintf('<a href="%2$s" target="%6$s"><img src="%1$s" width="%4$d" height="%5$d" title="%3$s" alt="%3$s" /></a>', $this->_image, $this->_profileUrl, h($name), $width, $height, h($target));
        }
        return sprintf('<img src="%1$s" width="%3$d" height="%4$d" title="%2$s" alt="%2$s" />', $this->_image, h($name), $width, $height);
    }

    /**
     * Prints the HTML link of this identity
     *
     * @return string
     * @param string $target
     */
    function printHTMLLink($target = '_self')
    {
        echo $this->getHTMLLink($target);
    }

    /**
     * Prints the image HTML link of this identity
     *
     * @return string
     * @param int $width
     * @param int $height
     * @param string $target
     */
    function printHTMLImageLink($width = 16, $height = 16, $target = '_self')
    {
        echo $this->getHTMLImageLink($width, $height, $target);
    }
}