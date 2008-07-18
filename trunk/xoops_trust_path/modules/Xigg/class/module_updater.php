<?php
require_once 'SabaiXOOPS/ModuleInstaller.php';

class xigg_xoops_module_updater extends SabaiXOOPS_ModuleInstaller
{
    var $_app;
    var $_lastVersion;

    function xigg_xoops_module_updater(&$app, $lastVersion)
    {
        parent::SabaiXOOPS_ModuleInstaller('Legacy.Admin.Event.ModuleUpdate.%s.Success', 'Legacy.Admin.Event.ModuleUpdate.%s.Fail', 'msgs');
        $this->_app =& $app;
        $this->_lastVersion = $lastVersion;
    }

    function _doExecute(&$module)
    {
        // update database schema
        $this->addLog('Updating database tables...');

        // Version prior to 1.10 has int(10) for the primary key, which needs to be
        // changed to bigint(20) manually, which is the default integer column created by
        // MDB2_Schema, because MDB2 fails to alter primary key column (?) as of version 2.5.0b1
        if ($this->_lastVersion < 110) {
            $db =& $this->_app->locator->getService('DB');
            $db->beginTransaction();
            foreach (array('access', 'category', 'comment', 'node', 'node2tag', 'plugin', 'tag', 'trackback', 'vote') as $name) {
                $sql = sprintf('ALTER TABLE %1$s%2$s CHANGE %2$s_id %2$s_id BIGINT(20) UNSIGNED NOT NULL', $db->getResourcePrefix(), $name);
                if (false === $db->exec($sql)) {
                    $db->rollback();
                    return false;
                }
                $sql = sprintf('ALTER TABLE %1$s%2$s DROP PRIMARY KEY', $db->getResourcePrefix(), $name);
                if (false === $db->exec($sql)) {
                    $db->rollback();
                    return false;
                }
            }
            $db->commit();
        }

        $schema_new = $schema_old = array();
        $schema_dir = XOOPS_TRUST_PATH . '/modules/Xigg/schema/';
        if (!$dh = opendir($schema_dir)){
            $this->addLog('Failed opening schema directory.');
            return false;
        }
        while ($file = readdir($dh)) {
            if (preg_match('/^\d+(?:\.\d+)*(?:\d*)?\.xml$/', $file)) {
                $file_version = round(100 * basename($file, '.xml'));
                if ($file_version > $this->_lastVersion) {
                    $schema_new[$file_version] = $schema_dir . $file;
                } else {
                    $schema_old[$file_version] = $schema_dir . $file;
                }
            }
        }
        closedir($dh);
        if (!empty($schema_new) && !empty($schema_old)) {
            ksort($schema_old, SORT_NUMERIC);
            ksort($schema_new, SORT_NUMERIC);
            // get the last previous schema file
            $previous_schema = array_pop($schema_old);
            require_once 'Sabai/DB/Schema.php';
            $schema =& Sabai_DB_Schema::factory($this->_app->locator->getService('DB'));
            // update schema incrementally
            foreach ($schema_new as $new_schema) {
                if (!$schema->update($new_schema, $previous_schema)) {
                    $this->addLog(sprintf('Failed updating database schema from %s to %s. Error: %s', str_replace($schema_dir, '', $previous_schema), str_replace($schema_dir, '', $new_schema), $schema->getError()));
                    return false;
                }
                $this->addLog(sprintf('Updated database schema from %s to %s', str_replace($schema_dir, '', $previous_schema), str_replace($schema_dir, '', $new_schema)));
                $previous_schema = $new_schema;
            }
        }
        return true;
    }
}