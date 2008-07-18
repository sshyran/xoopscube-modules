<?php
// $Id: checkconfigs.php,v 1.3 2008/07/05 15:45:11 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-07-01 K.OHWADA
// added FFmpeg
//---------------------------------------------------------

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_admin_checkconfigs
//=========================================================
class webphoto_admin_checkconfigs extends webphoto_base_this
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_admin_checkconfigs( $dirname, $trust_dirname )
{
	$this->webphoto_base_this( $dirname, $trust_dirname );
}

function &getInstance( $dirname, $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_admin_checkconfigs( $dirname, $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// main
//---------------------------------------------------------
function check()
{
	$cfg_makethumb   = $this->get_config_by_name('makethumb');
	$cfg_imagingpipe = $this->get_config_by_name('imagingpipe');
	$cfg_photospath  = $this->get_config_by_name('photospath');
	$cfg_thumbspath  = $this->get_config_by_name('thumbspath');
	$cfg_giconspath  = $this->get_config_by_name('giconspath');
	$cfg_tmppath     = $this->get_config_by_name('tmppath');
	$cfg_use_ffmpeg  = $this->get_config_by_name('use_ffmpeg');
	$cfg_imagickpath = $this->_config_class->get_dir_by_name('imagickpath');
	$cfg_netpbmpath  = $this->_config_class->get_dir_by_name('netpbmpath');
	$cfg_ffmpegpath  = $this->_config_class->get_dir_by_name('ffmpegpath');

// Initialize
	$netpbm_pipes = array( "jpegtopnm" , "giftopnm" , "pngtopnm" , 
		 "pnmtojpeg" , "pnmtopng" , "ppmquant" , "ppmtogif" ,
		 "pnmscale" , "pnmflip" ) ;

//
// ENVIRONTMENT CHECK
//
	echo "<h4>"._AM_WEBPHOTO_H4_ENVIRONMENT."</h4>\n" ;
	echo "<b>"._AM_WEBPHOTO_PHPDIRECTIVE." : </b><br />\n";

	echo " &nbsp; 'safe_mode' ("._AM_WEBPHOTO_BOTHOK."): &nbsp; " ;
	$this->_print_on_off( ini_get( "safe_mode" ) );

	echo " &nbsp; 'file_uploads' ("._AM_WEBPHOTO_NEEDON."): &nbsp; " ;
	$this->_print_on_off( ini_get( "file_uploads" ), true );

	echo " &nbsp; 'register_globals' ("._AM_WEBPHOTO_BOTHOK."): &nbsp; " ;
	$this->_print_on_off( ini_get( "register_globals" ) );

	echo " &nbsp; 'upload_max_filesize': &nbsp; " ;
	$str = ini_get( "upload_max_filesize" ).' byte' ;
	$this->_print_green( $str );

	echo " &nbsp; 'post_max_size': &nbsp; " ;
	$str = ini_get( "post_max_size" ).' byte' ;
	$this->_print_green( $str );

	echo " &nbsp; 'open_basedir': &nbsp; " ;
	$rs = ini_get( "open_basedir" ) ;
	if ( $rs ) {
		$this->_print_green( $rs );
	} else {
		$this->_print_green( 'noting' );
	}

	echo " &nbsp; 'upload_tmp_dir': &nbsp; " ;
	$ini_upload_tmp_dir = ini_get("upload_tmp_dir");
	$tmp_dirs = explode( PATH_SEPARATOR , $ini_upload_tmp_dir ) ;

	foreach( $tmp_dirs as $dir ) 
	{
		if( $dir != "" && ( ! is_writable( $dir ) || ! is_readable( $dir ) ) ) {
			$msg = "Error: upload_tmp_dir ($dir) is not writable nor readable ." ;
			$this->_print_red( $msg );
			$error_upload_tmp_dir = true ;
		}
	}

	if ( empty( $error_upload_tmp_dir ) ) {
		$msg = 'ok '. $ini_upload_tmp_dir;
		$this->_print_green( $msg );
	}

	echo "<br />\n";
	echo ' &nbsp; Exif Extention : ' ;
	if ( function_exists( 'exif_read_data' ) ) {
		$this->_print_green('loaded' );
	} else {
		$this->_print_red('not loaded' );
	}

	echo "<br />\n";
	echo '<a href="'. $this->_MODULE_URL .'/admin/index.php/abc/" target="_blank">';
	echo _AM_WEBPHOTO_PATHINFO_LINK;
	echo '</a><br />'."\n";
	echo " &nbsp; "._AM_WEBPHOTO_PATHINFO_DSC."<br />\n" ;

//
// CONFIG CHECK
//
	echo "<h4>"._AM_WEBPHOTO_H4_CONFIG."</h4>\n" ;

// pipe
	echo "<b>"._AM_WEBPHOTO_PIPEFORIMAGES." : </b><br /><br />\n" ;

	echo "<b>GD</b> <br />\n" ;
	if ( function_exists( 'gd_info' ) ) {
		$gd_info = gd_info() ;
		echo ' &nbsp; GD Version: '. $gd_info['GD Version'] ."<br />\n" ;
		echo "<br />\n";
		echo '<a href="'. $this->_MODULE_URL .'/admin/index.php?fct=checkgd2" target="_blank">';
		echo _AM_WEBPHOTO_LNK_CHECKGD2;
		echo '</a><br />'."\n";
		echo " &nbsp; "._AM_WEBPHOTO_CHECKGD2."<br />\n" ;
	} else {
		echo "cannot use GD<br />\n";
	}
	echo "<br />\n";

	if (( $cfg_imagingpipe == _C_WEBPHOTO_PIPEID_IMAGICK ) ||
	      $cfg_imagickpath ) {
		echo "<b>ImageMagick</b><br />\n";
		echo " &nbsp; Path: $cfg_imagickpath<br />\n" ;
		$ret_array = array() ;
		exec( "{$cfg_imagickpath}convert --help" , $ret_array ) ;
		if( count( $ret_array ) < 1 ) {
			$msg = " &nbsp; Error: {$cfg_imagickpath}convert can't be executed" ;
			$this->_print_red( $msg );
		} else {
			echo " &nbsp; {$ret_array[0]} &nbsp; " ;
			$this->_print_green( 'ok' );
		}
		echo "<br />\n";
	}

	if (( $cfg_imagingpipe == _C_WEBPHOTO_PIPEID_NETPBM ) ||
		  $cfg_netpbmpath ) {
		echo "<b>NetPBM</b><br />\n";
		echo " &nbsp; Path: $cfg_netpbmpath<br />\n" ;
		foreach( $netpbm_pipes as $pipe ) {
			$ret_array = array() ;
			exec( "{$cfg_netpbmpath}$pipe --version 2>&1" , $ret_array ) ;
			if( count( $ret_array ) < 1 ) {
				$msg = " &nbsp; Error: {$cfg_netpbmpath}pnmscale can't be executed" ;
				$this->_print_red( $msg );
			} else {
				echo " &nbsp; {$ret_array[0]} &nbsp; " ;
				$this->_print_green( 'ok' );
			}
		}
		echo "<br />\n";
	}


	if ( $cfg_use_ffmpeg || $cfg_ffmpegpath ) {
		$flag_ffmpeg = false;
		echo "<b>FFmpeg</b><br />\n";
		echo " &nbsp; Path: $cfg_ffmpegpath<br />\n" ;
		$ret_array = array() ;
		exec( "{$cfg_ffmpegpath}ffmpeg -version 2>&1" , $ret_array ) ;

		if ( is_array($ret_array) && count($ret_array) ) {
			foreach ( $ret_array as $line ) {
				if ( preg_match('/version/i', $line ) ) {
					echo ' &nbsp; '. $line ."<br />\n";
					$flag_ffmpeg = true;
				}
			}
		}

		if ( !$flag_ffmpeg ) {
			$msg = " &nbsp; Error: {$cfg_ffmpegpath}ffmpeg can't be executed" ;
			$this->_print_red( $msg );
		}

		echo "<br />\n";

	} else {
		echo "<b>FFmpeg</b> : not use <br /><br />\n";
	}

// directory
	echo "<b>Directory : </b><br /><br />\n" ;

// photos
	echo _AM_WEBPHOTO_DIRECTORYFOR_PHOTOS.': '.XOOPS_ROOT_PATH.$cfg_photospath.' &nbsp; ';
	$this->_check_directory( $cfg_photospath );

// thumbs
	echo _AM_WEBPHOTO_DIRECTORYFOR_THUMBS.': '.XOOPS_ROOT_PATH.$cfg_thumbspath.' &nbsp; ' ;
	$this->_check_directory( $cfg_photospath );

// gicons
	echo _AM_WEBPHOTO_DIRECTORYFOR_GICONS.': '.XOOPS_ROOT_PATH.$cfg_giconspath.' &nbsp; ' ;
	$this->_check_directory( $cfg_giconspath );

// tmp
	echo _AM_WEBPHOTO_DIRECTORYFOR_TMP.': '.XOOPS_ROOT_PATH.$cfg_tmppath.' &nbsp; ' ;
	$this->_check_directory( $cfg_tmppath );

}

function _check_directory( $path )
{
	$full_path = XOOPS_ROOT_PATH.$path;

	if( substr( $path , -1 ) == '/' ) {
		$this->_print_red( _AM_WEBPHOTO_ERR_LASTCHAR );

	} else if( ord( $path ) != 0x2f ) {
		$this->_print_red( _AM_WEBPHOTO_ERR_FIRSTCHAR );

	} else if( ! is_dir( $full_path ) ) {
		if( $safe_mode_flag ) {
			$this->_print_red( _AM_WEBPHOTO_PERMISSION );

		} else {
			$rs = mkdir( $full_path , 0777 ) ;
			if ( $rs ) {
				$this->_print_green( 'ok' );
			} else {
				$this->_print_red( _AM_WEBPHOTO_NOTDIRECTORY );
			}
		}

	} else if ( ! is_writable( $full_path ) || ! is_readable( $full_path ) ) {
		$this->_print_red( _AM_WEBPHOTO_READORWRITE );

	} else {
		$this->_print_green( 'ok' );
	}

	echo "<br />\n";
}

function _print_on_off( $val, $flag_red=false )
{
	if ( $val ) {
		$this->_print_green('on');
	} elseif ( $flag_red ) { 
		$this->_print_red('off');
	} else { 
		$this->_print_green('off');
	}
}

function _print_red( $str )
{
	echo '<font color="#FF0000"><b>'. $str .'</b></font>'."<br />\n" ;
}

function _print_green( $str )
{
	echo '<font color="#00FF00"><b>'. $str .'</b></font>'."<br />\n" ;
}

// --- class end ---
}

?>