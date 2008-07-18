<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'Token', 'HTML')); // not required in PHP5 ?>
<h3><?php echo _('Listing members');?></h3>
<div class="nodesSort">
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $member_sortby, 'xigg-admin-role-member-list', array('userid,ASC' => _('User ID, ascending'), 'userid,DESC' => _('User ID, descending'), 'created,DESC' => _('Date assigned role, descending'), 'created,ASC' => _('Date assigned role, ascending')), array('base' => '/role/' . $role_id . '/member/list'), _('Go'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), 'xigg-admin-role-member-list-select');?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/role/' . $role_id . '/member/submit'), array('id' => 'xigg-admin-role-member-list-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-role-member-list-form-checkall" type="checkbox" onclick="$$('#xigg-admin-role-member-list-form input.check').each(function(ele){ele.checked=$('xigg-admin-role-member-list-form-checkall').checked});" /></th>
        <th>&nbsp;</th>
        <th><?php echo _('User ID');?></th>
        <th><?php echo _('Username');?></th>
        <th><?php echo _('Email');?></th>
        <th><?php echo _('Date assigned role');?></th>
        <th scope="col"><?php echo _('Action');?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="4">
          <input type="submit" name="remove" value="<?php echo _('Remove');?>" />
        </td>
        <td colspan="3" class="right"><?php $this->PageNavRemote->write('xigg-admin-role-member-list', $member_pages, $member_page_requested, array('base' => '/role/' . $role_id . '/member/list', 'params' => array('sortby' => $member_sortby)), array('params' => array('sortby' => $member_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    <tbody>
<?php if ($member_entities->size() > 0):?>
<?php   $member_entities->rewind(); while ($e =& $member_entities->getNext()):?>
<?php     $member_identity =& $e->get('User');?>
      <tr>
        <td><input type="checkbox" class="check" name="members[]" value="<?php echo $e->getId();?>" /></td>
        <td><?php $member_identity->printHTMLImageLink();?></td>
        <td><?php _h($member_identity->getId());?></td>
        <td><?php $member_identity->printHTMLLink();?></td>
        <td><?php _h($member_identity->getEmail());?></td>
        <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
        <td><?php $this->HTML->linkTo(_('Remove'), array('base' => '/role/' . $role_id . '/member/' . $e->getId() . '/remove'));?></td>
      </tr>
<?php   endwhile; ?>
<?php else:?>
      <tr><td colspan="7">&nbsp;</td></tr>
<?php endif;?>
    </tbody>
  </table>
<input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_role_member_submit');?>" />
<?php $this->HTML->formTagEnd();?>

<div class="addEntityLink">
<?php $this->HTML->linkToRemote(_('Add member'), 'xigg-admin-role-member-list-update', array('base' => '/role/' . $role_id . '/member/add'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), array('toggle' => 1));?>
</div>

<div id="xigg-admin-role-member-list-update"></div>