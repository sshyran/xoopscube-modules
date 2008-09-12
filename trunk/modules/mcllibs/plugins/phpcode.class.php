<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_phpcode
{
  public $mPreXCodePriority = 10;
  public $mPostXCodePriority = 90;
  
  public function getPreXCodePatterns()
  {
    $patterns[] = "/\[none\](.*)\[\/none\]/esU";
    $replacements[] = "'[none]'.base64_encode('$1').'[/none]'";
    $patterns[] = '/\[phpcode\](.*?)\[\/phpcode\]/es';
    $replacements[] = "'[phpcode]'.base64_encode('$1').'[/phpcode]'";
    $patterns[] = '/\[phpsrc\](.*?)\[\/phpsrc\]/es';
    $replacements[] = "'[phpsrc]'.base64_encode('$1').'[/phpsrc]'";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public function getPostXCodePatterns()
  {
    $patterns[] = "/\[phpcode\](.*)\[\/phpcode\]/esU";
    $replacements[0][] = $replacements[1][] = "MCLXCode_phpcode::phpSource('$1', true)";
    $patterns[] = "/\[phpsrc\](.*)\[\/phpsrc\]/esU";
    $replacements[0][] = $replacements[1][] = "MCLXCode_phpcode::phpSource('$1')";
    $patterns[] = "/\[none\](.*)\[\/none\]/esU";
    $replacements[0][] = $replacements[1][] = "'<pre>'.MCLXCode_phpcode::codeSanitizer('$1').'</pre>'";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public static function codeSanitizer($text)
  {
    $text = MCL_TextFilter::decode_base64($text);
    return MCL_TextFilter::htmlspchr($text);
  }
  
  public static function phpSource($text, $tag = false)
  {
    $text = MCL_TextFilter::decode_base64($text);
    $text = preg_replace("/\r\n/","\n",$text);
    if ($tag) {
      $text = highlight_string("<?php\n".$text."\n?>", true);
      $patterns[] = '<span style="color: #0000BB">&lt;?php<br /></span>';
      $patterns[] = "<span style=\"color: #0000BB\">?&gt;</span>\n";
      $patterns[] = '<font color="#0000BB">)&lt;?php<br /></font>';
      $patterns[] = "<font color=\"#0000BB\">?&gt;</font>\n";
      $patterns[] = '&lt;?php<br />';
      $text = str_replace($patterns, "", $text);
    } else {
      $text = highlight_string($text, true);
    }
    return '<div class="phpsource" style="border: 1px solid gray;overflow: auto;">'.$text.'</div>';
  }
}
?>