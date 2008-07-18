<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'Token', 'HTML')); // not required in PHP5 ?>
<h3><?php echo _('Listing roles');?></h3>
<div class="nodesSort">
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $requested_sortby, 'xigg-admin-role-list', array('name,ASC' => _('Role name, ascending'), 'name,DESC' => _('Role name, descending'), 'created,ASC' => _('Created date, ascending'), 'created,DESC' => _('Created date, descending'), 'member_count,DESC' => _('Member count')), array('base' => '/role/list'), _('Go'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/role/submit'), array('id' => 'xigg-admin-role-list-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-role-list-form-checkall" type="checkbox" onclick="$$('#xigg-admin-role-list-form input.check').each(function(ele){ele.checked=$('xigg-admin-role-list-form-checkall').checked});" /></th>
        <th><?php echo _('Name');?></th>
        <th><?php echo _('Created');?></th>
        <th><?php echo _('Type');?></th>
        <th><?php echo _('Members');?></th>
        <th scope="col"><?php echo _('Action');?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="3">
          <!--//<input type="submit" name="delete" value="<?php echo _('Edit');?>" />//-->
          <!--//<input type="submit" name="delete" value="<?php echo _('Delete');?>" />//-->
        </td>
        <td colspan="3" class="right">&nbsp;<?php $this->PageNavRemote->write('xigg-admin-role-list', $entity_pages, $entity_page_requested, array('base' => '/role/list', 'params' => array('sortby' => $requested_sortby)), array('params' => array('sortby' => $requested_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    <tbody>
<?php if ($entity_objects->size() > 0):?>
<?php   while ($e =& $entity_objects->getNext()):?>
      <tr>
        <td><input type="checkbox" class="check" name="roles[]" value="<?php echo $e->getId();?>" /></td>
        <td><?php _h($e->getLabel(), 100);?></td>
        <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
        <td><?php if ($e->get('system')):?><?php echo _('System');?><?php else:?><?php echo _('Custom');?><?php endif;?></td>
        <td><?php echo $e->getMemberCount();?></a></td>
        <td><?php $this->HTML->linkTo(_('Details'), array('base' => '/role/' . $e->getId()));?> <?php $this->HTML->linkTo(_('Edit'), array('base' => '/role/' . $e->getId() . '/edit'));?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/role/' . $e->getId() . '/delete'));?></td>
      </tr>
<?php   endwhile; ?>
<?php else:?>
      <tr><td colspan="6"></td></tr>
<?php endif;?>
    </tbody>
  </table>
<input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_role_submit');?>" />
<?php $this->HTML->formTagEnd();?>

<div class="addEntityLink">
<?php $this->HTML->linkToRemote(_('Add role'), 'xigg-admin-role-list-update', array('base' => '/role/add'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), array('toggle' => 1));?>
</div>

<div id="xigg-admin-role-list-update"></div>