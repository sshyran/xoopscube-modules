<?php $this->loadHelpers(array('HTML')); // not required in PHP5 ?>
<h3><?php echo _('Add category');?></h3>
<?php if ($entity_form_errors = $entity_form->getFormValidationErrors()):?>
<ul>
<?php   foreach ($entity_form_errors as $entity_form_error):?>
  <li><?php _h($entity_form_error);?></li>
<?php   endforeach;?>
</ul>
<?php endif;?>
<?php $this->HTML->formTag('post', array('base' => '/category/add'));?>
  <table class="vertical">
    <thead>
      <tr><td colspan="2"></td></tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="2" class="buttons">
          <button type="submit" class="positive"><?php echo _('Create');?></button>
          <a href="<?php echo $this->Request->createUri(array('base' => '/category'));?>"><?php echo _('Cancel');?></a>
        </td>
      </tr>
    </tfoot>
    <tbody>
<?php foreach ($entity_form->getElementNames() as $name):?>
      <tr <?php if ($entity_form->isHidden($name)):?>style="display:none;"<?php endif;?>>
        <th><?php _h($entity_form->getElementLabel($name));?></th>
        <td><?php $entity_form->printHTMLFor($name);?>
<?php   foreach ($entity_form->getValidationErrorsFor($name) as $error):?>
          <div class="error">
            <p><?php _h($error);?></p>
          </div>
<?php   endforeach;?>
        </td>
      </tr>
<?php endforeach;?>
  </table>
<?php $this->HTML->formTagEnd();?>