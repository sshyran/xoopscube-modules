<?php $this->loadHelper('XiggTime');?>
<dl>
<?php $nodes->rewind(); while ($node =& $nodes->getNext()):?>
  <dt>
<?php   if ($category =& $node->get('Category')):?>
    <a href="<?php printf('%s/modules/%s/index.php?category_id=%d', XOOPS_URL, $module_dir, $category->getId());?>"><?php _h($category->getLabel());?></a>:
<?php   endif;?>
    <a href="<?php printf('%s/modules/%s/index.php/node/%d', XOOPS_URL, $module_dir, $node->getId());?>"><?php _h(Sabai_I18N::strcutMore($node->getLabel(), 75));?></a>
  </dt>
  <dd><span style="font-size:0.9em;"><?php $node_user =& $node->get('User'); printf(_MB_XIGG_PUB2, $node_user->getHTMLLink(), $this->XiggTime->ago($node->get('published')));?></span></dd>
<?php endwhile;?>
</dl>
<div style="text-align:right;">
  <a href="<?php echo XOOPS_URL . '/modules/' . $module_dir . '/index.php';?>"><?php _h(_MB_XIGG_SHOW_ALL);?></a>
</div>