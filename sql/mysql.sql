CREATE TABLE `{point}` (
  `id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid`         INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `item`        INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `table`       VARCHAR(64)      NOT NULL DEFAULT '',
  `module`      VARCHAR(64)      NOT NULL DEFAULT '',
  `point`       TINYINT(3)       NOT NULL DEFAULT '0',
  `ip`          CHAR(15)         NOT NULL DEFAULT '',
  `time_create` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `table` (`table`),
  KEY `item` (`item`),
  KEY `uid` (`uid`),
  KEY `ip` (`ip`),
  KEY `time_create` (`time_create`),
  KEY `user_point_list` (`uid`, `item`, `table`, `module`),
  KEY `ip_point_list` (`ip`, `item`, `table`, `module`)
);