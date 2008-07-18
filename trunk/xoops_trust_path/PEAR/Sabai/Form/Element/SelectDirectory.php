<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Element
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Form/Element/SelectDropdown.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Element
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Form_Element_SelectDirectory extends Sabai_Form_Element_SelectDropdown
{
    function Sabai_Form_Element_SelectDirectory($name, $size, $baseDir, $multiple = false, $excludeDir = null)
    {
        parent::Sabai_Form_Element_SelectDropdown($name, $size, $multiple);
        $exclude = array('.', '..');
        if (isset($excludeDir)) {
            $exclude = array_merge($exclude, (array)$excludeDir);
        }
        if (is_dir($baseDir) && false !== $dir = opendir($baseDir)) {
            while (false !== $_dir = readdir($dir)) {
                if (is_dir($_dir) && !in_array($_dir, $exclude)) {
                    $this->addOption($_dir);
                }
            }
            closedir($dir);
        }
    }
}