<?php

if ( ! function_exists('d3download_common_make_feed') ) {
	function d3download_common_make_feed( $mydirname, $type='rss' )
	{
		global $xoopsUser ;

		require_once dirname( dirname(__FILE__) ).'/class/feed_maker.php';
		require_once dirname( dirname( __FILE__ ) ).'/include/whatsnew.inc.php' ;

		$feed = new feed_maker( $mydirname );
		$limit = $feed->get_feed_limit();

		$cid = ( ! empty( $_GET['cid'] ) )? intval( $_GET['cid'] ) : "";
		$e = ( ! empty( $_GET['e'] ) )? $_GET['e'] : '';
		if ( $e === 'sjis' ) {
			$encode = 'SJIS';
			$encoding = 'Shift-JIS';
		} else {
			$encode = $encoding = 'UTF-8';
		}

		$cache_time = 30 * 60;
		$c_file = XOOPS_ROOT_PATH.'/cache/'.$mydirname.'_'.$cid.'.rss';
		if( is_object( $xoopsUser ) ) {
			$data = d3downloads_whatsnew_base( $mydirname, $cid, $limit, 0, 1 ) ;
		} elseif ( file_exists( $c_file ) && filemtime( $c_file ) + $cache_time > time() ){
			$data = unserialize( join( '', file( $c_file ) ) );
			$b_time = filemtime( $c_file );
		} else {
			$data = d3downloads_whatsnew_base( $mydirname, $cid, $limit, 0, 1 ) ;
			if ( $fp = @fopen( $c_file, 'wb' ) )
			{
				fputs( $fp,serialize( $data ) );
				fclose( $fp );
			}
			$b_time = time();
		}

		if( $type == 'rss' ){
			$xsl_file = $feed->set_xsl_file( 'rss2html.xsl' );
			$feed->rss_build( $cid, $data, $b_time, $encode, $encoding, $xsl_file );
		} elseif( $type == 'atom' ){
			$feed->Atom_build( $cid, $data, $b_time, $encode, $encoding );
		} elseif( $type == 'rdf' ){
			$feed->rdf_build( $cid, $data, $b_time, $encode, $encoding );
		}
	}
}

?>