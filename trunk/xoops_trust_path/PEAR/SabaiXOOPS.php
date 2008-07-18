<?php
/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   SabaiXOOPS
 * @package    SabaiXOOPS
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/gpl-license.php GNU GPL
 * @link       http://sourceforge.net/projects/sabai
 * @version    0.1.9a2
 * @since      Class available since Release 0.1.0
 */
class SabaiXOOPS
{
    /**
     * Runs the XC module version of a Sabai application
     *
     * @static
     * @param Sabai_Application $application
     * @param Sabai_Controller $controller
     * @param string $moduleName
     * @param string $moduleDir
     * @param array $context
     * @param string $layoutFile
     */
    function run(&$application, &$controller, $moduleName, $moduleDir, $layoutFile = null)
    {
        require_once 'Sabai/Request/Web.php';
        require_once 'Sabai/Response/Web.php';
        $script_filename = strpos($_SERVER['SCRIPT_FILENAME'], 'php.cgi') ? $_SERVER['PATH_TRANSLATED'] : $_SERVER['SCRIPT_FILENAME'];
        $request =& new Sabai_Request_Web(XOOPS_URL . '/modules/' . $moduleDir . '/' . basename($script_filename));
        $response =& new Sabai_Response_Web(SabaiXOOPS::getTemplate($application, $moduleName, $moduleDir));
        $response->setLayout(
                       XOOPS_URL . '/modules/' . $moduleDir . '/layouts/default',
                       XOOPS_ROOT_PATH . '/modules/' . $moduleDir . '/layouts/default',
                       $layoutFile
                   );
        if (file_exists($css_file = XOOPS_ROOT_PATH . '/themes/' . $GLOBALS['xoopsConfig']['theme_set'] . '/modules/' . $moduleDir . '/css/screen.css')) {
            $response->addCSSFile($css_file);
        }
        $user =& SabaiXOOPS::getCurrentUser();
        require_once 'Sabai/Controller/Context.php';
        $context =& new Sabai_Controller_Context(array(
                                                   'request'     => &$request,
                                                   'response'    => &$response,
                                                   'user'        => &$user));
        $application->run($controller, $context);
    }

    /**
     * Gets module specific configuration object
     *
     * @static
     * @staticvar array $configs
     * @param string $moduleName
     * @param string $moduleDir
     * @param array $default
     * @return Sabai_Config_Array
     */
    function getConfig($moduleName, $moduleDir, $default = array())
    {
        static $configs;
        if (!isset($configs[$moduleDir])) {
            if (!is_dir($locale_dir = XOOPS_ROOT_PATH . '/modules/' . $moduleDir . '/locales')) {
                if (!is_dir($locale_dir = XOOPS_TRUST_PATH . '/modules/' . $moduleName . '/locales')) {
                    $locale_dir = null;
                }
            }
            $configs[$moduleDir] = array_merge(
                        $default,
                        SabaiXOOPS::getModuleConfig($moduleDir),
                        array(
                          'I18N'   => array(
                                        'locales'        => SabaiXOOPS::getLocales(),
                                        'localeDir'      => $locale_dir,
                                      ),
                          'DB'     => array(
                                        'scheme'         => XOOPS_DB_TYPE,
                                        'tablePrefix'    => XOOPS_DB_PREFIX . '_' . strtolower($moduleDir) . '_' ,
                                        'clientEncoding' => (strpos(XOOPS_VERSION, '2.0.', 1) || (defined('LEGACY_JAPANESE_ANTI_CHARSETMYSQL') && LEGACY_JAPANESE_ANTI_CHARSETMYSQL)) ? null : _CHARSET,
                                        'options'        => array(
                                                            'host'   => XOOPS_DB_HOST,
                                                            'dbname' => XOOPS_DB_NAME,
                                                            'user'   => XOOPS_DB_USER,
                                                            'pass'   => XOOPS_DB_PASS,
                                                          )
                                      ),
                          'User'   => array(
                                        'scheme'          => 'custom',
                                        'Authenticator'   => array(
                                                             'file'  => 'SabaiXOOPS/User/Authenticator.php',
                                                             'class' => 'SabaiXOOPS_User_Authenticator'
                                                           ),
                                        'IdentityFetcher' => array(
                                                             'file'  => 'SabaiXOOPS/User/IdentityFetcher.php',
                                                             'class' => 'SabaiXOOPS_User_IdentityFetcher'
                                                           )
                                      )
                        ));
        }
        return $configs[$moduleDir];
    }

    /**
     * Gets module specific configuration variables
     *
     * @static
     * @param string $moduleDir
     * @return array
     */
    function getModuleConfig($moduleDir)
    {
        if (SabaiXOOPS::isInModule($moduleDir) && isset($GLOBALS['xoopsModuleConfig'])) {
            return $GLOBALS['xoopsModuleConfig'];
        }
        // if not, load the module configuration variables
        $module_h =& xoops_gethandler('module');
        if (!$module =& $module_h->getByDirname($moduleDir)) {
            trigger_error(sprintf('Requested module %s does not exist', $moduleDir), E_USER_WARNING);
            return array();
        }
        $config_h =& xoops_gethandler('config');
        return $config_h->getConfigsByCat(0, $module->getVar('mid'));
    }

    /**
     * Checks if the current page is within the specified module
     *
     * @param string $moduleDir
     * @return bool
     */
    function isInModule($moduleDir)
    {
        return isset($GLOBALS['xoopsModule']) && ($GLOBALS['xoopsModule']->getVar('dirname') == $moduleDir);
    }

    /**
     * Gets a template object for a XC module
     *
     * @static
     * @staticvar array $templates
     * @param Sabai_Application $application
     * @param string $moduleName
     * @param string $moduleDir
     * @return Sabai_Template_PHP
     */
    function &getTemplate(&$application, $moduleName, $moduleDir)
    {
        static $templates = array();
        if (!isset($templates[$moduleDir])) {
            require_once 'Sabai/Template/PHP.php';
            $templates[$moduleDir] =& new Sabai_Template_PHP(
                                             array(
                                               $application->getPath() . '/templates',
                                               XOOPS_TRUST_PATH . '/modules/' . $moduleName . '/templates'
                                             ));
            // module installation specific template files
            if (is_dir($custom_tpldir = XOOPS_ROOT_PATH . '/modules/' . $moduleDir . '/templates')) {
                $templates[$moduleDir]->addTemplateDir($custom_tpldir);
            }
        }
        return $templates[$moduleDir];
    }

    /**
     * Gets locale names from charset and lang settings in XC
     *
     * @static
     * @staticvar array $locales
     * @return array
     */
    function getLocales()
    {
        static $locales;
        if (!isset($locales)) {
            include dirname(__FILE__) . '/SabaiXOOPS/lang2locales.inc.php';
            $lang = strtolower(_LANGCODE);
            $charset = strtoupper(_CHARSET);
            $locales = isset($lang2locales[$lang][$charset]) ? (array)$lang2locales[$lang][$charset] : array('en_US.ISO8859-1');
        }
        return $locales;
    }

    /**
     * Gets the current user object
     *
     * @static
     * @return Sabai_User
     */
    function &getCurrentUser()
    {
        require_once 'Sabai/User.php';
        if (isset($GLOBALS['xoopsUser']) && is_object($GLOBALS['xoopsUser'])) {
            $user =& new Sabai_User(SabaiXOOPS::getUserIdentity($GLOBALS['xoopsUser']), true);
        } else {
            $user =& new Sabai_User(SabaiXOOPS::getGuestIdentity(), false);
        }
        return $user;
    }

    /**
     * Gets an user object by login information
     *
     * @static
     * @param string $username
     * @param string $password
     * @param string $module
     * @return Sabai_User
     */
    function &getUserByLogin($username, $password, $module = null)
    {
        $member_h =& xoops_gethandler('member');
        $xoops_user =& $member_h->loginUser(addslashes($username), $password);
        if (!is_object($xoops_user)) {
            $ret = false; return $ret;
        }
        require_once 'Sabai/User.php';
        $user =& new Sabai_User(SabaiXOOPS::getUserIdentity($xoops_user), true);
        return $user;
    }

    /**
     * Gets a registered user identity
     *
     * @param XoopsUser $xoopsUser
     * @return Sabai_User_IDentity
     * @static
     */
    function &getUserIdentity(&$xoopsUser)
    {
        $uid = $xoopsUser->getVar('uid');
        $name = $xoopsUser->getVar('name');
        $identity =& new Sabai_User_Identity($uid);
        $identity->setName(!empty($name) ? $name : $xoopsUser->getVar('uname'));
        $identity->setEmail($xoopsUser->getVar('email'));
        $identity->setProfileURL(XOOPS_URL . '/userinfo.php?uid=' . $uid);
        $identity->setURL($xoopsUser->getVar('url'));
        if ('blank.gif' != $avatar = $xoopsUser->getVar('user_avatar')) {
            $identity->setImage(XOOPS_URL . '/uploads/' . $avatar);
        }
        return $identity;
    }

    /**
     * Gets a guest user identity
     *
     * @return Sabai_User_Identity
     * @static
     */
    function &getGuestIdentity()
    {
        $identity =& new Sabai_User_Identity();
        $identity->setName($GLOBALS['xoopsConfig']['anonymous']);
        //$identity->setImage(XOOPS_URL . '/uploads/blank.gif');
        return $identity;
    }
}