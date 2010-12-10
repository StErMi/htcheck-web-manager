-- ---------------------------------------------------------------------
-- 
-- ht://Check - Web Manager Interface
-- Database Schema for PostgreSQL
-- 
-- Authors:
--   - Emanuele Ricci <stermi@users.sf.net>
--   - Gabriele Bartolini <gabriele.bartolini@devise.it>
-- 
-- Copyright (c) 2010 Devise.IT S.r.l. - Prato - Italy (www.devise.it)
-- ht://Check Web Manager is distributed under the GNU General Public License (GPL), v3.
-- See the COPYING file for license information.
-- 
-- ---------------------------------------------------------------------

DROP SCHEMA IF EXISTS htcheck_webmanager CASCADE;
CREATE SCHEMA htcheck_webmanager;
SET search_path TO htcheck_webmanager;

CREATE TABLE "configuration"
(
  webmanager_db_type character varying(255) NOT NULL,
  webmanager_host character varying(255) NOT NULL,
  webmanager_port character varying(255) NOT NULL,
  webmanager_db character varying(255) NOT NULL,
  webmanager_user character varying(255) NOT NULL,
  webmanager_password character varying(255) NOT NULL,
  webmanager_path character varying(255) NOT NULL,
  htcheck_host character varying(255) NOT NULL,
  htcheck_port character varying(255) NOT NULL,
  htcheck_db character varying(255) NOT NULL,
  htcheck_user character varying(255) NOT NULL,
  htcheck_password character varying(255) NOT NULL
);

CREATE TABLE crawler
(
  id serial NOT NULL,
  config_header text NOT NULL,
  config_footer text NOT NULL,
  title character varying(255) NOT NULL,
  start_url character varying(255) NOT NULL,
  limit_urls_to character varying(255) NOT NULL,
  limit_normalized character varying(255) NOT NULL,
  exclude_urls character varying(255) NOT NULL,
  max_hop_count integer NOT NULL,
  max_urls_count integer NOT NULL,
  bad_extensions character varying(255) NOT NULL,
  bad_querystr character varying(255) NOT NULL,
  check_external boolean NOT NULL,
  db_name character varying(255) NOT NULL,
  db_name_prepend character varying(255) NOT NULL,
  mysql_conf_file_prefix character varying(255) NOT NULL,
  mysql_conf_group character varying(255) NOT NULL,
  mysql_db_charset character varying(255) NOT NULL,
  mysql_client_charset character varying(255) NOT NULL,
  url_index_length integer NOT NULL,
  optimize_db boolean NOT NULL,
  sql_big_table_option boolean NOT NULL,
  max_doc_size integer NOT NULL,
  store_only_links boolean NOT NULL,
  store_url_contents integer NOT NULL,
  user_agent character varying(255) NOT NULL,
  persistent_connections boolean NOT NULL,
  head_before_get boolean NOT NULL,
  timeout integer NOT NULL,
  "authorization" character varying(255) NOT NULL,
  max_retries integer NOT NULL,
  tcp_wait_time integer NOT NULL,
  tcp_max_retries integer NOT NULL,
  http_proxy character varying(255) NOT NULL,
  http_proxy_exclude character varying(255) NOT NULL,
  accept_language character varying(255) NOT NULL,
  disable_cookies boolean NOT NULL,
  cookies_input_file character varying(255) NOT NULL,
  url_reserved_chars character varying(255) NOT NULL,
  summary_anchor_not_found boolean NOT NULL,
  accessibility_checks boolean NOT NULL,
  status boolean NOT NULL,
  CONSTRAINT crawler_pk_id PRIMARY KEY (id)
);

CREATE TABLE crawler_crontab
(
  id serial NOT NULL,
  crawler_id integer NOT NULL,
  "minute" character varying(2) NOT NULL,
  "hour" character varying(2) NOT NULL,
  "day" character varying(2) NOT NULL,
  "month" character varying(2) NOT NULL,
  weekday character varying(1) NOT NULL,
  CONSTRAINT crawler_crontab_pk_id PRIMARY KEY (id)
);

CREATE TABLE crawler_log
(
  id serial NOT NULL,
  crawler_id integer NOT NULL,
  "version" character varying(32) NOT NULL,
  start_time timestamp without time zone NOT NULL,
  end_time timestamp without time zone NOT NULL,
  scheduled_urls integer NOT NULL,
  tot_urls integer NOT NULL,
  retrieved_urls integer NOT NULL,
  tcp_connections integer NOT NULL,
  server_changes integer NOT NULL,
  http_requests integer NOT NULL,
  http_seconds integer NOT NULL,
  http_bytes bigint NOT NULL,
  accessibility_checks smallint NOT NULL,
  htdig_notification smallint NOT NULL,
  "user" character varying(255) NOT NULL,
  CONSTRAINT crawler_log_pk_id PRIMARY KEY (id)
);

CREATE TABLE crawler_queue
(
  id serial NOT NULL,
  user_id integer NOT NULL,
  crawler_id integer NOT NULL,
  CONSTRAINT crawler_queue_pk_id PRIMARY KEY (id)
);

CREATE TABLE "group"
(
  id serial NOT NULL,
  title character varying(255) NOT NULL,
  CONSTRAINT group_pk_id PRIMARY KEY (id)
);


CREATE TABLE group_crawler
(
  id serial NOT NULL,
  group_id integer NOT NULL,
  crawler_id integer NOT NULL,
  "read" boolean NOT NULL,
  config boolean NOT NULL,
  cron boolean NOT NULL,
  "admin" boolean NOT NULL,
  CONSTRAINT group_crawler_pk_id PRIMARY KEY (id)
);


CREATE TABLE lookup
(
  id serial NOT NULL,
  "name" character varying(128) NOT NULL,
  code integer NOT NULL,
  "type" character varying(128) NOT NULL,
  "position" integer NOT NULL,
  CONSTRAINT lookup_pk_id PRIMARY KEY (id)
);


CREATE TABLE "user"
(
  id serial NOT NULL,
  username character varying(255) NOT NULL,
  "password" character varying(32) NOT NULL,
  "language" smallint NOT NULL,
  "role" smallint NOT NULL,
  email character varying(255) NOT NULL,
  CONSTRAINT user_pk_id PRIMARY KEY (id)
);


CREATE TABLE user_crawler
(
  id serial NOT NULL,
  user_id integer NOT NULL,
  crawler_id integer NOT NULL,
  can_read smallint NOT NULL,
  "admin" smallint NOT NULL,
  CONSTRAINT user_crawler_pk_id PRIMARY KEY (id)
);

CREATE TABLE user_group
(
  user_id integer NOT NULL,
  group_id integer NOT NULL,
  CONSTRAINT user_group_pk PRIMARY KEY (user_id, group_id)
);

