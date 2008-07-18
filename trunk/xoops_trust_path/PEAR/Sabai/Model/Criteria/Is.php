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
 * Sabai_Model_Criteria_Value
 */
require_once 'Sabai/Model/Criteria/Value.php';

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
class Sabai_Model_Criteria_Is extends Sabai_Model_Criteria_Value
{
    function Sabai_Model_Criteria_Is($key, $value)
    {
        parent::Sabai_Model_Criteria_Value($key, $value);
        $this->setType('Is');
    }

    function toPHPExp()
    {
        $value_str = str_replace("'", "\\'", $this->getValue());
        $key = $this->getKey();
        return "\$entity->get('$key') != '$value_str'";
    }
}
