
This file is written by Shift-JIS.


Cinemaru Xoops Module


■概要

Cinemaru は動画/MP3を再生・管理を行う Xoops モジュールです。
再生中にコメントを付けることができます。

Cinemaru は「しねまる」と読みます。

以下のような機能があります。
・動画／MP3ファイルのアップロード、再生
・動画／MP3のURLまたは YouTube の動画のURLを指定して投稿
・再生中にコメントを付けれる
・任意のFLASH（SWFファイル）を動画再生中に表示できる
・タグ付け及びタグ固定
・違反報告機能
・動画承認機能


このモジュールを使って不正アップロードを行わないでください。


※現在はアルファバージョンであり、今後互換性のない変更が入る可能性があります。
また、十分テストされていませんので自己責任で利用してください。


■ライセンス

ライセンスは GPL Version 2 です。
詳しくは COPYING を参照してください。

Flashの動画プレイヤーのソースも添付されています。
( flash/player.mxml 及び flash/CommentLabel.as )


■インストール

Xoops の modules/ ディレクトリ以下に cinemaru をコピーします。
管理画面、モジュール管理から cinemaru モジュールをインストールしてください。
以上です。

とくにパーミッションを変更したりなどは必要ありません。
動画ファイル、MP3ファイル、サムネイル画像は XOOPS_ROOT_PATH/uploads/cinemaru/ 
以下に作られます。

また、ディレクトリ名を変更してインストールできます。複数インストール可能です。


■設定

サーバ側：
Webサーバでファイルアップロードの上限が 2MB に設定されている場合が多いです。
管理画面の「アップロード上限」の設定は表示のみで、そこを変更しただけでは有効になりません。

.htaccess の設定が有効な場合、.htaccess の設定のみでアップロード上限を変更でき
る場合があります。
より大きなファイルをアップロードしたい場合は、dot.htaccess を .htaccess に
書き換えて cinemaru/ 以下においてください。

管理画面、グループの全体的な権限から権限設定を行ってください。
デフォルトではモジュール管理者以外はなにもできない状態となっています。


■使用方法

Flash Video(FLV) 及びMP3ファイルを投稿画面からアップロードします。
もしくはもしくはURLを入力します。
サムネイル画像を設定できます。サイムネイル画像はリスト表示時に利用されます。
MP3ファイル再生時にはプレイヤー壁紙として使われます。

URL では YouTube の動画を指定できます。
YouTubeの場合は http://???.youtube.com/watch?v=xxxxxxxxxxx の形式で指定してく
ださい。
YouTube側の仕様に依存するのでYouTube側の仕様変更で使えなくなる可能性があります。

一般設定で「動画中のコメントにアバターをつける」が有効になっている場合、
XOOPSのユーザアバターをコメントの先頭につけて表示します。

スペシャルコマンドがあります。
デフォルト設定では「cmd:star」、「cmd:star2」、「cmd:star3」が使えます。
これをプレイヤーコメント欄に入力すると対応するFLASH（SWF）が表示されます。
コマンド名、FLASHとも管理画面の一般設定より変更できます。
ただしドメインをまたいでのファイルの読み込みにはFLASH制限が入りますので
ご注意ください。
必要に応じて crossdomain.xml の設定を行ってください。
詳しくは「crossdomain.xml」で検索してみてください。

動画/MP3にタグを付けることができます。タグは複数設定可能です。


■データ形式について

Flash Video(FLV) 及びMP3ファイルに対応します。
画像は PNG、JPG、GIF のみ対応します。


■FAQ

Q.トップページ右下の「Powered by Cinemaru Project」は削除していいですか？

A.もちろん削除してかまいません。

Q.YouTube のリンクが再生されません。

A.php.iniで「allow_url_fopen = On」とする必要があるかもしれません。
  Webサーバの設定次第ですが
  .htaccess で「php_value allow_url_fopen = On」と記述して有効にできるかも
  しれません。

Q.サイズが大きいファイルでアップロードエラーになりました。

A.Webサーバの設定次第ですが
  dot.htaccess ファイルを .htaccess に名前変更することでアップロードの
  上限サイズを変更できる可能性があります。
  また、管理画面からcinemaruの「一般設定」→「動画の最大ファイルサイズ」を
  大きい数字を設定してください。


■免責事項

このモジュールは無保証です。
このモジュールを使用して発生したいかなるトラブル、いかなる損害にもモジュール作
者は責任を負いません。


■開発環境・連絡先

sourceforege.jp に間借りして開発しています。

プロジェクトページ
http://cinemaru.net/

バグ報告、パッチ送付、諸連絡、ネタ提供など、こちらにどうぞ。

最新版のダウンロードはこちらから
http://sourceforge.jp/projects/cinemaru/


■著作権表示

プログラム
時田正彦 BQB04357@nifty.ne.jp

動画プレイヤーデザイン修正
Yujiro Takahashi <yujiro@rakuto.net> http://rakuto.net/

動画プレイヤーアイコン Silk icon set 1.3
Mark James http://www.famfamfam.com/lab/icons/silk/
  同アイコンはクリエイティブコモンズ 2.5 に基づいて配布されています。
  Creative Commons Attribution 2.5 License.
  [ http://creativecommons.org/licenses/by/2.5/ ]

