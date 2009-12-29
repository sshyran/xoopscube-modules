<?php
/**
 * @version $Id: blacklist.class.php 398 2008-03-26 02:20:50Z hodaka $
 */

class Blacklist
{
    var $_blacklists = array();
    var $_ips;
    var $_domains;
    var $_doubleCcTldFile = 'http://spamcheck.freeapp.net/two-level-tlds';
    
    function setBlacklists($blacklists)
    {
        if (is_array($blacklists)) {
            $this->_blacklists = $blacklists;
            return true;
        } else {
            return false;
        }
    }

    function isListed($host)
    {
        foreach ($this->_blacklists as $blacklist) {
            $built_host = $host. '.'. $blacklist;
            $ret = gethostbyname($built_host);
            if($ret != $built_host) {
//            if( strstr($ret, '127.0.0.') !== false ) {
                return true;
            }
        }
        return false;
    }

    function reverseIP($ip) 
    {        
        return implode('.', array_reverse(explode('.', $ip)));        
    }

    function checkIP($ip)
    {
        $oct = explode('.', $ip);
        if (count($oct) != 4) {
            return false;
        }
        for ($i = 0; $i < 4; $i++) {
            if (!preg_match("/^[0-9]+$/", $oct[$i])) {
                return false;
            }
            if ($oct[$i] < 0 || $oct[$i] > 255) {
                return false;
            }
        }
        return true;
    }


    function getIP()
    {
        $ip = 'unknown';
        $ip_array = array();
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strpos($_SERVER['HTTP_X_FORWARDED_FOR'],',')) {
            $ip_array +=  explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
            $ip_array[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '') {
            $ip_array[] = $_SERVER['REMOTE_ADDR'];
        }
        
        foreach ( $ip_array as $ip_s ) {
            if( !empty($ip_s) && !$this->_isPrivateNet($ip_s)){
                $ip = $ip_s;
                break;
            }
        }
        return $ip;
    }

    function _isPrivateNet($ip)
    {
        $private_ips = array(
           '127.0.0.0/8',
           '10.0.0.0/8',
           '172.16.0.0/12',
           '192.168.0.0/16'
        );

        foreach ($private_ips as $private) {
            list($net, $mask) = split('/', $private);
            if($this->_isIpInNet($ip, $net, $mask)){
                return true;
            }
        }
        return false;
    }

    function _isIpInNet($ip, $net, $mask)
    {
        $long_net = ip2long($net);
        $long_ip =  ip2long($ip);
        $binary_net = str_pad( decbin($long_net), 32, '0', 'STR_PAD_LEFT');
        $firstpart = substr($binary_net, 0, $mask);
        $binary_ip = str_pad( decbin($long_ip), 32, '0', 'STR_PAD_LEFT');
        $firstip = substr($binary_ip, 0, $mask);
        return (strcmp($firstpart, $firstip) == 0);
    }



    function buildLookupDomain($urls) {
        foreach($urls as $url) {
            // extract the hostname from the given URI
            $parsed_url = parse_url($url);
            $host = $parsed_url['host'];


            // check if the "hostname" is an ip
            if($this->checkIP($host)) {
                $this->_ips[] = $this->reverseIP($host);
            } else {
                $this->_domains[] = $this->_stripDomainPrefixes($host);
            }
        }
        $this->_ips = array_unique($this->_ips);
        $this->_domains = array_unique($this->_domains);
    }

    function _stripDomainPrefixes($host) {
        static $doubleLevelTlds = array();
        if (empty($doubleLevelTlds)) {
            $doubleLevelTlds = $this->_getDoubleCcTld();
        }

        $host_elements = explode('.', $host);
        while (count($host_elements) > 3) {
            array_shift($host_elements);
        }
        $host_3_elements = implode('.', $host_elements);
        
        $host_elements = explode('.', $host);
        while (count($host_elements) > 2) {
            array_shift($host_elements);
        }
        $host_2_elements = implode('.', $host_elements);
            
        // check if is in "CC-2-level-TLD"
        return (array_key_exists($host_2_elements, $doubleLevelTlds))? $host_3_elements : $host_2_elements;
    }


    function _getDoubleCcTld()
    {
        $duration = 2592000;    // 30 days
        $cache_path = XOOPS_TRUST_PATH . '/cache';
        $cache_file = $cache_path.'/two_level_tld_'.substr(md5($this->_doubleCcTldFile), 0, 12);
        $cache_file_mtime = file_exists($cache_file) ? filemtime($cache_file) : 0 ;
        if(!file_exists($cache_file) || $cache_file_mtime < time() - $duration) {
            $snoopy = new Snoopy;
            if($snoopy->fetch($this->_doubleCcTldFile)) {
                $contents = $snoopy->results;
            } else {
//                $this->setErrors('Could not get doubleCcTld data: '.$snoopy-error);
                return array();
            }
            
            $fp = fopen($cache_file, 'wb');
            if(!$fp) return array();
            fwrite($fp, $contents) ;
            fclose($fp) ;
            
        } else {
            $fp = fopen($cache_file, 'rb');
            $contents = fread($fp, filesize($cache_file));
            fclose($fp);
        }

        $data = explode("\n", $contents);
        return array_flip($data);        
    }


}
?>