<?php
class Sabai_Template_PHP_Helper_PageNavRemote extends Sabai_Template_PHP_Helper
{
    function create(&$pages, $currentPage, $linkUrl, $pageVar = 'page', $pageSummaryText = null)
    {
        if ($pages->size() <= 1) {
            return '';
        }
        // Get the HTML helper
        $html =& $this->_tpl->getHelper('HTML');

        $link_url = array_merge(array('base' => '', 'params' => array(), 'fragment' => ''), $linkUrl);
        $page_summary_text = isset($pageSummaryText) ? $pageSummaryText : 'Page %1$d of %2$d';
        $nav_html = array(sprintf('<li class="pagesSummary">%s</li>', h(sprintf($page_summary_text, $currentPage, $pages->size()))));
        if ($currentPage > 3) {
            $nav_html[] = sprintf('<li class="pagesFirst">%s</li>', $this->_getFirstPageLink($html, $link_url, $pageVar));
        }
        if ($currentPage > 1) {
            $nav_html[] = sprintf('<li class="pagesPrevious">%s</li>', $this->_getPreviousPageLink($html, $currentPage, $link_url, $pageVar));
        }
        while ($p =& $pages->getNext()) {
            if ($p->getPageNumber() == $currentPage) {
                $nav_html[] = sprintf('<li class="pagesCurrent">%d</li>', $p->getPageNumber());
            } elseif (abs($p->getPageNumber() - $currentPage) <= 2) {
                $nav_html[] = sprintf('<li>%s</li>', $this->_getPageLink($html, $p->getPageNumber(), $link_url, $pageVar));
            }
        }
        if ($currentPage < $pages->size()) {
            $nav_html[] = sprintf('<li class="pagesNext">%s</li>', $this->_getNextPageLink($html, $currentPage, $link_url, $pageVar));
        }
        $page_size = $pages->size();
        if ($currentPage < $page_size - 2) {
            $nav_html[] = sprintf('<li class="pagesLast">%s</li>', $getLastPageLink($html, $page_size, $link_url, $pageVar));
        }
        return sprintf('<ul class="pages">%s</ul>', implode('', $nav_html));
    }

    function _getFirstPageLink(&$html, $linkUrl, $pageVar)
    {
        return $html->createLinkTo('&laquo;', array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => 1)), 'fragment' => $linkUrl['fragment']));
    }

    function _getPreviousPageLink(&$html, $currentPage, $linkUrl, $pageVar)
    {
        return $html->createLinkTo('&lsaquo;', array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => $currentPage - 1)), 'fragment' => $linkUrl['fragment']));
    }

    function _getPageLink(&$html, $pageNum, $linkUrl, $pageVar)
    {
        return $html->createLinkTo($pageNum, array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => $pageNum)), 'fragment' => $linkUrl['fragment']));
    }

    function _getNextPageLink(&$html, $currentPage, $linkUrl, $pageVar)
    {
        return $html->createLinkTo('&rsaquo;', array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => $currentPage + 1)), 'fragment' => $linkUrl['fragment']));
    }

    function _getLastPageLink(&$html, $pages, $linkUrl, $pageVar)
    {
        return $html->createLinkTo('&raquo;', array('base' => $linkUrl['base'], 'params' => array_merge($linkUrl['params'], array($pageVar => $pages->size())), 'fragment' => $linkUrl['fragment']));
    }

    function write(&$pages, $currentPage, $linkUrl, $pageVar = 'page', $pageSummaryText = null)
    {
        echo $this->create($pages, $currentPage, $linkUrl, $pageVar, $pageSummaryText);
    }
}