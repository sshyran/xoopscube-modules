<?php
$this->loadHelpers(array('HTML')); // not required in PHP5
$breadcrumb_html = array();
$breadcrumb_html[] = sprintf('<a href="%s">%s</a>', $this->Request->getScriptUri(), h(_('Home')));
$breadcrumb_html[] = $breadcrumb_current = _('Assign roles by group');
?>
<div class="nodesBeadcrumb"><?php echo implode(' &#8250; ', $breadcrumb_html);?></div>
<h1><?php _h($breadcrumb_current);?></h1>
<h3><?php _h($breadcrumb_current);?></h3>
<div class="exclamation">
<?php _h(_('Roles assigned to each user by group on this page will not display as assigned roles on the user listing page nor on the role members list.'));?>
</div>
<div class="exclamation">
<?php _h(_('The default administrator group or groups with module administration rights are not listed here because those groups will have all the available permissions granted automatically by the system.'));?>
</div>
<?php if ($form_errors = $form->getFormValidationErrors()):?>
<ul>
<?php   foreach ($form_errors as $form_error):?>
  <li><?php _h($form_error);?></li>
<?php   endforeach;?>
</ul>
<?php endif;?>
<?php $this->HTML->formTag('post');?>
  <table class="vertical">
    <thead>
      <tr><td colspan="2"></td></tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" value="<?php _h(_('Update'));?>" class="button" /></td>
      </tr>
    </tfoot>
    <tbody>
<?php foreach ($form->getElementNames() as $name):?>
      <tr <?php if ($form->isHidden($name)):?>style="display:none;"<?php endif;?>>
        <th><?php _h($form->getElementLabel($name));?></th>
        <td><?php $form->printHTMLFor($name);?>
<?php   foreach ($form->getValidationErrorsFor($name) as $error):?>
          <div class="error">
            <p><?php _h($error);?></p>
          </div>
<?php   endforeach;?>
        </td>
      </tr>
<?php endforeach;?>
  </table>
<?php $this->HTML->formTagEnd();?>