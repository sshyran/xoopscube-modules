<?php

require_once dirname(dirname(__FILE__)).'/class/bulletin.php' ;
require_once dirname(dirname(__FILE__)).'/class/bulletingp.php' ;
require_once dirname(dirname(__FILE__)).'/class/bulletinTopic.php' ;
require_once dirname(dirname(__FILE__)).'/include/configs.inc.php' ;
require_once dirname(dirname(__FILE__)).'/include/common_functions.php' ;

$assing_array = array(
	'disp_rss_link' => $bulletin_disp_rss_link,
	'mydirurl' => $mydirurl,
	'mydirname' => $mydirname,
	);

//���¥��饹
$gperm = new BulletinGP;

// User has the right to post.
if($gperm->group_perm(1)){
	$assing_array['can_post'] = 1;
}

// RSS Feed in <header>
$rss_feed = '<link rel="alternate" type="application/rss+xml" title="RSS2.0" href="'.$mydirurl.'/index.php?page=rss" />'

?>