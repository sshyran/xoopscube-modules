<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Publish news');?></div>
<div class="nodeForm">
  <h4 class="nodeFormCaption"><?php echo _('Publish news');?></h4>
  <div class="exclamation">
    <p><?php echo _('Are you sure you want to publish this news item?');?></p>
  </div>
<?php foreach ($node_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
  <?php $this->HTML->formTag('post', array('base' => '/node/' . $node->getId() . '/publish'));?>
  <p>
    <input type="submit" value="<?php echo _('Publish');?>" class="button" />
  </p>
  <?php $node_form->printHTMLForToken();?>
  <?php $this->HTML->formTagEnd();?>
</div>



