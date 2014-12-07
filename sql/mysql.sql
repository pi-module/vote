CREATE TABLE `{point}` (
    `id` int(10) unsigned NOT NULL auto_increment,
    `uid` int(10) unsigned NOT NULL default '0',
    `item` int(10) unsigned NOT NULL default '0',
    `table` varchar(64) NOT NULL default '',
    `module` varchar(64) NOT NULL default '',
    `point` tinyint(3) NOT NULL default '0',
    `ip` char(15) NOT NULL default '',
    `time_create` int(10) unsigned NOT NULL default '0',
    PRIMARY KEY (`id`),
    KEY `module` (`module`),
    KEY `table` (`table`),
    KEY `item` (`item`),
    KEY `uid` (`uid`),
    KEY `ip` (`ip`),
    KEY `time_create` (`time_create`),
    KEY `point_list` (`uid`, `item`, `table`, `module`)
);