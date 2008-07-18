<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @subpackage Criteria
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Sabai_Model_Criteria_String
 */
require_once 'Sabai/Model/Criteria/String.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @subpackage Criteria
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Model_Criteria_StartsWith extends Sabai_Model_Criteria_String
{
    function Sabai_Model_Criteria_StartsWith($key, $str)
    {
        parent::Sabai_Model_Criteria_String($key, $str);
        $this->setType('StartsWith');
    }

    function toPHPExp()
    {
        $regex = '/^' . preg_quote($this->getValueStr(), '/') . '/i';
        $key = $this->getKey();
        return "preg_match(\"$regex\", \$entity->get('$key'))";
    }
}
