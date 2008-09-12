<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_Note
{
  public $mClickablePriority = 50;
  public $mXCodePriority = 50;
  public $mXCodeCheckImgPriority = 50;
  public $mPreXCodePriority = 50;
  public $mPostXCodePriority = 50;
  
  private static $_note_text = "";
  private static $_note_num = 1;
  
  public function getXCodePatterns()
  {
    $patterns[] = "/\[note\=(\w{1,2})\]/sU";
    $replacements[0][] = $replacements[1][] = '<span style="font-size:xx-small;"><a href="#notefoot_\\1" name="notetext_\\1"><sup style="color:red;">*\\1</sup></a></span>';
    $patterns[] = "/\[foot\=(\w{1,2})\](.*)\[\/foot\]/sU";
    $replacements[0][] = $replacements[1][] = '<span style="font-size:x-small;"><a href="#notetext_\\1" name="notefoot_\\1"><span style="color:red;">*\\1</span></a>&nbsp;\\2</span>';
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public function getPreXCodePatterns()
  {
    $patterns[] = "/\[note\](.*)\[\/note\]/esU";
    $replacements[] = "'[note]'.base64_encode('$1').'[/note]'";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public function getPostXCodePatterns()
  {
    $patterns[] = "/\[note\](.*)\[\/note\]/esU";
    $replacements[0][] = $replacements[1][] = "MCLXCode_Note::noteText('$1')";
    $patterns[] = '/([^\\x00](.*))/es';
    $replacements[0][] = $replacements[1][] = "MCLXCode_Note::areaText('$1')";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public static function noteText($text)
  {
    $text = MCL_TextFilter::decode_base64($text);
    self::$_note_text[] = MCL_TextFilter::htmlspchr($text);
    $num = count(self::$_note_text);
    $cnt = self::$_note_num;
    return '<span style="font-size:xx-small;"><a href="#notefoota'.$cnt.'_'.$num.'" name="notetexta'.$cnt.'_'.$num.'"><sup style="color:red;">*'.$num.'</sup></a></span>';
  }
  
  public static function areaText($text)
  {
    $text = str_replace('\"', '"', $text);
    if ( isset(self::$_note_text) && is_array(self::$_note_text) ) {
      $cnt = self::$_note_num;
      $text.= '<div class="Notes">';
      foreach (self::$_note_text as $k => $value) {
        $text.= '<div style="font-size:x-small;"><a href="#notetexta'.$cnt.'_'.($k+1).'" name="notefoota'.$cnt.'_'.($k+1).'"><span style="color:red;">*'.($k+1).'&nbsp;'.$value.'</span></a></div>';
      }
      $text.= '</div>';
      self::$_note_text = "";
      self::$_note_num++;
    }
    return $text;
  }
}
?>