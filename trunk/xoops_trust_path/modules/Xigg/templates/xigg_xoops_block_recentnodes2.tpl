<?php $this->loadHelper('XiggTime'); // not required in PHP5 ?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>" media="screen" />
<style type="text/css">
#Xigg div.nodeVoteSmall {
  width: 30px;
  margin-right: 5px;
}
#Xigg div.nodeVoteCountSmall {
  padding: 5px 0;
  font-size: 1.3em;
}
</style>
<div id="Xigg">
<?php $nodes->rewind(); while (($nodes->key() < $featured_nodes_count) && ($node =& $nodes->getNext())):
    $tag_html = array();
    $node_tags =& $node->get('Tags');
    while ($tag =& $node_tags->getNext()) {
        $tag_html[] = sprintf('<a href="%s/tag/%s" rel="tag">%s</a>', $xoops_script, $tag->getEncodedName(), h($tag->getLabel()));
    }
    $node_user =& $node->get('User');
?>
<div class="item clearfix" style="margin-bottom: 10px;">
  <div class="itemHead">
    <span class="itemTitle">
<?php if (!isset($category)) $category =& $node->get('Category');?>
<?php if ($category) printf('<a href="%s?category_id=%d">%s</a>: ', $xoops_script, $category->getId(), h($category->getLabel()));?>
<?php unset($category);?>
    <a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>"><?php _h($node->get('title'));?></a>
    </span>
  </div>
  <div class="itemInfo">
    <span class="itemPostDate"><?php printf(_MB_XIGG_SUBPUB, $node_user->getHTMLLink(), h($this->XiggTime->ago($node->getTimeCreated())), h($this->XiggTime->ago($node->get('published'))));?></span>
  </div>
  <div class="itemBody">
    <!--//<h4 class="nodeSource"><?php if ($source = $node->get('source')):?><a href="<?php echo $source;?>" title="<?php _h($node->get('source_title'));?>" /><?php _h($node->get('source_title'));?></a><?php endif;?></h4>//-->
    <div class="nodeVote">
      <div class="nodeVoteCount"><?php echo $node->getVoteCount();?></div>
      <div class="nodeVoteText">
        <a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>/voteform"><?php echo _MB_XIGG_VOTE;?></a>
      </div>
      <div id="Sabai-Xigg-VoteNodeError<?php echo $node->getId();?>" class="nodeVoteError"></div>
    </div>
    <div class="nodeContent">
<?php if ($show_screenshot && ($source = $node->get('source'))):?>
      <div class="nodeBodyScreenshot">
        <a href="<?php echo $source;?>" class="linkbubbler" title="<?php _h($node->get('source_title'));?>"><?php echo $node->getScreenshot();?></a>
      </div>
<?php endif;?>
      <p class="nodeTeaser">
<?php if ($teaser = $node->get('teaser_html')):?>
<?php   echo $teaser;?>&nbsp;<a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>#nodeBody" title="<?php echo _MB_XIGG_READFULL;?>"><?php echo _MB_XIGG_MORE;?></a>
<?php else:?>
<?php   echo $node->get('body_html');?>
<?php endif;?>
      </p>
    </div>
    <div class="nodeInfoTags clearfix">
<?php if (!empty($tag_html)):?>
<?php   printf(_MB_XIGG_TAGS, implode(', ', $tag_html));?>
<?php endif;?>
    </div>
  </div>
  <div class="itemFoot">
    <span class="itemAdminLink"></span>
    <span class="itemPermaLink">
    <span class="nodeCommentsLink"><a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>#nodeComments"><?php printf(_MB_XIGG_COMMENTS, $node->getCommentCount());?></a></span>
    |
    <span class="nodeTrackbacksLink"><a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>/trackbacktab#nodeTrackbacks"><?php printf(_MB_XIGG_TRACKBACKS, $node->getTrackbackCount());?></a></span>
     |
    <span class="nodeVotesLink"><a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>/votetab#nodeVotes"><?php printf(_MB_XIGG_VOTES, $node->getVoteCount());?></a></span>
    </span>
  </div>
</div>
<?php endwhile;?>

<table>
  <tr>
    <td style="width: 50%;">
      <table>
        <tr>
          <th colspan="2"><?php echo _MB_XIGG_RECENTPUB;?></th>
        </tr>
<?php while ($node =& $nodes->getNext()):?>
        <tr>
          <td style="width:35px; padding:0;">
            <div class="nodeVote nodeVoteSmall">
              <div class="nodeVoteCount nodeVoteCountSmall"><?php echo $node->getVoteCount();?></div>
            </div>
          </td>
          <td style="border-bottom: 1px dotted #999;">
            <span class="nodeTitle" style="font-size:1.0em; border-bottom:none;">
<?php if ($category =& $node->get('Category')) printf('<a href="%s?category_id=%d">%s</a>: ', $xoops_script, $category->getId(), h($category->getLabel()));?>
              <a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>"><?php _h(Sabai_I18N::strcutMore($node->getLabel(), 40));?></a>
            </span>
            <br />
            <span style="font-size:0.9em;"><?php printf(_MB_XIGG_PUB, $this->XiggTime->ago($node->get('published')));?></span>
            &nbsp|&nbsp;<span style="font-size:0.9em;" class="nodeCommentsLink">: <a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>#nodeComments"><?php echo $node->getCommentCount();?></a></span>
            &nbsp|&nbsp;<span style="font-size:0.9em;" class="nodeTrackbacksLink">: <a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>/trackbacktab#nodeTrackbacks"><?php echo $node->getTrackbackCount();?></a></span>
          </td>
        </tr>
<?php endwhile;?>
      </table>
    </td>
    <td style="width: 50%; padding:0;">
      <table style="padding:0;">
        <tr>
          <th colspan="2"><?php echo _MB_XIGG_TOPVOTED;?></th>
        </tr>
<?php $top_nodes->rewind(); while ($node =& $top_nodes->getNext()):?>
        <tr>
          <td style="text-align:left; width:35px; padding:0;">
            <div class="nodeVote nodeVoteSmall">
              <div class="nodeVoteCount nodeVoteCountSmall"><?php echo $node->getVoteCount();?></div>
            </div>
          </td>
          <td style="border-bottom: 1px dotted #999;">
            <span class="nodeTitle" style="font-size: 1.0em;border-bottom: none;">
<?php if ($category =& $node->get('Category')) printf('<a href="%s?category_id=%d">%s</a>: ', $xoops_script, $category->getId(), h($category->getLabel()));?>
              <a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>"><?php _h(Sabai_I18N::strcutMore($node->getLabel(), 40));?></a>
            </span>
            <br />
            <span style="font-size:0.9em;"><?php printf(_MB_XIGG_PUB, $this->XiggTime->ago($node->get('published')));?></span>
            &nbsp|&nbsp;<span style="font-size:0.9em;" class="nodeCommentsLink">: <a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>#nodeComments"><?php echo $node->getCommentCount();?></a></span>
            &nbsp|&nbsp;<span style="font-size:0.9em;" class="nodeTrackbacksLink">: <a href="<?php echo $xoops_script;?>/node/<?php echo $node->getId();?>/trackbacktab#nodeTrackbacks"><?php echo $node->getTrackbackCount();?></a></span>
          </td>
        </tr>
<?php endwhile;?>
      </table>
    </td>
  </tr>
</table>
</div>