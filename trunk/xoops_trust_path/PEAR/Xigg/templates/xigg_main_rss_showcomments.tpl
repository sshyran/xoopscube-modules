<?php echo'<?';?>xml version="1.0" encoding="utf-8" ?>
<rdf:RDF
  xmlns="http://purl.org/rss/1.0/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:annotate="http://purl.org/rss/1.0/modules/annotate/"
  xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/"
  xml:lang="<?php echo Sabai_I18N::lang();?>">
 <channel rdf:about="<?php echo $this->Request->createUri(array('base' => '/rss/node/' . $node->getId() . '/comments'));?>">
  <title><?php printf(_('%s (comments)'), h($node->getLabel()));?></title>
  <link><?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'fragment' => 'nodeComments'));?></link>
  <description><?php echo _('Recently posted comments');?></description>
  <items>
<?php if ($comments->size() > 0):?>
   <rdf:Seq>
<?php   while ($comment =& $comments->getNext()):?>
    <rdf:li rdf:resource="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment->getId()), 'fragment' => 'comment' . $comment->getId()));?>"/>
<?php   endwhile;?>
   </rdf:Seq>
<?php endif;?>
  </items>
 </channel>
<?php if ($comments->size() > 0): $comments->rewind();
        while ($comment =& $comments->getNext()):?>
 <item rdf:about="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment->getId()), 'fragment' => 'comment' . $comment->getId()));?>">
  <title><?php _h(Sabai_I18N::strcutMore($comment->get('title'), 50));?></title>
  <description><?php _h(Sabai_I18N::strcutMore(strip_tags(strtr($comment->get('body_html'), array("\r" => '', "\n" => ''))), 500));?></description>
  <content:encoded><![CDATA[<?php echo $comment->get('body_html');?>]]></content:encoded>
  <link><?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment->getId()), 'fragment' => 'comment' . $comment->getId()));?></link>
  <dc:creator><?php $comment_user =& $comment->get('User'); _h($comment_user->getName());?></dc:creator>
  <dc:date><?php echo date('Y-m-d\TH:i', $comment->getTimeCreated()); ?></dc:date>
 </item>
<?php   endwhile;?>
<?php endif;?>
</rdf:RDF>