#
# Table structure for table `stories`
#

CREATE TABLE `stories` (
  `storyid` int(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default 0,
  `title` varchar(255) NOT NULL default '',
  `created` int(10) unsigned NOT NULL default '0',
  `published` int(10) unsigned NOT NULL default '0',
  `expired` int(10) unsigned NOT NULL default '0',
  `hostname` varchar(20) NOT NULL default '',
  `html` tinyint(1) NOT NULL default '0',
  `smiley` tinyint(1) NOT NULL default '0',
  `br` tinyint(1) NOT NULL default '0',
  `xcode` tinyint(1) NOT NULL default '0',
  `hometext` text NOT NULL,
  `bodytext` text NOT NULL,
  `counter` int(8) unsigned NOT NULL default '0',
  `topicid` smallint(4) unsigned NOT NULL default '1',
  `ihome` tinyint(1) NOT NULL default '0',
  `notifypub` tinyint(1) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '0',
  `topicimg` tinyint(1) NOT NULL default '0',
  `comments` smallint(5) unsigned NOT NULL default '0',
  `block` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`storyid`),
  KEY `idxstoriestopic` (`topicid`),
  KEY `ihome` (`ihome`),
  KEY `uid` (`uid`),
  KEY `published_ihome` (`published`,`ihome`),
  KEY `title` (`title`),
  KEY `created` (`created`)
) TYPE=MyISAM;
# --------------------------------------------------------

INSERT INTO `stories` (`storyid`, `uid`, `title`, `created`, `published`, `expired`, `hostname`, `html`, `smiley`, `br`, `xcode`, `hometext`, `bodytext`, `counter`, `topicid`, `ihome`, `notifypub`, `type`, `topicimg`, `comments`, `block`) VALUES (1, 1, 'Portable WAMP', 1219646531, 1219646531, 0, '127.0.0.1', 0, 1, 1, 1, 'XOOPServer is a portable Windows Apache, MySQL, PHP and phpMyAdmin with required extensions to run and test locally XOOPS Cube Legacy Distributions Packages.\r\n\r\n[url=http://xoopserver.com]XOOPServer[/url]', '', 1, 5, 1, 0, 1, 1, 0, 1);
INSERT INTO `stories` (`storyid`, `uid`, `title`, `created`, `published`, `expired`, `hostname`, `html`, `smiley`, `br`, `xcode`, `hometext`, `bodytext`, `counter`, `topicid`, `ihome`, `notifypub`, `type`, `topicimg`, `comments`, `block`) VALUES (5, 1, 'Community Open Source Spirit', 1219647623, 1219647600, 0, '127.0.0.1', 0, 1, 1, 1, '\"Learn everything you can. Try everything that comes along. Look at everything there is to see. Search, experiment, make mistakes, fail, stand up. Turn religious, turn conservative, turn radical.\r\nAnd then forget all about it and find your way to create.\"', '', 0, 1, 1, 0, 1, 1, 0, 1);
INSERT INTO `stories` (`storyid`, `uid`, `title`, `created`, `published`, `expired`, `hostname`, `html`, `smiley`, `br`, `xcode`, `hometext`, `bodytext`, `counter`, `topicid`, `ihome`, `notifypub`, `type`, `topicimg`, `comments`, `block`) VALUES (2, 1, 'Legacy Render', 1219646854, 1219646667, 0, '127.0.0.1', 0, 1, 1, 1, 'You don\'t need to modify your favorite Xoops 2.0.16 theme to use it with your new XOOPS Cube 2.1 Legacy. Legacy Render ensure compatibility but also keep your Theme and modules Templates edition easier.\r\n\r\nPlease read the [url=http://xoopscube.org/modules/pukiwiki/index.php?XOOPSCubeLegacy%2FThemeCompatibility]XOOPS Cube Wiki[/url] about migration.\r\n\r\nXoops 2.0.16 use a bottom blocks hack which is not present on Legacy. This is not a problem and you can keep it for compatibility. For a light theme and faster render you can remove from your theme.html', '', 1, 3, 1, 0, 1, 1, 0, 1);
INSERT INTO `stories` (`storyid`, `uid`, `title`, `created`, `published`, `expired`, `hostname`, `html`, `smiley`, `br`, `xcode`, `hometext`, `bodytext`, `counter`, `topicid`, `ihome`, `notifypub`, `type`, `topicimg`, `comments`, `block`) VALUES (3, 1, 'Compatibility with Xoops 2', 1219647152, 1219647152, 0, '127.0.0.1', 0, 1, 1, 1, 'XOOPS Cube Legacy is highly compatible with XOOPS, allowing users to enjoy their favorite XOOPS modules and themes (have to be at least 2.0.7 compliant) while taking advantage of the new D3 Modules generation.\r\n\r\nThe community [url=http://xoopscube.org/modules/pukiwiki/?XOOPSCubeLegacy%2FModuleCompatibility]collect information about modules compatibility[/url] and still updating regularly those reports.\r\n\r\nXOOPS Cube Legacy can run modules of XOOPS2 JP and XOOPS 2.0.10. If you find modules which don\'t run on Legacy 2.1, please, report your information to the download URL - developer\'s site.', '', 1, 2, 1, 0, 1, 1, 0, 1);
INSERT INTO `stories` (`storyid`, `uid`, `title`, `created`, `published`, `expired`, `hostname`, `html`, `smiley`, `br`, `xcode`, `hometext`, `bodytext`, `counter`, `topicid`, `ihome`, `notifypub`, `type`, `topicimg`, `comments`, `block`) VALUES (4, 1, 'Welcome to XOOPS Cube', 1219647390, 1219647390, 0, '127.0.0.1', 0, 1, 1, 1, 'XOOPS Cube is an Open Source Web Application Platform, empowering everyone to create dynamic and content rich websites with ease. It is highly compatible with XOOPS, allowing users to enjoy their favorite XOOPS modules and themes (have to be at least 2.0.7 compliant) - Take advantage of the new D3 Modules generation running the simple, secure and scalable Object Oriented Web Application Platform - XOOPS Cube.', '', 0, 4, 1, 0, 1, 1, 0, 1);


#
# Table structure for table `topics`
#

CREATE TABLE `topics` (
  `topic_id` smallint(4) unsigned NOT NULL auto_increment,
  `topic_pid` smallint(4) unsigned NOT NULL default '0',
  `topic_imgurl` varchar(255) NOT NULL default '',
  `topic_title` varchar(255) NOT NULL default '',
  `topic_created` int(10) unsigned NOT NULL default 0,
  `topic_modified` int(10) unsigned NOT NULL default 0,
  PRIMARY KEY (`topic_id`),
  KEY `pid` (`topic_pid`)
) TYPE=MyISAM;


INSERT INTO `topics` (`topic_id`, `topic_pid`, `topic_imgurl`, `topic_title`, `topic_created`, `topic_modified`) VALUES (1, 0, '', 'TOP', 1219610045, 0);
INSERT INTO `topics` (`topic_id`, `topic_pid`, `topic_imgurl`, `topic_title`, `topic_created`, `topic_modified`) VALUES (2, 0, 'topic_modules.jpg', 'Modules', 1219646574, 1219646574);
INSERT INTO `topics` (`topic_id`, `topic_pid`, `topic_imgurl`, `topic_title`, `topic_created`, `topic_modified`) VALUES (3, 0, 'topic_themes.jpg', 'Themes', 1219646589, 1219646589);
INSERT INTO `topics` (`topic_id`, `topic_pid`, `topic_imgurl`, `topic_title`, `topic_created`, `topic_modified`) VALUES (4, 0, 'topic_xoopscube.jpg', 'XOOPS Cube', 1219646603, 1219646603);
INSERT INTO `topics` (`topic_id`, `topic_pid`, `topic_imgurl`, `topic_title`, `topic_created`, `topic_modified`) VALUES (5, 0, 'topic_xoopserver.jpg', 'XOOPServer', 1219646618, 1219646618);

#
# Table structure for table `relation`
#

CREATE TABLE `relation` (
  `storyid` int(8) NOT NULL default '0',
  `linkedid` int(8) NOT NULL default '0',
  `dirname` varchar(25) NOT NULL default '',
  KEY (`storyid`),
  PRIMARY KEY (`storyid`,`linkedid`,`dirname`)
) TYPE=MyISAM;
