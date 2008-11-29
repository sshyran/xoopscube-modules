<?php

if (defined('__WAFFLE_CONFIG__')) {
    return;
}
define('__WAFFLE_CONFIG__', '1');

$waffle_mydirname = basename( dirname( __FILE__ ) ) ;

define('WAFFLE_USE_PLUGIN', 1);

define('WAFFLE_TABLE_MAX', 30);
define('WAFFLE_COLUMN_MAX', 60);
define('WAFFLE_OPTION_MAX', 255);

define('WAFFLEMAP_DEFAULT_LIMIT', 10);
define('WAFFLE_MAX_TABLE_NAME_SIZE', 60);
define('WAFFLE_MAX_COLUMN_NAME_SIZE', 60);

define('WAFFLE_TABLE_NO', 'table_no');
define('WAFFLE_TABLE_DEFAULT_NO', 10);

define('WAFFLE_ONE_TABLE_TO_LIST', 'one_table_to_list');

define('WAFFLE_COLUMN_INTEGER',   1);
define('WAFFLE_COLUMN_STRING',    2);
define('WAFFLE_COLUMN_TEXTAREA',  3);
define('WAFFLE_COLUMN_EPOCTIME',  4);
define('WAFFLE_COLUMN_URL',       5);
define('WAFFLE_COLUMN_EMAIL',     6);
define('WAFFLE_COLUMN_RADIO',     7);
define('WAFFLE_COLUMN_SELECT',    8);
define('WAFFLE_COLUMN_CHECKBOX',  9);
define('WAFFLE_COLUMN_LISTBOX',   10);
define('WAFFLE_COLUMN_USER_ID',   11);
define('WAFFLE_COLUMN_IMAGE',     12);
define('WAFFLE_COLUMN_IMAGE_URL', 13);
define('WAFFLE_COLUMN_FILE',      14);
define('WAFFLE_COLUMN_HTMLTEXT',  15);
define('WAFFLE_COLUMN_PHP_CODE',  16);
define('WAFFLE_COLUMN_PASSWORD_PLAIN',  17);
define('WAFFLE_COLUMN_PASSWORD_CRYPT',  18);
define('WAFFLE_COLUMN_TIME',      19);
define('WAFFLE_COLUMN_DATE',      20);
define('WAFFLE_COLUMN_DATETIME',  21);
define('WAFFLE_COLUMN_RELATION',  22);

define('WAFFLE_CREATE_DATETIME_COLUMN_NAME', 'reg_time');
define('WAFFLE_UPDATE_DATETIME_COLUMN_NAME', 'mod_time');
define('WAFFLE_CREATE_USER_ID_COLUMN_NAME', 'reg_user_id');
define('WAFFLE_UPDATE_USER_ID_COLUMN_NAME', 'mod_user_id');

define('WAFFLE_GRANT_READ', 1);
define('WAFFLE_GRANT_ADD', 2);
define('WAFFLE_GRANT_UPDATE', 3);
define('WAFFLE_GRANT_DELETE', 4);
define('WAFFLE_GRANT_CSV_OUTPUT', 5);

define('WAFFLE_CSV_OUTPUT_TO_ENCODING', 'SJIS');
define('WAFFLE_CSV_OUTPUT_FROM_ENCODING', 'euc-jp');

define('WAFFLE_IMAGE_MAX_X', 'image_max_x');
define('WAFFLE_IMAGE_MAX_Y', 'image_max_y');
define('WAFFLE_IMAGE_MAX_FILESIZE', 'image_max_filesize');
define('WAFFLE_IMAGE_DIR', 'image_iamge_dir');
define('WAFFLE_IMAGE_VIEW_MAX_SIZE', 'image_view_max_size');

define('WAFFLE_IMAGE_DEFAULT_MAX_X', 640);
define('WAFFLE_IMAGE_DEFAULT_MAX_Y', 640);
define('WAFFLE_IMAGE_DEFAULT_MAX_FILESIZE', (1024 * 1024));
define('WAFFLE_IMAGE_DEFAULT_DIR', $waffle_mydirname);
define('WAFFLE_IMAGE_DEFAULT_VIEW_MAX_SIZE', 240);

define('WAFFLE_SETTING_USE_ADMIN_MAIL', 'waffle_setting_use_admin_mail');

define('WAFFLE_FILE_INDEX_NAME', 'waffle_file_index_name');

define('YAML_DIR', XOOPS_ROOT_PATH . '/modules/' . $waffle_mydirname . '/yaml/');
define('PLUGIN_DIR', XOOPS_ROOT_PATH . '/modules/' . $waffle_mydirname . '/plugin/');

define('WAFFLE_DEFAULT_INDEX_PHP', 'index.php');

$support_column = array(
			'1' => '1',
			'2' => '1',
			'3' => '1',
			'5' => '1',
			'6' => '1',
			'7' => '1',
			'8' => '1',
			'9' => '1',
			'12' => '1',
			'13' => '1',
			'14' => '1',
			'15' => '1',
			'16' => '1',
			'17' => '1',
			'19' => '1',
			'20' => '1',
			'21' => '1',
			'22' => '1'
			);

$search_column = array(
			'2' => '1',
			'3' => '1',
			'5' => '1',
			'6' => '1',
			'15' => '1',
			'16' => '1'
			);

$edit_column_ok = array(
			'2' => '1',
			'3' => '1',
			'5' => '1',
			'6' => '1',
			'7' => '1',
			'8' => '1',
			'15' => '1',
			'16' => '1',
			'17' => '1'
			);

$no2dbtype = array(
'1' => 'integer',
'2' => 'mediumtext',
'3' => 'mediumtext',
'4' => 'integer',
'5' => 'text',
'6' => 'text',
'7' => 'tinyint',
'8' => 'tinyint',
'9' => 'tinyint',
'10' => 'tinyint',
'11' => 'integer',
'12' => 'integer',
'13' => 'text',
'14' => 'text',
'15' => 'mediumtext',
'16' => 'mediumtext',
'17' => 'text',
'18' => 'text',
'19' => 'time',
'20' => 'date',
'21' => 'datetime',
'22' => 'integer'
	);

$no2type = array(
'1' => 'integer',
'2' => 'string',
'3' => 'textarea',
'4' => 'epoctime',
'5' => 'url',
'6' => 'email',
'7' => 'radio',
'8' => 'select',
'9' => 'checkbox',
'10' => 'listbox',
'11' => 'user_id',
'12' => 'image',
'13' => 'image_url',
'14' => 'file',
'15' => 'htmltext',
'16' => 'php_code',
'17' => 'password_plain',
'18' => 'password_crypt',
'19' => 'time',
'20' => 'date',
'21' => 'datetime',
'22' => 'relation'
	);

$type2no = array(
'integer'   => '1',
'string'    => '2',
'textarea'  => '3',
'epoctime'  => '4',
'url'       => '5',
'email'     => '6',
'radio'     => '7',
'select'    => '8',
'checkbox'  => '9',
'listbox'   => '10',
'user_id'   => '11',
'image'     => '12',
'image_url' => '13',
'file'      => '14',
'htmltext'  => '15',
'php_code'  => '16',
'password_plain' => '17',
'password_crypt' => '18',
'time'      => '19',
'date'      => '20',
'datetime'  => '21',
'relation'  => '22'
	);

$no2grant = array(
		  '1' => 'READ',
		  '2' => 'ADD',
		  '3' => 'UPDATE',
		  '4' => 'DELETE',
		  '5' => 'CSV_OUTPUT',
		  );

?>
