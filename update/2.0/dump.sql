CREATE TABLE IF NOT EXISTS `prefix_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned DEFAULT NULL,
  `url` varchar(50) NOT NULL,
  `url_full` varchar(254) NOT NULL,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `date_add` datetime NOT NULL,
  `date_edit` datetime DEFAULT NULL,
  `seo_keywords` varchar(250) DEFAULT NULL,
  `seo_description` varchar(250) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `main` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL,
  `auto_br` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `url_full` (`url_full`,`active`),
  KEY `title` (`title`),
  KEY `sort` (`sort`),
  KEY `main` (`main`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


INSERT INTO `prefix_page` (`id`, `pid`, `url`, `url_full`, `title`, `text`, `date_add`, `date_edit`, `seo_keywords`, `seo_description`, `active`, `main`, `sort`, `auto_br`) VALUES
(1, NULL, 'about', 'about', 'about', 'edit this page http://yousite/admin/', NOW(), NULL, '', '', 1, 1, 1, 1);

ALTER TABLE `prefix_page` ADD `text_source` TEXT NULL DEFAULT NULL AFTER `text`;