<?php
// $Id: main.php,v 1.4 2005/09/22 08:08:02 mcleines Exp $
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
// shortcuts for Byte, Kilo, Mega
define("_MD_D3XCGAL_BYTES","バイト");
define("_MD_D3XCGAL_KB","KB");
define("_MD_D3XCGAL_MB","MB");

define("_MD_D3XCGAL_NPICS","ファイル数:%s");
define("_MD_D3XCGAL_PICS","写真");
define("_MD_D3XCGAL_ALBUM","アルバム");
define("_MD_D3XCGAL_ERROR","戻る");
define("_MD_D3XCGAL_KEYS","キーワード");
define("_MD_D3XCGAL_CONTINUE","続ける");

define("_MD_D3XCGAL_RANDOM","ランダムファイル");
define("_MD_D3XCGAL_LASTUP","新着写真");
define("_MD_D3XCGAL_LASTCOM","最新コメント");
define("_MD_D3XCGAL_TOPN","高人気写真");
define("_MD_D3XCGAL_TOPRATED","高評価写真");
define("_MD_D3XCGAL_LASTHITS","最新ヒット");
define("_MD_D3XCGAL_SEARCH","検索");
define("_MD_D3XCGAL_USEARCH","サムネイル画像 ");
define("_MD_D3XCGAL_MOST_SENT","送信されたeカード");

define("_MD_D3XCGAL_ACCESS_DENIED","このページに対するアクセス権がありません。");
define("_MD_D3XCGAL_PERM_DENIED","この操作を行う権限がありません。");
define("_MD_D3XCGAL_PARAM_MISSING","必要なパラメータ無しでスクリプトが実行されました。");
define("_MD_D3XCGAL_NON_EXIST_AP","選択されたアルバム/写真は存在しません");
define("_MD_D3XCGAL_QUOTA_EXCEEDED","ディスク使用量オーバー<br /><br />あなたが使用できるディスク容量は [quota]Kです。現在 [space]Kを使用しています。このファイルを追加するとディスク容量をオーバーします。");
define("_MD_D3XCGAL_GD_FILE_TYPE_ERR","GDイメージライブラリーを使用する場合、JPEGとPNG形式のファイルのみ使用可能です。");
define("_MD_D3XCGAL_INVALID_IMG","あなたがアップロードしたイメージが破損したか、GDライブラリーで処理することができません。");
define("_MD_D3XCGAL_RESIZE_FAILED","イメージサイズが小さいため、サムネイルを作成できません。");
define("_MD_D3XCGAL_NO_IMG_TO_DISPLAY","表示するイメージはありません。");
define("_MD_D3XCGAL_NO_EXIST_CAT","選択したカテゴリは存在しません。");
define("_MD_D3XCGAL_ORPHAN_CAT","存在しない親カテゴリを持っています。カテゴリマネージャーを使って問題を解決してください!");
define("_MD_D3XCGAL_DIRECTORY_RO","ディレクトリ「 %s 」に書込み権がありません。ファイルの削除はできません。");
define("_MD_D3XCGAL_PIC_IN_INVALID_ALBUM","存在しないアルバム(%s)内にファイルがあります !?");
define("_MD_D3XCGAL_GD_VERSION_ERR","あなたのサーバー上で走るPHPはGDバージョン2.xを支援しません、configページのGDバージョン1.xに変更してください");
define("_MD_D3XCGAL_NO_GD_FOUND","PHP、あなたのサーバー上で実行できるGDイメージライブラリーはサポートされていません、ImageMagickまたはNetpbmのインストールを推奨します。");
define("_MD_D3XCGAL_IM_ERROR","ImageMagick-返り値-を実行するエラー");
define("_MD_D3XCGAL_IM_ERROR_CMD","コマンドライン");
define("_MD_D3XCGAL_IM_ERROR_CONV","The convert program said");

// ------------------------------------------------------------------------- //
// File include/theme_func.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_THM_ALB_LT","アルバムリストへ移動");
define("_MD_D3XCGAL_THM_ALB_LL","アルバムリスト");
define("_MD_D3XCGAL_THM_GAL_MYT","パーソナルギャラリーへ移動");
define("_MD_D3XCGAL_THM_GAL_MYL","マイギャラリー");
define("_MD_D3XCGAL_THM_ADM_MT","管理者モードへ変更");
define("_MD_D3XCGAL_THM_ADM_ML","管理者モード");
define("_MD_D3XCGAL_THM_USER_MT","ユーザモードに変更");
define("_MD_D3XCGAL_THM_USER_ML","ユーザモード");
define("_MD_D3XCGAL_THM_UPLT","アルバムにファイルをアップロード");
define("_MD_D3XCGAL_THM_UPLL","ファイルのアップロード");
define("_MD_D3XCGAL_THM_UPLTMORE","アルバムに複数ファイルをアップロード");
define("_MD_D3XCGAL_THM_UPLLMORE","複数ファイルのアップロード");
define("_MD_D3XCGAL_THM_UPLTBATCH","ディレクトリからファイルの一括登録");
define("_MD_D3XCGAL_THM_UPLLBATCH","ファイルの一括登録");
define("_MD_D3XCGAL_THM_LAST_UPL","最新アップロード");
define("_MD_D3XCGAL_THM_LAST_COM","最新コメント");
define("_MD_D3XCGAL_THM_MOST_VIEW","高人気写真");
define("_MD_D3XCGAL_THM_TOP_RATE","高評価写真");
define("_MD_D3XCGAL_THM_SEARCH","検索");
define("_MD_D3XCGAL_THM_UPL_APPR","アップロードの承認");

define("_MD_D3XCGAL_THM_ALBMGR_LNK","マイアルバムの作成/整理");
define("_MD_D3XCGAL_THM_MODIFY_LNK","マイアルバムの修正");
define("_MD_D3XCGAL_THM_CAT","カテゴリ");
define("_MD_D3XCGAL_THM_ALB","アルバム");
define("_MD_D3XCGAL_THM_PIC","ファイル");
define("_MD_D3XCGAL_THM_ALBONPAGE","アルバム数 %d / %dページ中");
define("_MD_D3XCGAL_THM_DATE","日付");
define("_MD_D3XCGAL_THM_NAME","ファイル名");
define("_MD_D3XCGAL_THM_SORT_DA","日付の昇順で並び替え");
define("_MD_D3XCGAL_THM_SORT_DD","日付の降順で並び替え");
define("_MD_D3XCGAL_THM_SORT_NA","ファイル名の昇順で並び替え");
define("_MD_D3XCGAL_THM_SORT_ND","ファイル名の降順で並び替え");
define("_MD_D3XCGAL_THM_PICPAGE","ファイル数 %d / %dページ中");
define("_MD_D3XCGAL_THM_USERPAGE","ユーザ数 %d / %dページ中");

// ------------------------------------------------------------------------- //
// File include/functions.inc.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_FUNC_FNAME","ファイル名 : ");
define("_MD_D3XCGAL_FUNC_FSIZE","ファイルサイズ: ");
define("_MD_D3XCGAL_FUNC_DIM","大きさ : ");
define("_MD_D3XCGAL_FUNC_DATE","登録日 : ");
define("_MD_D3XCGAL_FUNC_COM","コメント数 %s");
define("_MD_D3XCGAL_FUNC_VIEW","ヒット数 %s");
define("_MD_D3XCGAL_FUNC_VOTE","投票数 %s");
define("_MD_D3XCGAL_FUNC_SEND","%s times");
define("_MD_D3XCGAL_FUNC_DELUSER","Deleted User");
// ------------------------------------------------------------------------- //
// File admin.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_ADMIN_LEAVE","管理者モードを終了中 ...");
define("_MD_D3XCGAL_ADMIN_ENTER","管理者モードに移行中 ...");

// ------------------------------------------------------------------------- //
// File albmgr.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_ALBMGR_NEED_NAME","アルバムにはアルバム名が必要です !");
define("_MD_D3XCGAL_ALBMGR_CONF_MOD","本当に更新しても宜しいですか ?");
define("_MD_D3XCGAL_ALBMGR_NO_CHANGE","何も変更されていません !");
define("_MD_D3XCGAL_ALBMGR_NEW_ALB","新しいアルバム");
define("_MD_D3XCGAL_ALBMGR_CONF_DEL1","本当にこの写真を削除してもよろしいですか?");
define("_MD_D3XCGAL_ALBMGR_CONF_DEL2","アルバムに含まれる全ての写真とコメントは削除されます !");
define("_MD_D3XCGAL_ALBMGR_SELECT_FIRST","最初にアルバムを選択してください。");
define("_MD_D3XCGAL_ALBMGR_ALB_MGR","アルバム管理");
define("_MD_D3XCGAL_ALBMGR_MY_GAL","* マイギャラリー *");
define("_MD_D3XCGAL_ALBMGR_NO_CAT","* カテゴリ無し *");
define("_MD_D3XCGAL_ALBMGR_DEL","削除");
define("_MD_D3XCGAL_ALBMGR_NEW","新規作成");
define("_MD_D3XCGAL_ALBMGR_APPLY","更新の適用");
define("_MD_D3XCGAL_ALBMGR_SELECT","カテゴリ選択");

// ------------------------------------------------------------------------- //
// File db_input.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_DB_ALB_NEED_TITLE","アルバム名を入力してください !");
define("_MD_D3XCGAL_DB_NO_NEED","更新は必要ありません。");
define("_MD_D3XCGAL_DB_ALB_UPDATED","アルバムが更新されました。");
define("_MD_D3XCGAL_DB_UNKOWN","選択したアルバムが存在しない、又はこのアルバムにアップロードする権限がありません。");
define("_MD_D3XCGAL_DB_NO_PICUP","写真はアップロードされませんでした !<br /><br />アップロードする写真を正しく選択した場合、サーバが</br>ファイルのアップロードを許可しているか確認してください ...");
define("_MD_D3XCGAL_DB_ERR_MKDIR","ディレクトリ %s の作成に失敗しました !");
define("_MD_D3XCGAL_DB_DEST_DIR_RO","対象ディレクトリ %s はスクリプトによる書込みが出来ません !");
define("_MD_D3XCGAL_DB_ERR_FEXT","次の拡張子のファイルのみ使用できます : <br /><br />%s.");
define("_MD_D3XCGAL_DB_ERR_MOVE","Impossible to move %s to %s!");
define("_MD_D3XCGAL_DB_ERR_PIC_SIZE","あなたがアップロードした写真のサイズは大き過ぎます (最大サイズは %s x %sです");
define("_MD_D3XCGAL_DB_ERR_FSIZE","あなたがアップロードしたファイルのサイズは大き過ぎます (最大サイズは %s KBです) !");
define("_MD_D3XCGAL_DB_ERR_IMG_INVALID","あなたがアップロードしたファイルは有効な画像ではありません !");
define("_MD_D3XCGAL_DB_IMG_ALLOWED"," %s の画像のみアップロード出来ます。");
define("_MD_D3XCGAL_DB_ERR_INSERT","写真 '%s' はアルバムに登録できません。 ");
define("_MD_D3XCGAL_DB_UPLOAD_SUCC","あなたの写真は正常にアップロードされました<br /><br />管理者の承認後に表示されます。");
define("_MD_D3XCGAL_DB_UPL_SUCC","あなたの写真は正常に登録されました。");
// ------------------------------------------------------------------------- //
// File delete.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_DEL_CAPTION","キャプション");
define("_MD_D3XCGAL_DEL_FS_PIC","フルサイズイメージ");
define("_MD_D3XCGAL_DEL_DEL_SUCCESS","削除成功");
define("_MD_D3XCGAL_DEL_NS_PIC","ノーマルサイズイメージ");
define("_MD_D3XCGAL_DEL_ERR_DEL","削除不可");
define("_MD_D3XCGAL_DEL_THUMB","サムネイル");
define("_MD_D3XCGAL_DEL_COMMENT","コメント");
define("_MD_D3XCGAL_DEL_IMGALB","アルバム内のイメージ");
define("_MD_D3XCGAL_DEL_ALB_DEL_SUC","アルバム「 %s 」が削除されました。");
define("_MD_D3XCGAL_DEL_ALBMGR","アルバムマネージャー");
define("_MD_D3XCGAL_DEL_INVALID","「 %s 」に不正なデータが発生しました。");
define("_MD_D3XCGAL_DEL_CREATE","アルバム「 %s 」の作成中");
define("_MD_D3XCGAL_DEL_UPDATE","アルバム「 %s 」 アルバム名「 %s 」 インデックス「 %s 」を更新しています。");
define("_MD_D3XCGAL_DEL_DELPIC","ファイルの削除");
define("_MD_D3XCGAL_DEL_DELALB","アルバムの削除");

// ------------------------------------------------------------------------- //
// File displayimage.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_DIS_CONF_DEL","本当にこのファイルを削除してもよろしいですか ? p}n同時にコメントも削除されます。");
define("_MD_D3XCGAL_DIS_DEL_PIC","この写真を削除");
define("_MD_D3XCGAL_DIS_SIZE","%s x %s ピクセル");
define("_MD_D3XCGAL_DIS_VIEWS","%s 回");
define("_MD_D3XCGAL_DIS_SLIDE","スライドショー");
define("_MD_D3XCGAL_DIS_STOP_SLIDE","スライドショーを停止");
define("_MD_D3XCGAL_DIS_FULL","クリックでフルサイズの画像を表示");
define("_MD_D3XCGAL_DIS_TITLE","ファイル情報");
define("_MD_D3XCGAL_DIS_FNAME","ファイル名");
define("_MD_D3XCGAL_DIS_ANAME","アルバム名");
define("_MD_D3XCGAL_DIS_RATING","レーティング (投票数 %s 件)");
define("_MD_D3XCGAL_DIS_FSIZE","ファイルサイズ");
define("_MD_D3XCGAL_DIS_DIMEMS","ディメンション");
define("_MD_D3XCGAL_DIS_DISPLAYED","表示");
define("_MD_D3XCGAL_DIS_CAMERA","カメラ");
define("_MD_D3XCGAL_DIS_DATA_TAKEN","撮影日時");
define("_MD_D3XCGAL_DIS_APERTURE","レンズ");
define("_MD_D3XCGAL_DIS_EXPTIME","露出時間");
define("_MD_D3XCGAL_DIS_FLENGTH","焦点距離");
define("_MD_D3XCGAL_DIS_COMMENT","コメント");
define("_MD_D3XCGAL_DIS_BACK_TNPAGE","サムネイルページに戻る");
define("_MD_D3XCGAL_DIS_SHOW_PIC_INFO","ファイル情報の表示/非表示");
define("_MD_D3XCGAL_DIS_SEND_CARD","この写真をeカードとして送信する");
define("_MD_D3XCGAL_DIS_CARD_DISABLE","eカードは無効");
define("_MD_D3XCGAL_DIS_CARD_DISABLEMSG","eカードは送信できません。");
define("_MD_D3XCGAL_DIS_NEXT","次へ");
define("_MD_D3XCGAL_DIS_PREV","前へ");
define("_MD_D3XCGAL_DIS_PICPOS","アルバム %s/%s");
define("_MD_D3XCGAL_DIS_RATE_THIS","このファイルを評価する");
define("_MD_D3XCGAL_DIS_NO_VOTE","( 未投票 )");
define("_MD_D3XCGAL_DIS_RATINGCUR","( 現在のレーティング: %s/5&nbsp;&nbsp;&nbsp;投票数 %s件 )");
define("_MD_D3XCGAL_DIS_RUBBISH","酷い");
define("_MD_D3XCGAL_DIS_POOR","悪い");
define("_MD_D3XCGAL_DIS_FAIR","普通");
define("_MD_D3XCGAL_DIS_GOOD","良い");
define("_MD_D3XCGAL_DIS_EXCELLENT","素晴らしい");
define("_MD_D3XCGAL_DIS_GREAT","凄い");
define("_MD_D3XCGAL_DIS_UPLOADER","送信者");
define("_MD_D3XCGAL_DIS_EXIF_ERR","PHP running on your server does not support reading EXIF data in JPEG files, please turn this off on the general configuration page.");
define("_MD_D3XCGAL_DIS_VIEW_MORE_BY","送信者の他の画像を見る");
define("_MD_D3XCGAL_DIS_SUBIP","送信者 IPアドレス");
define("_MD_D3XCGAL_DIS_SENT","eカード送信数");
// ------------------------------------------------------------------------- //
// File ecard.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_CARD_TITLE","eカードの送信");
define("_MD_D3XCGAL_CARD_INVALIDE_EMAIL","<b>警告</b> : メールアドレスが正しくありません !");
define("_MD_D3XCGAL_CARD_ECARD_TITLE","%s のeカード");
define("_MD_D3XCGAL_CARD_VIEW_ECARD","eカードが正常に表示されない場合は、このリンクをクリックしてください。");
define("_MD_D3XCGAL_CARD_VIEW_MORE_PICS","もっと写真を見る場合は、このリンクをクリックしてください !");
define("_MD_D3XCGAL_CARD_SEND_SUCCESS","eカードが送信されました。");
define("_MD_D3XCGAL_CARD_SEND_FAILED","申し訳ございません、eカードを送信出来ませんでした ...");
define("_MD_D3XCGAL_CARD_FROM","From");
define("_MD_D3XCGAL_CARD_YOUR_NAME","名前");
define("_MD_D3XCGAL_CARD_YOUR_EMAIL","メールアドレス");
define("_MD_D3XCGAL_CARD_TO","To");
define("_MD_D3XCGAL_CARD_RCPT_NAME","受取人の名前");
define("_MD_D3XCGAL_CARD_RCPT_EMAIL","受取人のメールアドレス");
define("_MD_D3XCGAL_CARD_GREETINGS","あいさつ");
define("_MD_D3XCGAL_CARD_MESSAGE","メッセージ");
define("_MD_D3XCGAL_CARD_PERHOUR","%s によりIPアドレス %s より %s ( ギャラリー時間 ) に送信されました。");
define("_MD_D3XCGAL_CARD_NOTINDB","eカードデータをデータベースに保存できません<br />管理者に確認して下さい");


// ------------------------------------------------------------------------- //
// File editpics.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_EDITPICS_PIC_INFO","写真情報");
define("_MD_D3XCGAL_EDITPICS_TITLE","写真名");
define("_MD_D3XCGAL_EDITPICS_DESC","説明");
define("_MD_D3XCGAL_EDITPICS_INFOSTR","%sx%s - %s KB - ヒット回数 %s - 投票件数 %s");
define("_MD_D3XCGAL_EDITPICS_APPROVE","ファイルの承認");
define("_MD_D3XCGAL_EDITPICS_PP_APPROVE","承認の延期");
define("_MD_D3XCGAL_EDITPICS_DEL_PIC","ファイルの削除");
define("_MD_D3XCGAL_EDITPICS_RVIEW","ヒットカウンタのリセット");
define("_MD_D3XCGAL_EDITPICS_RVOTES","投票をリセット");
define("_MD_D3XCGAL_EDITPICS_DCOM","コメントの削除");
define("_MD_D3XCGAL_EDITPICS_UPL_APPROVAL","アップロード承認");
define("_MD_D3XCGAL_EDITPICS_EDIT","ファイルの編集");
define("_MD_D3XCGAL_EDITPICS_NEXT","前へ");
define("_MD_D3XCGAL_EDITPICS_PREV","次へ");
define("_MD_D3XCGAL_EDITPICS_NUMDIS","ファイル表示数");
define("_MD_D3XCGAL_EDITPICS_APPLY","修正の適用");

// ------------------------------------------------------------------------- //
// File index.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_INDEX_CONF_DEL","本当にこのアルバムを削除しても宜しいですか ? 同時に全ての写真とコメントは削除されます。");
define("_MD_D3XCGAL_INDEX_DEL","削除");
define("_MD_D3XCGAL_INDEX_MOD","プロパティ");
define("_MD_D3XCGAL_INDEX_EDIT","写真の編集");
define("_MD_D3XCGAL_INDEX_STAT1","カテゴリ数:<b>[cat]</b>&nbsp;&nbsp;&nbsp;アルバム数:<b>[albums]</b>&nbsp;&nbsp;&nbsp;写真枚数:<b>[pictures]</b>&nbsp;&nbsp;&nbsp;コメント数:<b>[comments]</b>&nbsp;&nbsp;&nbsp;ヒット回数:<b>[views]</b>");
define("_MD_D3XCGAL_INDEX_STAT2","アルバム数:<b>[albums]</b>&nbsp;&nbsp;&nbsp;写真枚数:<b>[pictures]</b>&nbsp;&nbsp;&nbsp;ヒット回数:<b>[views]</b>");
define("_MD_D3XCGAL_INDEX_USERS_GAL","%sのギャラリー");
define("_MD_D3XCGAL_INDEX_STAT3","アルバム数:<b>[albums]</b>&nbsp;&nbsp;&nbsp;写真枚数:<b>[pictures]</b>&nbsp;&nbsp;&nbsp;コメント数:<b>[comments]</b>&nbsp;&nbsp;&nbsp;ヒット回数:<b>[views]</b>");
define("_MD_D3XCGAL_INDEX_ULIST","ユーザリスト");
define("_MD_D3XCGAL_INDEX_NO_UGAL","ユーザギャラリーはありません。");
define("_MD_D3XCGAL_INDEX_NALBS","アルバム数 %s");
define("_MD_D3XCGAL_INDEX_NPICS","ファイル数 %s");
define("_MD_D3XCGAL_INDEX_LASTADD","、最終追加日:%s");

//--------------------------------------------------------------------------//
// File modifyalb.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_MODIFYALB_UPD_ALB_N","アルバムの更新 %s");
define("_MD_D3XCGAL_MODIFYALB_GEN_SET","一般設定");
define("_MD_D3XCGAL_MODIFYALB_ALB_TITLE","アルバム名");
define("_MD_D3XCGAL_MODIFYALB_ALB_CAT","カテゴリ");
define("_MD_D3XCGAL_MODIFYALB_ALB_DESC","説明");
define("_MD_D3XCGAL_MODIFYALB_ALB_THUMB","サムネイル");
define("_MD_D3XCGAL_MODIFYALB_ALB_PERM","このアルバムに対するパーミッション");
define("_MD_D3XCGAL_MODIFYALB_CAN_VIEW","アルバム表示可能");
define("_MD_D3XCGAL_MODIFYALB_CAN_UPLOAD","ビジターは写真をアップロード出来る");
define("_MD_D3XCGAL_MODIFYALB_CAN_COM","ビジターはコメントを投稿できる");
define("_MD_D3XCGAL_MODIFYALB_CAN_RATE","ビジターは写真を評価出来る");
define("_MD_D3XCGAL_MODIFYALB_USER_GAL","ユーザギャラリー");
define("_MD_D3XCGAL_MODIFYALB_NO_CAT","* カテゴリー無し *");
define("_MD_D3XCGAL_MODIFYALB_ALB_EMPTY","アルバムには何も入っていません");
define("_MD_D3XCGAL_MODIFYALB_LAST_UPL","最新アップロード");
define("_MD_D3XCGAL_MODIFYALB_PUB_ALB","全員 (パブリックアルバム)");
define("_MD_D3XCGAL_MODIFYALB_ME_ONLY","私のみ");
define("_MD_D3XCGAL_MODIFYALB_OWNER_ONLY","アルバムの所有者 (%s) のみ");
define("_MD_D3XCGAL_MODIFYALB_GROUP_ONLY"," '%s' グループメンバーのみ");
define("_MD_D3XCGAL_MODIFYALB_ERR_NO_ALB","修正できるアルバムがデータベースにありません。");
define("_MD_D3XCGAL_MODIFYALB_UPDATE","アルバムの更新");

// ------------------------------------------------------------------------- //
// File ratepic.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_RATE_ALREADY","申し訳ございません、あなたは既にこのファイルを評価しています。");
define("_MD_D3XCGAL_RATE_OK","あなたの投票は受理されました。");

// ------------------------------------------------------------------------- //
// File search.php - OK
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_SEARCH_TITLE","写真の検索");

// ------------------------------------------------------------------------- //
// File upload.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_UPL_TITLE","ファイルのアップロード");
define("_MD_D3XCGAL_UPL_MAX_FSIZE","アップロード可能な最大ファイルサイズは %s KBです。");
define("_MD_D3XCGAL_UPL_ALBUM","アルバム");
define("_MD_D3XCGAL_UPL_PICTURE","ファイル");
define("_MD_D3XCGAL_UPL_PIC_TITLE","ファイル名");
define("_MD_D3XCGAL_UPL_DESCRIPTION","ファイルの説明");
define("_MD_D3XCGAL_UPL_KEYWORDS","キーワード (半角スペースで区切る)");
define("_MD_D3XCGAL_UPL_ERR_NO_ALB_UPLOAD","申し訳ございません。あなたがファイルをアップロード許可されているアルバムはありません。");
define("_MD_D3XCGAL_UPL_YOURALB","プライベートアルバム");
define("_MD_D3XCGAL_UPL_ALBPUB","パブリックアルバム");
define("_MD_D3XCGAL_UPL_OUSERALB","Other User Albums");



?>