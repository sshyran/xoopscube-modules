<?php
//
// Created on 2006/11/07 by nao-pon http://hypweb.net/
// $Id: check.func.php,v 1.16 2008/07/03 00:01:42 nao-pon Exp $
//

// when onInstall & onUpdate
function xpwikifunc_permission_check ($mydirname) {
	$msg = array();
	
	$dirs = array(
		'attach',
		'attach/s',
		'private/backup',
		'private/cache',
		'private/cache/page',
		'private/cache/plugin',
		'private/counter',
		'private/diff',
		'private/trackback',
		'private/wiki'
	);
	
	foreach($dirs as $dir) {
		$dir = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/'.$dir;
		$checkfile = $dir.'/.check';
		if (@touch($checkfile)) {
			unlink($checkfile);
		} else {
			$msg[] = " - {$dir}<br />";
		}
	}
	
	if ($msg) {
		array_unshift($msg, "<span style=\"color:#ff0000;\">Error: Could not write a file in next directories. Please check permission and retry.</span><br />");
	}
	
	return $msg;
}

// when onInstall & onUpdate
function xpwikifunc_defdata_check ($mydirname, $mode = 'install') {
	$msg = array();
	
	$config_handler =& xoops_gethandler('config');
	$xoopsConfig =& $config_handler->getConfigsByCat(XOOPS_CONF);
	$language = $xoopsConfig['language'];
	$utf8from = '';
	
	switch (strtolower($language)) {
		case 'japanese' :
		case 'japaneseutf' :
		case 'ja_utf8' :
		case 'japanese_utf8' :
			$lang = 'ja';
			if ('utf-8' === strtolower(_CHARSET)) {
				$utf8from = 'EUC-JP';
			}
			break;
		case 'english' :
			$lang = 'en';
			break;
		default:
			$lang = 'en';
	}

	$dirs = array(
		'cache' => 'private/cache',
		'wiki'  => 'private/wiki'
	);
	
	$from_base = dirname(dirname(__FILE__)).'/ID/'.$lang.'/';
	$timestamp = array();
	
	foreach(file($from_base.'wiki/.timestamp') as $line) {
		list($file, $time) = explode("\t", $line);
		$timestamp[$file] = intval(trim($time));
	}

	foreach ($dirs as $from=>$to) {
		$dir = $from;
		$from = $from_base.$from;
		$to   = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/'.$to;
		
		if ($handle = opendir($from)) {
			while (false !== ($file = readdir($handle))) {
				if ($file !== '.' && $file !== '..' && ! is_dir($from.'/'.$file)) {
					if ($mode === 'install' || $dir !== 'wiki' || substr($file, -4) !== '.txt') {
						if (! file_exists($to.'/'.$file)) {
							copy($from.'/'.$file, $to.'/'.$file);
							if ($utf8from) {
								xpwikifunc_conv_utf($to.'/'.$file, $utf8from);
							}
							if ($dir === 'wiki' && isset($timestamp[$file])) {
								touch($to.'/'.$file, $timestamp[$file]);
							}
							$msg[] = "Copied a file '{$file}'.<br />";
						}
					} else {
						// wiki pages
						$_file_exist = file_exists($to.'/'.$file);
						if (! $_file_exist || filemtime($to.'/'.$file) < $timestamp[$file]) {
							if (! isset($xpwiki)) {
								include_once dirname(dirname(__FILE__)) . '/include.php';
								$xpwiki = new XpWiki($mydirname);
								$xpwiki->init('#RenderMode');
							}
							
							$page = $xpwiki->func->decode(str_replace('.txt', '', $file));
							
							if (! $_file_exist && $xpwiki->func->get_pgid_by_name($page)) {
								// The user has intentionally deleted it.
								continue;
							}
							
							// Reformat source
							$src = file_get_contents($from.'/'.$file);
							$src = $xpwiki->func->remove_pginfo($src);
							$src_freeze = false;
							if (!$_file_exist) {
								$src_freeze = preg_match('/^#freeze\s*$/m', $src);
							}
							// Remove '#freeze'
							$src = preg_replace('/^#freeze\s*$/m', '', $src);
							$src = ltrim($src);
							
							// UTF-8?
							if ($utf8from) {
								$src = mb_convert_encoding($src, 'UTF-8', $utf8from);
							}
							
							// Was it frozen?
							$is_freeze = $xpwiki->func->is_freeze($page);
							$xpwiki->root->rtf['no_checkauth_on_write'] = true;
							$xpwiki->func->page_write($page, $src);
							if ($is_freeze || $src_freeze) {
								// Freeze
								$postdata = $xpwiki->func->get_source($page);
								array_unshift($postdata, "#freeze\n");
								$xpwiki->func->file_write($xpwiki->cont['DATA_DIR'], $page, join('', $postdata), TRUE);
								// Update
								$xpwiki->func->is_freeze($page, TRUE);
								// pginfo DB write
								$xpwiki->func->pginfo_freeze_db_write($page, 1);
							}
							// touch page
							$xpwiki->func->touch_page($page, $timestamp[$file]);
							
							$msg[] = "Updated a page '" . htmlspecialchars($page) . "'.<br />";
						}
					}
				}
			}
			closedir($handle);
		}
	}
	
	if (isset($xpwiki)) { $xpwiki = null; }
	
	// Remove facemarks.js
	@ unlink(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/private/cache/'. md5(XOOPS_URL . '/modules/' . $mydirname) . '_facemarks.js');
	
	return $msg;
}

function xpwikifunc_conv_utf($file, $utf8from) {
	$dat = file_get_contents($file);
	$dat = mb_convert_encoding($dat, 'UTF-8', $utf8from);
	if ($fp = fopen($file, 'wb')) {
		fwrite($fp, $dat);
		fclose($fp);
	}
	return ;
}
?>