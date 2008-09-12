<?php

if (defined('__CINEMARU_DB_PHP__')) {
    return;
}
define('__CINEMARU_DB_PHP__', 1);

function cinemaru_movie_add($randam_code, $valid)
{
    global $xoopsDB;
    global $mydirname;
      
    $sql = "INSERT INTO " . $xoopsDB->prefix($mydirname . '_movie');
    $sql .= " ( ";
    $sql .= " title, `file`, image_file, file_size, randam_code, `desc`, ";
    $sql .= " genre, `valid`, owner, reg_time, reg_user ";
    $sql .= " ) VALUES ( ";
    $sql .= "'" . mysql_real_escape_string($_REQUEST['title']) . "', ";
    $sql .= "'', ";
    $sql .= "'', ";
    $sql .= intval(@$_FILES['file']['size']) . ", ";
    $sql .= "'" . mysql_real_escape_string($randam_code) . "', ";
    $sql .= "'" . mysql_real_escape_string($_REQUEST['desc']) . "', ";
    $sql .= "0, ";
    $sql .= intval($valid) . ", ";
    $sql .= intval(@$_SESSION['xoopsUserId']) . ", ";
    $sql .= intval(time()) . ", ";
    $sql .= intval(@$_SESSION['xoopsUserId']);
    $sql .= " ) ";
    
    $xoopsDB->queryF($sql);

    return $xoopsDB->getInsertId();
}

function cinemaru_movie_file_name_update($id, $randam_code, $movie_ext='', $image_ext='', $file_url='', $image_file_url='', $file_type=0)
{
    global $xoopsDB;
    global $mydirname;
    
    $f = $id . '_' . $randam_code;
      
    $sql = 'UPDATE ' . $xoopsDB->prefix($mydirname . '_movie') . ' SET ';
    $sql .= " `file` = '" . mysql_real_escape_string($f . '.flv') . "' ";
    if ($movie_ext != '') {
	$sql .= ", `file` = '" . mysql_real_escape_string($f . '.' . $movie_ext) . "' ";
    }
    if ($image_ext != '') {
	$sql .= ", `image_file` = '" . mysql_real_escape_string($f . '.' . $image_ext) . "' ";
    }
    if ($file_url != '') {
	$sql .= ", `file_url` = '" . mysql_real_escape_string($file_url) . "' ";
    }
    if ($image_file_url != '') {
	$sql .= ", `image_file_url` = '" . mysql_real_escape_string($image_file_url) . "' ";
    }
    if (0 < $file_type) {
	$sql .= ", `file_type` = " . intval($file_type);
    }
    $sql .= ' WHERE id = ' . intval($id);
	      
    $xoopsDB->queryF($sql);
}

function cinemaru_movie_valid_update($id, $valid)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'UPDATE ' . $xoopsDB->prefix($mydirname . '_movie') . ' SET ';
    $sql .= " `valid` = " . intval($valid);
    $sql .= ' WHERE id = ' . intval($id);
	      
    $xoopsDB->queryF($sql);

    return $xoopsDB->getInsertId();
}

function cinemaru_movie_get_one($id)
{
    global $xoopsDB;
    global $mydirname;
      
    $sql = "SELECT * FROM " . $xoopsDB->prefix($mydirname . '_movie');
    $sql .= " WHERE id = " . intval($id) . ' LIMIT 1';

    $result = $xoopsDB->query($sql);
    
    return $xoopsDB->fetchArray($result);
}

function cinemaru_movie_get_min_max()
{
    global $xoopsDB;
    global $mydirname;
      
    $sql = "SELECT MIN(id) AS min, MAX(id) AS max FROM " . $xoopsDB->prefix($mydirname . '_movie');
    
    $result = $xoopsDB->query($sql);
    
    return $xoopsDB->fetchArray($result);
}

function cinemaru_comment_add($movie_id, $comment, $comment_time, $owner)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'INSERT INTO ' . $xoopsDB->prefix($mydirname . '_comment');
    $sql .= ' ( ';
    $sql .= '`movie_id`, `comment`, `comment_time`, `reg_time`, `reg_user`) VALUES ( ';
    $sql .= intval($movie_id) . ',';
    $sql .= "'" . mysql_real_escape_string($comment) . "', ";
    $sql .= intval($comment_time) . ',';
    $sql .= time() . ', ';
    $sql .= intval($owner) . ' ';
    $sql .= ' ) ';

    $result = $xoopsDB->queryF($sql);
}

function cinemaru_comment_delete($comment_id)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'DELETE FROM ' . $xoopsDB->prefix($mydirname . '_comment');
    $sql .= ' WHERE id = ' . intval($comment_id);

    $result = $xoopsDB->queryF($sql);
}

function cinemaru_comment_get($movie_id)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT * FROM ' . $xoopsDB->prefix($mydirname . '_comment');
    $sql .= ' WHERE `movie_id` = ' . intval($movie_id);
    $sql .= ' ORDER BY reg_time DESC LIMIT 0, 100';

    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    while ($row = $arr = $xoopsDB->fetchArray($result)) {
	$list[] = $row;
    }
    
    return $list;
}

function cinemaru_comment_get_custom($offset=0, $limit=100, $id=0)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT id, movie_id, comment, comment_time, reg_time, mod_time, reg_user, mod_user FROM ' . $xoopsDB->prefix($mydirname. '_comment');
    if ($id) {
	$sql .= ' WHERE movie_id = ' . intval($id);
    }
    $sql .= ' ORDER BY reg_time DESC ';
    $sql .= ' LIMIT ' . intval($offset) . ', ' . intval($limit);

    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    while ($row = $arr = $xoopsDB->fetchArray($result)) {
	$t = intval($row['comment_time'] / 1000);
	$hour = $t / 3600;
	$min = $t / 60;
	$sec = $t % 60;
	$row['comment_time_f'] = sprintf('%02d:%02d:%02d', $hour, $min, $sec);
	$list[] = $row;
    }
    
    return $list;
}

function cinemaru_comment_get_count($id=0)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT count(id) AS cnt FROM ' . $xoopsDB->prefix($mydirname . '_comment');
    if ($id) {
	$sql .= ' WHERE `movie_id` = ' . intval($id);
    }

    $result = $xoopsDB->query($sql);
    $row = $xoopsDB->fetchArray($result);

    return intval(@$row['cnt']);
}

function cinemaru_movie_get_list($length=100, $valid=1, $sort=1)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT * FROM ' . $xoopsDB->prefix($mydirname . '_movie');
    if ($valid) {
	$sql .= ' WHERE `valid` = ' . intval($valid);
    }
    $sql .= ' ORDER BY ';
    if ($sort == 1) {
	$sql .= ' reg_time DESC ';
    } else if ($sort == 2) {
	$sql .= ' reg_time ';
    } else if ($sort == 3) {
	$sql .= ' counter DESC ';
    } else if ($sort == 4) {
	$sql .= ' counter ';
    } else if ($sort == 5) {
	$sql .= ' comment_up_time DESC ';
    } else if ($sort == 6) {
	$sql .= ' comment_up_time ';
    } else if ($sort == 7) {
	$sql .= ' comment DESC ';
    } else if ($sort == 8) {
	$sql .= ' comment ';
    } else {
	$sql .= ' comment_up_time DESC ';
    }
    
    $sql .= ' LIMIT ' . intval($length);

    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    while ($row = $arr = $xoopsDB->fetchArray($result)) {
	$list[] = $row;
    }
    
    return $list;
}

function cinemaru_movie_get_count($auth_admin=0, $valid=0)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT count(id) AS cnt FROM ' . $xoopsDB->prefix($mydirname . '_movie');
    if ($auth_admin == 1) {
	if ($valid) {
	    $sql .= ' WHERE `valid` = 0 ';
	}
    } else {
	$sql .= ' WHERE `valid` = 1 ';
    }

    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    $row = $xoopsDB->fetchArray($result);

    return intval(@$row['cnt']);
}

function cinemaru_movie_get_count_with_tag($tags_id, $auth_admin=0, $valid=0)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT count(m.id) AS cnt FROM ' . $xoopsDB->prefix($mydirname . '_movie') . ' AS m, ';
    $sql .= $xoopsDB->prefix($mydirname . '_tag_movie') . ' AS tm ';
    $sql .= ' WHERE tm.movie_id = m.id AND tm.tags_id = ' . intval($tags_id);
    if ($auth_admin == 1) {
	if ($valid) {
	    $sql .= ' AND `valid` = 0 ';
	}
    } else {
	$sql .= ' AND `valid` = 1 ';
    }

    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    $row = $xoopsDB->fetchArray($result);

    return intval(@$row['cnt']);
}

function cinemaru_movie_get_list_custom($offset, $limit, $auth_admin=0, $valid=0, $sort=0)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT * FROM ' . $xoopsDB->prefix($mydirname . '_movie');
    if ($auth_admin == 1) {
	if ($valid) {
	    $sql .= ' WHERE `valid` = 0 ';
	}
    } else {
	$sql .= ' WHERE `valid` = 1 ';
    }
    $sql .= ' ORDER BY ';
    if (@$sort == 0) {
	$sql .= ' comment_up_time DESC, counter DESC ';
    } else if (@$sort == 1) {
	$sql .= ' reg_time DESC, comment_up_time DESC, counter DESC ';
    } else if (@$sort == 2) {
	$sql .= ' reg_time, comment_up_time DESC, counter DESC ';
    } else if (@$sort == 3) {
	$sql .= ' counter DESC, comment_up_time DESC ';
    } else if (@$sort == 4) {
	$sql .= ' counter, comment_up_time DESC ';
    }
    $sql .= ' LIMIT ' . intval($offset) . ', ' . intval($limit);

    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    while ($row = $arr = $xoopsDB->fetchArray($result)) {
	$list[] = $row;
    }
    
    return $list;
}

function cinemaru_movie_get_list_custom_with_tag($offset, $limit, $tags_id, $auth_admin=0, $valid=0)
{
    global $xoopsDB;
    global $mydirname;

    $columns = array(
		     'id', 'title', 'file', 'image_file', 'total_time', 'file_type',
		     'file_size', 'randam_code', 'desc', 'genre', 'valid', 'owner',
		     'counter', 'comment', 'comment_up_time', 'reg_time',
		     'mod_time', 'reg_user', 'mod_user'
		     );
    $c = array();
    foreach ($columns as $val) {
	$c[] = 'm.' . $val;
    }
    $c2 = join(', ', $c);
    
    $sql = 'SELECT  ' . $c2 . ' FROM ' . $xoopsDB->prefix($mydirname . '_movie') . ' AS m, ';
    $sql .= $xoopsDB->prefix($mydirname . '_tag_movie') . ' AS tm ';
    $sql .= ' WHERE tm.movie_id = m.id AND tm.tags_id = ' . intval($tags_id);
    if ($auth_admin == 1) {
	if ($valid) {
	    $sql .= ' AND m.valid = 0 ';
	}
    } else {
	$sql .= ' AND m.valid = 1 ';
    }
    $sql .= ' ORDER BY ';
    if (@$sort == 0) {
	$sql .= ' comment_up_time DESC, counter DESC ';
    } else if (@$sort == 1) {
	$sql .= ' m.reg_time DESC, comment_up_time DESC, counter DESC ';
    } else if (@$sort == 2) {
	$sql .= ' m.reg_time, comment_up_time DESC, counter DESC ';
    } else if (@$sort == 3) {
	$sql .= ' counter DESC, comment_up_time DESC ';
    } else if (@$sort == 4) {
	$sql .= ' counter, comment_up_time DESC ';
    }
    $sql .= ' LIMIT ' . intval($offset) . ', ' . intval($limit);
    
    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    while ($row = $arr = $xoopsDB->fetchArray($result)) {
	$list[] = $row;
    }
    
    return $list;
}

function cinemaru_movie_counter_up($id)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'UPDATE ' . $xoopsDB->prefix($mydirname . '_movie') . ' SET ';
    $sql .= " `counter` = `counter` + 1 ";
    $sql .= ' WHERE id = ' . intval($id);
	      
    $xoopsDB->queryF($sql);
}

function cinemaru_movie_comment_up($id)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'UPDATE ' . $xoopsDB->prefix($mydirname . '_movie') . ' SET ';
    $sql .= " `comment` = `comment` + 1, ";
    $sql .= " `comment_up_time` = " . time() . " ";
    $sql .= ' WHERE id = ' . intval($id);
	      
    $xoopsDB->queryF($sql);
}

function cinemaru_movie_title_desc_update($id, $title, $desc, $tag_lock, $file='', $image='', $valid=0, $file_url='', $image_file_url='', $file_type=0)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'UPDATE ' . $xoopsDB->prefix($mydirname . '_movie') . ' SET ';
    $sql .= " `title` = '" . mysql_real_escape_string($title) . "', ";
    $sql .= " `desc` = '" . mysql_real_escape_string($desc) . "', ";
    $sql .= " `valid` = '" . intval($valid) . "', ";
    $sql .= " `tag_lock` = '" . intval($tag_lock) . "', ";
    $sql .= " `mod_time` = '" . intval(time()) . "', ";
    $sql .= " `mod_user` = '" . intval(@$_SESSION['xoopsUserId']) . "' ";
    if ($file != '') {
	$sql .= ", `file` = '" . mysql_real_escape_string($file) . "' ";
    }
    if ($image != '') {
	$sql .= ", `image_file` = '" . mysql_real_escape_string($image) . "' ";
    }
    if ($file_url != '') {
	$sql .= ", `file_url` = '" . mysql_real_escape_string($file_url) . "' ";
    }
    if ($image_file_url != '') {
	$sql .= ", `image_file_url` = '" . mysql_real_escape_string($image_file_url) . "' ";
    }
    if (0 < $file_type) {
	$sql .= ", `file_type` = " . intval($file_type);
    }
    $sql .= ' WHERE id = ' . intval($id);

    $xoopsDB->queryF($sql);

    return $xoopsDB->getInsertId();
}

function cinemaru_movie_delete($id)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'DELETE FROM ' . $xoopsDB->prefix($mydirname . '_movie');
    $sql .= ' WHERE id = ' . intval($id);

    $xoopsDB->queryF($sql);
}

function cinemaru_tag_get($movie_id)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT t.id AS id, tm.id AS tags_movie_id, tm.tags_id AS tags_id, t.name AS name ';
    $sql .= 'FROM ' . $xoopsDB->prefix($mydirname . '_tags') . ' AS t, ';
    $sql .= $xoopsDB->prefix($mydirname . '_tag_movie') . ' AS tm ';
    $sql .= ' WHERE ';
    $sql .= 'tm.movie_id = ' . intval($movie_id) . ' AND ';
    $sql .= 't.id = tm.tags_id ';

    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    while ($row = $arr = $xoopsDB->fetchArray($result)) {
	$list[] = $row;
    }
    
    return $list;
}

function cinemaru_get_tag_by_name($name)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT id FROM ' . $xoopsDB->prefix($mydirname . '_tags');
    $sql .= " WHERE name = '" . mysql_real_escape_string($name) . "'";
    
    $result = $xoopsDB->query($sql);
        
    $row = $xoopsDB->fetchArray($result);
        
    if ($row) {
	return $row['id'];
    } else {
	return '';
    }
}

function cinemaru_get_tag_movie($movie_id, $tag_id)
{
    global $xoopsDB;
    global $mydirname;

    $sql = 'SELECT id FROM ' . $xoopsDB->prefix($mydirname . '_tag_movie');
    $sql .= " WHERE tags_id = " . intval($tag_id) . ' AND ';
    $sql .= ' movie_id = ' . intval($movie_id);
    
    $result = $xoopsDB->query($sql);
        
    $row = $xoopsDB->fetchArray($result);
        
    if ($row) {
	return $row['id'];
    } else {
	return '';
    }
}

function cinemaru_add_tag($tag_name, $user_id)
{
    global $xoopsDB;
    global $mydirname;
    
    $id = cinemaru_get_tag_by_name($tag_name);

    if ($id) {
	// ´û¤ËÅÐÏ¿ºÑ¤ß
	return $id;
    }
        
    $sql = 'INSERT INTO ' . $xoopsDB->prefix($mydirname . '_tags');
    $sql .= ' ( ';
    $sql .= 'name, reg_time, reg_user ) VALUES ( ';
    $sql .= "'" . mysql_real_escape_string($tag_name) . "', ";
    $sql .= time() . ', ';
    $sql .= intval($user_id) . ' ';
    $sql .= ' ) ';
    
    $result = $xoopsDB->queryF($sql);
        
    return mysql_insert_id();
}

function cinemaru_add_tag_to_movie($movie_id, $tag_name, $user_id)
{
    global $xoopsDB;
    global $mydirname;
    
    $tag_id = cinemaru_add_tag($tag_name, $user_id);

    if (cinemaru_get_tag_movie($movie_id, $tag_id)) {
	// ´û¤ËÅÐÏ¿ºÑ¤ß
	return;
    }
        
    $sql = 'INSERT INTO ' . $xoopsDB->prefix($mydirname . '_tag_movie');
    $sql .= ' ( ';
    $sql .= 'tags_id, movie_id, reg_time, reg_user ) VALUES ( ';
    $sql .= intval($tag_id) . ', ';
    $sql .= intval($movie_id) . ', ';
    $sql .= time() . ', ';
    $sql .= intval($user_id) . ' ';
    $sql .= ' ) ';

    $result = $xoopsDB->queryF($sql);
}

function cinemaru_delete_tag_to_movie($id)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'DELETE FROM ' . $xoopsDB->prefix($mydirname . '_tag_movie');
    $sql .= ' WHERE ';
    $sql .= ' id = ' . intval($id);
    
    $result = $xoopsDB->queryF($sql);
}

function cinemaru_movie_report_add($movie_id, $category, $comment)
{
    global $xoopsDB;
    global $mydirname;
      
    $sql = "INSERT INTO " . $xoopsDB->prefix($mydirname . '_report');
    $sql .= " ( ";
    $sql .= " movie_id, `category`, comment, ";
    $sql .= " reg_time, reg_user ";
    $sql .= " ) VALUES ( ";
    $sql .= intval($movie_id) . ", ";
    $sql .= intval($category) . ", ";
    $sql .= "'" . mysql_real_escape_string($comment) . "', ";
    $sql .= intval(time()) . ", ";
    $sql .= intval(@$_SESSION['xoopsUserId']) . " ";
    $sql .= " ) ";

    $xoopsDB->queryF($sql);

    return $xoopsDB->getInsertId();
}

function cinemaru_report_get_count()
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT count(id) AS cnt FROM ' . $xoopsDB->prefix($mydirname . '_report');
    
    $result = $xoopsDB->query($sql);
    $row = $xoopsDB->fetchArray($result);

    return intval(@$row['cnt']);
}

function cinemaru_report_get_custom($offset=0, $limit=100)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'SELECT id, movie_id, category, comment, reg_time, mod_time, reg_user, mod_user FROM ' . $xoopsDB->prefix($mydirname . '_report');
    $sql .= ' ORDER BY reg_time DESC ';
    $sql .= ' LIMIT ' . intval($offset) . ', ' . intval($limit);

    $result = $xoopsDB->query($sql);
    
    $list = array();
    
    while ($row = $arr = $xoopsDB->fetchArray($result)) {
	$list[] = $row;
    }
    
    return $list;
}

function cinemaru_report_delete($report_id)
{
    global $xoopsDB;
    global $mydirname;
    
    $sql = 'DELETE FROM ' . $xoopsDB->prefix($mydirname . '_report');
    $sql .= ' WHERE id = ' . intval($report_id);

    $result = $xoopsDB->queryF($sql);
}

