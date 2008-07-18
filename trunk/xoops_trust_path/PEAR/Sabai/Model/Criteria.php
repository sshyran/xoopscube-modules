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
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

define('SABAI_MODEL_CRITERIA_AND', 'AND');
define('SABAI_MODEL_CRITERIA_OR', 'OR');

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Model_Criteria
{
    /**
     * @var string
     * @access protected
     */
    var $_type;

    /**
     * Sets the type of criteria object
     *
     * @param string $type
     */
    function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * Accepts a gateway object as in Visitor pattern
     *
     * @param Sabai_Model_Gateway $gateway
     * @param mixed $valuePassed
     * @param bool $validateField
     */
    function acceptGateway(&$gateway, &$valuePassed, $validateField = true)
    {
        $method = 'visitCriteria' . $this->_type;
        $gateway->$method($this, $valuePassed, $validateField);
    }

    /**
     * Checks if an entity satisfies the criteira
     *
     * @param Sabai_Model_Entity $entity
     * @return bool
     */
    function isSatisfiedBy(&$entity)
    {
        $php_exp = 'return ' . $this->toPHPExp() . ';';
        return (bool)eval($php_exp);
    }

    /**
     * Checks if the criteria is empty
     *
     * @return bool
     */
    function isEmpty()
    {
        return false;
    }

    function &createComposite($elements = array())
    {
        require_once 'Sabai/Model/Criteria/Composite.php';
        $ret =& new Sabai_Model_Criteria_Composite($elements);
        return $ret;
    }

    function &createCompositeNot($elements = array())
    {
        require_once 'Sabai/Model/Criteria/CompositeNot.php';
        $ret =& new Sabai_Model_Criteria_CompositeNot($elements);
        return $ret;
    }

    function &createIn($key, $values)
    {
        require_once 'Sabai/Model/Criteria/In.php';
        $ret =& new Sabai_Model_Criteria_In($key, $values);
        return $ret;
    }

    function &createNotIn($key, $values)
    {
        require_once 'Sabai/Model/Criteria/NotIn.php';
        $ret =& new Sabai_Model_Criteria_NotIn($key, $values);
        return $ret;
    }

    function &createString($key, $string, $operator = '*')
    {
        switch($operator) {
            case '^':
                require_once 'Sabai/Model/Criteria/StartsWith.php';
                $ret =& new Sabai_Model_Criteria_StartsWith($key, $string);
                break;
            case '$':
                require_once 'Sabai/Model/Criteria/EndsWith.php';
                $ret =& new Sabai_Model_Criteria_EndsWith($key, $string);
                break;
            default:
              require_once 'Sabai/Model/Criteria/Contains.php';
              $ret =& new Sabai_Model_Criteria_Contains($key, $string);
        }
        return $ret;
    }

    function &createEmpty()
    {
        require_once 'Sabai/Model/Criteria/Empty.php';
        $ret =& new Sabai_Model_Criteria_Empty();
        return $ret;
    }

    function &createValue($key, $value, $operator = '=')
    {
        switch($operator) {
            case '<':
                require_once 'Sabai/Model/Criteria/IsSmallerThan.php';
                $ret =& new Sabai_Model_Criteria_IsSmallerThan($key, $value);
                break;
            case '>':
                require_once 'Sabai/Model/Criteria/IsGreaterThan.php';
                $ret =& new Sabai_Model_Criteria_IsGreaterThan($key, $value);
                break;
            case '<=':
                require_once 'Sabai/Model/Criteria/IsOrSmallerThan.php';
                $ret =& new Sabai_Model_Criteria_IsOrSmallerThan($key, $value);
                break;
            case '>=':
                require_once 'Sabai/Model/Criteria/IsOrGreaterThan.php';
                $ret =& new Sabai_Model_Criteria_IsOrGreaterThan($key, $value);
                break;
            case '!=':
                require_once 'Sabai/Model/Criteria/IsNot.php';
                $ret =& new Sabai_Model_Criteria_IsNot($key, $value);
                break;
            default:
              require_once 'Sabai/Model/Criteria/Is.php';
              $ret =& new Sabai_Model_Criteria_Is($key, $value);
        }
        return $ret;
    }
}
