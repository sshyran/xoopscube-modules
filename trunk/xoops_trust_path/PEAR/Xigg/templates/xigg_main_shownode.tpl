<?php
$this->loadHelpers(array('XiggBreadCrumb', 'HTML', 'XiggTime', 'Token')); // not required in PHP5
$node_user =& $node->get('User');
$tag_html = array();
$node_tags =& $node->get('Tags');
if ($node_tags->size() > 0) {
    while ($tag =& $node_tags->getNext()) {
        $tag_html[] = sprintf('<a href="%s" rel="tag">%s</a>', $this->Request->createUri(array('base' => '/tag/' . $tag->getEncodedName())), h($tag->getLabel()));
    }
}
// determine which tab should be selected for this request
$tab_class = array('comment' => '', 'trackback' => '', 'vote' => '');
foreach (array_keys($tab_class) as $_tab) {
    if (strpos($_SERVER['REQUEST_URI'], $_tab)) {
        $tab_class[$_tab] = 'tabbertabdefault';
        break;
    }
}
?>
<script type="text/javascript" src="<?php echo $LAYOUT_URL;?>/js/tabber-minimized.js"></script>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node, false);?></div>
<div class="node">
  <h4 class="nodeSource"><?php echo $node->getSourceHTMLLink(200);?></h4>
  <h2 class="nodeTitle">
  <?php _h($node->get('title'));?>
  </h2>
<?php if ($this->Config->get('useVotingFeature')):?>
  <div class="nodeVote">
    <div class="nodeVoteCount"><span id="xigg-votenode<?php echo $node->getId();?>"><?php echo $node->getVoteCount();?></span></div>
    <div class="nodeVoteText">
<?php if (!empty($vote_enable)):?>
<?php   if (empty($voted)):?>
      <?php $this->HTML->linkToRemote(_('Vote!'), 'xigg-votenode' . $node->getId(), array('base' => '/node/' . $node->getId() . '/voteform'), array('base' => '/node/' . $node->getId() . '/vote', 'params' => array('echo' => 1, XIGG_REQUEST_AJAX_PARAM => 1), 'query' => array($this->Token->createQuery('Vote_submit_' . $node->getId()))), array('post' => true, 'replace' => '<span>' . _('Voted') . '</span>', 'failure' => 'xigg-votenodeerror' . $node->getId()));?>
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
<?php if ($this->Config->get('useUpcomingFeature') && $node->isPublished()):?>
<?php   printf(_('%s submitted %s, published <strong>%s</strong>'), $node_user->getHTMLLink(), h($this->XiggTime->ago($node->getTimeCreated())), h($this->XiggTime->ago($node->get('published'))));?>
<?php else:?>
<?php   printf(_('%s posted <strong>%s</strong>'), $node_user->getHTMLLink(), h($this->XiggTime->ago($node->getTimeCreated())));?>
<?php endif;?>
<?php if ($this->Config->get('showNodeViewCount')):?>
<?php   printf(' | ' . _('%d views'), $node->get('views'));?>
<?php endif;?>
    <br />
    <span class="nodeInfoTags"><?php echo _('Tags: ');?>
<?php if (!empty($tag_html)) echo implode(', ', $tag_html);?>
    </span>
    </div>
  </div>
  <div class="nodeContent">
<?php if ($source = $node->get('source')):?>
    <div class="nodeBodyScreenshot">
      <a href="<?php echo $source;?>" class="linkbubbler" title="<?php _h($node->get('source_title'));?>"><?php echo $node->getScreenshot();?></a>
    </div>
<?php endif;?>
<?php if ($teaser = $node->get('teaser_html')):?>
    <div class="nodeTeaser"><?php echo $node->get('teaser_html');?></div>
<?php endif;?>
    <a name="nodeBody"></a>
    <div class="nodeBody"><?php echo $node->get('body_html');?></div>
  </div>
  <div class="commentReplyForm" id="xigg-showcommentform<?php echo $node->getId();?>"></div>
  <div class="nodeInnerLinks clear">
<?php if ($comment_form_show):?>
    <span class="commentReply"><?php $this->HTML->linkToRemote(_('Reply'), 'xigg-showcommentform' . $node->getId(), array('base' => '/node/' . $node->getId() . '/comment'), array('base' => '/node/' . $node->getId() . '/commentform', 'params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), array('toggle' => 'blind'));?></span>
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
<div class="tabber">
<?php if ($this->Config->get('useCommentFeature')):?>
  <div class="nodeComments tabbertab <?php echo $tab_class['comment']?>" id="xigg-showcomments<?php echo $node->getId();?>">
    <h4 class="commentsCaption"><a name="nodeComments" id="nodeComments"><?php printf(_('Comments (%d)'), $node->getCommentCount());?></a></h4>
    <?php include $this->getTemplatePath('xigg_main_showcomments.tpl');?>
  </div>
<?php endif;?>
<?php if ($this->Config->get('useTrackbackFeature')):?>
  <div class="nodeTrackbacks tabbertab <?php echo $tab_class['trackback']?>" id="xigg-showtrackbacks<?php echo $node->getId();?>">
    <h4 class="trackbacksCaption"><a name="nodeTrackbacks" id="nodeTrackbacks"><?php printf(_('Trackbacks (%d)'), $node->getTrackbackCount());?></a></h4>
    <?php include $this->getTemplatePath('xigg_main_showtrackbacks.tpl');?>
  </div>
<?php endif;?>
<?php if ($this->Config->get('useVotingFeature')):?>
  <div class="nodeVotes tabbertab <?php echo $tab_class['vote']?>" id="xigg-showvotes<?php echo $node->getId();?>">
    <h4 class="votesCaption"><a name="nodeVotes" id="nodeVotes"><?php printf(_('Votes (%d)'), $node->getVoteCount());?></a></h4>
    <?php include $this->getTemplatePath('xigg_main_showvotes.tpl');?>
  </div>
<?php endif;?>
</div>