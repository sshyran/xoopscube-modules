<?php
/**
 * @version $Id: pical.inc.php 313 2008-02-29 12:52:07Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// options[0]   categories seperated by comma
$options = explode('|', $plugin['options']);

$mytrustdirpath = dirname(dirname( __FILE__ ));

require dirname(dirname(__FILE__)).'/include/prepend.inc.php';

// GET MODULE INFORMATION
$myModule = call_user_func(array($mydirname, 'getInstance'));

$entry_handler =& $myModule->getHandler('entry');
$criteria =& $entry_handler->getDefaultCriteria();
// CRITERIA WITH AN ENTRY PERMISSION
$criteria =& $entry_handler->entryPermCriteria($criteria);

switch($pluginTactname) {
	case 'daily':
        $range_start = mktime(0,0,0,$this->month,$this->date-1,$this->year);
        $range_end = mktime(0,0,0,$this->month,$this->date+2,$this->year);
        break;
    case 'weekly':
        $wtop_date = $this->date - ( $this->day - $this->week_start + 7 ) % 7;
        $range_start = mktime(0,0,0,$this->month,$wtop_date-1,$this->year);
        $range_end = mktime(0,0,0,$this->month,$wtop_date+8,$this->year);
        break;
    case 'monthly':
    default:
        $range_start = mktime(0,0,0,$this->month,0,$this->year);
        $range_end = mktime(0,0,0,$this->month+1,1,$this->year);
    break;
}

switch($pluginQueryname) {
	case 'entry':
        $d3blog_sql = sprintf('SELECT bid, title, cid, published FROM %s WHERE (published >= %d AND published < %d)',
                    $db->prefix($mydirname.'_entry'), $range_start, $range_end);
        $group_by = '';
        $order_by = ' ORDER BY published ASC, cid ASC';
        break;
    case 'date':
    default:
        $d3blog_sql = sprintf('SELECT cid, published, count(bid) FROM %s WHERE (published >= %d AND published < %d)',
                    $db->prefix($mydirname.'_entry'), $range_start, $range_end);
        $group_by = ' GROUP BY LEFT(FROM_UNIXTIME(published)+0, 8)';
        $order_by = ' ORDER BY LEFT(FROM_UNIXTIME(published)+0, 8)';
        if(!empty($options[0])) {
        	$group_by .= ', cid';
            $order_by .= ', cid';
        }
        break;
}

if(count($criteria->criteriaElements)) {
    $d3blog_sql .= ' AND '.$criteria->render();
}


if(!empty($options[0])) {
    $d3blog_sql .= ' AND cid IN (' . addslashes($options[0]) . ')' ;
}

$d3blog_sql .= $group_by.$order_by;
$result = $db->query($d3blog_sql);

switch($pluginQueryname) {
	case 'entry':
        while( list( $bid, $title, $cid, $server_time ) = $db->fetchRow( $result ) ) {
            $user_time = $server_time + $tzoffset_s2u;
            if( date( 'n' , $user_time ) != $this->month )
                continue;
            $target_date = date('j',$user_time);
            $tmp_array = array(
                'dotgif' => $plugin['dotgif'],
                'dirname' => $plugin['dirname'],
                'link' => sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $mydirname, $bid),
                'id' => $bid,
                'server_time' => $server_time,
                'user_time' => $user_time,
                'name' => 'bid' ,
                'title' => $myts->makeTboxData4Show( $title )
                );
            if( $just1gif ) {
                // just 1 gif per a plugin & per a day
                $plugin_returns[ $target_date ][ $plugin['dirname'] ] = $tmp_array;
            } else {
                // multiple gifs allowed per a plugin & per a day
                $plugin_returns[ $target_date ][] = $tmp_array;
            }
        }
        break;
    case 'date':
    default:
        while( list( $cid, $server_time, $entry_count ) = $db->fetchRow( $result ) ) {
            $user_time = $server_time + $tzoffset_s2u;
            if( date( 'n' , $user_time ) != $this->month )
                continue;
            $target_date = date('j',$user_time);
            $target_Ymd = sprintf("%04d%02d%02d",$this->year,$this->month,$target_date);
            $link = sprintf('%s/modules/%s/index.php?date=%s&amp;caldate=%s-%s-%s',
                            XOOPS_URL, $mydirname, $target_Ymd, $this->year, $this->month, $target_date);
            if(!empty($options[0])) {
            	$link .= '&amp;cid='.intval($cid);
            }
            $tmp_array = array(
                'dotgif' => $plugin['dotgif'],
                'dirname' => $plugin['dirname'],
                'link' => $link,
                'id' => $cid.$target_Ymd,
                'server_time' => $server_time,
                'user_time' => $user_time,
                'name' => 'date',
                'title' => $plugin['name']."($entry_count)"
                );
            if( $just1gif ) {
                // just 1 gif per a plugin & per a day
                $plugin_returns[ $target_date ][ $plugin['dirname'] ] = $tmp_array;
            } else {
                // multiple gifs allowed per a plugin & per a day
                $plugin_returns[ $target_date ][] = $tmp_array;
            }
        }
        break;
}

?>