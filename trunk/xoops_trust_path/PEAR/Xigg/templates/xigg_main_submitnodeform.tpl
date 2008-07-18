<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->create();?><?php echo _('Submit news');?></div>
<?php if (!empty($node_preview)):?>
<h4 class="nodeFormCaption"><?php echo _('Preview');?></h4>
<div class="node nodePreview">
  <h2 class="nodeTitle">
  <?php _h($node_preview->get('title'));?>
  </h2>
  <div class="nodeContent clearfix">
<?php   if ($source = $node_preview->get('source')):?>
    <div class="nodeBodyScreenshot">
      <a href="<?php echo $source;?>" class="linkbubbler" title="<?php _h($node_preview->get('source_title'));?>"><?php echo $node_preview->getScreenshot();?></a>
    </div>
<?php   endif;?>
    <p class="nodeTeaser">
      <?php echo $node_preview->get('teaser_html');?>
    </p>
    <p class="nodeBody">
      <?php echo $node_preview->get('body_html');?>
    </p>
  </div>
</div>
<div class="nodePreviewHTML">
  <span><?php echo _('HTML output');?></span>
  <pre name="code" class="html"><?php _h(sprintf('<h2 class="nodeTitle">
  %s
</h2>
<div class="nodeContent">
  <p class="nodeTeaser">
    %s
  </p>
  <p class="nodeBody">
    %s
  </p>
</div>', $node_preview->get('title'), $node_preview->get('teaser_html'), $node_preview->get('body_html')));
?></pre>
</div>
<?php endif;?>

<div class="nodeForm">
  <a name="nodeForm"></a>
  <h4 class="nodeFormCaption"><?php echo _('Submit news');?></h4>
<?php foreach ($node_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
  <?php $this->HTML->formTag('post', array('base' => $node_form_action));?>
<?php foreach ($node_form->getElementNames() as $name):?>
  <p>
    <label><?php _h($node_form->getElementLabel($name));?></label>
<?php   if ($name == 'content_syntax'):?>
    <?php $node_form->printHTMLFor($name, array('id' => 'SubmitNodeForm-contentSyntax'));?>
    <input type="submit" name="change_syntax" value="<?php echo _('Update');?>" class="button" />
<?php   else:?>
    <?php $node_form->printHTMLFor($name);?>
<?php   endif;?>
  </p>
<?php   foreach ($node_form->getValidationErrorsFor($name) as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php   endforeach;?>
<?php endforeach;?>
  <p>
    <input type="submit" name="preview_form" value="<?php echo _('Preview');?>" class="button" />
    <input type="submit" name="submit_form" value="<?php echo _('Submit');?>" class="button" />
  </p>
  <?php $this->HTML->formTagEnd();?>
</div>
<script type="text/javascript">
$('SubmitNodeForm-contentSyntax').observe('change', function(evt) {
  new Ajax.Updater(
    'xigg-main-submitnodeform',
    '<?php echo $this->Request->createUri(array('base' => '/submit'));?>',
    {
      evalScripts: true,
      method: 'post',
      parameters: evt.element().up('form').serialize() + '&<?php echo XIGG_REQUEST_AJAX_PARAM;?>=1'
    }
  );
});
</script>