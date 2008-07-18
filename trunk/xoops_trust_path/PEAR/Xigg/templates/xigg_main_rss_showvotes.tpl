<?php echo'<?';?>xml version="1.0" encoding="utf-8" ?>
<rdf:RDF
  xmlns="http://purl.org/rss/1.0/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:annotate="http://purl.org/rss/1.0/modules/annotate/"
  xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/"
  xml:lang="<?php echo Sabai_I18N::lang();?>">
 <channel rdf:about="<?php echo $this->Request->createUri(array('base' => '/rss/node/' . $node->getId() . '/votes'));?>">
  <title><?php printf(_('%s (votes)'), h($node->getLabel()));?></title>
  <link><?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'fragment' => 'nodeVotes'));?></link>
  <description><?php echo _('Recently posted votes');?></description>
  <items>
<?php if ($votes->size() > 0):?>
   <rdf:Seq>
<?php   while ($vote =& $votes->getNext()):?>
    <rdf:li rdf:resource="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('vote_id' => $vote->getId()), 'fragment' => 'vote' . $vote->getId()));?>"/>
<?php   endwhile;?>
   </rdf:Seq>
<?php endif;?>
  </items>
 </channel>
<?php if ($votes->size() > 0): $votes->rewind();
        while ($vote =& $votes->getNext()):?>
 <item rdf:about="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('vote_id' => $vote->getId()), 'fragment' => 'vote' . $vote->getId()));?>">
  <title><?php $vote_user =& $vote->get('User'); _h($vote_user->getName());?></title>
  <link><?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('vote_id' => $vote->getId()), 'fragment' => 'vote' . $vote->getId()));?></link>
  <dc:creator><?php $vote_user =& $vote->get('User'); _h($vote_user->getName());?></dc:creator>
  <dc:date><?php echo date('Y-m-d\TH:i', $vote->getTimeCreated()); ?></dc:date>
 </item>
<?php   endwhile;?>
<?php endif;?>
</rdf:RDF>