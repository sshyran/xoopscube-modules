<?php $this->loadHelpers(array('XiggTime', 'HTML')); // not required in PHP5 ?>
<?php if ($comment_replies->size() > 0):?>
<?php $node_user =& $node->get('User');?>
<?php   while ($comment =& $comment_replies->getNext()):?>
<a name="comment<?php echo $comment->getId();?>"></a>
<?php     $comment_user =& $comment->get('User');?>
<?php     if ($comment_user->getId() == $node_user->getId()):?>
<div class="comment commentByPoster" style="margin-left:<?php echo 10*($comment->parentsCount());?>px;">
<?php     else:?>
<div class="comment" style="margin-left:<?php echo 10*($comment->parentsCount());?>px;">
<?php     endif;?>
  <div class="commentHead"></div>
  <div class="commentTitle">
    <span class="toggleButton commentTitleToggle"><?php $this->HTML->linkToToggle('commentContent' . $comment->getId(), false, _('[-]'), _('[+]'));?></span>
    <span class="commentTitleText"><?php _h($comment->getLabel());?>&nbsp;</span>
  </div>
  <div id="commentContent<?php echo $comment->getId();?>" class="commentContent">
    <div class="commentData">
<?php     if ($comment_pid = $comment->getVar('parent')):?>
<?php   printf(_('%s posted <strong>%s</strong> in reply to <a href="#comment%d">#%d</a>'), $comment_user->getHTMLLink(), $this->XiggTime->ago($comment->getTimeCreated()), $comment_pid, $comment_pid);?>
<?php     else:?>
<?php   printf(_('%1$s posted <strong>%2$s</strong>'), $comment_user->getHTMLLink(), $this->XiggTime->ago($comment->getTimeCreated()), $comment->getVar('parent'));?>
<?php     endif;?>
    </div>
    <div class="commentPoster"><?php echo $comment_user->getHTMLImageLink(32, 32);?></div>
    <div class="commentBody">
      <?php echo $comment->get('body_html');?>
      <div class="commentReplyForm" id="xigg-shownodecommentreplyform<?php echo $comment->getId();?>"></div>
    </div>
    <div class="commentCtrl">
      <span>
        <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment->getId()), 'fragment' => 'comment' . $comment->getId()));?>">#<?php echo $comment->getId();?></a>
      </span>
<?php     if ($comment_form_show):?>
      |
      <span class="commentReply">
      <?php $this->HTML->linkToRemote(_('Reply'), 'xigg-shownodecommentreplyform' . $comment->getId(), array('base' => '/comment/' . $comment->getId() . '/reply'), array('base' => '/comment/' . $comment->getId() . '/replyform', 'params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), array('toggle' => 'blind'));?>
      </span>
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
<?php   endwhile;?>
<?php else:?>
<div class="exclamation">
  <p><?php echo _('No comments for this entry yet');?></p>
</div>
<?php endif;?>