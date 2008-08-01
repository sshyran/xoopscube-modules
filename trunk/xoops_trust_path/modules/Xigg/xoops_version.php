<?php
$const_prefix = '_MI_' . strtoupper($module_dirname);

$lang_dir = dirname(__FILE__) . '/language/';
if (file_exists($lang_file = $lang_dir . @$xoopsConfig['language'] . '/modinfo.php')
     || file_exists($lang_file = $lang_dir . 'english/modinfo.php')) {
    include $lang_file;
}

$modversion['name'] = constant($const_prefix . '_NAME');
$modversion['version'] = 1.21;
$modversion['description'] = constant($const_prefix . '_DESC');
$modversion['credits'] = 'Kazumi Ono<br />( http://www.myweb.ne.jp/ )';
$modversion['author'] = 'Kazumi Ono AKA onokazu';
$modversion['help'] = '';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = file_exists( $module_dirname.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = $module_dirname;

//Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin.php';
$modversion['adminmenu'] = 'admin_menu.php';

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = constant($const_prefix . '_SMENU_TAGCLOUD');
$modversion['sub'][1]['url'] = 'index.php/tag';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'search.php';
$modversion['search']['func'] = $module_dirname . '_search';

// Module administration callbacks
$modversion['onInstall'] = 'module_install.php' ;
$modversion['onUpdate'] = 'module_update.php' ;
$modversion['onUninstall'] = 'module_uninstall.php' ;

// Blocks
$modversion['blocks'][1] = array(
	'file'			=> 'blocks.php',
	'name'			=> constant($const_prefix . '_BNAME_CATEGORIES'),
	'description'		=> constant($const_prefix . '_BDESC_CATEGORIES'),
	'show_func'		=> 'b_xigg_categories',
	'edit_func'		=> 'b_xigg_categories_edit',
	'options'		=> $module_dirname,
	'template'		=> ''
);
$modversion['blocks'][2] = array(
	'file'			=> 'blocks.php',
	'name'			=> constant($const_prefix . '_BNAME_TAG_CLOUD'),
	'description'		=> constant($const_prefix . '_BDESC_TAG_CLOUD'),
	'show_func'		=> 'b_xigg_tag_cloud',
	'edit_func'		=> 'b_xigg_tag_cloud_edit',
	'options'		=> $module_dirname . '|30',
	'template'		=> ''
);
$modversion['blocks'][3] = array(
	'file'			=> 'blocks.php',
	'name'			=> constant($const_prefix . '_BNAME_RECENT_NODES'),
	'description'		=> constant($const_prefix . '_BDESC_RECENT_NODES'),
	'show_func'		=> 'b_xigg_recent_nodes',
	'edit_func'		=> 'b_xigg_recent_nodes_edit',
	'options'		=> $module_dirname . '|6',
	'template'		=> ''
);
$modversion['blocks'][4] = array(
	'file'			=> 'blocks.php',
	'name'			=> constant($const_prefix . '_BNAME_RECENT_COMMENTS'),
	'description'		=> constant($const_prefix . '_BDESC_RECENT_COMMENTS'),
	'show_func'		=> 'b_xigg_recent_comments',
	'edit_func'		=> 'b_xigg_recent_comments_edit',
	'options'		=> $module_dirname . '|6',
	'template'		=> ''
);
$modversion['blocks'][5] = array(
	'file'			=> 'blocks.php',
	'name'			=> constant($const_prefix . '_BNAME_RECENT_TRACKBACKS'),
	'description'		=> constant($const_prefix . '_BDESC_RECENT_TRACKBACKS'),
	'show_func'		=> 'b_xigg_recent_trackbacks',
	'edit_func'		=> 'b_xigg_recent_trackbacks_edit',
	'options'		=> $module_dirname . '|6',
	'template'		=> ''
);
$modversion['blocks'][6] = array(
	'file'			=> 'blocks.php',
	'name'			=> constant($const_prefix . '_BNAME_RECENT_VOTES'),
	'description'		=> constant($const_prefix . '_BDESC_RECENT_VOTES'),
	'show_func'		=> 'b_xigg_recent_votes',
	'edit_func'		=> 'b_xigg_recent_votes_edit',
	'options'		=> $module_dirname . '|6',
	'template'		=> ''
);
$modversion['blocks'][7] = array(
	'file'			=> 'blocks.php',
	'name'			=> constant($const_prefix . '_BNAME_RECENT_NODES2'),
	'description'		=> constant($const_prefix . '_BDESC_RECENT_NODES2'),
	'show_func'		=> 'b_xigg_recent_nodes2',
	'edit_func'		=> 'b_xigg_recent_nodes2_edit',
	'options'		=> $module_dirname . '|6|5|1|1',
	'template'		=> ''
);

// Configs
$modversion['config'][1] = array(
	'name'			=> 'siteTitle',
	'title'		=> $const_prefix . '_C_SITETITLE',
	'description'		=> '',
	'formtype'		=> 'textbox',
	'valuetype'		=> 'text',
	'default'		=> $GLOBALS['xoopsConfig']['sitename']
);
$modversion['config'][2] = array(
	'name'			=> 'siteDescription',
	'title'		=> $const_prefix . '_C_SITEDESC',
	'description'		=> '',
	'formtype'		=> 'textarea',
	'valuetype'		=> 'text',
	'default'		=> $GLOBALS['xoopsConfig']['slogan']
);
$modversion['config'][3] = array(
	'name'			=> 'numberOfNodesOnTop',
	'title'		=> $const_prefix . '_C_NUMNODES',
	'description'		=> '',
	'formtype'		=> 'select',
	'valuetype'		=> 'int',
	'default'		=> 10,
	'options'       	=> array('3' => 3, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
);
$modversion['config'][4] = array(
	'name'			=> 'defaultNodesPeriod',
	'title'		=> $const_prefix . '_C_PERIOD',
	'description'		=> '',
	'formtype'		=> 'select',
	'valuetype'		=> 'text',
	'default'		=> 'new',
	'options'       	=> array(
                                constant($const_prefix . '_C_PERIOD_OPT1') => 'new',
	                         constant($const_prefix . '_C_PERIOD_OPT2') => 'day',
	                         constant($const_prefix . '_C_PERIOD_OPT3') => 'week',
	                         constant($const_prefix . '_C_PERIOD_OPT4') => 'month',
	                         constant($const_prefix . '_C_PERIOD_OPT5') => 'all',
	                         constant($const_prefix . '_C_PERIOD_OPT6') => 'comments',
	                         constant($const_prefix . '_C_PERIOD_OPT7') => 'active',)
);
$modversion['config'][5] = array(
	'name'			=> 'numberOfCommentsOnPage',
	'title'		=> $const_prefix . '_C_NUMCOMS',
	'description'		=> '',
	'formtype'		=> 'select',
	'valuetype'		=> 'int',
	'default'		=> 20,
	'options'       	=> array('10' => 10, '20' => 20, '30' => 30, '50' => 50)
);
$modversion['config'][6] = array(
	'name'			=> 'numberOfTrackbacksOnPage',
	'title'		=> $const_prefix . '_C_NUMTBS',
	'description'		=> '',
	'formtype'		=> 'select',
	'valuetype'		=> 'int',
	'default'		=> 20,
	'options'       	=> array('10' => 10, '20' => 20, '30' => 30, '50' => 50)
);
$modversion['config'][7] = array(
	'name'			=> 'numberOfVotesOnPage',
	'title'		=> $const_prefix . '_C_NUMVOTES',
	'description'		=> '',
	'formtype'		=> 'select',
	'valuetype'		=> 'int',
	'default'		=> 20,
	'options'       	=> array('10' => 10, '20' => 20, '30' => 30, '50' => 50)
);
$modversion['config'][8] = array(
	'name'			=> 'guestVotesAllowed',
	'title'		=> $const_prefix . '_C_GVOTEALLOWED',
	'description'		=> $const_prefix . '_C_GVOTEALLOWEDD',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 0
);
$modversion['config'][9] = array(
	'name'			=> 'guestCommentsAllowed',
	'title'		=> $const_prefix . '_C_GCOMALLOWED',
	'description'		=> $const_prefix . '_C_GCOMALLOWEDD',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 0
);
$modversion['config'][10] = array(
	'name'			=> 'userCommentEditTime',
	'title'		=> $const_prefix . '_C_UTIME',
	'description'		=> '',
	'formtype'		=> 'select',
	'valuetype'		=> 'int',
	'default'		=> 86400,
	'options'       	=> array(constant($const_prefix . '_C_UTIME_OPT1') => 0,
	                         constant($const_prefix . '_C_UTIME_OPT2') => 3600,
	                         constant($const_prefix . '_C_UTIME_OPT3') => 7200,
	                         constant($const_prefix . '_C_UTIME_OPT4') => 86400,
	                         constant($const_prefix . '_C_UTIME_OPT5') => 172800,
	                         constant($const_prefix . '_C_UTIME_OPT6') => 604800,
	                         constant($const_prefix . '_C_UTIME_OPT7') => 864000,
	                         constant($const_prefix . '_C_UTIME_OPT8') => 2592000)
);
$modversion['config'][11] = array(
	'name'			=> 'useUpcomingFeature',
	'title'		=> $const_prefix . '_C_UPCOMING',
	'description'		=> $const_prefix . '_C_UPCOMINGD',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 1
);
$modversion['config'][12] = array(
	'name'			=> 'useCommentFeature',
	'title'		=> $const_prefix . '_C_COMMENT',
	'description'		=> $const_prefix . '_C_COMMENTD',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 1
);
$modversion['config'][13] = array(
	'name'			=> 'useTrackbackFeature',
	'title'		=> $const_prefix . '_C_TBACK',
	'description'		=> $const_prefix . '_C_TBACKD',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 1
);
$modversion['config'][14] = array(
	'name'			=> 'useVotingFeature',
	'title'		=> $const_prefix . '_C_VOTING',
	'description'		=> $const_prefix . '_C_VOTINGD',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 1
);
$modversion['config'][15] = array(
	'name'			=> 'numberOfVotesForPopular',
	'title'		=> $const_prefix . '_C_NUMVPOP',
	'description'		=> '',
	'formtype'		=> 'select',
	'valuetype'		=> 'int',
	'default'		=> 10,
	'options'       => array('10' => 10, '20' => 20, '30' => 30, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000)
);
$modversion['config'][16] = array(
	'name'			=> 'toppageTitle',
	'title'		=> $const_prefix . '_C_TOPTITLE',
	'description'		=> '',
	'formtype'		=> 'textbox',
	'valuetype'		=> 'text',
	'default'		=> $modversion['name']
);
$modversion['config'][17] = array(
	'name'			=> 'homepageURL',
	'title'		=> $const_prefix . '_C_HPURL',
	'description'		=> '',
	'formtype'		=> 'textbox',
	'valuetype'		=> 'text',
	'default'		=> XOOPS_URL . '/'
);
$modversion['config'][18] = array(
	'name'			=> 'showNodeViewCount',
	'title'		=> $const_prefix . '_C_SHOWVC',
	'description'		=> '',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 1
);