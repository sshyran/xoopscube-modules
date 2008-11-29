<?php

if (defined('WAFFLE_MB_ADMIN_PHP')) {
    return;
}

define('WAFFLE_MB_ADMIN_PHP', 1);


define('_AD_TABLE', 'テーブル');
define('_AD_SETTING', '設定');
define('_AD_GENERAL_SETTING', '一般設定');
define('_AD_SAMPLE', 'サンプル');
define('_AD_EXT', '環境設定');
define('_AD_TABLE_NAME', 'テーブル名');
define('_AD_DESC', '概要');
define('_AD_VALID', '有効');
define('_AD_VALIDABLE', '登録に認証が必要');
define('_AD_EDIT', '編集');
define('_AD_GRANT', '権限');
define('_AD_EDIT_GRANT', '権限修正');
define('_AD_EDIT_COLUMN', 'カラム編集');
define('_AD_DELETE', '削除');
define('_AD_EDIT_TABLE', 'テーブル編集');
define('_AD_COLUMN_NAME', 'カラム名');
define('_AD_COLUMN_OVER_MAX', 'カラム名は %d 文字までです。');
define('_AD_TYPE', '型');
define('_AD_PARAM', '属性');
define('_AD_DETAILVIEW', '詳細画面に表示する');
define('_AD_INSERTVIEW', '追加画面に表示する');
define('_AD_UPDATEVIEW', '更新画面に表示する');
define('_AD_LISTVIEW', 'リストに表示する');
define('_AD_UPDATABLE', '更新可');
define('_AD_SEARCH', '検索対象にする');
define('_AD_ACTION', 'アクション');
define('_AD_ADD_COLUMN', 'カラム追加');
define('_AD_ADD_COLUMN_1', 'カラム追加(1)');
define('_AD_ADD_COLUMN_2', 'カラム追加(2)');
define('_AD_ADD_COLUMN_3', 'カラム追加(3)');
define('_AD_ADD_COLUMN_CONFIRM', 'カラム追加確認');
define('_AD_INPUT_COLUMN_NAME', 'カラム名を入力してください。');
define('_AD_SELECT_TYPE', '型を選択してください。');
define('_AD_NEXT', '次へ');
define('_AD_BACK', '戻る');
define('_AD_CONFIRM', '確認');
define('_AD_DEFAULT', 'デフォルト値');
define('_AD_STRING_MAXLENGTH', '最大文字数(HTML中ではmaxlengthで使われます)');
define('_AD_STRING_SIZE', '入力フィールド文字数(HTML中ではsizeで使われます)');
define('_AD_STRING_DEFAULT', '入力が空だった場合のデフォルト値');
define('_AD_STRING_UNIQ', '一意にする(ユニークにする)');
define('_AD_STRING_NOT_NULL', '空はエラーにする(not null にする)');
define('_AD_STRING_CREATE_OK', '以下の設定でカラムを作成しますか?');
define('_AD_TEXTAREA_MAXLENGTH', '最大文字数');
define('_AD_TEXTAREA_ROWS', '行数');
define('_AD_TEXTAREA_COLS', '桁数');
define('_AD_RADIO_OPTION', '選択肢');
define('_AD_RADIO_OPTION_IS_DEFUALT', '※ラジオボタンはデフォルト値の選択です。');
define('_AD_RADIO_ADD_OPTION', '選択肢を追加する');
define('_AD_RADIO_DELETE_OPTION', '選択肢を削除する');
define('_AD_CHECKBOX_CHECK', 'チェックする');
define('_AD_CHECKBOX_NO_CHECK', 'チェックしない');
define('_AD_DATE_DEFAULT_CHECK', 'デフォルト値をセットする');
define('_AD_UNIQ', 'ユニーク');
define('_AD_MAXLENGTH', '最大文字数');
define('_AD_SIZE', '入力フィールド文字数');
define('_AD_DELETE_COLUMN_OK', 'カラムを削除しましすか? 削除する前にバックアップすることをお薦めします。');
define('_AD_DELETED', '削除しました。');
define('_AD_SELECT_DELETE_OPTION', '削除するオプションをチェックしてください。');
define('_AD_UPDATE', '更新');
define('_AD_UPDATED', '更新しました。');
define('_AD_NO', 'なし');
define('_AD_ADD', '追加');
define('_AD_ADDED', '追加しました。');
define('_AD_ORDER', '表示順');
define('_AD_DEFAULT_SETTING', 'デフォルト設定');
define('_AD_ADDED_COLUMN', 'カラムを追加しました。');
define('_AD_COLUMN_TYPE', '型');
define('_AD_COLUMN_INTEGER', '整数(integer)');
define('_AD_COLUMN_STRING', '文字列(string)');
define('_AD_COLUMN_TEXTAREA', 'テキストエリア(textarea)');
define('_AD_COLUMN_EPOCTIME', '日時(epoctime)');
define('_AD_COLUMN_URL', 'URL(url)');
define('_AD_COLUMN_EMAIL', 'メール(email)');
define('_AD_COLUMN_RADIO', 'ラジオボタン(radio)');
define('_AD_COLUMN_SELECT', 'プルダウン(select)');
define('_AD_COLUMN_CHECKBOX', 'チェックボックス(checkbox)');
define('_AD_COLUMN_LISTBOX', 'リストボックス(listbox)');
define('_AD_COLUMN_USER_ID', 'ユーザID(user_id)');
define('_AD_COLUMN_IMAGE', '画像(image)');
define('_AD_COLUMN_IMAGE_URL', '画像URL(image_url)');
define('_AD_COLUMN_FILE', 'ファイル(file)');
define('_AD_COLUMN_HTMLTEXT', 'HTMLテキスト(htmltext)');
define('_AD_COLUMN_PHP_CODE', 'PHPコード(php_code)');
define('_AD_COLUMN_PASSWORD_PLAIN', 'パスワード(平文)(password_plain)');
define('_AD_COLUMN_PASSWORD_CRYPT', 'パスワード(暗号化)(password_crypt)');
define('_AD_COLUMN_TIME', '時間(time)');
define('_AD_COLUMN_DATE', '日付(date)');
define('_AD_COLUMN_DATETIME', '日時(datetime)');
define('_AD_COLUMN_RELATION', '関連付(relaion)');
define('_AD_COLUMN_MAX_SIZE', 'カラム名は%d文字以内です。');
define('_AD_COLUMN_RELATION_SETTING', '関連付け設定');
define('_AD_COLUMN_RELATION_SETTING2', '関連付け設定2');
define('_AD_COLUMN_RELATION_TABLE', '関連付け先テーブル');
define('_AD_COLUMN_RELATION_COLUMN', '関連付け先カラム');
define('_AD_COLUMN_RELATION_V_COLUMN', '表示カラム');
define('_AD_COLUMN_RELATION_INFO1', '※関連付カラムを追加する前に登録したデータは表示できなくなります。');
define('_AD_COLUMN_RELATION_INFO2', '※関連付先のカラムの型は文字列と数値のみサポートしています。それ以外の場合の型は正しく表示できません。');
define('_AD_PRESET', 'プリセット');
define('_AD_PRESET_DEFAULT', 'デフォルト');
define('_AD_PRESET_PREFECTURE', '都道府県');
define('_AD_SETTING_USE_ADMIN_MAIL', '追加・更新・削除が発生したとき管理者にメールを送信する');
define('_AD_ONE_TABLE_TO_LIST', '表示するテーブルが１つの場合、メニューのクリックでリスト表示をする');

define('_AD_NO_DEFINE', '未定義');

define('_AD_GRANT_READ', '読み込み権限');
define('_AD_GRANT_ADD', '追加権限');
define('_AD_GRANT_UPDATE', '更新権限');
define('_AD_GRANT_DELETE', '削除権限');
define('_AD_GRANT_CSV_OUTPUT', 'CSV出力権限');
define('_AD_GRANT_GROUP', 'グループ権限');
define('_AD_GRANT_USER', 'ユーザ権限');

define('_AD_SAMPLE_CONFIRM', 'サンプルデータを上書きします。このモジュール内のデータ、設定は全て削除されます。');
define('_AD_SAMPLE_INSERT', 'サンプルを投入');
define('_AD_SAMPLE_SUCCESSFUL', 'サンプル投入成功');

define('_AD_CONFIRM_DESC', '承認するデータにチェックを付けてボタンを押して下さい');
define('_AD_CONFIRM_NO_DATA', '承認が必要なデータはありません');
define('_AD_CONFIRM_BODY', '登録内容');

define('_AD_RSS', 'RSS');
define('_AD_RSS_OUTPUT', 'RSS出力');
define('_AD_RSS_SETTING', 'RSS設定');
define('_AD_RSS_TITLE', 'RSSタイトル');
define('_AD_RSS_TOP_URL', 'RSSトップURL');
define('_AD_RSS_SUMMARY', 'RSS概要');
define('_AD_RSS_ITEM_SETTING', '項目毎の設定');
define('_AD_RSS_ITEM_URL', 'URLに使うカラム');
define('_AD_RSS_ITEM_TITLE', 'タイトルに使うカラム');
define('_AD_RSS_ITEM_BODY', '本文に使うカラム');
define('_AD_RSS_ITEM_SUMMARY', '概要に使うカラム');

define('_AD_VERSION_UP', 'バージョンアップ');
define('_AD_VERSION_UP_INFO', 'バージョンアップを行います。実行前にデータのバックアップをお勧めします。（※テーブル追加やカラム追加を行います）');
define('_AD_VERSION_UP_FROM_0_3', 'waffle-0.3 から現バージョンへバージョンアップする');
define('_AD_VERSION_UP_FROM_0_4', 'waffle-0.4/0.5 から現バージョンへバージョンアップする');
define('_AD_VERSION_UP_FROM_0_6', 'waffle-0.6 から現バージョンへバージョンアップする');
define('_AD_VERSION_UP_SUCCESSFUL', 'バージョンアップ完了');
define('_AD_VERSION_UP_CACHE_CLEAR', 'キャッシュクリア');

define('_AD_ADD_TABLE_INFO', 'テーブルの追加を行います');
define('_AD_ADD_TABLE', 'テーブル追加');
define('_AD_ADD_TABLE_SUCCESSFUL', 'テーブル追加完了');
define('_AD_ADD_TABLE_DESC', '※テーブルは%d個までです');

define('_AD_IMAGE_MAX_X', '最大画像幅');
define('_AD_IMAGE_MAX_Y', '最大画像高');
define('_AD_IMAGE_MAX_FILESIZE', '最大ファイルサイズ');
define('_AD_IMAGE_VIEW_MAX_SIZE', '表示時の最大画像サイズ');

$waffle_ad_prefecture =
       array(
	     '北海道',
	     '青森県',
	     '岩手県',
	     '宮城県',
	     '秋田県',
	     '山形県',
	     '福島県',
	     '茨城県',
	     '栃木県',
	     '群馬県',
	     '埼玉県',
	     '千葉県',
	     '東京都',
	     '神奈川県',
	     '新潟県',
	     '富山県',
	     '石川県',
	     '福井県',
	     '山梨県',
	     '長野県',
	     '岐阜県',
	     '静岡県',
	     '愛知県',
	     '三重県',
	     '滋賀県',
	     '京都府',
	     '大阪府',
	     '兵庫県',
	     '奈良県',
	     '和歌山県',
	     '鳥取県',
	     '島根県',
	     '岡山県',
	     '広島県',
	     '山口県',
	     '徳島県',
	     '香川県',
	     '愛媛県',
	     '高知県',
	     '福岡県',
	     '佐賀県',
	     '長崎県',
	     '熊本県',
	     '大分県',
	     '宮崎県',
	     '鹿児島県',
	     '沖縄県',
	     'その他');

?>
