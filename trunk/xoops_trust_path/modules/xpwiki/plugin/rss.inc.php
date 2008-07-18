<?php
// PukiWiki - Yet another WikiWikiWeb clone
// $Id: rss.inc.php,v 1.28 2008/06/26 00:17:40 nao-pon Exp $
//
// RSS plugin: Publishing RSS of RecentChanges
//
// Usage: plugin=rss[&ver=[0.91|1.0|2.0|atom]] (Default: 1.0)
//
// NOTE for acronyms
//   RSS 0.9,  1.0  : RSS means 'RDF Site Summary'
//   RSS 0.91, 0.92 : RSS means 'Rich Site Summary'
//   RSS 2.0        : RSS means 'Really Simple Syndication' (born from RSS 0.92)
//   RSS Atom       : RSS means 'Atom Syndication Format'

class xpwiki_plugin_rss extends xpwiki_plugin {
	var $maxcount;
	
	function plugin_rss_init () {
		// �ꥹ�ȥ��å׺���ڡ�����
		$this->maxcount = 100;
	}

	function get_content ($page) {
		// �ɲþ������
		$added = $this->func->get_page_changes($page);

		// ����ڡ�������ʸ����
		$a_page = & XpWiki::getSingleton($this->root->mydirname);
		$a_page->init($page);
		$GLOBALS['Xpwiki_'.$this->root->mydirname]['cache'] = null;
		$a_page->root->rtf['use_cache_always'] = TRUE;
		$a_page->execute();
		$html = $a_page->body;
		
		// ���
		if (empty($GLOBALS['Xpwiki_'.$this->root->mydirname]['cache']['fusen']['loaded'])){
			if ($fusen = $this->func->get_plugin_instance('fusen')) {
				if ($fusen_data = $fusen->plugin_fusen_data($page)) {
					if ($fusen_tag = $fusen->plugin_fusen_gethtml($fusen_data, '')) {
						$html .= '<fieldset><legend> fusen.dat </legend>' . $fusen_tag . '</fieldset>';					
					}
				}
			}
		}
		
		$html = $this->func->add_MyHostUrl($html);
		
		$description = strip_tags(($added ? $added . '&#182;' : '') . $html);
		//$description = preg_replace('/(\s+|&'.$this->root->entity_pattern.';)/i', ' ', $description);
		$description = preg_replace('/[\r\n]+/', "\n", $description);
		$description = mb_substr($description, 0, 250);
		// ������ʬ�Ǥ��줿���ֻ��Ȥ�����к��->���˥�����
		$description = htmlspecialchars(preg_replace('/&([^;]+)?$/', '', $description));
		
		$tags = array();
		if (file_exists($this->cont['CACHE_DIR'] . $this->func->encode($page) . '_page.tag')) {
			$tags = file($this->cont['CACHE_DIR'] . $this->func->encode($page) . '_page.tag');
		}

		if ($added) $html = '<dl><dt>Changes</dt><dd>' . $added . '</dd></dl><hr />' . $html;
		$pginfo = $this->func->get_pginfo($page);
		
		// ]]> �򥯥�����
		$html = str_replace(']]>', ']]&gt;', $html);

		// ̵���ʥ�������
		$html = preg_replace('#<(script|form|embed|object).+?/\\1>#is', '',$html);
		$html = preg_replace('#<(link|wbr).*?>#is', '',$html);

		// ���л����󥯤���
		$html = preg_replace('#<a[^>]+href=(?!(?:"|\')?\w+://)[^>]+>(.*?)</a>#is', '$1', $html);
		
		// �������̵����°������
		$_reg = '/(<[^>]*)\s+(?:id|class|name|on[^=]+)=("|\').*?\\2([^>]*>)/s';
		while(preg_match($_reg, $html)) {
			$html = preg_replace($_reg, '$1$3', $html);
		}
		
		return array($description, $html, $pginfo, $tags);

	}
	
	function plugin_rss_action()
	{
		$version = isset($this->root->vars['ver']) ? strtolower($this->root->vars['ver']) : '';
		$base = isset($this->root->vars['p']) ? $this->root->vars['p'] : '';
		$s_base = $base ? '/' . $base : '';
		switch($version){
		case '':  $version = '1.0';  break; // Default
		case '1': $version = '1.0';  break; // Sugar
		case '2': $version = '2.0';  break; // Sugar
		case 'atom': /* FALLTHROUGH */
		case '0.91': /* FALLTHROUGH */
		case '1.0' : /* FALLTHROUGH */
		case '2.0' : break;
		default: die('Invalid RSS version!!');
		}
		
		$count = (empty($this->root->vars['count']))? $this->root->rss_max : (int)$this->root->vars['count'];
		
		$count = max($count, 1);
		$count = min($count, $this->maxcount);
			
		// ����å���ե�����̾
		$c_file = $this->cont['CACHE_DIR'] . 'plugin/' . md5($version.$base.$count.$this->cont['ROOT_URL']) . $this->cont['UI_LANG'] . '.rss';

		// ǰ�Τ���Хåե��򥯥ꥢ
		while( ob_get_level() ) { ob_end_clean() ; }
		
		if (file_exists($c_file)) {
			$filetime = filemtime($c_file);
			$etag = md5($c_file.$filetime);
					
			if ($etag === @$_SERVER["HTTP_IF_NONE_MATCH"] && $this->cont['UA_PROFILE'] !== 'keitai') {
				header( "HTTP/1.1 304 Not Modified" );
				header( "Etag: ". $etag );
				header('Cache-Control: private');
				header('Pragma:');
				//header('Expires:');
				exit();
			}
			
			$out = file_get_contents($c_file);

		} else {
			// �Хåե����
			ob_start();
					
			$lang = $this->cont['LANG'];
			$page_title = htmlspecialchars($this->root->siteinfo['sitename'] . '::' . $this->root->module_title . $s_base);
			$self = $this->func->get_script_uri();
			$maketime = $date = substr_replace($this->func->get_date('Y-m-d\TH:i:sO'), ':', -2, 0);
			$buildtime = $this->func->get_date('r');
			$pubtime = 0;
			$rss_css = $this->cont['LOADER_URL'] . '?src=rss.' . $this->cont['UI_LANG'] . '.xml';
		
			// Creating <item>
			$items = $rdf_li = '';
			
			// �����Ȱ����ǰ��������
			$lines = $this->func->get_existpages(FALSE, ($base ? $base . '/' : ''), array('limit' => $count, 'order' => ' ORDER BY editedtime DESC', 'nolisting' => TRUE, 'withtime' => TRUE, 'asguest' => TRUE));
			
			foreach ($lines as $line) {
				list($time, $page) = explode("\t", rtrim($line));
				$r_page = rawurlencode($page);
				$link = $this->func->get_page_uri($page, true);
				$title = htmlspecialchars($this->root->pagename_num2str ? preg_replace('/\/(?:[0-9\-]+|[B0-9][A-Z0-9]{9})$/','/'.$this->func->get_heading($page),$page) : $page);
				if ($base) $title = substr($title, (strlen($base) + 1));
				if (!$pubtime) $pubtime = $this->func->get_date('r', $time);
		
				switch ($version) {
				
				case '0.91':
					$date = $this->func->get_date('r', $time);
					$items .= <<<EOD
<item>
 <title>$title</title>
 <link>$link</link>
 <description>$date</description>
</item>

EOD;
					break;
				
				case '2.0':
					list($description, $html, $pginfo) = $this->get_content($page);
					$author = htmlspecialchars($pginfo['uname']);
					$date = $this->func->get_date('r', $time);
					$items .= <<<EOD
<item>
 <title>$title</title>
 <link>$link</link>
 <guid>$link</guid>
 <pubDate>$date</pubDate>
 <description>$description</description>
 <content:encoded><![CDATA[
  $html
  ]]></content:encoded>
</item>

EOD;
					break;
		
				case '1.0':
					// Add <item> into <items>
					list($description, $html, $pginfo, $tags) = $this->get_content($page);
					$author = htmlspecialchars($pginfo['uname']);
					
					$tag = '';
					if ($tags) {
						$tags = array_map('htmlspecialchars',array_map('rtrim',$tags));
						$tag = '<dc:subject>' . join("</dc:subject>\n <dc:subject>", $tags).'</dc:subject>';
					}
					
					$rdf_li .= '    <rdf:li rdf:resource="' . $link . '" />' . "\n";
					
					$date = substr_replace($this->func->get_date('Y-m-d\TH:i:sO', $time), ':', -2, 0);
					
					$trackback_ping = '';
					/*
					if ($this->root->trackback) {
						$tb_id = md5($r_page);
						$trackback_ping = ' <trackback:ping>' . $self .
						'?tb_id=' . $tb_id . '</trackback:ping>';
					}
					*/
					$items .= <<<EOD
<item rdf:about="$self?$r_page">
 <title>$title</title>
 <link>$link</link>
 <dc:date>$date</dc:date>
 <dc:creator>$author</dc:creator>
 $tag
 <description>$description</description>
 <content:encoded><![CDATA[
 $html
 ]]></content:encoded>
 <dc:identifier>$self?$r_page</dc:identifier>
$trackback_ping
</item>

EOD;
					break;
				case 'atom':
					list($description, $html, $pginfo, $tags) = $this->get_content($page);
					$author = htmlspecialchars($pginfo['uname']);
					
					$tag = '';
					if ($tags) {
						$tags = array_map('htmlspecialchars',array_map('rtrim',$tags));
						foreach($tags as $_tag) {
							$tag .= '<category term="'.str_replace('"', '\\"',$_tag).'"/>'."\n";
						}
					}
					
					$date = substr_replace($this->func->get_date('Y-m-d\TH:i:sO', $time), ':', -2, 0);
					
					$id = $link;
					
					$items .= <<<EOD
<entry>
 <title type="html">$title</title>
 <link rel="alternate" type="text/html" href="$link" />
 <id>$id</id>
 <updated>$date</updated>
 <published>$date</published>
 $tag
 <author>
  <name>$author</name>
 </author>
 <summary type="html">$description</summary>
 <content type="html"><![CDATA[
 $html
 ]]></content>
</entry>

EOD;

					break;
				}
			}
		
			// Feeding start
			print '<?xml version="1.0" encoding="UTF-8"?>' . "\n\n";
		
			//$r_whatsnew = rawurlencode($this->root->whatsnew);
			$link = $base? $this->func->get_page_uri($base, true) : $self;
			
			switch ($version) {
			case '0.91':
				print <<<EOD
<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN" "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="$version">
 <channel>
  <title>$page_title</title>
  <link>$link</link>
  <description>xpWiki RecentChanges</description>
  <language>$lang</language>

$items
 </channel>
</rss>
EOD;
				break;		
			case '2.0':
				print <<<EOD
<rss version="$version" xmlns:content="http://purl.org/rss/1.0/modules/content/">
 <channel>
  <title>$page_title</title>
  <link>$link</link>
  <description>xpWiki RecentChanges</description>
  <language>$lang</language>
  <image>
   <url>{$self}module_icon.php</url>
   <title>$page_title</title>
   <link>$link</link>
   <description>$page_title</description>
  </image>
  <pubDate>$pubtime</pubDate>
  <lastBuildDate>$buildtime</lastBuildDate>
  <generator>xpWiki</generator>
    
$items
 </channel>
</rss>
EOD;
				break;
		
			case '1.0':
				$xmlns_trackback = $this->root->trackback ?
					'  xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/"' : '';
				print <<<EOD
<?xml-stylesheet type="text/xsl" media="screen" href="{$rss_css}" ?>
<rdf:RDF
  xmlns:dc="http://purl.org/dc/elements/1.1/"
$xmlns_trackback
  xmlns="http://purl.org/rss/1.0/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xml:lang="$lang">
 <channel rdf:about="$link">
  <title>$page_title</title>
  <link>$link</link>
  <description>xpWiki RecentChanges</description>
  <dc:date>$maketime</dc:date>
  <image rdf:resource="{$self}module_icon.php" />
  <items>
   <rdf:Seq>
$rdf_li
   </rdf:Seq>
  </items>
 </channel>
 <image rdf:about="{$self}module_icon.php">
   <title>$page_title</title>
   <link>$link</link>
   <url>{$self}module_icon.php</url>
 </image>

$items
</rdf:RDF>
EOD;
				break;
			case 'atom':
				$rpage = ($base)? '&amp;p='.rawurlencode($base) : '';
				$feedurl = $this->cont['HOME_URL'].'?cmd=rss'.$rpage.'&amp;ver=atom';
				$rpage = ($base)? '&amp;p='.rawurlencode($base) : '';
				$modifier = htmlspecialchars($this->root->modifier);
				print <<<EOD
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="$lang">
 <title>$page_title</title>
 <link rel="alternate" type="text/html" href="$link" />
 <link rel="self" type="application/atom+xml" href="$feedurl" />
 <id>$self</id>
 <updated>$maketime</updated>
 <subtitle>xpWiki RecentChanges</subtitle>
 <generator uri="http://hypweb.net/">xpWiki</generator>
  <rights>hypweb.net</rights>
 <author>
  <name>$modifier</name>
  <uri>{$this->root->modifierlink}</uri>
 </author>

$items
</feed>
EOD;
				break;
			}
			$out = mb_convert_encoding(ob_get_contents(), 'UTF-8', $this->cont['CONTENT_CHARSET']);
			ob_end_clean();
			
			// NULL�Х��Ƚ���
			$out = $this->func->input_filter($out);
			
			//����å���񤭹���
			if ($fp = @fopen($c_file,"wb"))
			{
				fputs($fp, $out);
				fclose($fp);
			}
			$filetime = filemtime($c_file);
			$etag = md5($c_file.$filetime);
		}

		if ($this->cont['UA_PROFILE'] === 'keitai' && HypCommonFunc::get_version() >= '20080626') {
			HypCommonFunc::loadClass('HypRss2Html');
			$r = new HypRss2Html($out);
			$out = $r->getHtml();
			$out = mb_convert_encoding($out, 'SJIS', $r->encoding);

			HypCommonFunc::loadClass('HypKTaiRender');
			$r = new HypKTaiRender();
			$r->set_myRoot($this->root->siteinfo['host']);
			$r->inputHtml = $out;
			$r->inputEncode = 'SHIFT_JIS';
			$r->Config_redirect = $this->cont['HOME_URL'] . 'gate.php?way=redirect_SJIS&amp;xmode=2&amp;l=';
			$r->doOptimize();
			$out = $r->outputBody;

			header('Content-Type: text/html; charset=Shift_JIS');
			header('Content-Length: ' . strlen($out));
		
		} else {
			header('Content-Type: application/xml; charset=utf-8');
			header('Content-Length: ' . strlen($out));
			header('Cache-Control: private');
			header('Pragma:');
			header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $filetime ) . ' GMT' );
			header('Etag: '. $etag );
		}
		echo $out;
		exit;
	}
}
?>