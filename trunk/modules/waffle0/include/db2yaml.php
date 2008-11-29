<?php

if (defined('__DB2YAML_PHP__')) {
    return;
}

define('__DB2YAML_PHP__', '1');
require_once('WaffleMAP.php');

function waffle_db2yaml($table_id)
{
    global $no2type;
    
    $table = WaffleMAP::new_with_cache($GLOBALS['waffle_mydirname'] . '_table.yml');
    $t = $table->get_row($table_id);
    $column = WaffleMAP::new_with_cache($GLOBALS['waffle_mydirname'] . '_column.yml');
    $option = WaffleMAP::new_with_cache($GLOBALS['waffle_mydirname'] . '_option.yml');

    $c = $column->get_all('table_id = ' . intval($table_id), array('order', 'id'));

    $yaml = array();

    $yaml['name'] = $GLOBALS['waffle_mydirname'] . '_data' . intval($table_id);
    $yaml['desc'] = $t['name'];
    $yaml['valid'] = $t['valid'];
    $yaml['validable'] = $t['validable'];
    $yaml['validable_column'] = 't' . intval($table_id) . '_valid';
    $yaml['create_datetime_column_name'] = 't' . intval($table_id) . '_reg_time';
    $yaml['update_datetime_column_name'] = 't' . intval($table_id) . '_mod_time';
    $yaml['create_user_id_column_name'] = 't' . intval($table_id) . '_reg_user_id';
    $yaml['update_user_id_column_name'] = 't' . intval($table_id) . '_mod_user_id';
    
    foreach ($c as $key => $val) {
	$a = array();
	$a['name'] = $val['name'];
	$a['desc'] = $val['desc'];
	$a['type'] = $no2type[$val['type']];
	if ($val['valid'] == 1) {
	    $a['valid'] = 1;
	}
	if ($val['uniq']) {
	    $a['uniq'] = $val['uniq'];
	}
	if ($val['not_null']) {
	    $a['not_null'] = $val['not_null'];
	}
	if ($val['default']) {
	    $a['default'] = $val['default'];
	}
	$a['order'] = intval($val['order']);
	if ($val['primary_key'] || $val['name'] == 'id') {
	    $a['primary_key'] = 1;
	}
	if ($val['fixed']) {
	    $a['fixed'] = $val['fixed'];
	}
	if ($val['serial']) {
	    $a['serial'] = $val['serial'];
	}
	if ($val['detailview'] == 1) {
	    $a['detailview'] = 1;
	}
	if ($val['insertview'] == 1) {
	    $a['insertview'] = 1;
	}
	if ($val['updateview'] == 1) { 
	    $a['updateview'] = 1;
	}
	if ($val['listview'] == 1) {
	    $a['listview'] = 1;
	}
	if ($val['updatable'] == 1) {
	    $a['updatable'] = 1;
	}
	if (isset($val['validable']) && $val['validable'] == 1) {
	    $a['validable'] = 1;
	}
	if ($val['maxlength']) {
	    $a['maxlength'] = $val['maxlength'];
	}
	if ($val['size']) {
	    $a['size'] = $val['size'];
	}
	
	if ($val['type'] == WAFFLE_COLUMN_RADIO ||
	    $val['type'] == WAFFLE_COLUMN_SELECT) {
	    $o = $option->get_all('column_id = ' . intval($val['id']), 'id');
	    
	    $oa = array();
	    foreach ($o as $kk => $vv) {
		$oa[] = $vv['name'] . "\n";
	    }
	    
	    $a['enum'] = $oa;
	}
	if ($val['type'] == WAFFLE_COLUMN_TEXTAREA ||
	    $val['type'] == WAFFLE_COLUMN_HTMLTEXT ||
	    $val['type'] == WAFFLE_COLUMN_PHP_CODE) {
	    if ($val['rows']) {
		$a['rows'] = $val['rows'];
	    }
	    if ($val['cols']) {
		$a['cols'] = $val['cols'];
	    }
	}
	
	if ($val['type'] == WAFFLE_COLUMN_RELATION) {
	    $a['rel_table'] = $val['rel_table'];
	    $a['rel_column'] = $val['rel_column'];
	    $a['rel_v_column'] = $val['rel_v_column'];
	    $a['rel_where'] = $val['rel_where'];
	    $a['rel_type'] = $val['rel_type'];
	    $yaml['rel_exists'] = 1;
	}
	
	$yaml['columns'][] = $a;
    }
    
    return Spyc::YAMLDump($yaml);
}

?>
