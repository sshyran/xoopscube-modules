<?php $this->loadHelpers(array('XiggBreadCrumb')); // not required in PHP5 ?>
<div class="breadcrumb">
  <?php echo $this->XiggBreadCrumb->create();?><?php echo _('Tags');?>
</div>

<h3 class="tagsCaption"><?php echo _('Tags');?></h3>
<div class="tagCloud">
<?php foreach ($tags as $tag):?>
  <a href="<?php echo $tag['link'];?>" style="font-size:<?php echo $tag['size'];?>px;"><?php _h($tag['name']);?></a>
<?php endforeach;?>
</div>