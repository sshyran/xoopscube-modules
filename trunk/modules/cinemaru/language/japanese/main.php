<?php

if (defined('__CINEMARU_MAIN_PHP__')) {
    return;
}
define('__CINEMARU_MAIN_PHP__', 1);

define("_MD_CINEMARU_MOVIE_UPLOAD", "動画/MP3アップロード");
define("_MD_CINEMARU_TITLE", "タイトル");
define("_MD_CINEMARU_MOVIE_FILE", "動画/MP3ファイル");
define("_MD_CINEMARU_FLV_ONLY", "FLV/MP3ファイルのみ");
define("_MD_CINEMARU_THUMB_FILE", "サムネイル画像");
define("_MD_CINEMARU_DESC", "説明");
define("_MD_CINEMARU_GENRE", "ジャンル");
define("_MD_CINEMARU_MOVIE_EDIT", "動画情報編集");
define('_MD_CINEMARU_MOVIE_DELETE', '動画情報削除');
define("_MD_CINEMARU_TAG_LOCK", "タグをロックする");
define("_MD_CINEMARU_TAG_LOCK_DESC", "ロックする");
define("_MD_CINEMARU_USER", "投稿者");
define("_MD_CINEMARU_SUBMIT", "投稿する");

define('_MD_CINEMARU_ERROR_NO_DATA', '%s を入力してください');
define('_MD_CINEMARU_ERROR_MAIL_NG_FORMAT', '%s の入力が不正です');
define('_MD_CINEMARU_ERROR_URL_NG_FORMAT', '%s の入力が不正です');
define('_MD_CINEMARU_ERROR_SIZE_OVER', '%s は半角 %s 文字以内で入力してください');
define('_MD_CINEMARU_ERROR_SIZE_UNDER', '%s は半角 %s 文字以上で入力してください');
define('_MD_CINEMARU_ERROR_CONFIRM_NO_MATCH', '%s が一致しませんでした');
define('_MD_CINEMARU_ERROR_MAIL_EXISTS', 'メールアドレスが登録済みでした');
define('_MD_CINEMARU_ERROR_MAIL_NO_EXISTS', 'メールアドレスが登録されていませんでした');
define('_MD_CINEMARU_ERROR_NO_AUTH', 'メールアドレスまたはパスワードが違います');
define('_MD_CINEMARU_ERROR_NO_PASSWORD', 'パスワードが違います');
define('_MD_CINEMARU_ERROR_NO_IMAGE_FILE', '%s は画像ファイルではありません');
define('_MD_CINEMARU_ERROR_NO_FLV_FILE', '%s はFLVファイルではありません');
define('_MD_CINEMARU_ERROR_NG_FILE_UPLOAD', '%s はファイルのアップロードに失敗しました');
define('_MD_CINEMARU_ERROR_NO_FILE', '%s にファイルを指定してください');

define('_MD_CINEMARU_ERROR_UPLOAD_ERR_INI_SIZE', 'ファイルサイズが制限を越えました(UPLOAD_ERR_INI_SIZE)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_FORM_SIZE', 'ファイルサイズが制限を越えました(UPLOAD_ERR_FORM_SIZE)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_PARTIAL', 'アップロードに失敗しました(UPLOAD_ERR_PARTIAL)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_NO_FILE', 'アップロードに失敗しました(UPLOAD_ERR_NO_FILE)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_NO_TMP_DIR', 'アップロードに失敗しました(UPLOAD_ERR_NO_TMP_DIR)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_CANT_WRITE', 'アップロードに失敗しました(UPLOAD_ERR_CANT_WRITE)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_EXTENSION', 'アップロードに失敗しました(UPLOAD_ERR_EXTENSION)');

define('_MD_CINEMARU_ERROR_NO_TITLE', 'タイトルを入力してください');
define('_MD_CINEMARU_ERROR_DESC_OVER', '説明は1000文字以内までです');
define('_MD_CINEMARU_COUNT', '再生数');
define('_MD_CINEMARU_COMMENT', 'コメント');
define('_MD_CINEMARU_EDIT', '編集');
define('_MD_CINEMARU_DELETE', '削除');
define('_MD_CINEMARU_ADD', '追加');
define('_MD_CINEMARU_UPLOAD', 'アップロード');
define('_MD_CINEMARU_UPDATE', '更新');

define('_MD_CINEMARU_MOVIE_NOT_FOUND', '動画が見つかりませんでした');
define('_MD_CINEMARU_UPDATED', '更新しました');
define('_MD_CINEMARU_DELETED', '削除しました');
define('_MD_CINEMARU_THANKSSUBMIT', '投稿ありがとうございました');

define('_MD_CINEMARU_TAG', 'タグ');
define('_MD_CINEMARU_EDIT_TAG', 'タグ編集');
define('_MD_CINEMARU_END_EDIT_TAG', '編集終了');

define('_MD_CINEMARU_NO_REG_AUTH', '投稿権限がありません');
define('_MD_CINEMARU_NO_DEL_AUTH', '削除権限がありません');
define('_MD_CINEMARU_NO_EDIT_AUTH', '編集権限がありません');
define('_MD_CINEMARU_NO_VALID_AUTH', '承認権限がありません');
define('_MD_CINEMARU_NO_REPORT_AUTH', '違反報告権限がありません');
define('_MD_CINEMARU_NO_REPORT_LIST_AUTH', '違反報告リスト閲覧権限がありません');

define('_MD_CINEMARU_NEXT', '次へ');
define('_MD_CINEMARU_PREV', '前へ');

define('_MD_CINEMARU_TOTAL', '合計件数');

define('_MD_CINEMARU_MOVIE_NO_VALID', 'この動画は承認待ちです。');
define('_MD_CINEMARU_MOVIE_NO_VALID2', '未承認');
define('_MD_CINEMARU_MOVIE_NO_VALID3', '未承認にする');
define('_MD_CINEMARU_MOVIE_VALID', '承認');
define('_MD_CINEMARU_MOVIE_VALIDED', '承認しました');
define('_MD_CINEMARU_MOVIE_NG_VALIDED', '未承認しました');

define('_MD_CINEMARU_MOVIE_LIST_NO_VALID', '未承認の動画のみ表示する');
define('_MD_CINEMARU_MOVIE_LIST_NO_VALID_EXISTS', '未承認の動画があります');
define('_MD_CINEMARU_MOVIE_LIST_NORMAL', '通常表示');

define('_MD_CINEMARU_MOVIE', '動画');
define('_MD_CINEMARU_TIME', '日時');
define('_MD_CINEMARU_ACTION', '操作');

define('_MD_CINEMARU_NO_COMMENT_READ', 'コメント閲覧権限がありません');
define('_MD_CINEMARU_NO_DELETE_COMMENT_ADMIN', 'コメント削除権限がありません');
define('_MD_CINEMARU_DELETED_COMMENT', 'コメントを削除しました');
define('_MD_CINEMARU_COMMENT_ADMIN', 'コメント管理');
define('_MD_CINEMARU_COMMENT_LIST', 'コメント一覧');
define('_MD_CINEMARU_COMMENT_TIME', '表示時間');

define('_MD_CINEMARU_LIST', 'リスト表示');
define('_MD_CINEMARU_THUMB', 'サムネイル表示');

define('_MD_CINEMARU_WAIT_VALID', '動画/MP3は承認後、再生できるようになります。');

define('_MD_CINEMARU_SORT', 'ソート');
define('_MD_CINEMARU_SORT_NEW', '登録日時が新しい');
define('_MD_CINEMARU_SORT_OLD', '登録日時が古い');
define('_MD_CINEMARU_SORT_HIGH_HIT', '再生数が多い');
define('_MD_CINEMARU_SORT_LOW_HIT', '再生数が少ない');

define('_MD_CINEMARU_VIOLATION_REPORT_LIST', '違反/リンク切れ報告リスト');
define('_MD_CINEMARU_VIOLATION_REPORT', '違反/リンク切れ報告をする');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT', 'カテゴリ');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT_1', 'リンク切れ');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT_2', '不正アップロード');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT_3', '性的表現・暴力表現');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT_4', 'その他');

define('_MD_CINEMARU_REPORTED', '報告しました');
define('_MD_CINEMARU_DELETED_REPORT', '報告を削除しました');
define('_MD_CINEMARU_CHECK_REPORT_LIST', '違反/リンク切れ報告があります');

define('_MD_CINEMARU_FILE_UPLOAD', 'ファイルアップロード');
define('_MD_CINEMARU_URL', 'URL');
define('_MD_CINEMARU_FILE_URL', 'ファイルのURL');
define('_MD_CINEMARU_IMAGE_FILE_UPLOAD', '画像ファイルアップロード');
define('_MD_CINEMARU_IMAGE_FILE_URL', '画像ファイルのURL');

define('_MD_CINEMARU_BLOG_PASTE_TAG', 'ブログ貼り付け用タグ');

define('_MD_CINEMARU_URL_DESC', 'FLV/MP3ファイルへのURLを指定してください。<br />YouTubeの場合は http://???.youtube.com/watch?v=xxxxxxxxxxx の形式で指定してください。 ');
