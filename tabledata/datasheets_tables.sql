--
-- Table structure for table `filetype`
--

DROP TABLE IF EXISTS `filetype`;
CREATE TABLE `filetype` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                            `display_name` varchar(50) NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `type` int NOT NULL,
                        `name` varchar(255) NOT NULL,
                        `filepath` varchar(500) NOT NULL,
                        `date_uploaded` datetime NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `type` (`type`),
                        CONSTRAINT `file_ibfk_1` FOREIGN KEY (`type`) REFERENCES `filetype` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=750 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Table structure for table `perms`
--

DROP TABLE IF EXISTS `perms`;
CREATE TABLE `perms` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `usergroup` varchar(20) NOT NULL,
                         `title` varchar(100) NOT NULL,
                         `description` varchar(500) DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


--
-- Table structure for table `userperms`
--

DROP TABLE IF EXISTS `userperms`;
CREATE TABLE `userperms` (
                             `uid` varchar(30) NOT NULL,
                             `permid` int NOT NULL,
                             PRIMARY KEY (`uid`,`permid`),
                             KEY `permid` (`permid`),
                             CONSTRAINT `userperms_ibfk_1` FOREIGN KEY (`permid`) REFERENCES `perms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;