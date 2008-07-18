<?php
require_once 'SabaiXOOPS/ModuleInstaller.php';

class xigg_xoops_module_installer extends SabaiXOOPS_ModuleInstaller
{
    var $_app;

    function xigg_xoops_module_installer(&$app)
    {
        parent::SabaiXOOPS_ModuleInstaller();
        $this->_app =& $app;
    }

    function _doExecute(&$module)
    {
        // init cache directories
        $this->addLog('Initializing cache directories...');
        $cache_root = $this->_app->config->get('cacheDir');
        foreach (array('HTMLPurifier/HTML', 'HTMLPurifier/CSS', 'HTMLPurifier/URI', 'Cache_Lite') as $dir) {
            if (!is_writable($cache_dir = $cache_root . '/' . $dir)) {
                if (!@chmod($cache_dir, 0777)) {
                    $this->addLog(sprintf('Failed setting permission of cache directory %s to 0777. Please manually set the permission of this directory to 0777.', $cache_dir));
                } else {
                    $this->addLog(sprintf('Setting permission of cache directory %s to 0777', $cache_dir));
                }
            } else {
                $this->addLog(sprintf('Cache directory %s is writable.', $cache_dir));
            }
        }

        // create database tables
        $this->addLog('Creating database tables...');
        require_once 'Sabai/DB/Schema.php';
        $schema =& Sabai_DB_Schema::factory($this->_app->locator->getService('DB'));
        if (!$result = $schema->create($this->_app->getPath() . '/schema/latest.xml')) {
            $this->addLog(sprintf('Failed creating database tables using schema. Error: %s', $schema->getError()));
        } else {
            $this->addLog('Database tables created');
        }
        return $result;
    }
}