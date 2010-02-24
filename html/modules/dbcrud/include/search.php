<?php

$dirname = basename(dirname(dirname(__FILE__)));

eval('function ' . $dirname . '_xgdb_search($keywords, $andor, $limit, $offset, $userid){
	return xgdb_search("' . $dirname . '", $keywords, $andor, $limit, $offset, $userid);
}');

if (!function_exists('xgdb_search')) {
    function xgdb_search($dirname, $keywords, $andor, $limit, $offset, $userid) {
        require_once XOOPS_ROOT_PATH . '/modules/' . $dirname . '/include/functions.php';
        $myts =& MyTextsanitizer::getInstance();
        $xoopsDB =& Database::getInstance();
        $data_tbl = $xoopsDB->prefix($dirname . '_xgdb_data');

        $item_defs = getItemDefs($dirname);
        $site_search_defs = getDefs($item_defs, 'site_search');

        // GP変数の値のマジッククォートを無効化する
        if (get_magic_quotes_gpc()) {
            $_POST = array_map('stripSlashesDeep', $_POST);
            $_GET = array_map('stripSlashesDeep', $_GET);
        }

        $andor = strtoupper($andor);
        if ($andor != 'AND' && $andor != 'OR' && $andor != 'EXACT') $andor = 'AND';
        $userid = intval($userid);

        $wheres = array();
        $list_link_item_def = getListLinkItemDef($item_defs);
        $title_name = $list_link_item_def['item_name'];
        if (is_array($keywords)) {
            foreach ($keywords as $keyword) {
                $where = '(';
                foreach ($site_search_defs as $item_name => $item_def) {
                    $where .= $item_name . " LIKE '%" . addslashes($keyword) . "%' OR ";
                }
                $wheres[] = substr($where, 0, -4) . ')';
            }
        }

        $sql = "SELECT id, add_date, add_uid, $title_name FROM " . $xoopsDB->prefix($dirname . '_xgdb_data');
        if (count($wheres) > 0 || $userid > 0) $sql .= ' WHERE ';
        foreach ($wheres as $where) {
            $sql .= $where . ' ' . $andor . ' ';
        }
        if (count($wheres) > 0) $sql = substr($sql, 0, -1 * (strlen($andor) + 2));
        if ($userid > 0) {
            if (count($wheres) > 0) $sql .= ' AND ';
            $sql .= " add_uid = $userid";
        }
        $sql .= " ORDER BY id DESC";

        $res = $xoopsDB->query($sql, $limit, $offset);
        $ret = array();
        while (list($id, $add_date, $add_uid, $title) = $xoopsDB->fetchRow($res)) {
            $ret[] = array(
                'link'  => "detail.php?id=$id",
                'title' => $myts->htmlSpecialChars($title),
                'time'  => strtotime($add_date),
                'uid'   => $add_uid
            );
        }
        return $ret;
    }
}

?>