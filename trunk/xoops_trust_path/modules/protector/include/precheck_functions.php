<?php

function protector_prepare()
{
	// check the access is from install/index.php
	if( defined( '_INSTALL_CHARSET' ) && ! is_writable( XOOPS_ROOT_PATH.'/mainfile.php' ) ) die( 'To use installer, remove protector\'s lines from mainfile.php first.' ) ;

	// Protector class
	require_once dirname(dirname(__FILE__)).'/class/protector.php' ;

	// Protector object
	$protector =& Protector::getInstance() ;
	$conf = $protector->getConf() ;

	// bad_ips
	$bad_ips = Protector::get_bad_ips() ;
	$bad_ip_match = Protector::ip_match( $bad_ips ) ;
	if( $bad_ip_match ) {
		$protector->call_filter( 'precommon_badip' , 'You are registered as BAD_IP by Protector.' ) ;
	}

	// global enabled or disabled
	if( ! empty( $conf['global_disabled'] ) ) return true ;

	// reliable ips
	$reliable_ips = @unserialize( @$conf['reliable_ips'] ) ;
	if( ! is_array( $reliable_ips ) ) {
		// for the environment of (buggy core version && magic_quotes_gpc)
		$reliable_ips = @unserialize( stripslashes( @$conf['reliable_ips'] ) ) ;
		if( ! is_array( $reliable_ips ) ) $reliable_ips = array() ;
	}
	$is_reliable = false ;
	foreach( $reliable_ips as $reliable_ip ) {
		if( ! empty( $reliable_ip ) && preg_match( '/'.$reliable_ip.'/' , $_SERVER['REMOTE_ADDR'] ) ) {
			$is_reliable = true ;
		}
	}

	// "Big Umbrella" subset version
	if( ! empty( $conf['enable_bigumbrella'] ) ) $protector->bigumbrella_init() ;

	// force intval variables whose name is *id
	if( ! empty( $conf['id_forceintval'] ) ) $protector->intval_allrequestsendid() ;

	// eliminate '..' from requests looks like file specifications
	if( ! $is_reliable && ! empty( $conf['file_dotdot'] ) ) $protector->eliminate_dotdot() ;

	// Check uploaded files
	if( ! $is_reliable && ! empty( $_FILES ) && ! empty( $conf['die_badext'] ) && ! defined( 'PROTECTOR_SKIP_FILESCHECKER' ) && ! $protector->check_uploaded_files() ) {
		$protector->output_log( $protector->last_error_type ) ;
		$protector->purge() ;
	}

	// Variables contamination
	if( ! $protector->check_contami_systemglobals() ) {
		if( @$conf['contami_action'] & 4 ) {
			if( @$conf['contami_action'] & 8 ) {
				$protector->_should_be_banned = true ;
			} else {
				$protector->_should_be_banned_time0 = true ;
			}
			$_GET = $_POST = array() ;
		}

		$protector->output_log( $protector->last_error_type ) ;
		if( @$conf['contami_action'] & 2 ) $protector->purge() ;
	}

	// prepare for DoS
	//if( ! $protector->check_dos_attack_prepare() ) {
	//	$protector->output_log( $protector->last_error_type , 0 , true ) ;
	//}

	if( ! empty( $conf['disable_features'] ) ) $protector->disable_features() ;

}

?>