<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Controller
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.2.0
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Controller
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.2.0
 */
class Sabai_Controller_UserIdentityPaginate extends Sabai_Controller
{
    /**
     * @var array
     * @access protected
     */
    var $_options;

    /**
     * Constructor
     *
     * @param array $options
     * @return Sabai_Controller_UserIdentityPaginate
     */
    function Sabai_Controller_UserIdentityPaginate($options = array())
    {
        $default = array('viewName'            => null,
                         'tplVarPages'         => 'identity_pages',
                         'tplVarSortKey'       => 'identity_sort_key',
                         'tplVarSortOrder'     => 'identity_sort_order',
                         'tplVarPageRequested' => 'identity_page_requested',
                         'tplVarIdentities'    => 'identity_objects',
                         'perpage'             => 20,
                   );
        $this->_options = array_merge($default, $options);
    }

    /**
     * Executes the action
     *
     * @param Sabai_Controller_Context $context
     */
    function _doExecute(&$context)
    {
        $sort_key = $this->_getRequestedSort($context->request);
        $sort_order = $this->_getRequestedOrder($context->request);
        $page_num = $this->_getRequestedPage($context->request);

        $identity_fetcher =& $this->_getUserIdentityFetcher($context);
        $pages =& $identity_fetcher->paginateIdentities(intval($this->_options['perpage']), $sort_key, $sort_order);
        $page =& $pages->getValidPage($page_num);
        $identities =& $this->_onPaginateIdentities($page->getElements(), $context);
        $context->response->setVars(array(
                                 $this->_options['tplVarPages']         => &$pages,
                                 $this->_options['tplVarSortKey']       => $sort_key,
                                 $this->_options['tplVarSortOrder']     => $sort_order,
                                 $this->_options['tplVarPageRequested'] => $page_num,
                                 $this->_options['tplVarIdentities']    => &$identities));

        if (!empty($this->_options['viewName'])) {
            $context->response->popContentName();
            $context->response->pushContentName($this->_options['viewName']);
        }
    }

    function _getRequestedPage(&$request)
    {
        return $request->getAsInt('page', 1, null, 0);
    }

    function _getRequestedSort(&$request)
    {
        return $request->getAsStr('sort', 'id', array('id', 'name'));
    }

    function _getRequestedOrder(&$request)
    {
        return $request->getAsStr('order', 'ASC', array('ASC', 'DESC'));
    }

    /**
     * Callback method called just before viewing the list of identities
     *
     * @return Sabai_Iterator
     * @param Sabai_Iterator $identities
     * @param Sabai_Controller_Context $context
     * @access protected
     */
    function &_onPaginateIdentities(&$identities, &$context)
    {
        return $identities;
    }

    /**
     * Returns the user identity fetcher object
     *
     * @access protected
     * @return Sabai_User_IdentityFetcher
     * @param Sabai_Controller_Context
     */
    function &_getUserIdentityFetcher(&$context)
    {
    }
}