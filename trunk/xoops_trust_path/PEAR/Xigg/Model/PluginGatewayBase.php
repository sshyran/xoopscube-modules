<?php
/*
This file has been generated by the Sabai scaffold script. Do not edit this file directly.
If you need to customize the class, use the following file:
Xigg/library/Xigg/Model/PluginGateway.php
*/
class Xigg_Model_PluginGatewayBase extends Sabai_Model_Gateway
{
    function getName()
    {
        return 'plugin';
    }

    function getFields()
    {
        return array('plugin_id' => SABAI_MODEL_KEY_TYPE_INT, 'plugin_created' => SABAI_MODEL_KEY_TYPE_INT, 'plugin_updated' => SABAI_MODEL_KEY_TYPE_INT, 'plugin_name' => SABAI_MODEL_KEY_TYPE_VARCHAR, 'plugin_version' => SABAI_MODEL_KEY_TYPE_VARCHAR, 'plugin_active' => SABAI_MODEL_KEY_TYPE_INT, 'plugin_params' => SABAI_MODEL_KEY_TYPE_TEXT, 'plugin_priority' => SABAI_MODEL_KEY_TYPE_INT, 'plugin_locked' => SABAI_MODEL_KEY_TYPE_INT);
    }

    function _getSelectByIdQuery($id, $fields)
    {
        $fields = empty($fields) ? '*' : implode(', t.', $fields);
        return sprintf('SELECT t.%s FROM %splugin t WHERE plugin_id = %d', $fields, $this->_db->getResourcePrefix(), $id);
    }

    function _getSelectByCriteriaQuery($criteriaStr, $fields)
    {
        $fields = empty($fields) ? '*' : implode(', t.', $fields);
        return sprintf('SELECT t.%1$s FROM %2$splugin t WHERE %3$s', $fields, $this->_db->getResourcePrefix(), $criteriaStr);
    }

    function _getInsertQuery($values)
    {
        $values['plugin_created'] = time();
        $values['plugin_updated'] = 0;
        return sprintf("INSERT INTO %splugin(plugin_created, plugin_updated, plugin_name, plugin_version, plugin_active, plugin_params, plugin_priority, plugin_locked) VALUES(%d, %d, %s, %s, %d, %s, %d, %d)", $this->_db->getResourcePrefix(), $values['plugin_created'], $values['plugin_updated'], $this->_db->escapeString($values['plugin_name']), $this->_db->escapeString($values['plugin_version']), $values['plugin_active'], $this->_db->escapeString($values['plugin_params']), $values['plugin_priority'], $values['plugin_locked']);
    }

    function _getUpdateQuery($id, $values)
    {
        $last_update = $values['plugin_updated'];
        $values['plugin_updated'] = time();
        return sprintf("UPDATE %splugin SET plugin_updated = %d, plugin_name = %s, plugin_version = %s, plugin_active = %d, plugin_params = %s, plugin_priority = %d, plugin_locked = %d WHERE plugin_id = %d AND plugin_updated = %d", $this->_db->getResourcePrefix(), $values['plugin_updated'], $this->_db->escapeString($values['plugin_name']), $this->_db->escapeString($values['plugin_version']), $values['plugin_active'], $this->_db->escapeString($values['plugin_params']), $values['plugin_priority'], $values['plugin_locked'], $id, $last_update);
    }

    function _getDeleteQuery($id)
    {
        return sprintf('DELETE FROM %1$splugin WHERE plugin_id = %2$d', $this->_db->getResourcePrefix(), $id);
    }

    function _getUpdateByCriteriaQuery($criteriaStr, $sets)
    {
        $sets['plugin_updated'] = 'plugin_updated=' . time();
        return sprintf('UPDATE %splugin SET %s WHERE %s', $this->_db->getResourcePrefix(), implode(',', $sets), $criteriaStr);
    }

    function _getDeleteByCriteriaQuery($criteriaStr)
    {
        return sprintf('DELETE FROM %1$splugin WHERE %2$s', $this->_db->getResourcePrefix(), $criteriaStr);
    }

    function _getCountByCriteriaQuery($criteriaStr)
    {
        return sprintf('SELECT COUNT(*) FROM %1$splugin WHERE %2$s', $this->_db->getResourcePrefix(), $criteriaStr);
    }
}