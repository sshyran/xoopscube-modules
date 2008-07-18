<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Add Comment');?></div>
<?php if (!empty($comment_preview)):?>
<h4 class="nodeFormCaption"><?php echo _('Preview');?></h4>
<div class="comment">
  <div class="commentHead"></div>
  <div class="commentTitle">
    <span class="commentTitleText"><?php _h($comment_preview->getLabel());?></span>
  </div>
  <div class="commentContent">
    <div class="commentData">&nbsp;</div>
    <div class="commentBody">
      <?php echo $comment_preview->get('body_html');?>
    </div>
    <div class="commentCtrl">&nbsp;</div>
    <div class="commentContentFoot"></div>
  </div>
  <div class="commentFoot"></div>
</div>
<div class="commentPreviewHTML">
  <span><?php echo _('HTML output');?></span>
  <pre name="code" class="html"><?php _h(sprintf('<div class="commentTitle">
  <span class="commentTitleText">%s</span>
</div>
<div class="commmentContent">
  <div class="commentBody">
    %s
  </div>
</div>', $comment_preview->get('title'), $comment_preview->get('body_html')));
?></pre>
</div>
<?php endif;?>

<h4 class="nodeFormCaption"><?php echo _('Add Comment');?></h4>
<div class="nodeCommentForm">
<?php foreach ($comment_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
  <?php $this->HTML->formTag('post', array('base' => '/node/' . $node->getId() . '/comment'));?>
<?php foreach ($comment_form->getElementNames() as $name):?>
  <p>
    <label><?php _h($comment_form->getElementLabel($name));?></label>
<?php   if ($name == 'content_syntax'):?>
    <?php $comment_form->printHTMLFor($name, array('id' => 'SubmitCommentForm-contentSyntax'));?>
    <input type="submit" name="change_syntax" value="<?php echo _('Update');?>" class="button" />
<?php   else:?>
    <?php $comment_form->printHTMLFor($name);?>
<?php   endif;?>
  </p>
<?php   foreach ($comment_form->getValidationErrorsFor($name) as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php   endforeach;?>
<?php endforeach;?>
  <p>
    <input type="submit" name="preview_form" value="<?php echo _('Preview');?>" class="button" />
    <input type="submit" name="submit_form" value="<?php echo _('Send');?>" class="button" />
  </p>
  <?php $this->HTML->formTagEnd();?>
</div>
<script type="text/javascript">
$('SubmitCommentForm-contentSyntax').observe('change', function(evt) {
  new Ajax.Updater(
    'xigg-main-submitcommentform',
    '<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/comment'));?>',
    {
      evalScripts: true,
      method: 'post',
      parameters: evt.element().up('form').serialize() + '&<?php echo XIGG_REQUEST_AJAX_PARAM;?>=1'
    }
  );
});
</script>