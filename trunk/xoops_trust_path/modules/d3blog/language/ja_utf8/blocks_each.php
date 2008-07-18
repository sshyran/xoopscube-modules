<?php
/**
 * @version $Id: blocks_each.php 237 2007-11-24 03:17:02Z hodaka $
 * @author kuri <kuri@keynext.co.jp>
 */

$constpref = '_MB_' . strtoupper( $mydirname ) ;

// calendar
define($constpref.'_LANG_PREVMONTH', '&laquo;');
define($constpref.'_LANG_NEXTMONTH', '&raquo;');
define($constpref.'_LANG_PREVYEAR', '&laquo;');
define($constpref.'_LANG_NEXTYEAR', '&raquo;');
define($constpref.'_LANG_PREVMONTH_TITLE', '前の月');
define($constpref.'_LANG_NEXTMONTH_TITLE', '次の月');
define($constpref.'_LANG_PREVYEAR_TITLE', '前の年');
define($constpref.'_LANG_NEXTYEAR_TITLE', '次の年');
define($constpref.'_LANG_THIS_MONTH_TITLE', 'この月のアーカイブ');
define($constpref.'_LANG_SUNDAY', '日');
define($constpref.'_LANG_MONDAY', '月');
define($constpref.'_LANG_TUESDAY', '火');
define($constpref.'_LANG_WEDNESDAY', '水');
define($constpref.'_LANG_THURSDAY', '木');
define($constpref.'_LANG_FRIDAY', '金');
define($constpref.'_LANG_SATURDAY', '土');
// latest entries
define($constpref.'_LANG_CATEGORY', 'カテゴリ');
define($constpref.'_LANG_TITLE', 'タイトル');
define($constpref.'_LANG_ENTRIES', '最近のエントリ');
define($constpref.'_LANG_ENTRIES_FOR', '%sさんのエントリ');
define($constpref.'_LANG_AUTHOR', '執筆者');
define($constpref.'_LANG_COMMENTS', 'コメント数');
define($constpref.'_LANG_POSTED', '投稿日');
define($constpref.'_LANG_COUNTER', '閲覧数');
define($constpref.'_LANG_BLOGTOP', '%sのトップへ');
define($constpref.'_LANG_READMORE', '...続きを読む');
// archives
define($constpref.'_LANG_SORT_ARCHIVE', '過去ログの検索');
define($constpref.'_LANG_MOREARCHIVES', 'アーカイブへ');
// bloggers list
define($constpref.'_LANG_READ_ENTRIES_OF_BLOGGER', '%sさんのエントリを読む');
// trackback
define($constpref.'_LANG_TRACKBACKS', 'トラックバック数'); //eng
define($constpref.'_LANG_TRACKBACKS_FOR', '%sさんへのトラックバック');
define($constpref.'_LANG_TB_TITLE', 'タイトル');
define($constpref.'_LANG_TB_ENTRYTITLE', 'トラックバックエントリ');
define($constpref.'_LANG_TB_BLOGNAME', 'ブログ名');
define($constpref.'_LANG_TB_POSTED', '日付');
// comments
define($constpref.'_LANG_COM_TITLE', 'コメント');
define($constpref.'_LANG_COM_UNAME', 'ユーザ');
define($constpref.'_LANG_COM_ENTRYTITLE', 'コメントのエントリ');
define($constpref.'_LANG_COM_POSTED', '日付');

define($constpref.'_LANG_LINKS_FOR','%sさんのリンク');

define($constpref.'_USERS_SORT_READS', '累計閲覧数');
define($constpref.'_USERS_SORT_UPDATE', '最終更新');

define($constpref.'_SUMMARY_COMMENTS_LIST', 'このテーブルはブログに対する最新のコメントを一覧にした表です。');
define($constpref.'_SUMMARY_CALENDAR', 'このテーブルは日別に投稿データの有無を示すブログカレンダーです。月、年単位に前後に移動できます。');
define($constpref.'_SUMMARY_LATEST_BLOGS', 'このテーブルは最新ブログの一覧を表にしたものです。');
define($constpref.'_SUMMARY_LATEST_CONTENTS', 'このテーブルは最新ブログのコンテンツ一覧を表にしたものです。');
define($constpref.'_SUMMARY_LATEST_TRACKBACKS', 'このテーブルは最新トラックバックの一覧を表にしたものです。');
define($constpref.'_SUMMARY_USERS_BLOG', 'このテーブルはユーザー別最新ブログの一覧を表にしたものです。');

?>