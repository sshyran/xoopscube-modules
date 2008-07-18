<?php
$breadcrumb_html = array();
$breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->getScriptUri(), _('Home'));

if (!empty($category_id) && !empty($category)) {
    $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/category')), _('Category Administration'));
    $parent_categories =& $category->parents();
    while ($parent_category =& $parent_categories->getNext()) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/category/' . $parent_category->getId())), h($parent_category->getLabel()));
    }
    if (!empty($breadcrumb_current)) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/category/' . $category_id)), h($category->getLabel()));
        $breadcrumb_html[] = $breadcrumb_current;
    } else {
        $breadcrumb_html[] = $breadcrumb_current = h($category->getLabel());
    }
} else {
    if (!empty($breadcrumb_current)) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/category')), _('Category Administration'));
        $breadcrumb_html[] = $breadcrumb_current;
    } else {
        $breadcrumb_html[] = $breadcrumb_current = _('Category Administration');
    }
}
?>
<div class="nodesBeadcrumb"><?php echo implode(' &#8250; ', $breadcrumb_html);?></div>
<h1><?php echo $breadcrumb_current;?></h1>
<?php echo $CONTENT;?>