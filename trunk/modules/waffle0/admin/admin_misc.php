<?php

function waffle_admin_misc_yaml_remake()
{
    $num_of_table = WaffleMAP::get_config(WAFFLE_TABLE_NO, WAFFLE_TABLE_DEFAULT_NO);
    if ($num_of_table == 0) {
	WaffleMAP::set_config(WAFFLE_TABLE_NO, WAFFLE_TABLE_DEFAULT_NO);
	$num_of_table = WAFFLE_TABLE_DEFAULT_NO;
    }
    
    for ($i=1; $i<=$num_of_table; $i++) {
	$yaml_data = waffle_db2yaml($i);
	$t_table = $GLOBALS['waffle_mydirname'].'_data' . $i;
	WaffleMAP::set_config($t_table . '.yml', $yaml_data);
    }
}

?>
