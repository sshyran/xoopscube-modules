<?php
$root = XCube_Root::getSingleton();
if (is_object($root->mContext->mUser) && $root->mContext->mUser->isInRole('Site.GuestUser')) {
  define('_MI_MYFRIEND_NAME', '新規登録について');
} else {
  define('_MI_MYFRIEND_NAME', 'マイフレンド');
}
define('_MI_MYFRIEND_GROUP', 'ユーザのグループ');
define('_MI_MYFRIEND_GROUP_DESC', 'SNSで使用するユーザのグループ');

define('_MI_MYFRIEND_DELDAYS', '削除日数');
define('_MI_MYFRIEND_DELDAYS_DESC', '招待者を削除する日数');

define('_MI_MYFRIEND_BLOCK_NAME', '新着ブロック');

define('_MI_MYFRIEND_SUB_SEARCH', 'ユーザ検索');
define('_MI_MYFRIEND_SUB_FAVORITES', 'お気に入り');
define('_MI_MYFRIEND_INSTALL_ERROR', 'このモジュールはPHP5.0以上でないと動作しません。');
?>
