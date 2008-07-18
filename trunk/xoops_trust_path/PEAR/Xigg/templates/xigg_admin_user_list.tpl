<?php $this->loadHelpers(array('Token', 'PageNavRemote', 'HTML', 'Token')); // not required in PHP5 ?>
<h3><?php echo _('Listing users');?></h3>
<div class="nodesSort">
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $requested_sortby, 'xigg-admin-user-list', array('id,ASC' => _('User ID, ascending'), 'id,DESC' => _('User ID, descending'), 'name,ASC' => _('User name, ascending'), 'name,DESC' => _('User name, descending')), array('base' => '/user/list'), _('Go'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/user/submit', 'params' => array('sortby' => $requested_sortby, 'page' => $identity_page_requested)), array('id' => 'xigg-admin-user-list-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-user-list-form-checkall" type="checkbox" onclick="$$('#xigg-admin-user-list-form input.check').each(function(ele){ele.checked=$('xigg-admin-user-list-form-checkall').checked});" /></th>
        <th>&nbsp;</th>
        <th><?php echo _('User ID');?></th>
        <th><?php echo _('Username');?></th>
        <th><?php echo _('Email');?></th>
        <th width="35%"><?php echo _('Role');?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="4">
          <select name="action">
            <option><?php echo _('For each selected user: ');?></option>
            <optgroup label="<?php echo _('Assign a role');?>">
<?php foreach (array_keys($roles) as $role_id):?>
              <option value="assign,<?php echo $role_id;?>"><?php _h($roles[$role_id]->getLabel());?></option>
<?php endforeach;?>
            </optgroup>
            <optgroup label="<?php echo _('Remove a role');?>">
<?php foreach (array_keys($roles) as $role_id):?>
              <option value="remove,<?php echo $role_id;?>"><?php _h($roles[$role_id]->getLabel());?></option>
<?php endforeach;?>
            </optgroup>
          </select>
          <input type="submit" value="<?php echo _('Update');?>" />
        </td>
        <td class="right" colspan="2"><?php $this->PageNavRemote->write('xigg-admin-user-list', $identity_pages, $identity_page_requested, array('base' => '/user/list', 'params' => array('sortby' => $requested_sortby)), array('params' => array('sortby' => $requested_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    <tbody>
<?php $identity_objects->rewind(); while ($identity =& $identity_objects->getNext()):?>
<?php   $identity_id = $identity->getId();?>
      <tr>
        <td><input type="checkbox" class="check" name="users[<?php echo $identity_id;?>]" value="<?php echo $identity_id;?>" /></td>
        <td><?php $identity->printHTMLImageLink();?></td>
        <td><?php _h($identity->getId());?></td>
        <td><?php $identity->printHTMLLink();?></td>
        <td><?php _h($identity->getEmail());?></td>
        <td>
<?php   if (!empty($user_roles[$identity_id])):?>
<?php     $identity_roles = array_intersect_key($roles, $user_roles[$identity_id]); $identity_roles_buf = array();?>
<?php     foreach (array_keys($identity_roles) as $role_id):?>
<?php        $identity_roles_buf[] = $this->HTML->createLinkTo($roles[$role_id]->getLabel(), array('base' => '/role/' . $role_id));?>
<?php     endforeach;;?>
<?php     echo implode(', ', $identity_roles_buf);?>
<?php   endif;?>
        </td>
      </tr>
<?php endwhile;?>
    </tbody>
  </table>
<input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_user_submit');?>" />
<?php $this->HTML->formTagEnd();?>