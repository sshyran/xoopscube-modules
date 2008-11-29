<?php

if (defined('WAFFLE_MB_MAIN_PHP')) {
    return;
}

define('WAFFLE_MB_MAIN_PHP', 1);

define("_XD_TITLE","WAFFLE");
define('_MD_NO_YAML', "管理メニューよりカラムを追加してください。設定が見付かりませんでした。%s");

// view
define("_MD_INSERT","追加する");
define("_MD_UPDATE","修正");
define("_MD_DELETE","削除");
define("_MD_DETAIL","詳細");
define("_MD_R_MARK","▼");
define("_MD_NO_DATA","表示するデータがありません");
define("_MD_CSV_OUTPUT","CSV形式で出力する");
define("_MD_BACK","戻る");
define("_MD_NORIGHT","このエリアへのアクセスは権限がありません。");
define("_MD_FILE_DOWNLOAD","添付ファイル");
define("_MD_FILE_NOT_FOUND","ファイルが見つかりませんでした。");

// insert
define("_MD_THANKSSUBMIT","投稿ありがとうございます。");
define("_MD_ADDED","追加しました。");
define("_MD_TIME_INPUT_HINT","※ 12:44:03 のように入力");
define("_MD_DATE_INPUT_HINT","※ 2006-01-04 のように入力");
define("_MD_DATETIME_INPUT_HINT","※ 2006-01-04 12:44:03のように入力");
define("_MD_REFER","参照...");
define("_MD_ADDED_DATA","データを追加しました。");
define("_MD_MAIL_SUBJECT_ADDED_DATA","追加通知");
define("_MD_NOT_NULL","* のついている項目は必ず入力してください");

// delete
define("_MD_DELETE_CONFIRM","削除しますか？");
define("_MD_DELETED","削除しました。");
define("_MD_IDNOTFOUND","IDが見付かりませんでした。");
define("_MD_DELETED_DATA","データを削除しました。");
define("_MD_MAIL_SUBJECT_DELETED_DATA","削除通知");

// update
define("_MD_UPDATED","更新しました。");
define("_MD_UPDATED_DATA","データを更新しました。");
define("_MD_MAIL_SUBJECT_UPDATED_DATA","更新通知");

// index
define("_MD_NO_TABLES","表示できるテーブルはありません。");

?>
