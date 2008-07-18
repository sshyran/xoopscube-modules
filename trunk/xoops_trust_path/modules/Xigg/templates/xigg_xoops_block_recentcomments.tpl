<ul>
<?php
$this->loadHelper('XiggTime'); // not required in PHP5
$comments =& $comments->with('User');
$comments->rewind();
while ($comment =& $comments->getNext()):?>
  <li><a href="<?php echo XOOPS_URL;?>/modules/<?php echo $module_dir;?>/index.php/comment/<?php echo $comment->getId();?>#comment<?php echo $comment->getId();?>"><?php _h(Sabai_I18N::strcutMore($comment->getLabel(), 40));?></a> - <?php $comment_user =& $comment->get('User'); $comment_user->printHTMLLink();?> (<?php _h($this->XiggTime->ago($comment->getTimeCreated()));?>)</li>
<?php endwhile;?>
</ul>