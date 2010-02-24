<?php

require_once '../../../include/cp_header.php';
require_once 'include/common.php';

$errors = array();
if (!extension_loaded('mbstring')) {
    $errors[] = constant('_AM_' . $affix . '_MBSTRING_DISABLE_ERR');
}
if (!extension_loaded('gd')) {
    $errors[] = constant('_AM_' . $affix . '_GD_DISABLE_ERR');
} else {
    $gd_infos = gd_info();
    if (!$gd_infos['GIF Read Support'] || !$gd_infos['GIF Create Support'] || !$gd_infos['JPG Support'] || !$gd_infos['PNG Support']) {
        $errors[] = constant('_AM_' . $affix . '_GD_NOT_SUPPORTED_ERR');
    }
}

xoops_cp_header();

$items = array();
$res = $xoopsDB->query("SELECT * FROM $item_tbl ORDER BY `sequence` ASC, `iid` ASC");
while ($row = $xoopsDB->fetchArray($res)) {
    $item = array();
    $item['iid'] = $row['iid'];
    $item['name'] = $myts->htmlSpecialChars($row['name']);
    $item['caption'] = $myts->htmlSpecialChars($row['caption']);
    $item['type'] = $myts->htmlSpecialChars($row['type']);
    $item['type_title'] = $types[$row['type']];
    $item['required'] = $row['required'];
    $item['sequence'] = $row['sequence'];
    $item['search'] = $row['search'];
    $item['list'] = $row['list'];
    $item['add'] = $row['add'];
    $item['update'] = $row['update'];
    $item['detail'] = $row['detail'];
    $item['duplicate'] = $row['duplicate'];
    $item['list_link'] = $row['list_link'];
    $items[] = $item;
}
$xoopsTpl->assign('items', $items);

$type_item_def = array(
    'options'    => array_flip($types),
    'type'       => 'select',
    'value_type' => 'string'
);
$item_add_msg = sprintf($admin_consts['_ITEM_ADD_MSG'], makeSelectForm($dirname, 'type', $type_item_def, ''));
$xoopsTpl->assign('item_add_msg', $item_add_msg);
$xoopsTpl->assign('errors', $errors);

$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/' . $dirname . '/templates/admin/xgdb_admin_index.html');

xoops_cp_footer();

?>
