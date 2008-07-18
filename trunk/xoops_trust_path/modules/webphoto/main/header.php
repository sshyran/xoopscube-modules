<?php
// $Id: header.php,v 1.2 2008/07/05 12:54:16 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-07-01 K.OHWADA
// added uri.php
//---------------------------------------------------------

if( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) die( 'not permit' ) ;

//---------------------------------------------------------
// xoops system files
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/class/template.php';

//---------------------------------------------------------
// webphoto files
//---------------------------------------------------------
webphoto_include_once( 'include/constants.php' );
webphoto_include_once( 'class/xoops/base.php' );
webphoto_include_once( 'class/inc/handler.php' );
webphoto_include_once( 'class/inc/config.php' );
webphoto_include_once( 'class/inc/group_permission.php' );
webphoto_include_once( 'class/inc/xoops_header.php' );
webphoto_include_once( 'class/d3/language.php' );
webphoto_include_once( 'class/d3/notification_select.php' );
webphoto_include_once( 'class/d3/preload.php' );
webphoto_include_once( 'class/lib/error.php' );
webphoto_include_once( 'class/lib/handler.php' );
webphoto_include_once( 'class/lib/tree_handler.php' );
webphoto_include_once( 'class/lib/post.php' );
webphoto_include_once( 'class/lib/pathinfo.php' );
webphoto_include_once( 'class/lib/highlight.php' );
webphoto_include_once( 'class/lib/pagenavi.php' );
webphoto_include_once( 'class/lib/utility.php' );
webphoto_include_once( 'class/lib/base.php' );
webphoto_include_once( 'class/lib/cloud.php' );
webphoto_include_once( 'class/lib/multibyte.php' );
webphoto_include_once( 'class/handler/photo_handler.php' );
webphoto_include_once( 'class/handler/cat_handler.php' );
webphoto_include_once( 'class/handler/tag_handler.php' );
webphoto_include_once( 'class/handler/p2t_handler.php' );
webphoto_include_once( 'class/handler/photo_tag_handler.php' );
webphoto_include_once( 'class/handler/gicon_handler.php' );
webphoto_include_once( 'class/webphoto/config.php' );
webphoto_include_once( 'class/webphoto/permission.php' );
webphoto_include_once( 'class/webphoto/uri.php' );
webphoto_include_once( 'class/webphoto/base_this.php' );
webphoto_include_once( 'class/webphoto/image_info.php' );
webphoto_include_once( 'class/webphoto/tag.php' );
webphoto_include_once( 'class/webphoto/gmap_info.php' );
webphoto_include_once( 'class/webphoto/gmap.php' );
webphoto_include_once( 'class/webphoto/photo_sort.php' );
webphoto_include_once( 'class/webphoto/show_photo.php' );
webphoto_include_once( 'class/webphoto/show_main.php' );
webphoto_include_once( 'class/webphoto/show_list.php' );

webphoto_include_language( 'modinfo.php' );
webphoto_include_language( 'main.php' );

webphoto_include_once_preload();

?>