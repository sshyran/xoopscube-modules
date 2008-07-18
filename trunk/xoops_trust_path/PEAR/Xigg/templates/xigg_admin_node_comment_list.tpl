<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'Token', 'HTML')); // not required in PHP5 ?>
<h3><?php _h($this->__('Listing comments for "%s"', $node->getLabel()));?></h3>
<?php if ($comment_objects->size() > 0):?>
<div class="nodesSort">
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $comment_sortby, 'xigg-admin-node-comment-list', array('created,DESC' => _('Newest first'), 'created,ASC' => _('Oldest first')), array('base' => '/node/' . $node_id . '/comment', 'params' => array()), _('Go'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)), 'xigg-admin-node-comment-list-select');?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/node/' . $node_id . '/comment/submit'), array('id' => 'xigg-admin-node-comment-list-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-node-comment-list-form-checkall" type="checkbox" onclick="$$('#xigg-admin-node-comment-list-form input.check').each(function(ele){ele.checked=$('xigg-admin-node-comment-list-form-checkall').checked});" /></th>
        <th><?php echo _('Title');?></th>
        <th><?php echo _('Poster');?></th>
        <th><?php echo _('Posted');?></th>
        <th><?php echo _('Updated');?></th>
        <th><?php echo _('Article');?></th>
        <th scope="col"><?php echo _('Action');?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="4">
          <input type="submit" name="delete" value="<?php echo _('Delete');?>" />
        </td>
        <td colspan="3" class="right"><?php $this->PageNavRemote->write('xigg-admin-node-comment-list', $comment_pages, $comment_page_requested, array('base' => '/node/' . $node_id . '/comment/list', 'params' => array('sortby' => $comment_sortby)), array('params' => array('sortby' => $comment_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    </tfoot>
    <tbody>
<?php $comment_objects->rewind(); while ($e =& $comment_objects->getNext()):?>
    <tr <?php if(isset($child_comments[$e->getId()])):?>class="treeEntityActive"<?php endif;?>>
<?php   if($e->isLeaf()):?>
      <td><input type="checkbox" class="check" name="comments[]" value="<?php echo $e->getId();?>" /></td>
<?php   else:?>
      <td>&nbsp;</td>
<?php   endif;?>
      <td>
<?php   if(!$e->isLeaf()):?>
<?php     if (isset($child_comments[$e->getId()])):?>
        <span class="treeEntity treeEntityBranchOpen"><?php _h(Sabai_I18N::strcutMore($e->getLabel(), 50));?></span>
<?php     else:?>
        <span class="treeEntity treeEntityBranch"><?php $this->HTML->linkToRemote($e->getLabel(), 'xigg-admin-node-comment-list', array('base' => '/node/' .$node_id . '/comment', 'params' => array('comment_id' => $e->getId(), 'sortby' => $comment_sortby, 'page' => $comment_page_requested)), array('params' => array('comment_id' => $e->getId(), 'sortby' => $comment_sortby, 'page' => $comment_page_requested, XIGG_REQUEST_AJAX_PARAM => 1)));?> (<?php echo $e->descendantsCount();?>)</span>
<?php     endif;?>
<?php   else:?>
        <span class="treeEntity"><?php _h(Sabai_I18N::strcutMore($e->getLabel(), 50));?></span>
<?php   endif;?>
      </td>
      <td><?php $comment_user =& $e->get('User'); $comment_user->printHTMLLink();?></td>
      <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
      <td><?php if($updated = $e->getTimeUpdated()){_h($this->XiggTime->ago($updated));}?></td>
      <td><?php _h($node->getLabel());?></td>
      <td>
<?php
$this->HTML->linkToRemote(_('Edit'), 'xigg-admin-node-comment-list-update', array('base' => '/node/' .$node_id . '/comment/' . $e->getId() . '/edit'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));
$this->HTML->linkTo(_('View'), array('base' => '/node/' .$node_id . '/comment/' . $e->getId(), 'fragment' => 'comment' . $e->getId()));
?>
      </td>
    </tr>
<?php   if (isset($child_comments[$e->getId()])):?>
<?php     $child_comments[$e->getId()]->rewind(); while($child =& $child_comments[$e->getId()]->getNext()):?>
    <tr>
<?php   if($child->isLeaf()):?>
      <td><input type="checkbox" class="check" name="comments[]" value="<?php echo $child->getId();?>" /></td>
<?php   else:?>
      <td>&nbsp;</td>
<?php   endif;?>
      <td><?php echo str_repeat('&nbsp;&nbsp;', $child->parentsCount());?><span class="treeEntity<?php if (!$child->isLeaf()):?> treeEntityBranchOpen<?php endif;?>"><?php _h(Sabai_I18N::strcutMore($child->getLabel(), 50));?></span></td>
      <td><?php $comment_user =& $child->get('User'); $comment_user->printHTMLLink();?></td>
      <td><?php _h($this->XiggTime->ago($child->getTimeCreated()));?></td>
      <td><?php if($updated = $child->getTimeUpdated()){_h($this->XiggTime->ago($updated));}?></td>
      <td><?php _h($node->getLabel());?></td>
      <td>
<?php
$this->HTML->linkToRemote(_('Edit'), 'xigg-admin-node-comment-list-update', array('base' => '/node/' .$node_id . '/comment/'. $child->getId() . '/edit'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));
$this->HTML->linkTo(_('View'), array('base' => '/node/' .$node_id . '/comment/' . $child->getId(), 'fragment' => 'comment' . $child->getId()));
?>
      </td>
    </tr>
<?php     endwhile;?>
<?php   endif;?>
<?php endwhile; ?>
    </tbody>
  </table>
  <input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_node_comment_submit');?>" />
<?php $this->HTML->formTagEnd();?>

<div id="xigg-admin-node-comment-list-update"></div>
<?php else:?>
<?php echo _('No comments found for this entry');?>
<?php endif;?>