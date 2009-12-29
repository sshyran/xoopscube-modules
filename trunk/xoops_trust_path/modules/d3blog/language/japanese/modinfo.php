<?php
/**
 * @version $Id: modinfo.php 622 2009-09-06 17:23:01Z hodaka $
 * @author kuri <kuri@keynext.co.jp>
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3blog' ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// <--- BASIC PROPERTY --->
define ( $constpref.'_BASIC_MODULE_NAME','D3ブログ' );
define ( $constpref.'_BASIC_MODULE_NAME_DSC','D3版Xoopsブログシステム' );

// <--- SUBMENU PROPERTY --->
define ( $constpref.'_SUBMENU_POST','投稿する' );
define ( $constpref.'_SUBMENU_MY_BLOG','マイブログ' );
define ( $constpref.'_SUBMENU_ARCHIVES','アーカイブ' );

// <--- ADMENU PROPERTY --->
define ( $constpref.'_ADMENU_CATEGORY_MANAGER','カテゴリ管理' );
define ( $constpref.'_ADMENU_PERMISSION_MANAGER','パミッション管理' );
define ( $constpref.'_ADMENU_APPROVAL_MANAGER','承認管理' );
define ( $constpref.'_ADMENU_IMPORT_MANAGER','インポート' );
define ( $constpref.'_ADMENU_CSS_MANAGER','CSSマネジャー' );
define ( $constpref.'_ADMENU_MYLANGADMIN','言語定数管理' ) ;
define ( $constpref.'_ADMENU_MYTPLSADMIN','テンプレート管理' ) ;
define ( $constpref.'_ADMENU_MYBLOCKSADMIN','ブロック管理/モジュールアクセス権限' ) ;
define ( $constpref.'_ADMENU_MYPREFERENCES','一般設定' ) ;

// <--- BLOCKS PROPERTY --->
define ( $constpref.'_CALENDAR', 'ブログ カレンダー');
define ( $constpref.'_CALENDAR_DESC', '１ヶ月カレンダー');
define ( $constpref.'_CATEGORY_LIST', 'カテゴリ一覧');
define ( $constpref.'_CATEGORY_LIST_DESC', '件数つきカテゴリ一覧');
define ( $constpref.'_ARCHIVE_LIST', 'アーカイブ');
define ( $constpref.'_ARCHIVE_LIST_DESC', 'アーカイブの検索');
define ( $constpref.'_LATEST_ENTRIES','最新のエントリ');
define ( $constpref.'_LATEST_ENTRIES_DESC','最新エントリの一覧');
define ( $constpref.'_LATEST_TRACKBACKS','最新のトラックバック');
define ( $constpref.'_LATEST_TRACKBACKS_DESC','最近受信したトラックバック一覧');
define ( $constpref.'_LATEST_COMMENTS','最新のコメント');
define ( $constpref.'_LATEST_COMMENTS_DESC','ブログのエントリに最近付けられたコメント');
define ( $constpref.'_BLOGGERS_LIST', 'ブロガー一覧');
define ( $constpref.'_BLOGGERS_LIST_DESC', 'ブロガーの一覧');

// <--- CFG PROPERTY --->
define ( $constpref.'_WYSIWYG','使用エディタ' );
define ( $constpref.'_WYSIWYG_DSC','FCKeditor、Quicktagはhtml権限のあるユーザーのみ使用可' );
define ( $constpref.'_NO_WYSIWYG','xoopsデフォルト' );
define ( $constpref.'_WYSIWYG_FCK','FCKエディタ' );
define ( $constpref.'_WYSIWYG_QUICKTAG','QUICKタグ' );
define ( $constpref.'_PERM_BY','エントリ単位で閲覧権限を設定する' );
define ( $constpref.'_PERM_BY_DSC','各エントリ毎に投稿・編集時に閲覧可能なグループが選択できます。<br />ただし、パミッション管理で閲覧不可としたグループはいっさい閲覧できません。' );
define ( $constpref.'_PERMED','許可するグループのデフォルト' );
define ( $constpref.'_PERMED_DSC','エントリ単位の閲覧権限を設定した場合のグループ初期値です。<br /><span style="font-weight:bold">グループを追加した場合は、先にモジュールアップデートする必要があります。</span>' );
define ( $constpref.'_EXCERPTOK','タイトル・要約部分は閲覧可能' );
define ( $constpref.'_EXCERPTOK_DSC','エントリ単位で閲覧権限のないグループでも、タイトル・要約部分は閲覧可能になります。' );
define ( $constpref.'_NUMPERPAGE','ページ当たり表示記事数' );
define ( $constpref.'_NUMPERPAGE_DSC','最新一覧ページに一度に表示する記事数' );
define ( $constpref.'_MAX_FEED','RDFフィード記事数' );
define ( $constpref.'_MAX_FEED_DSC','フィード要求があったとき返信する記事数の限度。' );
define ( $constpref.'_RSSICON','RSSフィードアイコンを表示する' );
define ( $constpref.'_RSSICON_DSC','表示場所はテンプレート編集で自由に決めてください。' );
define ( $constpref.'_AVATAR','各記事にアバタを表示する' );
define ( $constpref.'_AVATAR_DSC','表示方法はテンプレート編集でご自由に。' );
define ( $constpref.'_LOGOPATH','モジュールロゴファイルのパス' );
define ( $constpref.'_LOGOPATH_DSC','rss、印刷ページ用。絶対パスで指定してください。' );
define ( $constpref.'_INCREMENT','ブログ投稿をユーザー投稿数に加える' );
define ( $constpref.'_INCREMENT_DSC','' );
define ( $constpref.'_CAT_ICON','カテゴリアイコンを置くディレクトリのパス' );
define ( $constpref.'_CAT_ICON_DSC','絶対パスで指定してください。アイコンはftpツールでアップします。' );
define ( $constpref.'_URL_CHOICE','更新pingサーバーを投稿時指定する' );
define ( $constpref.'_URL_CHOICE_DSC','投稿時に更新pingサーバーの選択が可能になります。' );
define ( $constpref.'_MAX_URLS','更新pingサーバー数の限度' );
define ( $constpref.'_MAX_URLS_DSC','選択可能にした場合のみ制限します。' );
define ( $constpref.'_UPDATEPING','更新pingサーバー' );
define ( $constpref.'_UPDATEPING_DSC','更新pingサーバーを指定します。改行で区切ります。' );
define ( $constpref.'_UPDATEPING_SERVERS',"http://ping.bloggers.jp/rpc/\nhttp://ping.myblog.jp/\nhttp://blog.goo.ne.jp/XMLRPC" );
define ( $constpref.'_TBAPPROVAL','トラックバック受付は承認を必要とする' );
define ( $constpref.'_TBAPPROVAL_DSC','' );
define ( $constpref.'_TBTICKET','チケット式トラックバックURLを使う' );
define ( $constpref.'_TBTICKET_DSC','Javascriptが使えないユーザーには無効ですので注意してください。生存時間はデフォルトで1日。' );
define ( $constpref.'_NOT_ADMIN','トラックバックがあったら通知する' );
define ( $constpref.'_NOT_ADMIN_DSC','承認権を持つユーザー宛に通知します。' );
define ( $constpref.'_SPAMCHECK','トラックバックのSPAMチェック' );
define ( $constpref.'_SPAMCHECK_DSC','チェックの組合せを選択してください。' );
define ( $constpref.'_NOSPAMCHECK','SPAMチェックをしない' );
define ( $constpref.'_REFERENCE','ブログページの言及' );
define ( $constpref.'_WORLDLIST','禁止用語チェック' );
define ( $constpref.'_BANNEDWORD','禁止用語' );
define ( $constpref.'_BANNEDWORD_DSC','ブログ名、タイトル、要約をチェックします。1行につき1語です。' );
define ( $constpref.'_BANNEDWORDS', "drugs\nhydrocodone\npharma\nsex\nsmoking\nviagra" );
define ( $constpref.'_REGEX','正規表現チェック' );
define ( $constpref.'_REGEXCHECK','正規表現' );
define ( $constpref.'_REGEXCHECK_DSC','ブログ名、タイトル、要約、urlをチェックしてマッチした場合拒否します。1行につき1セットです。' );
define ( $constpref.'_DNSBL','DNSBLチェック' );
define ( $constpref.'_DNSBLSRV','DNSBLサーバー' );
define ( $constpref.'_DNSBLSRV_DSC','参照元がこのサーバーのブラックリストDBに登録されているかどうかをチェックします。1行につき1サーバーです。' );
define ( $constpref.'_DNSBL_SERVERS', "niku.2ch.net\nlist.dsbl.org\nbl.spamcop.net\nsbl-xbl.spamhaus.org\nall.rbl.jp\nopm.blitzed.org\nbsb.empty.us\nbsb.spamlookup.net");
define ( $constpref.'_SURBL','SURBLチェック' );
define ( $constpref.'_SURBLSRV','SURBLサーバー' );
define ( $constpref.'_SURBLSRV_DSC','ブログ名、タイトル、要約文中のurlがこのサーバーのブラックリストDBに登録されているかどうかをチェックします。1行につき1サーバーです。' );
define ( $constpref.'_SURBL_SERVERS',"url.rbl.jp\nmulti.surbl.org" );
define ( $constpref.'_LANGCHECK','日本語チェック' );
define ( $constpref.'_PATTERN','日本語固有の文字パターン' );
define ( $constpref.'_PATTERN_DSC','漢字、かな、カナに相当する正規表現。' );
define ( $constpref.'_REGEX_PATTERN','[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+' );
define ( $constpref.'_LETTERS','必要な文字数' );
define ( $constpref.'_LETTERS_DSC','日本語チェックonにした場合、タイトル、ブログ名、要約文中の日本文字数合計がこれを下回る場合SPAMと判定します。' );
define ( $constpref.'_DYNAMICCSS','ダイナミックスタイルシートの使用' );
define ( $constpref.'_DYNAMICCSS_DSC','都度DBから直接読み込むのでonにするとCSS編集時に便利です。<br />通常時はoffにしてCSSマネジャーでtext形式のCSSを書き出しブラウザキャッシュを有効利用します。' );
define ( $constpref.'_ORIGINAL_COM','d3blogオリジナルのコメントシステムを使用' );
define ( $constpref.'_ORIGINAL_COM_DSC','オリジナルコメントでは返信をブログ投稿者のみに限定できます。<br />その場合は下記項目の「はい」を選択してください。' );
define ( $constpref.'_REJECTREPLY','コメント返信はブログ投稿者のみ' );
define ( $constpref.'_REJECTREPLY_DSC','オリジナルコメントを使用する場合、返信は投稿者のみに限定できます。<br />下記2項目のオプションはいずれのコメントシステムでも有効です。' );
define ( $constpref.'_FIGUREHANDLER','FigureHandler.jsの使用' );
define ( $constpref.'_FIGUREHANDLER_DSC','d3blogでは画像・図表などをキャプションとともにマークアップするxcodeの[fig]タグを追加してあります。<br />さらに、このjsを使うと画像サイズに応じてクラスを自動生成することが可能になります。<br />ただし、このjsは実験的な取り組みなので、テーマ操作やスタイルシートの知識がない場合はoffにしておいてください。' );
define ( $constpref.'_COM_AGENT','コメント統合' );
define ( $constpref.'_COM_AGENT_DSC','d3forumのコメント統合機能を使用する場合は該当モジュールのディレクトリ名を指定します。' );
//define ( $constpref.'_NO_COM_AGENT','コメント統合を利用しない' );
define ( $constpref.'_COM_AGENTID','コメントのforum_id' );
define ( $constpref.'_COM_AGENTID_DSC','コメント統合を選択した場合、forum_idを必ず指定してください。' );

// <--- NOTIFY PROPERTY --->
define ( $constpref.'_NOTIFY_GLOBAL','ブログ全体' );
define ( $constpref.'_NOTIFY_GLOBAL_DSC','ブログモジュール全体における通知オプション' );
define ( $constpref.'_NOTIFY_ENTRY','表示中のエントリ' );
define ( $constpref.'_NOTIFY_ENTRY_DSC','表示中のエントリにおける通知オプション' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED','承認が必要なエントリ投稿があったとき' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_CAP','ブログに承認が必要な新規投稿があったら通知する' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_DSC','ブログに承認が必要な新規投稿があったとき' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_SBJ','[{X_SITENAME}] {X_MODULE}: 承認が必要なエントリが投稿されました' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED','ブログに新規掲載があったとき' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_DSC','ブログに新規掲載があったら通知する' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_CAP','ブログに新規掲載があったら通知する' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: ブログに新規エントリが掲載されました' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED','承認が必要なトラックバックを受信したとき' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_CAP','承認が必要なトラックバックを受信したら通知する' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_DSC','承認が必要なトラックバックを受信したとき' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_SBJ','[{X_SITENAME}] {X_MODULE}: 承認が必要なトラックバックを受信しました' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED','トラックバックを受信したとき' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_CAP','ブログにトラックバックがあったら通知する' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_DSC','ブログにトラックバックがあったとき' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: トラックバックを受信しました' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED','ブログエントリが承認されたとき' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_CAP','ブログエントリが承認されたら通知する' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_DSC','ブログエントリが承認されたとき' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: ブログエントリが承認されました' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK','トラックバックを受信したとき' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_DSC','表示中のエントリにトラックバックを受信したとき通知する' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_CAP','表示中のエントリにトラックバックを受信したとき通知する' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_SBJ','[{X_SITENAME}] {X_MODULE}: トラックバックを受信しました' );

}
?>
