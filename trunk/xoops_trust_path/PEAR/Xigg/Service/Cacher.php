<?php
require_once 'Cache/Lite.php';

class Xigg_Service_Cacher extends Sabai_Service_Provider
{
    function Xigg_Service_Cacher($cacheDir)
    {
        parent::Sabai_Service_Provider(array('cacheDir' => $cacheDir));
    }

    function &_doGetService($params, $services)
    {
        if (empty($params['cacheDir']) || !is_dir($params['cacheDir'])) {
            die('Invalid cache directory.');
        }
        if (!is_writable($params['cacheDir'])) {
            die(sprintf('The cache directory %s must be configured writeable by the server.', $params['cacheDir']));
        }
        $cacher =& new Cache_Lite($params);
        return $cacher;
    }
}