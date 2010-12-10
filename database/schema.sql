-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 11 ott, 2010 at 10:33 PM
-- Versione MySQL: 5.1.41
-- Versione PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `htcheck_webmanager`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `webmanager_db_type` varchar(255) NOT NULL,
  `webmanager_host` varchar(255) NOT NULL,
  `webmanager_port` varchar(255) NOT NULL,
  `webmanager_db` varchar(255) NOT NULL,
  `webmanager_user` varchar(255) NOT NULL,
  `webmanager_password` varchar(255) NOT NULL,
  `webmanager_path` varchar(255) NOT NULL,
  `htcheck_host` varchar(255) NOT NULL,
  `htcheck_port` varchar(255) NOT NULL,
  `htcheck_db` varchar(255) NOT NULL,
  `htcheck_user` varchar(255) NOT NULL,
  `htcheck_password` varchar(255) NOT NULL,
  PRIMARY KEY (`webmanager_host`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `configuration`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `crawler`
--

CREATE TABLE IF NOT EXISTS `crawler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_header` text NOT NULL,
  `config_footer` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_url` varchar(255) NOT NULL,
  `limit_urls_to` varchar(255) NOT NULL,
  `limit_normalized` varchar(255) NOT NULL,
  `exclude_urls` varchar(255) NOT NULL,
  `max_hop_count` int(11) NOT NULL,
  `max_urls_count` int(11) NOT NULL,
  `bad_extensions` varchar(255) NOT NULL,
  `bad_querystr` varchar(255) NOT NULL,
  `check_external` tinyint(1) NOT NULL,
  `db_name` varchar(255) NOT NULL,
  `db_name_prepend` varchar(255) NOT NULL,
  `mysql_conf_file_prefix` varchar(255) NOT NULL,
  `mysql_conf_group` varchar(255) NOT NULL,
  `mysql_db_charset` varchar(255) NOT NULL,
  `mysql_client_charset` varchar(255) NOT NULL,
  `url_index_length` int(11) NOT NULL,
  `optimize_db` tinyint(1) NOT NULL,
  `sql_big_table_option` tinyint(1) NOT NULL,
  `max_doc_size` int(11) NOT NULL,
  `store_only_links` tinyint(1) NOT NULL,
  `store_url_contents` int(11) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `persistent_connections` tinyint(1) NOT NULL,
  `head_before_get` tinyint(1) NOT NULL,
  `timeout` int(11) NOT NULL,
  `authorization` varchar(255) NOT NULL,
  `max_retries` int(11) NOT NULL,
  `tcp_wait_time` int(11) NOT NULL,
  `tcp_max_retries` int(11) NOT NULL,
  `http_proxy` varchar(255) NOT NULL,
  `http_proxy_exclude` varchar(255) NOT NULL,
  `accept_language` varchar(255) NOT NULL,
  `disable_cookies` tinyint(1) NOT NULL,
  `cookies_input_file` varchar(255) NOT NULL,
  `url_reserved_chars` varchar(255) NOT NULL,
  `summary_anchor_not_found` tinyint(1) NOT NULL,
  `accessibility_checks` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `crawler`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `crawler_crontab`
--

CREATE TABLE IF NOT EXISTS `crawler_crontab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crawler_id` int(11) NOT NULL,
  `minute` varchar(2) NOT NULL,
  `hour` varchar(2) NOT NULL,
  `day` varchar(2) NOT NULL,
  `month` varchar(2) NOT NULL,
  `weekday` varchar(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `crawler_id` (`crawler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `crawler_crontab`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `crawler_log`
--

CREATE TABLE IF NOT EXISTS `crawler_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crawler_id` int(11) NOT NULL,
  `version` varchar(32) NOT NULL DEFAULT '2.0.0',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `scheduled_urls` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tot_urls` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `retrieved_urls` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tcp_connections` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `server_changes` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `http_requests` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `http_seconds` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `http_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `accessibility_checks` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `htdig_notification` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `crawler_id` (`crawler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `crawler_log`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `crawler_queue`
--

CREATE TABLE IF NOT EXISTS `crawler_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `crawler_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `crawler_id` (`crawler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `crawler_queue`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `group`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `group_crawler`
--

CREATE TABLE IF NOT EXISTS `group_crawler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `crawler_id` int(11) NOT NULL,
  `read` tinyint(1) NOT NULL,
  `config` tinyint(1) NOT NULL,
  `cron` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `crawler_id` (`crawler_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `group_crawler`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `lookup`
--

CREATE TABLE IF NOT EXISTS `lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;



--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `language` tinyint(1) NOT NULL,
  `role` tinyint(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `user`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `user_crawler`
--

CREATE TABLE IF NOT EXISTS `user_crawler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `crawler_id` int(11) NOT NULL,
  `can_read` tinyint(1) NOT NULL COMMENT 'Y/N/NULL',
  `admin` tinyint(1) NOT NULL COMMENT 'Y/N/NULL',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`crawler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `user_crawler`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `user_group`
--


