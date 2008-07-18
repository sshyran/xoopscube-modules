<?php

if ( ! function_exists('d3download_return_bytes') ) {
	function d3download_return_bytes( $val )
	{
	    $val = trim( $val );
		$last = strtolower( substr( $val, -1, 1 ) );
		switch( $last ) {
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return intval( $val );
	}
}

if ( ! function_exists('d3download_upload_config_check') ) {
	function d3download_upload_config_check( $mydirname )
	{
		$error = 0 ;
		$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/';
		$safe_mode = ini_get( "safe_mode" ) ;
		if( ! is_dir( $uploads_dir ) ) {
			if( $safe_mode ) {
				$error = _MD_D3DOWNLOADS_UPLOADDIR_NOT_IS_DIR ;
			}
			$mrs = mkdir( $uploads_dir , 0777 ) ;
			if( ! $mrs ) {
				$error = _MD_D3DOWNLOADS_UPLOADDIR_NOT_MKDIR ;
			} else @chmod( $uploads_dir , 0777 ) ;
		}
		if( ! is_writable( $uploads_dir ) || ! is_readable( $uploads_dir ) ) {
			$mrs = chmod( $uploads_dir , 0777 ) ;
			if( ! $mrs ) {
				$error = _MD_D3DOWNLOADS_UPLOADDIR_NOT_IS_WRITEABLE ;
			}
		}
		return $error ;
	}
}

if ( ! function_exists('d3download_file_error_message') ) {
	function d3download_file_error_message( $file_error )
	{
		if( $file_error == 1 ){
			$error = _MD_D3DOWNLOADS_UPLOAD_ERR_INI_SIZE ;
		} elseif( $file_error == 2 ){
			$error = _MD_D3DOWNLOADS_FILELARGE ;
		} elseif( $file_error == 3 ){
			$error = _MD_D3DOWNLOADS_UPLOADERROR ;
		} elseif( $file_error == 4 ){
			$error = _MD_D3DOWNLOADS_UPLOADERROR ;
		} elseif( $file_error == 5 ){
			$error = _MD_D3DOWNLOADS_UPLOADERROR ;
		} else {
			$error = _MD_D3DOWNLOADS_UPLOADERROR ;
		}
		return $error ;
	}
}

// ��ʐݒ�̍ő�t�@�C���T�C�Y���擾
if ( ! function_exists('d3download_get_maxsize') ) {
	function d3download_get_maxsize( $mydirname )
	{
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar('mid') );

		if( empty( $mod_config['maxfilesize'] ) ) {
			$maxsize = 1000 * 1024 ;
		} else {
			$maxsize = intval( $mod_config['maxfilesize'] ) * 1024 ;
		}
		return $maxsize ;
	}
}

// �A�b�v���[�h�\�Ȋg���q���擾
if ( ! function_exists('d3download_get_allowed_extension') ) {
	function d3download_get_allowed_extension( $mydirname )
	{
		include_once dirname( dirname(__FILE__) ).'/class/upload_validate.php' ;
		$upload_validate = new Upload_Validate() ;
		$allowed_extension = array_diff( $upload_validate->allowed_extension( $mydirname ), $upload_validate->deny_extension() );
		return sprintf( _MD_D3DOWNLOADS_SUBMIT_EXTENSION , implode( ',',$allowed_extension ) ) ;
	}
}

// �t�@�C���A�b�v���[�h����
if ( ! function_exists('d3download_file_upload') ) {
	function d3download_file_upload( $mydirname, $upload_arr, $maxsize, $id, $uid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/upload_validate.php' ;
		$upload_validate = new Upload_Validate( $mydirname ) ;

		$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/';

		// PHP 4.3.6 �ȑO�̃o�[�W�����ւ̑΍�( .. �� / ���܂܂�Ă���ꍇ�����I�� )
		$upload_validate->check_doubledot( $upload_arr['name'] ) ;

		$file_name = $upload_arr['name'] ;
		$file_tmp_name = $upload_arr['tmp_name'] ;
		$file_error = intval( $upload_arr['error'] );

		// �A�b�v���[�h���ꂽ�t�@�C���́A�g���q�͂Ȃ��A�t�@�C������ς��ĕۑ�����
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$uploads_path = $uploads_dir.$id.'_'.$site_salt.'_'.$uid.'_'.time() ;

		// ���`�F�b�N�ƃG���[�`�F�b�N
		$config_error = "" ;
		$config_error = d3download_upload_config_check( $mydirname );
		if( ! empty( $config_error ) ){
			redirect_header( XOOPS_URL."/modules/$mydirname/" , 10 , $config_error ) ;
			exit();
		}

		if ( $file_error > 0 ){
			return array(
				'error'  => d3download_file_error_message( $file_error ) ,
			) ;
			exit();
		}

		if( is_uploaded_file( $file_tmp_name ) ){
			$f_info = pathinfo( $file_name );
			$f_ext = strtolower( $f_info['extension'] ) ;
			$f_size = intval( filesize( $file_tmp_name ) );
			if( $f_size > $maxsize ) {
				return array(
					'error'  => _MD_D3DOWNLOADS_FILELARGE ,
				) ;
				exit();
			}

			// �g���q�`�F�b�N
			if( ! $upload_validate->check_allowed_extensions( $f_ext ) ){
				redirect_header( XOOPS_URL."/modules/$mydirname/", 2, sprintf( _MD_D3DOWNLOADS_UPLOADERROR_EXT , $f_ext ) );
				exit();
			} else {
				// php �ȂǊ댯�Ȋg���q�̃t�@�C���̃A�b�v���[�h��h��
				$upload_validate->check_deny_extensions( $f_ext );

				// multiple dot file �̃`�F�b�N���s�����ǂ���
				$check_multiple_dot = $upload_validate->config_check_multiple_dot();
				// multiple dot file �̃`�F�b�N
				if( ! empty( $check_multiple_dot ) ){
					$upload_validate->check_multiple_dot( $file_name );
				}

				// �摜�t�@�C����ΏۂɊg���q�U���̃`�F�b�N
				$upload_validate->check_image_extensions( $f_ext, $file_tmp_name, $file_name );

				// �w�b�_�̃`�F�b�N���s�����ǂ���
				$check_of_head = $upload_validate->config_validate_of_head();
				// �t�@�C���̐擪�����m�F���Ċg���q�U���̃`�F�b�N
				if( ! empty( $check_of_head ) ){
					$upload_validate->Validate_of_head( $file_tmp_name, $file_name, $f_ext );
				}

				$urs = @move_uploaded_file( $file_tmp_name , $uploads_path );
				if ( $urs === TRUE ) {
					return array(
						'url'  => $uploads_path ,
						'file_name'  => $file_name,
						'ext'  => $f_ext ,
						'size' => $f_size ,
						'error' => '' ,
					) ;
				} else {
					redirect_header( XOOPS_URL."/modules/$mydirname/", 2, _MD_D3DOWNLOADS_UPLOADERROR );
					exit();
				}
			}
		} else {
			redirect_header( XOOPS_URL."/modules/$mydirname/", 2, _MD_D3DOWNLOADS_UPLOADERROR );
			exit();
		}
	}
}

if ( ! function_exists('d3download_convert_for_newid') ) {
	function d3download_convert_for_newid( $mydirname, $newid, $url, $uid )
	{
		$db =& Database::getInstance() ;

		if ( file_exists( $url ) ){
			$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/';
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$new_file = $uploads_dir.$newid.'_'.$site_salt.'_'.$uid.'_'.time() ;
			if ( copy( $url, $new_file ) ) {
				@unlink( $url );
			} else {
				redirect_header( XOOPS_URL."/modules/$mydirname/" , 3 , _MD_D3DOWNLOADS_UPLOADERROR ) ;
				exit();
			}
			$nrs = $db->query( "UPDATE ".$db->prefix( $mydirname."_downloads" )." SET url = '".$new_file."' WHERE lid = '".$newid."'");
			if( ! $nrs ){
				redirect_header( XOOPS_URL."/modules/$mydirname/" , 3 , _MD_D3DOWNLOADS_UPLOADERROR ) ;
				exit();
			}
		}
	}
}

if ( ! function_exists('d3download_convert_for_unapproval') ) {
	function d3download_convert_for_unapproval( $mydirname, $newid, $url, $uid )
	{
		$db =& Database::getInstance() ;

		if ( file_exists( $url ) ){
			$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/';
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$new_file = $uploads_dir.$newid.'_'.$site_salt.'_'.$uid.'_'.time() ;
			if ( copy( $url, $new_file ) ) {
				@unlink( $url );
			} else {
				redirect_header( XOOPS_URL."/modules/$mydirname/" , 3 , _MD_D3DOWNLOADS_UPLOADERROR ) ;
				exit();
			}
			$nrs = $db->query( "UPDATE ".$db->prefix( $mydirname."_unapproval" )." SET url = '".$new_file."' WHERE requestid = '".$newid."'");
			if( ! $nrs ){
				redirect_header( XOOPS_URL."/modules/$mydirname/" , 3 , _MD_D3DOWNLOADS_UPLOADERROR ) ;
				exit();
			}
		}
	}
}

?>