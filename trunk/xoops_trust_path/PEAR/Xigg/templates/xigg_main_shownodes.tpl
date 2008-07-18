<?php
include $this->getTemplatePath('xigg_main_shownodes.inc.tpl');
?>
<div class="nodesBreadcrumb">
  <?php echo $breadcrumb;?>
</div>
<div class="nodesHead clearfix">
  <h1 class="categoryTitle"><?php _h($category_title);?></h1>
  <ul>
<?php if ($this->Config->get('useUpcomingFeature')):?>
    <li class="active"><?php echo _('Popular news');?></li>
    <li>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/upcoming', 'params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword)));?>" title="<?php echo _('Upcoming news');?>"><?php printf(_('Upcoming news (%d)'), $upcoming_count);?></a>
    </li>
<?php   if ($this->User->hasPermission('article post')):?>
    <li class="submit">
      <a href="<?php echo $this->Request->createUri(array('base' => '/submit', 'params' => array('category_id' => $requested_category_id)));?>" title="<?php echo _('Submit Article');?>"><?php echo _('Submit Article');?></a>
    </li>
<?php   endif;?>
<?php else:?>
<?php   if ($this->User->hasPermission('article post')):?>
    <li class="submit">
      <a href="<?php echo $this->Request->createUri(array('base' => '/submit', 'params' => array('category_id' => $requested_category_id)));?>" title="<?php echo _('Submit Article');?>"><?php echo _('Submit Article');?></a>
    </li>
<?php   endif;?>
<?php endif;?>
  </ul>
</div>
<div class="nodesFeed">
  <a href="<?php echo $this->Request->createUri(array('base' => '/rss', 'params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword)));?>"><img src="<?php echo $LAYOUT_URL;?>/images/feed.gif" width="16" height="16" alt="RSS feed" title="RSS feed" /></a>
</div>
<div class="nodesSearch">
  <form method="get" id="nodesSearchForm">
<?php echo _('Search: ');?>
    <select name="category_id">
<?php     foreach ($category_list as $category_id => $category_name):?>
<?php       if ($category_id == $requested_category_id):?>
      <option value="<?php _h($category_id);?>" selected="selected"><?php _h($category_name);?></option>
<?php       else:?>
      <option value="<?php _h($category_id);?>"><?php _h($category_name);?></option>
<?php       endif;?>
<?php      endforeach;?>
    </select>
    <input name="keyword" type="text" value="<?php _h($requested_keyword);?>" size="15" />
    <input name="user_id" type="hidden" value="<?php _h($requested_user_id);?>" />
    <input type="hidden" name="period" value="<?php _h($requested_period);?>" />
    <input type="submit" value="<?php echo _('GO');?>" />
  </form>
</div>
<table class="nodesNav">
  <tr>
    <td class="nodesNavResults"><?php echo $node_nav_result;?></td>
    <td class="nodesNavSort"><?php echo _('Sort by: '); $this->HTML->selectToRemote('period', $requested_period, 'xigg-main-shownodes', $sorts, array('base' => '/', 'params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword)), _('GO'), array('params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
  </tr>
</table>
<?php if (isset($nodes)):
        $nodes =& $nodes->with('Category'); $nodes =& $nodes->with('Tags'); $nodes =& $nodes->with('User'); $nodes->rewind();
        while ($node =& $nodes->getNext()):
          include $this->getTemplatePath('xigg_main_shownodesummary.tpl');
        endwhile;?>
<table class="nodesNav nodesNavBottom">
  <tr>
    <td class="nodesNavPages"><?php $this->PageNavRemote->write('xigg-main-shownodes', $pages, $page->getPageNumber(), array('base' => '', 'params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword, 'period' => $requested_period)), array('params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword, 'period' => $requested_period, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
  </tr>
</table>
<?php endif;?>
<script type="text/javascript">
Event.observe('nodesSearchForm', 'submit', function(evt) {
  new Ajax.Updater(
    'xigg-main-shownodes',
    '<?php echo $this->Request->createUri(array('base' => '', 'params' => array('period' => $requested_period)));?>',
    {
      evalScripts: true,
      method: 'get',
      parameters: evt.element().serialize() + '&<?php echo XIGG_REQUEST_AJAX_PARAM;?>=1'
    }
  );
  Event.stop(evt);
});
</script>