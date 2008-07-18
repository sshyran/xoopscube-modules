<?php $this->loadHelpers(array('XiggTime', 'HTML')); // not required in PHP5 ?>
<h3><?php _h($entity->getLabel());?></h3>

<table class="vertical">
  <thead>
    <tr><td colspan="2"></td></tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="2"></td>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <th><?php echo _('Name');?></th>
      <td><?php _h($entity->getLabel());?></td>
    </tr>
    <tr>
      <th><?php echo _('Created');?></th>
      <td><?php _h($this->XiggTime->ago($entity->getTimeCreated()));?></td>
    </tr>
    <tr>
      <th><?php echo _('Members');?></th>
      <td><?php echo $entity->getMemberCount();?></td>
    </tr>
    <tr>
      <th><?php echo _('Permissions');?></th>
      <td>
        <dl id="rolePermissions" style="margin-bottom:5px;">
<?php $entity_permissions = $entity->getPermissions();?>
<?php foreach (array_keys($permissions) as $perm_group):?>
          <dt><?php _h($perm_group);?><dt>
<?php   foreach ($permissions[$perm_group] as $perm => $perm_label):?>
<?php     if (in_array($perm, $entity_permissions)):?>
          <dd style="color: #000;"><?php _h($perm_label);?></dd>
<?php     else:?>
          <dd style="color: #ccc;"><?php _h($perm_label);?></dd>
<?php     endif;?>
<?php   endforeach;?>
<?php endforeach;?>
        </dl>
        <p><?php $this->HTML->linkToToggle('rolePermissions', true, _('Hide list'), _('Show list'));?></p>
      </td>
    </tr>
    <tr>
      <th><?php echo _('Action');?></th>
      <td><?php $this->HTML->linkTo(_('Edit'), array('base' => '/role/' . $entity->getId() . '/edit'));?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/role/' . $entity->getId() . '/delete'));?></td>
    </tr>
  </tbody>
</table>
<div id="xigg-admin-role-member-list">
<?php
include $this->getTemplatePath('xigg_admin_role_member_list.tpl');
?>
</div>