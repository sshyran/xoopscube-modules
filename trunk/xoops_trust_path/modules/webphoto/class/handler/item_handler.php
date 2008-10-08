<?php
// $Id: item_handler.php,v 1.2 2008/08/27 06:45:16 ohwada Exp $

//=========================================================
// webphoto module
// 2008-08-24 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_item_handler
//=========================================================
class webphoto_item_handler extends webphoto_lib_handler
{
	var $_AREA_NS = 1.0;
	var $_AREA_EW = 1.0;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_item_handler( $dirname )
{
	$this->webphoto_lib_handler( $dirname );
	$this->set_table_prefix_dirname( 'item' );
	$this->set_id_name( 'item_id' );

	$constpref = strtoupper( '_P_' . $dirname. '_' ) ;
	$this->set_debug_sql_by_const_name(   $constpref.'DEBUG_SQL' );
	$this->set_debug_error_by_const_name( $constpref.'DEBUG_ERROR' );

}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_item_handler( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// create
//---------------------------------------------------------
function create( $flag_new=false )
{
	$time_create = 0;
	$time_update = 0;

	if ( $flag_new ) {
		$time = time();
		$time_create = $time;
		$time_update = $time;
	}

	$arr = array(
		'item_id'             => 0,
		'item_time_create'    => $time_create,
		'item_time_update'    => $time_update,
		'item_cat_id'         => 0,
		'item_gicon_id'       => 0,
		'item_uid'            => 0,
		'item_kind'           => 0,
		'item_ext'            => '',
		'item_datetime'       => '0000-00-00 00:00:00',
		'item_title'          => '',
		'item_place'          => '',
		'item_equipment'      => '',
		'item_gmap_latitude'  => 0,
		'item_gmap_longitude' => 0,
		'item_gmap_zoom'      => 0,
		'item_gmap_type'      => 0,
		'item_perm_read'      => '*',
		'item_status'         => 0,
		'item_hits'           => 0,
		'item_rating'         => 0,
		'item_votes'          => 0,
		'item_comments'       => 0,
		'item_exif'           => '',
		'item_description'    => '',
		'item_search'         => '',
	);

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_FILE_ID; $i++ ) {
		$arr[ 'item_file_id_'.$i ] = '';
	}

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_TEXT; $i++ ) {
		$arr[ 'item_text_'.$i ] = '';
	}

	return $arr;
}

//---------------------------------------------------------
// insert
//---------------------------------------------------------
function insert( $row, $force=false )
{
	extract( $row ) ;

	$sql  = 'INSERT INTO '.$this->_table.' (';

	if ( $item_id > 0 ) {
		$sql .= 'item_id, ';
	}

	$sql .= 'item_time_create, ';
	$sql .= 'item_time_update, ';
	$sql .= 'item_cat_id, ';
	$sql .= 'item_gicon_id, ';
	$sql .= 'item_uid, ';
	$sql .= 'item_kind, ';
	$sql .= 'item_ext, ';
	$sql .= 'item_datetime, ';
	$sql .= 'item_title, ';
	$sql .= 'item_place, ';
	$sql .= 'item_equipment, ';
	$sql .= 'item_gmap_latitude, ';
	$sql .= 'item_gmap_longitude, ';
	$sql .= 'item_gmap_zoom, ';
	$sql .= 'item_gmap_type, ';
	$sql .= 'item_perm_read, ';
	$sql .= 'item_status, ';
	$sql .= 'item_hits, ';
	$sql .= 'item_rating, ';
	$sql .= 'item_votes, ';
	$sql .= 'item_comments, ';
	$sql .= 'item_exif, ';
	$sql .= 'item_description, ';

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_FILE_ID; $i++ ) {
		$sql .= 'item_file_id_'.$i.', ';
	}

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_TEXT; $i++ ) {
		$sql .= 'item_text_'.$i.', ';
	}

	$sql .= 'item_search ';

	$sql .= ') VALUES ( ';

	if ( $item_id > 0 ) {
		$sql .= intval($item_id).', ';
	}

	$sql .= intval($item_time_create).', ';
	$sql .= intval($item_time_update).', ';
	$sql .= intval($item_cat_id).', ';
	$sql .= intval($item_gicon_id).', ';
	$sql .= intval($item_uid).', ';
	$sql .= intval($item_kind).', ';
	$sql .= $this->quote($item_ext).', ';
	$sql .= $this->quote($item_datetime).', ';
	$sql .= $this->quote($item_title).', ';
	$sql .= $this->quote($item_place).', ';
	$sql .= $this->quote($item_equipment).', ';
	$sql .= floatval($item_gmap_latitude).', ';
	$sql .= floatval($item_gmap_longitude).', ';
	$sql .= intval($item_gmap_zoom).', ';
	$sql .= intval($item_gmap_type).', ';
	$sql .= $this->quote($item_perm_read).', ';
	$sql .= intval($item_status).', ';
	$sql .= intval($item_hits).', ';
	$sql .= floatval($item_rating).', ';
	$sql .= intval($item_votes).', ';
	$sql .= intval($item_comments).', ';
	$sql .= $this->quote($item_exif).', ';
	$sql .= $this->quote($item_description).', ';

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_FILE_ID; $i++ ) {
		$sql .= $this->quote( $row[ 'item_file_id_'.$i ] ).', ';
	}

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_TEXT; $i++ ) {
		$sql .= $this->quote( $row[ 'item_text_'.$i ] ).', ';
	}

	$sql .= $this->quote($item_search).' ';

	$sql .= ')';

	$ret = $this->query( $sql, 0, 0, $force );
	if ( !$ret ) { return false; }

	return $this->_db->getInsertId();
}

//---------------------------------------------------------
// update
//---------------------------------------------------------
function update( $row, $force=false )
{
	extract( $row ) ;

	$sql  = 'UPDATE '.$this->_table.' SET ';
	$sql .= 'item_time_create='.intval($item_time_create).', ';
	$sql .= 'item_time_update='.intval($item_time_update).', ';
	$sql .= 'item_cat_id='.intval($item_cat_id).', ';
	$sql .= 'item_gicon_id='.intval($item_gicon_id).', ';
	$sql .= 'item_uid='.intval($item_uid).', ';
	$sql .= 'item_kind='.$this->quote($item_kind).', ';
	$sql .= 'item_ext='.$this->quote($item_ext).', ';
	$sql .= 'item_datetime='.$this->quote($item_datetime).', ';
	$sql .= 'item_title='.$this->quote($item_title).', ';
	$sql .= 'item_place='.$this->quote($item_place).', ';
	$sql .= 'item_equipment='.$this->quote($item_equipment).', ';
	$sql .= 'item_gmap_latitude='.floatval($item_gmap_latitude).', ';
	$sql .= 'item_gmap_longitude='.floatval($item_gmap_longitude).', ';
	$sql .= 'item_gmap_zoom='.intval($item_gmap_zoom).', ';
	$sql .= 'item_gmap_type='.intval($item_gmap_type).', ';
	$sql .= 'item_perm_read='.$this->quote($item_perm_read).', ';
	$sql .= 'item_status='.intval($item_status).', ';
	$sql .= 'item_hits='.intval($item_hits).', ';
	$sql .= 'item_rating='.floatval($item_rating).', ';
	$sql .= 'item_votes='.intval($item_votes).', ';
	$sql .= 'item_comments='.intval($item_comments).', ';
	$sql .= 'item_exif='.$this->quote($item_exif).', ';
	$sql .= 'item_description='.$this->quote($item_description).', ';

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_FILE_ID; $i++ ) 
	{
		$name = 'item_file_id_'.$i;
		$sql .= $name .'='. $this->quote( $row[ $name ] ).', ';
	}

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_TEXT; $i++ ) 
	{
		$name = 'item_text_'.$i;
		$sql .= $name .'='. $this->quote( $row[ $name ] ).', ';
	}

	$sql .= 'item_search='.$this->quote($item_search).' ';
	$sql .= 'WHERE item_id='.intval($item_id);

	return $this->query( $sql, 0, 0, $force );
}

function update_status_by_id_array( $id_array )
{
	$sql  = 'UPDATE '.$this->_table.' SET ';
	$sql .= 'item_status=1 ';
	$sql .= 'WHERE '.$this->build_where_by_itemid_array( $id_array );

	return $this->query( $sql );
}

function update_rating_by_id( $item_id, $rating, $votes )
{
	$sql  = 'UPDATE '.$this->_table.' SET ';
	$sql .= 'item_rating='. floatval($rating) .', ';
	$sql .= 'item_votes='. intval($votes) .' ';
	$sql .= 'WHERE item_id='. intval($item_id);

	return $this->query( $sql );
}

function clear_gicon_id( $gicon_id )
{
	$sql  = 'UPDATE '.$this->_table.' SET ';
	$sql .= 'item_gicon_id=0 ';
	$sql .= 'WHERE item_gicon_id='.intval($gicon_id);

	return $this->query( $sql );
}

// when GET request
function update_hits( $item_id )
{
	$sql  = 'UPDATE '.$this->_table.' SET ';
	$sql .= 'item_hits = item_hits+1 ';
	$sql .= 'WHERE '. $this->build_where_public();
	$sql .= 'AND item_id='.intval($item_id);

	return $this->queryF( $sql );
}

//---------------------------------------------------------
// get count
//---------------------------------------------------------
function get_count_public()
{
	$where = $this->build_where_public();
	return $this->get_count_by_where( $where );
}

function get_count_waiting()
{
	return $this->get_count_by_where( $this->build_where_waiting() );
}

function get_count_by_catid( $cat_id )
{
	$where = 'item_cat_id='.intval($cat_id);
	return $this->get_count_by_where( $where );
}

function get_count_public_by_catid( $cat_id )
{
	$where = $this->build_where_public_by_catid( $cat_id );
	return $this->get_count_by_where( $where );
}

function get_count_public_by_catid_array( $catid_array )
{
	$where = $this->build_where_public_by_catid_array( $catid_array );
	return $this->get_count_by_where( $where );
}

function get_count_public_by_uid( $uid )
{
	$where = $this->build_where_public_by_uid( $uid );
	return $this->get_count_by_where( $where );
}

function get_count_by_itemid_uid( $item_id, $uid )
{
	$where  = 'item_id='.intval($item_id);
	$where .= ' AND item_uid='.intval($uid);
	return $this->get_count_by_where( $where );
}

function get_count_public_by_datetime( $datetime )
{
	$where = $this->build_where_public_by_datetime( $datetime );
	return $this->get_count_by_where( $where );
}

function get_count_public_by_like_datetime( $datetime )
{
	$where = $this->build_where_public_by_like_datetime( $datetime );
	return $this->get_count_by_where( $where );
}

function get_count_public_imode()
{
	$where = $this->build_where_public_imode();
	return $this->get_count_by_where( $where );
}

//---------------------------------------------------------
// get row
//---------------------------------------------------------
function get_row_public_by_id( $item_id )
{
	$sql  = 'SELECT * FROM '.$this->_table;
	$sql .= ' WHERE '. $this->build_where_public();
	$sql .= ' AND item_id='.intval($item_id);
	return $this->get_row_by_sql( $sql );
}

function get_title_by_id( $item_id )
{
	$row = $this->get_row_by_id( $item_id );
	if ( is_array($row) ) {
		return $row['item_title'] ;
	}
	return false;
}

//---------------------------------------------------------
// get rows
//---------------------------------------------------------
function get_rows_public( $limit=0, $offset=0 )
{
	$where   = $this->build_where_public();
	$orderby = 'item_id ASC';
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_latest( $limit=0, $offset=0 )
{
	$where   = $this->build_where_public();
	$orderby = 'item_time_update DESC, item_id DESC';
	return $this->get__rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_by_orderby( $orderby, $limit=0, $offset=0  )
{
	$where = $this->build_where_public();
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_by_catid_orderby( $cat_id, $orderby, $limit=0, $offset=0  )
{
	$where  = $this->build_where_public();
	$where .= ' AND item_cat_id='.intval($cat_id);
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_by_uid_orderby( $uid, $orderby, $limit=0, $offset=0 )
{
	$where = $this->build_where_public_by_uid( $uid );
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_by_datetime_orderby( $datetime, $orderby, $limit=0, $offset=0 )
{
	$where = $this->build_where_public_by_datetime( $datetime );
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_imode_by_orderby( $orderby, $limit=0, $offset=0 )
{
	$where = $this->build_where_public_imode();
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_waiting( $limit=0, $offset=0 )
{
	$where   = $this->build_where_waiting();
	$orderby = 'item_id ASC';
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_by_catid( $cat_id, $limit=0, $offset=0 )
{
	$where   = 'item_cat_id='.intval($cat_id);
	$orderby = 'item_id ASC';
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_by_id_array( $id_array, $limit=0, $offset=0  )
{
	$where = $this->build_where_by_itemid_array( $id_array );
	$orderby = 'item_id ASC';
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_gmap_latest( $limit=0, $offset=0 )
{
	$where   = $this->build_where_public();
	$where  .= ' AND '. $this->build_where_gmap();
	$orderby = 'item_time_update DESC, item_id DESC';
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_gmap_latest_by_catid_array( $catid_array, $limit=0, $offset=0 )
{
	$where   = $this->build_where_public_by_catid_array( $catid_array );
	$where  .= ' AND '. $this->build_where_gmap();
	$orderby = 'item_time_update DESC, item_id DESC';
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_gmap_area( $item_id, $lat, $lon, $limit=0, $offset=0 )
{
	$where   = $this->build_where_public();
	$where  .= ' AND '. $this->build_where_gmap();
	$where  .= ' AND '. $this->build_where_gmap_area( $lat, $lon );
	$where  .= ' AND item_id <> '. intval($item_id);
	$orderby = 'item_id ASC';
	return $this->get_rows_by_where_orderby( $where, $orderby, $limit, $offset );
}

function get_rows_public_catlist( $limit=0, $offset=0 )
{
	$sql  = 'SELECT *, COUNT(item_id) AS cat_sum ';
	$sql .= ' FROM '. $this->_table;
	$sql .= ' WHERE '. $this->build_where_public();
	$sql .= ' GROUP BY item_cat_id' ;
	$sql .= ' ORDER BY item_cat_id' ;
	return $this->get_rows_by_sql( $sql, $limit, $offset );
}

function get_rows_from_id_array( $id_array )
{
	$arr = array();
	foreach ( $id_array as $id ) {
		$arr[] = $this->get_row_by_id( $id ) ;
	}
	return $arr;
}

//---------------------------------------------------------
// get id array
//---------------------------------------------------------
function get_id_array_public_by_catid_orderby( $cat_id, $orderby, $limit=0, $offset=0 )
{
	$where  = $this->build_where_public();
	$where .= ' AND item_cat_id='.intval($cat_id);
	return $this->get_id_array_by_where_orderby( $where, $orderby, $limit, $offset );
}

//---------------------------------------------------------
// build
//---------------------------------------------------------
function build_search( $row )
{
	$text  = '';
	$text .= $row['item_datetime'].' ';
	$text .= $row['item_title'].' ';
	$text .= $row['item_place'].' ';
	$text .= $row['item_equipment'].' ';

	$text .= $row['item_description'].' ';
	$text .= $row['item_ext'].' ';

	for ( $i=1; $i <= _C_WEBPHOTO_MAX_ITEM_TEXT; $i++ ) {
		$text .= $row[ 'item_text_'.$i ].' ';
	}

	return $text;
}

//---------------------------------------------------------
// where
//---------------------------------------------------------
function build_where_public_by_catid( $cat_id )
{
	$where  = $this->build_where_public();
	$where .= ' AND item_cat_id='.intval($cat_id);
	return $where;
}

function build_where_public_by_catid_array( $catid_array )
{
	$where  = $this->build_where_public() ;
	$where .= ' AND '. $this->build_where_by_catid_array( $catid_array );
	return $where;
}

function build_where_public_by_uid( $uid )
{
	$where  = $this->build_where_public();
	$where .= ' AND item_uid='.intval($uid);
	return $where;
}

function build_where_public_by_datetime( $datetime )
{
	$where  = $this->build_where_public();
	$where .= ' AND item_datetime ='. $this->quote($datetime);
	return $where;
}

function build_where_public_by_like_datetime( $datetime )
{
	$where  = $this->build_where_public();
	$where .= ' AND item_datetime LIKE '. $this->quote( $datetime.'%' );
	return $where;
}

function build_where_public_by_place( $place )
{
	$where  = $this->build_where_public();
	$where .= ' AND item_place ='. $this->quote($place);
	return $where;
}

function build_where_public_by_place_array( $place_array )
{
	$where  = $this->build_where_public();
	$where .= ' AND '.$this->build_where_place_array( $place_array );
	return $where;
}

function build_where_public_photo()
{
	$where  = $this->build_where_public();
	$where .= ' AND '. $this->build_where_photo();
	return $where;
}

function build_where_public_photo_by_catid( $cat_id )
{
	$where  = $this->build_where_public();
	$where .= ' AND '. $this->build_where_photo();
	$where .= ' AND item_cat_id='. intval($cat_id);
	return $where;
}

function build_where_public_imode()
{
	$where  = $this->build_where_public();
	$where .= ' AND '. $this->build_where_imode();
	return $where;
}

function build_where_public()
{
	$where = ' item_status > 0 ';
	return $where;
}

function build_where_waiting()
{
	$where = ' item_status = 0 ';
	return $where;
}

function build_where_imode()
{
	$where  = " ( item_ext='gif' ";
	$where .= "OR item_ext='jpg' ";
	$where .= "OR item_ext='jpeg' ";
	$where .= "OR item_ext='3gp' ";
	$where .= "OR item_ext='3g2' )";
	return $where;
}

function build_where_photo()
{
	$where  = " ( item_ext='gif' ";
	$where .= "OR item_ext='png' ";
	$where .= "OR item_ext='jpg' ";
	$where .= "OR item_ext='jpeg' ) ";
	return $where;
}

function build_where_gmap()
{
	$where  = ' ( item_gmap_latitude <> 0 ';
	$where .= 'OR item_gmap_longitude <> 0 ';
	$where .= 'OR item_gmap_zoom <> 0 ) ';
	return $where;
}

function build_where_place_array( $place_array )
{
	return $this->build_where_by_keyword_array( $place_array, 'AND', 'item_place' );
}

function build_where_waiting_by_keyword_array( $keyword_array )
{
	$where = $this->build_where_waiting() ;
	$where_key = $this->build_where_by_keyword_array( $keyword_array );
	if ( $where_key ) {
		$where .= ' AND '.$where_key ;
	}
	return $where;
}

function build_where_by_keyword_array_catid( $keyword_array, $cat_id )
{
	$where_key = $this->build_where_by_keyword_array( $keyword_array );

	$where_cat = null;
	if ( $cat_id != 0 ) {
		$where_cat = "item_cat_id=".intval($cat_id);
	}

	if ( $where_key && $where_cat ) {
		$where = $where_key .' AND '. $where_cat ;
		return $where;
	} elseif ( $where_key ) {
		return $where_key;
	} elseif ( $where_cat ) {
		return $where_cat;
	}

	return null;
}

function build_where_by_keyword_array( $keyword_array, $andor='AND', $name='item_search' )
{
	if ( !is_array($keyword_array) || !count($keyword_array) ) {
		return null;
	}

	switch ( strtolower($andor) )
	{
		case 'exact':
			$where = $this->build_where_keyword_single( $keyword_array[0], $name );
			return $where;

		case 'or':
			$andor_glue = 'OR';
			break;

		case 'and':
		default:
			$andor_glue = 'AND';
			break;
	}

	$arr = array();

	foreach( $keyword_array as $keyword ) 
	{
		$keyword = trim($keyword);
		if ( $keyword ) {
			$arr[] = $this->build_where_keyword_single( $keyword, $name ) ;
		}
	}

	if ( is_array( $arr ) && count( $arr ) ) {
		$glue  = ' '. $andor_glue .' ';
		$where = ' ( '. implode( $glue , $arr ) .' ) ' ;
		return $where;
	}

	return null;
}

function build_where_keyword_single( $str, $name='item_search' )
{
	$text = $name ." LIKE '%" . addslashes( $str ) . "%'" ;
	return $text;
}

function build_where_by_itemid_array( $id_array )
{
	$where = '';
	foreach( $id_array as $id ) {
		$where .= 'item_id='. intval($id) .' OR ';
	}

// 0 means to belong no category
	$where .= '0';
	return $where;
}

function build_where_by_catid_array( $catid_array )
{
	$where  = ' item_cat_id IN ( ' ;
	foreach( $catid_array as $id ) {
		$where .= intval($id) .', ';
	}

// 0 means to belong no category	
	$where .= ' 0 )';
	return $where;
}

//---------------------------------------------------------
// build gmap
//---------------------------------------------------------
function build_where_gmap_area( $lat, $lon )
{
	$north = $this->adjust_latitude(  $lat + $this->_AREA_NS );
	$south = $this->adjust_latitude(  $lat - $this->_AREA_NS );
	$east  = $this->adjust_longitude( $lon + $this->_AREA_EW );
	$west  = $this->adjust_longitude( $lon - $this->_AREA_EW );

	$where  = ' item_gmap_latitude > '.floatval($south);
	$where .= ' AND item_gmap_latitude  < '.floatval($north);
	$where .= ' AND item_gmap_longitude > '.floatval($west);
	$where .= ' AND item_gmap_longitude < '.floatval($east);
	return $where;
}

function adjust_latitude( $lat )
{
// north pole
	if ( $lat > 90 ) {
		$lat = 90;

// south pole
	} elseif ( $lat < -90 ) {
		$lat = -90;
	}

	return $lat;
}

function adjust_longitude( $lon )
{
// international date line
	if ( $lon > 180 ) {
		$lon = -360 + $lon;
	} elseif ( $lon < -180 ) {
		$lon = 360 + $lon;
	}
	return $lon;
}

//---------------------------------------------------------
// build datetime
//---------------------------------------------------------
function build_datetime_by_post( $key, $default=null )
{
	$val = isset($_POST[$key]) ? $_POST[$key] : $default;
	return $this->build_datetime( $val );
}

function build_datetime( $str )
{
	$utility_class =& webphoto_lib_utility::getInstance();
	return $utility_class->str_to_mysql_datetime( $str );
}

//---------------------------------------------------------
// for show
//---------------------------------------------------------
function build_value_fileid_by_kind( $row, $kind )
{
	if ( isset( $row[ $this->build_name_fileid_by_kind( $kind ) ] ) ) {
		return  $row[ $this->build_name_fileid_by_kind( $kind ) ];
	}
	return false ;
}

function build_name_fileid_by_kind( $kind )
{
	$str = 'item_file_id_'.$kind;
	return $str ;
}

function build_value_text_by_num( $row, $num )
{
	if ( isset( $row[ $this->build_name_text_by_num( $num ) ] ) ) {
		return  $row[ $this->build_name_text_by_num( $num ) ];
	}
	return false ;
}

function build_name_text_by_kind( $num )
{
	$str = 'item_text_'.$num;
	return $str ;
}

function build_show_description_disp( $row )
{
	$myts =& MyTextSanitizer::getInstance();
	return $myts->displayTarea( $row['item_description'] , 0 , 1 , 1 , 1 , 1  );
}

function build_show_exif_disp( $row )
{
	$myts =& MyTextSanitizer::getInstance();
	return $myts->displayTarea( $row['item_exif'] , 0 , 0 , 0 , 0 , 1 );
}

//---------------------------------------------------------
// for comment_new
//---------------------------------------------------------
function get_replytitle()
{
	$com_itemid = isset( $_GET['com_itemid'] ) ? intval( $_GET['com_itemid'] ) : 0 ;

	if ( $com_itemid > 0 ) {
		return $this->get_title_by_id( $com_itemid );
	}
	return null;
}

// --- class end ---
}

?>