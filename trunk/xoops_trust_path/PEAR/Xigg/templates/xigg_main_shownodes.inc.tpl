<?php
$this->loadHelpers(array('XiggBreadCrumb', 'HTML', 'PageNavRemote', 'XiggTime', 'Token')); // not required in PHP5
$_base_route = !empty($_upcoming) ? '/node/upcoming' : '/';
$breadcrumb_html = array();
if (!empty($requested_category)) {
    $requested_category_id = $requested_category->getId();
    $parent_id = $requested_category->getParentId();
    if (!empty($requested_keyword)) {
        $category_title = _('Search: ') . $requested_keyword;
        $breadcrumb_html[] = h($category_title);
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => $_base_route, 'params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id))), h($requested_category->getLabel()));
    } else {
        $category_title = $requested_category->getLabel();
        $breadcrumb_html[] = h($category_title);
    }
    while (isset($categories[$parent_id])) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => $_base_route, 'params' => array('category_id' => $parent_id, 'user_id' => $requested_user_id))), h($categories[$parent_id]->getLabel()));
        $parent_id = $categories[$parent_id]->getParentId();
    }
    if (!empty($requested_user_id)) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => $_base_route, 'params' => array('user_id' => $requested_user_id))), _('User: ') . h($requested_user->getName()));
    }
} else {
    $requested_category_id = 0;
    if (!empty($requested_keyword)) {
        $category_title = _('Search: ') . $requested_keyword;
        $breadcrumb_html[] = h($category_title);
        if (!empty($requested_user_id)) {
            $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => $_base_route, 'params' => array('user_id' => $requested_user_id))), _('User: ') . h($requested_user->getName()));
        }
    } else {
        if (!empty($requested_user_id)) {
            $category_title = _('User: ') . h($requested_user->getName());
            $breadcrumb_html[] = h($category_title);
        } else {
            $category_title = $this->Config->get('toppageTitle');
        }
    }
}
if (!empty($breadcrumb_html)) {
    krsort($breadcrumb_html);
    $breadcrumb = $this->XiggBreadCrumb->create() . implode(' &#8250; ', $breadcrumb_html);
} else {
    $breadcrumb = $this->XiggBreadCrumb->create(false);
}
$entity_count_last = $page->getOffset() + $page->getLimit();
$entity_count_first = $entity_count_last > 0 ? $page->getOffset() + 1 : 0;
$node_nav_result = sprintf(_('Showing %1$d - %2$d of %3$d'), $entity_count_first, $entity_count_last, $pages->getElementCount());
?>