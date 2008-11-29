<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) {
    exit();
}
$waffle_mydirname = $waffle_mydirname_base = basename( dirname( dirname( __FILE__ ) ) );
if( ! preg_match( '/^(\D+)(\d*)$/' , $waffle_mydirname , $regs ) ) {
    echo ( "invalid dirname: " . htmlspecialchars( $waffle_mydirname ) );
}

$regs[2] = isset($regs[2]) ? $regs[2] : '';

$waffle_mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

include_once( XOOPS_ROOT_PATH . "/modules/$waffle_mydirname_base/include/WaffleMAP.php" ) ;
include_once( XOOPS_ROOT_PATH . "/modules/$waffle_mydirname/include/WaffleGrant.php" ) ;


eval( '

function ' . $waffle_mydirname . '_search( $keywords , $andor , $limit , $offset , $userid )
{
	return waffle_search_base( "'.$waffle_mydirname.'" , "'.$waffle_mydirnumber.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}

' ) ;

if( ! function_exists( 'waffle_search_base' ) ) {

function waffle_search_base( $mydirname , $mydirnumber , $keywords , $andor , $limit , $offset , $userid )
{

    $GLOBALS['mydirname_search'] = $mydirname;
    $y = $mydirname . '_table.yml';
    $table = WaffleMAP::new_with_cache($y);
    
    $y = $mydirname . '_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    
    $t = $table->get_all();
    
    $ret = '';
    
    foreach ($t as $k => $v) {
	if ($v['valid'] == 0) {
	    continue;
	}
	if (WaffleGrant::is_ok($mydirname . '_data' . intval($v['id']), WAFFLE_GRANT_READ) == false) {
	    continue;
	}
	
        $c = $column->get_all('table_id = ' . intval($v['id']));
		     
	$y = $mydirname . '_data' . intval($v['id']) . '.yml';
	$ytime = WaffleMAP::get_config_time($y);
	if ($ytime == 0) {
	    // no setting date
	    return array();
	}
	$map = WaffleMAP::new_with_cache($y);
	
	$s_column = array();

	foreach ($c as $k2 => $v2) {
	    if ($v2['search']) {
		$s_column[] = $v2['name'];
	    }
	}

	if (count($s_column)) {
	    $w1 = array();

	    foreach ($s_column as $k2 => $v2) {
		$w2 = array();
		
		foreach ($keywords as $k3 => $v3) {
		    $w2[] = ' ' . $v2 . " like '%" . $v3 . "%' ";
		}
							       
		$w1[] = ' ( ' . implode($andor, $w2) . ' ) ';
	    }

            $where = implode(' OR ', $w1);

            $all = $map->get_all($where);

            foreach ($all as $k2 => $v2) {
		$arr = array();
		$arr['image'] = "";
		$arr['link'] = "index.php?t_m=ddcommon_view&id=" . $v2[$map->primary_key_name] . "&t_dd=" . $mydirname . "_data" . intval($v['id']);

                if ($v2['t' . intval($v['id']) . '_c1']) {
		    $arr['title'] = $v2['t' . intval($v['id']) . '_c1'];
		} else {
		    $arr['title'] = 'no title';
		}
                $arr['time'] = $v2[$map->create_datetime_column_name];

                $arr['uid'] = $v2[$map->create_user_id_column_name];
                $ret[] = $arr;
	    }
	}
    }

    return $ret; 
}

}


?>
