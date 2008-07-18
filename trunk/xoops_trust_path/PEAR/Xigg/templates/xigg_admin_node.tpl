<?php
$breadcrumb_html = array();
$breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->getScriptUri(), _('Home'));
if (!empty($node_id) && !empty($node)) {
    $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/node')), _('Article Administration'));
    if (!empty($breadcrumb_current)) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/node/' . $node_id)), h($node->getLabel()));
        $breadcrumb_html[] = $breadcrumb_current;
    } else {
        $breadcrumb_html[] = $breadcrumb_current = h($node->getLabel());
    }
} else {
    if (!empty($breadcrumb_current)) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/node')), _('Article Administration'));
        $breadcrumb_html[] = $breadcrumb_current;
    } else {
        $breadcrumb_html[] = $breadcrumb_current = _('Article Administration');
    }
}
?>
<div class="nodesBeadcrumb"><?php echo implode(' &#8250; ', $breadcrumb_html);?></div>
<h1><?php _h($breadcrumb_current);?></h1>
<?php echo $CONTENT;?>