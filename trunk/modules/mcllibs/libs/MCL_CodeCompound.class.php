<?php
/*
 * 暗号・復号クラス
 * mcrypt関数を使用するので、mcrypt関数が無い場合は単にbase64されるだけです。
 *
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
 
/*
//暗号化
//define('XOOPS_SALT', '9a66f188');
$text = '暗号化前の文章';
$gen = new MCL_CodeCompound();
$enc = $gen->Generic($text);
$iv = $gen->getIV();
echo $text.'<br />';
echo '暗号化テキスト：'.$enc.'<br />';
echo 'IV：'.$iv.'<hr />';

//複合化
$com = new MCL_CodeCompound();
$com->setIV($iv);
$str = $com->Compound($enc);
echo $str.'<br />';
*/

class MCL_CodeCompound
{
  private $iv = null;
  private $mcrypt = false;
  private $type = null;
  private $mode = null;
  private $rnd = null;
  
  /*
   * @param $type 暗号化タイプ
   * MCRYPT_3DES,MCRYPT_CRYPT,MCRYPT_BLOWFISH,MCRYPT_DESなど
   * 
   * @param $mode 暗号化モード
   * MCRYPT_MODE_ECB,MCRYPT_MODE_CBC,MCRYPT_MODE_CFB,MCRYPT_MODE_OFB,MCRYPT_MODE_NOFB,MCRYPT_MODE_STREAM
   **/
  public function __construct($type = "", $mode = "")
  {
    $this->mcrypt = function_exists('mcrypt_module_open');
    if ( $this->mcrypt ) {
      $this->type = ($type !== "") ? $type : MCRYPT_3DES;
      $this->mode = ($mode !== "") ? $mode : MCRYPT_MODE_CBC;
      if ( strpos(strtolower(PHP_OS), 'win') === false ) {
        $this->rnd = MCRYPT_DEV_RANDOM;
      } else {
        $this->rnd = MCRYPT_RAND;
      }
    }
  }
  
  public function getIV()
  {
    return base64_encode($this->iv);
  }
  
  public function setIV($iv)
  {
    $this->iv = base64_decode($iv);
  }
  
  public function Generic($text)
  {
    if ($this->mcrypt) {
      $text = $this->_crypt($text);
    }
    return base64_encode($text);
  }
  
  public function Compound($text)
  {
    $text = base64_decode($text);
    if ($this->mcrypt) {
      $text = $this->_decrypt($text);
    }
    return $text;
  }
  
  private function _crypt($text)
  {
    $td = $this->_getResource();
    $text = mcrypt_generic($td, $text);
    
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    
    return $text;
  }
  
  private function _decrypt($text)
  {
    $td = $this->_getResource();
    $text = mdecrypt_generic($td, $text);
    
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    
    return rtrim($text, "\0");
  }
  
  private function _getResource()
  {
    srand();
    $td = mcrypt_module_open($this->type, '', $this->mode, '');
    if ( strlen($this->iv) != mcrypt_enc_get_iv_size($td) ) {
      $this->iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), $this->rnd);
    }
    $key = substr(sha1(XOOPS_SALT), 0, mcrypt_enc_get_key_size($td));
    mcrypt_generic_init($td, $key, $this->iv);
    return $td;
  }
}
?>