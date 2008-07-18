<?php
//require_once 'MDB2/Schema.php';
require_once 'Sabai/DB/MDB2Schema.php';
require_once 'Sabai/DB/SchemaParser.php';

class Sabai_DB_Schema
{
    /**
     * @access protected
     * @var MDB2_Schema
     */
    var $_mdb2Schema;
    /**
     * @access protected
     * @var array
     */
    var $_createTableOptions;
    /**
     * @access protected
     * @var string
     */
    var $_error;

    /**
     * Constructor
     *
     * @param MDB2_Schema $mdb2Schema
     * @param array $createTableOptions
     * @return Sabai_DB_Schema
     */
    function Sabai_DB_Schema(&$mdb2Schema, $createTableOptions = array())
    {
        $this->_mdb2Schema =& $mdb2Schema;
        $this->_createTableOptions = $createTableOptions;
    }

    /**
     * Creates a Sabai_DB_Schema instance
     *
     * @static
     * @param Sabai_DB $db
     * @param array $options
     * @return mixed Sabai_DB_Schema on success, PEAR_Error on failure
     */
    function &factory(&$db, $options = array())
    {
        $default = array(
                     'log_line_break' => '<br>',
                     'idxname_format' => '%s',
                     'debug' => true,
                     'quote_identifier' => true,
                     'force_defaults' => false,
                     'portability' => false,
                     'parser' => 'Sabai_DB_SchemaParser'
                   );
        //$mdb2_schema =& MDB2_Schema::factory($db->getMDB2SchemaDSN(), array_merge($default, $options));
        $schema_options = array(
                            'create_table_options' => $db->getMDB2CreateTableOptions(),
                            'parser_options'       => array(
                                                        'table_prefix'  => $db->getResourcePrefix(),
                                                        'database_name' => $db->getResourceName()
                                                      ),
                          );
        $mdb2_schema =& Sabai_DB_MDB2Schema::factory($db->getMDB2SchemaDSN(), $schema_options, array_merge($default, $options));
        if (PEAR::isError($mdb2_schema)) {
            return $mdb2_schema;
        }
        $schema =& new Sabai_DB_Schema($mdb2_schema, $db->getMDB2CreateTableOptions());
        return $schema;
    }

    function create($schemaFile)
    {
        $definition = $this->_mdb2Schema->parseDatabaseDefinitionFile($schemaFile);
        if (PEAR::isError($definition)) {
            $this->_setError($definition);
            return false;
        }
        $result = $this->_mdb2Schema->createDatabase($definition, $this->_createTableOptions);
        if (PEAR::isError($result)) {
            $this->_setError($result);
            return false;
        }
        return true;
    }

    function update($schemaFile, $previousSchemaFile)
    {
        $result = $this->_mdb2Schema->updateDatabase($schemaFile, $previousSchemaFile);
        if (PEAR::isError($result)) {
            $this->_setError($result);
            return false;
        }
        return true;
    }

    function drop($previousSchemaFile)
    {
        $changes = array();
        $definition = $this->_mdb2Schema->parseDatabaseDefinitionFile($previousSchemaFile);
        foreach (array_keys($definition['tables']) as $table_name) {
            $changes['tables']['remove'][$table_name] = true;
        }
        foreach (array_keys($definition['sequences']) as $sequence_name) {
            $changes['sequences']['remove'][$sequence_name] = true;
        }
        $result = $this->_mdb2Schema->alterDatabase($definition, $definition, $changes);
        if (PEAR::isError($result)) {
            $this->_setError($result);
            return false;
        }
        return true;
    }

    function _setError(&$pearError)
    {
        $this->_error = sprintf('%s(%s)', $pearError->getMessage(), $pearError->getUserInfo());
    }

    function getError()
    {
        return $this->_error;
    }
}
