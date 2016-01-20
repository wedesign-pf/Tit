--
-- Table structure for table `social_publisher`
--

CREATE TABLE IF NOT EXISTS `social_publisher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL,
  `user_id` varchar(120) NOT NULL,
  `username` varchar(60) NOT NULL,
  `name` varchar(120) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_secret` varchar(255) NOT NULL,
  `token_expires` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `social_publisher_history`
--

CREATE TABLE IF NOT EXISTS `social_publisher_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT NULL,
  `user_id` varchar(120) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `result` text,
  `message_id` varchar(60) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
