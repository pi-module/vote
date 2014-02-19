CREATE TABLE `{point}` (
    `id` int(10) unsigned NOT NULL auto_increment,
    `uid` int(10) unsigned NOT NULL,
    `item` int(10) unsigned NOT NULL,
    `table` varchar(64) NOT NULL,
    `module` varchar(64) NOT NULL,
    `point` tinyint(3) NOT NULL,
    `ip` char(15) NOT NULL,
    `time_create` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `module` (`module`),
    KEY `table` (`table`),
    KEY `item` (`item`),
    KEY `uid` (`uid`),
    KEY `ip` (`ip`),
    KEY `time_create` (`time_create`),
    KEY `point_list` (`uid`, `item`, `table`, `module`)
);