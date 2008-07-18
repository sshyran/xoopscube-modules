<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Service
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.10
*/

require_once 'Sabai/DB.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Service
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.10
 */
class Sabai_Service_Provider_DB extends Sabai_Service_Provider
{
    /**
     * Constructor
     *
     * @param string $scheme
     * @param string $tablePrefix
     * @param string $clientEncoding
     * @param array $options
     * @return Sabai_Service_Provider_DB
     */
    function Sabai_Service_Provider_DB($scheme, $tablePrefix, $clientEncoding, $options)
    {
        parent::Sabai_Service_Provider(array(
                                         'scheme'         => $scheme,
                                         'tablePrefix'    => $tablePrefix,
                                         'clientEncoding' => $clientEncoding,
                                         'options'        => $options
                                       )
                                      );
    }

    function &_doGetService($params, $services)
    {
        $db =& Sabai_DB::factory($params['scheme'], $params['tablePrefix'], $params['clientEncoding'], $params['options']);
        return $db;
    }
}