<?php

if ( ! function_exists('d3download_getsub_categories') ) {
	function d3download_getsub_categories( $mydirname, $parent_id, $mytree, $whr_cat )
	{
		global $xoopsUser ;

		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_'.$parent_id.'_'.$site_salt.'.php' ;
		if( is_object( $xoopsUser ) || ! file_exists( XOOPS_TRUST_PATH.'/cache/' ) ) {
			$data = d3download_get_categories_data( $mydirname, $parent_id, $mytree, $whr_cat );
		} elseif ( file_exists( $cache ) ){
			$data = unserialize( join( '', file( $cache ) ) );
		} else {
			$data = d3download_get_categories_data( $mydirname, $parent_id, $mytree, $whr_cat );
			if ( $fp = @fopen( $cache, 'wb' ) )
			{
				fputs( $fp,serialize( $data ) );
				fclose( $fp );
			}
		}
		return $data ;
	}
}

if ( ! function_exists('d3download_get_categories_data') ) {
	function d3download_get_categories_data( $mydirname, $parent_id, $mytree, $whr_cat )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$ret = array() ;
		$result = $db->query("SELECT cid, title, imgurl FROM ".$db->prefix( $mydirname."_cat" )." WHERE pid = '".$parent_id."' AND ( $whr_cat ) ORDER BY cat_weight");
		while( list( $id , $title , $imgurl ) = $db->fetchRow( $result ) ) {
			$subcat = array() ;
			$cid = intval( $id );
			$arr = $mytree->getFirstChild( $cid, $whr_cat ) ;
			foreach( $arr as $child ) {
				$subcat[] = array(
					'cid' => intval( $child['cid'] ),
					'title' => $myts->makeTboxData4Show( $child['title'] ) ,
					'subcat_total' => d3download_small_sum_from_cat( $mydirname , intval( $child['cid'] ) , "visible = '1'" ) ,
					'number_of_subcat' => sizeof( $mytree->getFirstChildId( $child['cid'] , $whr_cat ) )
				) ;
			}

			// Category's banner default
			if( $imgurl == "http://" ) $imgurl = '' ;
			// Total sum of file
			$cids = $mytree->getAllChildId( $cid, $whr_cat ) ;
			array_push( $cids , $cid ) ;
			$bcat_total = d3download_total_sum_from_cat( $mydirname , $cids , "visible = '1'" ) ;
			$ret[] = array(
				'cid' => $cid ,
				'imgurl' => $myts->makeTboxData4Show( $imgurl ) ,
				'subcat_total' => d3download_small_sum_from_cat( $mydirname , $cid , "visible = '1'" ),
				'bcat_total' => $bcat_total ,
				'title' => $myts->makeTboxData4Show( $title ) ,
				'subcategories' => $subcat
			) ;
		}
		return $ret ;
	}
}

if ( ! function_exists('d3download_total_sum_from_cat') ) {
	function d3download_total_sum_from_cat( $mydirname, $cids, $whr_append = "" )
	{
		$db =& Database::getInstance() ;

		if( $whr_append ) $whr_append = "AND ( $whr_append )" ;

		$whr = "cid IN (" ;
		foreach( $cids as $cid ) {
			$whr .= "$cid," ;
		}
		$whr = "$whr 0)" ;

		$sql = "SELECT COUNT( lid ) FROM ".$db->prefix( $mydirname."_downloads" )." WHERE $whr $whr_append" ;
		$trs = $db->query( $sql ) ;
		list( $numrows ) = $db->fetchRow( $trs ) ;

		return $numrows ;
	}
}

if ( ! function_exists('d3download_small_sum_from_cat') ) {
	function d3download_small_sum_from_cat( $mydirname, $cid, $whr_append = "" )
	{
		$db =& Database::getInstance() ;

		if( $whr_append ) $whr_append = "AND ( $whr_append )" ;

		$sql = "SELECT COUNT( lid ) FROM ".$db->prefix( $mydirname."_downloads" )." WHERE cid='".$cid."' $whr_append" ;
		$trs = $db->query( $sql ) ;
		list( $numrows ) = $db->fetchRow( $trs ) ;

		return $numrows ;
	}
}

if ( ! function_exists('d3download_makecache_for_selbox') ) {
	function d3download_makecache_for_selbox( $mydirname, $mytree, $whr_cat, $cid=0, $sum=0 )
	{
		global $xoopsUser ;

		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_selbox_'.$site_salt.'.php' ;
		if( is_object( $xoopsUser ) || ! file_exists( XOOPS_TRUST_PATH.'/cache/' ) ) {
			$data = d3download_categories_selbox( $mydirname, $mytree, $whr_cat, $cid, $sum );
		} elseif ( file_exists( $cache ) ){
			$data = unserialize( join( '', file( $cache ) ) );
		} else {
			$data = d3download_categories_selbox( $mydirname, $mytree, $whr_cat, $cid, $sum );
			if ( $fp = @fopen( $cache, 'wb' ) )
			{
				fputs( $fp,serialize( $data ) );
				fclose( $fp );
			}
		}
		return $data ;
	}
}

if ( ! function_exists('d3download_categories_selbox') ) {
	function d3download_categories_selbox( $mydirname, $mytree, $whr_cat, $cid=0, $sum=0 )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$category = array();
		$sql = "SELECT cid, title FROM ".$db->prefix( $mydirname."_cat" )." WHERE ( $whr_cat )";
		if( ! empty( $cid ) ){
			$sql .= " AND cid='".$cid."'";
		} else {
			$sql .= " AND pid='0'";
		}
		$sql .= " ORDER BY cat_weight ASC";
		$crs = $db->query( $sql );
		while( list( $id, $name ) = $db->fetchRow( $crs ) ) {
			$catid = intval( $id );
			$category[ $catid ] = $myts->makeTboxData4Show( $name ) ;
			if( ! empty( $sum ) ){
				$category[ $catid ] .= "&nbsp;(".d3download_small_sum_from_cat( $mydirname, $catid, "visible = '1'" ).")" ;
			}
			$arr = $mytree->getChildTreeArray( $catid, $whr_cat );
			foreach ( $arr as $child ) {
				$child_id = intval( $child['cid'] );
				$child['prefix'] = str_replace( ".","--", $child['prefix'] );
				$category[$child_id] = $child['prefix']."&nbsp;".$myts->makeTboxData4Show( $child['title'] );
				if( ! empty( $sum ) ){
					$category[$child_id] .= "&nbsp;(".d3download_small_sum_from_cat( $mydirname , $child_id , "visible = '1'" ).")";
				}
			}
		}
		return $category ;
	}
}

if ( ! function_exists('d3download_delete_cache_of_categories') ) {
	function d3download_delete_cache_of_categories( $mydirname )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mytree.php' ;

		$db =& Database::getInstance() ;
		$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;

		$cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_0_'.$site_salt.'.php' ;
		if( file_exists( $cache ) ) @unlink( $cache ) ;
		$topview_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_topview_'.$site_salt.'.php' ;
		if( file_exists( $topview_cache ) ) @unlink( $topview_cache ) ;
		$selbox_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_selbox_'.$site_salt.'.php' ;
		if( file_exists( $selbox_cache ) ) @unlink( $selbox_cache ) ;
		$sql = "SELECT cid FROM ".$db->prefix( $mydirname."_cat" )." WHERE pid='0'";
		$crs = $db->query( $sql );
		while( list( $cid ) = $db->fetchRow( $crs ) ) {
			$catid = intval( $cid );
			$parent_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_'.$catid.'_'.$site_salt.'.php' ;
			if( file_exists( $parent_cache ) ) @unlink( $parent_cache ) ;
			$arr = $mytree->getChildTreeArray( $catid );
			foreach ( $arr as $child ) {
				$child_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_'.intval( $child['cid'] ).'_'.$site_salt.'.php' ;
				if( file_exists( $child_cache ) ) @unlink( $child_cache ) ;
			}
		}
	}
}

if ( ! function_exists('d3download_delete_topview_cache') ) {
	function d3download_delete_topview_cache( $mydirname )
	{
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$topview_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_topview_'.$site_salt.'.php' ;
		if( file_exists( $topview_cache ) ) @unlink( $topview_cache ) ;
	}
}

if ( ! function_exists('d3download_categories_for_edit') ) {
	function d3download_categories_for_edit( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mytree.php' ;
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
		$maincategory = array( 0 => '------' ) ;
		$result = $db->query("SELECT cid, title  FROM ".$db->prefix( $mydirname."_cat" )." WHERE pid='0' AND cid NOT IN ( '".$cid."' ) ORDER BY cat_weight");
		while( list( $id, $name ) = $db->fetchRow( $result ) ) {
			$catid = intval( $id );
			$maincategory[ $catid ] = $myts->makeTboxData4Edit( $name ) ;
			$arr = $mytree->getChildTreeArray( $catid );
			foreach ( $arr as $child ) {
				$child_id = intval( $child['cid'] );
				if( $child_id != $cid ){
					$child['prefix'] = str_replace(".","--",$child['prefix']);
					$maincategory[ $child_id ] = $child['prefix']."&nbsp;".$myts->makeTboxData4Edit( $child['title'] );
				}
			}
		}
		return $maincategory ;
	}
}

if ( ! function_exists('d3download_get_title') ) {
	function d3download_get_title( $mydirname, $lid, $whr )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname, $whr, $lid ) ;
		if( ! $mydownload->return_lid() ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , _MD_D3DOWNLOADS_NOMATCH ) ;
			exit ;
		} else {
			return array(
				'lid' => $mydownload->return_lid() ,
				'cid' => $mydownload->return_cid() ,
				'title' => $mydownload->return_title('Show') ,
			) ;
		}
	}
}

if ( ! function_exists('d3download_items_perpage') ) {
	function d3download_items_perpage()
	{
		return array(
			'5'  => '5' ,
			'10' => '10' ,
			'15' => '15' ,
			'20' => '20' ,
			'25' => '25' ,
			'30' => '30' ,
			'50' => '50'
		) ;
	}
}

//updates rating data in itemtable for a given item
if ( ! function_exists('d3download_updaterating') ) {
	function d3download_updaterating( $mydirname, $sel_id )
	{
		$db =& Database::getInstance() ;

		$query = "select rating FROM ".$db->prefix( $mydirname."_votedata" )." WHERE lid = ".$sel_id."";
		$voteresult = $db->query( $query );
		$votesDB = $db->getRowsNum( $voteresult );
		$totalrating = 0;
		while(list( $rating )=$db->fetchRow( $voteresult ) ){
			$totalrating += $rating;
		}
		if( ! empty( $votesDB ) ){
			$finalrating = $totalrating/$votesDB;
		} else {
			$finalrating = 0 ;
		}
		$finalrating = number_format( $finalrating, 4 );
		$sql = sprintf("UPDATE %s SET rating = %u, votes = %u WHERE lid = %u", $db->prefix( $mydirname."_downloads" ), $finalrating, $votesDB, $sel_id);
		$db->query( $sql );
	}
}

if ( ! function_exists('d3download_convertorderbyin') ) {
	function d3download_convertorderbyin( $orderby )
	{
		switch ( $orderby ) {
		case "titleA":
			$orderby = "d.title ASC";
			break;
		case "dateA":
			$orderby = "d.date ASC";
			break;
		case "hitsA":
			$orderby = "d.hits ASC";
			break;
		case "ratingA":
			$orderby = "d.rating ASC";
			break;
		case "titleD":
			$orderby = "d.title DESC";
			break;
		case "hitsD":
			$orderby = "d.hits DESC";
			break;
		case "ratingD":
			$orderby = "d.rating DESC";
			break;
		case"dateD":
		default:
			$orderby = "d.date DESC";
			break;
		}
		return $orderby;
	}
}

if ( ! function_exists('d3download_convertorderbytrans') ) {
	function d3download_convertorderbytrans( $orderby )
	{
		if ($orderby == "d.hits ASC")   $orderbyTrans = _MD_D3DOWNLOADS_POPULARITYLTOM;
		if ($orderby == "d.hits DESC")    $orderbyTrans = _MD_D3DOWNLOADS_POPULARITYMTOL;
		if ($orderby == "d.title ASC")    $orderbyTrans = _MD_D3DOWNLOADS_TITLEATOZ;
		if ($orderby == "d.title DESC")   $orderbyTrans = _MD_D3DOWNLOADS_TITLEZTOA;
		if ($orderby == "d.date ASC") $orderbyTrans = _MD_D3DOWNLOADS_DATEOLD;
		if ($orderby == "d.date DESC")   $orderbyTrans = _MD_D3DOWNLOADS_DATENEW;
		if ($orderby == "d.rating ASC")  $orderbyTrans = _MD_D3DOWNLOADS_RATINGLTOH;
		if ($orderby == "d.rating DESC") $orderbyTrans = _MD_D3DOWNLOADS_RATINGHTOL;
		return $orderbyTrans;
	}
}

if ( ! function_exists('d3download_convertorderbyout') ) {
	function d3download_convertorderbyout( $orderby )
	{
		if ($orderby == "d.title ASC")            $orderby = "titleA";
		if ($orderby == "d.date ASC")            $orderby = "dateA";
		if ($orderby == "d.hits ASC")          $orderby = "hitsA";
		if ($orderby == "d.rating ASC")        $orderby = "ratingA";
		if ($orderby == "d.title DESC")              $orderby = "titleD";
		if ($orderby == "d.date DESC")            $orderby = "dateD";
		if ($orderby == "d.hits DESC")          $orderby = "hitsD";
		if ($orderby == "d.rating DESC")        $orderby = "ratingD";
		return $orderby;
	}
}

if ( ! function_exists('d3download_shots_dir') ) {
	function d3download_shots_dir( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		$cate_shotsdir = $mycategory->return_shotsdir() ;
		if( !empty( $cate_shotsdir ) && file_exists( XOOPS_ROOT_PATH.'/'.$cate_shotsdir ) ){
			$shots_dir = XOOPS_ROOT_PATH.'/'.$cate_shotsdir;
		} else {
			$shots_dir = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/images/shots/';
		}
		return $shots_dir ;
	}
}

if ( ! function_exists('d3download_shots_img_ar') ) {
	function d3download_shots_img_ar( $mydirname, $shots_dir )
	{
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

		$myalbum_dirname = htmlspecialchars( $mod_config['albumselect'] , ENT_QUOTES );

		$usealbum = d3download_can_albumselect( $mydirname  );
		if( ! empty( $usealbum ) ){
			$img_ar = d3download_get_album_list( $myalbum_dirname );
		} else {
			$img_ar = array();
			$downimg_array = d3download_getimglist( $shots_dir );
			$img_ar[' '] = '------';
			foreach ( $downimg_array as $image ) {
				$img_ar[$image] = $image;
			}
		}
		return $img_ar ;
	}
}

if ( ! function_exists('d3download_getimglist') ) {
	function d3download_getimglist( $dirname, $prefix='' )
	{
		$filelist = array();
		if ( $handle = opendir( $dirname ) ) {
			while ( false !== ( $file = readdir( $handle ) ) ) {
				if ( ! preg_match( "/^[\.]{1,2}$/", $file ) && preg_match( "/(\.gif|\.jpe?g|\.png)$/i",$file ) ) {
					$file = $prefix.$file;
					$filelist[$file]=$file;
				}
			}
			closedir( $handle );
			asort( $filelist );
			reset( $filelist );
		}
		return $filelist;
	}
}

if ( ! function_exists('d3download_can_albumselect') ) {
	function d3download_can_albumselect( $mydirname, $myalbum_dirname='' )
	{
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

		if( empty( $myalbum_dirname ) ){
			$myalbum_dirname = htmlspecialchars( $mod_config['albumselect'] , ENT_QUOTES );
		}
		$usealbum = 0;
		if( ! empty( $mod_config['usealbum'] )  && ! empty( $mod_config['albumselect'] ) ){
			$myalbm_path = XOOPS_ROOT_PATH .'/modules/'.$myalbum_dirname ;
			$usealbum = file_exists( $myalbm_path ) ? 1 : 0 ;
		}
		return $usealbum;
	}
}

if ( ! function_exists('d3download_get_album_list') ) {
	function d3download_get_album_list( $myalbum_dirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$myalbm_path = XOOPS_ROOT_PATH .'/modules/'.$myalbum_dirname ;
		include $myalbm_path .'/include/read_configs.php';

		$album_list = array();
		$album_list[0] = '------';
		$ars = $db->query( "SELECT lid, title FROM $table_photos WHERE status > 0 ORDER BY lid DESC" );
		while( list( $id, $name ) = $db->fetchRow( $ars ) ) {
			$album_list[ $id ] = sprintf('%06d',$id).': '.$myts->makeTboxData4Show( $name ) ;
		}
		return $album_list ;
	}
}

if ( ! function_exists('d3download_select_platform') ) {
	function d3download_select_platform( $mydirname )
	{
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

		$normal_platform = array( 'Windows' , 'Unix' , 'Mac' , 'Xoops 2.0x' , 'XOOPS Cube Legacy 2.1x' ) ;
		if( empty( $mod_config['select_platform'] ) ) {
			$platform_array = $normal_platform ;
		} else {
			$platform_array = explode( '|' , htmlspecialchars( $mod_config['select_platform'] , ENT_QUOTES ) );
		}
		$select_platform = array();
		$select_platform[''] = '------';
		foreach ( $platform_array as $platform ) {
			$select_platform[$platform] = $platform;
		}
		return $select_platform ;
	}
}

if ( ! function_exists('d3download_delcat') ) {
	function d3download_delcat( $mydirname, $cid, $errors )
	{
		$db =& Database::getInstance() ;
		include_once dirname(dirname(__FILE__)).'/class/mytree.php' ;

		$mytree = new MyTree($db->prefix( $mydirname."_cat" ),"cid","pid");
		$module_handler =& xoops_gethandler('module');
		$xoopsModule =& $module_handler->getByDirname( $mydirname );
		$mid =& $xoopsModule->getVar('mid');
		$children = $mytree->getAllChildId( $cid ) ;
		$whr = "cid IN (" ;
		foreach( $children as $child ) {
			$whr .= "$child," ;
			xoops_notification_deletebyitem( $mid , 'cat' , $child ) ;
		}
		$whr .= "$cid)" ;
		xoops_notification_deletebyitem( $mid, 'category', $cid ) ;
		d3download_delete_contents( $mydirname , $whr, $cid );
		d3download_delete_cache_of_categories( $mydirname ) ;
		$db->query( "DELETE FROM ".$db->prefix( $mydirname."_cat")." WHERE $whr" ) or die( "DB error: DELETE cat table" ) ;
	}
}

if ( ! function_exists('d3download_delete_contents') ) {
	function d3download_delete_contents( $mydirname, $whr, $cid )
	{
		$db =& Database::getInstance() ;
		$res = $db->query("SELECT lid, filename, submitter FROM ".$db->prefix( $mydirname."_downloads")." WHERE $whr" ) ;
		while( list( $id, $fname, $submit ) = $db->fetchRow( $res ) ) 
		{
			$lid = intval( $id ) ;
			$filename = htmlspecialchars( $fname , ENT_QUOTES ) ;
			$submitter = intval( $submit ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_broken")." WHERE lid=$lid" ) or die( "DB error: DELETE broken table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_downloads")." WHERE lid=$lid" ) or die( "DB error: DELETE downloads table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_downloads_history")." WHERE lid=$lid" ) or die( "DB error: DELETE downloads_history table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_votedata")." WHERE lid=$lid" ) or die( "DB error: DELETE votedata table." ) ;
			if( ! empty( $filename ) ){
				d3download_delete_uploadfiles( $mydirname , $lid, $submitter );
			}
		}

		$urs = $db->query("SELECT cid FROM ".$db->prefix( $mydirname."_user_access")." WHERE cid=$cid" ) ;
		while( list( $delete_id ) = $db->fetchRow( $urs ) ) 
		{
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_user_access")." WHERE cid=$delete_id" ) or die( "DB error: DELETE broken table." ) ;
		}
	}
}

if ( ! function_exists('d3download_delete_lid') ) {
	function d3download_delete_lid( $mydirname, $lid )
	{
		$db =& Database::getInstance() ;

		$res = $db->query("SELECT lid, filename, submitter FROM ".$db->prefix( $mydirname."_downloads")." WHERE lid=$lid" ) ;
		while( list( $id, $fname, $submit ) = $db->fetchRow( $res ) ) 
		{
			$filename = htmlspecialchars( $fname , ENT_QUOTES ) ;
			$submitter = intval( $submit ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_downloads")." WHERE lid=$id" ) or die( "DB error: DELETE downloads table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_broken")." WHERE lid=$id" ) or die( "DB error: DELETE broken table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_downloads_history")." WHERE lid=$id" ) or die( "DB error: DELETE downloads_history table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_votedata")." WHERE lid=$id" ) or die( "DB error: DELETE votedata table." ) ;
		}
		if( ! empty( $filename ) ){
			d3download_delete_uploadfiles( $mydirname, $lid, $submitter );
		}
		d3download_delete_cache_of_categories( $mydirname ) ;
	}
}

if ( ! function_exists('d3download_delete_uploadfiles') ) {
	function d3download_delete_uploadfiles( $mydirname , $lid, $submitter )
	{
		$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$target_name = $lid.'_'.$site_salt.'_'.$submitter ;
		if( $handler = @opendir( $uploads_dir . '/' ) ) {
			while( ( $file = readdir( $handler ) ) !== false ) {
				$file_path = $uploads_dir . '/' . $file ;
				if ( is_file( $file_path ) && strstr( $file , $target_name ) ){
					@unlink( $file_path ) or die("File delete error ". $file );
				}
			}
		}
		closedir( $handler ) ;
	}
}

if ( ! function_exists('d3download_delete_unapproval_files') ) {
	function d3download_delete_unapproval_files( $mydirname, $id )
	{
		$db =& Database::getInstance() ;

		$frs = $db->query("SELECT url, filename FROM ".$db->prefix( $mydirname."_unapproval" )."  WHERE requestid='".$id."'");
		while( list( $url, $filename ) = $db->fetchRow( $frs ) ) {
			if ( ! empty( $filename ) && file_exists( $url ) ){
				@unlink( $url ) or die("File delete error ". $url );
			}
		}
	}
}

if ( ! function_exists('d3download_delete_history') ) {
	function d3download_delete_history( $mydirname, $lid )
	{
		$db =& Database::getInstance() ;

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

		$hsum = $db->getRowsNum( $db->query( "SELECT * FROM ".$db->prefix( $mydirname."_downloads_history" )." WHERE lid='".$lid."'" ) );
		if( $hsum > $mod_config['history'] ){
			$delsum = $hsum - $mod_config['history'];
			$hrs = $db->query( "SELECT id, url FROM ".$db->prefix( $mydirname."_downloads_history")." WHERE lid='".$lid."' ORDER BY id", $delsum, 0 );
			while( list( $id, $url ) = $db->fetchRow( $hrs ) ) 
			{
				$hid = intval( $id );
				$sql = "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_downloads" )." WHERE url='".$url."'";
				list( $fcont ) = $db->fetchRow( $db->query( $sql ) );
				$hql = "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_downloads_history" )." WHERE id NOT IN ( '".$hid."' ) AND  url='".$url."'";
				list( $hcont ) = $db->fetchRow( $db->query( $hql ) );
				if( empty( $fcont ) && empty( $hcont ) ){
					if ( ! preg_match("/^(https?|ftp):\/\//", $url )  && file_exists( $url ) ) {
						@unlink( $url ) or die("File delete error ". $url );
					}
				}
				$db->query("DELETE FROM ".$db->prefix( $mydirname."_downloads_history" )." WHERE id = '".$hid."'" ) or die( "DB error: DELETE downloads_history table." ) ;
			}
		}
	}
}

if ( ! function_exists('d3download_submit_message') ) {
	function d3download_submit_message( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		$submit_message = $mycategory->return_submit_message() ;
		if( ! empty( $submit_message ) ){
			return $submit_message ;
		} else {
			return '' ;
		}
	}
}

if ( ! function_exists('d3download_get_broken_data') ) {
	function d3download_get_broken_data( $mydirname, $lid )
	{
		$db =& Database::getInstance() ;

		$broken = array();
		$brs = $db->query("SELECT reportid, sender, ip FROM ".$db->prefix( $mydirname."_broken" )." WHERE lid = '".$lid."' ORDER BY reportid DESC");
		$broken_sum = $db->getRowsNum( $brs );
		$totalbroken = ! empty( $broken_sum ) ?  intval( $broken_sum ) : 0 ;
		$total_broken4assign = sprintf( _MD_D3DOWNLOADS_TOTAL_BROKEN , $totalbroken );
		while( list( $bid, $sen, $ip )=$db->fetchRow( $brs ) ) {
			$sender = intval( $sen );
			$sendername = d3download_postname( $sender );
			if ( $sender > 0 ) {
				$sender_url = XOOPS_URL."/userinfo.php?uid=$sender";
			} else {
				$sender_url = "";
			}
			$broken[] = array(
				'id' => intval( $bid ) ,
				'sendername' => $sendername ,
				'sender_url' => $sender_url ,
				'ip' => htmlspecialchars( $ip , ENT_QUOTES ) ,
			) ;
		}
		return array(
			'totalbroken' => $totalbroken ,
			'total_broken4assign' => $total_broken4assign ,
			'broken' => $broken ,
		) ;
	}
}

if ( ! function_exists('d3download_get_user_vote') ) {
	function d3download_get_user_vote( $mydirname, $lid )
	{
		$db =& Database::getInstance() ;

		$user_vote = array();
		$urs = $db->query("SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp FROM ".$db->prefix( $mydirname."_votedata" )." WHERE lid = $lid AND ratinguser != 0 ORDER BY ratingtimestamp DESC");
		$user_votes = $db->getRowsNum( $urs );
		$user_totalvote = sprintf( _MD_D3DOWNLOADS_USER_TOTAL_VOTE , $user_votes );
		while( list( $id, $uid, $rat, $hostname, $timestamp )=$db->fetchRow( $urs ) ) {
			$formatted_date = formatTimestamp( intval( $timestamp ) );
			$ratinguser = intval( $uid );
			$usr = $db->query("SELECT rating FROM ".$db->prefix( $mydirname."_votedata" )." WHERE ratinguser = $ratinguser" );
			$uservotes = $db->getRowsNum( $usr );
			$useravgrating = 0;
			while(list( $user_rating ) = $db->fetchRow( $usr ) ){
				$useravgrating = $useravgrating + $user_rating;
			}
			$useravgrating = $useravgrating / $uservotes;
			$useravgrating = number_format( $useravgrating, 1 );
			$ratingusername = d3download_postname( $ratinguser );
			$ratinguserurl = XOOPS_URL."/userinfo.php?uid=$ratinguser";
			$user_vote[] = array(
				'id' => intval( $id ) ,
				'ratingusername' => $ratingusername ,
				'ratinguserurl' => $ratinguserurl ,
				'ratinghostname' => htmlspecialchars( $hostname , ENT_QUOTES ) ,
				'rating' => intval( $rat ) ,
				'useravgrating' => intval( $useravgrating ) ,
				'uservotes' => intval( $uservotes ) ,
				'ratingtimestamp' => $formatted_date ,
			) ;
		}
		return array(
			'user_totalvote' => $user_totalvote ,
			'user_vote' => $user_vote ,
		) ;
	}
}

if ( ! function_exists('d3download_get_guest_vote') ) {
	function d3download_get_guest_vote( $mydirname, $lid )
	{
		$db =& Database::getInstance() ;

		$guest_vote = array();
		$gre = $db->query("SELECT ratingid, rating, ratinghostname, ratingtimestamp FROM ".$db->prefix( $mydirname."_votedata" )." WHERE lid = $lid AND ratinguser = '0' ORDER BY ratingtimestamp DESC");
		$guest_votes = $db->getRowsNum( $gre );
		$guest_totalvote = sprintf( _MD_D3DOWNLOADS_GUEST_TOTAL_VOTE , $guest_votes );
		while( list( $gid, $grating, $ghostname, $gtimestamp ) = $db->fetchRow( $gre ) ) {
    		$formatted_date = formatTimestamp( $gtimestamp );
			$guest_vote[] = array(
				'id' => intval( $gid ) ,
				'ratinghostname' => htmlspecialchars( $ghostname , ENT_QUOTES ) ,
				'rating' => intval( $grating ) ,
				'guestvote' => intval( $guest_votes ) ,
				'ratingtimestamp' => $formatted_date ,
			) ;
		}
		return array(
			'guest_totalvote' => $guest_totalvote ,
			'guest_vote' => $guest_vote ,
		) ;
	}
}

if ( ! function_exists('d3download_use_htmlpurifierl') ) {
	function d3download_use_htmlpurifierl( $mydirname )
	{
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar('mid') );

		if( ! empty( $mod_config['use_htmlpurifier'] ) ) {
			$use_htmlpurifierl = 1 ;
		} else {
			$use_htmlpurifierl = 0 ;
		}
		return $use_htmlpurifierl ;
	}
}

if ( ! function_exists('d3download_postname') ) {
	function d3download_postname( $submitter )
	{
		if ( $submitter > 0 ) {
			$member_handler =& xoops_gethandler( 'member' );
			$member =& $member_handler->getUser( $submitter );
			if ( $member ) {
				$postname = $member->getvar('name');
				if ( ! $postname ) {
					$postname = $member->getvar('uname');
				}
			}
		} else {
			global $xoopsConfig;
			$postname = $xoopsConfig['anonymous'];
		}
		return $postname ;
	}
}

if ( ! function_exists('d3download_can_read') ) {
	function d3download_can_read( $mydirname )
	{
		include_once dirname(dirname(__FILE__)).'/class/user_access.php' ;
		$user_access = new user_access( $mydirname ) ;
		return $user_access->can_read() ;
	}
}

// trigger event for D3
if ( ! function_exists('d3download_main_trigger_event') ) {
	function d3download_main_trigger_event( $category , $item_id, $event, $extra_tags=array(), $user_list=array(), $omit_user_id=null )
	{
		global $xoopsModule , $xoopsConfig , $mydirname , $mydirpath , $mytrustdirname , $mytrustdirpath ;

		$notification_handler =& xoops_gethandler('notification') ;

		$mid = $xoopsModule->getVar('mid') ;

		// language file
		$language = empty( $xoopsConfig['language'] ) ? 'english' : $xoopsConfig['language'] ;
		if( file_exists( "$mydirpath/language/$language/mail_template/" ) ) {
			// user customized language file
			$mail_template_dir = "$mydirpath/language/$language/mail_template/" ;
		} else if( file_exists( "$mytrustdirpath/language/$language/mail_template/" ) ) {
			// default language file
			$mail_template_dir = "$mytrustdirpath/language/$language/mail_template/";
		} else {
			// fallback english
			$mail_template_dir = "$mytrustdirpath/language/english/mail_template/";
		}

		// Check if event is enabled
		$config_handler =& xoops_gethandler('config');
		$mod_config =& $config_handler->getConfigsByCat(0,$mid);
		if (empty($mod_config['notification_enabled'])) {
			return false;
		}
		$category_info =& notificationCategoryInfo ( $category, $mid );
		$event_info =& notificationEventInfo ($category, $event, $mid);
		if (!in_array(notificationGenerateConfig($category_info,$event_info,'option_name'),$mod_config['notification_events']) && empty($event_info['invisible'])) {
			return false;
		}

		if (!isset($omit_user_id)) {
			global $xoopsUser;
			if (!empty($xoopsUser)) {
				$omit_user_id = $xoopsUser->getVar('uid');
			} else {
				$omit_user_id = 0;
			}
		}
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('not_modid', intval($mid)));
		$criteria->add(new Criteria('not_category', $category));
		$criteria->add(new Criteria('not_itemid', intval($item_id)));
		$criteria->add(new Criteria('not_event', $event));
		$mode_criteria = new CriteriaCompo();
		$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDALWAYS), 'OR');
		$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE), 'OR');
		$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT), 'OR');
		$criteria->add($mode_criteria);
		if (!empty($user_list)) {
			$user_criteria = new CriteriaCompo();
			foreach ($user_list as $user) {
				$user_criteria->add (new Criteria('not_uid', $user), 'OR');
			}
			$criteria->add($user_criteria);
		}
		$notifications =& $notification_handler->getObjects($criteria);
		if (empty($notifications)) {
			return;
		}

		// Add some tag substitutions here
		$tags = array();
		// {X_ITEM_NAME} {X_ITEM_URL} {X_ITEM_TYPE} from lookup_func are disabled
		$tags['X_MODULE'] = $xoopsModule->getVar('name','n');
		$tags['X_MODULE_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/';
		$tags['X_NOTIFY_CATEGORY'] = $category;
		$tags['X_NOTIFY_EVENT'] = $event;

		$template = $event_info['mail_template'] . '.tpl';
		$subject = $event_info['mail_subject'];

		foreach ($notifications as $notification) {
			if (empty($omit_user_id) || $notification->getVar('not_uid') != $omit_user_id) {
				// user-specific tags
				//$tags['X_UNSUBSCRIBE_URL'] = 'TODO';
				// TODO: don't show unsubscribe link if it is 'one-time' ??
				$tags['X_UNSUBSCRIBE_URL'] = XOOPS_URL . '/notifications.php';
				$tags = array_merge ($tags, $extra_tags);

				$notification->notifyUser($mail_template_dir, $template, $subject, $tags);
			}
		}
	}
}

if ( ! function_exists('d3download_submenu') ) {
	function d3download_submenu( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$user_access = new user_access( $mydirname ) ;
		$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
		$categories = array( 0 => array( 'name' => '' , 'url' => '' , 'sub' => array() ) ) ;
		$sql = "SELECT cid, pid, title FROM ".$db->prefix( $mydirname."_cat" )." WHERE ( $whr_cat ) AND pid = '0' ORDER BY cat_weight" ;
		$crs = $db->query( $sql ) ;
		if( ! empty( $crs ) ){
			while( $myrow = $db->fetchArray( $crs ) ) {
				$cid = intval( $myrow['cid'] ) ;
				$categories['sub'][] = array(
					'name' => $myts->makeTboxData4Show( $myrow['title'] ) ,
					'url' => 'index.php?cid='.$cid ,
				);
			}
		}
		if( ! empty( $categories['sub'] ) ){
			return $categories['sub'];
		} else {
			return '';
		}
	}
}

if ( ! function_exists('d3download_dbmoduleheader') ) {
	function d3download_dbmoduleheader( $mydirname )
	{
		$css_name = XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=main_css' ;
		$header = '<link rel="stylesheet" type="text/css" media="all" href="'.$css_name.'" />' ;
		return $header ;
	}
}

if ( ! function_exists('d3download_dbmoduleheader_for_livevalidation') ) {
	function d3download_dbmoduleheader_for_livevalidation( $mydirname )
	{
		$css_name = XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=validation_css' ;
		$css_header = '<link rel="stylesheet" type="text/css" media="all" href="'.$css_name.'" />' ;

		$js_name = XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=validation_js' ;
		$js_module_header = '<script type="text/javascript" src="'.$js_name.'"></script>';
		$header = $css_header . "\n" . $js_module_header ;

		return $header ;
	}
}

if ( ! function_exists('d3download_delete_livevalidation') ) {
	function d3download_delete_livevalidation()
	{
		$js_path = XOOPS_ROOT_PATH.'/cache/livevalidation.js' ;
		if ( file_exists( $js_path ) ){
			@unlink( $js_path );
		}
	}
}

if ( ! function_exists('d3download_pathstring') ) {
	function d3download_pathstring( $mytree, $cid, $whr )
	{
		$pathstring = "<a href='index.php'>"._MD_D3DOWNLOADS_MAIN."</a>&nbsp;:&nbsp;";
		$pathstring .= $mytree->getNicePathFromId( $cid, "title", $whr, "index.php?" );
		return $pathstring ;
	}
}

if ( ! function_exists('d3download_breadcrumbs') ) {
	function d3download_breadcrumbs( $mydirname )
	{
		$module_handler =& xoops_gethandler('module');
		$xoopsModule =& $module_handler->getByDirname( $mydirname );
		return array( 'url' => XOOPS_URL.'/modules/'.$mydirname.'/index.php' , 'name' => $xoopsModule->getVar( 'name' ) ) ;
	}
}

if ( ! function_exists('d3download_delete_nullbyte') ) {
	function d3download_delete_nullbyte( $arr )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		return $myts->Delete_Nullbyte( $arr ) ;
	}
}

?>