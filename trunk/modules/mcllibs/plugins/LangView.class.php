<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCLXCode_LangView
{
  public $mXCodePriority = 10;
  public $mLangPriority = 50;
  
  public function getLangPatterns()
  {
    if ( class_exists('LangSelect') ) {
      $root = XCube_Root::getSingleton();
      $selectlang = $root->mLanguageManager->mLanguageName;
      $langs_array = LangSelect::get_LangArray();
      foreach ( $langs_array as $langa ) {
        $langs[$langa[0]] = $langa[1];
      }
      
      foreach ( $langs as $language => $lang ) {
        $patterns[] = '/\['.$lang.'\](.*)\[\/'.$lang.'\]/sU';
        if ( $language == $selectlang ) {
          $replacements[] = '\\1';
        } else {
          $replacements[] = "";
        }
      }
      return array('pat' => $patterns, 'rep' => $replacements);
    }
  }
  
  public function getXCodePatterns()
  {
    if ( class_exists('LangSelect') ) {
      $root = XCube_Root::getSingleton();
      $selectlang = $root->mLanguageManager->mLanguageName;
      $langs_array = LangSelect::get_LangArray();
      foreach ( $langs_array as $langa ) {
        $langs[$langa[0]] = $langa[1];
      }
      
      foreach ( $langs as $language => $lang ) {
        $patterns[] = '/\['.$lang.'\](.*)\[\/'.$lang.'\]/sU';
        if ( $language == $selectlang ) {
          $replacements[0][] = $replacements[1][] = '\\1';
        } else {
          $replacements[0][] = $replacements[1][] = "";
        }
      }
      return array('pat' => $patterns, 'rep' => $replacements);
    }
  }
}
?>