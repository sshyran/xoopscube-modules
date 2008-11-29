<?php
// $Id: admin.php,v 1.2 2005/09/01 13:58:33 mcleines Exp $
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
define("_AM_D3XCGAL_CONFIG","xcGalleryD3 管理");
define("_AM_D3XCGAL_GENERALCONF","一般設定");
define("_AM_D3XCGAL_CATMNGR","カテゴリー管理");
define("_AM_D3XCGAL_USERMNGR","ユーザー管理");
define("_AM_D3XCGAL_GROUPMNGR","グループ管理");
define("_AM_D3XCGAL_BATCHADD","アップロード画像の一括登録");
define("_AM_D3XCGAL_ECARDMNGR","eカード管理");
define("_AM_D3XCGAL_PICAPP","承認待ち画像");

define("_AM_D3XCGAL_PARAM_MISSING","スクリプトは要求されたパラメーター(s)なしで呼びだされました。");


// ------------------------------------------------------------------------- //
// File usermgr.php
// ------------------------------------------------------------------------- //
define("_AM_D3XCGAL_USERMGR_TITLE","xcGalleryユーザの管理");
define("_AM_D3XCGAL_USERMGR_USHOW","アルバム/作成ユーザーを表示");
define("_AM_D3XCGAL_USERMGR_USHOWDEL","すべての削除されたユーザのアルバムを表示します");
define("_AM_D3XCGAL_USERMGR_ULIST","ユーザーリスト");
define("_AM_D3XCGAL_USERMGR_USER","ユーザー");
define("_AM_D3XCGAL_USERMGR_ALBUMS","アルバム");
define("_AM_D3XCGAL_USERMGR_PICS","写真");
define("_AM_D3XCGAL_USERMGR_QUOTA","用いられている割り当て");
define("_AM_D3XCGAL_USERMGR_ALB","アルバム");
define("_AM_D3XCGAL_USERMGR_DELUID","デラウェア・ユーザid");
define("_AM_D3XCGAL_USERMGR_OPT","操作");
define("_AM_D3XCGAL_USERMGR_NOTMOVE","** 移動しません **");
define("_AM_D3XCGAL_USERMGR_DEL","削除");
define("_AM_D3XCGAL_USERMGR_PROPS","プロパティ");
define("_AM_D3XCGAL_USERMGR_EDITP","ファイルの編集");

define("_AM_D3XCGAL_USERMGR_UONPAGE","ユーザ数 %d / %dページ中");
define("_AM_D3XCGAL_USERMGR_NOUSER","選択したユーザは存在しません !");

// ------------------------------------------------------------------------- //
// File searchnew.php
// ------------------------------------------------------------------------- //
define("_AM_D3XCGAL_SRCHNEW_TITLE","新しいファイルの検索");
define("_AM_D3XCGAL_SRCHNEW_SEL_DIR","ディレクトリ選択");
define("_AM_D3XCGAL_SRCHNEW_SEL_DIR_MSG","ここではFTPによりサーバにアップロードしたファイルをアルバムに一括登録します。<br /><br />ファイルをアップロードしたディレクトリを選択してください。");
define("_AM_D3XCGAL_SRCHNEW_NO_PIC_ADD","追加するファイルはありません。");
define("_AM_D3XCGAL_SRCHNEW_NEED_ONE_ALB","この機能を使うためには1つ以上のアルバムが必要です。");
define("_AM_D3XCGAL_SRCHNEW_WARNING","警告");
define("_AM_D3XCGAL_SRCHNEW_CHG_PERM","スクリプトがこのディレクトリに書込めませんでした。ファイルを追加する前にディレクトリのパーミッションモードを755または777に変更する必要があります !");
define("_AM_D3XCGAL_SRCHNEW_TARGET_ALB","<b>「</b>%s<b>」内のファイルを</b>%s<b>に追加する</b>");
define("_AM_D3XCGAL_SRCHNEW_FOLDER","フォルダ");
define("_AM_D3XCGAL_SRCHNEW_IMAGE","画像");
define("_AM_D3XCGAL_SRCHNEW_ALB","アルバム");
define("_AM_D3XCGAL_SRCHNEW_RESULT","結果");
define("_AM_D3XCGAL_SRCHNEW_DIR_RO","書込み権がありません。");
define("_AM_D3XCGAL_SRCHNEW_CANT_READ","読取り権がありません。");
define("_AM_D3XCGAL_SRCHNEW_INSERT","新規ファイルのギャラリーへの追加");
define("_AM_D3XCGAL_SRCHNEW_LIST_NEW","新規ファイル一覧");
define("_AM_D3XCGAL_SRCHNEW_INS_SEL","選択したファイルの追加");
define("_AM_D3XCGAL_SRCHNEW_NO_PIC","新しいファイルは見つかりませんでした。");
define("_AM_D3XCGAL_SRCHNEW_PATIENT","暫くお待ちください。");
define("_AM_D3XCGAL_SRCHNEW_NOTES","<ul><li><b>OK</b> : 正常にファイルが追加されました。<li><b>DP</b> : ファイルが重複して既にデータベースに登録されています。<li><b>PB</b> : ファイルを追加できませんでした、設定およびファイルが登録されるディレクトリのパーミッションを確認してください。<li><b>NA</b> : ファイルを追加するアルバムが選択されていません。<li>OK、DP、PBサインのいずれも表示されなかった場合は、PHPエラーを表示するために破損した写真をクリックしてください。<li>タイムアウトが発生した場合、ブラウザの更新ボタンをクリックしてください。</ul>");


// ------------------------------------------------------------------------- //
// File groupmgr.php
// ------------------------------------------------------------------------- //

define("_AM_D3XCGAL_GRPMGR_KB","KB");
define("_AM_D3XCGAL_GRPMGR_NAME","グループ名");
define("_AM_D3XCGAL_GRPMGR_QUOTA","ディスク割り当て");
define("_AM_D3XCGAL_GRPMGR_RATE","写真を評価可能");
define("_AM_D3XCGAL_GRPMGR_SENDCARD","eカードを送信可能");
define("_AM_D3XCGAL_GRPMGR_COM","コメントを記入することができます");
define("_AM_D3XCGAL_GRPMGR_UPLOAD","写真をアップロード可能");
define("_AM_D3XCGAL_GRPMGR_PRIVATE","パーソナルギャラリー作成可能");
define("_AM_D3XCGAL_GRPMGR_APPLY","適用");
define("_AM_D3XCGAL_GRPMGR_MANAGE","ユーザ・グループを管理してください");
define("_AM_D3XCGAL_GRPMGR_PUB_APPR","パブリックアップロード承認 (1)");
define("_AM_D3XCGAL_GRPMGR_PRIV_APPR","プライベートアップロード承認 (2)");
define("_AM_D3XCGAL_GRPMGR_PUB_NOTE","<b>(1)</b> パブリックアルバムへアップロードされた写真は管理者の承認が必要です。");
define("_AM_D3XCGAL_GRPMGR_PRIV_NOTE","<b>(2)</b> ユーザのアルバムへアップロードされた写真は管理者の承認が必要です。");
define("_AM_D3XCGAL_GRPMGR_NOTES","注意");
define("_AM_D3XCGAL_GRPMGR_SYN","同期");
define("_AM_D3XCGAL_GRPMGR_SYN_NOTE","xcGalleryグループとXoopsグループを同期させるには「同期」をクリックしてください。");
define("_AM_D3XCGAL_GRPMGR_EMPTY","グループテーブルが空です!<br /><br />デフォルトグループが作成されました。");
// ------------------------------------------------------------------------- //
// File catmgr.php
// ------------------------------------------------------------------------- //

define("_AM_D3XCGAL_CAT_MISS_PARAM","'%s'の操作に必要なパラメータが渡されていません !");
define("_AM_D3XCGAL_CAT_UNKOWN","選択したカテゴリはデータベースに存在しません。");
define("_AM_D3XCGAL_CAT_UGAL_CAT_RO","ユーザギャラリーのカテゴリーは削除出来ません !");
define("_AM_D3XCGAL_CAT_MNGCAT","カテゴリの管理");
define("_AM_D3XCGAL_CAT_CONF_DEL","本当にこのカテゴリを削除しても宜しいですか ?");
define("_AM_D3XCGAL_CAT_CAT","カテゴリー");
define("_AM_D3XCGAL_CAT_OP","操作");
define("_AM_D3XCGAL_CAT_MOVE","移動先");
define("_AM_D3XCGAL_CAT_UPCR","カテゴリの作成/更新");
define("_AM_D3XCGAL_CAT_PARENT","親カテゴリ");
define("_AM_D3XCGAL_CAT_TITLE","カテゴリ名");
define("_AM_D3XCGAL_CAT_DESC","カテゴリ説明");
define("_AM_D3XCGAL_CAT_NOCAT","* カテゴリがありません *");

// ------------------------------------------------------------------------- //
// File ecardmgr.php
// ------------------------------------------------------------------------- //

define("_AM_D3XCGAL_CARDMGR_TITLE","xcGallery eカード管理");
define("_AM_D3XCGAL_CARDMGR_TIME","日付");
define("_AM_D3XCGAL_CARDMGR_SUNAME","送信ユーザー名");
define("_AM_D3XCGAL_CARDMGR_SEMAIL","送信電子メールアドレス");
define("_AM_D3XCGAL_CARDMGR_SIP","送信者IP");
define("_AM_D3XCGAL_CARDMGR_PID","写真 ID");
define("_AM_D3XCGAL_CARDMGR_STATUS","Picked");
define("_AM_D3XCGAL_CARDMGR_DEL_SELECTED","選択されたeカードを削除する");
define("_AM_D3XCGAL_CARDMGR_DEL_ALL","eカードすべてを削除する");
define("_AM_D3XCGAL_CARDMGR_DEL_PICKED","取得したeカードをすべて削除してください");
define("_AM_D3XCGAL_CARDMGR_DEL_UNPICKED","選別されていないeカードをすべて削除する");
define("_AM_D3XCGAL_CARDMGR_CONPAGE","%d eカード on %d ページ(s)");

?>