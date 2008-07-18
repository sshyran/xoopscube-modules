<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Edit comment');?></div>

<?php if (!empty($comment_preview)):?>
<h4 class="nodeFormCaption"><?php echo _('Preview');?></h4>
<div class="comment">
  <div class="commentHead"></div>
  <div class="commentTitle">
    <span class="commentTitleText"><?php _h($comment_preview->getLabel());?></span>
  </div>
  <div class="commentContent">
    <div class="commentBody">
      <?php echo $comment_preview->get('body_html');?>
    </div>
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

<h4 class="nodeFormCaption"><?php echo _('Edit comment');?></h4>
<div class="nodeForm">
<?php foreach ($comment_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
  <?php $this->HTML->formTag('post', array('base' => '/comment/' . $comment->getId() . '/edit'));?>
<?php foreach ($comment_form->getElementNames() as $name):?>
    <p>
<?php   if ($name == 'body_html'):?>
      <label><?php _h($comment_form->getElementLabel($name));?> <?php $this->HTML->linkToToggle('SubmitCommentForm-' . $name, true);?></label>
      <div id="SubmitCommentForm-<?php echo $name;?>">
       <?php $comment_form->printHTMLFor($name, array('id' => 'SubmitCommentForm-' . $name . '-html'));?>
<?php     if (isset($body_html_regenerate) && !$body_html_regenerate):?>
        <br /><input type="checkbox" name="body_html_regenerate" value="1" /><?php echo _('Regenerate HTML from the original body text');?>
<?php     else:?>
        <br /><input type="checkbox" name="body_html_regenerate" value="1" checked="checked" /><?php echo _('Regenerate HTML from the original body text');?>
<?php     endif;?>
      </div>
<?php   elseif ($name == 'content_syntax'):?>
      <label><?php _h($comment_form->getElementLabel($name));?></label>
      <?php $comment_form->printHTMLFor($name, array('id' => 'SubmitCommentForm-contentSyntax'));?>
      <input type="submit" name="change_syntax" value="<?php echo _('Update');?>" class="button" />
<?php   else:?>
      <label><?php _h($comment_form->getElementLabel($name));?></label>
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
  <?php $comment_form->printHTMLForToken();?>
  <?php $this->HTML->formTagEnd();?>
</div>
<script type="text/javascript">
Event.observe($('SubmitCommentForm-contentSyntax'), 'change', function(evt) {
  new Ajax.Updater(
    'Xigg-Main-EditCommentForm',
    '<?php echo $this->Request->createUri(array('base' => '/comment/' . $comment->getId() . '/edit'));?>',
    {
      evalScripts: true,
      method: 'post',
      parameters: evt.element().up('form').serialize()
    }
  );
});
Event.observe($('SubmitCommentForm-body_html-html'), 'change', function(evt)
{
    $('SubmitCommentForm-body_html').getElementsByTagName('input')[0].checked = '';
});
</script>