<?php $this->loadHelpers(array('HTML', 'XiggTime', 'PageNavRemote')); // not required in PHP5 ?>
<div class="trackbacksSort">
  <div class="toggleButton trackbacksSortToggle">
    <?php $this->HTML->linkToShowClass('trackbackContent', _('[+]'), _('[-]'));?>
    <?php $this->HTML->linkToHideClass('trackbackContent', _('[-]'), _('[+]'));?>
  </div>
<?php foreach (array('newest' => _('Newest first'), 'oldest' => _('Oldest first')) as $view_key => $view_label):?>
<?php   if ($view_key == $trackback_view):?>
  <span class="trackbacksSortCurrent"><?php _h($view_label);?></span>
<?php   else:?>
  <?php $this->HTML->linkToRemote($view_label, 'xigg-showtrackbacks' . $node->getId(), array('base' => '/node/' . $node->getId(), 'params' => array('trackback_view' => $view_key), 'fragment' => 'nodeTrackbacks'), array('base' => '/node/' . $node->getId() . '/trackbacks', 'params' => array('trackback_view' => $view_key, XIGG_REQUEST_AJAX_PARAM => 1)));?>
<?php   endif;?>
  |
<?php endforeach;?>
  <a href="<?php echo $this->Request->createUri(array('base' => '/rss/node/' . $node->getId(). '/trackbacks'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/feed.gif" width="16" height="16" alt="RSS feed" title="RSS feed" /></a>
</div>
<?php
$trackbacks =& $trackback_page->getElements();
if ($trackbacks->size() > 0):
  $trackbacks->rewind(); while ($trackback =& $trackbacks->getNext()):?>
<a name="trackback<?php echo $trackback->getId();?>"></a>
<div class="trackback">
  <div class="trackbackHead"></div>
  <div class="trackbackTitle">
    <span class="toggleButton trackbackTitleToggle"><?php $this->HTML->linkToToggle('trackbackContent' . $trackback->getId(), false, _('[-]'), _('[+]'));?></span>
    <span class="trackbackTitleText"><?php echo $trackback->getHTMLLink();?>&nbsp;</span>
  </div>
  <div id="trackbackContent<?php echo $trackback->getId();?>" class="trackbackContent">
    <div class="trackbackData"><?php if ($blog_name = $trackback->get('blog_name')):?><?php echo $this->__('Blog: %s', h($blog_name));?> | <?php endif?><?php echo $this->__('Posted: <strong>%s</strong>', $this->XiggTime->ago($trackback->getTimeCreated()));?></div>
    <div class="trackbackBody"><?php _h($trackback->get('excerpt'));?></div>
    <div class="trackbackCtrl">
      <span>
        <a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('trackback_id' => $trackback->getId()), 'fragment' => 'trackback' . $trackback->getId()));?>">#<?php echo $trackback->getId();?></a>
      </span>
      |
      <span class="nodeAdminLink trackbackAdminLink">
<?php   if ($this->User->hasPermission('trackback edit')):?>
        <a href="<?php echo $this->Request->createUri(array('base' => '/trackback/' . $trackback->getId() . '/edit'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/edit.gif" alt="<?php echo _('Edit');?>" title="<?php echo _('Edit this trackback');?>" /></a>
<?php   endif;?>
<?php   if ($this->User->hasPermission('trackback delete')):?>
        <a href="<?php echo $this->Request->createUri(array('base' => '/trackback/' . $trackback->getId() . '/delete'));?>"><img src="<?php echo $LAYOUT_URL;?>/images/delete.gif" alt="<?php echo _('Delete');?>" title="<?php echo _('Delete this trackback');?>" /></a>
<?php   endif;?>
      </span>
    </div>
    <div class="trackbackContentFoot"></div>
  </div>
  <div class="trackbackFoot"></div>
</div>
<?php endwhile;?>
<table class="nodesNav nodesNavBottom">
  <tr>
    <td class="nodesNavPages"><?php $this->PageNavRemote->write('xigg-showtrackbacks' . $node->getId(), $trackback_pages, $trackback_page->getPageNumber(), array('base' => '/node/' . $node->getId(), 'params' => array('trackback_view' => $trackback_view),'fragment' => 'nodeTrackbacks'), array('base' => '/node/' . $node->getId() . '/trackbacks', 'params' => array('trackback_view' => $trackback_view, XIGG_REQUEST_AJAX_PARAM => 1)), 'trackback_page');?></td>
  </tr>
</table>
<?php endif;?>

<?php if ($node->get('allow_trackbacks')):?>
<div class="nodeTrackbackLink">
  <h4 class="trackbackLinkCaption"><?php echo _('Trackback URL');?></h4>
  <input type="text" value="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId() . '/trackback'));?>" size="80" onfocus="javascript:this.select();" />
</div>
<?php else:?>
<div class="stop">
  <p><?php echo _('No additional trackbacks allowed for this entry');?></p>
</div>
<?php endif;?>