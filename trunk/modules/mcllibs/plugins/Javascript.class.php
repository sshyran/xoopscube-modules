<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_Javascript
{
  public $mXCodePriority = 50;
  public $mXCodeCheckImgPriority = 50;
  
  public function getXCodePatterns()
  {
    $patterns[] = "/\[video url\=http:\/\/(jp|www)\.youtube\.com\/watch\?v\=([0-9a-zA-Z-_]*)\]/esU";
    $replacements[0][] = $replacements[1][] = "'<a href=\"http://\\1.youtube.com/watch?v=\\2\" rel=\"vidbox\"><img src=\"http://img.youtube.com/vi/\\2/1.jpg\" /></a>'";
    
    $patterns[] = "/\[video url\=(http[s]?:\/\/[^\"'<>]*) title\=([^\s]*) width\=([0-9]{1,3}+) height\=([0-9]{1,3}+)\](.*)\[\/video\]/esU";
    $replacements[0][] = $replacements[1][] = "'<a href=\"\\1\" rel=\"vidbox \\3 \\4\" title=\"\\2\">\\5</a>'";
    $patterns[] = "/\[video url\=(http[s]?:\/\/[^\"'<>]*) title\=(.*)\](.*)\[\/video\]/esU";
    $replacements[0][] = $replacements[1][] = "'<a href=\"\\1\" rel=\"vidbox\" title=\"\\2\">\\3</a>'";
    
    $patterns[] = "/\[grey url\=(http[s]?:\/\/[^\"'<>]*) title\=([^\s]*) type\=([^\s]*) option\=([^\s]*)\](.*)\[\/grey\]/esU";
    $replacements[0][] = $replacements[1][] = "'<a href=\"\\1\" rel=\"\\3[\\4]\" title=\"\\2\">\\5</a>'";
    $patterns[] = "/\[grey url\=(http[s]?:\/\/[^\"'<>]*) title\=([^\s]*) type\=([^\s]*)\](.*)\[\/grey\]/esU";
    $replacements[0][] = $replacements[1][] = "'<a href=\"\\1\" rel=\"\\3[]\" title=\"\\2\">\\4</a>'";
    
    $patterns[] = "/\[light url\=(http[s]?:\/\/[^\"'<>]*) title\=([^\s]*) option\=([^\s]*)\](.*)\[\/light\]/esU";
    $replacements[0][] = $replacements[1][] = "'<a href=\"\\1\" rel=\"lightbox[\\3]\" title=\"\\2\">\\4</a>'";
    $patterns[] = "/\[light url\=(http[s]?:\/\/[^\"'<>]*) title\=([^\s]*)\](.*)\[\/light\]/esU";
    $replacements[0][] = $replacements[1][] = "'<a href=\"\\1\" rel=\"lightbox\" title=\"\\2\">\\3</a>'";
    
    return array('pat' => $patterns, 'rep' => $replacements);
  }
}
?>
