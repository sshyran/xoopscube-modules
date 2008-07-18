<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'Token', 'HTML')); // not required in PHP5 ?>
<h3><?php echo _('Listing tags');?></h3>
<div class="nodesSort">
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $requested_sortby, 'xigg-admin-tag-list', array('name,ASC' => _('Tag name, ascending'), 'name,DESC' => _('Tag name, descending'), 'created,ASC' => _('Created date, ascending'), 'created,DESC' => _('Created date, descending')), array('base' => '/tag/list'), _('Go'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/tag/submit'), array('id' => 'xigg-admin-tag-list-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-tag-list-form-checkall" type="checkbox" onclick="$$('#xigg-admin-tag-list-form input.check').each(function(ele){ele.checked=$('xigg-admin-tag-list-form-checkall').checked});" /></th>
        <th><?php echo _('Name');?></th>
        <th><?php echo _('Created');?></th>
        <th><?php echo _('Articles');?></th>
        <th scope="col"><?php echo _('Action');?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" name="empty" value="<?php echo _('Empty');?>" />
          <input type="submit" name="delete" value="<?php echo _('Delete');?>" />
        </td>
        <td colspan="3" class="right"><?php $this->PageNavRemote->write('xigg-admin-tag-list', $entity_pages, $entity_page_requested, array('base' => '/tag/list', 'params' => array('sortby' => $requested_sortby)), array('params' => array('sortby' => $requested_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    <tbody>
<?php if ($entity_objects->size() > 0):?>
<?php   while ($e =& $entity_objects->getNext()):?>
<?php     $tag_nodes =& $e->get('Nodes');?>
      <tr>
        <td><input type="checkbox" class="check" name="tags[]" value="<?php echo $e->getId();?>" /></td>
        <td><?php _h(Sabai_I18N::strcutMore($e->getLabel(), 100));?></td>
        <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
        <td><?php echo $tag_nodes->size();?></td>
        <td><?php $this->HTML->linkTo(_('Details'), array('base' => '/tag/' . $e->getId()));?> <?php $this->HTML->linkTo(_('Edit'), array('base' => '/tag/' . $e->getId() . '/edit'));?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/tag/' . $e->getId() . '/delete'));?></td>
      </tr>
<?php   endwhile; ?>
<?php else:?>
      <tr><td colspan="6"></td></tr>
<?php endif;?>
    </tbody>
  </table>
<input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_tag_submit');?>" />
<?php $this->HTML->formTagEnd();?>

<div class="addEntityLink">
<?php $this->HTML->linkToRemote(_('Add tag'), 'xigg-admin-tag-list-update', array('base' => '/tag/add'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), array('toggle' => 1));?>
</div>

<div id="xigg-admin-tag-list-update"></div>

<h3><?php echo _('Delete empty tags');?></h3>
<p><?php echo _('Press the button below to delete all tags that do not have any nodes assciated with.');?></p>
<?php $this->HTML->formTag('post', array('base' => '/tag/delete_empty_tags'));?>
  <input type="submit" value="<?php echo _('Delete empty tags');?>" />
  <input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_tag_delete_empty_tags');?>" />
</form>