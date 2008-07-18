<?php

// Set extension data
include_once dirname( dirname(__FILE__) ).'/class/upload_validate.php' ;
$upload_validate = new Upload_Validate() ;
$allowed_extension = '\.'.implode( '|\.',array_diff( $upload_validate->allowed_extension( $mydirname ), $upload_validate->deny_extension() ) );

// Set length data
include_once dirname( dirname(__FILE__) ).'/class/submit_validate.php' ;
$submit_validate = new Submit_Validate() ;
$title_length = $submit_validate->title_length ;
$url_length = $submit_validate->url_length ;
$size_length = $submit_validate->size_length ;
$version_length = $submit_validate->version_length ;
$platform_length = $submit_validate->platform_length ;

// Submit rules by livevalidationphp
$formRules = array();

$formRules['makedownloadform'] = array(
	// Title check
	'title' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_TITLE_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Presence',
				'args'=>array(
					'failureMessage' => _MD_D3DOWNLOADS_TITLE_NONE
				)
			),
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_TITLE_TOOLONG, $title_length ) ,
					'maximum'=>$title_length
				)
			),
		)
	),

	// Url check
	'url' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_URL_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Presence',
				'args'=>array(
					'failureMessage' => _MD_D3DOWNLOADS_URL_NONE
				)
			),
			// Check control code
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => "/[\\0-\\31]/",
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			// Check black pattern(deprecated)
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => '/(javascript|java script|vbscript|about|data):/i',
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			// Check rfc2396 URI Characters
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => "/[^-\/?:#@&=+$,\w.!~*;'()%]/",
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/^(https?|ftp):\/\/.+$|^XOOPS_TRUST_PATH\/([^\s]*)+$|^XOOPS_ROOT_PATH\/([^\s]*)+$/i',
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_URL_TOOLONG, $url_length ) ,
					'maximum'=>$url_length
				)
			),
		)
	),

	// File_upload check
	'file_upload' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_URL_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Presence',
				'args'=>array(
					'failureMessage' => _MD_D3DOWNLOADS_URL_NONE
				)
			),
			// 一般設定で設定されている拡張子をチェック
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/('.$allowed_extension.')$/i',
					'failureMessage' => _MD_D3DOWNLOADS_EXT_CHECK
				)
			),
		)
	),

/*
	// Homepage check
	'homepage' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_HOMEPAGE_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/^https?:\/\/.+\..+|^https?/',
					'failureMessage' => _MD_D3DOWNLOADS_HOMEPAGE_CHECK
				)
			),
		)
	),
*/
	// Size check
	'size' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_SIZE_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/^[0-9]+$/',
					'failureMessage' => _MD_D3DOWNLOADS_SIZE_CHECK
				)
			),
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_SIZE_TOOLONG, $size_length ) ,
					'maximum'=>$size_length
				)
			),
		)
	),

	// Version check
	'version' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_VERSION_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_VERSION_TOOLONG, $version_length ) ,
					'maximum'=> $version_length
				)
			),
		)
	),

	// Platform check
	'platform' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_PLATFORM_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_PLATFORM_TOOLONG, $platform_length ) ,
					'maximum'=>$platform_length
				)
			),
		)
	),

	// Description check
	'desc' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_DESCRIPTION_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Presence',
				'args'=>array(
					'failureMessage' => _MD_D3DOWNLOADS_DESCRIPTION_NONE
				)
			),
		)	
	),
);

?>