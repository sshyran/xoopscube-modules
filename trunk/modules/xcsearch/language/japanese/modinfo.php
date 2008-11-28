<?php

/**
 * @author $Author$ 
 * @version $Id$
 *
 */

define('_MI_XCSEARCH_NAME', "xcsearch");
define('_MI_XCSEARCH_DESCRIPTION', "Google Co-op Search module");
define('_MI_XCSEARCH_CONF_ID_TITLE', "Google Co-op cx value");
define('_MI_XCSEARCH_CONF_ID_DESC', "Google Co-op サービスにて出力されるコードの name='cx' のvalue(値)を入力してください。");
define('_MI_XCSEARCH_CONF_RANK_TITLE', "キーワードランキングを利用しますか");
define('_MI_XCSEARCH_CONF_RANK_DESC', "");
define('_MI_XCSEARCH_CONF_APIKEY_TITLE', "Google AJAX Search API key");
define('_MI_XCSEARCH_CONF_APIKEY_DESC', 'Google AJAX Search を利用する場合は、API key を取得してください。<br /><a href="http://code.google.com/apis/ajaxsearch/signup.html" target="_blank">Google AJAX Search Site</a>');
define('_MI_XCSEARCH_CONF_P_NUM_TITLE', "サイト内検索： 初期検索時の検索結果数");
define('_MI_XCSEARCH_CONF_P_NUM_DESC', "");
define('_MI_XCSEARCH_CONF_NEXT_TITLE', "サイト内検索： NEXT 検索時の検索結果数");
define('_MI_XCSEARCH_CONF_NEXT_DESC', "");
define('_MI_XCSEARCH_CONF_DEF_TITLE', "モジュールトップのデフォルト検索の指定");
define('_MI_XCSEARCH_CONF_DEF_DESC', "");

define('_MI_XCSEARCH_CONF_XCSEARCH', "XCSEARCH");
define('_MI_XCSEARCH_CONF_AJAXSEARCH', "Google Ajax Search");
define('_MI_XCSEARCH_CONF_INSIDE', "サイト内検索");

define( '_MI_XCSEARCH_ADMENU1' , "Google Co-op ID 編集" );
define( '_MI_XCSEARCH_ADMENU2' , "キーワードランキング" );
if( !defined('_MD_A_MYMENU_MYTPLSADMIN') ) define( '_MD_A_MYMENU_MYTPLSADMIN' , "テンプレート管理" );
if( !defined('_MD_A_MYMENU_MYBLOCKSADMIN') ) define( '_MD_A_MYMENU_MYBLOCKSADMIN' , "ブロック・アクセス権限" );

?>
