<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'Token', 'HTML')); // not required in PHP5 ?>
<h3><?php _h($entity->getLabel());?></h3>

<table>
  <thead>
    <tr>
      <th><?php echo _('Name');?></th>
      <th><?php echo _('Created');?></th>
      <th><?php echo _('Articles');?></th>
      <th><?php echo _('Action');?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
  </tfoot>
  <tbody>
    <tr class="treeEntityActive">
      <td><?php _h(Sabai_I18N::strcutMore($entity->getLabel(), 50));?></td>
      <td><?php _h($this->XiggTime->ago($entity->getTimeCreated()));?></td>
      <td><?php echo $node_entities->size();?></td>
      <td><?php $this->HTML->linkTo(_('Edit'), array('base' => '/tag/' . $entity->getId() . '/edit'));?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/tag/' . $entity->getId() . '/delete'));?></td>
    </tr>
  </tbody>
</table>

<h3><?php echo _('Listing articles');?></h3>
<div class="nodesSort">
<?php foreach (array('all' => _('List all'), 'published' => _('List published'), 'upcoming' => _('List upcoming'), 'hidden' => _('List hidden')) as $select_key => $select_label):?>
<?php   if ($select_key == @$node_select):?>
  <span class="nodesSortCurrent"><?php _h($select_label);?></span> |
<?php   else:?>
<?php $this->HTML->linkToRemote($select_label, 'xigg-admin-tag-details', array('base' => '/tag/' . $entity->getId(), 'params' => array('select' => $select_key, 'sortby' => $node_sortby)), array('params' => array('select' => $select_key, 'sortby' => $node_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?>
  |
<?php   endif;?>
<?php endforeach;?>
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $node_sortby, 'xigg-admin-tag-details', array('title,ASC' => _('Title'), 'source,ASC' => _('Source'), 'category_id,ASC' => _('Category'), 'userid,ASC' => _('Poster'), 'created,DESC' => _('Posted date, descending'), 'created,ASC' => _('Posted date, ascending'), 'published,DESC' => _('Published date, descending'), 'published,ASC' => _('Published date, ascending'), 'views,DESC' => _('View count'), 'comment_count,DESC' => _('Comments'), 'trackback_count,DESC' => _('Trackbacks'), 'vote_count,DESC' => _('Votes'), 'priority,DESC' => _('Priority'), 'status,ASC' => _('Status')), array('base' => '/tag/' . $entity->getId(), 'params' => array('select' => $node_select)), _('Go'), array('params' => array('select' => $node_select, XIGG_REQUEST_AJAX_PARAM => 1)), 'xigg-admin-tag-details-select');?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/node/submit', 'params' => array('tag_id' => $entity->getId())), array('id' => 'xigg-admin-tag-details-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-tag-details-form-checkall" type="checkbox" onclick="$$('#xigg-admin-tag-details-form input.check').each(function(ele){ele.checked=$('xigg-admin-tag-details-form-checkall').checked});" /></th>
        <th>&nbsp;</th>
        <th><?php echo _('Title');?></th>
        <th><?php echo _('Source');?></th>
        <th><?php echo _('Category');?></th>
        <th><?php echo _('Poster');?></th>
        <th><?php echo _('Posted');?></th>
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
        <td colspan="6">
<?php if ($node_select != 'published'):?>
          <input type="submit" name="publish" value="<?php echo _('Publish');?>" />
<?php endif;?>
<?php if ($node_select != 'hidden'):?>
          <input type="submit" name="hide" value="<?php echo _('Hide');?>" />
<?php endif;?>
          <input type="submit" name="unhide" value="<?php echo _('Unhide');?>" />
          <input type="submit" name="delete" value="<?php echo _('Delete');?>" />
        </td>
        <td colspan="8" class="right"><?php $this->PageNavRemote->write('xigg-admin-tag-details', $node_pages, $node_page_requested, array('base' => '/tag/' . $entity->getId(), 'params' => array('sortby' => $node_sortby, 'select' => $node_select)), array('params' => array('sortby' => $node_sortby, 'select' => $node_select, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    <tbody>
<?php if ($node_entities->size() > 0):?>
<?php   while ($e =& $node_entities->getNext()):?>
<?php     if ($e->isHidden()):?>
      <tr style="background-color:#eee;">
<?php     else:?>
      <tr>
<?php     endif;?>
        <td><input type="checkbox" class="check" name="nodes[]" value="<?php echo $e->getId();?>" /></td>
        <td><?php if ($e->isPublished()):?><img src="<?php echo $LAYOUT_URL;?>/images/tick.gif" alt="" /><?php endif;?></td>
        <td><a href="<?php echo $this->Request->createUri(array('script' => $this->Request->getScriptUri('index.php'), 'base' => '/node/' . $e->getId()));?>"><?php _h(Sabai_I18N::strcutMore($e->getLabel(), 100));?></a></td>
        <td><?php echo $e->getSourceHTMLLink(40);?></td>
        <td><?php if ($node_category =& $e->get('Category')):?><a href="<?php echo $this->Request->createUri(array('base' => '/category/' . $node_category->getId()));?>"><?php _h($node_category->getLabel());?></a><?php endif;?></td>
        <td><?php $node_user =& $e->get('User'); $node_user->printHTMLLink();?></td>
        <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
        <td><?php if ($e->isPublished()) {_h($this->XiggTime->ago($e->get('published')));}?></td>
        <td><?php echo $e->get('views');?></td>
        <td><?php echo $e->getCommentCount();?></td>
        <td><?php echo $e->getTrackbackCount();?></td>
        <td><?php echo $e->getVoteCount();?></td>
        <td><?php echo $e->get('priority');?></td>
        <td><?php $this->HTML->linkTo(_('Details'), array('base' => '/node/' . $e->getId()));?> <?php $this->HTML->linkTo(_('Edit'), array('base' => '/node/' . $e->getId() . '/edit'));?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/node/' . $e->getId() . '/delete'));?></td>
      </tr>
<?php   endwhile; ?>
<?php else:?>
      <tr><td colspan="14">&nbsp;</td></tr>
<?php endif;?>
    </tbody>
  </table>
<input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_node_submit');?>" />
<?php $this->HTML->formTagEnd();?>