<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Edit trackback');?></div>

<h4 class="nodeFormCaption"><?php echo _('Edit trackback');?></h4>
<div class="nodeForm">
<?php foreach ($trackback_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
  <?php $this->HTML->formTag('post', array('base' => '/trackback/' . $trackback->getId() . '/edit'));?>
<?php foreach ($trackback_form->getElementNames() as $name):?>
    <p>
      <label><?php _h($trackback_form->getElementLabel($name));?></label>
      <?php $trackback_form->printHTMLFor($name);?>
    </p>
<?php   foreach ($trackback_form->getValidationErrorsFor($name) as $error):?>
    <div class="stop">
      <p><?php _h($error);?></p>
    </div>
<?php   endforeach;?>
<?php endforeach;?>
    <p>
      <input type="submit" name="submit_form" value="<?php echo _('Send');?>" class="button" />
    </p>
  <?php $trackback_form->printHTMLForToken();?>
  <?php $this->HTML->formTagEnd();?>
</div>