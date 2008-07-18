<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Element
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Form/Element.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Element
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Form_Element_InputFile extends Sabai_Form_Element
{
    var $_uploadDir;
    var $_maxSize;
    var $_required;
    var $_allowedExtensions;
    var $_binaryAsValue;
    var $_finfoEnabled;

    function Sabai_Form_Element_InputFile($name, $uploadDir, $maxSize = 0, $required = false, $binaryAsValue = false)
    {
        parent::Sabai_Form_Element($name);
        $this->_uploadDir = $uploadDir;
        $this->_maxSize = intval($maxSize);
        $this->_required = $required;
        $this->_binaryAsValue = (bool)$binaryAsValue;
        $this->_finfoEnabled = function_exists('finfo_open');
    }

    function addAllowedExtension($extension, $mime = null)
    {
        $this->_allowedExtensions[strtolower($extension)] = $mime;
    }

    function allowImages()
    {
        $image_extensions = array('gif'  => IMAGETYPE_GIF,
                                  'jpg'  => IMAGETYPE_JPEG,
                                  'jpeg' => IMAGETYPE_JPEG,
                                  'png'  => IMAGETYPE_PNG,
                                  'bmp'  => IMAGETYPE_BMP);
        foreach ($image_extensions as $ext => $mime) {
            $this->addAllowedExtension($ext, $mime);
        }
    }

    function getHTML($attr)
    {
        $html = '<input type="hidden" name="MAX_FILE_SIZE" value="%d" /><input type="file" name="%s"%s />';
        return sprintf($html, $this->_maxSize, h($this->getName()), $this->attrToHTML($attr));
    }

    function validate()
    {
        if (empty($_FILES)) {
            if ($this->_required) {
                $this->addValidationError($this->getName() . ' is required');
            }
        } else {
            $file = $_FILES[$this->_name];
            $file_name = basename($file['name']);
            $file_path = $this->_uploadDir . '/' . $file_name;
            if (!$valid_file_path = $this->_validateFile($file_name, $file['type'], $file['size'], $file['tmp_name'], $file['error'], $file_path)) {
                unset($_FILES[$this->_name]);
                $this->addValidationError(sprintf('Invalid file %s', $file_name));
                @unlink($file_path);
            } else {
                if ($this->_binaryAsValue) {
                    if ($fp = @fopen($valid_file_path, 'rb')) {
                        if ($content = @fread($fp, filesize($valid_file_path))) {
                            $this->setValue($content);
                        } else {
                            $this->addValidationError(sprintf('Failed reading uploaded file %s', $file_name));
                        }
                        fclose($fp);
                    } else {
                        $this->addValidationError(sprintf('Failed opening uploaded file %s', $file_name));
                    }
                    @unlink($valid_file_path);
                } else {
                    $this->setValue($file_name);
                }
            }
        }
    }

    function _validateFile($fileName, $fileType, $fileSize, $fileTmpName, $fileError, $filePath)
    {
        if ($fileError > 0) {
            return false;
        }
        if ($fileTmpName == 'none') {
            return false;
        }
        if (!is_uploaded_file($fileTmpName)) {
            return false;
        }
        if (strlen(trim($fileName)) <= 0) {
            return false;
        }
        if ($this->_maxSize > 0 && $fileSize > $this->_maxSize) {
            return false;
        }
        if (!$ext_pos = strrpos($fileName, '.')) {
            return false;
        }
        if (!$this->_validateFileExtension(substr($fileName, $ext_pos + 1), $fileTmpName)) {
            return false;
        }
        if (!move_uploaded_file($fileTmpName, $filePath)) {
            return false;
        }
        return $filePath;
    }

    function _validateFileExtension($extension, $fileTmpName)
    {
        $extension = strtolower($extension);
        if (!array_key_exists($extension, $this->_allowedExtensions)) {
            return false;
        }
        foreach ((array)$this->_allowedExtensions[$extension] as $allowed_mime) {
            if (is_int($allowed_mime)) {
                if ($allowed_mime > 0) {
                    if (!$image_size = getimagesize($fileTmpName)) {
           	    		return false;
                    }
                    if ($image_size[2] != $allowed_mime) {
                        return false;
                    }
                }
            } else {
                if ($this->_finfoEnabled) {
                    $finfo = finfo_open(FILEINFO_MIME);
                    if ($allowed_mime != finfo_file($finfo, $fileTmpName)) {
                        finfo_close($finfo);
                        return false;
                    }
                    finfo_close($finfo);
                }
            }
        }
        return true;
    }
}