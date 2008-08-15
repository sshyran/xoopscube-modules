<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

//	General
define ("_AM_MYXBACKUP_GOBACK_TO_MENU",	"メニューに戻る");
define ("_AM_MYXBACKUP_ERROR",		"エラーが発生しました。");
define ("_AM_MYXBACKUP_PARAMETERERROR",	"エラーが発生しました。（パラメータが不正か、不足しています））");
define ("_AM_MYXBACKUP_DBCHECKERROR",	"エラーが発生しました。（データベースが変更された可能性があります）");
define ("_AM_MYXBACKUP_FILECHECKERROR",	"エラーが発生しました。（SQLファイルが変更された可能性があります）");
define ("_AM_MYXBACKUP_RESTOREERROR",	"<div style=\"color:#ff0000; font-size:larger; margin-left:20px;\">エラーが発生しました。（このファイルの処理は中断されます）</div>");

//	Index (Menu)
define ("_AM_MYXBACKUP_NOTICEONINDEX",	"処理には時間がかかることがあるので、一度クリックしたらそのままお待ちください。<br />データベースが巨大な場合は、メモリー不足やタイムアウトエラーが起きることがあります。");
define ("_AM_MYXBACKUP_REPORT_TITLE",	"レポート");
define ("_AM_MYXBACKUP_REPORT_DESC",	"XOOPS用のテーブルを一覧表示します。");
define ("_AM_MYXBACKUP_OPTIMIZE_TITLE",	"最適化");
define ("_AM_MYXBACKUP_OPTIMIZE_DESC",	"XOOPS用の各テーブルを最適化します。");
define ("_AM_MYXBACKUP_CHECK_TITLE",	"テーブルチェック");
define ("_AM_MYXBACKUP_CHECK_DESC",	"XOOPS用の各テーブルをチェックし、エラーがあれば修復（Repairコマンド）を試みます。");
define ("_AM_MYXBACKUP_CLEANUP_TITLE",	"テーブル整理");
define ("_AM_MYXBACKUP_CLEANUP_DESC",	"孤立した（モジュールがインストールされていない）テーブルを削除します。<br />モジュールのアンインストールを行うものではありません。");
define ("_AM_MYXBACKUP_BACKUP_TITLE",	"バックアップ");
define ("_AM_MYXBACKUP_BACKUP_DESC",	"XOOPS用のデータベース内容をZIPファイルでバックアップします。<br />モジュール毎にテーブルを復元するためのSQLファイルを生成し、圧縮ファイルにまとめてダウンロードします。");
define ("_AM_MYXBACKUP_BACKUPMOD_TITLE","バックアップ（モジュール単位）");
define ("_AM_MYXBACKUP_BACKUPMOD_DESC",	"XOOPS用のデータベース内容をモジュール単位にZIPファイルでバックアップします。");
define ("_AM_MYXBACKUP_DUMP_TITLE",	"ダンプ");
define ("_AM_MYXBACKUP_DUMP_DESC",	"XOOPS用のデータベース内容をSQLテキストでダンプします。<br />内容はバックアップとほぼ同じものですが、単一のファイルになります。");
define ("_AM_MYXBACKUP_EXPORT_TITLE",	"エクスポート");
define ("_AM_MYXBACKUP_EXPORT_DESC",	"データベースの内容をcsv形式でエクスポートします。");
define ("_AM_MYXBACKUP_RESTORE_TITLE",	"復元");
define ("_AM_MYXBACKUP_RESTORE_DESC",	"バックアップしたテーブル内容をデータベースに復元します。<br />このモジュールのディレクトリの下にあるsqlディレクトリに拡張子がsqlのファイルをFTP転送しておいてください。");
define ("_AM_MYXBACKUP_CONFIG_TITLE",	"一般設定");
define ("_AM_MYXBACKUP_CONFIG_DESC",	"デバッグモードやバックアップ形式の設定を行います。");
define ("_AM_MYXBACKUP_SQLFILE_EXSITS",	"SQLディレクトリにファイルが存在します。<br />復元を行わない場合は削除しておきましょう。");

//	Report / Check
define ("_AM_MYXBACKUP_LIST_Prefix",		"PREFIX");
define ("_AM_MYXBACKUP_LIST_Name",		"テーブル名");
define ("_AM_MYXBACKUP_LIST_Table",		"テーブル");
define ("_AM_MYXBACKUP_LIST_ModName",		"モジュール");
define ("_AM_MYXBACKUP_LIST_Rows",		"レコード数");
define ("_AM_MYXBACKUP_LIST_Data_length",	"サイズ");
define ("_AM_MYXBACKUP_LIST_Avg_row_length",	"平均サイズ");
define ("_AM_MYXBACKUP_LIST_Data_free",		"オ－バーヘッド");
define ("_AM_MYXBACKUP_LIST_Update_time",	"更新日時");
define ("_AM_MYXBACKUP_LIST_Status",		"ステータス");
define ("_AM_MYXBACKUP_LIST_Command",		"処理");

//	Optimize
define ("_AM_MYXBACKUP_OPTIMIZED",		"<span style=\"color:#00ff00;\">最適化されました</span>");
define ("_AM_MYXBACKUP_NOTOPTIMIZED",		"<span style=\"color:#ff0000;\">最適化は失敗しました</span>");
define ("_AM_MYXBACKUP_NONEEDOPTIMIZED",	"<span style=\"color:#000000;\">最適化は不要です</span>");
define ("_AM_MYXBACKUP_NOTABLE_OPTIMIZED",	"最適化が必要なテーブルがありませんでした");

//	Delete
define ("_AM_MYXBACKUP_NOTABLES_TO_DELETE",	"削除が必要なテーブルは見付かりませんでした");
define ("_AM_MYXBACKUP_TABLE_DELETED",		"は削除されました");
define ("_AM_MYXBACKUP_TABLE_NOTDELETED",	"の削除時にエラーがありました");
define ("_AM_MYXBACKUP_CHECK_TO_DELETE",	"削除対象");

//	Restore
define ("_AM_MYXBACKUP_NOSQLFILES",		"必要なSQLファイルが見付かりません<br />先に転送を行ってください");
define ("_AM_MYXBACKUP_SQL_NAME",		"SQLファイル名");
define ("_AM_MYXBACKUP_SQL_PREFIX",		"SQL中のPREFIX");
define ("_AM_MYXBACKUP_SQL_DATE",		"ファイル作成日");
define ("_AM_MYXBACKUP_SQLPREFIX",		"SQLファイルのテーブル名に含まれるPREFIXを入力してください");
define ("_AM_MYXBACKUP_MYPREFIX",		"現在のPREFIX");
define ("_AM_MYXBACKUP_GO_RESTORE",		"開始");
define ("_AM_MYXBACKUP_GO_RESTORE_NOTE",	"復元を開始する（中止・取消はできません！！）");
define ("_AM_MYXBACKUP_RESTORE_DONE",		"処理は終了しました。SQLファイルを必ず削除してください。");

//	Clean Up
define ("_AM_MYXBACKUP_CAUTIONTODEL",		"<span style=\"color:#ff0000;\">複製可能モジュールによっては、必要なテーブルが「削除対象」となる場合があります<br />不要であることが明確なもののみを削除するようにしてください<br />また、必ずバックアップをしておいてください</span>");
define ("_AM_MYXBACKUP_TAKERISK",		"危険性を理解して実行する");
?>