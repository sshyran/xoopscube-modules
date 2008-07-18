<ul>
<?php
$votes =& $votes->with('User'); $votes =& $votes->with('Node'); $votes->rewind();
while ($vote =& $votes->getNext()): $vote_node =& $vote->get('Node'); $vote_user =& $vote->get('User');?>
  <li><a href="<?php echo XOOPS_URL;?>/modules/<?php echo $module_dir;?>/index.php/vote/<?php echo $vote->getId();?>#vote<?php echo $vote->getId();?>"><?php _h(Sabai_I18N::strcutMore($vote_node->getLabel(), 40));?></a> - <?php $vote_user->printHTMLLink();?> (<?php _h($this->XiggTime->ago($vote->getTimeCreated()));;?>)</li>
<?php endwhile;?>
</ul>