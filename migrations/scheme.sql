CREATE TABLE IF NOT EXISTS `{prefix}seo_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url_id` (`url_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `{prefix}seo_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text,
  `h1` varchar(255) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `{prefix}seo_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_id` int(11) NOT NULL,
  `param` varchar(255) DEFAULT NULL,
  `obj` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `url_id` (`url_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `{prefix}redirects`;
CREATE TABLE `{prefix}redirects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_from` varchar(255) DEFAULT NULL,
  `url_to` varchar(255) DEFAULT NULL,
  `switch` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET={charset};


