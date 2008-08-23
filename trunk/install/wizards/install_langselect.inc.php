<?php
/**
 *
 * @package Legacy
 * @version $Id: install_langselect.inc.php,v 1.2 2007/06/24 07:26:22 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
    if (!defined('_INSTALL_L128')) {
        define('_INSTALL_L128', 'Choose the language to be used for the installation process!');
    }
    $langarr = getDirList('./language/');
    foreach ($langarr as $lang) {
        $wizard->addArray('languages', $lang);
        if (strtolower($lang) == $language) {
            $wizard->addArray('selected','selected="selected"');
        } else {
            $wizard->addArray('selected','');
        }
    }
    $wizard->render('install_langselect.tpl.php');
?>
