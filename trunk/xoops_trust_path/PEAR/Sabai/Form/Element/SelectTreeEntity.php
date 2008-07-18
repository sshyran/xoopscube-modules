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
class Sabai_Form_Element_SelectTreeEntity extends Sabai_Form_Element_SelectDropdown
{
    var $_model;
    var $_entityName;
    var $_prefix;

    function Sabai_Form_Element_SelectTreeEntity(&$model, $entityName, $name, $size, $prefix = ' - ', $multiple = false)
    {
        parent::Sabai_Form_Element_SelectDropdown($name, $size, $multiple);
        $this->_model =& $model;
        $this->_entityName = $entityName;
        $this->_prefix = $prefix;
    }

    function onView()
    {
        // option for no parent
        $this->addOption(0, '');
        $repository =& $this->_model->getRepository($this->_entityName);
        $options =& $repository->fetchAll();
        $options->rewind();
        $entities = array();
        while ($option =& $options->getNext()) {
            $entities[$option->getParentId()][] =& $option;
            unset($option);
        }
        if (!empty($entities[0])) {
            foreach (array_keys($entities[0]) as $i) {
                $this->_fillTreeEntityOption($entities, $entities[0][$i], $this->_prefix);
            }
        }
    }

    function _fillTreeEntityOption($entities, &$entity, $prefix)
    {
        $id = $entity->getId();
        $this->addOption($id, $prefix . $entity->getLabel());
        if (!empty($entities[$id])) {
            foreach (array_keys($entities[$id]) as $i) {
                $this->_fillTreeEntityOption($entities, $entities[$id][$i], $prefix . $this->_prefix);
            }
        }
    }
}