<?php $this->loadHelpers(array('XiggBreadCrumb', 'HTML')); // not required in PHP5 ?>
<div class="nodeBreadcrumb"><?php echo $this->XiggBreadCrumb->createForNode($node);?><?php echo _('Vote');?></div>

<div class="node nodePreview">
  <h2 class="nodeTitle">
  <?php _h($node->get('title'));?>
  </h2>
  <div class="nodeContent clearfix">
<?php   if ($source = $node->get('source')):?>
    <div class="nodeBodyScreenshot">
      <a href="<?php echo $source;?>" class="linkbubbler" title="<?php _h($node->get('source_title'));?>"><?php echo $node->getScreenshot();?></a>
    </div>
<?php   endif;?>
    <p class="nodeTeaser">
      <?php echo $node->get('teaser_html');?>
    </p>
    <p class="nodeBody">
      <?php echo $node->get('body_html');?>
    </p>
  </div>
</div>

<div class="nodeVoteForm">
  <h4 class="voteFormCaption"><?php echo _('Vote');?></h4>
<?php foreach ($vote_form->getFormValidationErrors() as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php endforeach;?>
<?php $this->HTML->formTag('post', array('base' => '/node/' . $node->getId() . '/vote'));?>
<?php foreach ($vote_form->getElementNames() as $name):?>
<?php   foreach ($vote_form->getValidationErrorsFor($name) as $error):?>
  <div class="stop">
    <p><?php _h($error);?></p>
  </div>
<?php   endforeach;?>
<?php endforeach;?>
  <p>
    <input type="submit" value="<?php echo _('Vote for this article');?>" class="button" />
  </p>
  <?php $vote_form->printHTMLForToken(); $this->HTML->formTagEnd();?>
</div>