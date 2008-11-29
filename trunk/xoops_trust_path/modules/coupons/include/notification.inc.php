<?php
$mytrustdirname = basename( dirname(dirname( __FILE__ )) ) ;
$mytrustdirpath = dirname(dirname( __FILE__ )) ;

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
    return coupons_notify_iteminfo_base( "'.$mydirname.'" , $category , $item_id ) ;
}
' ) ;

function coupons_notify_iteminfo_base($category, $item_id)
{
	global $xoopsDB, $mydirname ;
	global $xoopsModule, $xoopsModuleConfig, $xoopsConfig , $mydirname;

	if ($category=='global') {
		$item['name'] = '';
		$item['url'] = '';
		return $item;
	}

	if ($category=='link') {
		$sql = 'SELECT title FROM '. $xoopsDB->prefix($mydirname.'_coupons') .' WHERE lid='. intval($item_id);
		$result = $xoopsDB->query($sql); // TODO: error check
		$result_array = $xoopsDB->fetchArray($result);
		$item['name'] = htmlspecialchars($result_array['title'],ENT_QUOTES);
		$item['url'] = XOOPS_URL . "/modules/$mydirname/index.php?lid=". intval($item_id);
		return $item;
	}
}
?>
