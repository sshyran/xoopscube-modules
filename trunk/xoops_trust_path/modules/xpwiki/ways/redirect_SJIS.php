<?php
/*
 * Created on 2008/06/17 by nao-pon http://hypweb.net/
 * License: GPL v2 or (at your option) any later version
 * $Id: redirect_SJIS.php,v 1.1 2008/06/17 10:12:37 nao-pon Exp $
 */

if (isset($_GET['l'])) {
	$url = $_GET['l'];
	$google = 'http://www.google.co.jp/gwt/n?u=' . rawurlencode($url);
	$url = str_replace('&amp;', '&',htmlspecialchars($_GET['l']));

	// clear output buffer
	while( ob_get_level() ) {
		ob_end_clean() ;
	}

	header('Content-type: text/html; charset=Shift_JIS');
	echo '<html><head><title>�O���ֈړ�</title></head><body>�O���T�C�g�ֈړ����܂��B<br><br><a href="'.$url.'">'.$url.'</a><br><br><a href="'.$google.'">Google �̌g�ѕϊ����g��</a></body></html>';
}
?>