<?php $this->loadHelpers(array('HTML')); // not required in PHP5 ?>
<h4 class="nodeFormCaption"><?php echo _('Post Reply');?></h4>
<div class="nodeCommentForm">
<?php   foreach ($comment_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php   endforeach;?>
  <?php $this->HTML->formTag('post', array('base' => sprintf('/comment/%d/reply', $comment_id)), array('id' => 'Xigg-CommentReplyForm' . $comment_id));?>
<?php   foreach ($comment_form->getElementNames() as $name):?>
  <p>
      <label><?php _h($comment_form->getElementLabel($name));?></label>
<?php     if ($name == 'content_syntax'):?>
      <?php $comment_form->printHTMLFor($name, array('id' => 'SubmitCommentForm-contentSyntax'));?>
      <input type="submit" name="change_syntax" value="<?php echo _('Update');?>" class="button" />
<?php     else:?>
      <?php $comment_form->printHTMLFor($name);?>
<?php     endif;?>
  </p>
<?php     foreach ($comment_form->getValidationErrorsFor($name) as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php     endforeach;?>
<?php   endforeach;?>
  <p>
    <input type="submit" name="preview_form" value="<?php echo _('Preview');?>" class="button" />
    <input type="submit" name="submit_form" value="<?php echo _('Send');?>" class="button" />
  </p>
  <?php $this->HTML->formTagEnd();?>
</div>
<script type="text/javascript">
$('Xigg-CommentReplyForm<?php echo $comment_id;?>').getElementsByTagName('textarea')[0].focus();
</script>