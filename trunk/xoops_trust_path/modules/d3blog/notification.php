<?php
/**
 * @version $Id: notification.php 40 2007-07-21 06:21:54Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 * Copyrighted (c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;

global $xoopsConfig;

// template directory
if($event_info['name']=='comment_submit' || $event_info['name']=='comment') {
} else {
    $language = empty( $xoopsConfig['language'] ) ? 'english' : $xoopsConfig['language'] ;
    if( file_exists( "$mydirpath/language/$language/mail_template/" ) ) {
        // user customized language file
        $event_info['mail_template_dir'] = "$mydirpath/language/$language/mail_template/" ;
    } else if( file_exists( "$mytrustdirpath/language/$language/mail_template/" ) ) {
        // default language file
        $event_info['mail_template_dir'] = "$mytrustdirpath/language/$language/mail_template/";
    } else {
        // fallback english
        $event_info['mail_template_dir'] = "$mytrustdirpath/language/english/mail_template/";
    }
}

eval( '
function '.$mydirname.'_notify_iteminfo( $category, $item_id )
{
    return d3blog_notify_iteminfo_base( "'.$mydirname.'" , $category , $item_id ) ;
}
' ) ;

if( ! function_exists( 'd3blog_notify_iteminfo_base' ) ) {

function d3blog_notify_iteminfo_base( $mydirname , $category , $item_id )
{

    $db =& Database::getInstance();
//    $module_handler =& xoops_gethandler( 'module' ) ;
//    $module =& $module_handler->getByDirname( $mydirname ) ;

    if( $category == 'global' ) {
        $item['name'] = '';
        $item['url'] = '';
        return $item ;
    }

    if( $category == 'entry' ) {
        $sql = "SELECT title FROM " . $db->prefix($mydirname.'_entry') . " WHERE bid = ".intval($item_id);
        $result = $db->query($sql); // TODO: error check
        $result_array = $db->fetchArray($result);
        $item['name'] = htmlspecialchars($result_array['title'], ENT_QUOTES);
        $item['url'] = XOOPS_URL . '/modules/' . $mydirname . '/details.php?bid=' . intval($item_id);
        return $item;
    }

}

}
?>