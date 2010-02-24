<?php

$dirname = basename(dirname(dirname(dirname(__FILE__))));
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);

include_once 'common.php';

$main_consts = array(
    '_PAGENAVI_INFO'      => '全%s件中、 %s件目から%s件目までを表示',
    '_REQ_MARK'           => '<font color="red">(必須)</font>',
    '_SEARCH'             => '検索',
    '_SEARCH_RESULT'      => '検索結果',
    '_ADD_DATE'           => '登録日時',
    '_UNAME'              => '登録ユーザ名',
    '_FILE'               => 'ファイル',
    '_ADD'                => '登録',
    '_ADD_MSG'            => '登録しました。',
    '_UPDATE'             => '更新',
    '_UPDATE_MSG'         => '更新しました。',
    '_DELETE'             => '削除',
    '_DELETE_CONFIRM_MSG' => '本当にこの情報を削除しますか？',
    '_DELETE_MSG'         => '削除しました。',
    '_DETAIL'             => '詳細',
    '_CANCEL'             => 'キャンセル',
    '_NOT_FOUND_MSG'      => '検索条件に該当する資料はありませんでした。',
    '_REQ_ERR_MSG'        => '「%s」は、必ず入力もしくは選択してください。',
    '_RANGE_ERR_MSG'      => '「%s」の入力値が許容範囲(%s)を超えています。',
    '_INT_ERR_MSG'        => '「%s」に整数値以外が入力されています。',
    '_FLOAT_ERR_MSG'      => '「%s」に小数値以外が入力されています。',
    '_FILE_TYPE_ERR_MSG'  => 'ファイル「%s」をアップロードできませんでした。',
    '_FILE_SIZE_ERR_MSG'  => 'ファイル「%s」の容量が制限値を超えています。',
    '_FILE_SAME_ERR_MSG'  => 'ファイル「%s」のアップロードと削除は同時に行えません。',
    '_DUPLICATE_ERR_MSG'  => 'すでに同じ内容の情報が登録されているため、登録できません。',
    '_TOKEN_ERR_MSG'      => 'トークンエラーが発生しました。',
    '_SYSTEM_ERR_MSG'     => 'システムエラーが発生しました。',
    '_PARAM_ERR_MSG'      => 'パラメーターが不正です。',
    '_PERM_ERR_MSG'       => 'この操作を行う権限がありません。',
    '_NO_ERR_MSG'         => '指定された情報はありません。'
);

foreach ($main_consts as $key => $value) {
    if (!defined('_MD_' . $affix . $key)) {
        define('_MD_' . $affix . $key, $value);
    }
}

?>