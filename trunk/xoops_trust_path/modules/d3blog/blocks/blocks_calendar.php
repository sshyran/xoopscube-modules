<?php
/**
 * @version $Id: blocks_calendar.php 466 2008-06-08 08:18:40Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

function b_d3blog_calendar_show($options) {
    global $currentUser;
    global $xoopsConfig;

    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );
    $this_template = empty( $options[4] ) ? 'db:'.$mydirname.'_block_calendar.html' : trim( $options[4] );
    $constpref = '_MB_' . strtoupper( $mydirname );

    // GET MODULE BASE INFO
    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);

    // set when month
    $date = ( isset($_GET['date']) && strlen(strval($_GET['date'])) >= 6 ) ? intval($_GET['date']) : null;
    if( $date && is_numeric($date)  ){
        $month = substr( strval($date) , 0 , 6 );
        if(!checkdate(intval(substr($month , 4 , 2)), 1, intval(substr($month , 0 , 4))))
            $month = date('Ym' , time());
    }else{
        $month = date('Ym' , time());
    }
    // get next/previous month and year
    $this_year = substr($month , 0 , 4) ;
    $this_month = substr($month , 4 , 6) ;
    $month_next = date('Ym', mktime(0, 0, 0, intval($this_month)+1, 1, intval($this_year)));
    $month_prev = date('Ym', mktime(0, 0, 0, intval($this_month)-1, 1, intval($this_year)));
    $year_next = strval(intval($this_year) + 1) . $this_month ;
    $year_prev = strval(intval($this_year) - 1) . $this_month ;

    if(!defined('_CAL_SUNDAY')) {
        if (file_exists(XOOPS_ROOT_PATH.'/language/'.$xoopsConfig["language"].'/calendar.php')) {
            require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig["language"].'/calendar.php';
        } else {
            require_once XOOPS_ROOT_PATH.'/language/english/calendar.php';
        }
    }
    $month_arr = array(1 => _CAL_JANUARY, 2 => _CAL_FEBRUARY, 3 => _CAL_MARCH, 4 => _CAL_APRIL,
                        5 => _CAL_MAY, 6 => _CAL_JUNE, 7 => _CAL_JULY, 8 => _CAL_AUGUST,
                        9 => _CAL_SEPTEMBER, 10 => _CAL_OCTOBER, 11 => _CAL_NOVEMBER, 12 => _CAL_DECEMBER
                        );

    $week_arr = array( constant($constpref.'_LANG_SUNDAY'), constant($constpref.'_LANG_MONDAY'), constant($constpref.'_LANG_TUESDAY'),
                        constant($constpref.'_LANG_WEDNESDAY'), constant($constpref.'_LANG_THURSDAY'), constant($constpref.'_LANG_FRIDAY'), constant($constpref.'_LANG_SATURDAY'));
        
    // get one month calendar array
    require_once dirname(dirname(__FILE__)).'/include/calendar.inc.php';
    $mycalendar = new MyCalendar($month);
    $calendar = $mycalendar->dispCalendar();

    $calendar['lang_calendar_summary'] = constant($constpref.'_SUMMARY_CALENDAR');
    $calendar['lang_monthPrev'] = constant($constpref.'_LANG_PREVMONTH');
    $calendar['lang_monthNext'] = constant($constpref.'_LANG_NEXTMONTH');
    $calendar['lang_yearPrev'] = constant($constpref.'_LANG_PREVYEAR');
    $calendar['lang_yearNext'] = constant($constpref.'_LANG_NEXTYEAR'); 
    $calendar['lang_month'] = $month_arr[intval($calendar['month'])];
    $calendar['lang_ShowPrevMonth'] = constant($constpref.'_LANG_PREVMONTH_TITLE');
    $calendar['lang_ShowNextMonth'] = constant($constpref.'_LANG_NEXTMONTH_TITLE');
    $calendar['lang_ShowPrevYear'] = constant($constpref.'_LANG_PREVYEAR_TITLE');
    $calendar['lang_ShowNextYear'] = constant($constpref.'_LANG_NEXTYEAR_TITLE');
    $calendar['lang_ShowThisMonth'] = constant($constpref.'_LANG_THIS_MONTH_TITLE');
    $calendar['dayofweek'] = $week_arr;
    // override
    $calendar['monthThis'] = $this_year . $this_month ;
    $calendar['monthPrev'] = $month_prev ;
    $calendar['monthNext'] = $month_next ;
    $calendar['yearPrev'] = $year_prev ;
    $calendar['yearNext'] = $year_next ;
    

    // get entries of the month
    $entry_handler =& $myModule->getHandler('entry');
	// CRITERIA WITH AN ENTRY PERMISSION
	$criteria =& $entry_handler->getDefaultCriteria();
	$criteria =& $entry_handler->entryPermCriteria($criteria);
	$criteria->add(new criteria("FROM_UNIXTIME(published+". $currentUser->timeoffset() .", '%Y%m')", "$month"));
    $criteria->setSort('published');
    $criteria->setOrder('ASC');
    $objs =& $entry_handler->getObjects($criteria);

    $entries = array();
    foreach($objs as $obj) {
        $day = date('d', $obj->published() + $currentUser->timeoffset());
        $entries[intval($day)] =& $obj->getStructure();
        $entries[intval($day)]['yyyymmdd'] = $this_year . $this_month . $day;
    }

    $days = array_keys($entries);           // make array of day

    // week number of 1st day of this month
    $firstcol = date("w", mktime(0, 0, 0, $this_month, 1, $this_year) );
    // insert entry info corresponding to the day
    foreach($entries as $day => $entry) {
    	$row = ceil( ($day + $firstcol) / 7 ) - 1;
        $col = date("w", mktime(0, 0, 0, $this_month, $day, $this_year));
        $calendar['entries'][$row][$col] = $entry;
    }

    $block['mydirname'] = $mydirname4show;
    $block['mod_url'] = sprintf('%s/modules/%s', XOOPS_URL, $mydirname4show);
//    $block['moduleInfo'] = $myModule->module_info;
    $block['calendar'] = $calendar;

    if(empty($options['disable_renderer'])) {
        require_once XOOPS_ROOT_PATH.'/class/template.php';
        $tpl = new XoopsTpl();
        $tpl->assign('block', $block);
        $ret['content'] = $tpl->fetch($this_template);
        return $ret ;
    } else {
        return $block ;
    }

}

function b_d3blog_calendar_edit($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );

    $form = "<input type='hidden' name='options[]' value='".htmlspecialchars($mydirname, ENT_QUOTES)."' />\n";
    return $form ;
}

?>