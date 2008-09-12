<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_Youtube
{
  public $mXCodePriority = 50;
  public $mXCodeCheckImgPriority = 50;
  public $mClickablePriority = 30;

  public function getXCodePatterns()
  {
    $patterns[] = "/\[youtube id\=([0-9a-zA-Z-_]*)\]/esU";
    $replacements[0][] = $replacements[1][] = "'<object width=\"425\" height=\"355\"><param name=\"movie\" value=\"http://www.youtube.com/v/\\1&rel=1\"></param><param name=\"wmode\" value=\"transparent\"></param><embed src=\"http://www.youtube.com/v/\\1&rel=1&color1=0x000000&color2=0xa0a0a0&border=0\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"425\" height=\"355\"></embed></object>'";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public function getClickablePatterns()
  {
    $patterns[] = "/(^|[^]_a-z0-9-=\"'\/])http:\/\/(jp|www)\.youtube\.com\/watch\?v\=([0-9a-zA-Z-_]*)/e";
    $replacements[] = "'<object width=\"425\" height=\"355\"><param name=\"movie\" value=\"http://www.youtube.com/v/\\3&rel=1\"></param><param name=\"wmode\" value=\"transparent\"></param><embed src=\"http://www.youtube.com/v/\\3&rel=1&color1=0x000000&color2=0xa0a0a0&border=0\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"425\" height=\"355\"></embed></object>'";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
}
?>
