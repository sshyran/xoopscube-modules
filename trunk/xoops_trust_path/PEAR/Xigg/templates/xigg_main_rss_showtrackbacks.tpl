<?php echo'<?';?>xml version="1.0" encoding="utf-8" ?>
<rdf:RDF
  xmlns="http://purl.org/rss/1.0/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:annotate="http://purl.org/rss/1.0/modules/annotate/"
  xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/"
  xml:lang="<?php echo Sabai_I18N::lang();?>">
 <channel rdf:about="<?php echo $this->Request->createUri(array('base' => '/rss/node/' . $node->getId() . '/trackbacks'));?>">
  <title><?php printf(_('%s (trackbacks)'), h($node->getLabel()));?></title>
  <link><?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'fragment' => 'nodeTrackbacks'));?></link>
  <description><?php echo _('Recently posted trackbacks');?></description>
  <items>
<?php if ($trackbacks->size() > 0):?>
   <rdf:Seq>
<?php   while ($trackback =& $trackbacks->getNext()):?>
    <rdf:li rdf:resource="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('trackback_id' => $trackback->getId()), 'fragment' => 'trackback' . $trackback->getId()));?>"/>
<?php   endwhile;?>
   </rdf:Seq>
<?php endif;?>
  </items>
 </channel>
<?php if ($trackbacks->size() > 0): $trackbacks->rewind();
        while ($trackback =& $trackbacks->getNext()):?>
 <item rdf:about="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('trackback_id' => $trackback->getId()), 'fragment' => 'trackback' . $trackback->getId()));?>">
  <title><?php _h($trackback->getLabel());?></title>
  <link><?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'params' => array('trackback_id' => $trackback->getId()), 'fragment' => 'trackback' . $trackback->getId()));?></link>
  <description><?php _h(Sabai_I18N::strcutMore(strip_tags(strtr($trackback->get('excerpt'), array("\r" => '', "\n" => ''))), 500));?></description>
  <content:encoded><![CDATA[<?php echo $trackback->get('excerpt');?>]]></content:encoded>
  <dc:creator><?php _h($trackback->get('blog_name'));?></dc:creator>
  <dc:date><?php echo date('Y-m-d\TH:i', $trackback->getTimeCreated()); ?></dc:date>
 </item>
<?php   endwhile;
      endif;?>
</rdf:RDF>