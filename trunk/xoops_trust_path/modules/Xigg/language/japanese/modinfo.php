<?php
$const_prefix = '_MI_' . strtoupper($module_dirname);

if (!defined($const_prefix)) {
define($const_prefix, 1);

define($const_prefix . '_NAME', 'Xigg(' . $module_dirname . ')');
define($const_prefix . '_DESC', 'Xigg module for XOOPS powered by Sabai Framework');

// Blocks
define($const_prefix . '_BNAME_CATEGORIES', 'カテゴリ');
define($const_prefix . '_BDESC_CATEGORIES', 'カテゴリブロック');
define($const_prefix . '_BNAME_TAG_CLOUD', 'タグ');
define($const_prefix . '_BDESC_TAG_CLOUD', 'タグクラウド');
define($const_prefix . '_BNAME_RECENT_NODES', '最近の公開記事');
define($const_prefix . '_BDESC_RECENT_NODES', '最近の投稿記事を表示');
define($const_prefix . '_BNAME_RECENT_COMMENTS', '最近のコメント');
define($const_prefix . '_BDESC_RECENT_COMMENTS', '最近のコメントを表示');
define($const_prefix . '_BNAME_RECENT_TRACKBACKS', '最近のトラックバック');
define($const_prefix . '_BDESC_RECENT_TRACKBACKS', '最近のトラックバックを表示');
define($const_prefix . '_BNAME_RECENT_VOTES', '最近の投票');
define($const_prefix . '_BDESC_RECENT_VOTES', '最近の投票を表示');
define($const_prefix . '_BNAME_RECENT_NODES2', '最近の公開記事2');
define($const_prefix . '_BDESC_RECENT_NODES2', '最近の投稿記事およびトップ投票記事を表示');

// Admin menu
define($const_prefix . '_ADMENU_CATEGORIES', 'カテゴリ管理');
define($const_prefix . '_ADMENU_NODES', '記事の管理');
define($const_prefix . '_ADMENU_TAGS', 'タグ管理');
define($const_prefix . '_ADMENU_PLUGINS', 'プラグイン管理');
define($const_prefix . '_ADMENU_ROLES', 'ロール管理');
define($const_prefix . '_ADMENU_XROLES', 'ロール割り当て（グループ別）');
define($const_prefix . '_ADMENU_USERS', 'ユーザ管理');

define($const_prefix . '_SMENU_SUBMIT', '記事を投稿');
define($const_prefix . '_SMENU_COMMENTS', 'コメント一覧');
define($const_prefix . '_SMENU_TAGCLOUD', 'タグクラウド');


define($const_prefix . '_C_SITETITLE', 'サイトの名称');
define($const_prefix . '_C_SITEDESC', 'サイトの説明');
define($const_prefix . '_C_GCOMALLOWED', 'ゲストユーザによるコメントを許可');
define($const_prefix . '_C_GCOMALLOWEDD', '「はい」を選択した場合、ロールの権限設定に関わらず全てのユーザがコメントを投稿できるようになります。');
define($const_prefix . '_C_GVOTEALLOWED', 'ゲストユーザによる投票を許可');
define($const_prefix . '_C_GVOTEALLOWEDD', '「はい」を選択した場合、ロールの権限設定に関わらず全てのユーザが投票できるようになります。');
define($const_prefix . '_C_NUMNODES', 'トップページに表示する記事の数');
define($const_prefix . '_C_NUMCOMS', '1ページに表示するコメントの数');
define($const_prefix . '_C_NUMTBS', '1ページに表示するトラックバックの数');
define($const_prefix . '_C_NUMVOTES', '1ページに表示する投票の数');
define($const_prefix . '_C_UTIME', 'コメントの編集を許可する時間の長さ');
define($const_prefix . '_C_UTIME_OPT1', '編集は許可しない');
define($const_prefix . '_C_UTIME_OPT2', '1時間');
define($const_prefix . '_C_UTIME_OPT3', '2時間');
define($const_prefix . '_C_UTIME_OPT4', '1日');
define($const_prefix . '_C_UTIME_OPT5', '2週間');
define($const_prefix . '_C_UTIME_OPT6', '1週間');
define($const_prefix . '_C_UTIME_OPT7', '10週間');
define($const_prefix . '_C_UTIME_OPT8', '30週間');
define($const_prefix . '_C_NUMVPOP', '公開待ち記事が公開されるのに必要な得票数');
define($const_prefix . '_C_UPCOMING', '公開待ち記事の機能を有効にする');
define($const_prefix . '_C_UPCOMINGD', 'この機能を有効にすることにより、通常のユーザによる投稿は公開待ち記事として登録されます。この機能を無効にした場合、投稿された記事は全て公開記事となります。');
define($const_prefix . '_C_VOTING', '投票機能を有効にする');
define($const_prefix . '_C_VOTINGD', 'この機能を有効にすることにより、登録ユーザが各記事に対して投票できるようになります。');
define($const_prefix . '_C_PERIOD', 'トップページに表示する記事の表示順');
define($const_prefix . '_C_PERIOD_OPT1', '投稿の新しいものから');
define($const_prefix . '_C_PERIOD_OPT2', '投票の多い順（24時間）');
define($const_prefix . '_C_PERIOD_OPT3', '投票の多い順（1週間）');
define($const_prefix . '_C_PERIOD_OPT4', '投票の多い順（1ヶ月）');
define($const_prefix . '_C_PERIOD_OPT5', '投票の多い順（全ての期間）');
define($const_prefix . '_C_PERIOD_OPT6', 'コメントの新しいものから');
define($const_prefix . '_C_PERIOD_OPT7', '投稿またはコメントの新しいものから');
define($const_prefix . '_C_TOPTITLE', 'Xiggトップページのタイトル');
define($const_prefix . '_C_HPURL', 'ホームページのURL');
define($const_prefix . '_C_COMMENT', 'コメント機能を有効にする');
define($const_prefix . '_C_COMMENTD', 'この機能を有効にすることにより、各記事に対してコメントを受け付けることができます。');
define($const_prefix . '_C_TBACK', 'トラックバック機能を有効にする');
define($const_prefix . '_C_TBACKD', 'この機能を有効にすることにより、各記事に対するトラックバックを受け付けることができます。');
define($const_prefix . '_C_SHOWVC', '各記事の閲覧数を表示する');
}