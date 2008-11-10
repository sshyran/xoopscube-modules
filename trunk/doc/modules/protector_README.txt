[mlimg]
[xlang:en]
= SUMMARY =

Xoops Protector is a module to defend XOOPS2 from various and malicious attacks.

This module can protect a various kind of attacks like:

- DoS
- Bad Crawlers (like bots collecting e-mails...)
- SQL Injection
- XSS (not all though)
- System globals pollution
- Session hi-jacking
- Null-bytes
- Directory Traversal
- Some kind of CSRF (fatal in XOOPS <= 2.0.9.2)
- Brute Force
- Camouflaged Image File Uploading (== IE Content-Type XSS)
- Executable File Uploading Attack
- XMLRPC's eval() and SQL Injection Attacks
- SPAMs for comment, trackback etc.

Xoops Protector defends you XOOPS from these attacks, and it records into its log. 

Of course, all vulnerablities can't be prevented.
Be not overconfident, please.

However, I [color=ff0000][b]strongly[/b][/color] recommend installing this module to all XOOPS sites with any versions.



= INSTALL =

First, define XOOPS_TRUST_PATH into mainfile.php if you've never done it yet.

Copy html/modules/protector in the archive into your XOOPS_ROOT_PATH/modules/
Copy xoops_trust_path/modules/protector in the archive into your XOOPS_TRUST_PATH/modules/

Turn permission of XOOPS_TRUST_PATH/modules/protector/configs writable

After Xoops Protector is installed, edit your mainfile.php like this:
[code]
	[color=ff0000]include XOOPS_TRUST_PATH.'/modules/protector/include/precheck.inc.php' ;[/color]
	if (!isset($xoopsOption['nocommon']) [color=0000ff]&& XOOPS_ROOT_PATH != ''[/color] ) {
		include XOOPS_ROOT_PATH."/include/common.php";
	}
	[color=ff0000]include XOOPS_TRUST_PATH.'/modules/protector/include/postcheck.inc.php' ;[/color]
[/code]
Just add two red-colored lines.
If the blue-colored part is different from your mainfile.php, don't mind it.

Both pre-check and post-check are needed.

An option "DENY by .htaccess" is added on version 2.34.
If you try this option, set writable XOOPS_ROOT_PATH/.htaccess
Before installing this, you should compare it to the security risks which .htaccess is writable.


= How to rescue =

If you've been banned from Protector, just delete files under XOOPS_TRUST_PATH/modules/protector/configs/

The setting and controller of "rescue password" has been eliminated.


= How to install it into XOOPS Cube Legacy 2.1 =

Almost the same as installing into XOOPS 2.0.x.
There is just a different with the patching point in mainfile.php.
Refer this.
[code]
    if (!defined('_LEGACY_PREVENT_LOAD_CORE_') && XOOPS_ROOT_PATH != '') {
        include XOOPS_TRUST_PATH.'/modules/protector/include/precheck.inc.php' ;
        @include_once XOOPS_ROOT_PATH.'/include/cubecore_init.php';
        if (!isset($xoopsOption['nocommon']) && !defined('_LEGACY_PREVENT_EXEC_COMMON_')) {
            include XOOPS_ROOT_PATH.'/include/common.php';
        }
        include XOOPS_TRUST_PATH.'/modules/protector/include/postcheck.inc.php' ;
    }
[/code]


= UPGRADE from Protector 2.x =

- remove two lines for Protector from your mainfile.php
- remove all files under XOOPS_ROOT_PATH/modules/protector/ via FTP etc.
- upload files in the archive (refer INSTALL)
- do "upgrade" Protector in modulesadmin
- add two lines for Protector into your mainfile.php

Note: "XOOPS_TRUST_PATH" for 3.0 instead of "XOOPS_ROOT_PATH" for 2.x


= Using filter-plugin =

You can put a filter-plugin in XOOPS_TRUST_PATH/modules/protector/filters_enabled/

There are two plugins in this archive.

- postcommon_post_deny_by_rbl.php
an anti-SPAM plugin.
All of Post from IP registered in RBL will be rejected.
This plugin can slow the performance of Post, especially chat modules.

- postcommon_post_need_multibyte.php
an anti-SPAM plugin.
Post without multi-byte characters will be rejected.
This plugin is only for sites of japanese, tchinese, schinese, and korean.

If you want to turn the plugin on, copy the file in filters_disabled into filters_enabled.


= CONTRIBUTIONS =

Here is a good documentation for installing/running the latest Protector.
http://library.fishbreeder.net/xoopsdocs/protector-3-02.pdf (PDF)
http://library.fishbreeder.net/xoopsdocs/protector-3-02.odt (OpenDocument)
http://library.fishbreeder.net/xoopsdocs/protector-3-02.doc (Word)

I thank Madfish for this excellent work!


= CHANGES =

3.17 beta (2008/04/24)
- modified URLs with the same hostname as XOOPS_URL are not counted as URI SPAM
- update language files
-- persian (thx stranger and voltan) 3.17a
- added language files
-- de_utf8 (thx wuddel) 3.17a

3.16 beta (2008/01/08)
- added a filter postcommon_post_deny_by_httpbl for antispam by honeypotproject
- updated language files
-- polish (thx kurak_bu)

3.15 beta (2007/10/18)
- added "compact log"
- added "remove all log"
- added language files
-- fr_utf8 (thx gigamaster)

3.14 beta (2007/09/17)
- imported HTMLPurifier (special thx! Edward Z. Yang) PHP5 only
- added filtering point (spamcheck, crawler, f5attack, bruteforce, purge)
- added filter plugins
-- postcommon_post_htmlpurify4guest (guest's post will be purified) only PHP5
-- spamcheck_overrun_message
-- crawler_overrun_message
-- f5attack_overrun_message
-- bruteforce_overrun_message
-- prepurge_exit_message

3.13 beta (2007/08/22)
- modified the filter structure from function to class
- added filtering point (badip, register)
- added filter plugins
-- postcommon_register_insert_js_check (against registering SPAM)
-- precommon_badip_message (displays a message on rejecting the IP)
-- precommon_badip_redirection (redirects somewhere on rejecting the IP)

3.12 beta (2007/08/16)
- fixed for controllers with $xoopsOption['nocommon']=true

3.11 beta (2007/08/16)
- modified ordering precheck and postcheck
- removed a rbl server from postcommon_post_deny_by_rbl.php
- added language files
-- french (thx Christian)

3.10 beta (2007/07/30)
- modified precheck getting config via local cache
- modified precheck does not connect MySQL as possible
- fixed "reliable IP" does not work well
- modified mainfile patch can be inserted before protector installation
- added a logic to check some folder's permission on installing protector
- modified IP denying pattern. 'full', 'foward match', and 'preg match'
- added denied IP moratorium
- added a warning if the directory for configs is not writable

3.04 (2007/06/13)
- added a check against the phpmailer command-injection vulnerability.
- modified postcommon_post_need_multibyte (3.04a)

3.03 (2007/06/03)
- added a protection against installer attack
- changed language name
-- ja_utf8 (formerly japaneseutf) 3.03a

3.02 (2007/04/08)
- modified compatibility of the option "force_intval"
- fixed wrong link in advisory.php (thx genet)
- added a method module can skip DoS/crawler check (define a constant)
- updated D3 system
- added language files
-- persian (thx voltan)
-- russian (thx West) 3.02a
-- arabic (thx onasure) 3.02b
-- japaneseutf 3.02c

3.01 (2007/02/10)
- modified the rule for sorting IPs
- added language files
-- portuguesebr (thx beduino)
-- spanish (thx PepeMty)
-- polish (thx kurak_bu) 3.01a
-- german (thx wuddel) 3.01b
- modified module_icon.php 3.01c
- fixed typo in module_icon.php 3.01d

3.00 (2007/02/06)
- marked as a stable version
- fixed typo in log level
- fixed multibyte plugin never denies registered users (thx mizukami)
- modified compatibility with 2.2.x from xoops.org 3.00a

3.00beta2 (2007/01/31)
- added plugin system (just postcommon_post_*)
- added filtering-plugins
-- postcommon_post_deny_by_rbl.php (deny SPAM by RBL)
-- postcommon_post_need_multibyte.php (deny SPAM by character type)

3.00beta (2007/01/30)
- moved almost files under XOOPS_TRUST_PATH
- modified denying IP from DB to a file under configs
- removed rescue feature (just remove a file via FTP)
- added allowed IPs for user of group=1
- modified table structures (compatible MySQL5)
- added BigUmbrella anti-XSS system
- added anti-SPAM feature

= THANKS =
 - Kikuchi  (Traditional Chinese language files)
 - Marcelo Yuji Himoro (Brazilian Portuguese and Spanish language files)
 - HMN (French language files)
 - Defkon1 (Italian language files)
 - Dirk Louwers (Dutch language files)
 - Rene (German language files)
 - kokko (Finnish language files)
 - Tomasz (Polski language files)
 - Sergey (Russian language files)
 - Bezoops (Spanish language files)
These contributions was made for v2.x
I'm appreciated new language files for v3.0 :-)

Moreover, I thank to JM2 and minahito -zx team- about having taught me kindly.
You are very great programmers!


[/xlang:en][xlang:ja]

●要旨

Xoops Protector は、XOOPS2 を様々な悪意ある攻撃から守るためのモジュールです。

このモジュールでは、以下の攻撃を防ぎます。

- DoS
- 悪意あるクローラー（メール収集ボットなど）
- SQL Injection
- XSS （といっても、全てではありません）
- システムグローバル変数汚染
- セッションハイジャック
- ヌルバイト攻撃
- ディレクトリ遡り攻撃
- いくつかの危険なCSRF (XOOPS 2.0.9.2以下に存在するもの)
- Brute Force （パスワード総当たり）
- 拡張子偽装画像ファイルアップロード (すなわち、IE Content-Type XSS)
- 実行可能なファイルをアップロードする攻撃
- XMLRPC関連
- コメントSPAM/トラックバックSPAM等、あらゆるSPAM

これらの攻撃からあなたのXOOPSを守り、ログに記録します。

ただし、このモジュールはあくまで、最大公約数的な防御しか行いません。
一部の3rdパーティモジュールに見られるような穴の一部は防げるかもしれませんが、すべての穴を防ぎきるものではなく、過信は禁物です。

その限界は承知の上で、すべてのXOOPSユーザーに対して、インストールを[color=ff0000][b]強く[/b][/color]お勧めします。



●利用方法

インストールには、XOOPS_TRUST_PATHの設定が必要です。

アーカイブのhtml内を、XOOPS_ROOT_PATH側にコピーし、アーカイブのxoops_trust_path内を、XOOPS_TRUST_PATH側にコピーします。

モジュール管理からインストールできれば、正しくファイルが置けています。

ただ、それだけではまったく動作していませんので、mainfile.php からも呼び出すようにすることが絶対必要条件です。

Xoops Protector をインストール後、お使いのXOOPSの mainfile.php の一番下のあたりに
[code]
	[color=ff0000]include XOOPS_TRUST_PATH.'/modules/protector/include/precheck.inc.php' ;[/color]
	if (!isset($xoopsOption['nocommon']) [color=0000ff]&& XOOPS_ROOT_PATH != ''[/color] ) {
		include XOOPS_ROOT_PATH."/include/common.php";
	}
	[color=ff0000]include XOOPS_TRUST_PATH.'/modules/protector/include/postcheck.inc.php' ;[/color]
[/code]
と、赤くなっている２行を追加して下さい。

青色の部分は、最初にインストールした時のバージョンによって異なりますが、違っていても気にしなくて結構です。

バージョン3から、システムモジュール由来のIPアクセス拒否は利用しなくなりました。XOOPS_TRUST_PATH/modules/protector/configs を書込許可してください。Protectorが拒否IPを自動登録する場合、ここに記述するようになります。

もし、なんらかの理由で、自分自身がIP拒否リストに載ってしまった場合、バージョン2まではレスキューパスワードを利用していましたが、バージョン3からは、FTP等で XOOPS_TRUST_PATH/modules/protector/configs 内のファイルを編集または削除してください。

2.34から、実験的に、.htaccessによるDoS防御というオプションを追加しました。これを利用する場合、XOOPS_ROOT_PATHにある.htaccessを書込可能とする必要があります。導入する際には、.htaccessファイルが書込可能である、というリスクと比較して下さい。


●Cube 2.1 Legacyへのインストール

特段違いはありません。
mainfile.php の書き換えポイントの周辺が違うので、パッチを当てた後を示しておきます。
[code]
    if (!defined('_LEGACY_PREVENT_LOAD_CORE_') && XOOPS_ROOT_PATH != '') {
        include XOOPS_TRUST_PATH.'/modules/protector/include/precheck.inc.php' ;
        @include_once XOOPS_ROOT_PATH.'/include/cubecore_init.php';
        if (!isset($xoopsOption['nocommon']) && !defined('_LEGACY_PREVENT_EXEC_COMMON_')) {
            include XOOPS_ROOT_PATH.'/include/common.php';
        }
        include XOOPS_TRUST_PATH.'/modules/protector/include/postcheck.inc.php' ;
    }
[/code]


●バージョン2からのバージョンアップ

まず、mainfile.php から、Protectorに関する行を削除してください。

次に、いったんXOOPS_ROOT_PATH/modules/protector/ 内のファイルを全て削除します。

すぐに、インストールと同様に全ファイルをアップロードします。

管理画面からモジュール管理に入って、Protectorモジュールをアップデートします。

最後に、再度、mainfile.phpを編集し、precheckおよびpostcheckを有効にしてください。バージョン2では、XOOPS_ROOT_PATH となっていた部分が、バージョン3では、XOOPS_TRUST_PATH となっていることに注意が必要です。


●フィルタープラグインの利用

V3から、XOOPS_TRUST_PATH/modules/protector/filters_enabled/ にフィルタープラグインを格納することで、追加チェックができるようになりました。

現状で用意されているのは、下の２種類です。

- postcommon_post_deny_by_rbl.php
スパム対策用。
RBLを利用してPOSTをはねます。
RBLに登録されたIPからの投稿はすべてSPAMだと判定します。問い合わせが入るため、投稿時の処理がやや重くなるかもしれません。（特にChatなどでは影響があるかも）

-postcommon_post_need_multibyte.php
スパム対策用。
投稿に日本語が含まれていることを要求するプラグイン。
日本語が１文字も含まれていない100byte以上の文字列があったらSPAMだと判定します。

いずれも、XOOPS_TRUST_PATH/modules/protector/filters_disabled/ に置いてあるので、必要に応じて、filters_enabled にコピーしてください。


●変更履歴

3.17 beta (2008/04/24)
- URI SPAM判定で、自ホストと同一の場合は通過するようにした
- 言語ファイル更新
-- persian (thx stranger and voltan) 3.17a
- 言語ファイル追加
-- de_utf8 (thx wuddel) 3.17a

3.16 beta (2008/01/08)
- SPAMフィルター追加 postcommon_post_deny_by_httpbl (honeypotproject.orgのBL利用)
- 言語ファイル更新
-- polish (thx kurak_bu)

3.15 beta (2007/10/18)
- ログのコンパクト化追加
- ログの全削除追加
- 言語ファイル追加
-- fr_utf8 (thx gigamaster)

3.14 beta (2007/09/17)
- HTMLPurifier導入 (special thx! Edward Z. Yang) ※PHP4ではまともに動きません
- フィルターポイントを追加 (spamcheck, crawler, f5attack, bruteforce, purge)
- フィルタープラグイン追加
-- ゲスト投稿のすべてをHTMLPurifierに通過させるフィルター (PHP5専用)
-- SPAM判定された時にメッセージを表示する（リダイレクトする）フィルター
-- 悪質クローラ判定された時にメッセージを表示する（リダイレクトする）フィルター
-- F5アタック判定された時にメッセージを表示する（リダイレクトする）フィルター
-- ブルートフォース時にメッセージを表示する（リダイレクトする）フィルター
-- その他排斥処理される直前にメッセージを表示する（リダイレクトする）フィルター

3.13 beta (2007/08/22)
- フィルタープラグインをグローバル関数からクラスに変更
- フィルターポイントを追加 (badip, register)
- フィルタープラグイン追加
-- ユーザ登録時にJavaScriptチェックを入れるフィルター(ユーザ登録SPAM対策)
-- 拒否IP時にメッセージを表示するフィルター
-- 拒否IP時にリダイレクトするフィルター

3.12 beta (2007/08/16)
- $xoopsOption['nocommon'] が動作していなかったバグの修正

3.11 beta (2007/08/16)
- mainfile.php へのパッチでprecheckとpostcheckを取り違えても動くように対応
- RBLフィルターのデフォルトからniku.2ch.netを削除
- 言語ファイル追加
-- フランス語 (thx Christian)

3.10 beta (2007/07/30)
- precheckのconfigは、ローカルキャッシュから取得するようにした
- MySQLへの二重コネクションを極力排除した
- 信用できるIPが一部で機能していないバグの修正
- インストールとmainfileパッチの順番が逆でもエラーが出ないようにした
- ホダ塾インストーラだとフォルダのパーミッションを事前にチェックするロジックの追加
- 拒否IPを「一致」「前方一致」「正規表現」のいずれでも表記できるようにした
- 拒否IPに時間制限を設けた
- configsディレクトリが書込禁止になっている場合のWarningを追加

3.04 (2007/06/13)
- phpmailerのコマンド実行脆弱性に対するチェックを追加した
- postcommon_post_need_multibyte のチェックをもう少し強力にした (3.04a)

3.03 (2007/06/03)
- インストーラアタックへの対策を追加した
- 言語名変更
-- ja_utf8 (以前のjapaneseutf) 3.03a

3.02 (2007/04/08)
- ID風変数の強制変換の処理をもう少し緩やかにした
- セキュリティガイドのリンク切れを修正
- DoS/crawlerチェックをスキップできる手段の提供（ある定数を定義する）
- D3システムのアップデート
- 言語ファイル追加
-- persian (thx voltan)
-- russian (thx West) 3.02a
-- arabic (thx onasure) 3.02b
-- japaneseutf 3.02c

3.01 (2007/02/10)
- IPソートルールの変更
- 言語ファイル追加
-- portuguesebr (thx beduino)
-- spanish (thx PepeMty)
-- polish (thx kurak_bu) 3.01a
-- german (thx wuddel) 3.01b
- module_icon.php をキャッシュ可能に 3.01c
- module_icon.php のtypo修正 3.01d

3.00 (2007/02/06)
- 安定版としてのリリース
- ログレベル指定ミスの修正
- マルチバイトプラグインが登録ユーザのPOSTを弾かないように修正 (thx mizukami)
- 本家版2.2.xとの相性問題の改善 3.00a

3.00beta2 (2007/01/31)
- プラグインシステムの導入 (とりあえず postcommon_post_* というタイプのみ)
- フィルタープラグインの追加
-- postcommon_post_deny_by_rbl.php (RBLによるIPベースなSPAM対策)
-- postcommon_post_need_multibyte.php (文字種類によるSPAM対策)

3.00beta (2007/01/30)
- XOOPS_TRUST_PATH側に本体を置くことにした
- IP拒否機能を単純なファイル処理(configsディレクトリ下)に変更した
- グループ1になれるIPアドレス制限機能の追加（これも単なるファイル処理）
- レスキュー機能の削除 （3.0以降は単にFTP等でファイルを削除すれば復活します）
- テーブル構造の修正 (MySQL5対応)
- BigUmbrella anti-XSS の導入
- コメント・トラックバックSPAM対策機能追加
- Cube 2.1 Legacy RC での動作確認


●謝辞
 - Kikuchi (繁体中国語ファイル)
 - Marcelo Yuji Himoro (ブラジルのポルトガル語・スペイン語ファイル)
 - HMN (フランス語ファイル)
 - Defkon1 (イタリア語ファイル)
 - Dirk Louwers (オランダ語ファイル)
 - Rene (ドイツ語ファイル)
 - kokko (フィンランド語ファイル)
 - Tomasz (ポーランド語ファイル)
 - Sergey (ロシア語ファイル)
 - Bezoops (スペイン語ファイル)
 (以上、バージョン2までの言語ファイル作成者です。バージョン3ではいったん削ってます。すみません）
 - beduino (ブラジルのポルトガル語ファイル)
 - PepeMty (スペイン語ファイル)
 - kurak_bu (ポーランド語ファイル)
 - wuddel (ドイツ語)
 - voltan (ペルシャ語)
 - onasure (アラビア語)


また、このモジュール作成にあたり、様々なご指導・ご鞭撻をいただいた、zxチームの皆様、とりわけJM2さん、minahitoさんに、心より感謝いたします。


[/xlang:ja]

------------------------------------------------------------

GIJ=CHECKMATE <gij@peak.ne.jp>
2004-2008

PEAK XOOPS  http://xoops.peak.ne.jp/

