<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Reply');?></div>
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
<?php include $this->getTemplatePath('xigg_main_showcommentreplyform.tpl');?>
<script type="text/javascript">
$('SubmitCommentForm-contentSyntax').observe('change', function(evt) {
  new Ajax.Updater(
    'xigg-main-submitcommentreplyform',
    '<?php echo $this->Request->createUri(array('base' => sprintf('/comment/%d/reply', $comment->getId())));?>',
    {
      evalScripts: true,
      method: 'post',
      parameters: evt.element().up('form').serialize() + '&<?php echo XIGG_REQUEST_AJAX_PARAM;?>=1'
    }
  );
});
</script>