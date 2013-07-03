CREATE TABLE `{point}` (
 `id` int(10) unsigned NOT NULL auto_increment,
 `uid` int(10) unsigned NOT NULL,
 `item` int(10) unsigned NOT NULL,
 `module` varchar(64) NOT NULL,
 `point` tinyint(3) NOT NULL,
 `case` int(10) unsigned NOT NULL,
 `hostname` varchar(64) NOT NULL,
 `create` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `item` (`item`),
  KEY `uid` (`uid`),  KEY `hostname` (`hostname`),
  KEY `create` (`create`),
  KEY `point_list` (`uid`, `module`, `item`)
);

CREATE TABLE `{case}` (
 `id` int(10) unsigned NOT NULL auto_increment,
 `item` int(10) unsigned NOT NULL,
 `module` varchar(64) NOT NULL,
 `point` int(10) NOT NULL,
 `count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `item` (`item`),
  KEY `case_list` (`module`, `item`)
);