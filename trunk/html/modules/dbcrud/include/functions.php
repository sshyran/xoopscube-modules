<?php

if (!defined('_XGDB_FUNCTIONS_INCLUDED')) {
    define('_XGDB_FUNCTIONS_INCLUDED', true);

    /**
     * テキストボックスのinputタグを生成する.
     *
     * @param String $name name属性の値f
     * @param Array $item_def 項目の定義情報
     * @param String $default 初期値
     * @return String テキストボックスのinputタグ
     */
    function makeTextForm($name, $item_def, $default) {
        $myts =& MyTextSanitizer::getInstance();

        $ret = '<input type="text" name="' . $myts->htmlSpecialChars($name) . '" size="' . intval($item_def['size']) . '" maxlength="' . intval($item_def['max_length']) . '" value="' . $myts->htmlSpecialChars($default) . '" />';

        return $ret;
    }

    /**
     * チェックボックスのinputタグを生成する.
     *
     * @param String $name name属性の値
     * @param Array $item_def 項目の定義情報
     * @param Array $defaults 初期値
     * @return String チェックボックスのinputタグ
     */
    function makeCboxForm($name, $item_def, $defaults) {
        $myts =& MyTextSanitizer::getInstance();

        if (!is_array($defaults)) $defaults = string2array($defaults);
        $ret = '';

        foreach ($item_def['options'] as $key => $value) {
            $ret .= '<label style="margin-right: 1em;"><input type="checkbox" name="' . $myts->htmlSpecialChars($name) . '[]" value="' . $myts->htmlSpecialChars($value) . '"';
            foreach ($defaults as $default) {
                if ($default == $value) $ret .= " checked";
            }
            $ret .= '/>' . $myts->htmlSpecialChars($key) . '</label>';

            if ($item_def['option_br']) $ret .= '<br />';
        }
        if ($ret !== '' && substr($ret, -6) == '<br />') $ret = substr($ret, 0, -6);

        return $ret;
    }

    /**
     * ラジオボタンのinputタグを生成する.
     *
     * @param String $name name属性の値
     * @param Array $item_def 項目の定義情報
     * @param String $default 初期値
     * @return String ラジオボタンのinputタグ
     */
    function makeRadioForm($name, $item_def, $default) {
        $myts =& MyTextSanitizer::getInstance();

        $ret = '';

        foreach ($item_def['options'] as $key => $value) {
            $ret .= '<label style="margin-right: 1em;"><input type="radio" name="' . $myts->htmlSpecialChars($name) . '" value="' . $myts->htmlSpecialChars($value) . '"';
            if ($default == $value) $ret .= " checked";
            $ret .= '/>' . $myts->htmlSpecialChars($key) . '</label>';

            if ($item_def['option_br']) $ret .= '<br />';
        }
        if ($ret !== '' && substr($ret, -6) == '<br />') $ret = substr($ret, 0, -6);

        return $ret;
    }

    /**
     * プルダウンメニューのselectタグを生成する.
     *
     * @param String  $dirname モジュールディレクトリ名
     * @param String $name name属性の値
     * @param Array $item_def 項目の定義情報
     * @param String $default 初期値
     * @return String プルダウンメニューのselectタグ
     */
    function makeSelectForm($dirname, $name, $item_def, $default) {
        $affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);
        $myts =& MyTextSanitizer::getInstance();

        $not_selected_ary = array(constant('_' . $affix . '_NOT_SELECTED') => '');
        $item_def['options'] = $not_selected_ary + $item_def['options'];
        $ret = '<select name="' . $myts->htmlSpecialChars($name) . '">';

        foreach ($item_def['options'] as $key => $value) {
            $ret .= '<option value="' . $myts->htmlSpecialChars($value) . '"';
            if ($default === (string) $value) $ret .= ' selected="selected"';
            $ret .= '>' . $myts->htmlSpecialChars($key) . '</option>';
        }
        $ret .= '</select>';

        return $ret;
    }

    /**
     * リストボックスのselectタグを生成する.
     *
     * @param String $name name属性の値
     * @param Array $item_def 項目の定義情報
     * @param Array $defaults 初期値
     * @return String リストボックスのselectタグ
     */
    function makeMSelectForm($name, $item_def, $defaults) {
        $myts =& MyTextSanitizer::getInstance();

        if (!is_array($defaults)) $defaults = string2array($defaults);
        $ret = '<select name="' . $myts->htmlSpecialChars($name) . '[]" size="' . intval($item_def['size']) . '" multiple="multiple">';

        foreach ($item_def['options'] as $key => $value) {
            $ret .= '<option value="' . $myts->htmlSpecialChars($value) . '"';
            if (in_array($value, $defaults)) $ret .= ' selected="selected"';
            $ret .= '>' . $myts->htmlSpecialChars($key) . '</option>';
        }
        $ret .= '</select>';

        return $ret;
    }

    /**
     * テキストエリアのtextareaタグを生成する.
     *
     * @param String $name name属性の値
     * @param Array $item_def 項目の定義情報
     * @param String $default 初期値
     * @return String テキストエリアのtextareaタグ
     */
    function makeTAreaForm($name, $item_def, $default) {
        $myts =& MyTextSanitizer::getInstance();

        $ret = '<textarea name="' . $myts->htmlSpecialChars($name) . '" rows="' . intval($item_def['rows']) . '" cols="' . intval($item_def['cols']) . '">' . sanitize($default, $item_def) . '</textarea>';

        return $ret;
    }

    /**
     * BBコード対応テキストエリアのtextareaタグを生成する.
     *
     * @param String $name name属性の値
     * @param Array $item_def 項目の定義情報
     * @param String $default 初期値
     * @return String BBコード対応テキストエリアのtextareaタグ
     */
    function makeXTAreaForm($name, $item_def, $default) {
        $myts =& MyTextSanitizer::getInstance();

        $form = new XoopsFormDhtmlTextArea($myts->htmlSpecialChars($name), $myts->htmlSpecialChars($name), sanitize($default, $item_def), intval($item_def['rows']), intval($item_def['cols']));
        $ret = $form->render();

        return $ret;
    }

    /**
     * ファイルアップロードのinputタグを生成する.
     *
     * @param String $name name属性の値
     * @param Array $item_def 項目の定義情報
     * @return String ファイルアップロードのinput
     */
    function makeFileForm($name, $item_def) {
        $myts =& MyTextSanitizer::getInstance();
        $ret = '<input type="file" name="' . $myts->htmlSpecialChars($name) . '" size="' . intval($item_def['size']) . ' maxlength="' . intval($item_def['max_length']) . '"  />';

        return $ret;
    }

    /**
     * 指定したディレクトリ内でユニークになるランダムなファイル名を返す.
     *
     * @param String $ext ファイルの拡張子
     * @param String $target_dirpath ディレクトリのフルパス
     * @return String ファイル名(ディレクトリのパスは含まない)
     */
    function getUniqueFileName($ext, $target_dirpath) {
        $file_name = md5(XOOPS_SALT . uniqid(rand(), true)) . '.' . $ext;
        if (file_exists($target_dirpath . $file_name)) {
            $file_name = getUniqueFileName($ext, $target_dirpath);
        }

        return $file_name;
    }

    /**
     * ファイルの縦と横の大きさをリサイズする.
     *
     * @param String $file_name ファイル名(ファイルのパスを含む)
     * @param String $max_image_size 最大ファイルサイズ(px)
     * @return String リサイズしたファイルの拡張子。リサイズしなかった場合は空文字
     */
    function resizeImage($file_name, $max_image_size) {
        if (!extension_loaded('gd')) {
            return '';
        } else {
            $gd_infos = gd_info();
        }

        list($bef_x, $bef_y, $type) = getImageSize($file_name);
        if ($bef_x > $max_image_size || $bef_y > $max_image_size) {
            switch ($type) {
                case 1:
                    if (!$gd_infos['GIF Read Support'] || !$gd_infos['GIF Create Support']) return '';
                    $bef_img = ImageCreateFromGIF($file_name);
                    break;
                case 2:
                    if (!$gd_infos['JPG Support']) return '';
                    $bef_img = ImageCreateFromJPEG($file_name);
                    break;
                case 3:
                    if (!$gd_infos['PNG Support']) return '';
                    $bef_img = ImageCreateFromPNG($file_name);
                    break;
            }

            if ($bef_x > $bef_y) {
                $aft_x = $max_image_size;
                $aft_y = $bef_y * ($max_image_size / $bef_x);
            } else {
                $aft_x = $bef_x * ($max_image_size / $bef_y);
                $aft_y = $max_image_size;
            }

            $aft_img = ImageCreateTrueColor($aft_x, $aft_y);
            ImageCopyResampled($aft_img, $bef_img, 0, 0, 0, 0, $aft_x, $aft_y, $bef_x, $bef_y);
            ImageDestroy($bef_img);

            switch ($type) {
                case 1:
                    imageGIF($aft_img, $file_name);
                    ImageDestroy($aft_img);
                    return 'gif';
                case 2:
                    imageJPEG($aft_img, $file_name);
                    ImageDestroy($aft_img);
                    return 'jpg';
                case 3:
                    imagePNG($aft_img, $file_name);
                    ImageDestroy($aft_img);
                    return 'png';
            }
        }

        return '';
    }

    /**
     * 権限をチェックする.
     *
     * @param Array $user_groups ユーザーが所属するグループのグループIDの配列
     * @param Array $perm_groups 権限を持つグループのグループIDの配列
     * @return Boolean 権限がある場合はtrue、ない場合はfalse
     */
    function checkPerm($user_groups, $perm_groups) {
        foreach ($user_groups as $gid) {
            if (in_array($gid, $perm_groups)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 指定したグループIDのグループに属するユーザーのXoopsUserObjectの配列を取得する.
     *
     * @param Array グループIDの配列
     * @return Array ユーザーのXoopsUserObjectの配列
     */
    function getUsers($gids) {
        $ret = array();

        foreach ($gids as $gid) {
            $member_handler =& xoops_gethandler('member');
            $users =& $member_handler->getUsersByGroup($gid, true);
            foreach ($users as $user) {
                $ret[$user->getVar('uid')] = $user;
            }
        }

        return $ret;
    }

    /**
     * stripslashes関数で再帰的に処理して返す.
     *
     * @param $value stripslashes関数で処理する値
     * @return String/Array 引数をstripslashes関数で処理した値
     */
    function stripSlashesDeep($value) {
        if (is_array($value)) {
            $value = array_map('stripSlashesDeep', $value);
        } else {
            $value = stripslashes($value);
        }

        return $value;
    }

    /**
     * 配列を区切り文字列に変換する.
     *
     * @param Array $array 配列
     * @param String $sep 区切り文字(初期値：|)
     *
     * @return String 文字列
     */
    function array2string($array, $sep = '|') {
        if (!is_array($array) && $array == '') return '';
        $ret = '';

        foreach ($array as $value) {
            $ret .= $value . $sep;
        }
        if ($ret != '') $ret = substr($ret, 0, -1 * strlen($sep));

        return $ret;
    }

    /**
     * 配列を改行区切り文字列に変換する.
     *
     * @param String $array 配列
     *
     * @return String 改行区切り文字列
     */
    function array2brstring($array) {
        $ret = '';

        foreach ($array as $key => $value) {
            $key .= '';
            $value .= '';
            if ($key !== $value) $ret .= $key . '|';
            $ret .= $value;
            $ret .= '<br />';
        }

        if ($ret !== '') $ret = substr($ret, 0, -6);

        return $ret;
    }

    /**
     * 区切り文字列を配列に変換する.
     *
     * @param String $string 文字列
     * @param String $sep 区切り文字(初期値：|)
     *
     * @return Array 配列
     */
    function string2array($string, $sep = '|') {
        if ($string != '') return explode($sep, $string);
        else return array();
    }

    /**
     * 改行区切り文字列を配列に変換する.
     *
     * @param String $string 文字列
     * @param String $sep 区切り文字(初期値：|)
     *
     * @return Array 配列
     */
    function nl2array($string, $sep = '|') {
        if ($string === '') return array();

        $myts =& MyTextSanitizer::getInstance();

        if (function_exists('mb_ereg_replace')) {
            $string = mb_ereg_replace("\r\n", "\n", $string);
            $string = mb_ereg_replace("\r", "\n", $string);
        } else {
            $string = ereg_replace("\r\n", "\n", $string);
            $string = ereg_replace("\r", "\n", $string);
        }
        $strings = explode("\n", $string);

        $ret = array();
        foreach ($strings as $value) {
            if (strpos($value, $sep)) {
                list($key, $value) = explode($sep, $value);
                $ret[$myts->htmlSpecialChars($key)] = $myts->htmlSpecialChars($value);
            } else {
                $value = $myts->htmlSpecialChars($value);
                $ret[$value] = $value;
            }
        }
        return $ret;
    }

    /**
     * すべての項目の情報を返す.
     *
     * @return Array 項目情報の配列
     */
    function getItemDefs($dirname) {
        $xoopsDB =& Database::getInstance();
        $myts =& MyTextSanitizer::getInstance();

        $ret = array();
        $sql = "SELECT * FROM " . $xoopsDB->prefix($dirname . '_xgdb_item') . " ORDER BY `sequence` ASC, `iid` ASC";
        $res = $xoopsDB->query($sql);
        while ($row = $xoopsDB->fetchArray($res)) {
            $item = array();
            $item['caption'] = $myts->htmlSpecialChars($row['caption']);
            $item['type'] = $myts->htmlSpecialChars($row['type']);
            $item['required'] = $row['required'];
            $item['sequence'] = $row['sequence'];
            $item['search'] = $row['search'];
            $item['list'] = $row['list'];
            $item['add'] = $row['add'];
            $item['update'] = $row['update'];
            $item['detail'] = $row['detail'];
            $item['site_search'] = $row['site_search'];
            $item['duplicate'] = $row['duplicate'];
            $item['search_desc'] = $myts->displayTarea($row['search_desc']);
            $item['show_desc'] = $myts->displayTarea($row['show_desc']);
            $item['input_desc'] = $myts->displayTarea($row['input_desc']);
            if ($row['type'] == 'text') {
                $item['list_link'] = $row['list_link'];
                $item['value_type'] = $myts->htmlSpecialChars($row['value_type']);
                if (($row['value_type'] == 'int' || $row['value_type'] == 'float') && $row['value_range_min'] !== '') {
                    $item['value_range_min'] = $row['value_range_min'];
                }
                if (($row['value_type'] == 'int' || $row['value_type'] == 'float') && $row['value_range_max'] !== '') {
                    $item['value_range_max'] = $row['value_range_max'];
                }
                $item['default'] = $myts->htmlSpecialChars($row['default']);
                $item['size'] = $row['size'];
                $item['max_length'] = $row['max_length'];
                $item['ambiguous'] = $row['ambiguous'];
            } elseif ($row['type'] == 'cbox') {
                $item['value_type'] = $myts->htmlSpecialChars($row['value_type']);
                $item['default'] = nl2array($row['default']);
                $item['options'] = nl2array($row['options']);
                $item['option_br'] = $row['option_br'];
            } elseif ($row['type'] == 'radio') {
                $item['list_link'] = $row['list_link'];
                $item['value_type'] = $myts->htmlSpecialChars($row['value_type']);
                $item['default'] = $myts->htmlSpecialChars($row['default']);
                $item['options'] = nl2array($row['options']);
                $item['option_br'] = $row['option_br'];
            } elseif ($row['type'] == 'select') {
                $item['list_link'] = $row['list_link'];
                $item['value_type'] = $myts->htmlSpecialChars($row['value_type']);
                $item['default'] = $myts->htmlSpecialChars($row['default']);
                $item['options'] = nl2array($row['options']);
            } elseif ($row['type'] == 'mselect') {
                $item['value_type'] = $myts->htmlSpecialChars($row['value_type']);
                $item['default'] = nl2array($row['default']);
                $item['size'] = $row['size'];
                $item['options'] = nl2array($row['options']);
            } elseif ($row['type'] == 'tarea' || $row['type'] == 'xtarea') {
                $item['default'] = $row['html'] ? $row['default'] : $myts->htmlSpecialChars($row['default']);
                $item['size'] = $row['size'];
                $item['max_length'] = $row['max_length'];
                $item['rows'] = $row['rows'];
                $item['cols'] = $row['cols'];
                $item['html'] = $row['html'];
                $item['smily'] = $row['smily'];
                $item['xcode'] = $row['xcode'];
                $item['image'] = $row['image'];
                $item['br'] = $row['br'];
            } elseif ($row['type'] == 'file' || $row['type'] == 'image') {
                $item['default'] = '';
                $item['size'] = $row['size'];
                $item['max_length'] = $row['max_length'];
                $item['max_file_size'] = $row['max_file_size'];
                if ($row['type'] == 'image') $item['max_image_size'] = $row['max_image_size'];
                $item['allowed_exts'] = nl2array($row['allowed_exts']);
                $item['allowed_mimes'] = nl2array($row['allowed_mimes']);
            }

            $ret[$myts->htmlSpecialChars($row['name'])] = $item;
        }

        return $ret;
    }

    /**
     * 項目情報の内、指定したtypeに一致する項目情報を返す.
     *
     * @param Array $defs 項目情報の配列
     * @param String $type 取得するtypeの種類
     *
     * @return Array 項目情報の配列
     */
    function getDefs($defs, $type) {
        $ret = array();

        foreach ($defs as $index => $def) {
            if (isset($def[$type]) && $def[$type]) {
                $ret[$index] = $def;
            }
        }

        return $ret;
    }

    /**
     * 一覧リンクの項目名を返す.
     *
     * @param Array $defs 項目情報の配列
     *
     * @return String 一覧リンクの項目名
     */
    function getListLinkItemDef($defs) {
        foreach ($defs as $item_name => $def) {
            if (isset($def['list_link']) && $def['list_link']) {
                $def['item_name'] = $item_name;
                return $def;
            }
        }
    }

    /**
     * 項目情報の内容に従って、引数の値をサニタイズして返す.
     *
     * @param String $value サニタイズ対象の値
     * @param Array  $item_def 項目情報
     * @param Boolean $number_format 数値書式フォーマット
     *
     * @return String サニタイズした引数$value
     */
    function sanitize($value, $item_def, $number_format = true) {
        $myts =& MyTextSanitizer::getInstance();

        if ($item_def['type'] == 'tarea' || $item_def['type'] == 'xtarea') {
            if (!$item_def['html']) {
                $value = $myts->htmlSpecialChars($value);
            }
        } elseif ($item_def['type'] == 'file' || $item_def['type'] == 'image') {
            $value = $myts->htmlSpecialChars($value);
        } else {
            if ($item_def['value_type'] == 'int') {
                if ($value != '') {
                    $value = intval($value);
                    if ($number_format) $value = number_format($value);
                }
            } elseif ($item_def['value_type'] == 'float') {
                if ($value !== NULL && $value !== '') {
                    $value = floatval($value);
                    if (strpos($value, '.') === false) $value .= '.0';
                    if ($number_format) {
                        $value = number_format($value, strlen($value) - intval(strpos($value, '.')) - 1);
                    } else {
                        $value = number_format($value, strlen($value) - intval(strpos($value, '.')) - 1, '.', '');
                    }
                }
            } else {
                $value = $myts->htmlSpecialChars($value);
            }
        }

        return $value;
    }

    /**
     * モジュールのテンプレートファイルを更新する.
     *
     * @param String  $tpl_set      テンプレートセット名
     * @param String  $tpl_file     テンプレートファイル名
     * @param String  $tpl_source   テンプレートファイルのソースコードの内容
     * @param Integer $lastmodified 最終更新日時のタイムスタンプ
     */
    function updateTemplate($tpl_set, $tpl_file, $tpl_source, $lastmodified = 0) {
        include_once XOOPS_ROOT_PATH . '/class/template.php';
        $xoopsDB =& Database::getInstance();
        $tplfile_tbl = $xoopsDB->prefix("tplfile");
        $tplsource_tbl = $xoopsDB->prefix("tplsource");

        $sql = "SELECT * FROM $tplfile_tbl WHERE tpl_tplset = 'default' AND tpl_file = '" . addslashes($tpl_file) . "'";
        $res = $xoopsDB->query($sql);
        if ($xoopsDB->getRowsNum($res) == 0) return;

        $tpl_id_sql = "SELECT tpl_id FROM $tplfile_tbl WHERE tpl_tplset = '" . addslashes($tpl_set) . "' AND tpl_file = '" . addslashes($tpl_file) . "'";
        $tpl_id_res = $xoopsDB->query($tpl_id_sql);

        if ($tpl_set != 'default' && $xoopsDB->getRowsNum($tpl_id_res) == 0) {
            while ($row = $xoopsDB->fetchArray($res)) {
                $xoopsDB->queryF("INSERT INTO $tplfile_tbl SET tpl_refid = '" . addslashes($row['tpl_refid']) . "',tpl_module = '" . addslashes($row['tpl_module']) . "',tpl_tplset = '" . addslashes($tpl_set) . "',tpl_file = '" . addslashes($tpl_file) . "',tpl_desc = '" . addslashes($row['tpl_desc']) . "',tpl_type = '" . addslashes($row['tpl_type']) . "'");
                $tpl_id = $xoopsDB->getInsertId();
                $xoopsDB->queryF("INSERT INTO $tplsource_tbl SET tpl_id = '$tpl_id', tpl_source = ''");
            }
        }

        while (list($tpl_id) = $xoopsDB->fetchRow($tpl_id_res)) {
            $xoopsDB->queryF("UPDATE $tplfile_tbl SET tpl_lastmodified = '" . addslashes($lastmodified) . "',tpl_lastimported=UNIX_TIMESTAMP() WHERE tpl_id = '$tpl_id'");
            $xoopsDB->queryF("UPDATE $tplsource_tbl SET tpl_source = '" . addslashes($tpl_source) . "' WHERE tpl_id = '$tpl_id'");
            xoops_template_touch($tpl_id);
        }
    }

    /**
     * 最小値と最大値の範囲をあらわす文字列表現を返す.
     *
     * @param String  $dirname モジュールディレクトリ名
     * @param String  $value_range_min 最小値
     * @param String  $value_range_max 最大値
     *
     * @return String 最小値と最大値の範囲
     */
    function getRangeText($dirname, $value_range_min, $value_range_max) {
        $affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);
        $ret = '';
        if (isset($value_range_min)) {
            $ret .= $value_range_min . constant('_' . $affix . '_MORE_THAN');
        }
        if (isset($value_range_max)) {
            if ($ret !== '') {
                $ret .= constant('_' . $affix . '_COMMA');
            }
            $ret .= $value_range_max . constant('_' . $affix . '_LESS_THAN');
        }

        return $ret;
    }

    /**
     * 値が整数値かどうか判定する.
     *
     * @param String  $value 値
     *
     * @return Boolean 整数値の場合true、それ以外の場合false
     */
    function is_intval($value) {
        if (!isset($value) || $value === '') {
            return false;
        } elseif (!is_numeric($value)) {
            return false;
        } elseif (strpos($value, '.') !== false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 値が小数値かどうか判定する.
     *
     * @param String  $value 値
     *
     * @return Boolean 小数値の場合true、それ以外の場合false
     */
    function is_floatval($value) {
        if (!isset($value) || $value === '') {
            return false;
        } elseif (!is_numeric($value)) {
            return false;
        } elseif (strpos($value, '.') === false) {
            return false;
        } elseif (!is_numeric(substr($value, -1))) {
            return false;
        } elseif (strpos($value, '.') === 0) {
            return false;
        } elseif (!is_numeric(substr($value, strpos($value, '.') - 1, 1))) {
            return false;
        } else {
            return true;
        }
    }
}

?>