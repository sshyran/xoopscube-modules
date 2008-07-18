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
class Sabai_Form_Element_SelectEntity extends Sabai_Form_Element_SelectDropdown
{
    var $_model;
    var $_entityName;
    var $_paginate = false;

    function Sabai_Form_Element_SelectEntity(&$model, $entityName, $name, $size, $multiple = false)
    {
        parent::Sabai_Form_Element_SelectDropdown($name, $size, $multiple);
        $this->_model =& $model;
        $this->_entityName = $entityName;
    }

    function paginate($currentPage, $pageUrl, $perpage, $sort = null, $order = null)
    {
        $this->_paginate = true;
        $this->_currentPage = $currentPage;
        $this->_pageUrl = $pageUrl;
        $this->_perpage = $perpage;
        $this->_sort = $sort;
        $this->_order = $order;
    }

    function onView()
    {
        $repository =& $this->_model->getRepository($this->_entityName);
        if ($this->_paginate) {
            $pages =& $repository->paginateAll($this->_perpage, $this->_sort, $this->_order);
            $page =& $pages->getValidPage($this->_currentPage);
            $options =& $page->getElements();
        } else {
            $options =& $repository->fetchAll();
        }
        $options->rewind();
        while ($option =& $options->getNext()) {
            $this->addOption($option->getId(), $option->getLabel());
            unset($option);
        }
    }
}