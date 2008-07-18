<?php
require_once 'SabaiXOOPS/ModuleInstaller.php';

class xigg_xoops_module_uninstaller extends SabaiXOOPS_ModuleInstaller
{
    var $_app;
    var $_lastVersion;

    function xigg_xoops_module_uninstaller(&$app, $lastVersion)
    {
        parent::SabaiXOOPS_ModuleInstaller('Legacy.Admin.Event.ModuleUninstall.%s.Success', 'Legacy.Admin.Event.ModuleUninstall.%s.Fail');
        $this->_app =& $app;
        $this->_lastVersion = $lastVersion;
    }

    function _doExecute(&$module)
    {
        // remove files in cache directories
        $this->addLog('Removing cache files...');
        $cache_root = $this->_app->config->get('cacheDir');
        foreach (array('HTMLPurifier/HTML', 'HTMLPurifier/CSS', 'HTMLPurifier/URI', 'Cache_Lite') as $dir) {
            if ($dh = opendir($cache_dir = $cache_root . '/' . $dir)) {
                $this->addLog(sprintf('Removing cache files under %s.', $cache_dir));
                while (false !== $file = readdir($dh)) {
                    if (!in_array($file, array('index.html', '.htaccess'))
                          && is_file($cache_file = $cache_dir . '/' . $file)) {
                        if (!@unlink($cache_file)) {
                            $this->addLog(sprintf('Failed removing cache file %s.', $cache_file));
                        } else {
                            $this->addLog(sprintf('Removed cache file %s.', $cache_file));
                        }
                    }
                }
                closedir($dh);
            }
        }

        $this->addLog('Deleting database tables...');
        $schema_old = array();
        $schema_dir = XOOPS_TRUST_PATH . '/modules/Xigg/schema/';
        if (!$dh = opendir($schema_dir)) {
            return false;
        }
        while ($file = readdir($dh)) {
            if (preg_match('/^\d+(?:\.\d+)*(?:\d*)?\.xml$/', $file)) {
                $file_version = round(100 * basename($file, '.xml'));
                if ($file_version <= $this->_lastVersion) {
                    $schema_old[$file_version] = $schema_dir . $file;
                }
            }
        }
        closedir($dh);
        if (!empty($schema_old)) {
            ksort($schema_old, SORT_NUMERIC);
            // get the last previous schema file
            $previous_schema = array_pop($schema_old);
        } else {
            $previous_schema = $this->_app->getPath() . '/schema/latest.xml';
        }
        require_once 'Sabai/DB/Schema.php';
        $schema =& Sabai_DB_Schema::factory($this->_app->locator->getService('DB'));
        if (!$result = $schema->drop($previous_schema)) {
            $this->addLog(sprintf('Failed deleting database tables using schema %s. Error: %s', str_replace($schema_dir, '', $previous_schema), $schema->getError()));
        } else {
            $this->addLog(sprintf('Deleted database tables using schema %s.', str_replace($schema_dir, '', $previous_schema)));
        }
        return $result;
    }
}