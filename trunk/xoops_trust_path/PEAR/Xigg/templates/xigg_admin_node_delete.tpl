<?php $this->loadHelpers(array('HTML')); // not required in PHP5 ?>
<h3><?php echo _('Delete article');?></h3>

<?php if ($entity_form_errors = $entity_form->getFormValidationErrors()):?>
<ul>
<?php foreach ($entity_form_errors as $entity_form_error):?>
  <li><?php _h($entity_form_error);?></li>
<?php endforeach;?>
</ul>
<?php endif;?>

<?php $this->HTML->formTag('post', array('base' => '/node/' . $node_id . '/delete'));?>
  <table class="vertical">
    <thead>
      <tr><td colspan="2"></td></tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" value="<?php echo _('Delete');?>" class="button" /></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th><?php echo _('Title');?></th>
        <td><?php _h($entity->getLabel());?></td>
      </tr>
    </tbody>
  </table>
<?php $entity_form->printHTMLForToken();?>
<?php $this->HTML->formTagEnd();?>