<?php
$this->loadHelpers(array('XiggBreadCrumb', 'HTML', 'XiggTime', 'PageNavRemote', 'Token')); // not required in PHP5
$entity_count_last = $page->getOffset() + $page->getLimit();
$entity_count_first = $entity_count_last > 0 ? $page->getOffset() + 1 : 0;
$node_nav_result = $this->__('Showing %1$d - %2$d of %3$d', array($entity_count_first, $entity_count_last, $pages->getElementCount()));
?>
<div class="nodesBreadcrumb">
  <?php echo $this->XiggBreadCrumb->create();?><a href="<?php echo $this->Request->createUri(array('base' => '/tag'));?>"><?php echo _('Tags');?></a> &#8250; <?php printf(_('Tag: %s'), h($tag->getLabel()));?>
</div>
<div class="nodesHead clearfix">
  <h1 class="categoryTitle"><?php printf(_('Tag: %s'), h($tag->getLabel()));?></h1>
  <ul>
<?php if ($this->Config->get('useUpcomingFeature')):?>
    <li class="active"><?php echo _('Popular news');?></li>
    <li>
      <a href="<?php echo $this->Request->createUri(array('base' => $route .'/upcoming'));?>" title="<?php echo _('Upcoming news');?>"><?php printf(_('Upcoming news (%d)'), $upcoming_count);?></a>
    </li>
<?php else:?>
    <li class="active"><?php echo _('News list');?></li>
<?php endif;?>
<?php if ($this->User->hasPermission('article post')):?>
    <li class="submit">
      <a href="<?php echo $this->Request->createUri(array('base' => '/submit'));?>" title="<?php echo _('Submit Article');?>"><?php echo _('Submit Article');?></a>
    </li>
<?php endif;?>
  </ul>
</div>
<div class="nodesFeed">
  <a href="<?php echo $this->Request->createUri(array('base' => '/rss' . $route));?>"><img src="<?php echo $LAYOUT_URL;?>/images/feed.gif" width="16" height="16" alt="RSS feed" title="RSS feed" /></a>
</div>
<div class="nodesSearch">&nbsp;</div>
<table class="nodesNav">
  <tr>
    <td class="nodesNavResults"><?php echo $node_nav_result;?></td>
    <td class="nodesNavSort"><?php echo _('Sort by: '); $this->HTML->selectToRemote('period', $requested_period, 'xigg-main-shownodesbytag', $sorts, array('base' => $route), _('GO'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
  </tr>
</table>
<?php if (isset($nodes)):
        $nodes =& $nodes->with('Tags'); $nodes =& $nodes->with('User'); $nodes =& $nodes->with('Category'); $nodes->rewind();
        while ($node =& $nodes->getNext()):
          include $this->getTemplatePath('xigg_main_shownodesummary.tpl');
        endwhile;?>
<table class="nodesNav">
  <tr>
    <td class="nodesNavPages"><?php $this->PageNavRemote->write('xigg-main-shownodesbytag', $pages, $page->getPageNumber(), array('base' => $route, 'params' => array('period' => $requested_period)), array('params' => array('period' => $requested_period, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
  </tr>
</table>
<?php endif;?>