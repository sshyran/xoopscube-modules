<?php

function ddcommon_delete_do()
{
    global $xoopsTpl;
    global $map;

    if (WaffleGrant::delete_ok($_GET['t_dd']) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    if (isset($_GET['id'])) {
	// IDがセットされている
	
	$map->delete_one(intval($_GET['id']));
	
	if (WaffleMAP::get_config(WAFFLE_SETTING_USE_ADMIN_MAIL)){
	    $subject = '[waffle]' . _MD_MAIL_SUBJECT_DELETED_DATA;
	    
	    $message = _MD_DELETED_DATA . "\r\n";
	    $message .= "\r\n";
	    
	    $message .= XOOPS_URL . '/modules/' . $GLOBALS['waffle_mydirname'] . '/index.php?t_m=ddcommon_list&t_dd='.$GLOBALS['dd'] . "\r\n";
	    
	    waffle_send_admin_mail($subject, $message);
	}
	
	redirect_header('index.php?t_m=ddcommon_list&t_dd=' . $_GET['t_dd'], 2, _MD_DELETED);
	    
	exit();
    } else {
	// IDがセットされていない
	$xoopsTpl->assign('no_data', 1);
	redirect_header('index.php?t_m=ddcommon_list&t_dd=' . $_GET['t_dd'], 2, _MD_IDNOTFOUND . '(2)');
	exit();
    }
}

?>
