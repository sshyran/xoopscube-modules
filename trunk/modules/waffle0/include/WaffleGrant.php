<?php

if (defined('__WAFFLE_GRANT_PHP__')) {
    return;
}

define('__WAFFLE_GRANT_PHP__', '1');

class WaffleGrant
{
    function dd2tableno($dd)
    {
	if (!preg_match('/_data(.+)$/', $dd, $r)) {
	    return -1;
	}
	
	return $r[1];
    }
    
    function get_mydirname()
    {
	if (isset($GLOBALS['mydirname_search']) && $GLOBALS['mydirname_search'] != '') {
	    return $GLOBALS['mydirname_search'];
	}
	
	return $GLOBALS['waffle_mydirname'];
    }
    
    function get_grant_set($data_no) {
	$data_no = WaffleGrant::dd2tableno($data_no);
	global $xoopsDB;
	global $xoopsUser;
	
	$grant = array();
	
	if (is_object($xoopsUser)) {
	    $user_id = $xoopsUser->getVar('uid');
	} else {
	    $user_id = 0;
	}
	
	$sql = "SELECT grant_no FROM " . $xoopsDB->prefix(WaffleGrant::get_mydirname() . '_grant_user');
	$sql .= " WHERE ";
	$sql .= "table_id = " . intval($data_no) . " AND ";
	$sql .= "user_id = " . intval($user_id); 

        $result = $xoopsDB->query($sql);
	$list = array();
	        
	while ($arr = $xoopsDB->fetchArray($result)) {
	    $grant[$arr['grant_no']] = 1;
	}
	
	if (is_object($xoopsUser)) {
	    $a = $xoopsUser->getGroups();
	} else {
	    $a = array(0 => 3); // guest group id
	}
	
	$sql = "SELECT group_id, grant_no FROM " . $xoopsDB->prefix(WaffleGrant::get_mydirname() . '_grant_group');
	$sql .= " WHERE ";
	$sql .= "table_id = " . intval($data_no);

        $result = $xoopsDB->query($sql);
	$list = array();
	        
	while ($arr = $xoopsDB->fetchArray($result)) {
	    foreach ($a as $key => $val) {
		if ($arr['group_id'] == $val) {
		    $grant[$arr['grant_no']] = 1;
		}
	    }
	}
	
	return $grant;
    }
    
    function read_ok($data_no)
    {
	return WaffleGrant::is_ok($data_no, WAFFLE_GRANT_READ);
    }
    
    function add_ok($data_no)
    {
	return WaffleGrant::is_ok($data_no, WAFFLE_GRANT_ADD);
    }
    
    function update_ok($data_no)
    {
	return WaffleGrant::is_ok($data_no, WAFFLE_GRANT_UPDATE);
    }
    
    function delete_ok($data_no)
    {
	return WaffleGrant::is_ok($data_no, WAFFLE_GRANT_DELETE);
    }
    
    function csv_output_ok($data_no)
    {
	return WaffleGrant::is_ok($data_no, WAFFLE_GRANT_CSV_OUTPUT);
    }
    
    function is_ok($data_no, $grant)
    {
	$data_no = WaffleGrant::dd2tableno($data_no);
	
	if ($data_no == -1) {
	    return true;
	}

	if (WaffleGrant::is_ok_user($data_no, $grant)) {
	    return true;
	}
	
	if (WaffleGrant::is_ok_group($data_no, $grant)) {
	    return true;
	} else {
	    return false;
	}
    }

    function is_ok_user($data_no, $grant)
    {
	global $xoopsDB;
	global $xoopsUser;

	$y = WaffleGrant::get_mydirname().'_grant_user.yml';
	$grant_user = WaffleMAP::new_with_cache($y);

	if (is_object($xoopsUser)) {
	    $user_id = $xoopsUser->getVar('uid');
	} else {
	    $user_id = 0;
	}
	
	$r = $grant_user->get_all('table_id = ' . intval($data_no) . ' AND ' .
				  'grant_no = ' . intval($grant) . ' AND ' .
				  'user_id = ' . intval($user_id));

	if (0 < count($r)) {
	    return 1;
	} else {
	    return 0;
	}
    }
    
    function is_ok_group($data_no, $grant)
    {
	global $xoopsUser;
	
	$y = WaffleGrant::get_mydirname().'_grant_group.yml';
	$grant_group = WaffleMAP::new_with_cache($y);

	$g = $grant_group->get_all('table_id = ' . intval($data_no) . 
				  ' AND grant_no = ' . intval($grant));
	
	if (is_object($xoopsUser)) {
	    $a = $xoopsUser->getGroups();
	} else {
	    $a = array(0 => 3); // guest group id
	}

	foreach ($g as $key => $val) {
	    foreach ($a as $k => $v) {
		if ($val['group_id'] == $v) {
		    // grant - ok
		    return '1';
		}
	    }
	}
	
	return '0';
    }
    
    function is_ok_list()
    {
	global $xoopsUser;

	$y = WaffleGrant::get_mydirname().'_grant_group.yml';
	$grant_group = WaffleMAP::new_with_cache($y);
	
	$y = WaffleGrant::get_mydirname().'_grant_user.yml';
	$grant_user = WaffleMAP::new_with_cache($y);

	$g = $grant_group->get_all();
	
	if (is_object($xoopsUser)) {
	    $user_id = $xoopsUser->getVar('uid');
	    $a = $xoopsUser->getGroups();
	} else {
	    $user_id = 0;
	    $a = array(0 => 3); // guest group id
	}

	$ok_list = array();
	
	$u = $grant_user->get_all('user_id = ' . intval($user_id));
	
	foreach ($g as $key => $val) {
	    foreach ($a as $k => $v) {
		if ($val['group_id'] == $v) {
		    $ok_list[$val['table_id']][$val['grant_no']] = 1;
		}
	    }
	}
	foreach ($u as $key => $val) {
	    $ok_list[$val['table_id']][$val['grant_no']] = 1;
	}
	
	return $ok_list;
    }
    
    function get_grant_group($data_no)
    {
	$y = WaffleGrant::get_mydirname().'_grant_group.yml';
	$grant_group = WaffleMAP::new_with_cache($y);
	
	$r = $grant_group->get_all('table_id = ' . intval($data_no));
	
	$rr = array();
	foreach ($r as $key => $val) {
	    $rr[$val['grant_no']][$val['group_id']] = 1;
	}

	return $rr;
    }

    function get_grant_user($data_no)
    {
	$y = WaffleGrant::get_mydirname().'_grant_user.yml';
	$grant_user = WaffleMAP::new_with_cache($y);
	
	$r = $grant_user->get_all('table_id = ' . intval($data_no));

	$rr = array();
	foreach ($r as $key => $val) {
	    $rr[$val['grant_no']][$val['user_id']] = 1;
	}

	return $rr;
    }

    function add_group($data_no, $grant, $group)
    {
	global $xoopsDB;
	
	$y = WaffleGrant::get_mydirname().'_grant_group.yml';
	$grant_group = WaffleMAP::new_with_cache($y);

	$g = $grant_group->get_all('table_id = ' . intval($data_no) . ' AND ' .
				  'group_id = ' . intval($group) . ' AND ' .
				  'grant_no = ' . intval($grant)
				  );

	if (count($g) == 0) {
            // no update
	    
	    $arr = array('table_id' => intval($data_no),
			 'group_id' => intval($group),
			 'grant_no' => intval($grant)
			 );
	    
	    $grant_group->insert($arr);
        }
    }

    function add_user($data_no, $grant, $user_id)
    {
	global $xoopsDB;
	
	$y = WaffleGrant::get_mydirname().'_grant_user.yml';
	$grant_user = WaffleMAP::new_with_cache($y);

	$g = $grant_user->get_all('table_id = ' . intval($data_no) . ' AND ' .
				  'user_id = ' . intval($user_id) . ' AND ' .
				  'grant_no = ' . intval($grant)
				  );
	
	if (count($g) == 0) {
            // no update
	    
	    $arr = array('table_id' => intval($data_no),
			 'user_id' => intval($user_id),
			 'grant_no' => intval($grant)
			 );
	    
	    $grant_user->insert($arr);
        }
    }

    function delete_group($data_no, $grant, $group)
    {
	global $xoopsDB;
	
	$y = WaffleGrant::get_mydirname().'_grant_group.yml';
	$grant_group = WaffleMAP::new_with_cache($y);

	$where = 'table_id = ' .intval($data_no) . ' AND ' .
	  ' group_id = '. intval($group) . ' AND ' .
	  ' grant_no = ' . intval($grant);

	$grant_group->delete($where);
    }

    function delete_user($data_no, $grant, $user_id)
    {
	global $xoopsDB;
	
	$y = WaffleGrant::get_mydirname().'_grant_user.yml';
	$grant_user = WaffleMAP::new_with_cache($y);

	$where = 'table_id = ' .intval($data_no) . ' AND ' .
	  'user_id = '. intval($user_id) . ' AND ' .
	  'grant_no = ' . intval($grant);

	$grant_user->delete($where);
    }
    
    /**
     * このモジュールの管理ユーザか調べる
     */
    function is_admin()
    {
        global $xoopsUser;
	global $module_handler;
	
	if (! is_object($xoopsUser)) {
	    return false;
	}

        $module =& $module_handler->getByDirname( WaffleGrant::get_mydirname() ) ;

        if( ! is_object( $module ) ) {
            die( "invalid module dirname:" . htmlspecialchars( $src_dirname ) )  ;
        }
        $mid = $module->getvar( 'mid' ) ;

        return $xoopsUser->isAdmin($mid); 
    }
}

?>
