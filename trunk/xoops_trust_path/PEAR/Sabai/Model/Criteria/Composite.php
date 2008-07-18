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
class Sabai_Model_Criteria_Composite extends Sabai_Model_Criteria
{
    /**
     * Enter description here...
     *
     * @var array
     */
    var $_elements = array();
    /**
     * Enter description here...
     *
     * @var array
     */
    var $_conditions = array();

    /**
     * Constructor
     *
     * @param array $elements
     * @return Sabai_Model_Criteria_Composite
     */
    function Sabai_Model_Criteria_Composite($elements = array())
    {
        $this->setType('Composite');
        if (!empty($elements)) {
            foreach (array_keys($elements) as $i) {
                $this->addAnd($elements[$i]);
            }
        }
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    function getElements()
    {
        return $this->_elements;
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    function getConditions()
    {
        return $this->_conditions;
    }

    /**
     * Enter description here...
     *
     * @param Sabai_Model_CriteriaBase $criteria
     */
    function addAnd(&$criteria)
    {
        $this->_elements[] =& $criteria;
        $this->_conditions[] = SABAI_MODEL_CRITERIA_AND;
    }

    /**
     * Enter description here...
     *
     * @param Sabai_Model_CriteriaBase $criteria
     */
    function addOr(&$criteria)
    {
        $this->_elements[] =& $criteria;
        $this->_conditions[] = SABAI_MODEL_CRITERIA_OR;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    function toPHPExp()
    {
        $ret = '(' . $this->_elements[0]->toPHPExp();
        $count = count($this->_elements);
        for ($i = 1; $i < $count; $i++) {
            if ($this->_conditions[$i] == SABAI_MODEL_CRITERIA_OR) {
                $ret .= ' || ' . $this->_elements[$i]->toPHPExp();
            } else {
                $ret .= ' && ' . $this->_elements[$i]->toPHPExp();
            }
        }
        return $ret . ')';
    }

    /**
     * Enter description here...
     *
     * @return bool
     */
    function isEmpty()
    {
        return empty($this->_elements);
    }
}
