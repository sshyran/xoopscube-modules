<?php $this->loadHelpers(array('XiggTime', 'HTML', 'PageNavRemote')); // not required in PHP5 ?>
<h3><?php echo _('Listing categories');?></h3>
<div class="nodesSort">
<?php echo _('Sort by '); $this->HTML->selectToRemote('sortby', $requested_sortby, 'xigg-admin-category-list', array('name,ASC' => _('Category name, ascending'), 'name,DESC' => _('Category name, descending'), 'created,ASC' => _('Created date, ascending'), 'created,DESC' => _('Created date, descending')), array('base' => '/category/list'), _('Go'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), 'xigg-admin-category-list-select');?>
</div>

<table>
  <thead>
    <tr>
      <th><?php echo _('Name');?></th>
      <th><?php echo _('Description');?></th>
      <th><?php echo _('Created');?></th>
      <th><?php echo _('Articles');?></th>
      <th><?php echo _('Action');?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="5" class="right"><?php $this->PageNavRemote->write('xigg-admin-category-list', $entity_pages, $entity_page_requested, array('base' => '/category/list', 'params' => array('sortby' => $requested_sortby)), array('params' => array('sortby' => $requested_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
    </tr>
  </tfoot>
  <tbody>
<?php if ($entity_objects->size() > 0):
        $entity_objects->rewind(); while ($e =& $entity_objects->getNext()):?>
    <tr <?php if(isset($child_categories[$e->getId()])):?>class="active"<?php endif;?>>
      <td>
<?php     if(!$e->isLeaf()):
            if (isset($child_categories[$e->getId()])):?>
        <span class="treeEntity treeEntityBranchOpen"><?php _h(Sabai_I18N::strcutMore($e->getLabel(), 50));?></span>
<?php       else:?>
        <span class="treeEntity treeEntityBranch">
<?php       $this->HTML->linkToRemote(Sabai_I18N::strcutMore($e->getLabel(), 50), 'xigg-admin-category-list', array('base' => '/category/list', 'params' => array('branch' => $e->getId(), 'sortby' => $requested_sortby, 'page' => $entity_page_requested)), array('params' => array('branch' => $e->getId(), 'sortby' => $requested_sortby, 'page' => $entity_page_requested, XIGG_REQUEST_AJAX_PARAM => 1)));?>
        </span> (<?php echo $e->descendantsCount();?>)
<?php       endif;
          else:?>
        <span class="treeEntity"><?php _h(Sabai_I18N::strcutMore($e->getLabel(), 50));?></span>
<?php     endif;?>
      </td>
      <td><?php _h(Sabai_I18N::strcutMore($e->get('description'), 250));?></td>
      <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
      <td><?php  if(!isset($child_categories[$e->getId()]) && !empty($node_count_sum[$e->getId()])):?><?php echo $node_count_sum[$e->getId()];?>(<?php echo $e->getNodeCount();?>)<?php else:?><?php echo $e->getNodeCount();?><?php endif;?></td>
      <td><?php $this->HTML->linkTo(_('Details'), array('base' => '/category/' . $e->getId()));?> <?php $this->HTML->linkTo(_('Edit'), array('base' => '/category/' . $e->getId() . '/edit'));?><?php if($e->isLeaf()):?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/category/' . $e->getId() . '/delete'));?><?php endif;?></td>
    </tr>
<?php     if (isset($child_categories[$e->getId()])):
            while($child =& $child_categories[$e->getId()]->getNext()):?>
    <tr>
      <td><?php echo str_repeat('&nbsp;&nbsp;', $child->parentsCount());?><span class="treeEntity<?php if (!$child->isLeaf()):?> treeEntityBranchOpen<?php endif;?>"><?php _h(Sabai_I18N::strcutMore($child->getLabel(), 50));?></span></td>
      <td><?php _h(Sabai_I18N::strcutMore($child->get('description'), 250));?></td>
      <td><?php _h($this->XiggTime->ago($child->getTimeCreated()));?></td>
      <td><?php echo $child->getNodeCount();?></td>
      <td><?php $this->HTML->linkTo(_('Details'), array('base' => '/category/' . $child->getId()));?> <?php $this->HTML->linkTo(_('Edit'), array('base' => '/category/' . $child->getId() . '/edit'));?><?php if($child->isLeaf()):?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/category/' . $child->getId() . '/delete'));?><?php endif?></td>
    </tr>
<?php       endwhile;
          endif;
        endwhile;
      else:?>
    <tr><td colspan="5"></td></tr>
<?php endif;?>
  </tbody>
</table>

<div class="addEntityLink">
  <?php $this->HTML->linkToRemote(_('Add category'), 'xigg-admin-category-list-update', array('base' => '/category/add'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), array('toggle' => 1));?>
</div>

<div id="xigg-admin-category-list-update">
</div>
