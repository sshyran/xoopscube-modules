# CREATE TABLE `tablename` will be queried as
# CREATE TABLE `prefix_dirname_tablename`

CREATE TABLE category_permissions (
  cat_id smallint(5) unsigned NOT NULL default 0,
  uid mediumint(8) default NULL,
  groupid smallint(5) default NULL,
  permissions text,
  UNIQUE KEY (cat_id,uid),
  UNIQUE KEY (cat_id,groupid),
  KEY (cat_id),
  KEY (uid),
  KEY (groupid)
) TYPE=MyISAM;

INSERT INTO category_permissions (cat_id,uid,groupid,permissions) VALUES (0,NULL,1,'a:8:{s:8:"can_read";i:1;s:12:"can_readfull";i:1;s:8:"can_post";i:1;s:8:"can_edit";i:1;s:10:"can_delete";i:1;s:18:"post_auto_approved";i:1;s:12:"is_moderator";i:1;s:19:"can_makesubcategory";i:1;}');
INSERT INTO category_permissions (cat_id,uid,groupid,permissions) VALUES (0,NULL,2,'a:8:{s:8:"can_read";i:1;s:12:"can_readfull";i:1;s:8:"can_post";i:0;s:8:"can_edit";i:0;s:10:"can_delete";i:0;s:18:"post_auto_approved";i:0;s:12:"is_moderator";i:0;s:19:"can_makesubcategory";i:0;}');
INSERT INTO category_permissions (cat_id,uid,groupid,permissions) VALUES (0,NULL,3,'a:8:{s:8:"can_read";i:1;s:12:"can_readfull";i:1;s:8:"can_post";i:0;s:8:"can_edit";i:0;s:10:"can_delete";i:0;s:18:"post_auto_approved";i:0;s:12:"is_moderator";i:0;s:19:"can_makesubcategory";i:0;}');

CREATE TABLE categories (
  cat_id smallint(5) unsigned NOT NULL,
  cat_vpath varchar(255),
  pid smallint(5) unsigned NOT NULL default 0,
  cat_title varchar(255) NOT NULL default '',
  cat_desc mediumtext,
  cat_depth_in_tree smallint(5) NOT NULL default 0,
  cat_order_in_tree smallint(5) NOT NULL default 0,
  cat_path_in_tree text,
  cat_unique_path text,
  cat_weight smallint(5) NOT NULL default 0,
  cat_options text,
  cat_created_time int(10) NOT NULL default 0,
  cat_modified_time int(10) NOT NULL default 0,
  cat_vpath_mtime int(10) NOT NULL default 0,
  cat_redundants mediumtext,
  PRIMARY KEY (cat_id),
  UNIQUE KEY (cat_vpath),
  KEY (cat_weight),
  KEY (pid)
) TYPE=MyISAM;

INSERT INTO categories (cat_id,pid,cat_title) VALUES (0,0xffff,'TOP');

CREATE TABLE contents (
  content_id int(10) unsigned NOT NULL auto_increment,
  vpath varchar(255),
  cat_id smallint(5) unsigned NOT NULL default 0,
  weight smallint(5) NOT NULL default 0,
  created_time int(10) NOT NULL default 0,
  modified_time int(10) NOT NULL default 0,
  poster_uid mediumint(8) unsigned NOT NULL default 0,
  poster_ip varchar(15) NOT NULL default '',
  modifier_uid mediumint(8) unsigned NOT NULL default 0,
  modifier_ip varchar(15) NOT NULL default '',
  subject varchar(255) NOT NULL default '',
  subject_waiting varchar(255) NOT NULL default '',
  locked tinyint(1) NOT NULL default 0,
  visible tinyint(1) NOT NULL default 1,
  approval tinyint(1) NOT NULL default 1,
  use_cache tinyint(1) NOT NULL default 1,
  allow_comment tinyint(1) NOT NULL default 1,
  show_in_navi tinyint(1) NOT NULL default 1,
  show_in_menu tinyint(1) NOT NULL default 1,
  viewed int(10) unsigned NOT NULL default 0,
  votes_sum int(10) unsigned NOT NULL default 0,
  votes_count int(10) unsigned NOT NULL default 0,
  comments_count int(10) unsigned NOT NULL default 0,
  htmlheader mediumtext,
  htmlheader_waiting mediumtext,
  body mediumtext,
  body_waiting mediumtext,
  body_cached mediumtext,
  filters text,
  redundants text,
  PRIMARY KEY (content_id),
  UNIQUE KEY (vpath),
  KEY (poster_uid),
  KEY (subject),
  KEY (created_time),
  KEY (cat_id),
  KEY (visible),
  KEY (votes_sum),
  KEY (votes_count)
) TYPE=MyISAM;

CREATE TABLE content_votes (
  vote_id int(10) unsigned NOT NULL auto_increment,
  content_id int(10) unsigned NOT NULL default 0,
  uid mediumint(8) unsigned NOT NULL default 0,
  vote_point tinyint(3) NOT NULL default 0,
  vote_time int(10) NOT NULL default 0,
  vote_ip char(16) NOT NULL default '',
  PRIMARY KEY (vote_id),
  KEY (content_id),
  KEY (vote_ip)
) TYPE=MyISAM;

CREATE TABLE content_histories (
  content_history_id int(10) unsigned NOT NULL auto_increment,
  content_id int(10) unsigned NOT NULL default 0,
  vpath varchar(255),
  cat_id smallint(5) unsigned NOT NULL default 0,
  created_time int(10) NOT NULL default 0,
  modified_time int(10) NOT NULL default 0,
  poster_uid mediumint(8) unsigned NOT NULL default 0,
  poster_ip varchar(15) NOT NULL default '',
  modifier_uid mediumint(8) unsigned NOT NULL default 0,
  modifier_ip varchar(15) NOT NULL default '',
  subject varchar(255) NOT NULL default '',
  htmlheader mediumtext,
  body mediumtext,
  filters text,
  PRIMARY KEY (content_history_id),
  KEY (content_id),
  KEY (created_time),
  KEY (modified_time),
  KEY (modifier_uid)
) TYPE=MyISAM;

CREATE TABLE content_extras (
  content_extra_id int(10) unsigned NOT NULL auto_increment,
  content_id int(10) unsigned NOT NULL default 0,
  extra_type varchar(255) NOT NULL default '',
  created_time int(10) NOT NULL default 0,
  modified_time int(10) NOT NULL default 0,
  data mediumtext,
  PRIMARY KEY (content_extra_id),
  KEY (content_id),
  KEY (extra_type),
  KEY (created_time)
) TYPE=MyISAM;


INSERT INTO `contents` VALUES (1, NULL, 0, 0, 1218658602, 1218658602, 1, '127.0.0.1', 1, '127.0.0.1', 'myForm', '', 0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, '', '', '<form>\r\n\r\n<h3>My Form Basic Information</h3>\r\n\r\n<fieldset>	\r\n<label class="field-first">First Name *\r\n<input type="text" name="first_name" value="" class="required" />\r\n</label>\r\n<label class="field-last">Last Name *<input type="text" name="last_name" value="" class="required" /></label>\r\n<label class="field-address">Home Address\r\n<input type="text" name="address" value="" /></label>\r\n<label class="field-city">City\r\n<input type="text" name="city" value="" /></label>\r\n<label class="field-zip">Zip Code\r\n<input type="text" name="zip" value="" /></label><br style="clear: left;" />                     \r\n<label class="field-email">Email *<input type="text" name="youremail" value="" class="email required" /></label>\r\n<label class="field-phone">Phone<input type="text" name="phone" value="" /></label>\r\n</fieldset>\r\n\r\n<h3>Choose Your Illusion *</h3>\r\n\r\n<fieldset>\r\n<input id="radiobutton_1" type="radio" name="radiobutton_type" value="" />\r\n<label class="radioitem" for="radiobutton_1">D3 Modules set your imagination free</label>\r\n<input id="radiobutton_2" type="radio" name="radiobutton_type" value="" />\r\n<label class="radioitem" for="radiobutton_2">D3 Modules are intuitive and powerful	</label>\r\n<input id="radiobutton_3" type="radio" name="radiobutton_type" value="" />\r\n<label class="radioitem" for="radiobutton_3">D3 Modules allow one to do almost everything</label>\r\n</fieldset>\r\n\r\n<h3>Your Opinion Counts</h3>\r\n\r\n<fieldset>	\r\n<label class="field-describe">Tell us what is important to you :<br /><textarea name="message" cols="40" rows="5"></textarea></label>\r\n</fieldset>\r\n\r\n<h3>Your evaluation help to match your expectations</h3>\r\n\r\n<fieldset>\r\n<input id="checkbox_1" type="checkbox" name="d3modules" value="free" /><label for="checkbox_1" class="field-checkbox"><span class="radioitem">D3 Modules set your imagination free</span></label>\r\n<input id="checkbox_2" type="checkbox" name="d3modules" value="powerful" /><label for="checkbox_2" class="field-checkbox"><span class="radioitem">D3 Modules are intuitive and powerful </span></label>\r\n<input id="checkbox_3" type="checkbox" name="d3modules" value="all" /><label for="checkbox_3" class="field-checkbox"><span class="radioitem">D3 Modules allow one to do almost everything</span></label>\r\n</fieldset>\r\n\r\n<h3>Have Fun!</h3>\r\n\r\n<fieldset>\r\n<label>Click "Submit" below!</label>\r\n<input type="submit" name="submit" value="SUBMIT" />\r\n</fieldset>\r\n\r\n</form>', '', '\r\n\r\nMy Form Basic Information\r\n\r\n	\r\nFirst Name *\r\n\r\n\r\nLast Name *\r\nHome Address\r\n\r\nCity\r\n\r\nZip Code\r\n                     \r\nEmail *\r\nPhone\r\n\r\n\r\nChoose Your Illusion *\r\n\r\n\r\n\r\nD3 Modules set your imagination free\r\n\r\nD3 Modules are intuitive and powerful	\r\n\r\nD3 Modules allow one to do almost everything\r\n\r\n\r\nYour Opinion Counts\r\n\r\n	\r\nTell us what is important to you :\r\n\r\n\r\nYour evaluation help to match your expectations\r\n\r\n\r\nD3 Modules set your imagination free\r\nD3 Modules are intuitive and powerful \r\nD3 Modules allow one to do almost everything\r\n\r\n\r\nHave Fun!\r\n\r\n\r\nClick "Submit" below!\r\n\r\n\r\n\r\n', 'xoopstpl', NULL);

INSERT INTO `contents` VALUES (2, NULL, 0, 0, 1218658698, 1218660626, 1, '127.0.0.1', 1, '127.0.0.1', 'myPage1', '', 0, 1, 1, 0, 1, 1, 1, 0, 10, 1, 0, '<style type="text/css">\r\n<!--\r\n\r\n#myform {width: 340px; text-align: left;}\r\n\r\n#myform fieldset {margin: 0;border: 0;padding: 0;}\r\n\r\n#myform legend {display: none;}\r\n\r\n#myform h3 {clear: both;padding: 5px 0px 10px 0px; font-size:14px;}\r\n\r\n#myform label \r\n{display: block;\r\nwidth: 310px;\r\nfont-size: 12px;\r\nline-height: 14px;\r\npadding: 0px 0px 12px 0px;}\r\n\r\n#myform input {display: block;margin-top: 3px;}\r\n\r\n#myform select {float: left;display: block;}\r\n\r\n#myform label.field-first,\r\n#myform label.field-address,\r\n#myform label.field-city,\r\n#myform label.field-email \r\n{clear: left;}\r\n\r\n#myform label.field-first,\r\n#myform label.field-last,\r\n#myform label.field-city,\r\n#myform label.field-email,\r\n#myform label.field-phone \r\n{float: left;margin: 0px 10px 0px 0px;width: 150px;}\r\n\r\n#myform label.field-first input,\r\n#myform label.field-last input,\r\n#myform label.field-email input,\r\n#myform label.field-city input,\r\n#myform label.field-phone input \r\n{float: left;width: 150px;padding: 0px;}\r\n\r\n#myform label.field-zip \r\n{float: left;width: 80px;}\r\n\r\n#myform label.field-zip input \r\n{float: left;width: 80px;}\r\n\r\n#myform label.field-address \r\n{float: left;width: 310px;margin: 0px;}\r\n\r\n#myform label.field-address input \r\n{float: left;width: 310px;padding: 0px;}\r\n\r\n#myform input#radiobutton_1,\r\n#myform input#radiobutton_2,\r\n#myform input#radiobutton_3 \r\n{clear: left;float: left;padding: 0px;margin: 0px;}\r\n\r\n#myform label.radioitem \r\n{clear: none;margin: 0px 0px 0px 25px;padding: 0px 0px 15px 0px;}\r\n\r\n#myform textarea {display: block;margin-top: 3px;}\r\n\r\n#myform input#checkbox_1,\r\n#myform input#checkbox_2,\r\n#myform input#checkbox_3 \r\n{clear: both;float: left;padding: 0px;margin: 0px;}\r\n\r\n#myform label.field-checkbox \r\n{clear: none;margin: 0px 0px 0px 25px; padding: 0px 0px 15px 0px;}\r\n\r\n-->\r\n</style>', '', '<h1>My Page with My Form</h1>\r\n<p>This sample form will validate XHMTL 1.0 Strict, and it will render with reasonable consistency across the following Web browsers:</p>\r\n<ul>\r\n    <li>Safari 1.2 for Mac OS X</li>\r\n    <li>Safari 2.0 for Mac OS X</li>\r\n    <li>Safari 3.0 for Windows</li>\r\n    <li>OmniWeb 5.1.1 for Mac OS X</li>\r\n    <li>Internet Explorer 5.2 for Mac OS X</li>\r\n    <li>Camino 0.9a1 for Mac OS X</li>\r\n    <li>Firefox 1.0 for Mac OS X</li>\r\n    <li>Firefox 1.0.4 for Windows</li>\r\n    <li>Internet Explorer 5.5 for Windows</li>\r\n    <li>Internet Explorer 6.0 for Windows</li>\r\n    <li>Opera 7.54 for Windows</li>\r\n    <li>Opera 9.0 for Windows</li>\r\n</ul>\r\n<p>Forms are notoriously difficult to style, and to get a form even to this point takes some effort. <br />\r\nSo you are welcome to use this form in whole or in part to create one of your own.<br />\r\nKhoi Vinh shared a markup and CSS simple and flexible to be applied by almost everyone.<br />\r\nIf you choose to credit the original author , that would be terrific.</p>\r\n<p>If you can improve this markup and, or the CSS, using Gijoe Pico smarty please share your changes with<br />\r\nthe community. Feel free topost new versions of this form for others to benefit from. Thanks!</p>\r\n<div id="myform"><{capture}> <{pico id="1"}> <{/capture}> <{formmail4fleamarket mail_body_pre="A query for validation exist\\nContact webmaster as soon as possible\\n\\n" from_name="XHTML Validation" cc_field_name="youremail" cc_mail_subject="A confirmation for your query" cc_mail_body_pre="Thank you for querying us.\\nThis is the content you have queried\\n"}></div>', '', 'My Page with My Form\r\nThis sample form will validate XHMTL 1.0 Strict, and it will render with reasonable consistency across the following Web browsers:\r\n\r\n    Safari 1.2 for Mac OS X\r\n    Safari 2.0 for Mac OS X\r\n    Safari 3.0 for Windows\r\n    OmniWeb 5.1.1 for Mac OS X\r\n    Internet Explorer 5.2 for Mac OS X\r\n    Camino 0.9a1 for Mac OS X\r\n    Firefox 1.0 for Mac OS X\r\n    Firefox 1.0.4 for Windows\r\n    Internet Explorer 5.5 for Windows\r\n    Internet Explorer 6.0 for Windows\r\n    Opera 7.54 for Windows\r\n    Opera 9.0 for Windows\r\n\r\nForms are notoriously difficult to style, and to get a form even to this point takes some effort. \r\nSo you are welcome to use this form in whole or in part to create one of your own.\r\nKhoi Vinh shared a markup and CSS simple and flexible to be applied by almost everyone.\r\nIf you choose to credit the original author , that would be terrific.\r\nIf you can improve this markup and, or the CSS, using Gijoe Pico smarty please share your changes with\r\nthe community. Feel free topost new versions of this form for others to benefit from. Thanks!\r\n   ', 'xoopstpl', NULL);
    