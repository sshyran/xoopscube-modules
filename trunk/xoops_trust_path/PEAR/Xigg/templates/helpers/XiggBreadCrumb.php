<?php
class Sabai_Template_PHP_Helper_XiggBreadCrumb extends Sabai_Template_PHP_Helper
{
    function create($linkSelf = true)
    {
        if ($homepage_url = $this->_tpl->Config->get('homepageURL')) {
            $html[] = sprintf('<a href="%s">%s</a>', $homepage_url, _('Home'));
        }
        if (!$linkSelf) {
            $html[] = h($this->_tpl->Config->get('toppageTitle'));
        } else {
            $html[] = sprintf('<a href="%s">%s</a> &#8250; ', $this->_tpl->Request->getScriptUri(), h($this->_tpl->Config->get('toppageTitle')));
        }
        return implode(' &#8250; ', $html);
    }

    function createForNode(&$node, $linkSelf = true)
    {
        if ($homepage_url = $this->_tpl->Config->get('homepageURL')) {
            $html[] = sprintf('<a href="%s">%s</a>', $homepage_url, _('Home'));
        }
        $html[] = sprintf('<a href="%s">%s</a>', $this->_tpl->Request->getScriptUri(), h($this->_tpl->Config->get('toppageTitle')));
        if ($category =& $node->get('Category')) {
            $parents =& $category->parents();
            while ($parent_category =& $parents->getNext()) {
                $html[] = sprintf('<a href="%s">%s</a>', $this->_tpl->Request->createUri(array('params' => array('category_id' => $parent_category->getId()))), h($parent_category->getLabel()));
            }
            $html[] = sprintf('<a href="%s">%s</a>', $this->_tpl->Request->createUri(array('params' => array('category_id' => $category->getId()))), h($category->getLabel()));
        }
        if ($linkSelf) {
            $html[] = sprintf('<a href="%s">%s</a> &#8250; ', $this->_tpl->Request->createUri(array('base' => '/node/' . $node->getId())), h(Sabai_I18N::strcutMore($node->getLabel(), 50)));
        } else {
            $html[] = h(Sabai_I18N::strcutMore($node->getLabel(), 50));
        }
        return implode(' &#8250; ', $html);
    }
}