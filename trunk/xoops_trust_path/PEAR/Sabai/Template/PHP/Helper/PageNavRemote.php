<?php
class Sabai_Template_PHP_Helper_PageNavRemote extends Sabai_Template_PHP_Helper
{
    function create($update, &$pages, $currentPage, $linkUrl, $ajaxUrl = array(), $pageVar = 'page', $pageSummaryText = null)
    {
        if ($pages->size() <= 1) {
            return '';
        }
        // Get the HTML helper
        $html =& $this->_tpl->getHelper('HTML');

        $link_url = array_merge(array('base' => '', 'params' => array(), 'fragment' => ''), $linkUrl);
        $ajax_url = array_merge($link_url, $ajaxUrl);
        $page_summary_text = isset($pageSummaryText) ? $pageSummaryText : 'Page %1$d of %2$d';
        $nav_html = array(sprintf('<li class="pagesSummary">%s</li>', h(sprintf($page_summary_text, $currentPage, $pages->size()))));
        if ($currentPage > 3) {
            $nav_html[] = sprintf('<li class="pagesFirst">%s</li>', $this->_getFirstPageLink($html, $update, $link_url, $ajax_url, $pageVar));
        }
        if ($currentPage > 1) {
            $nav_html[] = sprintf('<li class="pagesPrevious">%s</li>', $this->_getPreviousPageLink($html, $update, $currentPage, $link_url, $ajax_url, $pageVar));
        }
        while ($p =& $pages->getNext()) {
            if ($p->getPageNumber() == $currentPage) {
                $nav_html[] = sprintf('<li class="pagesCurrent">%d</li>', $p->getPageNumber());
            } elseif (abs($p->getPageNumber() - $currentPage) <= 2) {
                $nav_html[] = sprintf('<li>%s</li>', $this->_getPageLink($html, $update, $p->getPageNumber(), $link_url, $ajax_url, $pageVar));
            }
        }
        if ($currentPage < $pages->size()) {
            $nav_html[] = sprintf('<li class="pagesNext">%s</li>', $this->_getNextPageLink($html, $update, $currentPage, $link_url, $ajax_url, $pageVar));
        }
        $page_size = $pages->size();
        if ($currentPage < $page_size - 2) {
            $nav_html[] = sprintf('<li class="pagesLast">%s</li>', $this->_getLastPageLink($html, $update, $page_size, $link_url, $ajax_url, $pageVar));
        }
        return sprintf('<ul class="pages">%s</ul>', implode('', $nav_html));
    }

    function _getFirstPageLink(&$html, $update, $linkUrl, $ajaxUrl, $pageVar)
    {
        return $html->createLinkToRemote('&laquo;', $update, array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => 1)), 'fragment' => $linkUrl['fragment']), array('base' => $ajaxUrl['base'], 'params' => array_merge($ajaxUrl['params'], array($pageVar => 1))));
    }

    function _getPreviousPageLink(&$html, $update, $currentPage, $linkUrl, $ajaxUrl, $pageVar)
    {
        return $html->createLinkToRemote('&lsaquo;', $update, array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => $currentPage - 1)), 'fragment' => $linkUrl['fragment']), array('base' => $ajaxUrl['base'], 'params' => array_merge($ajaxUrl['params'], array($pageVar => $currentPage - 1))));
    }

    function _getPageLink(&$html, $update, $pageNum, $linkUrl, $ajaxUrl, $pageVar)
    {
        return $html->createLinkToRemote($pageNum, $update, array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => $pageNum)), 'fragment' => $linkUrl['fragment']), array('base' => $ajaxUrl['base'], 'params' => array_merge($ajaxUrl['params'], array($pageVar => $pageNum))));
    }

    function _getNextPageLink(&$html, $update, $currentPage, $linkUrl, $ajaxUrl, $pageVar)
    {
        return $html->createLinkToRemote('&rsaquo;', $update, array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => $currentPage + 1)), 'fragment' => $linkUrl['fragment']), array('base' => $ajaxUrl['base'], 'params' => array_merge($ajaxUrl['params'], array($pageVar => $currentPage + 1))));
    }

    function _getLastPageLink(&$html, $update, $pages, $linkUrl, $ajaxUrl, $pageVar)
    {
        return $html->createLinkToRemote('&raquo;', $update, array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => $pages)), 'fragment' => $linkUrl['fragment']), array('base' => $ajaxUrl['base'], 'params' => array_merge($ajaxUrl['params'], array($pageVar => $pages))));
    }

    function write($update, &$pages, $currentPage, $linkUrl, $ajaxUrl = array(), $pageVar = 'page', $pageSummaryText = null)
    {
        echo $this->create($update, $pages, $currentPage, $linkUrl, $ajaxUrl, $pageVar, $pageSummaryText);
    }
}