<?php
$breadcrumb_html = array();
$breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->getScriptUri(), _('Home'));
if (!empty($role_id) && !empty($role)) {
    $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/role')), _('Role Administration'));
    if (!empty($breadcrumb_current)) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/role/' . $role_id)), h($role->getLabel()));
        $breadcrumb_html[] = $breadcrumb_current;
    } else {
        $breadcrumb_html[] = $breadcrumb_current = h($role->getLabel());
    }
} else {
    if (!empty($breadcrumb_current)) {
        $breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->createUri(array('base' => '/role')), _('Role Administration'));
        $breadcrumb_html[] = $breadcrumb_current;
    } else {
        $breadcrumb_html[] = $breadcrumb_current = _('Role Administration');
    }
}
?>
<div class="nodesBeadcrumb"><?php echo implode(' &#8250; ', $breadcrumb_html);?></div>
<h1><?php _h($breadcrumb_current);?></h1>
<?php echo $CONTENT;?>