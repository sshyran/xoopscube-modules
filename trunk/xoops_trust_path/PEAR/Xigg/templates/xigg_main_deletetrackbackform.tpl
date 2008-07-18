<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Delete trackback');?></div>
<div class="nodeForm">
  <h4 class="nodeFormCaption"><?php echo _('Delete trackback');?></h4>
  <div class="exclamation">
    <p><?php echo _('Are you sure you want to delete this trackback?');?></p>
  </div>
<?php foreach ($trackback_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
  <?php $this->HTML->formTag('post', array('base' => '/trackback/' . $trackback->getId() . '/delete'));?>
  <p>
    <input type="submit" value="<?php echo _('Delete');?>" class="button" />
  </p>
  <?php $trackback_form->printHTMLForToken();?>
  <?php $this->HTML->formTagEnd();?>
</div>



