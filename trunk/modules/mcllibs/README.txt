【機能】
セッションのみを扱える小型のベースモジュのはずが、ごちゃごちゃ色んな機能が増えました。

インストールすることで、以下の機能が使えます。
Legacy_TextFilterがMCL_TextFilterに置き換えられます。
デリゲート「MCLLIBS.ModuleHeader」が利用出来る様になります。
ディレクトリlibs内の各クラスをファイルを読み込むことなく（自動で読み込み）利用出来ます。
対応したモジュールをフロントコントローラーで動作させることが出来ます。（このモジュールのメインメニューではリンクをフロントコントローラーに変更します）

管理画面での権限管理が気持ち楽になります。
管理画面の各モジュールの管理ブロックに権限管理とブロック管理が追加されます。
MCL Librarysの管理画面ではグループ毎による各モジュール、各ブロックの権限設定が一括で設定出来ます。
管理画面でインストールされているMarijuana製モジュールのバージョンアップの確認が出来ます。
（まだ全てのMarijuana製モジュールが対応している訳ではありません）
管理画面のモジュール管理では、モジュールのダイレクトアンインストール（非アクティブにする必要ありません）や、モジュールの再インストール機能があります。


ブラウザの言語に合わせて言語設定を変える事が出来ます。
ただし、登録時のメールなどサイトタイトルが日本語の場合は日本語のままです。
メインメニューなどのブロックはlegacyで持っているブロックからこのモジュールのブロックへ変えることでブロックタイトルを各言語に合わせて表示させることが出来ます。

テーマレンダーでは、テーマディレクトリのテンプレートを読み込み利用することが出来ます。
テーマ毎にブロックやモジュールのテンプレートを切り変える事が可能になります。
読み込みの順番は、テーマディレクトリ→モジュールディレクトリ→DBの順番にテンプレートを探します。
プリロード内で携帯判定と携帯用テーマを利用することで携帯電話へもある程度対応可能です。
＊XCLDBに入っているthemeRenderと違い文字コードの変換は行っていません。
テーマレンダーはデフォルトでオフになっているので、有効にする場合は
mcllibs/preload/themeRender.class.phpを変更してください。

Smartyプラグインで、投稿されたコメントや投稿フォームをテンプレートへ追加出来ます。
XCLコアの持つコメントとは全く別で、モジュール側へは手を入れることなくコメント機能を追加出来ます。
＊0.40a2では、コメントの編集、削除、管理機能、XCodeの制御など一部の機能はありません。

【使い方】
mainfile.phpを読み込むだけで、セッションが使用可能です。
プリロード等は一切読み込みませんが、XCLのカスタムセッションに対応しています。
データベースはMCL_MySQL::getInstance();でインスタンスを取得出来ます。
Session_Controller.class.phpを使用するだけなら、モジュールをインストールする必要はありません。
基本的にpreloadを削除することで機能の無効化が可能です。
MCL_TextFilterを利用したくない場合は、mcllibs/preload/Textfilter.class.phpを削除してください。
バージョンアップ確認を行いたくない場合はmcllibs/admin/preload/Update.class.phpを削除してください。
マルチランゲージ機能を使用したくない場合はpreload/LangSelect.class.phpを削除してください。
メインメニューはデリゲートでリンクの追加が出来ます。


【注意】
PHP5用なのでPHP4では動作しません。
MCL_TextFilterは、デリゲートで置換パターンを取得しませんので、巷に出回っているプリロードは反映されません。
オートログインはクッキー値を毎回作り直しするので、１つのアカウントを複数のパソコンで利用する場合は対応していません。
0.40未満からのアップデートの場合はモジュールの再インストールをしてください。
マルチランゲージを利用する場合はLangSelect.class.phpをXOOPS_ROOT_PATH/preloadに移動してください。
インストールするとテーブルuserにフィールドloginkeyを追加します。


【WhereComp】【WhereTray】【WhereElement】
クライテリアのクラス


【TableObjectHandler】
複数のプライマリキーに対応したクラス


【MCL_PageNavi】
ページナビ用のクラス


【MCL_Mailer】
メール送信用クラス


【Smartyプラグイン】
mcllibs/smartyにファイルを置くことで自動で読み込まれます。


【captcha】
Smartyプラグインを利用し画像認証を手軽に追加出来ます。
投稿フォームに<{mcllibs_captcha auto=true}>を追加するだけです。
パラメータ
width:画像の横幅
height:画像の高さ
returl:エラー時にリダイレクとするURL
posturl:ポストされるURL
auto:Trueの場合にテキストボックスの描画
＊ひとつの画面で複数設置は出来ません。


【メインメニュー】
<?php
class Mcllibs_MainMenuAdd extends XCube_ActionFilter
{
  public function preBlockFilter()
  {
    $this->mRoot->mDelegateManager->add('MCLLIBS.MainMenu', 'Mcllibs_MainMenuAdd::getMenu');
  }
  
  public static function getMenu(&$menu)
  {
    $menu[1][] = array('name' => 'Marijuana', 'link' => 'http://marijuana.ddo.jp/', 'sublinks' => array(), 'target' => '_blank');
  }
}
?>
こんな感じでpreloadディレクトリに追加


【コメント】
<{mcllibs_commentform}>でコメントの投稿フォームが表示されます。
パラメータの説明
modid:モジュールID（省略時はアクセス中のモジュールID、取得出来なければ0）
itemid:アイテムID（uidとか）（省略時は0）
status: 0は非表示、1は表示、2は登録ユーザのみ表示（0にすればモデレート後表示可能）
xcode:XCodeの使用時は1（省略時は0）
returl:コメント投稿後の戻り先（省略時はXOOPS_URL）
rows:textareaのrows（省略時は6）
cols:textareaのcols（省略時は50）
それぞれのパラメータは必須ではありません。
＊モジュール毎に同じコメントを使用する場合はitemidを省略、アイテム毎に別ける場合はitemidにアイテムのキー
例）ユーザ情報にコメントをつける場合
<{mcllibs_commentform modid=ユーザモジュールのmid itemid=ユーザのuid}>

<{mcllibs_commentview}>で投稿されたコメントの一覧が表示されます。
パラメータの説明
modid:モジュールID（省略時はアクセス中のモジュールID、取得出来なければ0）
itemid:アイテムID（uidとか）（省略時は0）
例）上記例のユーザ情報のコメントを表示させる場合
<{mcllibs_commentview modid=ユーザモジュールのmid itemid=ユーザのuid}>


【ライセンス】
複数混在します。
ライセンス：とりあえずhttp://creativecommons.org/licenses/by-nc-sa/3.0/deed.jaで
管理画面テーマなど一部GPLの汚染を受けます。
greyboxはLGPL
lightbox2はクリエイティブコモンズ
videoboxはMIT
highslideはクリエイティブコモンズ
Text_WikiはLGPL


【外部ライブラリ】
Text_Wiki1.20
greybox
lightbox2
videobox
highslide


【更新履歴】
Ver0.40:フォームのポスト時にJSを利用するプラグイン追加（スパム対策）
        プリロードCaptcha.class.phpをPostcheck.class.phpに変更
        G,P,Cのリクエスト値の文字コードが_CHARSETと違う場合値を削除
        コメントの編集・削除機能追加
        管理画面へコメント管理追加
        複製用プリロード追加
        MCL_TextFilterにメソッドcutstr,strlen追加
        MCL_TextFilter::toShowにマルチランゲージフラグ追加
        クラスMCL_Object,MCL_CodeCompound追加
        プリロードでMCL_Utils.class.phpの読込み追加
Ver0.40a2:モジュール管理機能追加
        メインメニューのフロントコントローラ時のサブリンク修正
        コメント機能追加（まだ全部の機能は実装していません）
        クラスTableObjectHandlerの修正
Ver0.40a:マルチランゲージ機能追加
        MCL_Utilsの動作の変更＆バグ修正
        Marijuana作モジュールのアップデート通知機能追加
        メインメニューの修正及びデリゲートの追加
        MCL_TextFilterの読み込みようプリロード追加
        テーマレンダー機能追加
        emailログイン、オートログイン追加
Ver0.32:言語定数が読み込めていなかったのを修正
        管理画面テーマ変更後、元のアドレスに戻るように修正
        randimageの大文字拡張子対応
Ver0.31:greybox,lightbox2,videobox,highslideのSmartyプラグイン追加
        youtube,ユーザメッセージ,greybox,lightbox2,videoboxのBBCode追加
Ver0.30:mcladminの機能をマージ（ログインログ除く）
Ver0.23:captcha機能追加
Ver0.22:クラスMCL_Utils追加
        プリロードMcllibs_FrontController追加
Ver0.21:ヘッダーをデリゲートで追加出来る様にSmartyのフィルタ追加
Ver0.20:クラスMCL_PageNavigator、MCL_Mailerの追加
Ver0.10:クラスMCL_TextFilterの追加
Ver0.02:Session_Controllerのプロパティをpublicに変更
        Session_Controllerにプロパティ$mSessionを追加し、XCube_Sessionのインスタンスを保持
        mainfile.phpの読み込みを相対パスから絶対パスに変更
Ver0.01:プリロードで定数_MCL_LIBS_PATHを追加
        MCL_PageNavi.class.phpの追加
Ver0.00:リリース


【ToDo】
READMEの整理＆英訳
