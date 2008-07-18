<ul>
<?php
while ($trackback =& $trackbacks->getNext()):?>
  <li><a href="<?php echo XOOPS_URL;?>/modules/<?php echo $module_dir;?>/index.php/trackback/<?php echo $trackback->getId();?>#trackback<?php echo $trackback->getId();?>"><?php _h(Sabai_I18N::strcutMore($trackback->get('excerpt'), 40));?></a> - <?php echo $trackback->get('blog_name');?> (<?php _h($this->XiggTime->ago($trackback->getTimeCreated()));?>)</li>
<?php endwhile;?>
</ul>