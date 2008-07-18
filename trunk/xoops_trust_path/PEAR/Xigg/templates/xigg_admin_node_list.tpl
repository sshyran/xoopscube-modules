<?php $this->loadHelpers(array('XiggTime', 'PageNavRemote', 'Token', 'HTML')); // not required in PHP5 ?>
<h3><?php echo _('Listing articles');?></h3>
<div class="nodesSort">
<?php foreach (array('all' => _('List all'), 'published' => _('List published'), 'upcoming' => _('List upcoming'), 'hidden' => _('List hidden'), 'nocategory' => _('List non-categorized')) as $select_key => $select_label):?>
<?php   if ($select_key == @$requested_select):?>
  <span class="nodesSortCurrent"><?php _h($select_label);?></span> |
<?php   else:?>
<?php $this->HTML->linkToRemote($select_label, 'xigg-admin-node-list', array('base' => '/node/list', 'params' => array('select' => $select_key, 'sortby' => $requested_sortby)), array('params' => array('select' => $select_key, 'sortby' => $requested_sortby, XIGG_REQUEST_AJAX_PARAM => 1)));?>
  |
<?php   endif;?>
<?php endforeach;?>
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $requested_sortby, 'xigg-admin-node-list', array('title,ASC' => _('Title'), 'source,ASC' => _('Source'), 'category_id,ASC' => _('Category'), 'userid,ASC' => _('Poster'), 'created,DESC' => _('Posted date, descending'), 'created,ASC' => _('Posted date, ascending'), 'published,DESC' => _('Published date, descending'), 'published,ASC' => _('Published date, ascending'), 'views,DESC' => _('View count'), 'comment_count,DESC' => _('Comments'), 'trackback_count,DESC' => _('Trackbacks'), 'vote_count,DESC' => _('Votes'), 'priority,DESC' => _('Priority'), 'status,ASC' => _('Status')), array('base' => '/node/list', 'params' => array('select' => $requested_select)), _('Go'), array('params' => array('select' => $requested_select, XIGG_REQUEST_AJAX_PARAM => 1)), 'xigg-admin-node-list-select');?>
</div>
<?php $this->HTML->formTag('post', array('base' => '/node/submit'), array('id' => 'xigg-admin-node-list-form'));?>
  <table>
    <thead>
      <tr>
        <th><input id="xigg-admin-node-list-form-checkall" type="checkbox" onclick="$$('#xigg-admin-node-list-form input.check').each(function(ele){ele.checked=$('xigg-admin-node-list-form-checkall').checked});" /></th>
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
<?php if ($requested_select != 'published'):?>
          <input type="submit" name="publish" value="<?php echo _('Publish');?>" />
<?php endif;?>
<?php if ($requested_select != 'hidden'):?>
          <input type="submit" name="hide" value="<?php echo _('Hide');?>" />
<?php endif;?>
          <input type="submit" name="unhide" value="<?php echo _('Unhide');?>" />
          <input type="submit" name="delete" value="<?php echo _('Delete');?>" />
        </td>
        <td colspan="8" class="right"><?php $this->PageNavRemote->write('xigg-admin-node-list', $entity_pages, $entity_page_requested, array('base' => '/node/list', 'params' => array('sortby' => $requested_sortby, 'select' => $requested_select)), array('params' => array('sortby' => $requested_sortby, 'select' => $requested_select, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
      </tr>
    </tfoot>
    <tbody>
<?php if ($entity_objects->size() > 0):?>
<?php   $entity_objects->rewind(); while ($e =& $entity_objects->getNext()):?>
<?php     if ($e->isHidden()):?>
      <tr style="background-color:#eee;">
<?php     else:?>
      <tr>
<?php     endif;?>
        <td><input type="checkbox" class="check" name="nodes[]" value="<?php echo $e->getId();?>" /></td>
        <td><?php if ($e->isPublished()):?><img src="<?php echo $LAYOUT_URL;?>/images/tick.gif" alt="" /><?php endif;?></td>
        <td><a href="<?php echo $this->Request->createUri(array('script' => $this->Request->getScriptUri('index.php'), 'base' => '/node/' . $e->getId()));?>"><?php _h(Sabai_I18N::strcutMore($e->getLabel(), 100));?></a></td>
        <td><?php echo $e->getSourceHTMLLink(40);?></td>
        <td><?php if ($category =& $e->get('Category')):?><a href="<?php echo $this->Request->createUri(array('base' => '/category/' . $category->getId()));?>"><?php _h($category->getLabel());?></a><?php endif;?></td>
        <td><?php $node_user =& $e->get('User'); $node_user->printHTMLLink();?></td>
        <td><?php _h($this->XiggTime->ago($e->getTimeCreated()));?></td>
        <td><?php if ($e->isPublished()) {_h($this->XiggTime->ago($e->get('published')));}?></td>
        <td><?php echo $e->get('views');?></td>
        <td><?php $this->HTML->linkToRemote($e->getCommentCount(), 'xigg-admin-node-comment-list', array('base' => '/node/' . $e->getId() . '/comment'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
        <td><?php $this->HTML->linkToRemote($e->getTrackbackCount(), 'xigg-admin-node-trackback-list', array('base' => '/node/' . $e->getId() . '/trackback'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
        <td><?php $this->HTML->linkToRemote($e->getVoteCount(), 'xigg-admin-node-vote-list', array('base' => '/node/' . $e->getId() . '/vote'), array('params' => array(XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
        <td><?php echo $e->get('priority');?></td>
        <td><?php $this->HTML->linkTo(_('Details'), array('base' => '/node/' . $e->getId()));?> <?php $this->HTML->linkTo(_('Edit'), array('base' => '/node/' . $e->getId() . '/edit'));?> <?php $this->HTML->linkTo(_('Delete'), array('base' => '/node/' . $e->getId() . '/delete'));?></td>
      </tr>
<?php   endwhile; ?>
<?php else:?>
      <tr><td colspan="14"></td></tr>
<?php endif;?>
    </tbody>
  </table>
<input type="hidden" name="_TOKEN" value="<?php $this->Token->write('Admin_node_submit');?>" />
<?php $this->HTML->formTagEnd();?>
<div id="xigg-admin-node-comment-list"></div>
<div id="xigg-admin-node-trackback-list"></div>
<div id="xigg-admin-node-vote-list"></div>