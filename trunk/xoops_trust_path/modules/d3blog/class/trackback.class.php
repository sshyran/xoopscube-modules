<?php
/**
 * @version $Id: trackback.class.php 638 2010-06-26 05:31:52Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

require_once dirname(dirname(__FILE__)).'/lib/object.php';
require_once dirname(dirname(__FILE__)).'/include/filter/TrackbackFilter.class.php';
require_once dirname(dirname(__FILE__)).'/include/blacklist.class.php';
require_once XOOPS_ROOT_PATH.'/class/snoopy.php';

if( ! class_exists('d3blogTrackbackObjectBase') ){

class d3blogTrackbackObjectBase extends myXoopsObject {
    var $mydirname_;
    var $_encoding = 'UTF-8';
    var $tbkey_;
    var $_data = array('title' => '', 'blog_name' => '', 'excerpt' => '', 'url' => '');

    function d3blogTrackbackObjectBase($id=null)
    {
        $this->initVar("tid", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("bid", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("blog_name", XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar("url", XOBJ_DTYPE_TXTBOX, null, false, 150);
        $this->initVar("trackback_url", XOBJ_DTYPE_TXTBOX, null, false, 150);
        $this->initVar("title", XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar("excerpt", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("direction", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("host", XOBJ_DTYPE_TXTBOX, null, false, 15);
        $this->initVar("tbkey", XOBJ_DTYPE_TXTBOX, null, false, 12);
        $this->initVar("approved", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("created", XOBJ_DTYPE_INT, time(), false);

        if ( is_array ( $id ) )
            $this->assignVars ( $id );
    }

    function &getStructure($type='s')
    {
        $ret =& parent::getStructure($type);
        return $ret;
    }

    function isApproved() {
        return $this->getVar('approved');
    }

    function autodiscover() {
        // get file contents.
        if (!$contents = $this->_getContents($this->getVar('trackback_url'))) {
            $this->setErrors('Could not get contents of '.$this->getVar('trackback_url'));
            return false;
        }

        // get trackback identifier
        if (!preg_match('@dc:identifier\s*=\s*["\'](http:[^"\']+)"@i', $contents, $matches)) {
            $this->setErrors('No trackback RDF found in "'.$this->getVar('trackback_url').'".');
            return false;
        }
        $identifier = trim($matches[1]);

        // get trackback URI
        if (!preg_match('@trackback:ping\s*=\s*["\'](http:[^"\']+)"@i', $contents, $matches)) {
            $this->setErrors('No trackback URI found in "'.$this->getVar('trackback_url').'".');
            return false;
        }
        $trackbackUrl = trim($matches[1]);

        // check if the URL to trackback matches the identifier from the autodiscovery code
        if ($identifier != $this->getVar('trackback_url')) {
            $this->setErrors('URLs mismatch. "'.$this->getVar('trackback_url').'" not equal to "'.$identifier.'".');
            return false;
        }

        $this->setVar('trackback_url', $trackbackUrl);
        return true;
    }

    function send() {
        $snoopy = new Snoopy();
        if (!$snoopy->submit($this->getVar('trackback_url'), $this->_data)) {
            $this->setErrors('Host returned Error:'.$snoopy->error);
            return false;
        }
        return $this->_interpreteTrackbackResponse($snoopy->results);
    }

    function receive() {
        if ( extension_loaded('mbstring') ) {
            $internalEncoding = mb_internal_encoding();
            $this->_encoding = mb_detect_encoding( serialize($_POST) );
            mb_convert_variables( $internalEncoding, $this->_encoding, $_POST );
        }

        $this->setVars($_POST);
        $this->setVar('trackback_url', '');
        if(!$this->_checkItems()) {
            return false;
        }

        return true;
    }

    function spamCheck() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $check_items = $myModule->getConfig('spam_check');
        if(is_array($check_items) && in_array('n', $check_items)) {
            return true;
        }

        // multibytes characters check
        if(XOOPS_USE_MULTIBYTES == 1 && function_exists('mb_strlen') && in_array('l', $check_items) && $myModule->getConfig('regex_pattern')) {
            $elements = array('title', 'blog_name', 'excerpt');
            $string = mb_convert_encoding($this->_makeString($elements), 'UTF-8');
            $pattern = mb_convert_encoding($myModule->getConfig('regex_pattern'), 'UTF-8');

            $matched = '';
            if(preg_match_all("/($pattern)/ux", $string, $matches)) {
                $matched = join("", $matches[1]);
            }
            if(mb_strlen($matched) < $myModule->getConfig('letters')) {
                $this->setErrors('Our language characters are not found in your comment. ');
                return false;
            }
        }

        // word check
        if(in_array('w', $check_items) && $myModule->getConfig('wordlist')) {
            $elements = array('title', 'blog_name', 'excerpt');
            $patterns = preg_split("/[\s]+/", $myModule->getConfig('wordlist'));
            $string = $this->_makeString($elements);
            foreach($patterns as $pattern) {
//                if(false !== stripos($string, $pattern)) {
                if(preg_match("/$pattern/i", $string)) {
                    $this->setErrors('Your trackback contains a banned word. ');
                    return false;
                }
            }
        }

        // regex check
        if(in_array('r', $check_items) && $myModule->getConfig('regex')) {
            $elements = array('title', 'blog_name', 'excerpt', 'url');
            $pattern = '('.implode('|', preg_split("/[\s]+/", $myModule->getConfig('regex'))).')';

            if (preg_match('/'. $pattern. '/i', $this->_makeString($elements))) {
                $this->setErrors('Your trackback contains a spammy word. ');
                return false;
            }
        }

        // dnsbl check
        if(in_array('d', $check_items) && $myModule->getConfig('dnsbl')) {
            $dnsbls = preg_split("/[\s]+/", $myModule->getConfig('dnsbl'));
            if(is_array($dnsbls) && !empty($dnsbls)) {
                $blacklist = new Blacklist();
                if($blacklist->setBlacklists($dnsbls)) {
                    $senderIP = $blacklist->getIP();
                    if($senderIP == 'unknown' || !($blacklist->checkIP($senderIP))) {
                        $this->setErrors('Your IP address is unknown.');
                        return false;
                    }

                    if($blacklist->isListed($blacklist->reverseIP($senderIP))) {
                        $this->setErrors('Your IP address, '.htmlspecialchars($senderIP, ENT_QUOTES).', are listed on a blacklist db.');
                        return false;
                    }
                    $this->setVar('host', $senderIP);
                }
                unset($blacklist);
            }
        }

        // SURBL check
        if(in_array('s', $check_items) && $myModule->getConfig('surbl')) {
            $elements = array('title', 'excerpt', 'blog_name');
            $urls = $this->_extractURLs($this->_makeString($elements));
            if(count($urls) > 0) {
                $blacklist = new Blacklist();

                // strip domain prefix to get a domain
                $blacklist->buildLookupDomain();

                // check if a domain is ip address
                if(!empty($blacklist->_ips)) {
                    if($blacklist->setBlacklists(preg_split("/[\s]+/", $myModule->getConfig('dnsbl')))) {
                        foreach($blacklist->_ips as $ip) {
                            if($blacklist->isListed($blacklist->reverseIP($ip))) {
                                $this->setErrors('Your contents are contaminated with spammy domain:'.htmlspecialchars($ip), ENT_QUOTES);
                                return false;
                            }
                        }
                    }
                }
                // check if domains exist
                if(!empty($blacklist->_domains)) {
                    if($blacklist->setBlacklists(preg_split("/[\s]+/", $myModule->getConfig('surbl')))) {
                        foreach($blacklist->_domains as $domain) {
                            if($blacklist->isListed($domain)) {
                                $this->setErrors('Your contents are contaminated with spammy domain name:'.htmlspecialchars($domain), ENT_QUOTES);
                                return false;
                            }
                        }
                    }
                }
            }
            unset($blacklist);
        }

        // reference check
        if(in_array('f', $check_items)) {
            $references = array(
                XOOPS_URL.'/modules/'.$this->mydirname_.'/details.php?bid='.$this->getVar('bid'),
                XOOPS_URL.'/modules/'.$this->mydirname_.'/tb.php/'.$this->tbkey_
            );

            // check the remote site
            $contents = $this->_getContents($this->getVar('url'));
            if(!$contents) {
                $this->setErrors('Could not reach your blog url.');
                return false;
            }

            $ref = false;
            foreach($references as $reference) {
                if(false !== strpos($contents, $reference)) {
                    $ref = true;
                    break;
                }
            }
            if(!$ref) {
                $this->setErrors('No reference to me in your blog. ');
                return false;
            }
        }

        return true;
    }

    function sendWeblogUpdateping($parsed_url, $timeout = 0) {
        $rpc_server = $parsed_url['scheme'].$parsed_url['host'].$parsed_url['path'];
        $fp = fsockopen($parsed_url['host'], 80, $errno, $errstr, $timeout);

        if (!$fp) {
            $this->setErrors('Connection to RPC server '
                            . htmlspecialchars($rpc_server, ENT_QUOTES) . ':' . 80
                            . ' failed. ' . $errstr);
            return false;
        }

        if($timeout) {
            stream_set_timeout($fp, $timeout);
        }

        $updateping_body = $this->_getUpdatepingBody();
        $updateping_headers = $this->_getUpdatepingHeader($parsed_url, strlen($updateping_body));
        $op  = $updateping_headers . "\r\n\r\n" . $updateping_body;
        if(!fputs($fp, $op, strlen($op))) {
            $this->setErrors('Transmission to RPC server '
                            . htmlspecialchars($rpc_server, ENT_QUOTES) . ':' . 80
                            . ' failed. ');
            return false;
        }
//        $response = fread($fp , 4095);
        $meta = stream_get_meta_data($fp);
        if ($meta['timed_out']) {
            fclose($fp);
            $this->setErrors('RPC server:'.htmlspecialchars($rpc_server, ENT_QUOTES).' did not send response before timeout.');
            return false;
        }
        //error_log($response . "\n" , 3 , 'd:/tmp/debug.log');
        fclose($fp);
        return true;
    }

    function _getUpdatepingBody() {
        // each rss
        $body =<<<EOD
<?xml version="1.0" encoding="UTF-8" ?>
<methodCall>
<methodName>weblogUpdates.ping</methodName>
<params>
<param>
<value>%s</value>
</param>
<param>
<value>%s</value>
</param>
</params>
</methodCall>
EOD;

         return str_replace("\n", "\r\n", sprintf($body, xoops_utf8_encode($this->getVar('blog_name')), xoops_utf8_encode($this->getVar('url'))));
    }

    function _getUpdatepingHeader($parsed_url, $length) {
        $headers = 'POST ';
        $headers .= $parsed_url['path']. " HTTP/1.0\r\n";
        $headers .= "User-Agent: XOOPSCUBE D3BLOG\r\n";
        $headers .= 'Host: ' . $parsed_url['host'] . "\r\n";
        $headers .= "Content-Type: text/xml\r\n";
        $headers .= 'Content-Length: ' . $length;
        return $headers;
    }

    function _extractURLs($string) {
        $urls = '(?:http|file|ftp)';
        $ltrs = 'a-z0-9';
        $gunk = '.-';
        $punc = $gunk;
        $any = "$ltrs$gunk";
/*        $regex = "{
                      $urls   ://
                      [$any]+


                      (?=
                        [$punc]*
                        [^$any]
                      |
                      )
                  }x";*/
        $regex = "/(?:http|https|file|ftp)://[A-Za-z0-9.-]+(?=[.-]*[^A-Za-z0-9.-]|)/x";
        $urls = array();
        if (0 !== preg_match_all($regex, $string, $matches)) {
            foreach ($matches[0] as $match) {
                $urls[] = $match;
            }
        }
        return array_unique($urls);
    }

    function _makeString($elements) {
        $str = '';
        foreach($elements as $element) {
            if($this->vars[$element] && $this->getVar($element)) {
                $str .= $this->getVar($element);
            }
        }
        return $str;
    }

    function _checkItems() {
        foreach(array_keys($this->_data) as $key) {
            if(!isset($this->vars[$key]) || !$this->getVar($key)) {
                $this->setErrors($key.' is not found in your trackback. ');
                return false;
            }
        }
        if(!d3blog_validateUrl($this->getVar('url'))) {
            $this->setErrors('Invalid url. ');
            return false;
        }
        return true;
    }

    function _getContents($url) {
        // check the remote site
        $snoopy = new Snoopy();
        if($snoopy->fetch($url)) {
            return $snoopy->results;
        } else {
            $this->setErrors($snoopy->error);
            unset($snoopy);
            return false;
        }
    }

    function _interpreteTrackbackResponse($response)
    {
        if (!preg_match('@<error>([0-9]+)</error>@', $response, $matches)) {
            $this->setErrors('Invalid trackback response, error code not found.');
            return false;
        }
        $errorCode = $matches[1];

        // Error code 0 means no error.
        if ($errorCode == 0) {
            return true;
        }

        if (!preg_match('@<message>([^<]+)</message>@', $response, $matches)) {
            $this->setErrors('Error code '.$errorCode.', no message received.');
        }

        $this->setErrors('Error code '.$errorCode.', message "'.$matches[1].'" received.');
        return false;
    }

}

class d3blogTrackbackObjectHandlerBase extends myXoopsObjectHandler
{
    var $mydirname_;
    var $filter_;

    function d3blogTrackbackObjectHandlerBase($db,$classname=null) {
        parent::myXoopsObjectHandler($db,$classname);
        $this->mydirname_ = '';
    }

    function getId() {
        if (array_key_exists('PATH_INFO', $_SERVER)) {
            $pathinfo = $_SERVER['PATH_INFO'];
        } else {
            $pathinfo = '';
        }

        if (substr($pathinfo, 0, 1) == '/') {
            $id = substr($pathinfo, 1);
        } else {
            return false;
        }

        $pos = strpos($id, '/');
        if ($pos != false) {
            $id = substr($id, 0, $pos);
        }
        return str_replace("\0", "", $id);
    }



    function getDefaultCriteria() {
        // get a default trackback criteria thru filter
        $this->filter_ = call_user_func(array($this->mydirname_.'TrackbackFilter', 'getInstance'));
        $criteria =& $this->filter_->getDefaultCriteria();
        return $criteria;
    }

    function getCriteria() {
        // get trackback criteria thru filter
        $this->filter_ = call_user_func(array($this->mydirname_.'TrackbackFilter', 'getInstance'));
        $criteria =& $this->filter_->getCriteria();
        return $criteria;
    }

    function getTrackback($bid, $boundfor=null, $as_object=false) {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $return = array();

        if(empty($bid))
            return $return;

        $this->filter_ = call_user_func(array($this->mydirname_.'TrackbackFilter', 'getInstance'));
        $criteria = $this->filter_->getCriteria();

        $criteria->add(new criteria('bid', intval($bid)));

        if($boundfor)
            $criteria->add(new criteria('direction', intval($boundfor)));
        else
            $criteria->add(new criteria('direction', '0', '<>'));

        $objs =& $this->getObjects($criteria);

        if(count($objs)) {
            foreach($objs as $obj) {
                $direction = $obj->getVar('direction')==1? 'outbound' : 'inbound';
                if(!$as_object) {
                    $return[$direction][$obj->getVar('tid')] = $obj->getStructure();
                } else {
                    $return[$direction][$obj->getVar('tid')] = $obj;
                }
            }
        }
        return $return;
    }

    function getByTbkey($id) {
        $myts =& d3blogTextSanitizer:: getInstance();
        $criteria = new criteriaCompo(new criteria('tbkey', $myts->addSlashes($id)));
        return $this->getOne($criteria);
    }

    // purge old trackback key. works every 10 times by default
    function garbageTrackbackKey($per=10, $expiration=86400){
        $per=intval($per);
        if(rand(0,100) >  $per){
            return null ;
        }
        $expiration = inyval($expiration);
        $sql = sprintf('delete from %s where direction=\'0\' and created<%d',
                       $this->db->prefix($this->mydirname_.'_trackback'), time()-$expiration ); // default 1 day
        $this->db->query($sql);
    }

    function getPingList($rss)
    {
        // each rss
        $items = '';
        if(isset($rss['items']) && is_array($rss['items'])) {
            $item = <<<EOF
<item>
<title>%s</title>
<link>%s</link>
<description>%s</description>
</item>
EOF;
            foreach($rss['items'] as $r) {
                $items .= sprintf($item, $r['title'], $r['url'], $r['excerpt']);
            }
        }

        $res = <<<EOD
<?xml version="1.0" encoding="%s"?>
<response>
<error>0</error>
<rss version="0.91">
<channel>
<title>%s</title>
<link>%s</link>
<description>%s</description>
<language>%s</language>
%s
</channel>
</rss>
</response>
EOD;
        return sprintf($res, $rss['encoding'], $rss['title'], $rss['url'], $rss['excerpt'],
                              $rss['language'], $items);
    }

    function insert(&$obj, $force=false)
    {
        return parent::insert($obj, $force);
    }

    function delete(&$obj, $force=false) {
        return parent::delete($obj, $force);
    }

    function deletes($criteria = null)
    {
        parent::deletes($criteria);
    }

}
}

if( ! class_exists($object_class_name) ) {
require dirname(dirname(__FILE__)).'/include/filter/TrackbackFilter.class.php';
eval('
class '. $object_class_name .' extends d3blogTrackbackObjectBase {
    function '. $object_class_name .'($id=null) {
        $this->mydirname_ = "'.$mydirname.'";
        $this->d3blogTrackbackObjectBase();
    }
    function getTableInfo() {
        $tinfo = new myTableInfomation("'.$mydirname.'_trackback", "tid");
        return ($tinfo);
    }
}
');
eval('
class '. $object_class_name .'Handler extends d3blogTrackbackObjectHandlerBase {
    var $mydirname_;
    function '. $object_class_name .'Handler($db) {
        parent::myXoopsObjectHandler($db, "'. $object_class_name .'");
        $this->mydirname_ = "'.$mydirname.'";
    }
}
');
}

?>
