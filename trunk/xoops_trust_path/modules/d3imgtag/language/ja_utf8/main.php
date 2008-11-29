<?php
//%%%%%%		Module Name 'IMGTag D3'		%%%%%

// New in IMGTag D3

// only "Y/m/d" , "d M Y" , "M d Y" can be interpreted
define( "_MD_D3IMGTAG_DTFMT_YMDHI" , "Y/m/d H:i" ) ;

define( "_MD_D3IMGTAG_NEXT_BUTTON" , "次へ" ) ;
define( "_MD_D3IMGTAG_REDOLOOPDONE" , "終了" ) ;

define( "_MD_D3IMGTAG_BTN_SELECTALL" , "全選択" ) ;
define( "_MD_D3IMGTAG_BTN_SELECTNONE" , "選択解除" ) ;
define( "_MD_D3IMGTAG_BTN_SELECTRVS" , "選択反転" ) ;

define( "_MD_D3IMGTAG_FMT_PHOTONUM" , "%s 枚" ) ;

define( "_MD_D3IMGTAG_AM_ADMISSION" , "画像の承認" ) ;
define( "_MD_D3IMGTAG_AM_ADMITTING" , "画像を承認しました" ) ;
define( "_MD_D3IMGTAG_AM_LABEL_ADMIT" , "チェックした画像を承認する" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_ADMIT" , "承認" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_EXTRACT" , "抽出" ) ;

define( "_MD_D3IMGTAG_AM_PHOTOMANAGER" , "画像の管理" ) ;
define( "_MD_D3IMGTAG_AM_PHOTONAVINFO" , "%s 番～ %s 番を表示 (全 %s 枚)" ) ;
define( "_MD_D3IMGTAG_AM_LABEL_REMOVE" , "チェックした画像を削除する" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_REMOVE" , "削除" ) ;
define( "_MD_D3IMGTAG_AM_JS_REMOVECONFIRM" , "削除してよろしいですか" ) ;
define( "_MD_D3IMGTAG_AM_LABEL_MOVE" , "チェックした画像を移動する" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_MOVE" , "移動" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_UPDATE" , "変更" ) ;
define( "_MD_D3IMGTAG_AM_DEADLINKMAINPHOTO" , "メイン画像が存在しません" ) ;

define( "_MD_D3IMGTAG_RADIO_ROTATETITLE" , "画像回転" ) ;
define( "_MD_D3IMGTAG_RADIO_ROTATE0" , "回転しない" ) ;
define( "_MD_D3IMGTAG_RADIO_ROTATE90" , "右に90度回転" ) ;
define( "_MD_D3IMGTAG_RADIO_ROTATE180" , "180度回転" ) ;
define( "_MD_D3IMGTAG_RADIO_ROTATE270" , "左に90度回転" ) ;


// New IMGTag 1.0.1 (and 1.2.0)
define("_MD_D3IMGTAG_MOREPHOTOS","%s さんの画像をもっと!");
define("_MD_D3IMGTAG_REDOTHUMBS","サムネイルの再構築(<a href='redothumbs.php'>再スタート</a>)");
define("_MD_D3IMGTAG_REDOTHUMBS2","サムネイルの再構築");
define("_MD_D3IMGTAG_REDOTHUMBSINFO","大きな数値を入力するとサーバータイムアウトの原因になります。");
define("_MD_D3IMGTAG_REDOTHUMBSNUMBER","一度に処理するサムネイルの数");
define("_MD_D3IMGTAG_REDOING","再構築しました: ");
define("_MD_D3IMGTAG_BACK","戻る");
define("_MD_D3IMGTAG_ADDPHOTO","画像を追加");


// New IMGTag 1.0.0
define("_MD_D3IMGTAG_PHOTOBATCHUPLOAD","サーバにアップロード済ファイルの一括登録");
define("_MD_D3IMGTAG_PHOTOUPLOAD","画像アップロード");
define("_MD_D3IMGTAG_PHOTOEDITUPLOAD","画像の編集・再アップロード");
define("_MD_D3IMGTAG_MAXPIXEL","サイズ上限");
define("_MD_D3IMGTAG_MAXSIZE","サイズ上限(byte)");
define("_MD_D3IMGTAG_PHOTOTITLE","タイトル");
define("_MD_D3IMGTAG_PHOTOPATH","Path:");
define("_MD_D3IMGTAG_TEXT_DIRECTORY","ディレクトリ");
define("_MD_D3IMGTAG_DESC_PHOTOPATH","画像の含まれるディレクトリを絶対パスで指定して下さい");
define("_MD_D3IMGTAG_MES_INVALIDDIRECTORY","指定されたディレクトリから画像を読み出せません");
define("_MD_D3IMGTAG_MES_BATCHDONE","%s 枚の画像を登録しました");
define("_MD_D3IMGTAG_MES_BATCHNONE","指定されたディレクトリに画像ファイルがみつかりませんでした");
define("_MD_D3IMGTAG_PHOTODESC","説明");
define("_MD_D3IMGTAG_PHOTOCAT","カテゴリ");
define("_MD_D3IMGTAG_SELECTFILE","画像選択");
define("_MD_D3IMGTAG_NOIMAGESPECIFIED","画像未選択：アップロードすべき画像ファイルを選択して下さい。");
define("_MD_D3IMGTAG_FILEERROR","画像アップロードに失敗：画像ファイルが見つからないか容量制限を越えてます。");
define("_MD_D3IMGTAG_FILEREADERROR","画像読込失敗：なんらかの理由でアップロードされた画像ファイルを読み出せません。");

define("_MD_D3IMGTAG_BATCHBLANK","タイトル部を空欄にした場合、ファイル名をタイトルとします");
define("_MD_D3IMGTAG_DELETEPHOTO","削除?");
define("_MD_D3IMGTAG_VALIDPHOTO","承認");
define("_MD_D3IMGTAG_PHOTODEL","画像削除?");
define("_MD_D3IMGTAG_DELETINGPHOTO","削除しました");
define("_MD_D3IMGTAG_MOVINGPHOTO","移動しました");

define("_MD_D3IMGTAG_STORETIMESTAMP","日時を変更しない");

define("_MD_D3IMGTAG_POSTERC","投稿: ");
define("_MD_D3IMGTAG_DATEC","日時: ");
define("_MD_D3IMGTAG_EDITNOTALLOWED","コメントを編集する権限がありません！");
define("_MD_D3IMGTAG_ANONNOTALLOWED","匿名ユーザは投稿できません。");
define("_MD_D3IMGTAG_THANKSFORPOST","ご投稿有り難うございます。");
define("_MD_D3IMGTAG_DELNOTALLOWED","コメントを削除する権限がありません!");
define("_MD_D3IMGTAG_GOBACK","戻る");
define("_MD_D3IMGTAG_AREYOUSURE","このコメントとその下部コメントを削除：よろしいですか？");
define("_MD_D3IMGTAG_COMMENTSDEL","コメント削除完了！");

// End New

define("_MD_D3IMGTAG_THANKSFORINFO","ご投稿頂いた画像の公開はできるだけ早く検討します。");
define("_MD_D3IMGTAG_BACKTOTOP","最初の画像へ戻る");
define("_MD_D3IMGTAG_THANKSFORHELP","ご協力有難うございます。");
define("_MD_D3IMGTAG_FORSECURITY","セキュリティの観点からあなたのIPアドレスを一時的に保存します。");

define("_MD_D3IMGTAG_MATCH","合致");
define("_MD_D3IMGTAG_ALL","全て");
define("_MD_D3IMGTAG_ANY","どれでも");
define("_MD_D3IMGTAG_NAME","名前");
define("_MD_D3IMGTAG_DESCRIPTION","説明");

define("_MD_D3IMGTAG_MAIN","アルバムトップ");
define("_MD_D3IMGTAG_NEW","新着");
define("_MD_D3IMGTAG_UPDATED","更新");
define("_MD_D3IMGTAG_POPULAR","高ヒット");
define("_MD_D3IMGTAG_TOPRATED","高評価");

define("_MD_D3IMGTAG_POPULARITYLTOM","ヒット数 (低→高)");
define("_MD_D3IMGTAG_POPULARITYMTOL","ヒット数 (高→低)");
define("_MD_D3IMGTAG_TITLEATOZ","タイトル (A → Z)");
define("_MD_D3IMGTAG_TITLEZTOA","タイトル (Z → A)");
define("_MD_D3IMGTAG_DATEOLD","日時 (旧→新)");
define("_MD_D3IMGTAG_DATENEW","日時 (新→旧)");
define("_MD_D3IMGTAG_RATINGLTOH","評価 (低→高)");
define("_MD_D3IMGTAG_RATINGHTOL","評価 (高→低)");
define("_MD_D3IMGTAG_LIDASC","レコード番号昇順");
define("_MD_D3IMGTAG_LIDDESC","レコード番号降順");

define("_MD_D3IMGTAG_NOSHOTS","サムネイルなし");
define("_MD_D3IMGTAG_EDITTHISPHOTO","この画像を編集");

define("_MD_D3IMGTAG_DESCRIPTIONC","説明");
define("_MD_D3IMGTAG_EMAILC","Email");
define("_MD_D3IMGTAG_CATEGORYC","カテゴリ");
define("_MD_D3IMGTAG_SUBCATEGORY","サブカテゴリ");
define("_MD_D3IMGTAG_LASTUPDATEC","前回更新");
define("_MD_D3IMGTAG_TELLAFRIEND","友人に知らせる");
define("_MD_D3IMGTAG_SUBJECT4TAF","面白い写真を見つけました");
define("_MD_D3IMGTAG_HITSC","ヒット数");
define("_MD_D3IMGTAG_RATINGC","評価");
define("_MD_D3IMGTAG_ONEVOTE","投票数 1");
define("_MD_D3IMGTAG_NUMVOTES","投票数 %s");
define("_MD_D3IMGTAG_ONEPOST","コメント数");
define("_MD_D3IMGTAG_NUMPOSTS","コメント数 %s");
define("_MD_D3IMGTAG_COMMENTSC","コメント数");
define("_MD_D3IMGTAG_RATETHISPHOTO","投票する");
define("_MD_D3IMGTAG_MODIFY","変更");
define("_MD_D3IMGTAG_VSCOMMENTS","コメントを見る/送る");
define("_MD_D3IMGTAG_FILESIZE", "ファイルサイズ");
define("_MD_D3IMGTAG_FILERES", "解像度");

define("_MD_D3IMGTAG_DIRECTCATSEL","カテゴリ選択");
define("_MD_D3IMGTAG_THEREARE","データベースにある画像は <b>%s</b> 枚です");
define("_MD_D3IMGTAG_LATESTLIST","最新リスト");

define("_MD_D3IMGTAG_VOTEAPPRE","投票を受け付けました");
define("_MD_D3IMGTAG_THANKURATE","当サイト %s へのご投票、ありがとうございました");
define("_MD_D3IMGTAG_VOTEONCE","同一画像への投票は一度だけにお願いします。");
define("_MD_D3IMGTAG_RATINGSCALE","評価は 1 から 10 までです： 1 が最低、 10 が最高");
define("_MD_D3IMGTAG_BEOBJECTIVE","客観的な評価をお願いします。点数が1か10のみだと順位付けの意味がありません");
define("_MD_D3IMGTAG_DONOTVOTE","自分が登録した画像は投票できません。");
define("_MD_D3IMGTAG_RATEIT","投票する!");

define("_MD_D3IMGTAG_RECEIVED","画像を登録しました。ご投稿有難うございます。");
define("_MD_D3IMGTAG_ALLPENDING","すべての投稿画像は確認のため仮登録となります。");

define("_MD_D3IMGTAG_RANK","ランク");
define("_MD_D3IMGTAG_CATEGORY","カテゴリ");
define("_MD_D3IMGTAG_HITS","ヒット");
define("_MD_D3IMGTAG_RATING","評価");
define("_MD_D3IMGTAG_VOTE","投票");
define("_MD_D3IMGTAG_TOP10","%s のトップ10"); // %s はカテゴリのタイトル

define("_MD_D3IMGTAG_SORTBY","並び替え:");
define("_MD_D3IMGTAG_TITLE","タイトル");
define("_MD_D3IMGTAG_DATE","日時");
define("_MD_D3IMGTAG_POPULARITY","ヒット数");
define("_MD_D3IMGTAG_CURSORTEDBY","現在の並び順: %s");
define("_MD_D3IMGTAG_FOUNDIN","見つかったのはここ:");
define("_MD_D3IMGTAG_PREVIOUS","前");
define("_MD_D3IMGTAG_NEXT","次");
define("_MD_D3IMGTAG_NOMATCH","画像がありません");

define("_MD_D3IMGTAG_CATEGORIES","カテゴリ");

define("_MD_D3IMGTAG_SUBMIT","投稿");
define("_MD_D3IMGTAG_CANCEL","キャンセル");

define("_MD_D3IMGTAG_MUSTREGFIRST","申し訳ありませんがアクセス権限がありません。<br>登録するか、ログイン後にお願いします。");
define("_MD_D3IMGTAG_MUSTADDCATFIRST","追加するためにはカテゴリが必要です。<br>まずカテゴリを作成して下さい。");
define("_MD_D3IMGTAG_NORATING","評価が選択されてません。");
define("_MD_D3IMGTAG_CANTVOTEOWN","自分の投稿画像には投票できません。<br>投票には全て目を通します");
define("_MD_D3IMGTAG_VOTEONCE2","選択画像への投票は一度だけにお願いします。<br>投票にはすべて目を通します。");

//%%%%%%	Module Name 'IMGTag' (Admin)	  %%%%%

define("_MD_D3IMGTAG_PHOTOSWAITING","投稿された画像の承認: 承認待画像数");
define("_MD_D3IMGTAG_PHOTOMANAGER","画像管理");
define("_MD_D3IMGTAG_CATEDIT","カテゴリの追加・編集");
define("_MD_D3IMGTAG_GROUPPERM_GLOBAL","各グループの権限");
define("_MD_D3IMGTAG_CHECKCONFIGS","モジュールの状態チェック");
define("_MD_D3IMGTAG_BATCHUPLOAD","画像一括登録");
define("_MD_D3IMGTAG_GENERALSET","一般設定");

define("_MD_D3IMGTAG_SUBMITTER","投稿者");
define("_MD_D3IMGTAG_DELETE","削除");
define("_MD_D3IMGTAG_NOSUBMITTED","新規の投稿画像はありません。");
define("_MD_D3IMGTAG_ADDMAIN","トップカテゴリを追加");
define("_MD_D3IMGTAG_IMGURL","画像のURL (画像の高さはあらかじめ50pixelに): ");
define("_MD_D3IMGTAG_ADD","追加");
define("_MD_D3IMGTAG_ADDSUB","サブカテゴリの追加");
define("_MD_D3IMGTAG_IN","");
define("_MD_D3IMGTAG_MODCAT","カテゴリ変更");
define("_MD_D3IMGTAG_DBUPDATED","データベース更新に成功!");
define("_MD_D3IMGTAG_MODREQDELETED","変更要請を削除");
define("_MD_D3IMGTAG_IMGURLMAIN","画像URL (画像の高さはあらかじめ50pixelに): ");
define("_MD_D3IMGTAG_PARENT","親カテゴリ:");
define("_MD_D3IMGTAG_SAVE","変更を保存");
define("_MD_D3IMGTAG_CATDELETED","カテゴリの消去完了");
define("_MD_D3IMGTAG_CATDEL_WARNING","カテゴリと同時にここに含まれる画像およびコメントが全て削除されますがよろしいですか？");
define("_MD_D3IMGTAG_YES","はい");
define("_MD_D3IMGTAG_NO","いいえ");
define("_MD_D3IMGTAG_NEWCATADDED","新カテゴリ追加に成功!");
define("_MD_D3IMGTAG_ERROREXIST","エラー: 提供される画像はすでにデータベースに存在します。");
define("_MD_D3IMGTAG_ERRORTITLE","エラー: タイトルが必要です!");
define("_MD_D3IMGTAG_ERRORDESC","エラー: 説明が必要です!");
define("_MD_D3IMGTAG_WEAPPROVED","画像データベースへのリンク要請を承認しました。");
define("_MD_D3IMGTAG_THANKSSUBMIT","ご投稿有り難うございます。");
define("_MD_D3IMGTAG_CONFUPDATED","設定を更新しました。");

define("_MD_D3IMGTAG_LANGINFO", "画像情報");
define("_MD_D3IMGTAG_SHAREIMG", "共有画像");
define("_MD_D3IMGTAG_SHAREIMGDESC", " この画像を共有する");
define("_MD_D3IMGTAG_SHAREDIRECT", "直リンク");
define("_MD_D3IMGTAG_SHAREHTML", "HTML IMG コード");
define("_MD_D3IMGTAG_SHAREHTMLLINK", "HTML Link コード");

define("_MD_D3IMGTAG_TEXT_SMNAME4", "自分の投稿");


?>