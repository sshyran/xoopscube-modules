<?php
/**
 * Front Controller
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Controller
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.2.0
 * @abstract
 */
class Sabai_Controller_Filter
{
    /**
     * Pre execution filter
     *
     * @param Sabai_Controller_Context $context
     */
    function before(&$context){}

    /**
     * Post execution filter
     *
     * @param Sabai_Controller_Context $context
     */
    function after(&$context){}
}