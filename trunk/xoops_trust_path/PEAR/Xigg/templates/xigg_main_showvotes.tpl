<?php $this->loadHelpers(array('HTML', 'PageNavRemote')); // not required in PHP5 ?>
<div class="votesSort">
  <div class="votesSortNav">
<?php foreach (array('newest' => _('Newest first'), 'oldest' => _('Oldest first')) as $view_key => $view_label):?>
<?php   if ($view_key == $vote_view):?>
    <span class="votesSortCurrent"><?php _h($view_label);?></span>
<?php   else:?>
   <?php $this->HTML->linkToRemote($view_label, 'xigg-showvotes' . $node->getId(), array('base' => '/node/' . $node->getId(), 'params' => array('vote_view' => $view_key), 'fragment' => 'nodeVotes'), array('base' => '/node/' . $node->getId() . '/votes', 'params' => array('vote_view' => $view_key, XIGG_REQUEST_AJAX_PARAM => 1)));?>
<?php   endif;?>
    |
<?php endforeach;?>
    <a href="<?php echo $this->Request->createUri(array('base' => '/rss/node/' . $node->getId(). '/votes'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/feed.gif" width="16" height="16" alt="RSS feed" title="RSS feed" /></a>
  </div>
  <div class="votesSortToggle">&nbsp;</div>
</div>
<?php if ($votes->size() > 0):?>
<ul class="voteUsers clearfix">
<?php   $votes->rewind(); while ($vote =& $votes->getNext()):?>
  <li class="voteUser"><a name="vote<?php echo $vote->getId();?>"></a><?php $vote_user =& $vote->get('User');echo $vote_user->printHTMLImageLink(32, 32);?><?php echo $vote_user->printHTMLLink();?></li>
<?php   endwhile;?>
</ul>
<table class="nodesNav nodesNavBottom">
  <tr>
    <td class="nodesNavPages"><?php  $this->PageNavRemote->write('xigg-showvotes' . $node->getId(), $vote_pages, $vote_page, array('base' => '/node/' . $node->getId(), 'params' => array('vote_view' => $vote_view), 'fragment' => 'nodeVotes'), array('base' => '/node/' . $node->getId() . '/votes', 'params' => array('vote_view' => $vote_view, XIGG_REQUEST_AJAX_PARAM => 1)), 'vote_page');?></td>
  </tr>
</table>
<?php endif;?>