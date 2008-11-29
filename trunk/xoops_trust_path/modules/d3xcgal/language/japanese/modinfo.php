<?php
// $Id: modinfo.php,v 1.5 2005/12/16 14:54:35 mcleines Exp $
//  ------------------------------------------------------------------------ //
//                    xcGal 2.0 - XOOPS Gallery Modul                        //
//  ------------------------------------------------------------------------ //
//  Based on      xcGallery 1.1 RC1 - XOOPS Gallery Modul                    //
//                    Copyright (c) 2003 Derya Kiran                         //
//  ------------------------------------------------------------------------ //
//  Based on Coppermine Photo Gallery 1.10 http://coppermine.sourceforge.net///
//                      developed by Gr馮ory DEMAR                           //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3xcgal' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;
global $xoopsConfig;	//add for line 104

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

define($constpref."_D3XCGAL_NAME","xcGalleryD3");
define($constpref."_D3XCGAL_ADMENU1", "xcGalleryD3管理");
define($constpref."_D3XCGAL_ADMENU2", "アルバムカテゴリー管理");
define($constpref."_D3XCGAL_ADMENU3", "ユーザー管理");
define($constpref."_D3XCGAL_ADMENU4", "グループ管理");
define($constpref."_D3XCGAL_ADMENU5", "eカード管理");
define($constpref."_D3XCGAL_ADMENU6", "アップロード画像一括登録");

define($constpref."_D3XCGAL_SCROLL","Scrolling Thumbnails");
define($constpref."_D3XCGAL_CATMENU","xcGallery Categories");
define($constpref."_D3XCGAL_STATIC","Static Thumbnails");
define($constpref."_D3XCGAL_METAALB","Meta Albums");

// configs
define($constpref."_ANONSEE", "匿名のユーザがアルバムを見ることを可能にしますか");
define($constpref."_SUBCAT_LEVEL", "カテゴリ階層の表示数");
define($constpref."_ALB_PER_PAGE", "アルバム表示数");
define($constpref."_ALB_LIST_COLS", "アルバムリストの列数");
define($constpref."_ALB_THUMB_SIZE", "サムネイルのサイズ (ピクセル)");
define($constpref."_MAIN_LAYOUT", "メインページのコンテンツ");
define($constpref."_THUMBCOLS", "サムネイルページの列数");
define($constpref."_THUMBROWS", "サムネイルページの行数");
define($constpref."_MAX_TABS", "表示するべきタブの最大数");
define($constpref."_TEXT_THUMBVIEW", "サムネイルの下に写真説明を表示する (写真名に追加)");
define($constpref."_COM_COUNT", "サムネイルの下に表示するコメント数");
define($constpref."_DEF_SORT", "サムネイル表示: 写真表示順のデフォルト");
define($constpref."_SORT_NA", "名前の昇順");
define($constpref."_SORT_ND", "名前の降順");
define($constpref."_SORT_DA", "日付の昇順");
define($constpref."_SORT_DD", "日付の降順");
define($constpref."_MIN_VOTES", "｢高評価写真｣リストに表示される写真の最低投票数");
define($constpref."_DIS_PICINFO", "サムネイルの下に写真説明を表示する");
define($constpref."_JPG_QUAL", "JPEGファイルの品質");
define($constpref."_THUMB_WIDTH", "サムネイルの最大幅または高さ *");
define($constpref."_MAKE_INTERM", "中間写真を作成する");
define($constpref."_PICTURE_WIDTH", "中間写真の最大幅又は高さ *");
define($constpref."_MAX_UPL_SIZE", "最大ファイルサイズ (KB)<br />アップロード時のファイルサイズ制限");
define($constpref."_MAX_UPL_WIDTH", "アップロードを許可する画像の最大幅または高さ (ピクセル)");
define($constpref."_ALLOW_PRIVATE", "ユーザーがプライベートアルバムを作成出来る");
define($constpref."_UF_NAME1", "画像説明のためのカスタムフィールド名 1 (使用しない場合は空白)");
define($constpref."_UF_NAME2", "フィールド名 2");
define($constpref."_UF_NAME3", "フィールド名 3");
define($constpref."_UF_NAME4", "フィールド名 4");
define($constpref."_FORB_FNAME", "ファイル名で禁じる文字の指定");
define($constpref."_FILE_EXT", "アップロードを許可するファイル拡張子を指定する");
define($constpref."_THUMB_METHOD", "画像処理を行わせるパッケージ選択");
define($constpref."_THUMB_METHODDESC", "ほとんどのPHP環境で標準的に利用可能なのはGDですが機能的に劣ります<br />可能であればImageMagickかNetPBMの使用をお勧めします");
define($constpref."_IMPATH", "ImageMagick及びNetPBMの実行パスの指定");
define($constpref."_IMPATHDESC", "convertの存在するディレクトリをフルパスで指定<br />パスの最後に'/'が必要です (例　Linux /usr/bin/)");
define($constpref."_ALLOW_IMG_TYPES", "使用できる画像タイプ (ImageMagickのみに有効)");
define($constpref."_IM_OPTIONS", "ImageMagickのコマンドラインオプション");
define($constpref."_READ_EXIF", "JPEGファイルのEXIFデータを読み取る (needs php exif extension)");
define($constpref."_FULLPATH", "アルバムディレクトリの指定 *");
define($constpref."_USERPICS", "ユーザーディレクトリの指定 *");
define($constpref."_NORMAL_PFX", "中間写真の接頭辞 *");
define($constpref."_THUMB_PFX", "サムネイルの接頭辞 *");
define($constpref."_DIR_MODE", "ディレクトリのデフォルト・パーミッションモード");
define($constpref."_PIC_MODE", "写真のデフォルト・パーミッションモード");
define($constpref."_COOKIE_NAME", "スクリプトで使用するクッキー名");
define($constpref."_COOKIE_PATH", "スクリプトで使用するクッキーの保存先");
define($constpref."_DEBUG_MODE", "デパックモードを有効にする");
define($constpref."_ECRAD_SEE_MORE", "eカードの「もっと多くの写真を見る」ターゲットアドレス");
define($constpref."_ECRAD_TYPE", "カードタイプを選択");
define($constpref."_TEXT_CARD", "Text");
define($constpref."_HTML_CARD", "Html");
define($constpref."_ECRAD_PER_HOUR", "ユーザーが一度に送ることができるeカード送信数");
define($constpref."_ECRAD_SAVE", "データベースに保存するeカード（時間指定）");
define($constpref."_ECRAD_TEXT","Ecardテキスト");
define($constpref."_ECRAD_TEXTDESC","(ecardにつけるテキストを記述)<br /><b>Useful Tags</b><br />{X_SITEURL} は「".XOOPS_URL."」を表示<br />{X_SITENAME} は「".$xoopsConfig['sitename']."」を表示<br />{R_NAME} は受信者の名前を表示<br />{R_MAIL} 受信者のemailアドレスを表示<br />{S_NAME} 送信者の名前を表示<br />{S_MAIL} 送信者のemailアドレスを表示<br />{SAVE_DAYS} ecardをDBに保存する日数を表示<br />{CARD_LINK} ecardをpick-upするurlを表示");
define($constpref."_ECRAD_TEXTVALUE","こんにちは {R_NAME}さん。\n\n{S_NAME}({S_MAIL}) さんからあなたへのecardが届いております。\n次のリンク先からecardをpick-upしてください ({CARD_LINK})。\nあなたのecardは {SAVE_DAYS} 日間データベースに保管されます。\n\nregards\n{X_SITENAME} team ({X_SITEURL})");
define($constpref."_KEEP_VOTES", "ユーザー投票をデータベースに保存する日数");
define($constpref."_SEARCH_THUMB", "userinfoページでxcGalleryアイコンの代わりにサムネイルを表示");
define($constpref."_WATERMARKING", "Watermarkの使用");
define($constpref."_WATERMARK_TEXTDESC", "Watermarkは (モジュール名)/images/watermark.png に保存する必要があります。");
define($constpref."_BATCHSHOWALL", "バッチアップロード - 全て表示");
define($constpref."_BATCHSHOWALLDESC", "既にアルバムにあるファイルも含めて全てのファイルを表示します。「いいえ」の場合は新しいファイルのみ表示します。");
define($constpref.'_CSS_URI','モジュール用CSSのURI');
define($constpref.'_CSS_URIDSC','このモジュール専用のCSSファイルのURIを相対パスまたは絶対パスで指定します。デフォルトは {mod_url}/index.php?page=main_css です。');

// admin menu
define($constpref.'_ADMENU_MYLANGADMIN' , '言語定数管理' ) ;
define($constpref.'_ADMENU_MYTPLSADMIN' , 'テンプレート管理' ) ;
define($constpref.'_ADMENU_MYBLOCKSADMIN' , 'ブロック管理/アクセス権限' ) ;
define($constpref.'_ADMENU_MYPREFERENCES' , '一般設定' ) ;

}

?>