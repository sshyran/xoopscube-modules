<?php $this->loadHelpers(array('HTML')); // not required in PHP5 ?>
<h3><?php echo _('Remove member');?></h3>
<?php if ($entity_form_errors = $entity_form->getFormValidationErrors()):?>
<ul>
<?php   foreach ($entity_form_errors as $entity_form_error):?>
  <li><?php _h($entity_form_error);?></li>
<?php   endforeach;?>
</ul>
<?php endif;?>
<?php $this->HTML->formTag('post', array('base' => '/role/' . $role_id . '/member/' . $entity_id . '/remove'));?>
<table class="vertical">
  <thead>
    <tr><td colspan="2"></td></tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="2"><input type="submit" value="<?php echo _('Delete');?>" /></td>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <th><?php echo _('User');?></th>
      <td><?php $user =& $entity->get('User'); $user->printHTMLLink();?></td>
    </tr>
    <tr>
      <th><?php echo _('Role');?></th>
      <td><?php _h($role->getLabel());?></td>
    </tr>
  </tbody>
</table>
<?php $entity_form->printHTMLForToken();?>
<?php $this->HTML->formTagEnd();?>