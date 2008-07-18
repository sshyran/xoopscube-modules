<?php echo'<?';?>xml version="1.0" encoding="utf-8" ?>
<rdf:RDF
  xmlns="http://purl.org/rss/1.0/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:annotate="http://purl.org/rss/1.0/modules/annotate/"
  xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/"
  xml:lang="<?php echo Sabai_I18N::lang();?>">
 <channel rdf:about="<?php echo $this->Request->createUri(array('base' => '/rss/upcoming'));?>">
  <title><?php _h($sitename);?><?php if(isset($requested_category)):?> (<?php _h($requested_category->getLabel());?>)<?php endif;?></title>
  <link><?php if(!isset($requested_category)):?><?php echo $this->Request->createUri(array('base' => '/node/upcoming', 'params' => array('keyword' => $requested_keyword)));?><?php else:?><?php echo $this->Request->createUri(array('base' => '/node/upcoming', array('category_id' => $requested_category->getId(), 'keyword' => $requested_keyword));?><?php endif;?></link>
  <description><?php echo _('Recent upcoming news entries');?></description>
  <items>
<?php if (isset($nodes)):?>
   <rdf:Seq>
<?php   while ($node =& $nodes->getNext()):?>
    <rdf:li rdf:resource="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId()));?>"/>
<?php   endwhile;?>
   </rdf:Seq>
<?php endif;?>
  </items>
 </channel>
<?php if (isset($nodes)): $nodes->rewind();
        $nodes =& $nodes->with('Tags'); $nodes =& $nodes->with('User'); $nodes->rewind();
        while ($node =& $nodes->getNext()):?>
 <item rdf:about="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId()));?>">
  <title><?php _h($node->getLabel());?></title>
  <link><?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId()));?></link>
  <description><?php if ($teaser = $node->get('teaser_html')):?><?php _h(strip_tags(strtr($teaser, array("\r" => '', "\n" => ''))));?><?php else:?><?php _h(strip_tags(strtr($node->get('body_html'), array("\r" => '', "\n" => ''))));?><?php endif;?></description>
  <content:encoded><![CDATA[<?php if ($teaser_html = $node->get('teaser_html')):?><?php echo $teaser_html;?><p><a href="<?php echo $this->Request->createUri(array('base' => '/node/' . $node->getId(), 'fragment' => 'nodeBody'));?>" title="<?php echo _('Read full story');?>"><?php echo _('more...');?></a></p><?php else:?><?php echo $node->get('body_html');?><?php endif;?>]]></content:encoded>
<?php     if ($source = $node->get('source')):?>
  <annotate:reference rdf:resource="<?php _h($source, ENT_COMPAT);?>"/>
<?php     endif;?>
  <dc:creator><?php $node_user =& $node->get('User'); _h($node_user->getName());?></dc:creator>
  <dc:date><?php echo date('Y-m-d\TH:i', $node->get('published'));?></dc:date>
<?php     if ($category =& $node->get('Category')):?>
  <dc:subject><?php _h($category->getLabel());?></dc:subject>
<?php     endif; $node_tags =& $node->get('Tags');
          if ($node_tags->size() > 0):?>
  <taxo:topics>
   <rdf:Bag>
<?php       while ($tag =& $node_tags->getNext()):?>
    <rdf:li resource="<?php echo $this->Request->createUri(array('base' => '/tag/' . $tag->getEncodedName()));?>"/>
<?php       endwhile;?>
   </rdf:Bag>
  </taxo:topics>
<?php     endif;?>
 </item>
<?php   endwhile;?>
<?php endif;?>
</rdf:RDF>