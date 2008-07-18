<p>
<?php foreach($tags as $tag):?>
  <a href="<?php echo $tag['link'];?>" style="text-decoration:none;padding:2px;font-size:<?php echo $tag['size'];?>px;"><?php _h($tag['name']);?></a>
<?php endforeach;?>
</p>
<div style="text-align:right;">
  <a href="<?php echo XOOPS_URL . '/modules/' . $module_dir . '/index.php/tag';?>"><?php _h(_MB_XIGG_SHOW_ALL);?></a>
</div>