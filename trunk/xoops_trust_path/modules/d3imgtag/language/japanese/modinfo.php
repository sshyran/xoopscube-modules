<?php
// Module Info
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3imgtag' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","IMGタグD3");

// A brief description of this module
define($constpref."_DESC","画像の投稿・表示・ランク付けその他の機能を持つ先進的な画像ギャラリーを作成する");

// Names of blocks for this module (Not all module has blocks)
define( $constpref."_BNAME_RECENT","最近の画像");
define( $constpref."_BNAME_HITS","人気画像");
define( $constpref."_BNAME_RANDOM","ランダム画像");
define( $constpref."_BNAME_RECENT_P","最近の画像(画像付)");
define( $constpref."_BNAME_HITS_P","人気画像(画像付)");

// Config Items	@remove_CFG_
define( $constpref."_PHOTOSPATH" , "画像ファイルの保存先ディレクトリ" ) ;
define( $constpref."_DESCPHOTOSPATH" , "XOOPSインストール先からのパスを指定（最初の'/'は必要、最後の'/'は不要）<br />Unixではこのディレクトリへの書込属性をONにして下さい" ) ;
define( $constpref."_THUMBSPATH" , "サムネイルファイルの保存先ディレクトリ" ) ;
define( $constpref."_DESCTHUMBSPATH" , "「画像ファイルの保存先ディレクトリ」と同じです" ) ;
// define( $constpref."_USEIMAGICK" , "画像処理にImageMagickを使う" ) ;
// define( $constpref."_DESCIMAGICK" , "使わない場合は、メイン画像の調整は機能せず、サムネイルの生成にGDを使います。<br />可能であればImageMagickの使用が最善です" ) ;
define( $constpref."_IMAGINGPIPE" , "画像処理プロセッサーの選択" ) ;
define( $constpref."_DESCIMAGINGPIPE" , "ほとんどのPHP環境で標準的に利用可能なのはGDですが機能的に劣ります<br />可能であればImageMagickかNetPBMの使用をお勧めします" ) ;
define( $constpref."_FORCEGD2" , "強制GD2モード" ) ;
define( $constpref."_DESCFORCEGD2" , "強制的にGD2モードで動作させます<br />一部のPHPでは強制GD2モードでサムネイル作成に失敗します<br />画像処理パッケージとしてGDを選択した時のみ意味を持ちます" ) ;
define( $constpref."_IMAGICKPATH" , "ImageMagickの実行パス" ) ;
define( $constpref."_DESCIMAGICKPATH" , "convertの存在するディレクトリをフルパスで指定しますが、空白でうまく行くことが多いでしょう。<br />画像処理パッケージとしてImageMagickを選択した時のみ意味を持ちます" ) ;
define( $constpref."_NETPBMPATH" , "NetPBMの実行パス" ) ;
define( $constpref."_DESCNETPBMPATH" , "pnmscale等の存在するディレクトリをフルパスで指定しますが、空白でうまく行くことが多いでしょう。<br />画像処理パッケージとしてNetPBMを選択した時のみ意味を持ちます" ) ;
define( $constpref."_POPULAR" , "'POP'アイコンがつくために必要なヒット数" ) ;
define( $constpref."_NEWDAYS" , "'new'や'update'アイコンが表示される日数" ) ;
define( $constpref."_NEWPHOTOS" , "トップページで新規画像として表示する数" ) ;
define( $constpref."_DEFAULTORDER" , "カテゴリ表示でのデフォルト表示順" ) ;
define( $constpref."_PERPAGE" , "1ページに表示される画像数" ) ;
define( $constpref."_DESCPERPAGE" , "選択可能な数字を | で区切って下さい<br />例: 10|20|50|100" ) ;
define( $constpref."_ALLOWNOIMAGE" , "画像のない投稿を許可する" ) ;
define( $constpref."_MAKETHUMB" , "サムネイルを作成する" ) ;
define( $constpref."_DESCMAKETHUMB" , "「生成しない」から「生成する」に変更した時には、「サムネイルの再構築」が必要です。" ) ;
define( $constpref."_MAKEPREVIEW" , "プレビューを作成する" );
define( $constpref."_DESCMAKEPREVIEW" , "「生成しない」から「生成する」に変更した時には、「サムネイルの再構築」が必要です。" );
//define( $constpref."_THUMBWIDTH" , "サムネイル画像の幅" ) ;
//define( $constpref."_DESCTHUMBWIDTH" , "生成されるサムネイル画像の高さは、幅から自動計算されます" ) ;
define( $constpref."_THUMBSIZE" , "サムネイル画像サイズ(pixel)" ) ;
define( $constpref."_THUMBRULE" , "サムネイル生成法則" ) ;
define( $constpref."_WIDTH" , "最大画像幅" ) ;
define( $constpref."_DESCWIDTH" , "画像アップロード時に自動調整されるメイン画像の最大幅。<br />GDモードでTrueColorを扱えない時には単なるサイズ制限" ) ;
define( $constpref."_HEIGHT" , "最大画像高" ) ;
define( $constpref."_DESCHEIGHT" , "最大幅と同じ意味です" ) ;
define( $constpref."_FSIZE" , "最大ファイルサイズ" ) ;
define( $constpref."_DESCFSIZE" , "アップロード時のファイルサイズ制限(byte)" ) ;
define( $constpref."_MIDDLEPIXEL" , "シングルビューでの最大画像サイズ" ) ;
define( $constpref."_DESCMIDDLEPIXEL" , "幅x高さ で指定します。<br />（例 480x480）" ) ;
define( $constpref."_ADDPOSTS" , "写真を投稿した時にカウントアップされる投稿数" ) ;
define( $constpref."_DESCADDPOSTS" , "常識的には0か1です。負の値は0と見なされます" ) ;
define( $constpref."_CATONSUBMENU" , "サブメニューへのトップカテゴリーの登録" ) ;
define( $constpref."_NAMEORUNAME" , "投稿者名の表示" ) ;
define( $constpref."_DESCNAMEORUNAME" , "ログイン名かハンドル名か選択して下さい" ) ;
define( $constpref."_VIEWCATTYPE" , "一覧表示の表示タイプ" ) ;
define( $constpref."_COLSOFTABLEVIEW" , "テーブル表示時のカラム数" ) ;
define( $constpref."_ALLOWEDEXTS" , "アップロード許可するファイル拡張子" ) ;
define( $constpref."_DESCALLOWEDEXTS" , "ファイルの拡張子を、jpg|jpeg|gif|png のように、'|' で区切って入力して下さい。<br />すべて小文字で指定し、ピリオドや空白は入れないで下さい。<br />意味の判っている方以外は、phpやphtmlなどを追加しないで下さい" ) ;
define( $constpref."_ALLOWEDMIME" , "アップロード許可するMIMEタイプ" ) ;
define( $constpref."_DESCALLOWEDMIME" , "MIMEタイプを、image/gif|image/jpeg|image/png のように、'|' で区切って入力して下さい。<br />MIMEタイプによるチェックを行わない時には、ここを空欄にします" ) ;
define( $constpref."_USESITEIMG" , "イメージマネージャ統合での[siteimg]タグ" ) ;
define( $constpref."_DESCUSESITEIMG" , "イメージマネージャ統合で、[img]タグの代わりに[siteimg]タグを挿入するようになります。<br />利用モジュール側で[siteimg]タグが有効に機能するようになっている必要があります" ) ;

define( $constpref."_OPT_USENAME" , "ハンドル名" ) ;
define( $constpref."_OPT_USEUNAME" , "ログイン名" ) ;

define( $constpref."_OPT_CALCFROMWIDTH" , "指定数値を幅として、高さを自動計算" ) ;
define( $constpref."_OPT_CALCFROMHEIGHT" , "指定数値を高さとして、幅を自動計算" ) ;
define( $constpref."_OPT_CALCWHINSIDEBOX" , "幅か高さの大きい方が指定数値になるよう自動計算" ) ;

define( $constpref."_OPT_VIEWLIST" , "説明文付リスト表示" ) ;
define( $constpref."_OPT_VIEWTABLE" , "テーブル表示" ) ;


// Sub menu titles
define( $constpref."_TEXT_SMNAME1","投稿");
define( $constpref."_TEXT_SMNAME2","高人気");
define( $constpref."_TEXT_SMNAME3","トップランク");
define( $constpref."_TEXT_SMNAME4","自分の投稿");

// Names of admin menu items
define( $constpref."_D3IMGTAG_ADMENU0","投稿された画像の承認");
define( $constpref."_D3IMGTAG_ADMENU1","画像管理");
define( $constpref."_D3IMGTAG_ADMENU2","カテゴリ管理");
define( $constpref."_D3IMGTAG_ADMENU_GPERM","各グループの権限");
define( $constpref."_D3IMGTAG_ADMENU3","動作チェッカー");
define( $constpref."_D3IMGTAG_ADMENU4","画像一括登録");
define( $constpref."_D3IMGTAG_ADMENU5","サムネイルの再構築");
//define( $constpref."_D3IMGTAG_ADMENU_IMPORT","画像インポート");
//define( $constpref."_D3IMGTAG_ADMENU_EXPORT","画像エクスポート");
define( $constpref.'_ADMENU_MYLANGADMIN' , '言語定数管理' ) ;
define( $constpref.'_ADMENU_MYTPLSADMIN' , 'テンプレート管理' ) ;
define( $constpref.'_ADMENU_MYBLOCKSADMIN' , 'ブロック管理/アクセス権限' ) ;
define( $constpref.'_ADMENU_MYPREFERENCES' , '一般設定' ) ;


// Text for notifications
define( $constpref.'_GLOBAL_NOTIFY', 'モジュール全体');
define( $constpref.'_GLOBAL_NOTIFYDSC', 'IMGTagモジュール全体における通知オプション');
define( $constpref.'_CATEGORY_NOTIFY', 'カテゴリー');
define( $constpref.'_CATEGORY_NOTIFYDSC', '選択中のカテゴリーに対する通知オプション');
define( $constpref.'_PHOTO_NOTIFY', '写真');
define( $constpref.'_PHOTO_NOTIFYDSC', '表示中の写真に対する通知オプション');

define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFY', '新規写真登録');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYCAP', '新規に写真が登録された時に通知する');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYDSC', '新規に写真が登録された時に通知する');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: 新たに写真が登録されました');

define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFY', 'カテゴリ毎の新写真登録');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYCAP', 'このカテゴリに新たに写真が登録された時に通知する');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYDSC', 'このカテゴリに新たに写真が登録された時に通知する');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: 新たに写真が登録されました');


// KickassAMD Added Constants
define($constpref."_CHECKREFERER", "ホットリンクプロテクション");
define($constpref."_CHECKREFERERDESC", "画像のホットリンクからの防御を可能にする<br>*これは当サイトの画像を他のサイトにホットリンクさせないようにします");
define($constpref."__REFERERS", "画像のホットリンクを許可するサイト");
define($constpref."__REFERERSDESC", "このリスト上のサイトは画像のリンクを可能とします。サイトは | は区切って指定します。<br><b>自分のサイトが含まれていることを確認してください!!</b>.");
define($constpref."_DATEFORMAT", "日付フォーマット");
define($constpref."_DATEFORMATDESC", "画像の投稿日時のフォーマットを指定する。 <a href='http://www.php.net/date/'>PHP Date</a> を参照してください。");
define($constpref."_PREVIEWSIZE" , "プレビュー画像のサイズ (pixel)");
define($constpref."_PREVIEWRULE" , "プレビュー画像生成ルール");
define($constpref."_AJAX", "AJAX機能");
define($constpref."_AJAXDESC", "動的に AJAX機能を使用可能にする");
define($constpref."_MINFILE", "ファイル名の最小の長さ");
define($constpref."_MINFILEDESC", "ランダムなファイル名の長さの最小値を指定する。推奨値は: 10");
define($constpref."_MAXFILE", "ファイル名の最大の長さ");
define($constpref."_MAXFILEDESC", "ランダムなファイル名の長さの最大値を指定する。推奨値は: 50");
define($constpref."_FILERULE", "ファイル名のランダム化ルール");
define($constpref."_FILERULEDESC", "ランダムなファイル名を生成するときに使用するものを選択する");
define($constpref."_BADREFCHECK", "ホットリンクのアクション");
define($constpref."_BADREFCHECKDESC", "ホットリンクされたときのアクションを選択する");
define($constpref."_BADREFTXT", "ホットリンクを知らせる文");
define($constpref."_BADREFTXTDESC", "ホットリンクをされたとき画像上に表示するテキストまたはリダイレクト時のテキストを指定する");
define($constpref."_PREVIEWSPATH" , "プレビューファイルの保存先ディレクトリ");
define($constpref."_DESCPREVIEWSPATH" , "「画像ファイルの保存先ディレクトリ」と同じです");
//define($constpref."_POPULAR", "'POP'アイコンがつくために必要な表示数");
define($constpref."_EXINFO", "追加の画像情報");
define($constpref."_EXINFODESC", "画像情報にファイルサイズと解像度を表示する");
define($constpref."_SHARE", "画像の共有");
define($constpref."_SHAREDESC", "他のサイトと画像のシェアを可能にする");
define($constpref."_WATER", "ウォーターマーク");
define($constpref."_WATERDESC", "画像上にテキストを追加する");
define($constpref."_WATERVALUE", "表示するテキスト");
define($constpref."_WATERVALUEDESC", "ウォーターマークとして表示するテキストを指定する");
define($constpref."_WATERSIZE", "テキストのサイズ");
define($constpref."_WATERSIZEDESC", "テキストのサイズ指定は 1 - 100 まで可能です");
define($constpref."_WATERPOS", "ウォーターマークの位置");
define($constpref."_WATERPOSDESC", "ウォーターマークを表示させる画像上の位置を指定する");
define($constpref."_WATERFONT", "フォントタイプ");
define($constpref."_WATERFONTDESC", "テキストに使うフォントを選択する<br> * IMGTag内のfontフォルダに自分自身のtruetypeフォントを追加することができます。新しいフォントを追加する場合はモジュールアップデートが必要です。");
define($constpref."_DELETEBATCH", "一括処理で画像を削除する");
define($constpref."_DELETEBATCHDESC", "画像の一括処理でインポートしたのと同様に画像を削除することができます");
define($constpref."_AJAXEFFECT", "AJAX機能レベル");
define($constpref."_AJAXEFFECTDESC", "AJAX機能のレベルを選択する");

}

?>