<?php
/*
 * $Id: admin.inc.php 445 2008-05-30 08:21:20Z hodaka $
 */
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

define('_BL_ENTRY_SEPARATOR_DELIMETER' , '---UnderThisSeparatorIsLatterHalf---');
define('MEMBER_ONLY_READ_DELIMETER' , '---AnonymousUserCantReadUnderHere---');

function indexLink() {
    global $xoopsModule;

    return sprintf('<a href=\'%s/modules/%s/admin/index.php\'>%s</a>',
                   XOOPS_URL, $xoopsModule->dirname(), _MD_A_D3BLOG_CONFIG);
}

function import_from_weblog( $from_prefix , $import_mid )
{
    global $mydirname;
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    $member_handler =& xoops_gethandler('member');
    $groups =& $member_handler->getGroupList();
    
    // entry
    $table_name = 'entry';
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_prefix );
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
            while($entry = $db->fetchArray($re)) {
                $excerpt = str_replace(_BL_ENTRY_SEPARATOR_DELIMETER, "[seperator]", $entry['contents']);
                $excerpt = str_replace(MEMBER_ONLY_READ_DELIMETER, "[seperator]", $excerpt);
                $arr = preg_split("/((\015\012)|(\015)|(\012))?\[seperator\]((\015\012)|(\015)|(\012))?/", $excerpt );
                $excerpt = array_shift($arr);
                $body = implode('', $arr);
                
                if($entry['permission_group'] == 'all') {
                    $group = '|'.implode('|', array_keys($groups)).'|';
                } elseif($entry['permission_group'] == '0') {
                    $group = '|1|';
                } elseif($entry['permission_group'] == '1') {
                    $group = '|1|';
                } else {
                    $group = $entry['permission_group'];
                }

                $sql = sprintf("INSERT INTO `%s` (bid, uid, cid, title, excerpt, body, dohtml, dobr, groups, counter, comments, trackbacks, created, modified, published, approved, notified)".
                    " VALUES(%d, %d, %d, '%s', '%s', '%s', %d, %d, '%s', %d, %d, %d, %d, %d, %d, %d, %d)",
                    $to_table, intval($entry['blog_id']), intval($entry['user_id']), intval($entry['cat_id']), addslashes($entry['title']), addslashes($excerpt), addslashes($body), intval($entry['dohtml']), intval($entry['dobr']), addslashes($group), intval($entry['reads']), intval($entry['comments']), intval($entry['trackbacks']), intval($entry['created']), intval($entry['created']), intval($entry['created']), $entry['private']=='Y'? 0 : 1, 1);
                if (!$rs = $db->query($sql)) die("sql=".$sql." DB ERROR: Failed to insert to ".$to_table);
            }
        }
    }

    // category
    $table_name = 'category';
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_prefix.'_'.$table_name );
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
            while($category = $db->fetchArray($re)) {
                $sql = sprintf("INSERT INTO `%s` (cid, pid, `name`, weight, imgurl, created)".
                    " VALUES(%d, %d, '%s', %d, '%s', %d)",
                    $to_table, intval($category['cat_id']), intval($category['cat_pid']), addslashes($category['cat_title']), 0, addslashes($category['cat_imgurl']), intval($category['cat_created']));
                if (!$rs = $db->query($sql)) die("sql=".$sql." DB ERROR: Failed to insert to ".$to_table);
            }
        }
    }

    // trackback
    $table_name = 'trackback';
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_prefix.'_'.$table_name );
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
            while($trackback = $db->fetchArray($re)) {
                $tbkey = isset($trackback['tbkey'])?$trackback['tbkey']:'';
                $direction = ($trackback['direction']=='transmit')?1:(($trackback['direction']=='recieved')?2:0);
                if($direction==2 && !empty($tbkey) && $trackback['tb_url'] == $tbkey) continue;
                $sql = sprintf("INSERT INTO `$to_table` (bid, blog_name, title, excerpt, url, trackback_url, direction, `host`, tbkey, approved, created)".
                    " VALUES(%d, '%s', '%s', '%s', '%s', '%s', %d, '%s', '%s', %d, %d)",
                    intval($trackback['blog_id']), addslashes($trackback['blog_name']), addslashes($trackback['title']), addslashes($trackback['description']), addslashes($trackback['link']), addslashes($trackback['tb_url']), intval($direction), '', addslashes($tbkey), intval($trackback['trackback_created']), intval($trackback['trackback_created']));
                if (!$rs = $db->query($sql)) die("sql=".$sql." DB ERROR: Failed to insert to ".$to_table);
            }
        }
        make_tbkey($to_table);
    }

}

function import_from_weblogD3( $from_prefix , $import_mid )
{
    global $mydirname;
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    $member_handler =& xoops_gethandler('member');
    $groups =& $member_handler->getGroupList();   
    
    // entry
    $table_name = 'entry';
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_prefix.'_'.$table_name );
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
            while($entry = $db->fetchArray($re)) {
                $excerpt = str_replace(_BL_ENTRY_SEPARATOR_DELIMETER, "[seperator]", $entry['contents']);
                $excerpt = str_replace(MEMBER_ONLY_READ_DELIMETER, "[seperator]", $excerpt);
                $arr = preg_split("/((\015\012)|(\015)|(\012))?\[seperator\]((\015\012)|(\015)|(\012))?/", $excerpt );
                $excerpt = array_shift($arr);
                $body = implode('', $arr);

                if($entry['permission_group'] == 'all') {
                    $group = '|'.implode('|', array_keys($groups)).'|';
                } elseif($entry['permission_group'] == '0') {
                    $group = '|1|';
                } elseif($entry['permission_group'] == '1') {
                    $group = '|1|';
                } else {
                    $group = $entry['permission_group'];
                }

                $sql = sprintf("INSERT INTO `%s` (bid, uid, cid, title, excerpt, body, dohtml, dobr, groups, counter, comments, trackbacks, created, modified, published, approved, notified)".
                    " VALUES(%d, %d, %d, '%s', '%s', '%s', %d, %d, '%s', %d, %d, %d, %d, %d, %d, %d, %d)",
                    $to_table, intval($entry['blog_id']), intval($entry['user_id']), intval($entry['cat_id']), addslashes($entry['title']), addslashes($excerpt), addslashes($body), intval($entry['dohtml']), intval($entry['dobr']), addslashes($group), intval($entry['reads']), intval($entry['comments']), intval($entry['trackbacks']), intval($entry['created']), intval($entry['created']), intval($entry['created']), $entry['private']=='Y'? 0 : 1, 1);
                if (!$rs = $db->query($sql)) die("sql=".$sql." DB ERROR: Failed to insert to ".$to_table);
            }
        }
    }

    // category
    $table_name = 'category';
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_prefix.'_'.$table_name );
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
            while($category = $db->fetchArray($re)) {
                $sql = sprintf("INSERT INTO `%s` (cid, pid, `name`, weight, imgurl, created)".
                    " VALUES(%d, %d, '%s', %d, '%s', %d)",
                    $to_table, intval($category['cat_id']), intval($category['cat_pid']), addslashes($category['cat_title']), 0, addslashes($category['cat_imgurl']), intval($category['cat_created']));
                if (!$rs = $db->query($sql)) die("sql=".$sql." DB ERROR: Failed to insert to ".$to_table);
            }
        }
    }

    // trackback
    $table_name = 'trackback' ;
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_prefix.'_'.$table_name );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        list($count) = $db->fetchRow($res);
        if($count > 0) {
            $db->query( "DELETE FROM `$to_table` WHERE 1" ) ;
            if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
                while($trackback = $db->fetchArray($re)) {
                    $tbkey = isset($trackback['tbkey'])?$trackback['tbkey']:'';
                    $direction = ($trackback['direction']=='transmit')?1:2;
                    if($direction==2 && !empty($tbkey) && $trackback['tb_url'] == $tbkey) continue;
                    $sql = sprintf("INSERT INTO `$to_table` (bid, blog_name, title, excerpt, url, trackback_url, direction, `host`, tbkey, approved, created)".
                        " VALUES(%d, '%s', '%s', '%s', '%s', '%s', %d, '%s', '%s', %d, %d)",
                        intval($trackback['blog_id']), addslashes($trackback['blog_name']), addslashes($trackback['title']), addslashes($trackback['description']), addslashes($trackback['link']), addslashes($trackback['tb_url']), intval($direction), '', addslashes($tbkey), 1, intval($trackback['trackback_created']));
                        if (!$rs = $db->query($sql)) die("DB ERROR: Failed to insert to ".$to_table);
                }
            }
        }
    }

}

function import_from_d3blog( $from_prefix , $import_mid )
{
    global $mydirname;
    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $entry_handler =& $myModule->getHandler('entry');
    $db =& Database::getInstance() ;

    // entry
    $table_name = 'entry' ;
    $to_table = $db->prefix( $mydirname.'_'.$table_name ) ;
    $from_table = $db->prefix( $from_prefix.'_'.$table_name ) ;
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    $add_groups = $add_doimage = false;
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        $sql = "SHOW COLUMNS FROM `$from_table` LIKE 'groups'";
        if($res = $db->query($sql)) {
            if(!$row = $db->fetchRow($res)) {
                $add_groups = true;
            }
        }
        $sql = "SHOW COLUMNS FROM `$from_table` LIKE 'doimage'";
        if($res = $db->query($sql)) {
            if(!$row = $db->fetchRow($res)) {
                $add_doimage = true;
            }
        }
        if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
            while($entry = $db->fetchArray($re)) {
                if($add_groups) {
                    $entry['groups'] = '|'.implode('|', is_array($myModule->getConfig('default_groups'))? $myModule->getConfig('default_groups') : array('1')).'|';
                }
                if($add_doimage) {
                    $entry['doxcode'] = 1;
                    $entry['doimage'] = 1;
                }
                $obj =& $entry_handler->create();
                $obj->setVars($entry);
                if(!$entry_handler->insert($obj))
                    import_errordie();
                unset($obj);
            }
        }
    }
    
    // category
    $table_name = 'category' ;
    $to_table = $db->prefix( $mydirname.'_'.$table_name ) ;
    $from_table = $db->prefix( $from_prefix.'_'.$table_name ) ;
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        $irs = $db->query("INSERT INTO `$to_table` SELECT * FROM `$from_table`" );
        if( ! $irs ) import_errordie();
    }

    // trackback
    $table_name = 'trackback' ;
    $to_table = $db->prefix( $mydirname.'_'.$table_name ) ;
    $from_table = $db->prefix( $from_prefix.'_'.$table_name ) ;
    $db->query( "DELETE FROM `$to_table` WHERE 1" ) ;
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        $irs = $db->query("INSERT INTO `$to_table` SELECT * FROM `$from_table`" );
        if( ! $irs ) import_errordie();
    }

}

function import_from_xeblog( $from_prefix , $import_mid )
{
    global $mydirname;
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    $member_handler =& xoops_gethandler('member');
    $groups =& $member_handler->getGroupList();
    
    // entry
    $from_table_name = 'xeblog';
    $table_name ='entry';
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_table_name );
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
            while($entry = $db->fetchArray($re)) {
                if($entry['permission_group'] == 'all') {
                    $group = '|'.implode('|', array_keys($groups)).'|';
                } elseif($entry['permission_group'] == '0') {
                    $group = '|1|';
                } elseif($entry['permission_group'] == '1') {
                    $group = '|1|';
                } else {
                    $group = $entry['permission_group'];
                }

                $sql = sprintf("INSERT INTO `%s` (bid, uid, cid, title, excerpt, body, dohtml, dobr, groups, counter, comments, trackbacks, created, modified, published, approved, notified)".
                    " VALUES(%d, %d, %d, '%s', '%s', '%s', %d, %d, '%s', %d, %d, %d, %d, %d, %d, %d, %d)",
                    $to_table, intval($entry['blog_id']), intval($entry['user_id']), intval($entry['cat_id']), addslashes($entry['title']), addslashes($entry['contents']), addslashes($entry['description']), intval($entry['dohtml']), intval($entry['dobr']), addslashes($group), intval($entry['reads']), intval($entry['comments']), intval($entry['trackbacks']), intval($entry['created']), intval($entry['created']), intval($entry['created']), $entry['private']=='Y'? 0 : 1, 1);
                if (!$rs = $db->query($sql)) die("sql=".$sql." DB ERROR: Failed to insert to ".$to_table);
            }
        }
    }

    // category
    $table_name = 'category';
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_prefix.'_'.$table_name );
    $db->query( "DELETE FROM `$to_table` WHERE 1" );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
            while($category = $db->fetchArray($re)) {
                $sql = sprintf("INSERT INTO `%s` (cid, pid, `name`, weight, imgurl, created)".
                    " VALUES(%d, %d, '%s', %d, '%s', %d)",
                    $to_table, intval($category['cat_id']), intval($category['cat_pid']), addslashes($category['cat_title']), 0, addslashes($category['cat_imgurl']), intval($category['cat_created']));
                if (!$rs = $db->query($sql)) die("sql=".$sql." DB ERROR: Failed to insert to ".$to_table);
            }
        }
    }

    // trackback
    $table_name = 'trackback' ;
    $to_table = $db->prefix( $mydirname.'_'.$table_name );
    $from_table = $db->prefix( $from_prefix.'_'.$table_name );
    if($res = $db->query("SELECT count(*) as count FROM `$from_table` WHERE 1")) {
        list($count) = $db->fetchRow($res);
        if($count > 0) {
            $db->query( "DELETE FROM `$to_table` WHERE 1" ) ;
            if($re = $db->query("SELECT * FROM `$from_table` WHERE 1")) {
                while($trackback = $db->fetchArray($re)) {
                    $tbkey = isset($trackback['tbkey'])?$trackback['tbkey']:'';
                    $direction = ($trackback['direction']=='transmit')?1:2;
                    if($direction==2 && !empty($tbkey) && $trackback['tb_url'] == $tbkey) continue;
                    $sql = sprintf("INSERT INTO `$to_table` (bid, blog_name, title, excerpt, url, trackback_url, direction, `host`, tbkey, approved, created)".
                        " VALUES(%d, '%s', '%s', '%s', '%s', '%s', %d, '%s', '%s', %d, %d)",
                        intval($trackback['blog_id']), addslashes($trackback['blog_name']), addslashes($trackback['title']), addslashes($trackback['description']), addslashes($trackback['link']), addslashes($trackback['tb_url']), intval($direction), '', addslashes($tbkey), 1, intval($trackback['trackback_created']));
                        if (!$rs = $db->query($sql)) die("DB ERROR: Failed to insert to ".$to_table);
                }
            }
        }
    }

}

function import_comments($to_mid, $from_mid)
{
    $db =& Database::getInstance();
    $sql = "UPDATE ".$db->prefix('xoopscomments')." SET com_modid=".intval($to_mid)." WHERE com_modid=".intval($from_mid);
    if(!$irs = $db->query($sql)) {
        import_errordie() ;
    }
}

function import_notifications($to_mid, $from_mid, $fromtype)
{
    global $mydirname;
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    if(!$result = $db->query("SELECT not_id, not_category FROM ".$db->prefix('xoopsnotifications'). " WHERE not_modid=".intval($from_mid)))
        return true;
    $replacement = array('blog'=>'global', 'blog_entry'=>'entry');
    $replacement2 = array('blog'=>'global', 'category'=>'global', 'blogger'=>'global', 'detail'=>'entry');
    while( list($not_id, $category) = $db->fetchRow($result) ) {
        $sql = "UPDATE ".$db->prefix('xoopsnotifications')." SET not_modid=".intval($to_mid);
        if($fromtype == 'weblog') {
            $sql .= ", not_category='".$replacement[$category]."'";
        }
        if($fromtype == 'weblogD3') {
            $sql .= ", not_category='".$replacement2[$category]."'";
        }
        $sql .= " WHERE not_id=".intval($not_id);
        if(!$irs = $db->query($sql)) {
            import_errordie() ;
        }
    }
}

function synchronizeComments($tablename, $mid, $type='d3blog') {
    $db =& Database::getInstance() ;

    $sql = sprintf("UPDATE %s SET comments='0' WHERE 1", $db->prefix($tablename));
    if (!$re = $db->query($sql)) {
        import_errordie();
    }

    $bid = $type=='d3blog'? 'bid' : 'blog_id';

    $sql = sprintf("SELECT e.%s, COUNT(c.com_id) FROM %s AS e LEFT JOIN %s AS c ON e.%s=c.com_itemid AND c.com_modid=%d GROUP BY e.%s",
        $bid, $db->prefix($tablename), $db->prefix('xoopscomments'), $bid, intval($mid), $bid);
    if(!$result = $db->query($sql))     return true;

    while (list($blog_id, $comments) = $db->fetchRow($result)) {
        $sql = sprintf("UPDATE %s SET comments=%d WHERE %s=%d",
            $db->prefix($tablename), intval($comments), $bid, intval($blog_id));
        if (!$re = $db->query($sql)) {
            import_errordie();
        }
    }

    return true;
}

function synchronizeTrackbacks($dirname) {
    $db =& Database::getInstance();

    $sql = sprintf("UPDATE %s SET trackbacks='0' WHERE 1", $db->prefix($dirname.'_entry'));
    if (!$re = $db->query($sql)) {
        import_errordie();
    }

    $sql = sprintf("SELECT bid, COUNT(*) FROM `%s` WHERE direction=2 AND approved=1 GROUP BY bid",
                   $db->prefix($dirname.'_trackback'));
    if(!$result = $db->query($sql))     return true;

    while (list($bid, $trackbacks) = $db->fetchRow($result)) {
        $sql = sprintf("UPDATE %s SET trackbacks=%d WHERE bid=%d",
                       $db->prefix($dirname.'_entry'), intval($trackbacks), intval($bid));
        if (!$re = $db->query($sql)) {
            import_errordie();
        }
    }

    return true;
}

function import_errordie()
{
    $db =& Database::getInstance() ;

    echo _MD_A_D3BLOG_ERROR_SQLONIMPORT ;
    echo $db->logger->dumpQueries() ;
    exit ;
}

function rewrite_linkpath($pattern, $replacement)
{
    global $mydirname;
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    if(!$result = $db->query("SELECT bid, excerpt, body FROM ".$db->prefix($mydirname.'_entry')." WHERE 1")) die($db->prefix($mydirname.'_entry')." Not found");
    while(list($bid, $excerpt, $body) = $db->fetchRow($result)) {
        $excerpt2 = str_replace($pattern, $replacement, $excerpt);
        $body2 = str_replace($pattern, $replacement, $body);
        if($excerpt2 != $excerpt || $body2 != $body) {
            $sql = sprintf("UPDATE %s SET excerpt='%s', body='%s' WHERE bid=%d",
                       $db->prefix($mydirname.'_entry'), addslashes($excerpt2), addslashes($body2), intval($bid));
            if (!$res = $db->query($sql)) import_errordie();
        }
    }
}

function rewrite_compath($pattern, $replacement)
{
    global $mymid;
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    $sql = "SELECT com_id, com_text FROM ".$db->prefix('xoopscomments')." WHERE com_modid='$mymid'";

    if(!$result = $db->query($sql)) return true;
    while(list($com_id, $com_text) = $db->fetchRow($result)) {
        $com_text2 = str_replace($pattern, $replacement, $com_text);
        if($com_text2 != $com_text) {
            $sql = sprintf("UPDATE %s SET com_text='%s' WHERE com_id=%d",
                       $db->prefix('xoopscomments'), addslashes($com_text2), intval($com_id));
            if (!$res = $db->query($sql)) import_errordie();
        }
    }
}

function rewrite_imglinkpath($pattern, $replacement)
{
    global $mydirname, $mymid;
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    if(!$result = $db->query("SELECT bid, contents FROM ".$db->prefix($mydirname.'_entry')." WHERE 1")) die($db->prefix($mydirname.'_entry')." Not found");
    while(list($blog_id, $contents) = $db->fetchRow($result)) {
        $contents2 = str_replace($pattern, $replacement, $contents);
        if($contents2 != $contents) {
            $sql = sprintf("UPDATE `%s` SET contents='%s' WHERE bid=%d",
                       $db->prefix($mydirname.'_entry'), addslashes($contents2), intval($blog_id));
            if (!$res = $db->query($sql)) die("DB ERROR: Failed to rewrite $db->prefix($mydirname.'_entry')");
        }
    }

    $sql = "SELECT com_id, com_text FROM ".$db->prefix('xoopscomments')." WHERE com_mod_id='$mymid'";

    if(!$result = $db->query($sql)) return true;
    while(list($com_id, $com_text) = $db->fetchRow($result)) {
        $com_text2 = str_replace($pattern, $replacement, $com_text);
        if($com_text2 != $com_text) {
            $sql = sprintf("UPDATE `%s` SET com_text='%s' WHERE com_id=%d",
                       $db->prefix('xoopscomments'), addslashes($com_text2), intval($com_id));
            if (!$res = $db->query($sql)) die("DB ERROR: Failed to rewrite $db->prefix('xoopscomments')");
        }
    }
}

function make_tbkey($table)
{
    $db =& Database::getInstance();

    if(!$rs = $db->query("SELECT * FROM `$table` WHERE direction=2 AND tbkey=''"))
        return null;
    while($trackback = $db->fetchArray($rs)) {
        $tbkey = md5($trackback['created'].rand());
        $tbkey= substr(base_convert($tbkey, 16, 32),0,12);
        $sql = "UPDATE `$table` SET tbkey='".$tbkey."' WHERE tid=".intval($trackback['tid']);
        if (!$res = $db->query($sql)) die("DB ERROR: Failed to make tbkey ".$table);
    }
}

function make_excerpt($table)
{
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    if(!$rs = $db->query("SELECT * FROM `$table` WHERE 1"))
        return null;
    while($entry = $db->fetchArray($rs)) {
        $excerpt = str_replace(_BL_ENTRY_SEPARATOR_DELIMETER, "[seperator]", $entry['contents']);
        $arr = preg_split("/((\015\012)|(\015)|(\012))?\[seperator\]((\015\012)|(\015)|(\012))?/", $excerpt );
        $excerpt = array_shift($arr);
        $body = implode('', $arr);

        $sql = sprintf("UPDATE `%s` SET excerpt='%s', body='%s' WHERE bid=%d",
            $table, addslashes($excerpt), addslashes($body), intval($entry['bid']));
        if (!$res = $db->query($sql)) die("DB ERROR: Failed to rewrite ".$table);
    }

}
?>