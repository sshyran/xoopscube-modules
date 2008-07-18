<?php
/*
 * Created on 2008/01/24 by nao-pon http://hypweb.net/
 * $Id: conf.lng.php,v 1.4 2008/05/22 00:28:52 nao-pon Exp $
 */
//
// German Translation Version 1.0 (11.03.2008)
// Translation English --> German: Octopus (hunter0815@googlemail.com)
// sicherlich steckt hier noch reichlich Qualit�tspotential in den �bersetzungen ;-)

$msg = array(
	'title_form' => 'xpWiki Einstellungen',
	'title_done' => 'xpWiki Einstellungen ge�ndert',
	'btn_submit' => 'Best�tigen der Einstellung',
	'msg_done' => 'Gespeichert in "$cache_file" durch die folgende Einstellung.',
	'title_description' => 'Erkl�rung der xpWiki Einstellungen',
	'msg_description' => '<p>In diesen bevorzugten Einstellungen werden lediglich ausgew�hlte Dinge der Datei "pukiwiki.ini.php" gecustomized.</p>'
	                   . '<p>In "$trust_ini_file" k�nnen viele weitere Einstellungen vorgenommen werden.</p>'
	                   . '<p>Bitte ziehe die Einstellungen der Dinge in "$html_ini_file" vor, falls Du �nderungen vornehmen m�chtest, die in diesem Men� hier nicht m�glich sind.</p>'
	                   . '<p># Die Inhalte dieses Men�s sind aufgrund der hohen Priorit�t hier aufgef�hrt. </p>',

	'Yes' => 'Ja',
	'No' => 'Nein',

	'PKWK_READONLY' => array(
		'caption'     => 'Nur zum Lesen?',
		'description' => 'Falls lediglich Lesen eingestellt ist, ist es nicht m�glich zu administrieren und Abs�tze o.�. zu �ndern.',
	),

	'function_freeze' => array(
		'caption'     => 'Sperrfunktion aktivieren?',
		'description' => '',
	),

	'adminpass' => array(
		'caption'     => 'Administrator Passwort',
		'description' => 'Es ist auch m�glich ein leeres Passwort einzugeben. Aber gib bitte die verschl�sselte Zeichenfolge ein, indem Du folgendes nutzt: "<a href="?cmd=md5" target="_blank">cmd=md5</a>".<br />'
		               . 'Unter "XOOPS" ist das Administratorkennwort  the problem is not in the administer password as cannot an attestation of everything as "{x-php-md5}" because of unnecessary if it logs it in as an administer. ',
	),

	'html_head_title' => array(
		'caption'     => '&lt;title&gt; format in &lt;head&gt;',
		'description' => 'Der Titel wird in &lt;title&gt; tag angezeigt und im &lt;head&gt; vom HTML gesetzt.<br />'
		               . 'Unterteilt wird hier in <b>$page_title</b>: Seiten Name, <b>$content_title</b>: Seiten Titel und <b>$module_title</b>: Modul Titel.',
	),

	'modifier' => array(
		'caption'     => 'Name des Administrators',
		'description' => '',
	),
	
	'modifierlink' => array(
		'caption'     => 'Link zur URL des Administrators',
		'description' => 'Hier kann eine Internet-Adresse des Administrators hinterlegt werden.',
	),
	
	'notify' => array(
		'caption'     => 'Mail-Benachrichtigung bei Seiten-Aktualisierungen?',
		'description' => 'Mail wird an den Administrator geschickt, wenn Seiten aktualisiert werden.',
	),

	'notify_diff_only' => array(
		'caption'     => 'Mail-Benachrichtigung nur bei Seiten-�nderungen?',
		'description' => 'Die Mail-Benachrichtigung beinhaltet nur die �nderungen.  Falls "Nein" gew�hlt ist, wird der komplette Text �bermittelt.',
	),

	'defaultpage' => array(
		'caption'     => 'Standard-Seite',
		'description' => 'Das ist die Standard-Seite, die angezeigt wird, wenn keine Seite festgelegt ist.',
	),
	
	'page_case_insensitive' => array(
		'caption'     => 'Sind Seitennamen unabh�ngig von Gro�- und Kleinschreibung?',
		'description' => 'Gro�- und Kleinschreibung wird in Seitennamen nicht ber�cksichtigt.',
	),
	
	'SKIN_NAME' => array(
		'caption'     => 'Standard Skin Name',
		'description' => 'Der standardm��ige Skin-Name wird hier festgelegt.',
		'normalskin'  => 'Normale H�ute',
		'tdiarytheme' => 't-Diary\'s Themen', 
	),
	
	'SKIN_CHANGER' => array(
		'caption'     => 'Sind �nderungen am Skin erlaubt?',
		'description' => 'Der Benutzer kann einen Skin w�hlen wenn hier "Ja" gew�hlt wird.<br />'
		               . 'Au�erdem , wird es m�glich das tdiary-Plugin auf jeder benutzten Seite anzugeben.',
	),
	
	'referer' => array(
		'caption'     => 'M�chtest Du Referer Informationen?',
		'description' => '�Diese Funktion erm�glicht die Kontrolle f�r alle Seiten, wer diese besucht hat.',
	),
	
	'allow_pagecomment' => array(
		'caption'     => 'Sollen Kommentare m�glich sein?',
		'description' => 'Die Kommentar-Integration kann hier eingestellt werden.<br />'
		               . 'Es ist wichtig die Kommentarfunktion unter den allgemeinen Einstellungen zu aktivieren um sie wirklich nutzen zu k�nnen.',
	),

	'nowikiname' => array(
		'caption'     => 'Ist der WikiName ung�ltig?',
		'description' => 'Eine automatische Link-Funktion f�r ung�ltige Wiki-Links.',
	),

	'pagename_num2str' => array(
		'caption'     => 'Ist der Seitenname konkret angezeigt?',
		'description' => 'Falls der letzte hierarchische Teil, die Nummer - (der Bindestrich) existiert, ersetzt dieser Teil den Seiten-Titel.',
	),

	'static_url' => array(
		'caption'     => 'Page URL-Stil',
		'description' => 'Au�er "?[PAGE]", w�hlen Sie es bitte, und ist wie eine URL einer statischen Seite.<br />'
		               . 'Aber, Wahlen zufolge, ist es notwendig, dass Du folgende Eintr�ge in der ".htaccess" vornimmst.<br />'
		               . '<dl><dt>[ID].html</dt><dd><code>RewriteEngine on<br />RewriteRule ^([0-9]+)\.html$ index.php?pgid=$1 [qsappend,L]</code></dd></dl>'
		               . '<dl><dt>{$root->path_info_script}/[PAGE]</dt><dd><code>Options +MultiViews<br />&lt;FilesMatch "^{$root->path_info_script}$"&gt;<br />ForceType application/x-httpd-php<br />&lt;/FilesMatch&gt;</code></dd></dl>',
	),

	'url_encode_utf8' => array(
		'caption'     => 'Benutzen Sie "UTF-8" von URL?',
		'description' => '"[PAGE]" Teil obenerw�hnten "Page URL-Stil" wird von "UTF-8" verschl�sselt.<br />'
		               . 'Aber, wenn die Charakterverschl�sselung von xpWiki ist UTF-8, es wird immer "UTF-8."',
	),

	'link_target' => array(
		'caption'     => 'Ext.Link Attribut "target"',
		'description' => '"target" Attribut vom externen Link.',
	),

	'class_extlink' => array(
		'caption'     => 'Ext.Link Attribut "class"',
		'description' => '"class" Attribut vom externen Link.',
	),

	'nofollow_extlink' => array(
		'caption'     => '"nofollow" im Ext.Link einstellen?',
		'description' => 'Das "nofollow" Attribute ist auf einen externen Link bezogen.',
	),

	'LC_CTYPE' => array(
		'caption'     => 'lokale (LC_CTYPE)',
		'description' => 'The locale for character classification and conversion is set. Please set it according to the environment when expecting it when processing it by the regular expression such as auto links doesn\'t result. ',
	),

	'autolink' => array(
		'caption'     => 'AutoLinks Bytes des Seiten-Namens',
		'description' => 'Ein Autolink ist eine Funktion, die automatisch auf den existierenden Seiten-Namen verlinkt.<br />'
		               . 'Die Nummer des Seiten Bytes wird mit der Eingabe wirksam. (Es ist ung�ltig mit einer 0.)<br />'
		               . 'Bitte nutze keine Buchstaben f�r die Byte-Nummer.',
		'extention'   => 'Bytes',
	),

	'autolink_omissible_upper' => array(
		'caption'     => 'AutoLink, ber�cksichtigt nicht die h�herliegende Hierarchie',
		'description' => 'Es wird automatisch verlinkt, selbst wenn die h�herliegende Hierarchie ausgelassen wird.<br />'
		               . 'Es wird automatisch verlinkt mit "/hoge/fuga" wenn "fuga" geschrieben wird auf der Seite "/hoge/hoge". <br />'
		               . 'Es ist genauso die Byte Nummer Angabe als auch ein AutoLink. (Gib eine Bytes-Nummer an, die fuga entspricht. )',
		'extention'   => 'Bytes',
	),

	'autoalias' => array(
		'caption'     => 'AutoAlias\' Bytes vom Wort',
		'description' => 'Diese Funktion verlinkt automatisch zu einer festgelegten "URL, Seite oder InterWiki" mit einem "vorgegebenem Wort".<br />'
		               . 'Es ist genauso die Byte Nummer Angabe als auch ein AutoLink. (Es gibt es byteweise aus f�r das ersetzte Wort. Es ist ung�ltig mit einer 0.)<br />'
		               . 'Konfigurations-Seite: <a href="?'.rawurlencode($this->root->aliaspage).'" target="_blank">'.$this->root->aliaspage.'</a>',
		'extention'   => 'Bytes',
	),

	'autoalias_max_words' => array(
		'caption'     => 'AutoAlias\' maximale pairs',
		'description' => 'Anzahl maximaler aufgelisteter W�rterbucheintr�ge f�r AutoAliase.',
		'extention'   => 'pairs',
	),

	'plugin_follow_editauth' => array(
		'caption'     => 'Soll das Plugin die "�nderungsberechtigung" �bernehmen?',
		'description' => 'Die Bearbeitung durch das Plugin ist nicht m�glich, wenn keine Seiten-�nderungsberechtigung vorliegt.',
	),

	'plugin_follow_freeze' => array(
		'caption'     => 'Soll das Plugin Seiten-Sperren ber�cksichtigen?',
		'description' => 'Die Bearbeitung durch das Plugin ist nicht m�glich, wenn die Seite gesperrt ist.',
	),

	'line_break' => array(
		'caption'     => 'Automatischen Zeilenumbruch aktivieren?',
		'description' => 'Zeilenumbruch wird konvertiert zu "&lt;br /&gt;".',
	),

	'fixed_heading_anchor_edit' => array(
		'caption'     => 'Abschnittsweise Editierung nutzen?',
		'description' => '',
	),

	'paraedit_partarea' => array(
		'caption'     => 'Bereich des Kapitels editieren',
		'description' => 'Bereich des Kapitels ist gesetzt.<br />'
		               . 'Bereich des Kapitels beginnt bei der �berschrift und startet mit * des Wiki-Formats.',
		'compat'      => 'Weiter zum n�chsten',
		'level'       => 'Weiter zum gleichen oder h�heren Level',
	),

	'pagecache_min' => array(
		'caption'     => 'Seiten Cache Ablauf Zeit',
		'description' => 'W�hrend der Seiten Cache Ablauf Zeit (Einheit: Minute) wird, wenn HTML die Seite �bersetzt, dies in den Cache gegeben und f�hrt zu einer Beschleunigung.<br />'
		               . 'Aber nur wenn ein Gast-Account aufgerufen wird, wird gecached. Es wird empfohlen, wenn sehr viele Seitenaufrufe stattfinden.',
		'extention'   => 'Min.',
	),

	'pre_width' => array(
		'caption'     => 'CSS:Breit f�r &lt;pre&gt;',
		'description' => 'Der Wert Breite im CSS ist vorgegeben f�r &lt;pre&gt; Kennzeichnung ist vorgeschrieben.',
	),

	'pre_width_ie' => array(
		'caption'     => 'CSS:Breite f�r &lt;pre&gt;(nur IE)',
		'description' => 'Dieser Wert ist nur f�r den Internet Explorer. Falls die Anzeige nicht korrekt aussieht, da das Theme von XOOPS f�r &lt;Table&gt; entworfen wurde, gib einen festen Wert wie "700px" ein.',
	),

	'update_ping' => array(
		'caption'     => 'Schicken Update Ping?',
		'description' => '',
	),

	'update_ping_servers' => array(
		'caption'     => 'Update Ping Server',
		'description' => 'Schreiben Sie einem XML-RPC Ping Server, die mit "http" eine Linie beginnen.<br />Wenn Sie "extendedPing" schicken wollen, befestigen Sie [Space] + "E" nach dem URL.',
	),

	'pagereading_enable' => array(
		'caption'     => 'Classify by page name reading?',
		'description' => 'The setting concerning page name reading is a setting only for a Japanese environment.',
	),

	'pagereading_kanji2kana_converter' => array(
		'caption'     => 'Page name reading converter',
		'description' => '',
	),

	'pagereading_kanji2kana_encoding' => array(
		'caption'     => 'Converter\'s encoding',
		'description' => '',
	),

	'pagereading_chasen_path' => array(
		'caption'     => 'ChaSen path',
		'description' => '',
	),

	'pagereading_kakasi_path' => array(
		'caption'     => 'KAKASI path',
		'description' => '',
	),

	'pagereading_config_dict' => array(
		'caption'     => 'Reading dictionary page',
		'description' => 'It is used for "None" the method of acquiring page name reading.',
	),

);
?>