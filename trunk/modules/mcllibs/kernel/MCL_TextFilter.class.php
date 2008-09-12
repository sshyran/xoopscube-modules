<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCL_TextFilter
{
  public $mClickablePatterns = array();
  public $mClickableReplacements = array();

  public $mXCodePatterns = array();
  public $mXCodeReplacements = array();
  public $mXCodeCheckImgPatterns = array();

  public $mPreXCodePatterns = array();
  public $mPreXCodeReplacements = array();

  public $mPostXCodePatterns = array();
  public $mPostXCodeReplacements = array();
  
  public $mSmileys = array();
  public $mSmileysConvTable = array();
  
  public $mLangPatterns = array();
  public $mLangReplacements = array();
  
  private $_mPlugins = array();
  
  private static $instance;
  
  private function __construct()
  {
    $this->_loadPlugins(XOOPS_MODULE_PATH.'/mcllibs/plugins/');
  }

  public static function getInstance()
  {
    if ( !isset(self::$instance) ) {
      self::$instance = new MCL_TextFilter();
    }
    return self::$instance;
  }
  
  public function loadModPlgs($dirname)
  {
    $path = XOOPS_MODULE_PATH.'/'.$dirname.'/plugins/';
    if ( $this->_loadPlugins($path) ) {
      $this->_recreate();
    }
  }
  
  public function htmlspchr($text, $quote = ENT_QUOTES)
  {
    return htmlspecialchars($text, $quote, _CHARSET);
  }
  
  public function cutstr($str, $length, $trimmaker = '', $strip = false)
  {
    if ( $strip ) {
      $str = strip_tags($str);
    }
    
    if ( XOOPS_USE_MULTIBYTES ) {
      return mb_strimwidth($str, 0, $length, $trimmaker);
    } else {
      return (strlen($str) <= $length) ? substr($str, 0, $length) : substr($str, 0, $length - strlen($trimmarker)).$trimmarker;
    }
  }
  
  public function strlen($str)
  {
    if ( XOOPS_USE_MULTIBYTES ) {
      return mb_strlen($str);
    } else {
      return strlen($str);
    }
  }
  
  public function toShow($text, $conv = false)
  {
    $text = preg_replace("/&amp;(#[0-9]+|#x[0-9a-f]+|[a-z]+[0-9]*);/i", '&\\1;', $this->htmlspchr($text));
    if ( $conv ) {
      if (empty($this->mLangPatterns)) {
        $this->_getPatterns('Lang');
      }
      $text =  preg_replace($this->mLangPatterns, $this->mLangReplacements, $text);
    }
    return $text;
  }
  
  public function toEdit($text)
  {
    return preg_replace("/&amp;(#0?[0-9]{4,6};)/i", '&$1', $this->htmlspchr($text));
  }

  public function toShowTarea($text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1)
  {
    $text = $this->preConvertXCode($text, $xcode);
    if ($html != 1) {
      $text = $this->toShow($text);
    }
    $text = $this->makeClickable($text);
    if ($smiley != 0) {
      $text = $this->smiley($text);
    }
    if ($xcode != 0) {
      $text = $this->convertXCode($text, $image);
    }
    if ($br != 0) {
      $text = nl2br($text);
    }
    $text = $this->postConvertXCode($text, $xcode, $image);
    return $text;
  }

  public function getSmileys()
  {
    if (count($this->mSmileys) == 0) {
      $this->mSmileysConvTable[0] = $this->mSmileysConvTable[1] = array();
      $db = XoopsDatabaseFactory::getDatabaseConnection();
      if ($getsmiles = $db->query("SELECT * FROM ".$db->prefix('smiles'))) {
        while ($smile = $db->fetchArray($getsmiles)) {
          $this->mSmileys[] = $smile;
          $this->mSmileysConvTable[0][] = $smile['code'];
          $this->mSmileysConvTable[1][] = '<img src="'.XOOPS_UPLOAD_URL.'/'.$this->htmlspchr($smile['smile_url']).'" alt="'.$this->htmlspchr($smile['emotion']).'"  alt="'.$this->htmlspchr($smile['emotion']).'"/>';
        }
      }
      $this->_getSmileysConvTable();
    }
    return $this->mSmileys;
  }
  
  public function smiley($text)
  {
    if (count($this->mSmileys) == 0) {
      $this->getSmileys();
    }
    if (count($this->mSmileys) != 0) {
      $text = str_replace($this->mSmileysConvTable[0], $this->mSmileysConvTable[1], $text);
    }
    return $text;
  }
  
  public function makeClickable($text)
  {
    if (empty($this->mClickablePatterns)) {
      $this->_getPatterns('Clickable');
    }
    $text = preg_replace($this->mClickablePatterns, $this->mClickableReplacements, $text);
    return $text;
  }
  
  public function convertXCode($text, $allowimage = 1)
  {
    if (empty($this->mXCodePatterns)) {
      $this->_getPatterns('XCode', 1);
    }
    if (empty($this->mXCodeCheckImgPatterns)) {
      $this->_getCheckImgPatterns();
    }
    $text = preg_replace_callback($this->mXCodeCheckImgPatterns, array($this, '_filterImgUrl'), $text);
    $replacementsIdx = ($allowimage == 0) ? 0 : 1;
    $text = preg_replace($this->mXCodePatterns, $this->mXCodeReplacements[$replacementsIdx], $text);
    return $text;
  }

  public function nl2Br($text)
  {
    return nl2br($text);
  }

  public function preConvertXCode($text, $xcode = 1)
  {
    if($xcode != 0){
      if (empty($this->mPreXCodePatterns)) {
        $this->_getPatterns('PreXCode');
      }
      $text =  preg_replace($this->mPreXCodePatterns, $this->mPreXCodeReplacements, $text);
    }
    return $text;
  }

  public function postConvertXCode($text, $xcode = 1, $image = 1)
  {
    if ($xcode != 0) {
      if (empty($this->mPostXCodePatterns)) {
        $this->_getPatterns('PostXCode', 1);
      }
      $replacementsIdx = ($image == 0) ? 0 : 1;
      $text =  preg_replace($this->mPostXCodePatterns, $this->mPostXCodeReplacements[$replacementsIdx], $text);
    }
    return $text;
  }
  
  public function decode_base64($text)
  {
    return str_replace('\"', '"', base64_decode($text));
  }
  
  /* private method */
  private function _loadPlugins($path)
  {
    if (is_dir($path)) {
      if ($handler = opendir($path)) {
        while (($file = readdir($handler)) !== false) {
          if (preg_match("/(\w+)\.class\.php$/", $file, $matches)) {
            require_once $path . $file;
            $className = 'MCLXCode_'.$matches[1];
            if (class_exists($className)) {
              $this->_mPlugins[] = new $className();
            }
          }
        }
        closedir($handler);
        return true;
      }
    }
    return false;
  }
  
  private function _recreate()
  {
    $this->mClickablePatterns = array();
    $this->mClickableReplacements = array();
    
    $this->mXCodePatterns = array();
    $this->mXCodeReplacements = array();
    $this->mXCodeCheckImgPatterns = array();
    
    $this->mPreXCodePatterns = array();
    $this->mPreXCodeReplacements = array();
    
    $this->mPostXCodePatterns = array();
    $this->mPostXCodeReplacements = array();
    
    $this->mSmileysConvTable = array();
    $this->mSmileys = array();
    
    $this->mPostTitlePatterns = array();
    $this->mPostTitleReplacements = array();
    
    $this->_getPatterns('Clickable');
    $this->_getPatterns('XCode', 1);
    $this->_getCheckImgPatterns();
    $this->_getPatterns('PreXCode');
    $this->_getPatterns('PostXCode', 1);
    $this->_getPatterns('Title');
    
    $this->getSmileys();
  }

  private function _getSmileysConvTable()
  {
    $chains = array();
    foreach (array_keys($this->_mPlugins) as $i) {
      if ( method_exists($this->_mPlugins[$i], 'getSmileysConvTable') ) {
        $priority = isset($this->_mPlugins[$i]->mSmileysConvPriority) ? $this->_mPlugins[$i]->mSmileysConvPriority : 50;
        $chains[$priority][] = $this->_mPlugins[$i]->getSmileysConvTable();
      }
    }
    ksort($chains);
    
    foreach ($chains as $calls) {
      foreach ($calls as $call) {
        if ( count($call) > 0 ) {
          foreach ($call as $pattern) {
            $this->mSmileys[] = $pattern;
            $this->mSmileysConvTable[0][] = $pattern['code'];
            $this->mSmileysConvTable[1][] = '<img src="'.$this->htmlspchr($pattern['smile_url']).'" alt="'.$this->htmlspchr($pattern['emotion']).'"  alt="'.$this->htmlspchr($pattern['emotion']).'"/>';
          }
        }
      }
    }
  }
  
  private function _getPatterns($type, $image = 0)
  {
    $chains = array();
    $method = 'get'.$type.'Patterns';
    $num = 'm'.$type.'Priority';
    $patterns = 'm'.$type.'Patterns';
    $replaces = 'm'.$type.'Replacements';
    
    foreach (array_keys($this->_mPlugins) as $i) {
      if ( method_exists($this->_mPlugins[$i], $method) ) {
        $priority = isset($this->_mPlugins[$i]->$num) ? $this->_mPlugins[$i]->$num : 50;
        $chains[$priority][] = $this->_mPlugins[$i]->$method();
      }
    }
    ksort($chains);
    
    foreach ($chains as $calls) {
      foreach ($calls as $call) {
        if ( count($call) > 0 ) {
          $tmp_pat = $this->$patterns;
          foreach ($call['pat'] as $pattern) {
            $tmp_pat[] = $pattern;
          }
          $this->$patterns = $tmp_pat;
          
          $tmp_rep = $this->$replaces;
          if ( $image != 0 ) {
            if ( !isset($tmp_rep[0]) ) {
              $tmp_rep[0] = $call['rep'][0];
              $tmp_rep[1] = $call['rep'][1];
            } else {
              foreach ($call['rep'][0] as $replace) {
                $tmp_rep[0][] = $replace;
              }
              foreach ($call['rep'][1] as $replace) {
                $tmp_rep[1][] = $replace;
              }
            }
          } else {
            foreach ($call['rep'] as $replace) {
              $tmp_rep[] = $replace;
            }
          }
          $this->$replaces = $tmp_rep;
        }
      }
    }
  }
  
  private function _getCheckImgPatterns()
  {
    $chains = array();
    foreach (array_keys($this->_mPlugins) as $i) {
      if ( method_exists($this->_mPlugins[$i], 'getXCodeCheckImgPatterns') ) {
        $priority = isset($this->_mPlugins[$i]->mXCodeCheckImgPriority) ? $this->_mPlugins[$i]->mXCodeCheckImgPriority : 50;
        $chains[$priority][] = $this->_mPlugins[$i]->getXCodeCheckImgPatterns();
      }
    }
    ksort($chains);
    
    foreach ($chains as $calls) {
      foreach ($calls as $call) {
        if ( count($call) > 0 ) {
          foreach ($call as $pattern) {
            $this->mXCodeCheckImgPatterns[] = $pattern;
          }
        }
      }
    }
  }
  
  private function _filterImgUrl($matches)
  {
    if ($this->_checkUrlString($matches[2])) {
      return $matches[0];
    } else {
      return "";
    }
  }

  private function _checkUrlString($text)
  {
    if (preg_match("/[\\0-\\31]/", $text)) {
        return false;
    }
    // check black pattern(deprecated)
    return !preg_match("/^(javascript|vbscript|about):/i", $text);
  }
}
?>
