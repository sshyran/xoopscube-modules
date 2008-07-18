<?php
$_upcoming = true;
include $this->getTemplatePath('xigg_main_shownodes.inc.tpl');
?>
<div class="nodesBreadcrumb">
  <?php echo $breadcrumb;?>
</div>
<div class="nodesHead clearfix">
  <h1 class="categoryTitle"><?php _h($category_title);?></h1>
  <ul>
    <li>
      <a href="<?php echo $this->Request->createUri(array('params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword)));?>" title="<?php echo _('Popular news');?>"><?php printf(_('Popular news (%d)'), $popular_count);?></a>
    </li>
    <li class="active"><?php echo _('Upcoming news');?></li>
<?php if ($this->User->hasPermission('article post')):?>
    <li class="submit">
      <a href="<?php echo $this->Request->createUri(array('base' => '/submit', 'params' => array('category_id' => $requested_category_id)));?>" title="<?php echo _('Submit Article');?>"><?php echo _('Submit Article');?></a>
    </li>
<?php endif;?>
  </ul>
</div>
<div class="nodesFeed">
  <a href="<?php echo $this->Request->createUri(array('base' => '/rss/upcoming', 'params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword)));?>"><img src="<?php echo $LAYOUT_URL;?>/images/feed.gif" width="16" height="16" alt="RSS feed" title="RSS feed" /></a>
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
    <input type="hidden" name="sort" value="<?php _h($requested_sort);?>" />
    <input type="submit" value="<?php echo _('GO');?>" />
  </form>
</div>
<table class="nodesNav">
  <tr>
    <td class="nodesNavResults"><?php echo $node_nav_result;?></td>
    <td class="nodesNavSort"><?php echo _('Sort by: '); $this->HTML->selectToRemote('sort', $requested_sort, 'xigg-main-showupcomingnodes', $sorts, array('base' => '/node/upcoming', 'params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword)), _('GO'), array('params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
  </tr>
</table>
<?php if (isset($nodes)):
        $nodes =& $nodes->with('Tags'); $nodes =& $nodes->with('User'); $nodes->rewind();
        while ($node =& $nodes->getNext()):
          include $this->getTemplatePath('xigg_main_shownodesummary.tpl');
        endwhile;?>
<table class="nodesNav">
  <tr>
    <td class="nodesNavPages"><?php $this->PageNavRemote->write('xigg-main-showupcomingnodes', $pages, $page->getPageNumber(), array('base' => '/node/upcoming', 'params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword, 'sort' => $requested_sort)), array('params' => array('category_id' => $requested_category_id, 'user_id' => $requested_user_id, 'keyword' => $requested_keyword, 'sort' => $requested_sort, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
  </tr>
</table>
<?php endif;?>
<script type="text/javascript">
Event.observe('nodesSearchForm', 'submit', function(evt) {
  new Ajax.Updater(
    'xigg-main-showupcomingnodes',
    '<?php echo $this->Request->createUri(array('base' => '/node/upcoming', 'params' => array('sort' => $requested_sort)));?>',
    {
      evalScripts: true,
      method: 'get',
      parameters: evt.element().serialize() + '&<?php echo XIGG_REQUEST_AJAX_PARAM;?>=1'
    }
  );
  Event.stop(evt);
});
</script>