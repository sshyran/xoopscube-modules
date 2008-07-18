<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Move comment');?></div>
<div class="nodeForm">
  <h4 class="nodeFormCaption"><?php echo _('Move comment');?></h4>
<?php foreach ($comment_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
<?php $this->HTML->formTag('post', array('base' => '/comment/' . $comment->getId() . '/move'));?>
<?php foreach (array('move_to' => _('New parent comment ID (0 for top level comment):')) as $name => $label):?>
  <p>
    <?php _h($label);?><br />
    <?php $comment_form->printHTMLFor($name);?>
  </p>
<?php   foreach ($comment_form->getValidationErrorsFor($name) as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php   endforeach;?>
<?php endforeach;?>
  <p>
    <input type="submit" value="<?php echo _('Move');?>" class="button" />
  </p>
  <?php $comment_form->printHTMLForToken();?>
  <?php $this->HTML->formTagEnd();?>
</div>