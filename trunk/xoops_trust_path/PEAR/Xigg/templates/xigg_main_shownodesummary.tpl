<?php
$node_user =& $node->get('User');
$tag_html = array();
$node_tags =& $node->get('Tags');
if ($node_tags->size() > 0) {
    while ($tag =& $node_tags->getNext()) {
        $tag_html[] = sprintf('<a href="%s" rel="tag">%s</a>', $this->Request->createUri(array('base' => '/tag/' . $tag->getEncodedName())), h($tag->getLabel()));
    }
}
?>
<div class="node clearfix">
  <h4 class="nodeSource"><?php echo $node->getSourceHTMLLink();?></h4>
  <h2 class="nodeTitle">
<?php if (($category =& $node->get('Category')) && (!isset($requested_category_id) || ($category->getId() != $requested_category_id))):?>
<?php   printf('<a href="%s">%s</a>: ', $this->Request->createUri(array('base' => '/', 'params' => array('category_id' => $category->getId()))), h($category->getLabel()));?>
<?php endif;?>
    <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId()));?>"><?php _h($node->get('title'));?></a>
  </h2>
<?php if ($this->Config->get('useVotingFeature')):?>
  <div class="nodeVote">
    <div class="nodeVoteCount"><span id="xigg-votenode<?php echo $node->getId();?>"><?php echo $node->getVoteCount();?></span></div>
    <div class="nodeVoteText">
<?php if ($vote_allowed):?>
<?php   if (!in_array($node->getId(), $nodes_voted)):?>
<?php     $this->HTML->linkToRemote(_('Vote!'), 'xigg-votenode' . $node->getId(), array('base' => '/node/' . $node->getId() . '/voteform'), array('base' => '/node/' . $node->getId() . '/vote', 'params' => array('echo' => 1, XIGG_REQUEST_AJAX_PARAM => 1), 'query' => array($this->Token->createQuery('Vote_submit_' . $node->getId()))), array('post' => true, 'replace' => '<span>' . _('Voted') . '</span>', 'failure' => 'xigg-votenodeerror' . $node->getId()));?>
<?php   else:?>
      <span><?php echo _('Voted');?></span>
<?php   endif;?>
<?php else:?>
      <span><?php echo _('Vote!');?></span>
<?php endif;?>
    </div>
    <div id="xigg-votenodeerror<?php echo $node->getId();?>" class="nodeVoteError"></div>
  </div>
<?php endif;?>
  <div class="nodeInfo">
    <div class="nodeInfoPoster"><?php echo $node_user->getHTMLImageLink(32, 32);?></div>
    <div class="nodeInfoDetails">
<?php if ($this->Config->get('useUpcomingFeature')):?>
<?php   if ($node->isPublished()):?>
<?php     printf(_('%s submitted %s, published <strong>%s</strong>'), $node_user->getHTMLLink(), h($this->XiggTime->ago($node->getTimeCreated())), h($this->XiggTime->ago($node->get('published'))));?>
<?php   else:?>
<?php     printf(_('%s posted <strong>%s</strong>'), $node_user->getHTMLLink(), h($this->XiggTime->ago($node->getTimeCreated())));?>
<?php   endif;?>
<?php else:?>
<?php   printf(_('%s posted <strong>%s</strong>'), $node_user->getHTMLLink(), h($this->XiggTime->ago($node->get('published'))));?>
<?php endif;?>
<?php if ($this->Config->get('showNodeViewCount')):?>
<?php   printf(' | ' . _('%d views'), $node->get('views'));?>
<?php endif;?>
    <br />
    <span class="nodeInfoTags"><?php echo _('Tags: ');?>
<?php if (!empty($tag_html)):?>
<?php   echo implode(', ', $tag_html);?>
<?php endif;?>
    </span>
    </div>
  </div>
  <div class="nodeContent">
<?php if ($source = $node->get('source')):?>
    <div class="nodeBodyScreenshot">
      <a href="<?php echo $source;?>" class="linkbubbler" title="<?php _h($node->get('source_title'));?>"><?php echo $node->getScreenshot();?></a>
    </div>
<?php endif;?>
    <p class="nodeTeaser">
<?php if ($teaser = $node->get('teaser_html')):?>
<?php   echo $teaser;?>&nbsp;<a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'fragment' => 'nodeBody'));?>" title="<?php echo _('Read full story');?>"><?php echo _('more...');?></a>
<?php else:?>
<?php   echo $node->get('body_html');?>
<?php endif;?>
    </p>
  </div>
  <div class="nodeInnerLinks">
<?php if ($this->Config->get('useCommentFeature')):?>
    <span class="nodeCommentsLink"><a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'fragment' => 'nodeComments'));?>"><?php printf(_('Comments (%d)'), $node->getCommentCount());?></a></span>
<?php endif;?>
<?php if ($this->Config->get('useTrackbackFeature')):?>
    <span class="nodeTrackbacksLink"><a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/trackbacktab', 'fragment' => 'nodeTrackbacks'));?>"><?php printf(_('Trackbacks (%d)'), $node->getTrackbackCount());?></a></span>
<?php endif;?>
<?php if ($this->Config->get('useVotingFeature')):?>
    <span class="nodeVotesLink"><a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/votetab', 'fragment' => 'nodeVotes'));?>"><?php printf(_('Votes (%d)'), $node->getVoteCount());?></a></span>
<?php endif;?>
    <span class="nodeAdminLink">
<?php if (!$node->isOwnedBy($this->User)):?>
<?php   if ($node->isPublished()):?>
<?php     if ($this->User->hasPermission(array('article edit any published'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/edit'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/edit.gif" alt="<?php echo _('Edit');?>" title="<?php echo _('Edit this article');?>" /></a>
<?php     endif;?>
<?php     if ($this->User->hasPermission(array('article delete any published'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/delete'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/delete.gif" alt="<?php echo _('Delete');?>" title="<?php echo _('Delete this article');?>" /></a>
<?php     endif;?>
<?php   else:?>
<?php     if ($this->User->hasPermission(array('article edit any unpublished'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/edit'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/edit.gif" alt="<?php echo _('Edit');?>" title="<?php echo _('Edit this article');?>" /></a>
<?php     endif;?>
<?php     if ($this->User->hasPermission(array('article delete any unpublished'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/delete'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/delete.gif" alt="<?php echo _('Delete');?>" title="<?php echo _('Delete this article');?>" /></a>
<?php     endif;?>
<?php     if ($this->User->hasPermission(array('article publish any'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/publish'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/tick.gif" alt="<?php echo _('Publish');?>" title="<?php echo _('Publish this article');?>" /></a>
<?php     endif;?>
<?php   endif;?>
<?php else:?>
<?php   if ($node->isPublished()):?>
<?php     if ($this->User->hasPermission(array('article edit own published'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/edit'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/edit.gif" alt="<?php echo _('Edit');?>" title="<?php echo _('Edit this article');?>" /></a>
<?php     endif;?>
<?php     if ($this->User->hasPermission(array('article delete own published'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/delete'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/delete.gif" alt="<?php echo _('Delete');?>" title="<?php echo _('Delete this article');?>" /></a>
<?php     endif;?>
<?php   else:?>
<?php     if ($this->User->hasPermission(array('article edit own unpublished'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/edit'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/edit.gif" alt="<?php echo _('Edit');?>" title="<?php echo _('Edit this article');?>" /></a>
<?php     endif;?>
<?php     if ($this->User->hasPermission(array('article delete own unpublished'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/delete'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/delete.gif" alt="<?php echo _('Delete');?>" title="<?php echo _('Delete this article');?>" /></a>
<?php     endif;?>
<?php     if ($this->User->hasPermission(array('article publish own'))):?>
      <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/publish'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/tick.gif" alt="<?php echo _('Publish');?>" title="<?php echo _('Publish this article');?>" /></a>
<?php     endif;?>
<?php   endif;?>
<?php endif;?>
    </span>
  </div>
</div>