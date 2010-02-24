<?php

$dirname = basename(dirname(dirname(__FILE__)));

eval('function ' . $dirname . '_xgdb_notify($category, $item_id){
    return xgdb_notify("' . $dirname . '", $category, $item_id);}');

if (!function_exists('xgdb_notify')) {
    function xgdb_notify($dirname, $category, $item_id) {
        $item['name'] = '';
        $item['url'] = '';
        if ($category == 'change') {
            $myts =& MyTextSanitizer::getInstance();
            $xoopsDB =& Database::getInstance();
            $data_tbl = $xoopsDB->prefix($dirname . '_xgdb_data');
            $item_tbl = $xoopsDB->prefix($dirname . '_xgdb_item');

            $sql = "SELECT name FROM $item_tbl WHERE list_link = 1 ORDER BY `sequence` ASC";
            $res = $xoopsDB->query($sql, 1);
            list($name) = $xoopsDB->fetchRow($res);
            $sql = "SELECT $name FROM $data_tbl WHERE id = " . intval($item_id);
            $res = $xoopsDB->query($sql);
            list($title) = $xoopsDB->fetchRow($res);

            $item['name'] = $myts->htmlSpecialChars($title);
            $item['url'] = XOOPS_URL . '/modules/' . $dirname . '/detail.php?id=' . intval($item_id);
        }
        return $item;
    }
}

?>