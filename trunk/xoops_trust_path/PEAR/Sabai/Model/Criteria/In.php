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
 * Sabai_Model_Criteria_Array
 */
require_once 'Sabai/Model/Criteria/Array.php';

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
class Sabai_Model_Criteria_In extends Sabai_Model_Criteria_Array
{
    function Sabai_Model_Criteria_In($key, $values)
    {
        parent::Sabai_Model_Criteria_Array($key, $values);
        $this->setType('In');
    }

    function toPHPExp()
    {
        $value_str = implode("' ,'", $this->getValueArray());
        $key = $this->getKey();
        return "in_array(\$entity->get('$key'), array('$value_str'))";
    }
}
