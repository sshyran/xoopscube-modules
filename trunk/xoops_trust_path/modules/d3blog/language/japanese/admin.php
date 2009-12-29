<?php
/**
 * @version $Id: admin.php 300 2008-02-27 02:47:17Z hodaka $
 * @author kuri <kuri@keynext.co.jp>
 */

// <--- LANG PROPERTY --->
define ( '_MD_A_D3BLOG_LANG_EDIT','編集' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_MANAGER','カテゴリー管理' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_LIST','カテゴリー一覧' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_NAME','カテゴリー名' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_PARENT','親カテゴリー' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_WEIGHT','表示順' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_IMAGE','カテゴリーイメージ' );
define ( '_MD_A_D3BLOG_LANG_REGISTER_ANDOR_EDIT_CATEGORY','カテゴリーの新規登録/編集' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_GLOBAL','モジュール全体' );
define ( '_MD_A_D3BLOG_LANG_PERMISSION_MANAGER','パミッション管理' );
define ( '_MD_A_D3BLOG_LANG_GROUP_NAME','グループ名' );
define ( '_MD_A_D3BLOG_LANG_SELECT_INPORTMODULE','インポート元モジュールを選択' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_MANAGER','承認管理' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_SUMMARY','承認申請のあるデータ一覧' );
define ( '_MD_A_D3BLOG_LANG_ENTRY_TITLE','エントリ名' );
define ( '_MD_A_D3BLOG_LANG_BLOG_TITLE','ブログ名' );
define ( '_MD_A_D3BLOG_LANG_ENTRY_DATE','投稿日' );
define ( '_MD_A_D3BLOG_LANG_COMMENTER','投稿者/ブログ名' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE','承認タイプ' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_ENTRY','エントリ' );
define ( '_MD_A_D3BLOG_LANG_CREATE_DATE','投稿日' );
define ( '_MD_A_D3BLOG_LANG_BLOG_NAME_INBOUND','ブログ名' );
define ( '_MD_A_D3BLOG_LANG_BLOG_EXCERPT_INBOUND','要約' );
define ( '_MD_A_D3BLOG_LANG_TRACKBACK_DATE_INBOUND','受信日' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_COMMENT','コメント' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_TRACKBACK','トラバ' );
define ( '_MD_A_D3BLOG_LANG_COMMENTS','コメント/要約' );
define ( '_MD_A_D3BLOG_LANG_COMMENT_DATE','受信日' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL','承認' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_NAME','テンプレート名' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_TYPE','タイプ' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_FILE','オリジナルファイル' );
define ( '_MD_A_D3BLOG_LANG_CSS_FILE','CSSファイル' );
define ( '_MD_A_D3BLOG_LANG_WRITE_CSS_FILE','書き出し' );

// <--- MESSAGE PROPERTY --->
define ( '_MD_A_D3BLOG_MESSAGE_DBUPDATE_SUCCESS','DB更新が完了しました' );
define ( '_MD_A_D3BLOG_MESSAGE_DBUPDATE_FAILED','DB更新時エラーが発生しました' );
define ( '_MD_A_D3BLOG_MESSAGE_DELETE_SUCCESSED','%sを削除しました' );
define ( '_MD_A_D3BLOG_MESSAGE_DELETE_FAILED','%sの削除ができませんでした' );
define ( '_MD_A_D3BLOG_MESSAGE_IMPORTDONE','インポートが完了しました' );
define ( '_MD_A_D3BLOG_MESSAGE_MIGHT_REWRITE_LINKPATH','</br />本文のリンクパス書き換えを忘れないでください。' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_UPDATE_SUCCESS','%sの更新が終了しました' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_DELETE_SUCCESS','%sの削除が終了しました' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_UPDATE_FAILED','%sの更新が失敗しました' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_DELETE_FAILED','%sの削除が失敗しました' );
define ( '_MD_A_D3BLOG_MESSAGE_ARE_YOU_SURE_TO_OVERWRITE_CSSFILE','CSSファイルを上書きしていいですか？' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_OPEN_CSS_DIR','書き込み権限のあるCSSディレクトリ %s がありません。先に作成してください。' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_DIR','CSSディレクトリ %s に書き込み権限がありません。' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_FILE','スタイルシート %s には書き込み権限がありません。' );
define ( '_MD_A_D3BLOG_MESSAGE_NOT_CSS_FILE','%s はCSSファイルではありません。削除してください。' );
define ( '_MD_A_D3BLOG_MESSAGE_YOU_MUST_PREPARE_CSS_DIRECTORY','操作は無効です。CSSディレクトリを整えてください。' );
define ( '_MD_A_D3BLOG_MESSAGE_CSS_FILES_SUCCESSFULLY_WRITTEN','CSSファイルの書き込みが終了しました。' );

// <--- ERROR PROPERTY --->
define ( '_MD_A_D3BLOG_ERROR_WRONG_PID','親カテゴリがありません。テーブルが壊れているかも。' );
define ( '_MD_A_D3BLOG_ERROR_NAME_REQUIRED','カテゴリ名は必須です' );
define ( '_MD_A_D3BLOG_ERROR_NAME_SIZEOVER','カテゴリ名の長さが%sを超えています' );
define ( '_MD_A_D3BLOG_ERROR_WRONG_IMGURL','imgurlのフォーマットが不正です' );
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_CATEGORY','該当するカテゴリがありません' );
define ( '_MD_A_D3BLOG_ERROR_INVALIDMID', 'モジュールIDが正しくありません');
define ( '_MD_A_D3BLOG_ERROR_SQLONIMPORT', 'データベースアクセス（sql）エラーです');
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_TEMPLATE_SET','テンプレートセットが無効です。' );
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_TEMPLATE_FILE','テンプレート名 %s が無効です。' );

// <--- FORMAT PROPERTY --->
define ( '_MD_A_D3BLOG_FORMAT_CSS_DIRECTORY','CSSディレクトリは %s です。' );

// <--- PERMDESC PROPERTY --->
define ( '_MD_A_D3BLOG_PERMDESC_CAN_VIEW_BLOG','閲覧可能' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_EDIT_BLOG','投稿・編集可能' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_APPROVE_BLOG_SELF','自己承認可能' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_VIEW_COM','コメント閲覧可能' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_EDIT_COM','コメント投稿可能' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_APPROVE_COM_SELF','コメント承認不要' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_DELETE_COM_SELF','コメント削除許可' );
define ( '_MD_A_D3BLOG_PERMDESC_ALLOW_HTML','HTML許可' );
define ( '_MD_A_D3BLOG_PERMDESC_EDITOR','編集者' );

$xoopsModule =& XoopsModule::getByDirname($mydirname);
define('_MD_A_D3BLOG_CONFIG', $xoopsModule->getVar('name').'設定');
define('_MD_A_D3BLOG_PREFERENCES', _PREFERENCES);
define('_MD_A_D3BLOG_PREFERENCESDSC', '基本的な動作を設定します');
define('_MD_A_D3BLOG_GO', _GO);
define('_MD_A_D3BLOG_CANCEL', _CANCEL);
define('_MD_A_D3BLOG_DELETE', _DELETE);
define('_MD_A_D3BLOG_MODIFY', '変更する');
define('_MD_A_D3BLOG_TITLE', 'Title');

// <--- STRUCTURE PROPERTY --->
define('_MD_A_D3BLOG_H2_IMPORTFROM', 'インポートマネジャー');
define('_MD_A_D3BLOG_H3_IMPORTDATABASE', 'データベースのコピー');
define('_MD_A_D3BLOG_H3_IMPORTCOM', 'コメント、イベント通知のインポート');
define('_MD_A_D3BLOG_H3_SYNCHRONIZE', 'コメント・トラックバック数の再集計');
define('_MD_A_D3BLOG_LABEL_SELECTMODULE', 'インポート元モジュール');
define('_MD_A_D3BLOG_LABEL_SELECTDIRECTORY', '移動元モジュール');
define('_MD_A_D3BLOG_LANG_SELECT_IMPORTMODULE', '選択してください');
define('_MD_A_D3BLOG_BTN_DOIMPORT', 'インポート開始');
define('_MD_A_D3BLOG_BTN_DOIMAGEIMPORT', '移動開始');
define('_MD_A_D3BLOG_BTN_DOSYNCHRONIZE', '再集計開始');
define('_MD_A_D3BLOG_CONFIRM_DOIMPORT', 'データベースをインポートしていいですか？');
define('_MD_A_D3BLOG_CONFIRM_DOCOMIMPORT', 'コメント、イベント通知をインポートしていいですか？');
define('_MD_A_D3BLOG_CONFIRM_DOSYNCHRONIZE', '再集計していいですか？');
define('_MD_A_D3BLOG_HELP_IMPORTFROM', '<p>インポート元からテーブルデータを<strong>コピー</strong>します。インポート元のテーブルデータはモジュールをアンインストールするまで確保されます。</p>'.
    '<p><strong style="padding-right:1em">注意</strong>ブロック、テンプレート、一般設定項目は移行対象ではありません。</p>');
define('_MD_A_D3BLOG_HELP_COMIMPORT', '<p>指定したインポート元に投稿されたコメント、イベント通知データをこのモジュールに移します。</p>'.
    '<p><strong style="padding-right:1em">注意</strong>インポート元含めコメント投稿数を再集計します。</p>');
define('_MD_A_D3BLOG_HELP_SYNCHRONIZE', '<p>コメントとトラックバック数を再集計します。</p>'.
    '<p><strong style="padding-right:1em">注意</strong>phpmyadminなどでデータベースを編集した場合など、集計が狂ったら補正します。</p>');
define ( '_MD_A_D3BLOG_H2_CSSMANAGER','CSSマネジャー' );
define ( '_MD_A_D3BLOG_H3_WRITE_CSSFILE','スタイルシートファイルの書き出し' );
define ( '_MD_A_D3BLOG_HELP_CSSMANAGER', '<p>テンプレートからCSSファイルを書き出します。該当テンプレートをチェックして「書き出し」をクリックします。</p>'.
    '<p><strong style="padding-right:1em">注意</strong>カレントのテンプレートセットがCSSファイルの最終更新日よりも新しい場合、自動的にチェックが入ります。</p>');

?>