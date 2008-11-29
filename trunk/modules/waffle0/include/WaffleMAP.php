<?php

if (defined('__WAFFLEMAP_PHP__')) {
    return;
}

define('__WAFFLEMAP_PHP__', '1');

$basename = basename(dirname(dirname(__FILE__)));
include(XOOPS_ROOT_PATH . '/modules/' . $basename . '/include/spyc/spyc.php');

require_once(XOOPS_ROOT_PATH . '/modules/' . $basename . '/config.php');
require_once(XOOPS_ROOT_PATH . '/modules/' . $basename . '/include/ValidateInfo.php');
require_once(XOOPS_ROOT_PATH . '/modules/' . $basename . '/include/misc.php');

/** O/R MAP like class */
class WaffleMAP
{
    var $yaml;
    var $mydirname;
    var $all_select_limit = 65536;
    var $column_map;
    var $primary_key_no = '';
    var $primary_key_name = '';
    var $create_datetime_column_name = WAFFLE_CREATE_DATETIME_COLUMN_NAME;
    var $update_datetime_column_name = WAFFLE_UPDATE_DATETIME_COLUMN_NAME;
    var $create_user_id_column_name = WAFFLE_CREATE_USER_ID_COLUMN_NAME;
    var $update_user_id_column_name = WAFFLE_UPDATE_USER_ID_COLUMN_NAME;
    var $listview;
    var $list_epoctime;
    var $table_name;
    var $image_exists;
    var $file_exists;
    var $php_code_exists;
    var $rel_exists;
    var $rel_table;
    var $rel_column;
    var $rel_v_column;
    var $rel_where;
    var $rel_type;
    var $rel_table_list;
    var $rel_table_alias;
    var $rel_sql;
    
    function WaffleMAP($yaml)
    {
	global $xoopsDB;

	$this->yaml = Spyc::YAMLLoad($yaml);
	$this->listview = array();
	$this->list_epoctime = array();
	$this->table_name = $xoopsDB->prefix($this->yaml['name']);
	$this->image_exists = false;
	$this->file_exists = false;
	$this->rel_exist = false;
	$this->php_code_exist = false;
	$this->rel_table = array();
	$this->rel_column = array();
	$this->rel_v_column = array();
	$this->rel_where = array();
	$this->rel_type = array();
	$this->mydirname = basename( dirname( dirname( __FILE__ ) ) );
	$this->rel_table_list = array();;
	$this->rel_table_alias = array();;
	$this->rel_sql = '';
	
	if (isset($this->yaml['create_datetime_column_name'])) {
	    $this->create_datetime_column_name = $this->yaml['create_datetime_column_name'];
	}
	if (isset($this->yaml['update_datetime_column_name'])) {
	    $this->update_datetime_column_name = $this->yaml['update_datetime_column_name'];
	}
	if (isset($this->yaml['create_user_id_column_name'])) {
	    $this->create_user_id_column_name = $this->yaml['create_user_id_column_name'];
	}
	if (isset($this->yaml['update_user_id_column_name'])) {
	    $this->update_user_id_column_name = $this->yaml['update_user_id_column_name'];
	}

	$rel_table_tmp = array();
	$rel_table_count = array();
	
	$c_table_alias_list = array();
	$c_column_list = array();
	$c_column_alias_list = array();
	
	$t_table_list = array();
	$t_table_alias_list = array();
	$column_count = 0;
	
	foreach ($this->yaml['columns'] as $key => $val) {
	    $val['key'] = $key;

	    if ((!isset($val['desc'])) || $val['desc'] == '') {
		$val['desc'] = $val['name'];
	    }

	    if (isset($val['listview']) && $val['listview']) {
		$this->listview[$val['name']] = 1;
	    }
	    
	    if ($val['type'] == 'epoctime') {
		$this->list_epoctime[$val['name']] = 1;
	    }
	    
	    if (isset($val['primary_key'])) {
		$this->primary_key_no = $key;
		$this->primary_key_name = $val['name'];
		$val['not_insert_form'] = 1;
	    }

	    if ($val['name'] == $this->create_datetime_column_name) {
		$val['not_insert_form'] = 1;
	    }
	    
	    if ($val['name'] == $this->update_datetime_column_name) {
		$val['not_insert_form'] = 1;
	    }
	    
	    if ($val['name'] == $this->create_user_id_column_name) {
		$val['not_insert_form'] = 1;
	    }

	    if ($val['name'] == $this->update_user_id_column_name) {
		$val['not_insert_form'] = 1;
	    }
	    
	    if ($val['type'] == 'image') {
		$this->image_exists = true;
	    }
	    
	    if ($val['type'] == 'file') {
		$this->file_exists = true;
	    }
	    
	    if ($val['type'] == 'php_code') {
		$this->php_code_exists = true;
	    }

	    if (isset($val['rel_table']) && $val['rel_table']) {
		$this->rel_exists = true;

		$column_count++;
		
		if (! isset($rel_table_count[$val['rel_table']])) {
		    $rel_table_count[$val['rel_table']] = 0;
		}
		$rel_table_count[$val['rel_table']]++;
		array_push($t_table_list, $xoopsDB->prefix($val['rel_table']));
		array_push($t_table_alias_list, $xoopsDB->prefix($val['rel_table'] . '_' . $rel_table_count[$val['rel_table']]));

		$table_alias = $xoopsDB->prefix($val['rel_table'] . '_' . $rel_table_count[$val['rel_table']]);
		$c_table_alias_list[] = $table_alias;
		$c_column_list[] = $val['rel_v_column'];
		$c_column_alias_list[] = $val['rel_v_column'] . '_' . $column_count;

		array_push($this->rel_column, $val['rel_column']);
		array_push($this->rel_v_column, $val['rel_v_column']);
		array_push($this->rel_where, '(' . $this->table_name . '_m.' . $val['name'] . ' = ' . $table_alias . '.' . $val['rel_column'] . ')');
		
		$this->rel_type[$val['name']] = $val['rel_type'];
		$val['org_name'] = $val['name'];

		$val['name'] = $val['rel_v_column'] . '_' . $column_count;
		
	    } else {
		if (! isset($rel_table_count[$this->table_name])) {
		    $rel_table_count[$this->table_name] = 0;
		}
		$rel_table_count[$this->table_name]++;

		$c_table_alias_list[] = $this->table_name . '_m';
		$c_column_list[] = $val['name'];
		$c_column_alias_list[] = $val['name'];
	    }

	    $this->column_map[$val['name']] = $val;
	}
	
	if ($this->rel_exists) {
	    array_push($this->rel_table, array_keys($rel_table_tmp));

	    $sql = 'SELECT ';
	    
	    $ctmp = array();
	    for ($i=0; isset($c_column_list[$i]); $i++) {
		$ctmp[] = $c_table_alias_list[$i] . '.' . $c_column_list[$i] . ' as ' . $c_column_alias_list[$i];
	    }
	    
	    $sql .= implode(', ', $ctmp);
	    $sql .= ' FROM ';
	    $sql .= $this->table_name . ' as ' . $this->table_name . '_m, ';

	    $i = 0;
	    $ctmp = array();
	    foreach ($t_table_list as $key => $val) {
		$ctmp[] = $val . ' AS ' . $t_table_alias_list[$i];
		$i++;
	    }
	    
	    $sql .= implode(',', $ctmp);
	    $sql .= ' WHERE ';
	    $sql .= implode(' AND ', $this->rel_where);
	    
	    $this->rel_sql = $sql;
	}
    }
    
    function get_mydirname()
    {
	if (isset($GLOBALS['mydirname_search'])) {
	    return $GLOBALS['mydirname_search'];
	}

	if (isset($this) && isset($this->mydirname)) {
	    return $this->mydirname;
	} else {
	    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
	    return $mydirname;
	}
    }
    
    /**
     * オブジェクトを生成する。キャッシュがある場合はそちらを使う。
     */
    function new_with_cache($yaml)
    {
	$cache_file = $yaml . '.cache';
	$yaml_file = YAML_DIR . $yaml;
	
	$ctime = WaffleMAP::get_config_time($cache_file);

	// ファイルがある場合はファイルを第一候補に
	if (is_readable($yaml_file)) {
	    $fp2 = fopen($yaml_file, "r");
	    $ystat = fstat($fp2);
	    fclose($fp2);
	    
	    if ($ystat['mtime'] < $ctime) {
		return WaffleMAP::get_config($cache_file);
	    } else {
		$f = new WaffleMAP($yaml_file);
		WaffleMAP::set_config($cache_file, $f);
		return $f;
	    }
	}
	
	$ytime = WaffleMAP::get_config_time($yaml);
	
	if ($ytime == 0) {
	    die(sprintf(_MD_NO_YAML, $yaml));
	}

	if ($ytime < $ctime) {
	    $a =  WaffleMAP::get_config($cache_file);
	    return $a;
	} else {
	    $y = WaffleMAP::get_config($yaml);
	    $f = new WaffleMAP($y);
	    WaffleMAP::set_config($cache_file, $f);
	    return $f;
	}
    }

    /**
     * 
     */
    function get_one($column, $where = '')
    {
	global $xoopsDB;

	$sql = 'SELECT ' . mysql_real_escape_string($column);
	$sql .= ' FROM ' . $this->table_name;
	$sql .= ' WHERE ' . $where;
	$sql .= ' LIMIT 1';

	$result = $xoopsDB->query($sql);
	$arr = $xoopsDB->fetchRow($result);
	
	return $arr[0];
    }

    /**
     * 
     */
    function get_row($id, $flg_rel=true)
    {
	global $xoopsDB;
	
	if ($this->rel_exists && $flg_rel) {
	    return $this->get_row_with_rel($id);
	}

	$sql = 'SELECT * ';
	$sql .= ' FROM ' . $this->table_name;
	$sql .= ' WHERE ' . $this->primary_key_name . " = " . intval($id);
	if (isset($this->yaml) && isset($this->yaml['validable']) && $this->yaml['validable'] && (!WaffleGrant::is_admin())) {
	    $sql .= ' AND ' . $this->yaml['validable_column'] . ' = 1 ';
	}
	$sql .= ' LIMIT 1';

	$result = $xoopsDB->query($sql);
	$arr = $xoopsDB->fetchArray($result);
	
	return $arr;
    }

    function get_row_with_rel($id)
    {
	global $xoopsDB;

	$sql = $this->rel_sql . ' AND ' . $this->table_name . '_m.' . $this->primary_key_name . " = " . intval($id);
	if (isset($this->yaml) && isset($this->yaml['validable']) && $this->yaml['validable'] && (!WaffleGrant::is_admin())) {
	    $sql .= ' AND ' . $this->yaml['validable_column'] . ' = 1 ';
	}
	$sql .= ' LIMIT 1';

	$result = $xoopsDB->query($sql);
	$arr = $xoopsDB->fetchArray($result);
	
	return $arr;
    }

    function get_all($where = '', $order = '', $limit = '', $offset = '')
    {
	global $xoopsDB;

	if ($this->rel_exists) {
	    return $this->get_all_with_rel($where, $order, $limit, $offset);
	}
	
	$sql = 'SELECT * ';
	$sql .= ' FROM ' . $this->table_name;

	if (isset($this->yaml) && isset($this->yaml['validable']) && $this->yaml['validable']) {
	    if (!WaffleGrant::is_admin()) {
		if ($where != '') {
		    $sql .= ' WHERE ' . $this->yaml['validable_column'] . ' = 1 AND ' . $where;
		} else {
		    $sql .= ' WHERE ' . $this->yaml['validable_column'] . ' = 1 ';
		}
	    } elseif ($where != '') {
		$sql .= ' WHERE ' . $where;
	    }
	} elseif ($where != '') {
	    $sql .= ' WHERE ' . $where;
	}
	
	if (is_array($order)) {
	    $sql .= ' ORDER BY ';
	    $a = array();
	    foreach ($order as $i) {
		if (preg_match('/^(.+) desc$/i', $i, $r)) {
		    $a[] = '`' . $r[1] . '` DESC';
		} else {
		    $a[] = '`' . $i . '`';
		}
	    }
	    $sql .= join(',', $a);
	} else if ($order != '') {
	    if (preg_match('/\`/', $order)) {
		$sql .= ' ORDER BY ' . $order;
	    } else {
		$sql .= ' ORDER BY `' . $order . '`';
	    }
	}
	if (0 < $limit) {
	    if (isset($offset) && $offset != '') {
		$sql .= ' LIMIT ' . intval($offset) . ',' . intval($limit);
	    } else {
		$sql .= ' LIMIT ' . intval($limit);
	    }
	} else {
	    $sql .= ' LIMIT ' . intval($this->all_select_limit);
	}

	$result = $xoopsDB->query($sql);
	$list = array();

	while ($arr = $xoopsDB->fetchArray($result)) {
	    $list[] = $arr;
	}
	
	return $list;
    }

    function get_all_with_rel($where = '', $order = '', $limit = '', $offset = '')
    {
	global $xoopsDB;

	$sql = $this->rel_sql;
	
	if ($this->yaml['validable']) {
	    if (!WaffleGrant::is_admin()) {
		if ($where != '') {
		    $sql .= ' AND ' . $this->yaml['validable_column'] . ' = 1 AND ' . $where;
		} else {
		    $sql .= ' AND ' . $this->yaml['validable_column'] . ' = 1 ';
		}
	    } elseif ($where != '') {
		$sql .= ' AND ' . $where;
	    }
	} elseif ($where != '') {
	    $sql .= ' AND ( ' . $where . ')';
	}
	
	if (is_array($order)) {
	    $sql .= ' ORDER BY ';
	    $a = array();
	    foreach ($order as $i) {
		if (preg_match('/^(.+) desc$/i', $i, $r)) {
		    $a[] = '`' . $r[1] . '` DESC';
		} else {
		    $a[] = '`' . $i . '`';
		}
	    }
	    $sql .= join(',', $a);
	} else if ($order != '') {
	    if (preg_match('/\`/', $order)) {
		$sql .= ' ORDER BY ' . $order;
	    } else {
		$sql .= ' ORDER BY `' . $order . '`';
	    }
	}
	if (0 < $limit) {
	    if (isset($offset) && $offset != '') {
		$sql .= ' LIMIT ' . intval($offset) . ',' . intval($limit);
	    } else {
		$sql .= ' LIMIT ' . intval($limit);
	    }
	} else {
	    $sql .= ' LIMIT ' . intval($this->all_select_limit);
	}

	$result = $xoopsDB->query($sql);
	$list = array();
	
	while ($arr = $xoopsDB->fetchArray($result)) {
	    $list[] = $arr;
	}
	
	return $list;
    }

    /**
     * 行数を返す
     */
    function get_count($where = '')
    {
	global $xoopsDB;

	$sql = 'SELECT count(*) ';
	$sql .= ' FROM ' . $this->table_name;
	if ($where != '') {
	    $sql .= ' WHERE ' . $where;
	}
	
	$result = $xoopsDB->query($sql);
	$arr = $xoopsDB->fetchRow($result);
	
	return $arr[0];
    }

    /**
     * リスト表示用にSELECTして返す。
     */
    function get_for_list($offset='', $order='', $order_r='', $limit='', $where='') {
	if (isset($order) && $order != '') {
	    if (intval($order) <= count($this->column_map) - 1) {
		$order = '`' . $this->yaml['columns'][$order]['name'] . '`';

		// 逆ソートならばDESC指定
		if ($order != '' && $order_r) {
		    $order .= ' DESC ';
		}
	    } else {
		$order = '';
	    }
	} else {
	    $order = $this->primary_key_name;
	}
	
	return $this->get_all($where, $order, $limit, $offset);
    }

    /**
     * 
     */
    function insert($array)
    {
	global $xoopsDB;
	global $xoopsUser;
	global $no2type;

	if (count($array) == 0) {
	    return;
	}

	$array[$this->create_datetime_column_name] = time();

	// insert user id
	if (is_object($xoopsUser)) {
	    $user_id = $xoopsUser->getVar('uid');
	} else {
	    $user_id = 0;
	}
	
	$array[$this->create_user_id_column_name] = $user_id;
	
	$columns = array();
	$vals = array();
	
	foreach ($this->column_map as $key => $val) {
	    if ($val['type'] != $no2type[WAFFLE_COLUMN_RELATION]) {
		if ($key == $this->primary_key_name) {
		    // プライマリキーはスキップ
		    continue;
		}
	    
		if ((! isset($this->column_map[$key]))) {
		    // 存在しないカラム名はスキップする
		    continue;
		}
	    }

	    // カラム名
	    if (isset($val['rel_table'])) {
		$columns[] = $val['org_name'];
	    } else {
		$columns[] = $key;
	    }

	    // 値
	    if (isset($this->yaml['validable_column']) && $val['name'] == $this->yaml['validable_column']) {
		if ($this->yaml['validable']) {
		    if (WaffleGrant::is_admin()) {
			$vals[] = 1;
		    } else {
			$vals[] = 0;
		    }
		} else {
		    $vals[] = 1;
		}
	    } elseif ($this->column_map[$key]['type'] == 'string') {
		if (isset($array[$key])) {
		    $vals[] = "'" . mysql_real_escape_string($array[$key]) . "'";
		} else {
		    $vals[] = 'null';
		}
	    } else if ($this->column_map[$key]['type'] == 'integer') {
		if (isset($array[$key])) {
		    $vals[] = intval($array[$key]);
		} else {
		    $vals[] = 'null';
		}
	    } else if ($this->column_map[$key]['type'] == 'radio' ||
		       $this->column_map[$key]['type'] == 'select') {
		$vals[] = intval($array[$key]);
	    } else if ($this->column_map[$key]['type'] == 'checkbox') {
		if (isset($array[$key]) && $array[$key]) {
		    $vals[] = 1;
		} else {
		    $vals[] = 0;
		}
	    } else if ($val['type'] == 'relation') {
		if (isset($array[$val['org_name']])) {
		    $vals[] = intval($array[$val['org_name']]);
		} else {
		    $vals[] = 'null';
		}
	    } else {
		if (isset($array[$key]) && (!is_null($array[$key]))) {
		    $vals[] = "'" . mysql_real_escape_string($array[$key]) . "'";
		} else {
		    $vals[] = 'null';
		}
	    }
	}
	
	$sql = 'INSERT INTO ' . $this->table_name;
	$sql .= ' (';
	$sql .= "`" . implode("`,`", $columns) . "`";
	$sql .= ') VALUES (';
	$sql .= implode(',', $vals);
	$sql .= ')';

	$xoopsDB->queryF($sql);
    }

    function update($array)
    {
	$this->update_one($array);
    }
	
    function update_one($array)
    {
	global $xoopsDB;
	global $no2type;
	
	if (count($array) == 0) {
	    return;
	}
	
	if (isset($array[$this->primary_key_name]) == false) {
	    return;
	}
	
	$array[$this->update_datetime_column_name] = time();

	// update user id
	global $xoopsUser;
	
	if (is_object($xoopsUser)) {
	    $user_id = $xoopsUser->getVar('uid');
	} else {
	    $user_id = 0;
	}
	
	$array[$this->update_user_id_column_name] = $user_id;
	
	$sql = 'UPDATE ' . $this->table_name;
	$sql .= ' SET ';
	$list = array();
	
	foreach ($this->column_map as $key => $val) {
	    if ($val['type'] != $no2type[WAFFLE_COLUMN_CHECKBOX] &&
		$val['type'] != $no2type[WAFFLE_COLUMN_RELATION] &&
		isset($array[$key]) == false) {
		continue;
	    }
	    
	    if ($key == $this->primary_key_name) {
		// プライマリキーはスキップ
		continue;
	    }
	    
	    if ($key == $this->create_user_id_column_name) {
		continue;
	    }
	    
	    if ($key == $this->create_datetime_column_name) {
		continue;
	    }

	    if ($this->column_map[$key]['type'] == $no2type[WAFFLE_COLUMN_STRING]) {
		if (isset($array[$key])) {
		    $list[] = '`' . $key . '`' . " = '" . mysql_real_escape_string($array[$key]) . "' ";
		}
	    } else if ($this->column_map[$key]['type'] == $no2type[WAFFLE_COLUMN_INTEGER]) {
		if (isset($array[$key])) {
		    $list[] = '`' . $key . '`' . " = " . intval($array[$key]) . ' ';
		}
	    } else if ($this->column_map[$key]['type'] == $no2type[WAFFLE_COLUMN_CHECKBOX]) {
		if (isset($array[$key]) && $array[$key]) {
		    $list[] = "`" . $key . "` = " . 1;
		} else {
		    $list[] = "`" . $key . "` = " . 0;
		}
	    } else if ($this->column_map[$key]['type'] == $no2type[WAFFLE_COLUMN_RELATION]) {
		if (isset($array[$val['org_name']])) {
		    $list[] = '`' . $val['org_name'] . '`' . " = " . intval($array[$val['org_name']]) . ' ';
		}
	    } else {
		if (is_null($array[$key])) {
		    $list[] = 'null';
		} else {
		    $list[] = '`' . $key . '`' . " = '" . mysql_real_escape_string($array[$key]) . "' ";
		}
	    }
	}

	$sql .= implode(',', $list);
	$sql .= ' WHERE ' . $this->primary_key_name .  ' = ' . $array[$this->primary_key_name];
	$sql .= ' LIMIT 1';

	$xoopsDB->queryF($sql);
    }

    /**
     * 1件削除する
     */
    function delete_one($id)
    {
	global $xoopsDB;

	$sql = 'DELETE ';
	$sql .= ' FROM ' . $this->table_name;
	$sql .= ' WHERE ' . $this->primary_key_name . ' = ' . intval($id);
	$sql .= ' LIMIT 1';
	
	$xoopsDB->queryF($sql);
    }
    
    function delete($where)
    {
	global $xoopsDB;

	$sql = 'DELETE ';
	$sql .= ' FROM ' . $this->table_name;
	$sql .= ' WHERE ' . $where;
	$sql .= ' LIMIT 1';
	
	$xoopsDB->queryF($sql);
	
	return $xoopsDB->getAffectedRows();
    }
    
    /**
     * POSTされたデータが適切か調べる。
     * $_POST を参照する。
     */
    function validate() {
	global $no2type;
	global $xoopsDB;
	
	$post_data = array();
	$errmsg = array();
	
	$post_data = array();
	$errmsg = array();
	$errmsg_key = array();
	
	$validate = new ValidateInfo();

	foreach ($this->column_map as $key => $val) {
	    $post_key = isset($_POST[$key]) ? $_POST[$key] : '';
	    $val_not_null = isset($val['not_null']) ? $val['not_null'] : 0;
	    $val_uniq = isset($val['uniq']) ? $val['uniq'] : 0;
	    if ($val_not_null && $post_key == '' &&
		$key != $this->primary_key_name &&
		$key != $this->create_datetime_column_name &&
		$key != $this->update_datetime_column_name &&
		$key != $this->create_user_id_column_name &&
		$key != $this->update_user_id_column_name &&
		$val['type'] != $no2type[WAFFLE_COLUMN_RELATION] &&
		$val['type'] != $no2type[WAFFLE_COLUMN_CHECKBOX]
		) {

		$validate->set_error($key, $val['desc'] . 'は必須項目です。');
	    }
	    
	    if ($val_uniq) {
		$where = $key . " = '" . addslashes($post_key). "'";
		if (isset($_POST['id'])) {
		    $where .= ' AND ' . $this->primary_key_name . ' <> ' . intval($_POST['id']);
		}
		if ($this->get_one($key, $where)) {
		    $validate->set_error($key, $val['desc'] . 'は値が重複しています。');
		}
	    }
	    
	    switch ($val['type']) {
	     case 'integer':;
		if ($post_key == '') {
		    // integer で空文字だった場合はスキップ
		    continue 1;
		} else {
		    $s = trim($_POST[$key]);
		    if (isset($_POST[$key]) && (!preg_match("/^\-?\d*$/", $s))) {
			$validate->set_error($key, $val['desc'] . 'は数値を入力してください');
		    }
		    $post_data[$key] = intval($_POST[$key]);
		    
		}
		break;
	     case 'string':;
	     case 'email':;
	     case 'url':;
	     case 'image_url':;
	     case 'password_plain':;
		if (isset($val['maxlength'])) {
		    if ($val['maxlength'] < strlen($_POST[$key])) {
			$validate->set_error($key, $val['desc'] . 'は' . $val['maxlength'] . '文字までです');
		    }
		}
		$post_data[$key] = $_POST[$key];
		break;
	     case 'textarea';
	     case 'htmltext';
	     case 'php_code';
		if (isset($val['maxlength'])) {
		    if ($val['maxlength'] < strlen($_POST[$key])) {
			$validate->set_error($key, $val['desc'] . 'は' . $val['maxlength'] . '文字までです');
		    }
		}
		$post_data[$key] = $_POST[$key];
		break;
	     case 'radio';
	     case 'select';
		if (isset($_POST[$key])) {
		    if (intval($_POST[$key]) <= 0 || count($val['enum']) < intval($_POST[$key])) {
			// 選択肢にない値
			$validate->set_error($key, $val['desc'] . 'は選択肢にない値が設定されています:"' . $_POST[$key] .'" (' . $val['type'] . ')');
		    }
		}

		$post_data[$key] = intval($_POST[$key]);
		break;
	     case 'checkbox';
		$post_data[$key] = isset($_POST[$key]) ? intval($_POST[$key]) : 0;
		break;
	     case 'image';
		if ($_FILES[$key]['name']) {
		    $config_handler =& xoops_gethandler('config');
		    $xoopsConfigUser =& $config_handler->getConfigsByCat(XOOPS_CONF_USER);
		
		    $maxx = WaffleMAP::get_config(WAFFLE_IMAGE_MAX_X);
		    $maxy = WaffleMAP::get_config(WAFFLE_IMAGE_MAX_Y);
		    $maxsize = WaffleMAP::get_config(WAFFLE_IMAGE_MAX_FILESIZE);

		    if ($maxx == '') {
			$maxx = WAFFLE_IMAGE_DEFAULT_MAX_X;
		    }
		    if ($maxy == '') {
			$maxy = WAFFLE_IMAGE_DEFAULT_MAX_Y;
		    }
		    if ($maxsize == '') {
			$maxsize = WAFFLE_IMAGE_DEFAULT_MAX_FILESIZE;
		    }
		    
		    $updir = XOOPS_ROOT_PATH . '/uploads/' . $this->get_mydirname() . '_image/';
		    mkdir($updir);
		    
		    include_once XOOPS_ROOT_PATH.'/class/uploader.php';
		    $uploader = new XoopsMediaUploader($updir, array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'), $maxsize, $maxx, $maxy);
		    $uploader->setAllowedExtensions(array('gif', 'jpeg', 'jpg', 'png'));
		    
		    if ($uploader->fetchMedia($key)) {
			$uploader->setPrefix($this->get_mydirname() . '_image_');
			if ($uploader->upload()) {
			    
			    $f = $updir . $uploader->getSavedFileName();
			    if (preg_match('/\.png$/', $uploader->getSavedFileName())) {
				$im = @imagecreatefrompng($f);
			    } else if (preg_match('/\.gif$/', $uploader->getSavedFileName())) {
				$im = @imagecreatefromgif($f);
			    } else if (preg_match('/\.jpg$/', $uploader->getSavedFileName()) ||
				       preg_match('/\.jpeg$/', $uploader->getSavedFileName())) {
				$im = @imagecreatefromjpeg($f);
			    }

			    $x = imagesx($im); 
			    $y = imagesy($im);
			    $size = filesize($f);
			    
			    if ($maxx < $x) {
				$validate->set_error($key, $val['desc'] . ':エラーが発生しました(3)');
			    } else if ($maxy < $y) {
				$validate->set_error($key, $val['desc'] . ':エラーが発生しました(4)');
			    } else if ($maxsize < $size) {
				$validate->set_error($key, $val['desc'] . ':エラーが発生しました(5)');
			    } else {
				$ar = array('path' => $uploader->getSavedFileName(),
					    'width' => $x,
					    'height' => $y,
					    'file_size' => $size
					    );
			
				$y = $this->get_mydirname() . '_image.yml';
				$image = WaffleMAP::new_with_cache($y);
				
				$image->insert($ar);
				
				$post_data[$key] = $xoopsDB->getInsertId();
			    }
			} else {
			    $validate->set_error($key, $val['desc'] . ':エラーが発生しました(1) ' . $uploader->getErrors());
			}
		    } else {
			$validate->set_error($key, $val['desc'] . ':エラーが発生しました(2)');
		    }
		}
		break;
	     case 'file';
		if (isset($_FILES[$key]['name']) == false || $_FILES[$key]['name'] == '') {
		    // no upload file
		} else if ($_FILES[$key]['error'] == UPLOAD_ERR_INI_SIZE) {
		    $validate->set_error($key, $val['desc'] . ':エラーが発生しました。アップロードされたファイルのサイズがサーバの設定値を超えています。');
		} else if ($_FILES[$key]['error'] == UPLOAD_ERR_FORM_SIZE) {
		    $validate->set_error($key, $val['desc'] . ':エラーが発生しました。ファイルサイズが設定値を超えました。');
		} else if ($_FILES[$key]['error'] == UPLOAD_ERR_PARTIAL) {
		    $validate->set_error($key, $val['desc'] . ':エラーが発生しました。アップロードされたファイルは一部のみしかアップロードされていません。');
		} else if ($_FILES[$key]['error'] == UPLOAD_ERR_NO_FILE) {
		    $validate->set_error($key, $val['desc'] . ':エラーが発生しました。ファイルはアップロードされませんでした。');
		} else if ($_FILES[$key]['error'] == UPLOAD_ERR_NO_TMP_DIR) {
		    $validate->set_error($key, $val['desc'] . ':エラーが発生しました。テンポラリフォルダがありません。');
		} else if ($_FILES[$key]['error'] == UPLOAD_ERR_CANT_WRITE) {
		    $validate->set_error($key, $val['desc'] . ':エラーが発生しました。ディスクへの書き込みに失敗しました。');
		} else if ($_FILES[$key]['name']) {
		    $updir = XOOPS_ROOT_PATH . '/uploads/' . $this->get_mydirname() . '_file/';
		    mkdir($updir);
		    $c = WaffleMAP::get_config_inc(WAFFLE_FILE_INDEX_NAME);
		    $f = $this->get_mydirname() . '_file_' . $c;
		    if (move_uploaded_file($_FILES[$key]['tmp_name'], $updir . $f)) {
			
			$ar = array('name' => $_FILES[$key]['name'],
				    'real_name' => $f,
				    'file_size' => filesize($updir . $f));
			
			$y = $this->get_mydirname() . '_file.yml';
			$file = WaffleMAP::new_with_cache($y);
			$file->insert($ar);
				
			$post_data[$key] = $xoopsDB->getInsertId();
		    } else {
			$validate->set_error($key, $val['desc'] . ':エラーが発生しました(2)');
		    }
		} else {
		    $validate->set_error($key, $val['desc'] . ':エラーが発生しました(1)');
		}
	     case 'time';
		if (isset($_POST[$key]) && $_POST[$key]) {
		    if (preg_match('/-/', $_POST[$key])) {
			$sp = '-';
		    } else {
			$sp = ':';
		    }

		    $ar = split($sp, $_POST[$key]);
		    
		    if (! preg_match('/^\d\d:\d\d:\d\d$/', $_POST[$key])) {
			$validate->set_error($key, $val['desc'] . 'の入力が不正です');
		    } else if (waffle_validate_time($ar[0], $ar[1], $ar[2]) == false) {
			$validate->set_error($key, $val['desc'] . 'の入力が不正です');
		    }

		    $post_data[$key] = $_POST[$key];
		} else {
		    $post_date[$key] = null;
		}

		break;
	     case 'date';
		if (isset($_POST[$key]) && $_POST[$key]) {
		    $ar = array();
		    if (preg_match('/-/', $_POST[$key])) {
			$sp = '-';
			$ar = split($sp, $_POST[$key]);
		    } else if (preg_match('/\//', $_POST[$key])) {
			$sp = '/';
			$ar = split($sp, $_POST[$key]);
		    } else if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/', $_POST[$key], $r)) {
			$ar[0] = $r[1];
			$ar[1] = $r[2];
			$ar[2] = $r[3];
		    }
		    
		    $ar[0] = isset($ar[0]) ? $ar[0] : 0;
		    $ar[1] = isset($ar[1]) ? $ar[1] : 0;
		    $ar[2] = isset($ar[2]) ? $ar[2] : 0;

		    if (waffle_validate_date($ar[0], $ar[1], $ar[2]) == false) {
			$validate->set_error($key, $val['desc'] . 'の入力が不正です');
		    }

		    $post_data[$key] = $_POST[$key];
		} else {
		    $post_date[$key] = null;
		}

		break;
	     case 'datetime';
		if (isset($_POST[$key]) && $_POST[$key]) {
		    if (preg_match('/-/', $_POST[$key])) {
			$sp = '-';
		    } else if (preg_match('/\//', $_POST[$key])) {
			$sp = '/';
		    }

		    if (! preg_match('/^\d\d\d\d[-\/]\d\d[-\/]\d\d \d\d:\d\d:\d\d$/', $_POST[$key])) {
			$validate->set_error($key, $val['desc'] . 'の入力が不正です');
		    } else {
			$ar = split(' ', $_POST[$key]);
			$ar2 = split($sp, $ar[0]);
			$ar3 = split($sp, $ar[1]);
			
			$ar3[0] = isset($ar3[0]) ? $ar3[0] : 0;
			$ar3[1] = isset($ar3[1]) ? $ar3[1] : 0;
			$ar3[2] = isset($ar3[2]) ? $ar3[2] : 0;

			if (waffle_validate_date($ar2[0], $ar2[1], $ar2[2]) == false) {
			    $validate->set_error($key, $val['desc'] . 'の入力が不正です');
			} else if (waffle_validate_time($ar3[0], $ar3[1], $ar3[2]) == false) {
			    $validate->set_error($key, $val['desc'] . 'の入力が不正です');
			}
		    }

		    $post_data[$key] = $_POST[$key];
		} else {
		    $post_date[$key] = null;
		}

		break;
	     case 'relation':;
		if ($_POST[$val['org_name']] == '') {
		    // relation で空文字だった場合はスキップ
		    continue 1;
		} else {
		    $s = trim($_POST[$val['org_name']]);
		    if (isset($_POST[$val['org_name']]) && (!preg_match("/^\d*$/", $s))) {
			$validate->set_error($val['org_name'], $val['desc'] . 'は値を選択してください');
		    }
		    $post_data[$val['org_name']] = $_POST[$val['org_name']];
		}
		break;
	     default:
		break;
	    }
	}

	$ret['post_data'] = $post_data;
	
	$validate->set_post($post_data);
	
	return $validate;
    }

    /**
     * set config
     * @param config name
     * @param config value
     */
    function set_config($name, $value)
    {
	global $xoopsDB;
        global $xoopsUser;
	
	$mydirname = WaffleMAP::get_mydirname();
	
	if (is_object($xoopsUser)) {
	    $user_id =  $xoopsUser->getVar('uid');
	} else {
	    $user_id = 0;
	}

	$table = $xoopsDB->prefix($mydirname . '_config');
	
	if (is_array($value) || is_object($value)) {
	    $flag_serialize = 1;
	} else {
	    $flag_serialize = 0;
	}

	$sql = 'UPDATE ' . $table . ' SET ';
	if ($flag_serialize) {
	    $sql .= " value = '" . addslashes(serialize($value)) . "', ";
	    $sql .= ' flag_serialize = 1, ';
	} else {
	    $sql .= " value = '" . addslashes($value) . "', ";
	    $sql .= ' flag_serialize = 0, ';
	}
	$sql .= ' mod_time = ' . time() . ', ';
	$sql .= ' mod_user_id = ' . $user_id;
	$sql .= " WHERE name = '" . addslashes($name) . "'";

	$xoopsDB->queryF($sql);

	if ($xoopsDB->getAffectedRows() == 0) {
            // no update
	    $sql = 'INSERT INTO ' . $table . ' ( ';
	    $sql .= ' name, value, flag_serialize, reg_time, reg_user_id ) VALUES ( ';
	    $sql .= "'" . addslashes($name) . "', ";
	    if ($flag_serialize) {
		$sql .= "'" . addslashes(serialize($value)) . "', ";
		$sql .= "1, ";
	    } else {
		$sql .= "'" . addslashes($value) . "', ";
		$sql .= "0, ";
	    }
	    $sql .= time() . ", ";
	    $sql .= $user_id . " ) ";

	    $xoopsDB->queryF($sql);
        }
    }

    /**
     * get config 
     * @param config name
     * @return config value
     */
    function get_config($name)
    {
	global $xoopsDB;

	$mydirname = WaffleMAP::get_mydirname();
	
	$sql = 'SELECT value, flag_serialize ';
	$sql .= ' FROM ' . $xoopsDB->prefix($mydirname . '_config');
	$sql .= " WHERE name = '" . addslashes($name) . "'";
	$sql .= ' LIMIT 1';

	$result = $xoopsDB->query($sql);
	$arr = $xoopsDB->fetchRow($result);

	if ($arr[1]) {
	    return unserialize($arr[0]);
	} else {
	    return $arr[0];
	}
    }

    /**
     * get config update time
     * @param config name
     * @return config update time
     */
    function get_config_time($name)
    {
	global $xoopsDB;

	$mydirname = WaffleMAP::get_mydirname();

	$sql = 'SELECT reg_time, mod_time ';
	$sql .= ' FROM ' . $xoopsDB->prefix($mydirname . '_config');
	$sql .= " WHERE name = '" . addslashes($name) . "'";
	$sql .= ' LIMIT 1';

	$result = $xoopsDB->query($sql);
	$arr = $xoopsDB->fetchRow($result);

	if ($arr[0] < $arr[1]) {
	    return $arr[1];
	} else {
	    return $arr[0];
	}
    }
    
    /**
     * auto increment value
     * @param config name
     * @param config value
     */
    function get_config_inc($name, $value=1)
    {
	global $xoopsDB;
        global $xoopsUser;

	$mydirname = WaffleMAP::get_mydirname();
	
	if (is_object($xoopsUser)) {
	    $user_id =  $xoopsUser->getVar('uid');
	} else {
	    $user_id = 0;
	}
	
	$table = $xoopsDB->prefix($mydirname . '_config');
	
	$sql = 'UPDATE ' . $table . ' SET ';
	$sql .= " value = value + 1, ";
	$sql .= ' flag_serialize = 0, ';
	$sql .= ' mod_time = ' . time() . ', ';
	$sql .= ' mod_user_id = ' . $user_id;
	$sql .= " WHERE name = '" . addslashes($name) . "'";

	$xoopsDB->queryF($sql);

	if ($xoopsDB->getAffectedRows() == 0) {
            // no update
	    $sql = 'INSERT INTO ' . $table . ' ( ';
	    $sql .= ' name, value, flag_serialize, reg_time, reg_user_id ) VALUES ( ';
	    $sql .= "'" . addslashes($name) . "', ";
	    $sql .= intval($value) . ", ";
	    $sql .= "0, ";
	    $sql .= time() . ", ";
	    $sql .= $user_id . " ) ";

	    $xoopsDB->queryF($sql);

	    return intval($value);
        } else {
	    return WaffleMAP::get_config($name);
	}
    }
    
    function truncate($str, $size)
    {
	if (strlen($str) <= $size) {
	    return $str;
	}
	
	return substr($str, 0, $size) . '...';
    }
} 

?>
