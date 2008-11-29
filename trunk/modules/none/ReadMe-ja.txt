メインメニューに項目を増やすだけで、ほとんど何もしないモジュールです。

従来のNONEモジュールはEUC-JP固定でしたが、それに言語ファイル対応部分を加えました。
現在3つの言語ファイル（english, japanese, ja_utf8）があります。

メインのコンテンツを書き換える場合は、module/none/index.phpを編集してください。

メニューに表示される名前を変えるには、“インストールする前に”言語ファイルを編集します。
module/none/language/japanese/modinfo.phpもしくは
module/none/language/ja_utf8/modinfo.phpです。
適宜モジュールの名前と説明をを編集します。

変更前
///////////////////////////////////////////////////////////////////////////
// The name of this module
define('_MI_NONE_NAME', 'NONE モジュール');

// A brief description of this module
define('_MI_NONE_DESC', 'ほとんどなにもしないモジュールです。');
///////////////////////////////////////////////////////////////////////////
　↓
変更後
///////////////////////////////////////////////////////////////////////////
// The name of this module
define('_MI_NONE_NAME', '企業情報');

// A brief description of this module
define('_MI_NONE_DESC', '「企業情報」ページです。');
///////////////////////////////////////////////////////////////////////////

※設定どおりの文字コードで書いてください。
XOOPS Cube Legacy 2.1.xでは標準的にはEUC-JP、ホダ塾ディストリの標準はUTF-8です。


またモジュールの新規開発をする場合に、スケルトン・モジュール（モジュールの雛形）としても役立ちます。
依存関係の少なさと構成要素（ファイル数など）の少なさで、初学者には見通しがいいかもしれません。


■連絡先
いしだなおと
naoto@ryus.co.jp
naoto@isnot.jp
http://isnot.jp/
