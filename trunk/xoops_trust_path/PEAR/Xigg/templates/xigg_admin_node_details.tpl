<?php $this->loadHelpers(array('XiggTime', 'HTML')); // not required in PHP5 ?>
<h3><?php _h($node->getLabel());?></h3>
<table style="width:100%" summary="Articles">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th><?php echo _('Title');?></th>
      <th><?php echo _('Source');?></th>
      <th><?php echo _('Category');?></th>
      <th><?php echo _('Poster');?></th>
      <th><?php echo _('Created');?></th>
      <th><?php echo _('Published');?></th>
      <th><?php echo _('Views');?></th>
      <th><?php echo _('Comments');?></th>
      <th><?php echo _('Trackbacks');?></th>
      <th><?php echo _('Votes');?></th>
      <th><?php echo _('Priority');?></th>
      <th scope="col"><?php echo _('Action');?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="13">&nbsp;</td>
    </tr>
  </tfoot>
  <tbody>
<?php if ($node->isHidden()):?>
    <tr style="background-color:#eee;">
<?php else:?>
    <tr>
<?php endif;?>
      <td><?php if ($node->isPublished()):?><img src="<?php echo $LAYOUT_URL?>/images/tick.gif" alt="" /><?php endif;?></td>
      <td><a href="<?php echo $this->Request->createUri(array('script' => $this->Request->getScriptUri('index.php'), 'base' => '/node/' . $node->getId()));?>"><?php _h(Sabai_I18N::strcutMore($node->getLabel(), 100));?></a></td>
      <td><?php echo $node->getSourceHTMLLink(40);?></td>
      <td><?php if ($category =& $node->get('Category')):?><a href="<?php echo $this->Request->createUri(array('base' => '/category/' . $category->getId()));?>"><?php _h($category->getLabel());?></a><?php endif;?></td>
      <td><?php $node_user =& $node->get('User'); $node_user->printHTMLLink();?></td>
      <td><?php _h($this->XiggTime->ago($node->getTimeCreated()));?></td>
      <td><?php if ($node->isPublished()) _h($this->XiggTime->ago($node->get('published')));?></td>
      <td><?php echo $node->get('views');?></td>
      <td><?php echo $node->getCommentCount();?></td>
      <td><?php echo $node->getTrackbackCount();?></td>
      <td><?php echo $node->getVoteCount();?></td>
      <td><?php echo $node->get('priority');?></td>
      <td><?php $this->HTML->linkTo(_('Edit'), array('base' => '/node/' . $node->getId() . '/edit'));?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/node/' . $node->getId() . '/delete'));?></td>
    </tr>
  </tbody>
</table>
<div id="xigg-admin-node-update"></div>
<div id="xigg-admin-node-comment-list">
<?php include $this->getTemplatePath('xigg_admin_node_comment_list.tpl');?>
</div>
<div id="xigg-admin-node-trackback-list">
<?php include $this->getTemplatePath('xigg_admin_node_trackback_list.tpl');?>
</div>
<div id="xigg-admin-node-vote-list">
<?php include $this->getTemplatePath('xigg_admin_node_vote_list.tpl');?>
</div>