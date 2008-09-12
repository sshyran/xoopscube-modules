<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_ImageTitle
{
  public $mXCodePriority = 50;
  public $mXCodeCheckImgPriority = 50;
  
  public function getXCodePatterns()
  {
    $patterns[] = "/\[img align\=(['\"]?)(left|center|right) title\=([^\s]*)\]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
    $replacements[0][] = '<a href="\\4" target="_blank">\\3</a>';
    $replacements[1][] = '<img src="\\4" align="\\2" alt="\\3" title="\\3" />';
    $patterns[] = "/\[img title\=([^\s]*)\]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
    $replacements[0][] = '<a href="\\3" target="_blank">\\2</a>';
    $replacements[1][] = '<img src="\\3" alt="\\2" title="\\2" />';
    return array('pat' => $patterns, 'rep' => $replacements);
  }
}
?>