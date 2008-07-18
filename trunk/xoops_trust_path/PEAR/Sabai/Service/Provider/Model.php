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

require_once 'Sabai/Model.php';

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
class Sabai_Service_Provider_Model extends Sabai_Service_Provider
{
    /**
     * Constructor
     *
     * @param string $modelPrefix
     * @param string $modelDir
     * @return Sabai_Service_Provider_Model
     */
    function Sabai_Service_Provider_Model($modelPrefix, $modelDir)
    {
        parent::Sabai_Service_Provider(array(
                                         'modelPrefix' => $modelPrefix,
                                         'modelDir'    => $modelDir,
                                       ),
                                       array('DB', 'UserIdentityFetcher')
                                      );
    }

    function &_doGetService($params, $services)
    {
        $model =& new Sabai_Model($params['modelDir'], $params['modelPrefix']);
        $model->setDB($services['DB']);
        $model->setUserIdentityFetcher($services['UserIdentityFetcher']);
        return $model;
    }
}