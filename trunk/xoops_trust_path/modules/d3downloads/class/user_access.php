<?php

if( ! class_exists( 'user_access' ) )
{
	class user_access
	{
		var $db;
		var $table;
		var $cat_table;
		var $cat_ids;
		var $whr4cat;

		function user_access( $mydirname )
		{
			global $xoopsUser ;

			$this->db =& Database::getInstance();
			$this->mydirname = $mydirname ;
			$this->table = $this->db->prefix( "{$mydirname}_user_access" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$module_handler =& xoops_gethandler('module');
			$module =& $module_handler->getByDirname( $mydirname );
			if( is_object( $xoopsUser ) ) {
				$this->xoops_isuser = true ;
				$this->xoops_userid = $xoopsUser->getVar('uid') ;
				$mid = $module->getVar('mid') ;
				$this->xoops_isadmin = $xoopsUser->isAdmin( $mid ) ;
			} else {
				$this->xoops_isuser = false ;
				$this->xoops_userid = 0 ;
				$this->xoops_isadmin = false ;
			}
		}

		function permissions_of_current_user( $cid=0 )
		{
			if( empty( $cid ) ){
				$whr = $this->get_whr4cat() ;
				$sql = "SELECT * FROM ".$this->table." WHERE ( $whr ) GROUP BY cid" ;
				$result = $this->db->query( $sql ) ;
				if( $result ) while( $row = $this->db->fetchArray( $result ) ) {
					$ret[ $row['cid'] ] = $row ;
				}
				if( empty( $ret ) ) return array( 0 => array() ) ;
				else return $ret ;
			} else {
				return array(
					'can_read' => $this->can_read4cid( $cid ) ,
					'can_post' => $this->can_post4cid( $cid ) ,
					'can_edit' => $this->can_edit4cid( $cid ) ,
					'auto_approved' => $this->auto_approved4cid( $cid ) ,
					'edit_approved' => $this->edit_approved4cid( $cid ) ,
					'can_delete' => $this->can_delete4cid( $cid ) ,
					'can_html' => $this->can_html4cid( $cid ) ,
					'can_upload' => $this->can_upload4cid( $cid ) ,
				) ;
			}
		}

		function can_read4cid( $cid )
		{
			$whr_cat4read = "cid IN (".implode(",", $this->can_read() ).")" ;
			return $this->user_access_for_cat( $cid, $whr_cat4read ) ;
		}

		function can_post4cid( $cid )
		{
			$whr_cat4post = "cid IN (".implode(",", $this->can_post() ).")" ;
			return $this->user_access_for_cat( $cid, $whr_cat4post ) ;
		}

		function can_edit4cid( $cid, $whr='' )
		{
			if( $this->xoops_isadmin ) {
				return 1 ;
			} elseif( $this->xoops_isuser ){
				if( empty( $whr_cat4edit ) ) $whr = "cid IN (".implode(",", $this->can_edit() ).")" ;
				return $this->user_access_for_cat( $cid, $whr );
			} else {
				return 0;
			}
		}

		function auto_approved4cid( $cid )
		{
			if( $this->xoops_isadmin ) {
				return 1 ;
			} else {
				$whr_cat4approved = "cid IN (".implode(",", $this->auto_approved() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4approved ) ;
			}
		}

		function edit_approved4cid( $cid )
		{
			if( $this->xoops_isadmin ) {
				return 1 ;
			} elseif( $this->xoops_isuser ){
				$whr_cat4approved = "cid IN (".implode(",", $this->edit_approved() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4approved ) ;
			} else {
				return 0;
			}
		}

		function can_delete4cid( $cid )
		{
			if( $this->xoops_isadmin ) {
				return 1 ;
			} elseif( $this->xoops_isuser ){
				$whr_cat4delete = "cid IN (".implode(",", $this->can_delete() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4delete ) ;
			} else {
				return 0;
			}
		}

		function can_html4cid( $cid )
		{
			if( $this->xoops_isuser ){
				$whr_cat4html = "cid IN (".implode(",", $this->can_html() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4html );
			} else {
				return 0 ;
			}
		}

		function can_upload4cid( $cid )
		{
			if( $this->xoops_isadmin ) {
				return 1 ;
			} else {
				$whr_cat4upload = "cid IN (".implode(",", $this->can_upload() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4upload );
			}
		}

		function can_read( $permit=0 )
		{
			$whr4cat = $this->get_whr4cat( $permit );
			// get categories
			$sql = "SELECT distinct cid FROM ".$this->table." WHERE can_read ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql );
			if( empty( $cat_ids ) ) return array(0) ;
			else return $cat_ids ;
		}

		function can_post()
		{
			$whr4cat = $this->get_whr4cat();
			// get categories
			$sql = "SELECT distinct cid FROM ".$this->table." WHERE can_post ='1' AND  ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql );
			if( empty( $cat_ids ) ) return array(0) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function can_edit()
		{
			$whr4cat = $this->get_whr4cat();
			// get categories
			$sql = "SELECT distinct cid FROM ".$this->table." WHERE can_edit ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql );
			if( empty( $cat_ids ) ) return array(0) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function can_delete()
		{
			$whr4cat = $this->get_whr4cat();
			// get categories
			$sql = "SELECT distinct cid FROM ".$this->table." WHERE can_delete ='1' AND  ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql );
			if( empty( $cat_ids ) ) return array(0) ;
			else return $cat_ids ;
		}

		function auto_approved()
		{
			$whr4cat = $this->get_whr4cat();
			// get categories
			$sql = "SELECT distinct cid FROM ".$this->table." WHERE post_auto_approved ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql );
			if( empty( $cat_ids ) ) return array(0) ;
			else return $cat_ids ;
		}

		function edit_approved()
		{
			$whr4cat = $this->get_whr4cat();
			// get categories
			$sql = "SELECT distinct cid FROM ".$this->table." WHERE edit_auto_approved ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql );
			if( empty( $cat_ids ) ) return array(0) ;
			else return $cat_ids ;
		}

		function can_html()
		{
			$whr4cat = $this->get_whr4cat();
			// get categories
			$sql = "SELECT distinct cid FROM ".$this->table." WHERE html ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql );
			if( empty( $cat_ids ) ) return array(0) ;
			else return $cat_ids ;
		}

		function can_upload()
		{
			$whr4cat = $this->get_whr4cat();
			// get categories
			$sql = "SELECT distinct cid FROM ".$this->table." WHERE upload ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql );
			if( empty( $cat_ids ) ) return array(0) ;
			else return $cat_ids ;
		}

		function get_whr4cat( $permit=0 )
		{
			global $xoopsUser ;

			if( is_object( $xoopsUser ) ) {
				$groups = $xoopsUser->getGroups() ;
				if( ! empty( $groups ) ) {
					$whr4cat = "`uid`=$this->xoops_userid || `groupid` IN (".implode(",", $groups ).")" ;
				} else {
					$whr4cat = "`uid`=$this->xoops_userid" ;
				}
			} else {
				if ( empty( $permit ) ){
					$whr4cat = "`groupid`=".intval( XOOPS_GROUP_ANONYMOUS ) ;
				} else {
					$whr4cat = "`groupid`=".intval( XOOPS_GROUP_USERS ) ;
				}
			}
			return $whr4cat ;
		}

		function get_cat_ids( $sql )
		{
			include_once dirname( dirname(__FILE__ ) ).'/class/mytree.php' ;
			$mytree = new MyTree( $this->cat_table , "cid" , "pid" ) ;

			$result = $this->db->query( $sql ) ;
			if( $result ) while( list( $id ) = $this->db->fetchRow( $result ) ) {
				$cid =intval( $id ) ;
				// 閲覧権限のある親カテゴリを取得
				$crs = $this->db->query( "SELECT cid FROM ".$this->cat_table." WHERE cid=$cid AND pid = 0" ) ;
				if( $crs ) while( list( $id ) = $this->db->fetchRow( $crs ) ) {
					$cat_id = intval( $id )  ;
					$cat_ids[] = $cat_id ;
				}
				// 親カテゴリに閲覧権限がある場合のみ子カテゴリを取得
				$arr = $mytree->getChildTreeArray( $cat_id );
				foreach ( $arr as $child ) {
					$cat_ids[] = intval( $child['cid'] );
				}
			}
			if( empty( $cat_ids ) ) return array(0) ;
			else return $cat_ids ;
		}

		function user_access_for_cat( $cid, $whr )
		{
			$res = $this->db->query( "SELECT * FROM ".$this->cat_table." WHERE cid='".$cid."' AND ( $whr )" ) ;
			return $this->db->getRowsNum( $res ) ;
		}
	}
}

?>