<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML', 'XiggTime')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Edit news');?></div>

<?php if (!empty($node_preview)):?>
<h4 class="nodeFormCaption"><?php echo _('Preview');?></h4>
<div class="node nodePreview">
  <h2 class="nodeTitle"><?php _h($node_preview->get('title'));?></h2>
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
  <h4 class="nodeFormCaption"><?php echo _('Edit news');?></h4>
<?php foreach ($node_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
  <?php $this->HTML->formTag('post', array('base' => '/node/' . $node->getId() . '/edit'));?>
<?php foreach ($node_form->getElementNames() as $name):?>
  <p>
<?php   if ($name == 'teaser_html' || $name == 'body_html'):?>
    <label><?php _h($node_form->getElementLabel($name));?> <?php $this->HTML->linkToToggle('SubmitNodeForm-' . $name, true);?></label>
    <p id="SubmitNodeForm-<?php echo $name;?>">
    <?php $node_form->printHTMLFor($name, array('id' => 'SubmitNodeForm-' . $name . '-html'));?>
<?php     if ($name == 'teaser_html'):?>
<?php       if (isset($teaser_html_regenerate) && !$teaser_html_regenerate):?>
      <br /><input type="checkbox" name="teaser_html_regenerate" value="1" /><?php echo _('Regenerate HTML from the original teaser text');?>
<?php       else:?>
      <br /><input type="checkbox" name="teaser_html_regenerate" value="1" checked="checked" /><?php echo _('Regenerate HTML from the original teaser text');?>
<?php       endif;?>
<?php     elseif ($name == 'body_html'):?>
<?php       if (isset($body_html_regenerate) && !$body_html_regenerate):?>
      <br /><input type="checkbox" name="body_html_regenerate" value="1" /><?php echo _('Regenerate HTML from the original body text');?>
<?php       else:?>
      <br /><input type="checkbox" name="body_html_regenerate" value="1" checked="checked" /><?php echo _('Regenerate HTML from the original body text');?>
<?php       endif;?>
<?php     endif;?>
    </p>
<?php   elseif ($name == 'content_syntax'):?>
    <label><?php _h($node_form->getElementLabel($name));?></label>
    <?php $node_form->printHTMLFor($name, array('id' => 'SubmitNodeForm-contentSyntax'));?>
    <input type="submit" name="change_syntax" value="<?php echo _('Update');?>" class="button" />
<?php   elseif ($name == 'published'):?>
    <label><?php _h($node_form->getElementLabel($name));?></label><?php echo $this->XiggTime->ago($node_form->getValueFor($name));?>
<?php       if (!empty($published_update)):?>
    <input type="checkbox" name="published_update" value="1" checked="checked" /><?php echo _('Update published date');?>
<?php       else:?>
    <input type="checkbox" name="published_update" value="1" /><?php echo _('Update published date');?>
<?php       endif;?>
<?php   else:?>
    <label><?php _h($node_form->getElementLabel($name));?></label>
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
    'xigg-main-editnodeform',
    '<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/edit'));?>',
    {
      evalScripts: true,
      method: 'post',
      parameters: evt.element().up('form').serialize() + '&<?php echo XIGG_REQUEST_AJAX_PARAM;?>=1'
    }
  );
});

$('SubmitNodeForm-teaser_html-html').observe('change', function(evt) {
  $('SubmitNodeForm-teaser_html').getElementsByTagName('input')[0].checked = '';
});
$('SubmitNodeForm-body_html-html').observe('change', function(evt) {
  $('SubmitNodeForm-body_html').getElementsByTagName('input')[0].checked = '';
});
</script>