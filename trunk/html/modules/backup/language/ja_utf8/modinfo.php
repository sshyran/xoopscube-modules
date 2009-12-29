<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include_once dirname(__FILE__).'/admin.php';

define('_MI_MYXBACKUP_TITLE',	'MyX_BackUp');
define('_MI_MYXBACKUP_DESC',	'Database BackUp Module for XOOPS');

define('_MI_MYXBACKUP_CFG_DEBUG_TITLE',	'デバッグモード');
define('_MI_MYXBACKUP_CFG_DEBUG_DESC',	'一部の機能を実行せず、画面表示のみとします。');
define('_MI_MYXBACKUP_CFG_CHECK_TITLE',	'テーブルチェックのタイプ');
define('_MI_MYXBACKUP_CFG_CHECK_DESC',	'テーブルチェック時のチェックオプションです。');
define('_MI_MYXBACKUP_CFG_COMPI_TITLE',	'完全なインサート文');
define('_MI_MYXBACKUP_CFG_COMPI_DESC',	'バックアップ時、SQLのINSERT文にフィールド名を含めます。');
define('_MI_MYXBACKUP_CFG_DIRMOD_TITLE','ディレクトリ名をモジュール名とみなす');
define('_MI_MYXBACKUP_CFG_DIRMOD_DESC',	'複製可能モジュールに対応するため、ディレクトリ名もモジュール名とみなします。');
?>