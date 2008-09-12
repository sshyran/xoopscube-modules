<?php

/** 成功 */
define('CINEMARU_GET_URL_OK', 1);
/** ホスト名が引けなかった */
define('CINEMARU_GET_URL_UNKNOWN_HOST', 2);
/* ソケット作成失敗 */
define('CINEMARU_GET_URL_SOCKET_CREATE_FAILED', 3);
/* ソケット接続失敗 */
define('CINEMARU_GET_URL_SOCKET_CONNECT_FAILED', 4);
/** yotube flv url */
define('CINEMARU_YOUTUBE_FLV_URL', 'http://jp.youtube.com/get_video?video_id=%s&t=%s');

function cinemaru_get_url($url)
{
    $urls = parse_url($url);
    
    // Get the port for the WWW service. 
    $service_port = getservbyname('www', 'tcp');
    
    if (@$urls['port'] != '') {
	$service_port = $urls['port'];
    }
    
    // Get the IP address for the target host. 
    $address = gethostbyname($urls['host']);
    
    if ($urls['host'] == $address && preg_match('/[A-Za-z]/', $urls['host'])) {
	return array('stat' => CINEMARU_GET_URL_UNKNOWN_HOST);
    }
    
    // Create a TCP/IP socket.
    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    if ($socket < 0) {
	return array('stat' => CINEMARU_GET_URL_SOCKET_CREATE_FAILED);
    }
    
    $result = socket_connect($socket, $address, $service_port);
    if ($result < 0) {
	return array('stat' => CINEMARU_GET_URL_SOCKET_CONNECT_FAILED);
    }
    
    $path = @$urls['path'];
    if (@$urls['path'] == '') {
	$path = '/';
    }
    
    if (@$urls['query'] != '') {
	$path = $path . '?' . $urls['query'];
    }
    
    $in = "GET " . $path . " HTTP/1.0\r\n";
    $in .= "Host: " . $urls['host'] ."\r\n";
    $in .= "Connection: Close\r\n\r\n";
    $out = '';
    
    socket_write($socket, $in, strlen ($in));
    
    $ret = array();
    $ret['body'] = '';
    if ($out = socket_read($socket, 4096)) {
	$ret['body'] .= $out;
	if (preg_match('/Location:(.+)\n/', $out, $r)) {
	    $ret['res'] = $r[1];
	}
    }
    
    socket_close($socket);
    
    $ret['stat'] = CINEMARU_GET_URL_OK;
    
    return $ret;
}

function cinemaru_get_url2($url)
{
    $fi = fopen($url, 'r');
	    
    $buf = '';
    while ($tmp=fread($fi, 4096)) {
	$buf .= $tmp;
    }
	    
    fclose($fi);
    
    return $buf;
}

function cinemaru_get_youtube_flv_url($url)
{
    $urls = parse_url($url);
    if (preg_match('/v=([^&]+)&?/', $url, $r)) {
	$tmp_url = 'http://www.youtube.com/v/' . $r[1];
	
	if (function_exists('socket_create')) {
	    $ret = cinemaru_get_url($tmp_url);
	    
	    if (preg_match('/Location:.+&t=(.+)\n/', $ret['body'], $r2)) {
		return sprintf(CINEMARU_YOUTUBE_FLV_URL, trim($r[1]), trim($r2[1]));
	    }
	} else {
	    $buf = cinemaru_get_url2($url);
	    
	    if (preg_match('/"t": "([^"]+)"/', $buf, $r2)) {
		return sprintf(CINEMARU_YOUTUBE_FLV_URL, trim($r[1]), trim($r2[1]));
	    }
	}
    }
    
    return '';
}



