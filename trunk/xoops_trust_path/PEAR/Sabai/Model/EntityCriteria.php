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

/**
 * Sabai_Model_Criteria_Composite
 */
require_once 'Sabai/Model/Criteria/Composite.php';

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
class Sabai_Model_EntityCriteria extends Sabai_Model_Criteria_Composite
{
    var $_andOr;

    function &add(&$criteria)
    {
        switch ($this->_andOr) {
        case SABAI_MODEL_CRITERIA_OR:
            $this->addOr($criteria);
            $this->_andOr = SABAI_MODEL_CRITERIA_AND;
            break;
        case SABAI_MODEL_CRITERIA_AND:
        default:
            $this->addAnd($criteria);
            break;
        }
        return $this;
    }

    function &and_()
    {
        $this->_andOr = SABAI_MODEL_CRITERIA_AND;
        return $this;
    }

    function &or_()
    {
        $this->_andOr = SABAI_MODEL_CRITERIA_OR;
        return $this;
    }
}