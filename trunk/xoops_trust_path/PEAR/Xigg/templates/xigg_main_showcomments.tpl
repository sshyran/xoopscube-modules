<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'HTML')); // not required in PHP5 ?>
<div class="commentsSort">
  <div class="toggleButton commentsSortToggle">
    <?php $this->HTML->linkToShowClass('commentContent', _('[+]'), _('[-]'), '.commentTitleToggle > a');?>
    <?php $this->HTML->linkToHideClass('commentContent', _('[-]'), _('[+]'), '.commentTitleToggle > a');?>
  </div>
  <div class="commentsSortNav">
<?php foreach (array('newest' => _('Newest first'), 'oldest' => _('Oldest first'), 'nested' => _('Nested view')) as $view_key => $view_label):?>
<?php   if ($view_key == $comment_view):?>
    <span class="commentsSortCurrent"><?php _h($view_label);?></span> |
<?php   else:?>
   <?php $this->HTML->linkToRemote($view_label, 'xigg-showcomments' . $node->getId(), array('base' => '/node/' . $node->getId(), 'params' => array('comment_view' => $view_key), 'fragment' => 'nodeComments'), array('base' => '/node/' . $node->getId() . '/comments', 'params' => array('comment_view' => $view_key, XIGG_REQUEST_AJAX_PARAM => 1)));?> |
<?php   endif;?>
<?php endforeach;?>
    <a href="<?php echo $this->Request->createUri(array('base' => '/rss/node/' . $node->getId(). '/comments'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/feed.gif" width="16" height="16" alt="RSS feed" title="RSS feed" /></a>
  </div>
</div>

<?php if ($comments->size() > 0): $node_user =& $node->get('User');?>
<?php   if ($comment_view == 'nested') $comments =& $comments->with('DescendantsCount');?>
<?php   $comments->rewind(); while ($comment =& $comments->getNext()):?>
<a name="comment<?php echo $comment->getId();?>"></a>
<?php     $comment_user =& $comment->get('User');?>
<?php     if ($comment_user->getId() == $node_user->getId()):?>
<div class="comment commentByPoster">
<?php     else:?>
<div class="comment">
<?php     endif;?>
  <div class="commentHead"></div>
  <div class="commentTitle">
    <span class="toggleButton commentTitleToggle"><?php $this->HTML->linkToToggle('commentContent' . $comment->getId(), false, _('[-]'), _('[+]'));?></span>
    <span class="commentTitleText"><?php _h($comment->getLabel());?>&nbsp;</span>
  </div>
  <div id="commentContent<?php echo $comment->getId();?>" class="commentContent">
    <div class="commentData">
<?php     if ($comment_pid = $comment->getVar('parent')):?>
<?php       if (in_array($comment_pid, $comment_ids)):?>
    <?php printf(_('%s posted <strong>%s</strong> in reply to <a href="%s">#%d</a>'), $comment_user->getHTMLLink(), $this->XiggTime->ago($comment->getTimeCreated()), '#comment' . $comment_pid, $comment_pid);?>
<?php       else:?>
    <?php printf(_('%s posted <strong>%s</strong> in reply to <a href="%s">#%d</a>'), $comment_user->getHTMLLink(), $this->XiggTime->ago($comment->getTimeCreated()), $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment_pid), 'fragment' => 'comment' . $comment_pid)), $comment_pid);?>
<?php       endif;?>
<?php     else:?>
    <?php printf(_('%s posted <strong>%s</strong>'), $comment_user->getHTMLLink(), $this->XiggTime->ago($comment->getTimeCreated()));?>
<?php     endif;?>
    </div>
    <div class="commentPoster"><?php echo $comment_user->getHTMLImageLink(32, 32);?></div>
    <div class="commentBody">
      <?php echo $comment->get('body_html');?>
      <div class="commentReplyForm" id="xigg-showcommentreplyform<?php echo $comment->getId();?>"></div>
    </div>
    <div class="commentCtrl">
      <span>
        <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment->getId()), 'fragment' => 'comment' . $comment->getId()));?>">#<?php echo $comment->getId();?></a>
      </span>
<?php     if ($comment_view == 'nested'):?>
<?php       if ($replies_count = $comment->descendantsCount()):?>
      |
      <span class="commentRepliesLink">
<?php         if (!empty($comments_replies[$comment->getId()])):
                   $link_text = sprintf(_('Replies (%d)'), $replies_count);
                   $this->HTML->linkToToggle('xigg-showcommentreplies' . $comment->getId(), false, $link_text, $link_text);
                 else:
                   $this->HTML->linkToRemote(sprintf(_('Replies (%d)'), $replies_count), 'xigg-showcommentreplies' . $comment->getId(), array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment->getId()), 'fragment' => 'comment' . $comment->getId()), array('base' => '/comment/' . $comment->getId() . '/replies', 'params' => array('reply_paginate' => 1, XIGG_REQUEST_AJAX_PARAM => 1)), array('toggle' => 'blind'));
                 endif;?>
      </span>
<?php       endif;
          endif;
          if ($comment_form_show):?>
      |
      <span class="commentReply"><?php $this->HTML->linkToRemote(_('Reply'), 'xigg-showcommentreplyform' . $comment->getId(), array('base' => '/comment/' . $comment->getId() . '/reply'), array('base' => '/comment/' . $comment->getId() . '/replyform', 'params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), array('toggle' => 'blind'));?></span>
<?php     endif;?>
                |
      <span class="nodeAdminLink commentAdminLink">
<?php     if (!$comment->isOwnedBy($this->User)):?>
<?php       if ($this->User->hasPermission(array('comment edit any'))):?>
        <a href="<?php echo $this->Request->createUri(array('base' => '/comment/' . $comment->getId() . '/edit'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/edit.gif" alt="<?php echo _('Edit');?>" title="<?php echo _('Edit this comment');?>" /></a>
<?php       endif;?>
<?php       if ($this->User->hasPermission(array('comment delete any'))):?>
        <a href="<?php echo $this->Request->createUri(array('base' => '/comment/' . $comment->getId() . '/delete'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/delete.gif" alt="<?php echo _('Delete');?>" title="<?php echo _('Delete this comment');?>" /></a>
<?php       endif;?>
<?php       if ($this->User->hasPermission(array('comment move any'))):?>
        <a href="<?php echo $this->Request->createUri(array('base' => '/comment/' . $comment->getId() . '/move'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/move.gif" alt="<?php echo _('Move');?>" title="<?php echo _('Move this comment');?>" /></a>
<?php       endif;?>
<?php     else:?>
<?php       if ($this->User->hasPermission(array('comment edit own'))):?>
        <a href="<?php echo $this->Request->createUri(array('base' => '/comment/' . $comment->getId() . '/edit'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/edit.gif" alt="<?php echo _('Edit');?>" title="<?php echo _('Edit this comment');?>" /></a>
<?php       endif;?>
<?php       if ($this->User->hasPermission(array('comment delete own'))):?>
        <a href="<?php echo $this->Request->createUri(array('base' => '/comment/' . $comment->getId() . '/delete'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/delete.gif" alt="<?php echo _('Delete');?>" title="<?php echo _('Delete this comment');?>" /></a>
<?php       endif;?>
<?php       if ($this->User->hasPermission(array('comment move own'))):?>
        <a href="<?php echo $this->Request->createUri(array('base' => '/comment/' . $comment->getId() . '/move'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/move.gif" alt="<?php echo _('Move');?>" title="<?php echo _('Move this comment');?>" /></a>
<?php       endif;?>
<?php     endif;?>
      </span>
    </div>
    <div class="commentContentFoot"></div>
  </div>
  <div class="commentFoot"></div>
</div>
<?php     if ($comment_view == 'nested'):?>
<div id="xigg-showcommentreplies<?php echo $comment->getId();?>">
<?php
            $comment_id = $comment->getId();
            if (!empty($comments_replies[$comment_id]) && $comments_replies[$comment_id]->size() > 0) {
              $comment_replies =& $comments_replies[$comment_id];
              $comment_replies->rewind();
              include $this->getTemplatePath('xigg_main_showcommentreplies.tpl');
            }
?>
</div>
<?php     endif;?>
<?php   endwhile;?>
<table class="nodesNav nodesNavBottom">
  <tr>
    <td class="nodesNavPages"><?php $this->PageNavRemote->write('xigg-showcomments' . $node->getId(), $comment_pages, $comment_page->getPageNumber(), array('base' => '/node/' . $node->getId(), 'params' => array('comment_view' => $comment_view), 'fragment' => 'nodeComments'), array('base' => '/node/' . $node->getId() . '/comments', 'params' => array('comment_view' => $comment_view, XIGG_REQUEST_AJAX_PARAM => 1), 'fragment' => 'nodeComments'), 'comment_page');?></td>
  </tr>
</table>
<?php endif;?>