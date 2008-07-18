<?php

// CSS EXPORT
define('_MD_DBCSS_H2INPORT','CSSインポート');
define('_MD_DBCSS_LABEL_INPORT','インポートするCSSファイルを選択');
define('_MD_DBCSS_LABEL_CSS_DIR','アップロード先ディレクトリ');
define('_MD_DBCSS_CSS_NODIR','※ アップロード先ディレクトリが見つかりません');
define('_MD_DBCSS_CSS_NOWRITABLE','※ アップロード先ディレクトリに書込属性を設定してください');
define('_MD_DBCSS_CSS_DIR_NONE','アップロード先ディレクトリが見つかりませんでした');
define('_MD_DBCSS_INPORTDESC','※ CSSファイルをDBテンプレートとして簡単にインポートすることができます。<br />※ アップロードしたCSSファイルは defaultテンプレートセットに保存されます。<br>※ また、default に加えて、任意のテンプレートセットを選択してインポートすることも可能です。<br />※ アップロード先ディレクトリに、書込を許可したうえで、お使いください。');
define('_MD_DBCSS_CSS_DIR_NOWRITABLE','アップロード先ディレクトリのパーミッションを確認してください');
define('_MD_DBCSS_INSERTTEMPLATEERROR','エラーが発生し、DBに保存できませんでした ファイル名: %s');
define('_MD_DBCSS_INPORTED','のインポートが完了しました');
define('_MD_DBCSS_UPLOADERROR','アップロードに失敗しました。拡張子');
define('_MD_DBCSS_UPLOADEXITERROR','のアップロードはできません');
define('_MD_DBCSS_UPLOADE_ERROR','アップロードに失敗しました');
define('_MD_DBCSS_UPLOADED','を更新しました');
define('_MD_DBCSS_H2EXPORT','CSSエクスポート');
define('_MD_DBCSS_TH_CSSNAME','テンプレート名');
define('_MD_DBCSS_TH_ORIGINALFILE','オリジナルファイル');
define('_MD_DBCSS_TH_TPLSETS','テンプレートセット');
define('_MD_DBCSS_LABEL_SELECTTPLSETS','テンプレートセット選択');
define('_MD_DBCSS_BTN_EXPORT','エクスポート');
define('_MD_DBCSS_CONFIRM_EXPORT','エクスポートしてよろしいですか?');
define('_MD_DBCSS_EXPORTTED','エクスポートが完了しました');
define('_MD_DBCSS_EXPORT_ERROR','エクスポートに失敗しました');
define('_MD_DBCSS_EXPORT_CHECK_NONE','エクスポートするテンプレートを指定してください');
define('_MD_DBCSS_EXPORT_DIR_NONE','エクスポート先ディレクトリが見つかりませんでした');
define('_MD_DBCSS_EXPORT_DIR_NONEWRITABLE','エクスポート先ディレクトリに書込属性を設定してください');
define('_MD_DBCSS_EXPORT_DIR','デフォルトのエクスポート先ディレクトリ');
define('_MD_DBCSS_EXPORTDESC','※ DBに保存されている CSSテンプレートを CSSファイルとしてエクスポートすることができます。<br />※ 「一般設定」でエクスポート先ディレクトリを指定し、書込を許可したうえで、お使いください。<br />※ テンプレート毎のエクスポート先ディレクトリを保存する場合は、一般設定と同様の形式で記入し、送信します。');
define('_MD_DBCSS_EXPORT_NODIR','※ エクスポート先ディレクトリが見つかりません');
define('_MD_DBCSS_EXPORT_NOWRITABLE','※ エクスポート先ディレクトリに書込属性を設定してください');
define('_MD_DBCSS_MYEXPORT_DIR','エクスポート先ディレクトリ');
define('_MD_DBCSS_LABEL_EXPORT_DIR','テンプレート毎のエクスポート先ディレクトリを保存');
define('_MD_DBCSS_BTN_COPYTPL','コピー実行');
define('_MD_DBCSS_LABEL_COPYTPLSETS','コピー先');
define('_MD_DBCSS_COPY_CHECK_NONE','コピーするテンプレートとコピー先のテンプレートセットを指定してください');
define('_MD_DBCSS_COPYED','コピーが完了しました');
define('_MD_DBCSS_COPYTEMPLATEERROR','コピーに失敗しました ID: %s');
define('_MD_DBCSS_COPYABORT','コピー元とコピー先が同一のため中断しました');
define('_MD_DBCSS_CONFIRM_COPY','コピーしてよろしいですか?');
define('_MD_DBCSS_LABEL_TPLRIGHTCHECKED','チェックしたテンプレートを:');
define('_MD_DBCSS_CONFIRM_DELETETPL','テンプレートを削除してよろしいですか?');
define('_MD_DBCSS_DELETE_CHECK_NONE','削除するテンプレートを指定してください');
define('_MD_DBCSS_H2DOWNLOAD','CSSダウンロード');
define('_MD_DBCSS_BTN_ZIPDOWNLOAD','zip');
define('_MD_DBCSS_BTN_TARDOWNLOAD','tar.gz');
define('_MD_DBCSS_LABEL_DOWNLOADTPLSETS','テンプレートセット毎のダウンロード');
define('_MD_DBCSS_DOWNLOADERROR','ダウンロードするテンプレートセットを選択してください');
define('_MD_DBCSS_MYTPLSFORM_EDIT','テンプレート編集');
define('_MD_DBCSS_MYTPLSFORM_BTN_MODIFYCONT','更新して編集継続');
define('_MD_DBCSS_MYTPLSFORM_BTN_MODIFYEND','更新して編集終了');
define('_MD_DBCSS_MYTPLSFORM_BTN_RESET','リセット');
define('_MD_DBCSS_MYTPLSFORM_UPDATED','テンプレートを更新しました');

// META tag management
define('_MD_DBCSS_H2METALINK','METAタグ管理');
define('_MD_DBCSS_TH_MID','MID');
define('_MD_DBCSS_TH_MODULE','モジュール');
define('_MD_DBCSS_TH_DIRNAME','ディレクトリ');
define('_MD_DBCSS_TH_EDIT','編集');
define('_MD_DBCSS_METAEDITDESC','※ 空欄にした項目は、一般設定で設定した値が適用されます。');
define('_MD_DBCSS_METAEDITBLOCKDESC','※ モジュール毎に、METAタグを編集・設定することができます。<br />※ ここで設定した項目は、「METAタグフックブロック」を設定したモジュールにのみ反映されます。');
define('_MD_DBCSS_METAEDITNOCACHE_DIR','※ XOOPS_TRUST_PATH/cache/ ディレクトリを作り、書込を許可したうえで、お使いください。');
define('_MD_DBCSS_METAKEY','METAキーワード');
define('_MD_DBCSS_METAKEYDESC','METAキーワードはあなたのサイトの内容を表すものです。キーワードはカンマで区切って記述してください。(例: XOOPS, PHP, mySQL, ポータル)');
define('_MD_DBCSS_METADESC','METAタグ(Description)');
define('_MD_DBCSS_METADESCDESC','METAタグ(Description) は、あなたのサイトの内容を説明する一般的なタグです。');
define('_MD_DBCSS_METAROBOTS','METAタグ(ROBOTS)');
define('_MD_DBCSS_METAROBOTSDESC','ロボット型検索エンジンへの対応');
define('_MD_DBCSS_METARATING','METAタグ(RATING)');
define('_MD_DBCSS_METARATINGDESC','閲覧対象年齢層の指定');
define('_MD_DBCSS_METAAUTHOR','METAタグ(作成者)');
define('_MD_DBCSS_METAAUTHORDESC','作成者METAタグは、サイト文書の作成者情報を定義します。名前、WebmasterのEMailアドレス、会社名、URLなどを記述します。');
define('_MD_DBCSS_METACACHE_TIME','ファイルキャッシュ作成日時');
define('_MD_DBCSS_METANOCACHE','ファイルキャッシュ未作成');
define('_MD_DBCSS_METAEDITTITLE','METAタグ編集');
define('_MD_DBCSS_BTN_SUBMITEDITING','保存');
define('_MD_DBCSS_BTN_CANSEL','戻る');
define('_MD_DBCSS_MSG_CONFIRMDELETECONTENT','登録内容を削除してよろしいですか?');
define('_MD_DBCSS_NO_DATA','保存するデータがありません');
define('_MD_DBCSS_MODULE_NOTFOUND','モジュールが見つかりません');
define('_MD_DBCSS_REGSTERED','保存しました');
define('_MD_DBCSS_DELETED','削除しました');
define('_MD_DBCSS_NONDELETED','削除するデータがありません');
define('_MD_DBCSS_LABEL_PERPAGE','1ページに表示するモジュール数:');

// SCRIPT tag management
define('_MD_DBCSS_H2SCRIPTLINK','外部スクリプトタグ編集');
define('_MD_DBCSS_NEW','新規作成');
define('_MD_DBCSS_TH_CONTENTSACTIONS','アクション');
define('_MD_DBCSS_TH_ID','ID');
define('_MD_DBCSS_TH_TITLE','タイトル');
define('_MD_DBCSS_TH_CREATED','作成日時');
define('_MD_DBCSS_LABEL_CONTENTSRIGHTCHECKED','チェックしたデータを:');
define('_MD_DBCSS_BTN_DELETE','削除');
define('_MD_DBCSS_BTN_COPY','別データとして保存');
define('_MD_DBCSS_SCRIPTEDITBLOCKDESC','※ theme.htmlのhead内に外部スクリプトに必要なタグを挿入することができます。<br />※ なお、セキュリティの問題もあり、ここで設定できるのは XOOPS URL 以下にあるスクリプトのみです。<br />※ ここで設定した項目は、「SCRIPTタグフックブロック」を設定したページにのみ反映されます。');
define('_MD_DBCSS_CONFIRM_DELETE','登録内容を削除してよろしいですか?');
define('_MD_DBCSS_MSG_CONFIRMCOPYCONTENT','登録内容を別データとして保存してよろしいですか?');
define('_MD_DBCSS_SCRIPTEDITTITLE','外部スクリプトタグ編集');
define('_MD_DBCSS_SCRIPTBODY','外部スクリプトのパス<br /><br />XOOPSのインストール先からのパスで指定します。複数の外部スクリプトがある場合は、改行し1行毎に記入してください。<br /><br />設定例 : javascript/exsample.js (最初の / は不要)');
define('_MD_DBCSS_SCRIPTCSS','外部スクリプトのcss<br /><br />外部スクリプトに必要なCSSをXOOPSのインストール先からのパスで指定します。(複数のCSSがある場合は、改行し1行毎に記入してください。)<br /><br />設定例:javascript/exsample.css (最初の / は不要)');
define('_MD_DBCSS_SCRIPTCACHE_TIME','ファイルキャッシュ作成日時');
define('_MD_DBCSS_SCRIPTNOCACHE','ファイルキャッシュ未作成');
define('_MD_DBCSS_SUBJECT','タイトルを入力してください');
define('_MD_DBCSS_BODY','外部スクリプトのパスを入力してください');

// ERROR MESSEAGE
define('_MD_DBCSS_ERROR_MESSEAGE','エラーが発生しました ID: %s');
define('_MD_DBCSS_ERROR_MESSEAGE_NOID','エラーが発生しました');

?>