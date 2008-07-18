<?php
define('XIGG_NODE_STATUS_PUBLISHED', 1);
define('XIGG_NODE_STATUS_UPCOMING', 0);

class Xigg_Model_Node extends Xigg_Model_NodeBase
{
    var $_autoParagraphTeaser = false;
    var $_autoParagraphBody = false;
    var $_linkifyTeaser = false;
    var $_linkifyBody = false;

    function Xigg_Model_Node(&$model)
    {
        parent::Xigg_Model_NodeBase($model);
    }

    function isPublished()
    {
        return $this->get('status') == XIGG_NODE_STATUS_PUBLISHED;
    }

    function publish($time = null)
    {
        $this->set('status', XIGG_NODE_STATUS_PUBLISHED);
        $this->set('published', isset($time) ? $time : time());
    }

    function hide()
    {
        $this->set('hidden', 1);
    }

    function unhide()
    {
        $this->set('hidden', 0);
    }

    function isHidden()
    {
        return (bool)$this->get('hidden');
    }

    function isReadable(&$user)
    {
        if ($this->isHidden() && !$user->hasPermission('article view hidden')) {
            return false;
        }
        return true;
    }

    function &paginateCommentsByParentComment($parentCommentId = 'NULL', $perpage = 10, $sort = null, $order = null)
    {
        $comment_r =& $this->_model->getRepository('Comment');
        $criteria =& $this->_model->createCriteria('Comment');
        $pages=& $comment_r->paginateByNodeAndCriteria($this->getId(),
                                                       $criteria->parentIs($parentCommentId),
                                                       $perpage,
                                                       $sort,
                                                       $order);
        return $pages;
    }

    function HTMLize(&$pluginManager)
    {
        $this->HTMLizeTeaser($pluginManager);
        $this->HTMLizeBody($pluginManager);
    }

    function HTMLizeTeaser(&$pluginManager)
    {
        $teaser = $this->get('teaser');
        $pluginManager->dispatch('HTMLizeNodeTeaser', array($this->getId(),
                                                            $this->get('content_syntax'),
                                                            &$teaser,
                                                            &$this->_autoParagraphTeaser,
                                                            &$this->_linkifyTeaser));
        $this->set('teaser_html', $teaser);
    }

    function HTMLizeBody(&$pluginManager)
    {
        $body = $this->get('body');
        $pluginManager->dispatch('HTMLizeNodeBody', array($this->getId(),
                                                          $this->get('content_syntax'),
                                                          &$body,
                                                          &$this->_autoParagraphBody,
                                                          &$this->_linkifyBody));
        $this->set('body_html', $body);
    }

    function purifyHTML(&$purifier)
    {
        $purifier->config->set('AutoFormat', 'AutoParagraph', $this->_autoParagraphTeaser);
        $purifier->config->set('AutoFormat', 'Linkify', $this->_linkifyTeaser);
        $this->set('teaser_html', $this->_purifyHTML($purifier, $this->get('teaser_html')));
        $purifier->config->set('AutoFormat', 'AutoParagraph', $this->_autoParagraphBody);
        $purifier->config->set('AutoFormat', 'Linkify', $this->_linkifyBody);
        $this->set('body_html', $this->_purifyHTML($purifier, $this->get('body_html')));
    }

    function _purifyHTML(&$purifier, $html)
    {
        if (SABAI_CHARSET != 'UTF-8') {
            $html = preg_replace('/&([a-zA-Z0-9]{2,8};)/', '&amp;\\1', $html);
            $html = mb_convert_encoding($purifier->purify(mb_convert_encoding($html, 'UTF-8', SABAI_CHARSET)),
                                       SABAI_CHARSET,
                                       'UTF-8');
            return preg_replace('/&amp\;([a-zA-Z0-9]{2,8};)/', '&\\1', $html);
        }
        return $purifier->purify($html);
    }

    function getSourceHTMLLink($length = 100, $target = '_blank')
    {
        if ($source = $this->get('source')) {
            if ($source_title = $this->get('source_title')) {
                return sprintf('<a href="%s" target="%s">%s</a>', $source, $target, h(Sabai_I18N::strcutMore($source_title, $length)));
            }
            return sprintf('<a href="%s" target="%s">%s</a>', $source, $target, h(Sabai_I18N::strcutMore($source, $length)));
        }
        return '';
    }

    function getScreenshot()
    {
        return sprintf('<img src="http://mozshot.nemui.org/shot?img_x=120:img_y=120;effect=true;uri=%1$s" width="120" height="120" alt="%1$s" />', $this->get('source'));
    }

    function linkTagsByStr($tagsStr)
    {
        $tag_names = array();
        mb_regex_encoding(SABAI_CHARSET);
        foreach (explode(',', $tagsStr) as $tag_name) {
            // convert encoding specific chars and then trim
            $tag_name = mb_convert_kana($tag_name, 'a', SABAI_CHARSET);
            $tag_name = trim(mb_ereg_replace(_(' '), ' ', $tag_name));
            // remove redundant spaces and invalid characters
            $tag_name = preg_replace(array('/\s\s+/', "[\r\n\t]", '/[\/~]/'), array(' ', ' ', ''), $tag_name);
            if (!empty($tag_name)) {
                $tag_names[strtolower($tag_name)] = $tag_name;
            }
        }
        $tag_r =& $this->_model->getRepository('Tag');
        $tags_existing =& $tag_r->getExistingTags(array_keys($tag_names));
        while ($tag_existing =& $tags_existing->getNext()) {
            $tag_existing->linkNode($this);
            unset($tag_names[strtolower($tag_existing->getLabel())]);
        }
        foreach ($tag_names as $tag_name) {
            $tag =& $this->_model->create('Tag');
            $tag->set('name', $tag_name);
            $tag->linkNode($this);
        }
        return $this->_model->commit();
    }
}

class Xigg_Model_NodeRepository extends Xigg_Model_NodeRepositoryBase
{
    function Xigg_Model_NodeRepository(&$model)
    {
        parent::Xigg_Model_NodeRepositoryBase($model);
    }

    function &paginateByCriteriaKeywordAndCategory(&$criteria, $keyword, $categoryId, $perpage, $sort = null, $order = null)
    {
        require_once 'Sabai/Page/Collection/Custom.php';
        $pages =& new Sabai_Page_Collection_Custom(
                    array(&$this, 'countByCriteriaKeywordAndCategory'),
                    array(&$this, 'fetchByCriteriaKeywordAndCategory'),
                    $perpage,
                    array(&$criteria, $keyword, $categoryId, $sort, $order));
        return $pages;
    }

    function &fetchByCriteriaKeywordAndCategory($limit, $offset, &$criteria, $keywords, $categoryId, $sort = null, $order = null)
    {
        $criterion =& $this->_createKeywordAndCategoryCriteria($criteria, $keywords, $categoryId);
        $gateway =& $this->_model->getGateway($this->getName());
        $it =& $this->_getCollection($gateway->selectByCriteriaWithComment($criterion, array(), $limit, $offset, $sort, $order));
        $ret = array(&$it); // for php4
        return $ret;
    }

    function countByCriteriaKeywordAndCategory(&$criteria, $keywords, $categoryId)
    {
        $criterion =& $this->_createKeywordAndCategoryCriteria($criteria, $keywords, $categoryId);
        $gateway =& $this->_model->getGateway($this->getName());
        return $gateway->countByCriteriaWithComment($criterion);
    }

    function &_createKeywordAndCategoryCriteria(&$criteria, $keywords, $categoryId)
    {
        $criterion =& Sabai_Model_Criteria::createComposite(array(&$criteria));
        if (!empty($categoryId)) {
            if (is_array($categoryId)) {
                $criterion->addAnd(Sabai_Model_Criteria::createIn('node_category_id', $categoryId));
            } else {
                $criterion->addAnd(Sabai_Model_Criteria::createValue('node_category_id', $categoryId));
            }
        }
        foreach (explode(' ', $keywords) as $keyword) {
            $keyword_criteria =& Sabai_Model_Criteria::createComposite(array(Sabai_Model_Criteria::createString('node_teaser_html', $keyword)));
            $keyword_criteria->addOr(Sabai_Model_Criteria::createString('node_body_html', $keyword));
            $keyword_criteria->addOr(Sabai_Model_Criteria::createString('node_title', $keyword));
            $keyword_criteria->addOr(Sabai_Model_Criteria::createString('comment_title', $keyword));
            $keyword_criteria->addOr(Sabai_Model_Criteria::createString('comment_body_html', $keyword));
            $criterion->addAnd($keyword_criteria);
            unset($keyword_criteria);
        }
        return $criterion;
    }
}