<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_Wiki
{
  public $mPreXCodePriority = 50;
  public $mPostXCodePriority = 50;

  public function getPreXCodePatterns()
  {
    $patterns[] = "/\[wiki\](.*)\[\/wiki\]/esU";
    $replacements[] = "'[wiki]'.base64_encode('$1').'[/wiki]'";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public function getPostXCodePatterns()
  {
    $patterns[] = "/\[wiki\](.*)\[\/wiki\]/esU";
    $replacements[0][] = $replacements[1][] = "MCLXCode_Wiki::wikiText('$1')";
    return array('pat' => $patterns, 'rep' => $replacements);
  }
  
  public static function wikiText($text)
  {
    $text = MCL_TextFilter::decode_base64($text);
    $text = MCL_TextFilter::htmlspchr($text, ENT_COMPAT);
    if ( !strstr( ini_get('include_path') , XOOPS_MODULE_PATH.'/mcllibs/plugins/PEAR' ) ) {
      ini_set('include_path', ini_get('include_path').';'.XOOPS_MODULE_PATH.'/mcllibs/plugins/PEAR') ;
    }
    
    if ( !class_exists( 'Text_Wiki' ) ) {
      require XOOPS_MODULE_PATH.'/mcllibs/plugins/PEAR/Text/Wiki.php';
    }
    $wiki = new Text_Wiki();
    $wiki->setFormatConf('Xhtml', 'translate', false);
    return $wiki->transform($text);
  }
}
