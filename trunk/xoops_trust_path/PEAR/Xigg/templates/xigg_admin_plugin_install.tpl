<?php $this->loadHelpers(array('HTML')); // not required in PHP5 ?>
<h3><?php echo _('Install Plugin');?></h3>
<?php foreach ($plugin_params_form->getFormValidationErrors() as $error):?>
<div class="stop">
  <p><?php _h($error);?></p>
</div>
<?php endforeach;?>
<?php $this->HTML->formTag('post', array('base' => '/plugin/install/' . $plugin_name));?>
<table class="vertical">
  <thead>
    <tr><td colspan="2"></td></tr>
  </thead>
  <tfoot>
    <tr><td colspan="2"><input type="submit" value="<?php echo _('Submit');?>" /></td></tr>
  </tfoot>
  <tbody>
  <tr>
    <th><?php echo _('Name');?></th>
    <td><?php _h($plugin_name);?></td>
  </tr>
  <tr>
    <th><?php echo _('Version');?></th>
    <td><?php _h($plugin_version);?></td>
  </tr>
<?php if (!empty($plugins_required) || !empty($php_required)):?>
  <tr>
    <th><?php echo _('Dependency');?></th>
    <td>
      <dl>
<?php   if (!empty($php_required)):?>
        <dt>PHP</dt>
        <dd><?php _h($php_required);?></dd>
<?php   endif;?>
<?php   if (!empty($plugins_required)):?>
        <dt><?php echo _('Plugins');?></dt>
        <dd>
          <ul>
<?php     foreach($plugins_required as $plugin_required):?>
            <li><?php _h($plugin_required['name']);?><?php if (isset($plugin_required['version'])):?> <?php _h($plugin_required['version']);?><?php endif;?></li>
<?php     endforeach; ?>
          </ul>
        </dd>
<?php   endif;?>
      </dl>
    </td>
  </tr>
<?php endif;?>
  <tr>
    <th><?php echo _('Summary');?></th>
    <td><?php _h($plugin_summary);?></td>
  </tr>
  <tr>
    <th><?php echo _('Description');?></th>
    <td></td>
  </tr>
  <tr>
    <th><?php echo _('Options');?></th>
    <td>
      <dl>
<?php foreach($plugin_params_form->getElementNames() as $param_name):?>
<?php   if (!in_array($param_name, array('_active', '_priority'))):?>
        <dt><?php _h($plugin_params_form->getElementLabel($param_name));?></dt>
        <dd>
<?php     $plugin_params_form->printHTMLFor($param_name);?>
<?php     foreach ($plugin_params_form->getValidationErrorsFor($param_name) as $error):?>
         <div class="stop">
           <p><?php _h($error);?></p>
         </div>
<?php     endforeach;?>
<?php   endif;?>
       </dd>
<?php endforeach;?>
      </dl>
    </td>
  </tr>
  <tr>
    <th><?php _h($plugin_params_form->getElementLabel('_active'));?></th>
    <td><?php $plugin_params_form->printHTMLFor('_active');?></td>
  </tr>
  <tr>
    <th><?php _h($plugin_params_form->getElementLabel('_priority'));?></th>
    <td><?php $plugin_params_form->printHTMLFor('_priority');?></td>
  </tr>
  </tbody>
</table>
<?php $this->HTML->formTagEnd();?>