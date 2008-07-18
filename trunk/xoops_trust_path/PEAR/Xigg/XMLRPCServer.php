<?php
require_once 'XML/RPC/Server.php';

class Xigg_XMLRPCServer
{
    var $_locator;
    var $_loginUserFunc;
    var $_methods = array();

    function Xigg_XMLRPCServer(&$locator, $loginUserFunc)
    {
        $this->_locator =& $locator;
        $this->_loginUserFunc = $loginUserFunc;
        $this->_addMethod('metaWeblog.newPost');
        $this->_addMethod('metaWeblog.editPost');
        $this->_addMethod('metaWeblog.getPost');
        $this->_addMethod('metaWeblog.getCategories');
        $this->_addMethod('metaWeblog.getRecentPosts');
        $this->_addMethod('metaWeblog.newMediaObject');
        $this->_addMethod('nodeger.deletePost');
        $this->_addMethod('nodeger.getUsersBlogs');
        $this->_addMethod('mt.getPostCategories');
        $this->_addMethod('mt.setPostCategories');
        $this->_addMethod('mt.getCategoryList');
        $this->_addMethod('mt.supportedTextFilters');
        $this->_addMethod('mt.publishPost');
        // adding aliases
        $this->_addMethod('metaWeblog.deletePost', 'nodeger_deletePost');
        $this->_addMethod('metaWeblog.getUsersBlogs', 'nodeger_getUsersBlogs');
    }

    function service()
    {
        $server =& new XML_RPC_Server($this->_methods, 0);
        $server->setConvertPayloadEncoding(false);
        $server->service();
    }

    function _addMethod($serviceName, $methodName = null)
    {
        if (!isset($methodName)) {
            $methodName = str_replace('.', '_', $serviceName);
        }
        $this->_methods[$serviceName] = array('function' => array(&$this, $methodName));
    }

    function _execute($method, &$params)
    {
        $args = array();
        if (is_object($params)) {
            $count = $params->getNumParams();
            for ($i = 0; $i < $count; $i++) {
                $param = $params->getParam($i);
                if (!XML_RPC_Value::isValue($param)) {
                    return $param;
                }
                $args[$i] = XML_RPC_decode($param);
            }
        }
        return call_user_func_array(array(&$this, $method), $args);
    }

    function &_loginUser($username, $password)
    {
        static $user;
        if (!isset($user)) {
            $user = call_user_func_array($this->_loginUserFunc, array($username, $password));
        }
        return $user;
    }

    function &_nodeToStruct(&$node)
    {
        $link = Sabai_URL::get('/node/' . $node->getId());
        $title = $this->_encode($node->getLabel());
        $description = $this->_encode($node->get('body_html'));
        $mt_excerpt = $this->_encode($node->get('teaser_html'));
        $date = XML_RPC_iso8601_encode($node->getTimeCreated());
        $struct =& new XML_RPC_Value(
                        array('link'              => new XML_RPC_Value($link),
                              'permaLink'         => new XML_RPC_Value($link),
                              'userid'            => new XML_RPC_Value($node->getUserId()),
                              'title'             => new XML_RPC_Value($title),
                              'description'       => new XML_RPC_Value($description),
                              'postid'            => new XML_RPC_Value($node->getId()),
                              'dateCreated'       => new XML_RPC_Value($date, 'dateTime.iso8601'),
                              'mt_excerpt'        => new XML_RPC_Value($mt_excerpt),
                              'mt_text_more'      => new XML_RPC_Value(''),
                              'mt_allow_pings'    => new XML_RPC_Value($node->get('allow_trackbacks'), 'int'),
                              'mt_allow_comments' => new XML_RPC_Value($node->get('allow_comments'), 'int'),
                              'mt_convert_breaks' => new XML_RPC_Value($node->get('content_syntax')),
                              'mt_keywords'       => new XML_RPC_Value(''),
                              'mt_tags'           => new XML_RPC_Value('')),
                        'struct');
        return $struct;
    }

    function _encode($str)
    {
        return mb_convert_encoding($str, 'UTF-8', SABAI_CHARSET);
    }

    function _decode($str)
    {
        return mb_convert_encoding($str, SABAI_CHARSET, 'UTF-8');
    }

    function _metaWeblog_newPost($nodeId, $username, $password, $content, $publish)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        if (!$user->isInRole(array(XIGG_ROLE_ADMIN, XIGG_ROLE_EDITOR, XIGG_ROLE_WRITER, XIGG_ROLE_SUBMITTER))) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $title = isset($content['title']) ? trim($content['title']) : '';
        $description = isset($content['description']) ? trim($content['description']) : '';
        if (empty($title) || empty($description)) {
            return new XML_RPC_Response(0, $GLOBALS['XML_RPC_err'][3], $GLOBALS['XML_RPC_str'][3]);
        }
        $model =& $this->_locator->getService('Model');
        $node =& $model->create('Blog');
        $node->loadUserData($user);
        $title = $this->_decode($title);
        $description = $this->_decode($description);
        $node->set('title', $title);
        $node->set('body', $description);
        $node->set('title_html', $title);
        $node->set('body_html', $description);
        $node->set('allow_comments', 1);
        $node->set('allow_trackbacks', 1);
        $node->set('content_syntax', 'HTML');
        if ($user->isInRole(array(XIGG_ROLE_ADMIN, XIGG_ROLE_EDITOR, XIGG_ROLE_WRITER))) {
            if (!empty($publish)) {
                $publish_date = time();
                if (!empty($content['dateCreated'])) {
                    $date_created = XML_RPC_iso8601_decode($content['dateCreated']);
                    // do not allow future publish date
                    if ($date_created <= $publish_date) {
                        $publish_date = $date_created;
                    }
                }
                // this is a work around to prevent created time being after the date of publish
                $publish_date = $publish_date + 1;
                $node->publish($publish_date);
            }
        } else {
            $node->set('status', XIGG_NODE_STATUS_UPCOMING);
        }
        if (isset($content['mt_allow_comments'])) {
            $allow_comments = intval($content['mt_allow_comments']);
            if ($allow_comments > 1) {
                // mt_allow_comments 2 means to stop new comment postings
                $allow_comments = 0;
            }
            $node->set('allow_comments', $allow_comments);
        }
        if (isset($content['mt_allow_pings'])) {
            $node->set('allow_trackbacks', intval($content['mt_allow_pings']));
        }
        if (isset($content['mt_excerpt'])) {
            $node->set('teaser', $this->_decode($content['mt_excerpt']));
        }
        if (!empty($content['mt_text_more'])) {
            $node->set('body', $this->_decode($content['mt_text_more']));
        }
        $node->markNew();
        // always purify HTML before commit
        $node->purifyHTML($this->_locator->getService('HTMLPurifier'));
        if (!$model->commit()) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        return new XML_RPC_Response(new XML_RPC_Value($node->getId(), 'string'));
    }

    function _metaWeblog_editPost($postId, $username, $password, $content, $publish)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        if (!$user->isInRole(array(XIGG_ROLE_ADMIN, XIGG_ROLE_EDITOR, XIGG_ROLE_WRITER, XIGG_ROLE_SUBMITTER))) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $title = isset($content['title']) ? trim($content['title']) : '';
        $description = isset($content['description']) ? trim($content['description']) : '';
        if (empty($title) || empty($description)) {
            return new XML_RPC_Response(0, $GLOBALS['XML_RPC_err'][3], $GLOBALS['XML_RPC_str'][3]);
        }
        $model =& $this->_locator->getService('Model');
        $node_r =& $model->getRepository('Blog');
        if (!$node =& $node_r->fetchById($postId)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Invalid post id');
        }
        $node->set('title_html', $this->_decode($title));
        $node->set('body_html', $this->_decode($description));
        $node->set('allow_comments', 1);
        $node->set('allow_trackbacks', 1);
        if ($user->isInRole(array(XIGG_ROLE_ADMIN, XIGG_ROLE_EDITOR))) {
            if (!empty($publish) && !$node->isPublished()) {
                $publish_date = time();
                if (!empty($content['dateCreated'])) {
                    $date_created = XML_RPC_iso8601_decode($content['dateCreated']);
                    // do not allow future publish date
                    if ($date_created <= $publish_date) {
                        $publish_date = $date_created;
                    }
                }
                // this is a work around to prevent created time being after the date of publish
                $publish_date = $publish_date + 1;
                $node->publish($publish_date);
            }
        }
        if (isset($content['mt_allow_comments'])) {
            $allow_comments = intval($content['mt_allow_comments']);
            if ($allow_comments > 1) {
                // mt_allow_comments 2 means to stop new comment postings
                $allow_comments = 0;
            }
            $node->set('allow_comments', $allow_comments);
        }
        if (isset($content['mt_allow_pings'])) {
            $node->set('allow_trackbacks', intval($content['mt_allow_pings']));
        }
        if (isset($content['mt_excerpt'])) {
            $node->set('teaser', $this->_decode($content['mt_excerpt']));
        }
        if (!empty($content['mt_text_more'])) {
            $node->set('body', $this->_decode($content['mt_text_more']));
        }
        // always purify HTML before commit
        $node->purifyHTML($this->_locator->getService('HTMLPurifier'));
        if (!$model->commit()) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Commit error');
        }
        return new XML_RPC_Response(new XML_RPC_Value(true, 'boolean'));
    }

    function _metaWeblog_getPost($postId, $username, $password)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $node_r =& $model->getRepository('Blog');
        if (!$node =& $node_r->fetchById($postId)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Invalid post id');
        }
        return new XML_RPC_Response($this->_nodeToStruct($node));
    }

    // this does not follow the metaWeblog API RFC but a custom implementation of WLW 1.0 beta
    // see http://www.wictorwilen.se/Post/Windows-Live-Writer-10-beta-and-Metawenode-API.aspx
    function _metaWeblog_getCategories($nodeId, $username, $password, $content, $publish)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $category_r =& $model->getRepository('Category');
        $criteria =& $model->createCriteria('Category');
        $criteria->parentIs('NULL');
        $top_categories =& $category_r->fetchByCriteria($criteria);
        $category_structs = array();
        while ($top_category =& $top_categories->getNext()) {
            $category_structs[] =& new XML_RPC_Value(
                    array('categoryid'  => new XML_RPC_Value($top_category->getId()),
                          'title'       => new XML_RPC_Value($this->_encode($top_category->getLabel())),
                          'description' => new XML_RPC_Value($this->_encode($top_category->get('description')))),
                    'struct');
            $categories =& $category_r->fetchDescendantsAsTreeByParent($top_category->getId());
            while ($category =& $categories->getNext()) {
                $title = str_repeat('-', $category->parentsCount()) . $this->_encode($category->getLabel());
                $category_structs[] =& new XML_RPC_Value(
                    array('categoryid'  => new XML_RPC_Value($category->getId()),
                          'title'       => new XML_RPC_Value($title),
                          'description' => new XML_RPC_Value($this->_encode($category->get('description')))),
                   'struct');
            }
        }
        return new XML_RPC_Response(new XML_RPC_Value($category_structs, 'array'));
    }

    function _metaWeblog_getRecentPosts($nodeId, $username, $password, $numberOfPosts)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $node_r =& $model->getRepository('Blog');
        $criteria =& $model->createCriteria('Blog');
        $criteria->statusIs(XIGG_NODE_STATUS_PUBLISHED);
        if (50 < $numberOfPosts = intval($numberOfPosts)) {
            $numberOfPosts = 50;
        }
        $nodes =& $node_r->fetchByCriteria($criteria, $numberOfPosts, 0, 'node_published', 'DESC');
        $node_strutcs = array();
        while ($node =& $nodes->getNext()) {
            $node_structs[] =& $this->_nodeToStruct($node);
        }
        return new XML_RPC_Response(new XML_RPC_Value($node_structs, 'array'));
    }

    function _metaWeblog_newMediaObject($nodeId, $username, $password, $file)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
    }

    function _nodeger_deletePost($appKey, $postId, $username, $password, $content, $publish)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        if (!$user->isInRole(array(XIGG_ROLE_ADMIN, XIGG_ROLE_EDITOR))) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $node_r =& $model->getRepository('Blog');
        if (!$node =& $node_r->fetchById($postId)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Invalid post id');
        }
        $node->markRemoved();
        if (!$model->commit()) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Commit error');
        }
        return new XML_RPC_Response(new XML_RPC_Value(true, 'boolean'));
    }

    function _nodeger_getUsersBlogs($appKey, $username, $password)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $val =& new XML_RPC_Value(array(new XML_RPC_Value(
                                            array('url'      => new XML_RPC_Value(SABAI_URL_DIR),
                                                  'nodeName' => new XML_RPC_Value($this->_encode('Sabai Blog')),
                                                  'nodeid'   => new XML_RPC_Value('')),
                                            'struct')),
                                 'array');
        return new XML_RPC_Response($val);
    }

    function _mt_getPostCategories($postId, $username, $password)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $node_r =& $model->getRepository('Blog');
        if (!$node =& $node_r->fetchById($postId)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Requested entry does not exist');
        }
        $category_structs = array();
        if ($category =& $node->get('Category')) {
            $category_name = $this->_encode($category->getLabel());
            $category_structs[] =& new XML_RPC_Value(
                                        array('categoryId'   => new XML_RPC_Value($category->getId()),
                                              'categoryName' => new XML_RPC_Value($category_name)),
                                        'struct');
        }
        return new XML_RPC_Response(new XML_RPC_Value($category_structs, 'array'));
    }

    function _mt_setPostCategories($postId, $username, $password, $categories)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $node_r =& $model->getRepository('Blog');
        if (!$node =& $node_r->fetchById($postId)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Requested entry does not exist');
        }
        foreach ((array)$categories as $cat) {
            if (!isset($category_id) || $cat['isPrimary']) {
                $category_id = $cat['categoryId'];
            }
        }
        if (!empty($category_id)) {
            $category_r =& $model->getRepository('Category');
            if (!$category =& $category_r->fetchById($category_id)) {
                return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Requested category does not exist');
            }
            $node->set('Category', $category);
            if (!$model->commit()) {
                return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Failed commit');
            }
        }
        return new XML_RPC_Response(new XML_RPC_Value(true, 'boolean'));
    }

    function _mt_getCategoryList($nodeId, $username, $password)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $category_r =& $model->getRepository('Category');
        $criteria =& $model->createCriteria('Category');
        $criteria->parentIs('NULL');
        $top_categories =& $category_r->fetchByCriteria($criteria);
        $category_structs = array();
        while ($top_category =& $top_categories->getNext()) {
            $top_category_name = $this->_encode($top_category->getLabel());
            $category_structs[] =& new XML_RPC_Value(
                                        array('categoryId'   => new XML_RPC_Value($top_category->getId()),
                                              'categoryName' => new XML_RPC_Value($top_category_name)),
                                        'struct');
            $categories =& $category_r->fetchDescendantsAsTreeByParent($top_category->getId());
            while ($category =& $categories->getNext()) {
                $title = str_repeat('-', $category->parentsCount()) . $this->_encode($category->getLabel());
                $category_structs[] =& new XML_RPC_Value(
                                        array('categoryId'   => new XML_RPC_Value($category->getId()),
                                              'categoryName' => new XML_RPC_Value($title)),
                                        'struct');
            }
        }
        return new XML_RPC_Response(new XML_RPC_Value($category_structs, 'array'));
    }

    function _mt_getRecentPostTitles($nodeId, $username, $password, $numberOfPosts)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $node_r =& $model->getRepository('Blog');
        $criteria =& $model->createCriteria('Blog');
        $criteria->statusIs(XIGG_NODE_STATUS_PUBLISHED);
        if (50 < $numberOfPosts = intval($numberOfPosts)) {
            $numberOfPosts = 50;
        }
        $nodes =& $node_r->fetchByCriteria($criteria, $numberOfPosts, 0, 'node_published', 'DESC');
        $node_strutcs = array();
        while ($node =& $nodes->getNext()) {
            $title = $this->_encode($node->getLabal());
            $date = XML_RPC_iso8601_encode($node->getTimeCreated());
            $node_structs[] =& new XML_RPC_Value(
                                        array('postid'      => new XML_RPC_Value($node->getId()),
                                              'userid'      => new XML_RPC_Value($node->getUserId()),
                                              'title'       => new XML_RPC_Value($title),
                                              'dateCreated' => new XML_RPC_Value($date, 'dateTime.iso8601')),
                                        'struct');
        }
        return new XML_RPC_Response(new XML_RPC_Value($node_structs, 'array'));
    }

    function _mt_supportedTextFilters()
    {
        return new XML_RPC_Response(new XML_RPC_Value(array('Markdown'), 'array'));
    }

    function _mt_publishPost($postId, $username, $password)
    {
        if (!$user =& $this->_loginUser($username, $password)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        if (!$user->isInRole(array(XIGG_ROLE_ADMIN, XIGG_ROLE_EDITOR))) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Unauthorized');
        }
        $model =& $this->_locator->getService('Model');
        $node_r =& $model->getRepository('Blog');
        if (!$node =& $node_r->fetchById($postId)) {
            return new XML_RPC_Response(0, count($GLOBALS['XML_RPC_err']) + 1, 'Invalid post id');
        }
        if (!$node->isPublished()) {
            $node->publish();
        }
        return new XML_RPC_Response(new XML_RPC_Value(true, 'boolean'));
    }

    function metaWeblog_newPost(&$params)
    {
        return $this->_execute('_metaWeblog_newPost', $params);
    }

    function metaWeblog_editPost(&$params)
    {
        return $this->_execute('_metaWeblog_editPost', $params);
    }

    function metaWeblog_getPost(&$params)
    {
        return $this->_execute('_metaWeblog_getPost', $params);
    }

    function metaWeblog_getRecentPosts(&$params)
    {
        return $this->_execute('_metaWeblog_getRecentPosts', $params);
    }

    function metaWeblog_getCategories(&$params)
    {
        return $this->_execute('_metaWeblog_getCategories', $params);
    }

    function metaWeblog_newMediaObject(&$params)
    {
        return $this->_execute('_metaWeblog_newMediaObject', $params);
    }

    function nodeger_deletePost(&$params)
    {
        return $this->_execute('_nodeger_deletePost', $params);
    }

    function nodeger_getUsersBlogs(&$params)
    {
        return $this->_execute('_nodeger_getUsersBlogs', $params);
    }

    function mt_getPostCategories(&$params)
    {
        return $this->_execute('_mt_getPostCategories', $params);
    }

    function mt_setPostCategories(&$params)
    {
        return $this->_execute('_mt_setPostCategories', $params);
    }

    function mt_getCategoryList(&$params)
    {
        return $this->_execute('_mt_getCategoryList', $params);
    }

    function mt_getRecentPostTitles(&$params)
    {
        return $this->_execute('_mt_getRecentPostTitles', $params);
    }

    function mt_supportedTextFilters()
    {
        return $this->_execute('_mt_supportedTextFilters', $params);
    }

    function mt_publishPost()
    {
        return $this->_execute('_mt_publishPost', $params);
    }
}