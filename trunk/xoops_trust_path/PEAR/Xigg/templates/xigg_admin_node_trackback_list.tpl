<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'Token', 'HTML')); // not required in PHP5 ?>
<h3><?php _h($this->__('Listing trackbacks for "%s"', $node->getLabel()));?></h3>
<?php if ( $trackback_objects->size() > 0):?>
<div class="nodesSort">
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $trackback_sortby, 'xigg-admin-node-trackback-list', array('created,DESC' => _('Newest first'), 'created,ASC' => _('Oldest first')), array('base' => '/node/' . $node_id . '/trackback'), _('Go'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), 'xigg-admin-node-trackback-list-select');?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/node/' . $node_id . '/trackback/submit'), array('id' => 'xigg-admin-node-trackback-list-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-node-trackback-list-form-checkall" type="checkbox" onclick="$$('#xigg-admin-node-trackback-list-form input.check').each(function(ele){ele.checked=$('xigg-admin-node-trackback-list-form-checkall').checked});" /></th>
        <th><?php echo _('Title');?></th>
        <th><?php echo _('Weblog');?></th>
        <th><?php echo _('Excerpt');?></th>
        <th><?php echo _('Posted');?></th>
        <th><?php echo _('Article');?></th>
        <th scope="col"><?php echo _('Action');?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="4">
          <input type="submit" name="delete" value="<?php echo _('Delete');?>" />
        </td>
        <td colspan="3" class="right"><?php $this->PageNavRemote->write('xigg-admin-node-trackback-list', $trackback_pages, $trackback_page_requested, array('base' => '/node/' . $node_id . '/trackback/list', 'params' => array('sortby' => $trackback_sortby)), array('params' => array('sortby' => $trackback_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    <tbody>
<?php   $trackback_objects->rewind(); while ($e =& $trackback_objects->getNext()):?>
      <tr>
        <td><input type="checkbox" class="check" name="trackbacks[]" value="<?php echo $e->getId();?>" /></td>
        <td><a href="<?php echo $e->get('url');?>"><?php _h(Sabai_I18N::strcutMore($e->getLabel(), 100));?></a></td>
        <td><?php _h($e->get('blog_name'));?></td>
        <td><?php _h(Sabai_I18N::strcutMore($e->get('excerpt'), 255));?></td>
        <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
        <td><?php _h($node->getLabel());?></td>
        <td>
<?php
$this->HTML->linkToRemote(_('Edit'), 'xigg-admin-node-trackback-list-update', array('base' => '/node/' . $node_id . '/trackback/' . $e->getId() . '/edit'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));
$this->HTML->linkTo(_('View'), array('base' => '/node/' .$node_id . '/trackback/' . $e->getId(), 'fragment' => 'trackback' . $e->getId()));
?>
        </td>
      </tr>
<?php   endwhile; ?>
    </tbody>
  </table>
<input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_node_trackback_submit');?>" />
<?php $this->HTML->formTagEnd();?>
<div id="xigg-admin-node-trackback-list-update"></div>
<?php else:?>
<?php echo _('No trackbacks found for this entry');?>
<?php endif;?>