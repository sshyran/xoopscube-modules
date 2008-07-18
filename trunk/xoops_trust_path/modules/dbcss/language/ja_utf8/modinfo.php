<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'dbcss' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","DB css");

// A brief description of this module
define($constpref."_DESC","管理画面上でスタイルシートを編集できるようにするモジュール");

// admin menus
define($constpref.'_ADMENU_CSSADMIN','CSSインポート/エクスポート') ;
define($constpref.'_ADMENU_METAHEAD','METAタグ管理') ;
define($constpref.'_ADMENU_SCRIPTHEAD','外部スクリプトタグ編集') ;
define($constpref.'_ADMENU_MYLANGADMIN','言語定数管理') ;
define($constpref.'_ADMENU_MYTPLSADMIN','テンプレート管理') ;
define($constpref.'_ADMENU_MYBLOCKSADMIN','ブロック管理/アクセス権限') ;
define($constpref.'_ADMENU_MYPREFERENCES','一般設定') ;

// blocks
define($constpref.'_BNAME_DBCSSHOOK','DBスタイルシートフックブロック') ;
define($constpref.'_BNAME_CSSHOOK','スタイルシートフックブロック') ;
define($constpref.'_BNAME_METAHOOK','METAタグフックブロック') ;
define($constpref.'_BNAME_SCRIPTHOOK','SCRIPTタグフックブロック') ;

// configs
define($constpref.'_CSS_TEMPLATE','デフォルトにするテンプレート名');
define($constpref.'_CSS_TEMPLATEDSC','このモジュールで使用するテンプレート名を指定します。デフォルトは common.css です。');
define($constpref.'_CSS_URI','モジュール用CSSファイルのURI');
define($constpref.'_CSS_URIDSC','デフォルトで使用するCSSファイルのURIを相対パスまたは絶対パスで指定します。<br />デフォルトは<{$xoops_url}>/common/css/common.cssです。');
define($constpref.'_CSSCACHETIME','CSSのブラウザキャッシュ時間(sec)') ;
define($constpref.'_CSSEXPORT_DIR','CSSエクスポート先ディレクトリ') ;
define($constpref.'_CSSEXPORT_DIRDSC','「CSSエクスポート」機能のエクスポート先ディレクトリを、XOOPSのインストール先からのパスで指定します。また、このディレクトリに書込属性を設定してから、お使いください。<br />設定例 : common/css/ (最初の / は不要、最後の / は必要です)') ;
define($constpref.'_METADATA_CASHE','METAタグのデータをファイルキャッシュで保存する') ;
define($constpref.'_METADATA_CASHEDSC','ONにすると「METAタグ管理」で編集したデータをファイルキャッシュで保存します。なお、ファイルキャッシュを保存する場合は XOOPS_TRUST_PATH/cache/ ディレクトリを作り、書込属性を設定する必要があります。') ;
define($constpref.'_SCRIPTDATA_CASHE','外部スクリプトのデータをファイルキャッシュで保存する') ;
define($constpref.'_SCRIPTDATA_CASHEDSC','ONにすると、XOOPS_TRUST_PATH/cache/ に、「外部スクリプト管理」で編集したデータをファイルキャッシュで保存します。XOOPS_TRUST_PATH/cache/ を DocumentRoot 外に作れない場合は、この機能を OFF にすることをお勧めします。') ;

}

?>