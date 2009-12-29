COUPONS モジュール　[color=cc0000][b]テスト版[/b][/color]
XOOPS2 または XOOPS Cube Legacy で動作するモジュールです


//--------------------------------------
[b]特徴[/b]
- D3 モジュール
- altsys 必須
- /class/smarty/plugins/function.xoopsdhtmltarea.php必須（d3forum付属しているもの、配布アーカイブに同梱してあります）

- プラグイン
-- search
-- sitemap
-- whatsnew
-- d3pipes
-- xmobile
-- pical(daily/monthly)

- d3forum コメント統合
-- /class/smarty/plugins/
--- function.d3forum_comment.php（d3forum）
--- function.d3forum_comment_postscount.php（d3forum）
-- 利用するためには一般設定で設定し、テンプレートのコメントアウトを削除してください
--- coupons_coupon.html, coupons_single.html

- RSS 2.0

- クーポン統合（他モジュールへの埋込機能）
-- /class/smarty/plugins/function.coupons.php （利用する場合アップロード）
-- クーポン表示の記述
--- <{coupons cp_dir=coupons embed_dir=shop item_field=lid item_id=$link.id mode=display}>
-- 入力フォームを出す記述
--- <{coupons cp_dir=coupons embed_dir=shop item_field=lid item_id=$link.id mode=form}>
---- cp_dir : クーポンモジュールのルート側のディレクトリ名
---- embed_dir : クーポンを埋め込む側のモジュールのディレクトリ名
---- item_field : 埋め込んだ側のアイテム・記事などの識別するための項目
---- item_id : 埋め込んだ側のアイテム・記事などの識別するための項目についた番号
---- mode : display / form

- カテゴリー別にプリントアウト＆モバイルのデザインを若干変更できる
-- やりかたは別記します。

- モバイルについて
-- モジュール単独でクーポンを表示します。
-- xmobile を利用した場合はリスト表示を行ないます。
-- [d]/common/qrcode/ ライブラリがあるとQRコードを表示します（同梱してあります）。[/d]

- english の言語ファイルはウェブ翻訳
　
[pagebreak]
　
//--------------------------------------
[b]TODO[/b]
- wizMobile 用のテンプレートを用意しモバイルからの登録も可能にする予定

//--------------------------------------
[b]リリース履歴[/b]
2008.9.4 v0.29
- Google Chart API を利用する QR コードの生成に変更
-- 同梱していた QR コードライブラリをはずしました。
-- http://code.google.com/apis/chart/#qrcodes
- QR コード生成する URI が間違っていたのを修正(0.29a)[2008.9.9](Thanks wakaさん)
- クーポン統合で Google Chart API で QRコードが生成されていなかった不具合修正(0.29b)[2008.9.9]
- 検索でエラーが発生していたのを修正（0.29c）(Thanks flannelさん)[2009.7.28]
- Wizmobile, 携帯対応レンダラーで携帯判定された場合、{$is_mobile} に TRUE を割り当てるようにしました（0.29c）

2008.3.25 v0.28
- First Release(0.282)
- ja_utf8 の言語ファイルを用意しました(0.283)
- xmobileプラグインの不具合修正(0.284)[2008.3.28]
- ブロックのオプション不具合修正(0.28e)[2008.4.6]
- include/functions.php 若干修正(0.28f)[2008.4.14]
- xmobile の単独表示ページからクーポンの単独ページへリダイレクト(0.28g)[2008.5.30]
-- {xoops_trust_path}/modules/coupons/class/XmobilePlugin.class.php
