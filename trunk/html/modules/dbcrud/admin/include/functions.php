<?php

require_once XOOPS_ROOT_PATH . '/modules/' . $dirname . '/include/functions.php';

/**
 * 管理画面で使用する項目情報の内、指定したtypeに一致する項目情報を返す.
 *
 * @param String $type 取得するtypeの種類
 *
 * @return Array 項目情報の配列
 */
function getAdminItemDefs($type) {
    $dirname = basename(dirname(dirname(dirname(__FILE__))));
    $affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_NAME');
    $item_def['type'] = 'text';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'string';
    $item_def['size'] = 32;
    $item_def['max_length'] = 255;
    $item_defs['name'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_CAPTION');
    $item_def['type'] = 'text';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'string';
    $item_def['size'] = 32;
    $item_def['max_length'] = 255;
    $item_defs['caption'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_TYPE');
    $item_def['type'] = 'select';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'string';
    $item_def['options'] = constant('_' . $affix . '_NOT_SELECTED') . "|\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_TEXT') . "|text\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_CBOX') . "|cbox\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_RADIO') . "|radio\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_SELECT') . "|select\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_MSELECT') . "|mselect\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_TAREA') . "|tarea\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_XTAREA') . "|xtarea\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_FILE') . "|file\n";
    $item_def['options'] .= constant('_AM_' . $affix . '_TYPE_IMAGE') . "|image\n";
    $item_def['options'] = nl2array($item_def['options']);
    $item_defs['type'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_REQUIRED');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_YES') . "|1\n" . constant('_AM_' . $affix . '_NO') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['required'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_SHOW_GIDS');
    $item_def['type'] = 'mselect';
    $item_def['required'] = 0;
    $item_def['value_type'] = 'int';
    $item_def['input_desc'] = constant('_AM_' . $affix . '_SHOW_GIDS_DESC');
    $item_def['options'] = nl2array(makeGroupSelectOptions());
    $item_defs['show_gids'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_SEQUENCE');
    $item_def['type'] = 'text';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['value_range_min'] = 0;
    $item_def['value_range_max'] = 9999;
    $item_def['size'] = 4;
    $item_def['max_length'] = 4;
    $item_defs['sequence'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_SEARCH') . constant('_AM_' . $affix . '_PAGE');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_DISP') . "|1\n" . constant('_AM_' . $affix . '_NOT_DISP') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['search'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_LIST') . constant('_AM_' . $affix . '_PAGE');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_DISP') . "|1\n" . constant('_AM_' . $affix . '_NOT_DISP') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['list'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_ADD') . constant('_AM_' . $affix . '_PAGE');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_DISP') . "|1\n" . constant('_AM_' . $affix . '_NOT_DISP') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['add'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_UPDATE') . constant('_AM_' . $affix . '_PAGE');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_DISP') . "|1\n" . constant('_AM_' . $affix . '_NOT_DISP') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['update'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_DETAIL') . '/' . constant('_AM_' . $affix . '_DELETE') . constant('_AM_' . $affix . '_PAGE');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_DISP') . "|1\n" . constant('_AM_' . $affix . '_NOT_DISP') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['detail'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_SITE_SEARCH');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_YES') . "|1\n" . constant('_AM_' . $affix . '_NO') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['site_search'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_DUPLICATE_CHECK');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_YES') . "|1\n" . constant('_AM_' . $affix . '_NO') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['duplicate'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_SEARCH_DESC');
    $item_def['type'] = 'xtarea';
    $item_def['required'] = 0;
    $item_def['rows'] = 5;
    $item_def['cols'] = 50;
    $item_def['html'] = 0;
    $item_def['smily'] = 1;
    $item_def['xcode'] = 1;
    $item_def['image'] = 1;
    $item_def['br'] = 1;
    $item_defs['search_desc'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_SHOW_DESC');
    $item_def['type'] = 'xtarea';
    $item_def['required'] = 0;
    $item_def['rows'] = 5;
    $item_def['cols'] = 50;
    $item_def['html'] = 0;
    $item_def['smily'] = 1;
    $item_def['xcode'] = 1;
    $item_def['image'] = 1;
    $item_def['br'] = 1;
    $item_defs['show_desc'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_INPUT_DESC');
    $item_def['type'] = 'xtarea';
    $item_def['required'] = 0;
    $item_def['rows'] = 5;
    $item_def['cols'] = 50;
    $item_def['html'] = 0;
    $item_def['smily'] = 1;
    $item_def['xcode'] = 1;
    $item_def['image'] = 1;
    $item_def['br'] = 1;
    $item_defs['input_desc'] = $item_def;

    $item_def = array();
    $item_def['caption'] = constant('_AM_' . $affix . '_DISP_COND');
    $item_def['type'] = 'radio';
    $item_def['required'] = 1;
    $item_def['value_type'] = 'int';
    $item_def['options'] = nl2array(constant('_AM_' . $affix . '_DISP') . "|1\n" . constant('_AM_' . $affix . '_NOT_DISP') . "|0");
    $item_def['option_br'] = 0;
    $item_defs['disp_cond'] = $item_def;

    if ($type == 'text') {
        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_SEARCH_COND');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['input_desc'] = constant('_AM_' . $affix . '_SEARCH_COND_DESC');
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_COMP_MATCH') . "|1\n" . constant('_AM_' . $affix . '_PART_MATCH') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['search_cond'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_LIST_LINK');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_YES') . "|1\n" . constant('_AM_' . $affix . '_NO') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['list_link'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_VALUE_TYPE');
        $item_def['type'] = 'select';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'string';
        $item_def['options'] = constant('_' . $affix . '_NOT_SELECTED') . "|\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_STRING') . "|string\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_INTEGER') . "|int\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_FLOAT') . "|float";
        $item_def['options'] = nl2array($item_def['options']);
        $item_defs['value_type'] = $item_def;

        $item_def['caption'] = constant('_AM_' . $affix . '_VALUE_RANGE_MIN');
        $item_def['type'] = 'text';
        $item_def['required'] = 0;
        $item_def['input_desc'] = constant('_AM_' . $affix . '_VALUE_RANGE_DESC');
        $item_def['value_type'] = 'int';
        $item_def['size'] = 9;
        $item_def['max_length'] = 9;
        $item_defs['value_range_min'] = $item_def;

        $item_def['caption'] = constant('_AM_' . $affix . '_VALUE_RANGE_MAX');
        $item_def['type'] = 'text';
        $item_def['required'] = 0;
        $item_def['input_desc'] = constant('_AM_' . $affix . '_VALUE_RANGE_DESC');
        $item_def['value_type'] = 'int';
        $item_def['size'] = 9;
        $item_def['max_length'] = 9;
        $item_defs['value_range_max'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_DEFAULT');
        $item_def['type'] = 'text';
        $item_def['required'] = 0;
        $item_def['value_type'] = 'string';
        $item_def['size'] = 32;
        $item_def['max_length'] = 255;
        $item_defs['default'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_SIZE');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['size'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_MAX_LENGTH');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['max_length'] = $item_def;
    } elseif ($type == 'cbox' || $type == 'radio') {
        if ($type == 'cbox') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_SEARCH_COND');
            $item_def['type'] = 'radio';
            $item_def['required'] = 1;
            $item_def['value_type'] = 'int';
            $item_def['input_desc'] = '';
            $item_def['options'] = nl2array(constant('_AM_' . $affix . '_AND_MATCH') . "|1\n" . constant('_AM_' . $affix . '_OR_MATCH') . "|0");
            $item_def['option_br'] = 0;
            $item_defs['search_cond'] = $item_def;
        }

        if ($type == 'radio') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_LIST_LINK');
            $item_def['type'] = 'radio';
            $item_def['required'] = 1;
            $item_def['value_type'] = 'int';
            $item_def['options'] = nl2array(constant('_AM_' . $affix . '_YES') . "|1\n" . constant('_AM_' . $affix . '_NO') . "|0");
            $item_def['option_br'] = 0;
            $item_defs['list_link'] = $item_def;
        }

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_VALUE_TYPE');
        $item_def['type'] = 'select';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'string';
        $item_def['options'] = constant('_' . $affix . '_NOT_SELECTED') . "|\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_STRING') . "|string\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_INTEGER') . "|int\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_FLOAT') . "|float";
        $item_def['options'] = nl2array($item_def['options']);
        $item_defs['value_type'] = $item_def;

        if ($type == 'cbox') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_DEFAULT');
            $item_def['type'] = 'tarea';
            $item_def['required'] = 0;
            $item_def['input_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP');
            $item_def['show_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP');
            $item_def['rows'] = 5;
            $item_def['cols'] = 50;
            $item_def['html'] = 0;
            $item_def['smily'] = 0;
            $item_def['xcode'] = 0;
            $item_def['image'] = 0;
            $item_def['br'] = 1;
            $item_defs['default'] = $item_def;
        } elseif ($type == 'radio') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_DEFAULT');
            $item_def['type'] = 'text';
            $item_def['required'] = 0;
            $item_def['value_type'] = 'string';
            $item_def['size'] = 32;
            $item_def['max_length'] = 255;
            $item_defs['default'] = $item_def;
        }

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_OPTIONS');
        $item_def['type'] = 'tarea';
        $item_def['required'] = 1;
        $item_def['input_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP') . constant('_AM_' . $affix . '_NOTE_SHOW_VALUE_SEP');
        $item_def['show_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP') . constant('_AM_' . $affix . '_NOTE_SHOW_VALUE_SEP');
        $item_def['rows'] = 5;
        $item_def['cols'] = 50;
        $item_def['html'] = 0;
        $item_def['smily'] = 0;
        $item_def['xcode'] = 0;
        $item_def['image'] = 0;
        $item_def['br'] = 1;
        $item_defs['options'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_OPTION_BR');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_ENABLE') . "|1\n" . constant('_AM_' . $affix . '_DISABLE') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['option_br'] = $item_def;
    } elseif ($type == 'select' || $type == 'mselect') {
        if ($type == 'mselect') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_SEARCH_COND');
            $item_def['type'] = 'radio';
            $item_def['required'] = 1;
            $item_def['value_type'] = 'int';
            $item_def['input_desc'] = '';
            $item_def['options'] = nl2array(constant('_AM_' . $affix . '_AND_MATCH') . "|1\n" . constant('_AM_' . $affix . '_OR_MATCH') . "|0");
            $item_def['option_br'] = 0;
            $item_defs['search_cond'] = $item_def;
        }

        if ($type == 'select') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_LIST_LINK');
            $item_def['type'] = 'radio';
            $item_def['required'] = 1;
            $item_def['value_type'] = 'int';
            $item_def['options'] = nl2array(constant('_AM_' . $affix . '_YES') . "|1\n" . constant('_AM_' . $affix . '_NO') . "|0");
            $item_def['option_br'] = 0;
            $item_defs['list_link'] = $item_def;
        }

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_VALUE_TYPE');
        $item_def['type'] = 'select';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'string';
        $item_def['options'] = constant('_' . $affix . '_NOT_SELECTED') . "|\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_STRING') . "|string\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_INTEGER') . "|int\n";
        $item_def['options'] .= constant('_AM_' . $affix . '_FLOAT') . "|float";
        $item_def['options'] = nl2array($item_def['options']);
        $item_defs['value_type'] = $item_def;

        if ($type == 'select') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_DEFAULT');
            $item_def['type'] = 'text';
            $item_def['required'] = 0;
            $item_def['value_type'] = 'string';
            $item_def['size'] = 32;
            $item_def['max_length'] = 255;
            $item_defs['default'] = $item_def;
        } elseif ($type == 'mselect') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_DEFAULT');
            $item_def['type'] = 'tarea';
            $item_def['required'] = 0;
            $item_def['input_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP');
            $item_def['show_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP');
            $item_def['rows'] = 5;
            $item_def['cols'] = 50;
            $item_def['html'] = 0;
            $item_def['smily'] = 0;
            $item_def['xcode'] = 0;
            $item_def['image'] = 0;
            $item_def['br'] = 1;
            $item_defs['default'] = $item_def;

            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_SIZE');
            $item_def['type'] = 'text';
            $item_def['required'] = 1;
            $item_def['value_type'] = 'int';
            $item_def['value_range_min'] = 1;
            $item_def['value_range_max'] = 9999;
            $item_def['size'] = 4;
            $item_def['max_length'] = 4;
            $item_defs['size'] = $item_def;
        }

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_OPTIONS');
        $item_def['type'] = 'tarea';
        $item_def['required'] = 1;
        $item_def['input_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP') . constant('_AM_' . $affix . '_NOTE_SHOW_VALUE_SEP');
        $item_def['show_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP') . constant('_AM_' . $affix . '_NOTE_SHOW_VALUE_SEP');
        $item_def['rows'] = 5;
        $item_def['cols'] = 50;
        $item_def['html'] = 0;
        $item_def['smily'] = 0;
        $item_def['xcode'] = 0;
        $item_def['image'] = 0;
        $item_def['br'] = 1;
        $item_defs['options'] = $item_def;
    } elseif ($type == 'tarea' || $type == 'xtarea') {
        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_DEFAULT');
        $item_def['type'] = $type;
        $item_def['required'] = 0;
        $item_def['rows'] = 5;
        $item_def['cols'] = 50;
        $item_def['html'] = 0;
        $item_def['smily'] = 0;
        $item_def['xcode'] = 0;
        $item_def['image'] = 0;
        $item_def['br'] = 1;
        $item_defs['default'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_SIZE');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['size'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_MAX_LENGTH');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['max_length'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_ROWS');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['rows'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_COLS');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['cols'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_HTML');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['input_desc'] = constant('_AM_' . $affix . '_HTML_WARN');
        $item_def['show_desc'] = constant('_AM_' . $affix . '_HTML_WARN');
        $item_def['value_type'] = 'int';
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_ENABLE') . "|1\n" . constant('_AM_' . $affix . '_DISABLE') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['html'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_SMILY');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_ENABLE') . "|1\n" . constant('_AM_' . $affix . '_DISABLE') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['smily'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_XCODE');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_ENABLE') . "|1\n" . constant('_AM_' . $affix . '_DISABLE') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['xcode'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_IMAGE');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_ENABLE') . "|1\n" . constant('_AM_' . $affix . '_DISABLE') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['image'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_BR');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_ENABLE') . "|1\n" . constant('_AM_' . $affix . '_DISABLE') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['br'] = $item_def;
    } elseif ($type == 'file' || $type == 'image') {
        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_SEARCH_COND');
        $item_def['type'] = 'radio';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['input_desc'] = '';
        $item_def['options'] = nl2array(constant('_AM_' . $affix . '_COMP_MATCH') . "|1\n" . constant('_AM_' . $affix . '_PART_MATCH') . "|0");
        $item_def['option_br'] = 0;
        $item_defs['search_cond'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_SIZE');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['size'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_MAX_LENGTH');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['max_length'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_MAX_FILE_SIZE');
        $item_def['type'] = 'text';
        $item_def['required'] = 1;
        $item_def['value_type'] = 'int';
        $item_def['value_range_min'] = 1;
        $item_def['value_range_max'] = 9999;
        $item_def['size'] = 4;
        $item_def['max_length'] = 4;
        $item_defs['max_file_size'] = $item_def;

        if ($type == 'image') {
            $item_def = array();
            $item_def['caption'] = constant('_AM_' . $affix . '_MAX_IMAGE_SIZE');
            $item_def['type'] = 'text';
            $item_def['required'] = 1;
            $item_def['value_type'] = 'int';
            $item_def['value_range_min'] = 1;
            $item_def['value_range_max'] = 9999;
            $item_def['size'] = 4;
            $item_def['max_length'] = 4;
            $item_defs['max_image_size'] = $item_def;
        }

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_ALLOWED_EXTS');
        $item_def['type'] = 'tarea';
        $item_def['required'] = 1;
        if ($type == 'file') $item_def['input_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP') . constant('_AM_' . $affix . '_NOTE_ALLOWED_FILE_EXTS');
        else $item_def['input_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP') . constant('_AM_' . $affix . '_NOTE_ALLOWED_IMG_EXTS');
        $item_def['rows'] = 5;
        $item_def['cols'] = 50;
        $item_def['html'] = 0;
        $item_def['smily'] = 0;
        $item_def['xcode'] = 0;
        $item_def['image'] = 0;
        $item_def['br'] = 1;
        $item_defs['allowed_exts'] = $item_def;

        $item_def = array();
        $item_def['caption'] = constant('_AM_' . $affix . '_ALLOWED_MIMES');
        $item_def['type'] = 'tarea';
        $item_def['required'] = 1;
        if ($type == 'file') $item_def['input_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP') . constant('_AM_' . $affix . '_NOTE_ALLOWED_FILE_MIMES');
        else $item_def['input_desc'] = constant('_AM_' . $affix . '_NOTE_VALUE_SEP') . constant('_AM_' . $affix . '_NOTE_ALLOWED_IMG_MIMES');
        $item_def['rows'] = 5;
        $item_def['cols'] = 50;
        $item_def['html'] = 0;
        $item_def['smily'] = 0;
        $item_def['xcode'] = 0;
        $item_def['image'] = 0;
        $item_def['br'] = 1;
        $item_defs['allowed_mimes'] = $item_def;
    }

    return $item_defs;
}

/**
 * 引数の値が半角英数字(小文字)とアンダーバーだけで構成されているかチェックする.
 *
 * @param String $value チェック対象の値
 *
 * @return Boolean 半角英数字(小文字)とアンダーバーだけの場合true、それ以外の場合false
 */
function checkColumnName($value) {
    if ($value == '') return true;
    if (preg_match("/^[a-z0-9_]+$/", $value)) return true;
    return false;
}

?>
