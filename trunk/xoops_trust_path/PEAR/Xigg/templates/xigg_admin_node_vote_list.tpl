<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'Token', 'HTML')); // not required in PHP5 ?>
<h3><?php _h($this->__('Listing votes for "%s"', $node->getLabel()));?></h3>
<?php if ($vote_objects->size() > 0):?>
<div class="nodesSort">
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $vote_sortby, 'xigg-admin-node-vote-list', array('created,DESC' => _('Newest first'), 'created,ASC' => _('Oldest first')), array('base' => '/node/' . $node_id . '/vote'), _('Go'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), 'xigg-admin-node-vote-list-select');?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/node/' . $node_id . '/vote/submit'), array('id' => 'xigg-admin-node-vote-list-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-node-vote-list-form-checkall" type="checkbox" onclick="$$('#xigg-admin-node-vote-list-form input.check').each(function(ele){ele.checked=$('xigg-admin-node-vote-list-form-checkall').checked});" /></th>
        <th><?php echo _('Voter');?></th>
        <th><?php echo _('Score');?></th>
        <th><?php echo _('IP');?></th>
        <th><?php echo _('Created');?></th>
        <th><?php echo _('Article');?></th>
        <th scope="col"><?php echo _('Action');?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="4">
          <input type="submit" name="delete" value="<?php echo _('Delete');?>" />
        </td>
        <td colspan="3" class="right"><?php $this->PageNavRemote->write('xigg-admin-node-vote-list', $vote_pages, $vote_page_requested, array('base' => '/node/' . $node_id . '/vote/list', 'params' => array('sortby' => $vote_sortby)), array('params' => array('sortby' => $vote_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    <tbody>
<?php   $vote_objects->rewind(); while ($e =& $vote_objects->getNext()):?>
      <tr>
        <td><input type="checkbox" class="check" name="votes[]" value="<?php echo $e->getId();?>" /></td>
        <td><?php $vote_user =& $e->get('User'); $vote_user->printHTMLLink();?></td>
        <td><?php _h($e->get('score'));?></td>
        <td><?php _h($e->get('ip'));?></td>
        <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
        <td><?php _h($node->getLabel());?></td>
        <td><?php $this->HTML->linkToRemote(_('Edit'), 'xigg-admin-node-vote-list-update', array('base' => '/node/' . $node_id . '/vote/' . $e->getId() . '/edit'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
<?php   endwhile; ?>
    </tbody>
  </table>
<input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_node_vote_submit');?>" />
<?php $this->HTML->formTagEnd();?>
<div id="xigg-admin-node-vote-list-update"></div>
<?php else:?>
<?php echo _('No votes found for this entry');?>
<?php endif;?>