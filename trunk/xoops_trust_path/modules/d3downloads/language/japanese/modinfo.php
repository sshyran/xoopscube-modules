<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3downloads' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","D3対応ダウンロードモジュール");

// A brief description of this module
define($constpref."_DESC","ユーザが自由にダウンロード情報の登録／評価を行えるセクションを作成します。");

// admin menus
define($constpref.'_ADMENU_FILEMANAGER','ダウンロード情報管理') ;
define($constpref.'_ADMENU_APPROVALMANAGER','ダウンロード情報承認') ;
define($constpref.'_ADMENU_CATEGORYMANAGER','カテゴリ管理') ;
define($constpref.'_ADMENU_IMPORT','インポート/アップデート') ;
define($constpref.'_ADMENU_CONFIG_CHECK','アップロード環境チェック') ;
define($constpref.'_ADMENU_MYLANGADMIN','言語定数管理') ;
define($constpref.'_ADMENU_MYTPLSADMIN','テンプレート管理') ;
define($constpref.'_ADMENU_MYBLOCKSADMIN','ブロック管理/アクセス権限') ;
define($constpref.'_ADMENU_MYPREFERENCES','一般設定') ;

// blocks
define($constpref.'_BNAME_RECENT','新着ダウンロード') ;
define($constpref.'_BNAME_TOPRANK','高人気ダウンロード') ;
define($constpref.'_BNAME_DOWNLOAD','ダウンロード情報内容') ;
define($constpref.'_BNAME_LIST','ダウンロード情報一覧') ;

// Sub menu titles
define($constpref.'_SMNAME1','人気ダウンロード');
define($constpref.'_SMNAME2','高評価ダウンロード');

// Title of config items
define($constpref.'_POPULAR','「人気ダウンロード」になるためのダウンロード数');
define($constpref.'_NEWDLS','トップページの「新着ダウンロード」に表示する件数');
define($constpref.'_NEWMARK','「新着」「アップデート」アイコンを表示する日数');
define($constpref.'_PERPAGE','１ページ毎に表示するダウンロード情報の件数');
define($constpref.'_BREADCRUMBS','パンくずを表示する');
define($constpref.'_USESHOTS','スクリーンショット画像を表示する');
define($constpref.'_USEALBUM','myAlbum-P で登録した画像をスクリーンショット画像として利用する');
define($constpref.'_USEALBUMDSC','「スクリーンショット画像を表示する」を有効に設定している場合に、myAlbum-P モジュールで登録した画像をスクリーンショット画像として利用することができます。');
define($constpref.'_ALBUMSELECT','連携して利用する myAlbum-P の dirname');
define($constpref.'_ALBUMSELECTDSC','連携して利用する myAlbum-P モジュールの dirname を入力してください(記入例 myalbum)。');
define($constpref.'_SHOTSSELECT','サムネイルWebサービスを利用してスクリーンショット画像を表示する');
define($constpref.'_SHOTSSELECTDSC','「スクリーンショット画像を表示する」を有効に設定し、スクリーンショット画像の指定がない場合に、サムネイルWebサービスを利用して代替画像を表示します。');
define($constpref.'_SHOTWIDTH','スクリーンショットの画像幅');
define($constpref.'_CHECKURL','同じリンク先の登録をチェックする');
define($constpref.'_CHECKHOST','ダイレクトリンクの禁止(leeching)');
define($constpref.'_REFERERS','これらのサイトはファイルへのダイレクトリンクが可能<br />各サイトは | で分割');
define($constpref.'_PER_HISTORY','履歴として残す世代数');
define($constpref.'_EXTENSION','アップロードを許可する拡張子');
define($constpref.'_EXTENSIONDSC','アップロードを許可する拡張子を | で区切って入力してください。すべて小文字で指定し、ピリオドや空白は入れないで下さい。なお、phpやphtml などの拡張子は指定しても無視されます。');
define($constpref.'_MAXFILESIZE','アップロード時の最大ファイルサイズ(KB)');
define($constpref.'_MULTIDOT','アップロード時に multiple dot file のチェックをする');
define($constpref.'_MULTIDOTDSC','multiple dot file(ドット(.)が 2つ以上ある名前のファイル)のアップロードを許可するかどうかを設定します。multiple dot file は拡張子偽造の可能性があるため、標準ではアップロード処理を強制終了します。');
define($constpref.'_CHECKHEAD','アップロード時にファイルのヘッダをチェックする');
define($constpref.'_CHECKHEADDSC','標準ではファイルアップロード時にファイルの先頭部分をチェックし、不正なアップロードと判断した場合に強制終了します。できる限り正確なチェックをしようとしていますが、誤認識もあり得ます。誤認識などがある場合には「いいえ」に設定してください。');
define($constpref.'_EDITOR','本文編集エディタ');
define($constpref.'_EDITORDSC','fckeditor は、HTMLを許可したカテゴリでのみ有効になり、HTML を許可しないカテゴリでは無条件で xoopsdhtml となります。');
define($constpref.'_PURIFIER','HTML 許可時に危険なタグを除去する');
define($constpref.'_PURIFIERDSC','標準では HTML 許可時に XSS につながるような危険なタグを除去します。投稿者が信頼できるユーザーに限定される場合を除いて、「はい」がお勧めです。');
define($constpref.'_PLATFORM','利用可能な OS/ソフト等');
define($constpref.'_PLATFORMDSC','利用可能な OS/ソフト等を | で区切って入力してください。ここで設定した項目が投稿フォームのセレクトボックスで選択できるようになります。');
define($constpref.'_TELLAFRINED','Tell A Friendモジュールを利用する');
define($constpref.'_PER_RSS','RSSの表示件数');
define($constpref.'_COM_DIRNAME','コメント統合するd3forumのdirname');
define($constpref.'_COM_FORUM_ID','コメント統合するフォーラムの番号');
define($constpref.'_COM_VIEW','コメント統合の表示方法');

define($constpref.'_POPULARDSC','「人気！」アイコンが表示されるためのダウンロード件数を指定してください。');
define($constpref.'_NEWDLSDSC','トップページの「新着ダウンロード」に表示する最大件数を指定してください。');
define($constpref.'_PERPAGEDSC','ダウンロード一覧表示で１ページあたりに表示する最大件数を指定してください。');
define($constpref.'_SHOTWIDTHDSC','スクリーンショット画像の横幅の最大値を指定してください。');
define($constpref.'_REFERERSDSC','ファイルへのダイレクトリンクを許可する外部サイトを列挙してください。');

// Notify Categories
define($constpref.'_NOTCAT_CAT', '表示中のカテゴリ');
define($constpref.'_NOTCAT_CATDSC', '表示中のカテゴリに対する通知オプション');
define($constpref.'_NOTCAT_GLOBAL', 'モジュール全体');
define($constpref.'_NOTCAT_GLOBALDSC', 'フォーラムモジュール全体における通知オプション');

// Each Notifications
define($constpref.'_NOTIFY_CAT_NEWPOST', 'カテゴリ内投稿');
define($constpref.'_NOTIFY_CAT_NEWPOSTCAP', 'このカテゴリに投稿があった場合に通知する');
define($constpref.'_NOTIFY_CAT_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} カテゴリ内投稿');

define($constpref.'_NOTIFY_CAT_NEWPOSTFULL', 'カテゴリ内投稿全文');
define($constpref.'_NOTIFY_CAT_NEWPOSTFULLCAP', 'このカテゴリに投稿があった場合に投稿全文を通知します。');
define($constpref.'_NOTIFY_CATL_NEWPOSTFULLSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} カテゴリ内投稿全文');

define($constpref.'_NOTIFY_CAT_NEWFORUM', 'カテゴリ内新フォーラム');
define($constpref.'_NOTIFY_CAT_NEWFORUMCAP', 'このカテゴリにおいて新フォーラムが立てられた場合に通知する');
define($constpref.'_NOTIFY_CAT_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} カテゴリ内新フォーラム');

define($constpref.'_NOTIFY_GLOBAL_NEWPOST', '新投稿全体');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP', 'このモジュール全体のいずれかに投稿があった場合に通知する');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}: 投稿');

define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORY', 'モジュール全体');
define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYCAP', 'このモジュール全体のいずれかに新カテゴリが立てられた場合に通知する');
define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYSBJ', '[{X_SITENAME}] {X_MODULE}: 新カテゴリ');

define($constpref.'_NOTIFY_GLOBAL_WAITING', '承認待ち');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCAP', '承認を要する投稿・編集が行われた場合に通知します。管理者専用');
define($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ', '[{X_SITENAME}] {X_MODULE}: 承認待ち');

define($constpref.'_NOTIFY_GLOBAL_BROKEN', 'ファイル破損報告');
define($constpref.'_NOTIFY_GLOBAL_BROKENCAP', 'ファイル破損報告が行われた場合に通知します。管理者専用');
define($constpref.'_NOTIFY_GLOBAL_BROKENSBJ', '[{X_SITENAME}] {X_MODULE}: ファイル破損の報告がありました');

define($constpref.'_NOTIFY_GLOBAL_APPROVE', 'ファイル承認');
define($constpref.'_NOTIFY_GLOBAL_APPROVECAP', 'このファイルが承認された場合に通知する');
define($constpref.'_NOTIFY_GLOBAL_APPROVECAPSBJ', '[{X_SITENAME}] {X_MODULE}: ファイルが承認されました');

}
?>