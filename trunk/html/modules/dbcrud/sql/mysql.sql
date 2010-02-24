CREATE TABLE xgdb_data (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    add_uid INT UNSIGNED NOT NULL,
    add_date DATETIME NOT NULL,
    update_uid INT UNSIGNED NOT NULL,
    update_date DATETIME NOT NULL,
    xgdb_text VARCHAR(255),
    xgdb_cbox VARCHAR(255),
    xgdb_radio VARCHAR(255),
    xgdb_file VARCHAR(255),
    xgdb_image VARCHAR(255),
    xgdb_tarea TEXT,
    xgdb_xtarea VARCHAR(255),
    xgdb_select VARCHAR(255),
    xgdb_mselect VARCHAR(255),
    PRIMARY KEY(id)
) TYPE=MyISAM;

CREATE TABLE xgdb_item (
    `iid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `caption` VARCHAR(255) NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `required` TINYINT(1) UNSIGNED NOT NULL,
    `sequence` INT UNSIGNED NOT NULL,
    `search` TINYINT(1) UNSIGNED NOT NULL,
    `list` TINYINT(1) UNSIGNED NOT NULL,
    `add` TINYINT(1) UNSIGNED NOT NULL,
    `update` TINYINT(1) UNSIGNED NOT NULL,
    `detail` TINYINT(1) UNSIGNED NOT NULL,
    `site_search` TINYINT(1) UNSIGNED NOT NULL,
    `duplicate` TINYINT(1) UNSIGNED NOT NULL,
    `search_desc` TEXT,
    `show_desc` TEXT,
    `input_desc` TEXT,
    `list_link` TINYINT(1) UNSIGNED,
    `value_type` VARCHAR(255),
    `value_range_min` INT,
    `value_range_max` INT,
    `default` TEXT,
    `size` INT UNSIGNED,
    `max_length` INT UNSIGNED,
    `ambiguous` TINYINT(1) UNSIGNED,
    `options` TEXT,
    `option_br` TINYINT(1) UNSIGNED,
    `rows` INT UNSIGNED,
    `cols` INT UNSIGNED,
    `html` TINYINT(1) UNSIGNED,
    `smily` TINYINT(1) UNSIGNED,
    `xcode` TINYINT(1) UNSIGNED,
    `image` TINYINT(1) UNSIGNED,
    `br` TINYINT(1) UNSIGNED,
    `max_file_size` INT UNSIGNED,
    `max_image_size` INT UNSIGNED,
    `allowed_exts` TEXT,
    `allowed_mimes` TEXT,
    PRIMARY KEY(iid)
) TYPE=MyISAM;
#                                                                                                                                                                                                                                                                                                                                                                                                                                                                       name,           caption,               type,      required, sequence, search, list, add, update, detail, site_search, duplicate, search_desc, show_desc, input_desc, list_link, value_type, value_range_min, value_range_max, default, size, max_length, ambiguous, options,                                                                                       option_br, rows, cols, html, smily, xcode, image, br,   max_file_size, max_image_size, allowed_exts,          allowed_mimes
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_text',    'Text Box A',          'text',    1,        10,       1,      1,    1,   1,      1,      1,           1,         '',          '',        '',         1,         'string',   NULL,            NULL,            '',      32,   255,        1,         NULL,                                                                                          NULL,      NULL, NULL, NULL, NULL,  NULL,  NULL,  NULL, NULL,          NULL,           NULL,                  NULL);
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_cbox',    'Check Box A',         'cbox',    0,        20,       1,      1,    1,   1,      1,      1,           0,         '',          '',        '',         NULL,      'string',   NULL,            NULL,            '',      NULL, NULL,       NULL,      "Check Box 1|Check Box 1\nCheck Box 2|Check Box 2\nCheck Box 3|Check Box 3",                   1,         NULL, NULL, NULL, NULL,  NULL,  NULL,  NULL, NULL,          NULL,           NULL,                  NULL);
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_radio',   'Radio Button A',      'radio',   1,        30,       1,      1,    1,   1,      1,      1,           0,         '',          '',        '',         0,         'string',   NULL,            NULL,            '',      NULL, NULL,       NULL,      "Radio Button 1|Radio Button 1\nRadio Button 2|Radio Button 2\nRadio Button 3|Radio Button 3", 0,         NULL, NULL, NULL, NULL,  NULL,  NULL,  NULL, NULL,          NULL,           NULL,                  NULL);
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_select',  'Pulldown Menu A',     'select',  0,        40,       1,      1,    1,   1,      1,      1,           0,         '',          '',        '',         0,         'string',   NULL,            NULL,            '',      NULL, NULL,       NULL,      "Menu 1|Menu 1\nMenu 2|Menu 2\nMenu 3|Menu 3",                                                 NULL,      NULL, NULL, NULL, NULL,  NULL,  NULL,  NULL, NULL,          NULL,           NULL,                  NULL);
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_mselect', 'List Box A',          'mselect', 1,        50,       1,      1,    1,   1,      1,      1,           0,         '',          '',        '',         NULL,      'string',   NULL,            NULL,            '',      3,    NULL,       NULL,      "List Box 1|List Box 1\nList Box 2|List Box 2\nList Box 3|List Box 3",                         NULL,      NULL, NULL, NULL, NULL,  NULL,  NULL,  NULL, NULL,          NULL,           NULL,                  NULL);
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_tarea',   'Text Area A',         'tarea',   0,        60,       1,      1,    1,   1,      1,      1,           0,         '',          '',        '',         NULL,      NULL,       NULL,            NULL,            '',      32,   255,        NULL,      NULL,                                                                                          NULL,      5,    32,   0,    0,     0,     0,     1,    NULL,          NULL,           NULL,                  NULL);
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_xtarea',  'BB Code Text Area A', 'xtarea',  1,        70,       1,      1,    1,   1,      1,      1,           0,         '',          '',        '',         NULL,      NULL,       NULL,            NULL,            '',      32,   255,        NULL,      NULL,                                                                                          NULL,      5,    32,   0,    1,     1,     1,     1,    NULL,          NULL,           NULL,                  NULL);
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_file',    'File A',              'file',    0,        80,       1,      1,    1,   1,      1,      1,           0,         '',          '',        '',         NULL,      NULL,       NULL,            NULL,            NULL,    32,   255,        NULL,      NULL,                                                                                          NULL,      NULL, NULL, NULL, NULL,  NULL,  NULL,  NULL, 100,           NULL,           "pdf",                 "application/pdf\napplication/x-pdf");
INSERT INTO xgdb_item (`name`, `caption`, `type`, `required`, `sequence`, `search`, `list`, `add`, `update`, `detail`, `site_search`, `duplicate`, `search_desc`, `show_desc`, `input_desc`, `list_link`, `value_type`, `value_range_min`, `value_range_max`, `default`, `size`, `max_length`, `ambiguous`, `options`, `option_br`, `rows`, `cols`, `html`, `smily`, `xcode`, `image`, `br`, `max_file_size`, `max_image_size`, `allowed_exts`, `allowed_mimes`) VALUES('xgdb_image',   'Image A',             'image',   1,        90,       1,      1,    1,   1,      1,      1,           0,         '',          '',        '',         NULL,      NULL,       NULL,            NULL,            NULL,    32,   255,        NULL,      NULL,                                                                                          NULL,      NULL, NULL, NULL, NULL,  NULL,  NULL,  NULL, 100,           600,            "jpg\njpeg\ngif\npng", "image/jpeg\nimage/gif\nimage/png\nimage/x-png\nimage/pjpeg");

