<?php $this->loadHelpers(array('HTML')); // not required in PHP5 ?>
<h3><?php echo _('Uninstall Plugin');?></h3>
<?php if ($entity_form_errors = $entity_form->getFormValidationErrors()):?>
<?php   foreach ($entity_form_errors as $entity_form_error):?>
<div class="stop">
  <p><?php _h($entity_form_error);?></p>
</div>
<?php   endforeach;?>
<?php endif;?>

<?php $this->HTML->formTag('post', array('base' => '/plugin/' . $entity_id . '/uninstall'));?>
<table class="vertical">
  <thead>
    <tr><td colspan="2"></td></tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="2"><input type="submit" value="<?php echo _('Uninstall');?>" class="button" /></td>
    </tr>
  </tfoot>
  <tbody>
  <tr>
    <th><?php echo _('Name');?></th>
    <td><?php _h($entity_form->getValueFor('name'));?></td>
  </tr>
  <tr>
    <th><?php echo _('Version');?></th>
    <td><?php _h($entity_form->getValueFor('version'));?></td>
  </tr>
  </tbody>
</table>
<?php $entity_form->printHTMLForToken();?>
<?php $this->HTML->formTagEnd();?>