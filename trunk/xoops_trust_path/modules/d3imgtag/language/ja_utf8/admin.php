<?php

// Index (Categories)
define( "_AM_D3IMGTAG_H3_FMT_CATEGORIES" , "%s カテゴリー管理" ) ;
define( "_AM_D3IMGTAG_CAT_TH_TITLE" , "カテゴリー名" ) ;
define( "_AM_D3IMGTAG_CAT_TH_PHOTOS" , "画像数" ) ;
define( "_AM_D3IMGTAG_CAT_TH_OPERATION" , "カテゴリ操作" ) ;
define( "_AM_D3IMGTAG_CAT_TH_IMAGE" , "イメージ" ) ;
define( "_AM_D3IMGTAG_CAT_TH_PARENT" , "親カテゴリー" ) ;
define( "_AM_D3IMGTAG_CAT_TH_IMGURL" , "イメージのURL" ) ;
define( "_AM_D3IMGTAG_CAT_MENU_NEW" , "カテゴリーの新規作成" ) ;
define( "_AM_D3IMGTAG_CAT_MENU_EDIT" , "カテゴリーの編集" ) ;
define( "_AM_D3IMGTAG_CAT_INSERTED" , "カテゴリーを追加しました" ) ;
define( "_AM_D3IMGTAG_CAT_UPDATED" , "カテゴリーを更新しました" ) ;
define( "_AM_D3IMGTAG_CAT_BTN_BATCH" , "変更を反映する" ) ;
define( "_AM_D3IMGTAG_CAT_LINK_MAKETOPCAT" , "トップカテゴリーを追加" ) ;
define( "_AM_D3IMGTAG_CAT_LINK_ADDPHOTOS" , "このカテゴリーに画像を追加" ) ;
define( "_AM_D3IMGTAG_CAT_LINK_EDIT" , "このカテゴリーの編集" ) ;
define( "_AM_D3IMGTAG_CAT_LINK_MAKESUBCAT" , "このカテゴリー下にサブカテゴリー作成" ) ;
define( "_AM_D3IMGTAG_CAT_FMT_NEEDADMISSION" , "未承認画像あり (%s 枚)" ) ;
define( "_AM_D3IMGTAG_CAT_FMT_CATDELCONFIRM" , "カテゴリー %s を削除してよろしいですか？ 配下のサブカテゴリーも含め、画像やコメントがすべて削除されます" ) ;


// Admission
define( "_AM_D3IMGTAG_H3_FMT_ADMISSION" , "%s 投稿画像の承認" ) ;
define( "_AM_D3IMGTAG_TH_SUBMITTER" , "投稿者" ) ;
define( "_AM_D3IMGTAG_TH_TITLE" , "タイトル" ) ;
define( "_AM_D3IMGTAG_TH_DESCRIPTION" , "説明文" ) ;
define( "_AM_D3IMGTAG_TH_CATEGORIES" , "カテゴリー" ) ;
define( "_AM_D3IMGTAG_TH_DATE" , "最終更新日" ) ;


// Photo Manager
define( "_AM_D3IMGTAG_H3_FMT_PHOTOMANAGER" , "%s 画像管理" ) ;
define( "_AM_D3IMGTAG_TH_BATCHUPDATE" , "チェックした画像をまとめて変更する" ) ;
define( "_AM_D3IMGTAG_OPT_NOCHANGE" , "変更なし" ) ;
define( "_AM_D3IMGTAG_JS_UPDATECONFIRM" , "指定された項目についてのみ、チェックした画像を変更します" ) ;


// Module Checker
define( "_AM_D3IMGTAG_H3_FMT_MODULECHECKER" , "IMGTagD3 動作チェッカー (%s)" ) ;

define( "_AM_D3IMGTAG_H4_ENVIRONMENT" , "環境チェック" ) ;
define( "_AM_D3IMGTAG_MB_PHPDIRECTIVE" , "PHP設定" ) ;
define( "_AM_D3IMGTAG_H4_SIZECHECK" , "ディスクスペース使用量 (フルサイズ画像のみ)" );
define( "_AM_D3IMGTAG_MB_BOTHOK" , "両方ok" ) ;
define( "_AM_D3IMGTAG_MB_NEEDON" , "要on" ) ;


define( "_AM_D3IMGTAG_H4_TABLE" , "テーブルチェック" ) ;
define( "_AM_D3IMGTAG_MB_PHOTOSTABLE" , "メイン画像テーブル" ) ;
define( "_AM_D3IMGTAG_MB_DESCRIPTIONTABLE" , "テキストテーブル" ) ;
define( "_AM_D3IMGTAG_MB_CATEGORIESTABLE" , "カテゴリーテーブル" ) ;
define( "_AM_D3IMGTAG_MB_VOTEDATATABLE" , "投票データテーブル" ) ;
define( "_AM_D3IMGTAG_MB_COMMENTSTABLE" , "コメントテーブル" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFPHOTOS" , "画像総数" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFDESCRIPTIONS" , "テキスト総数" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFCATEGORIES" , "カテゴリー総数" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFVOTEDATA" , "投票総数" ) ;
define( "_AM_D3IMGTAG_MB_NUMBEROFCOMMENTS" , "コメント総数" ) ;


define( "_AM_D3IMGTAG_H4_CONFIG" , "設定チェック" ) ;
define( "_AM_D3IMGTAG_MB_PIPEFORIMAGES" , "画像処理プログラム" ) ;
define( "_AM_D3IMGTAG_MB_DIRECTORYFORPHOTOS" , "フルサイズ画像ディレクトリ" ) ;
define( "_AM_D3IMGTAG_MB_DIRECTORYFORTHUMBS" , "サムネイルディレクトリ" ) ;
define( "_AM_D3IMGTAG_MB_DIRECTORYFORPREVIEWS"  , "プレビュー画像ディレクトリ" );
define( "_AM_D3IMGTAG_ERR_LASTCHAR" , "エラー: 最後の文字は'/'でなければなりません" ) ;
define( "_AM_D3IMGTAG_ERR_FIRSTCHAR" , "エラー: 最初の文字は'/'でなければなりません" ) ;
define( "_AM_D3IMGTAG_ERR_PERMISSION" , "エラー: まずこのディレクトリをつくって下さい。その上で、書込可能に設定して下さい。Unixではchmod 777、Windowsでは読み取り専用属性を外します" ) ;
define( "_AM_D3IMGTAG_ERR_NOTDIRECTORY" , "エラー: 指定されたディレクトリがありません." ) ;
define( "_AM_D3IMGTAG_ERR_READORWRITE" , "エラー: 指定されたディレクトリは読み出せないか書き込めないかのいずれかです。その両方を許可する設定にして下さい。Unixではchmod 777、Windowsでは読み取り専用属性を外します" ) ;
define( "_AM_D3IMGTAG_ERR_SAMEDIR" , "エラー: メイン画像用ディレクトリとサムネイル用ディレクトリが一緒です。（その設定は不可能です）" ) ;
define( "_AM_D3IMGTAG_LNK_CHECKGD2" , "GD2(truecolor)モードが動くかどうかのチェック" ) ;
define( "_AM_D3IMGTAG_MB_CHECKGD2" , "（このリンク先が正常に表示されなければ、GD2モードでは動かないものと諦めてください）" ) ;
define( "_AM_D3IMGTAG_MB_GD2SUCCESS" , "成功しました!<br />おそらく、このサーバのPHPでは、GD2(true color)モードで画像を生成可能です。" ) ;


define( "_AM_D3IMGTAG_H4_PHOTOLINK" , "画像のリンクチェック" ) ;
define( "_AM_D3IMGTAG_MB_NOWCHECKING" , "チェック中 ." ) ;
define( "_AM_D3IMGTAG_FMT_PHOTONOTREADABLE" , "メイン画像 (%s) が読めません." ) ;
define( "_AM_D3IMGTAG_FMT_THUMBNOTREADABLE" , "サムネイル画像 (%s) が読めません." ) ;
define( "_AM_D3IMGTAG_FMT_NUMBEROFDEADPHOTOS" , "画像のないレコードが %s 個ありました。" ) ;
define( "_AM_D3IMGTAG_FMT_NUMBEROFDEADTHUMBS" , "サムネイルが %s 個未作成です" ) ;
define( "_AM_D3IMGTAG_FMT_NUMBEROFREMOVEDTMPS" , "テンポラリを %s 個削除しました" ) ;
define( "_AM_D3IMGTAG_LINK_REDOTHUMBS" , "サムネイル再構築" ) ;
define( "_AM_D3IMGTAG_LINK_TABLEMAINTENANCE" , "テーブルメンテナンス" ) ;



// Redo Thumbnail
define( "_AM_D3IMGTAG_H3_FMT_RECORDMAINTENANCE" , "IMGTagD3 画像メンテナンス (%s)" ) ;

define( "_AM_D3IMGTAG_FMT_CHECKING" , "%s をチェック中 ... " ) ;

define( "_AM_D3IMGTAG_FORM_RECORDMAINTENANCE" , "サムネイルの再構築など、写真データの各種メンテナンス" ) ;

define( "_AM_D3IMGTAG_MB_FAILEDREADING" , "画像ファイルの読み込み失敗" ) ;
define( "_AM_D3IMGTAG_MB_CREATEDTHUMBS" , "サムネイルとプレビューの再作成完了" ) ;
define( "_AM_D3IMGTAG_MB_BIGTHUMBS" , "サムネイルを作成できないので、コピーしました" ) ;
define( "_AM_D3IMGTAG_MB_BIGPREVIEW" , "プレビューを作成できないので、コピーしました" );
define( "_AM_D3IMGTAG_MB_SKIPPED" , "スキップします" ) ;
define( "_AM_D3IMGTAG_MB_SIZEREPAIRED" , "(登録されていたピクセル数を修正しました)" ) ;
define( "_AM_D3IMGTAG_MB_RECREMOVED" , "このレコードは削除されました" ) ;
define( "_AM_D3IMGTAG_MB_PHOTONOTEXISTS" , "画像がありません" ) ;
define( "_AM_D3IMGTAG_MB_PHOTORESIZED" , "サイズ調整しました" ) ;

define( "_AM_D3IMGTAG_TEXT_RECORDFORSTARTING" , "処理を開始するレコード番号" ) ;
define( "_AM_D3IMGTAG_TEXT_NUMBERATATIME" , "一度に処理する画像数" ) ;
define( "_AM_D3IMGTAG_LABEL_DESCNUMBERATATIME" , "この数を大きくしすぎるとサーバのタイムアウトを招きます" ) ;

define( "_AM_D3IMGTAG_RADIO_FORCEREDO" , "サムネイルがあっても常に作成し直す" ) ;
define( "_AM_D3IMGTAG_RADIO_REMOVEREC" , "画像がないレコードを削除する" ) ;
define( "_AM_D3IMGTAG_RADIO_RESIZE" , "今のピクセル数設定よりも大きな画像はサイズを切りつめる" ) ;

define( "_AM_D3IMGTAG_MB_FINISHED" , "完了" ) ;
define( "_AM_D3IMGTAG_LINK_RESTART" , "再スタート" ) ;
define( "_AM_D3IMGTAG_SUBMIT_NEXT" , "次へ" ) ;

define( "_AM_D3IMGTAG_MB_CHECKTTF" , "<b>FreeTypeフォントのチェック</b>" );
define( "_AM_D3IMGTAG_MB_CHECKTTFSUCCESS" , "<span style='color:#009900'>--> PHP Freetype がインストールされています</span>" );
define( "_AM_D3IMGTAG_MB_CHECKTTFFAILED" , "<span style='color:#FF0000'>--> Freetype がインストールされていません。Watermark は正しく動作しないでしょう!</span>" );



// Batch Register
define( "_AM_D3IMGTAG_H3_FMT_BATCHREGISTER" , "IMGTagD3 画像一括登録 (%s)" ) ;
define( "_AM_D3IMGTAG_H3_FMT_BATCHREGISTERNOTICE" , "一度に 100 画像以上実行してはいけません。サーバーがタイムアウトを引き起こし投稿数が正確ではなくなる可能性があります。" );


// GroupPerm Global
define( "_AM_D3IMGTAG_ALBM_GROUPPERM_GLOBAL" , "各グループの権限設定" ) ;
define( "_AM_D3IMGTAG_ALBM_GROUPPERM_GLOBALDESC" , "グループ個々について、権限を設定します" ) ;
define( "_AM_D3IMGTAG_ALBM_GPERMUPDATED" , "権限設定を変更しました" ) ;


?>