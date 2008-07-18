<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_User
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_User
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 * @abstract
 */
class Sabai_User_IdentityFetcher
{
    var $_idField;
    var $_nameField;

    /**
     * Constructor
     *
     * @param string $idField
     * @param string $nameFiled
     * @return Sabai_User_IdentityFetcher
     */
    function Sabai_User_IdentityFetcher($idField = 'id', $nameFiled = 'name')
    {
        $this->_idField = $idField;
        $this->_nameField = $nameFiled;
    }

    /**
     * Fetches user identity objects by user ids
     *
     * @param array $userids
     * @return array array of Sabai_User_Identity objects indexed by user id
     * @staticvar $identities;
     */
    function fetchUserIdentities($userids)
    {
        static $identities = array();
        // only fetch that are not already fetched
        if ($userids = array_diff($userids, array_keys($identities))) {
            $identities = $identities + $this->_doFetchUserIdentities($userids);
        }
        return $identities;
    }

    /**
     * Paginate user identity objects
     *
     * @param int $perpage
     * @param string $sort
     * @param string $order
     * @return Sabai_User_IdentityPageCollection
     */
    function &paginateIdentities($perpage = 20, $sort = 'id', $order = 'ASC', $key = 0)
    {
        require_once 'Sabai/User/IdentityPageCollection.php';
        $pages =& new Sabai_User_IdentityPageCollection($this, $perpage, $sort, $order, $key);
        return $pages;
    }

     /**
     * Fetches user identity objects
     *
     * @return Sabai_Iterator_Array
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     */
    function &fetchIdentities($limit, $offset, $sort, $order)
    {
        $order = in_array($order, array('ASC', 'DESC')) ? $order : 'ASC';
        switch ($sort) {
            case 'name':
                $sort = $this->_nameField;
                break;
            case 'id':
            default:
                $sort = $this->_idField;
        }
        require_once 'Sabai/Iterator/Array.php';
        $iterator =& new Sabai_Iterator_Array($this->_doFetchIdentities(intval($limit), intval($offset), $sort, $order));
        return $iterator;
    }

    /**
     * Fetches user identity objects
     *
     * @return array
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $order
     * @abstract
     */
    function _doFetchIdentities($limit, $offset, $sort, $order){}

    /**
     * Counts user identities
     *
     * @return int
     * @abstract
     */
    function countIdentities(){}

    /**
     * Fetches user identity objects by user ids
     *
     * @abstract
     * @param array $userids
     * @return array array of Sabai_User_Identity objects indexed by user id
     */
    function _doFetchUserIdentities($userids){}
}