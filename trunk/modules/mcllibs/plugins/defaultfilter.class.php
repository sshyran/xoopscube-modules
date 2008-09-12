<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_defaultfilter
{
  public $mClickablePriority = 50;
  public $mXCodePriority = 50;
  public $mXCodeCheckImgPriority = 50;
  public $mPreXCodePriority = 50;
  public $mPostXCodePriority = 50;
  
  public function getClickablePatterns()
  {
    $patterns[] = "/(^|[^]_a-z0-9-=\"'\/])([a-z]+?):\/\/([^, \r\n\"\(\)'<>]+)/ie";
    $replacements[] = "'\\1<a href=\"\\2://\\3\" '.MCLXCode_defaultfilter::getTarget('\\2://\\3').'>\\2://\\3</a>'";
    $patterns[] = "/(^|[^]_a-z0-9-=\"'\/])www\.([a-z0-9\-]+)\.([^, \r\n\"\(\)'<>]+)/i";
    $replacements[] = "\\1<a href=\"http://www.\\2.\\3\" target=\"_blank\">www.\\2.\\3</a>";
    $patterns[] = "/(^|[^]_a-z0-9-=\"'\/])ftp\.([a-z0-9\-]+)\.([^, \r\n\"\(\)'<>]+)/i";
    $replacements[] = "\\1<a href=\"ftp://ftp.\\2.\\3\" target=\"_blank\">ftp.\\2.\\3</a>";
    $patterns[] = "/(^|[^]_a-z0-9-=\"'\/:\.])([a-z0-9\-_\.]+?)@([^, \r\n\"\(\)'<>\[\]]+)/i";
    $replacements[] = "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public function getXCodePatterns()
  {
    $patterns[] = "/\[siteurl\=(['\"]?)([^\"'<>]*)\\1\](.*)\[\/siteurl\]/sU";
    $replacements[0][] = $replacements[1][] = '<a href="'.XOOPS_URL.'/\\2">\\3</a>';
    $patterns[] = "/\[url\=(['\"]?)(http[s]?:\/\/[^\"'<>]*)\\1\](.*)\[\/url\]/esU";
    $replacements[0][] = $replacements[1][] = "'<a href=\"\\2\"'.MCLXCode_defaultfilter::getTarget('\\2').'>\\3</a>'";
    $patterns[] = "/\[url\=(['\"]?)(ftp?:\/\/[^\"'<>]*)\\1\](.*)\[\/url\]/sU";
    $replacements[0][] = $replacements[1][] = '<a href="\\2" target="_blank">\\3</a>';
    $patterns[] = "/\[url\=(['\"]?)([^\"'<>]*)\\1\](.*)\[\/url\]/sU";
    $replacements[0][] = $replacements[1][] = '<a href="http://\\2" target="_blank">\\3</a>';
    
    $patterns[] = "/\[color\=(['\"]?)([a-zA-Z0-9]*)\\1\](.*)\[\/color\]/sU";
    $replacements[0][] = $replacements[1][] = '<span style="color: #\\2;">\\3</span>';
    $patterns[] = '/\[size\=([\'"]?)([x]{1,2}-small|small|medium|large|[x]{1,2}-large|[1-3]?[0-9]px|[1-3]?[0-9]pt|[0-9]em|[0-8]\.[1-9]em)\\1\](.*)\[\/size\]/sU';
    $replacements[0][] = $replacements[1][] = '<span style="font-size: \\2;">\\3</span>';
    $patterns[] = "/\[size\=(['\"]?)([a-z0-9-]*)\\1\](.*)\[\/size\]/sU";
    $replacements[0][] = $replacements[1][] = '\\3';
    $patterns[] = "/\[font\=(['\"]?)([^;<>\*\(\)\"']*)\\1\](.*)\[\/font\]/sU";
    $replacements[0][] = $replacements[1][] = '<span style="font-family: \\2;">\\3</span>';
    $patterns[] = "/\[email\]([^;<>\*\(\)\"']*)\[\/email\]/sU";
    $replacements[0][] = $replacements[1][] = '<a href="mailto:\\1">\\1</a>';
    $patterns[] = "/\[b\](.*)\[\/b\]/sU";
    $replacements[0][] = $replacements[1][] = '<span style="font-weight: bold;">\\1</span>';
    $patterns[] = "/\[i\](.*)\[\/i\]/sU";
    $replacements[0][] = $replacements[1][] = '<span style="font-style: italic;">\\1</span>';
    $patterns[] = "/\[u\](.*)\[\/u\]/sU";
    $replacements[0][] = $replacements[1][] = '<span style="text-decoration: underline;">\\1</span>';
    $patterns[] = "/\[d\](.*)\[\/d\]/sU";
    $replacements[0][] = $replacements[1][] = '<span style="text-decoration: line-through;">\\1</span>';
    $patterns[] = "/\[img align\=(['\"]?)(left|center|right)\\1\]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
    $replacements[0][] = '<a href="\\3" target="_blank">\\3</a>';
    $replacements[1][] = '<img src="\\3" align="\\2" alt="" />';
    $patterns[] = "/\[img\]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
    $replacements[0][] = '<a href="\\1" target="_blank">\\1</a>';
    $replacements[1][] = '<img src="\\1" alt="" />';
    $patterns[] = "/\[img align\=(['\"]?)(left|center|right)\\1 id\=(['\"]?)([0-9]*)\\3\]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
    $replacements[0][] = '<a href="'.XOOPS_URL.'/image.php?id=\\4" target="_blank">\\5</a>';
    $replacements[1][] = '<img src="'.XOOPS_URL.'/image.php?id=\\4" align="\\2" alt="\\5" />';
    $patterns[] = "/\[img id\=(['\"]?)([0-9]*)\\1\]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
    $replacements[0][] = '<a href="'.XOOPS_URL.'/image.php?id=\\2" target="_blank">\\3</a>';
    $replacements[1][] = '<img src="'.XOOPS_URL.'/image.php?id=\\2" alt="\\3" />';
    $patterns[] = "/\[siteimg align\=(['\"]?)(left|center|right)\\1\]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
    $replacements[0][] = '<a href"'.XOOPS_URL.'/\\3" target="_blank">'.XOOPS_URL.'/\\3</a>';
    $replacements[1][] = '<img src="'.XOOPS_URL.'/\\3" align="\\2" alt="" />';
    $patterns[] = "/\[siteimg\]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
    $replacements[0][] = '<a href"'.XOOPS_URL.'/\\1" target="_blank">'.XOOPS_URL.'/\\1</a>';
    $replacements[1][] = '<img src="'.XOOPS_URL.'/\\1" alt="" />';
    
    $patterns[] = "/\[quote\]/sU";
    $replacements[0][] = $replacements[1][] = _QUOTEC.'<div class="xoopsQuote"><blockquote>';
    $patterns[] = "/\[\/quote\]/sU";
    $replacements[0][] = $replacements[1][] = '</blockquote></div>';
    $patterns[] = "/javascript\:/si";
    $replacements[0][] = $replacements[1][] = "java script:";
    $patterns[] = "/about\:/si";
    $replacements[0][] = $replacements[1][] = "about :";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public function getXCodeCheckImgPatterns()
  {
    $patterns[] = "/\[img( align=\w+)\]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
    return $patterns;
  }
  
  public function getPreXCodePatterns()
  {
    $patterns[] = "/\[code\](.*)\[\/code\]/esU";
    $replacements[] = "'[code]'.base64_encode('$1').'[/code]'";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public function getPostXCodePatterns()
  {
    $patterns[] = "/\[code\](.*)\[\/code\]/esU";
    $replacements[0][] = "'<div class=\"xoopsCode\"><pre><code>'.MCLXCode_defaultfilter::codeSanitizer('$1', 0).'</code></pre></div>'";
    $replacements[1][] = "'<div class=\"xoopsCode\"><pre><code>'.MCLXCode_defaultfilter::codeSanitizer('$1', 1).'</code></pre></div>'";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public static function codeSanitizer($text, $image = 1)
  {
    $textfilter = MCL_TextFilter::getInstance();
    return $textfilter->convertXCode($textfilter->htmlspchr($textfilter->decode_base64($text)), $image);
  }
  
  public static function getTarget($url)
  {
    if ( preg_match("/^".preg_quote(XOOPS_URL, '/')."/", $url) ) {
      return "";
    } else {
      return ' target="_blank"';
    }
  }
}
?>