-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 24, 2017 at 07:58 AM
-- Server version: 10.0.30-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autovm_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` char(16) COLLATE utf8_bin NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `api_log`
--

CREATE TABLE `api_log` (
  `id` int(11) UNSIGNED NOT NULL,
  `api_id` int(11) UNSIGNED NOT NULL,
  `action` tinyint(1) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `bandwidth`
--

CREATE TABLE `bandwidth` (
  `id` int(11) UNSIGNED NOT NULL,
  `vps_id` int(11) UNSIGNED NOT NULL,
  `used` int(11) UNSIGNED NOT NULL,
  `pure_used` int(11) UNSIGNED NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `datastore`
--

CREATE TABLE `datastore` (
  `id` int(11) UNSIGNED NOT NULL,
  `server_id` int(11) UNSIGNED NOT NULL,
  `uuid` varchar(255) null default null,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  `space` int(11) UNSIGNED NOT NULL,
  `is_default` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ip`
--

CREATE TABLE `ip` (
  `id` int(11) UNSIGNED NOT NULL,
  `server_id` int(11) UNSIGNED NOT NULL,
  `ip` varchar(45) COLLATE utf8_bin NOT NULL,
  `gateway` varchar(255) COLLATE utf8_bin NOT NULL,
  `netmask` varchar(255) COLLATE utf8_bin NOT NULL,
  `mac_address` varchar(255) COLLATE utf8_bin NOT NULL,
  `is_public` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `lost_password`
--

CREATE TABLE `lost_password` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `key` char(16) COLLATE utf8_bin NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL,
  `expired_at` int(11) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_bin NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `os`
--

CREATE TABLE `os` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `operation_system` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `os`
--

INSERT INTO `os` (`id`, `name`, `type`, `operation_system`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'windows 2003 32', 'windows_2003_32', 'windows 2003 32 bit', 'administrator', '123QWEqwe', 1484388617, 1484388617),
(2, 'windows 2003 64', 'windows_2003_64', 'windows 2003 32 bit', 'administrator', '123QWEqwe', 1484388637, 1484388637),
(3, 'windows 2008 32', 'windows_2008_32', 'windows 2008 32 bit', 'administrator', '123QWEqwe', 1484388665, 1484388665),
(4, 'windows 2008 64', 'windows_2008_64', 'windows 2008 64 bit', 'administrator', '123QWEqwe', 1484388684, 1484388684),
(5, 'windows 2012 64', 'windows_2012_64', 'windows 2012 64 bit', 'administrator', '123QWEqwe', 1484388703, 1484388703),
(6, 'debian 8.5 32', 'debian_8.5_32', 'debian 8.5 32 bit', 'root', '123QWEqwe', 1484388762, 1484388762),
(7, 'debian 8.5 64', 'debian_8.5_64', 'debian 8.5 64 bit', 'root', '123QWEqwe', 1484388777, 1484388777),
(8, 'centos 6.8 32', 'centos_6.8_32', 'centos 6.8 32 bit', 'root', '123QWEqwe', 1484388809, 1484388809),
(9, 'centos 6.8 64', 'centos_6.8_64', 'centos 6.8 64 bit', 'root', '123QWEqwe', 1484388827, 1484388827),
(10, 'centos 7 64', 'centos_7_64', 'centos 7 64 bit', 'root', '123QWEqwe', 1484388827, 1484388827),
(11, 'ubuntu 16.04 32', 'ubuntu_16.04_32', 'ubuntu 16.04 32 bit', 'root', '123QWEqwe', 1484388849, 1484388849),
(12, 'ubuntu 16.04 64', 'ubuntu_16.04_64', 'ubuntu 16.04 64 bit', 'root', '123QWEqwe', 1484388874, 1484388874);

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `ram` int(11) UNSIGNED NOT NULL,
  `cpu_mhz` int(11) UNSIGNED NOT NULL,
  `cpu_core` int(11) UNSIGNED NOT NULL,
  `hard` int(11) UNSIGNED NOT NULL,
  `band_width` bigint(20) NOT NULL,
  `is_public` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE `server` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `ip` varchar(45) COLLATE utf8_bin NOT NULL,
  `port` smallint(11) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `license` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL,
  `vcenter_ip` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `vcenter_username` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `vcenter_password` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `key`, `value`) VALUES
(1, 'title', 'VPS management'),
(2, 'api_url', 'https://server1.autovm.info/web/index.php/api/default');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `auth_key` varchar(255) COLLATE utf8_bin NOT NULL,
  `is_admin` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `auth_key`, `is_admin`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Admin', 'admin', 'abchhjkfuerqwelo', 1, 123, 1483806002, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_email`
--

CREATE TABLE `user_email` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `key` char(16) COLLATE utf8_bin NOT NULL,
  `is_primary` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `is_confirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_email`
--

INSERT INTO `user_email` (`id`, `user_id`, `email`, `key`, `is_primary`, `is_confirmed`, `created_at`, `updated_at`) VALUES
(1, 1, '{email}', 'abchhjkfuerqwelo', 1, 1, 123, 123);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `ip` varchar(45) COLLATE utf8_bin NOT NULL,
  `os_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `browser_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_password`
--

CREATE TABLE `user_password` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `hash` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `salt` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_password`
--

INSERT INTO `user_password` (`id`, `user_id`, `hash`, `salt`, `password`, `created_at`) VALUES
(1, 1, 2, 'abchhjkfuerqwelo', '{password}', 123);

-- --------------------------------------------------------

--
-- Table structure for table `vps`
--

CREATE TABLE `vps` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `server_id` int(11) UNSIGNED NOT NULL,
  `datastore_id` int(11) UNSIGNED NOT NULL,
  `os_id` int(11) UNSIGNED DEFAULT NULL,
  `plan_id` int(11) UNSIGNED DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `plan_type` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `vps_ram` int(11) UNSIGNED DEFAULT NULL,
  `vps_cpu_mhz` int(11) UNSIGNED DEFAULT NULL,
  `vps_cpu_core` int(11) UNSIGNED DEFAULT NULL,
  `vps_hard` int(11) UNSIGNED DEFAULT NULL,
  `vps_band_width` int(11) UNSIGNED DEFAULT NULL,
  `reset_at` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `power` tinyint(1) UNSIGNED NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `vps_action`
--

CREATE TABLE `vps_action` (
  `id` int(11) UNSIGNED NOT NULL,
  `vps_id` int(11) UNSIGNED NOT NULL,
  `action` tinyint(1) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `vps_ip`
--

CREATE TABLE `vps_ip` (
  `id` int(11) UNSIGNED NOT NULL,
  `vps_id` int(11) UNSIGNED NOT NULL,
  `ip_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_key_unique_key` (`key`);

--
-- Indexes for table `api_log`
--
ALTER TABLE `api_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `api_log_api_id` (`api_id`);

--
-- Indexes for table `bandwidth`
--
ALTER TABLE `bandwidth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bandwidth_vps_id` (`vps_id`);

--
-- Indexes for table `datastore`
--
ALTER TABLE `datastore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datastore_server_id_foreign_key` (`server_id`);

--
-- Indexes for table `ip`
--
ALTER TABLE `ip`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip_id_unique_key` (`server_id`,`ip`),
  ADD KEY `ip_id_primary_key` (`id`);

--
-- Indexes for table `lost_password`
--
ALTER TABLE `lost_password`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lost_password_key_unique_key` (`key`),
  ADD KEY `lost_password_user_id_foreign_key` (`user_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `os`
--
ALTER TABLE `os`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key_unique_key` (`key`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_auth_key_unique_key` (`auth_key`);

--
-- Indexes for table `user_email`
--
ALTER TABLE `user_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_email_unique_key` (`email`),
  ADD UNIQUE KEY `user_email_key_unique_key` (`key`),
  ADD KEY `user_email_user_id_foreign_key` (`user_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login_user_id_foreign_key` (`user_id`);

--
-- Indexes for table `user_password`
--
ALTER TABLE `user_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_password_user_id_foreign_key` (`user_id`);

--
-- Indexes for table `vps`
--
ALTER TABLE `vps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `server_id` (`server_id`),
  ADD KEY `datastore_id` (`datastore_id`),
  ADD KEY `os_id` (`os_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `vps_action`
--
ALTER TABLE `vps_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vps_id` (`vps_id`);

--
-- Indexes for table `vps_ip`
--
ALTER TABLE `vps_ip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vps_id` (`vps_id`),
  ADD KEY `ip_id` (`ip_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `api_log`
--
ALTER TABLE `api_log`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bandwidth`
--
ALTER TABLE `bandwidth`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `datastore`
--
ALTER TABLE `datastore`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `ip`
--
ALTER TABLE `ip`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `lost_password`
--
ALTER TABLE `lost_password`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `os`
--
ALTER TABLE `os`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `server`
--
ALTER TABLE `server`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_email`
--
ALTER TABLE `user_email`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user_password`
--
ALTER TABLE `user_password`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `vps`
--
ALTER TABLE `vps`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `vps_action`
--
ALTER TABLE `vps_action`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `vps_ip`
--
ALTER TABLE `vps_ip`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `api_log`
--
ALTER TABLE `api_log`
  ADD CONSTRAINT `api_log_api_id` FOREIGN KEY (`api_id`) REFERENCES `api` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `bandwidth`
--
ALTER TABLE `bandwidth`
  ADD CONSTRAINT `bandwidth_vps_id` FOREIGN KEY (`vps_id`) REFERENCES `vps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `datastore`
--
ALTER TABLE `datastore`
  ADD CONSTRAINT `datastore_server_id_foreign_key` FOREIGN KEY (`server_id`) REFERENCES `server` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ip`
--
ALTER TABLE `ip`
  ADD CONSTRAINT `ip_server_id_foreign_key` FOREIGN KEY (`server_id`) REFERENCES `server` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lost_password`
--
ALTER TABLE `lost_password`
  ADD CONSTRAINT `lost_password_user_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_email`
--
ALTER TABLE `user_email`
  ADD CONSTRAINT `user_email_user_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_login`
--
ALTER TABLE `user_login`
  ADD CONSTRAINT `user_login_user_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_password`
--
ALTER TABLE `user_password`
  ADD CONSTRAINT `user_password_user_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `vps`
--
ALTER TABLE `vps`
  ADD CONSTRAINT `vps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `vps_ibfk_2` FOREIGN KEY (`server_id`) REFERENCES `server` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `vps_ibfk_3` FOREIGN KEY (`datastore_id`) REFERENCES `datastore` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `vps_ibfk_4` FOREIGN KEY (`os_id`) REFERENCES `os` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `vps_ibfk_5` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `vps_action`
--
ALTER TABLE `vps_action`
  ADD CONSTRAINT `vps_action_ibfk_1` FOREIGN KEY (`vps_id`) REFERENCES `vps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `vps_ip`
--
ALTER TABLE `vps_ip`
  ADD CONSTRAINT `vps_ip_ibfk_1` FOREIGN KEY (`vps_id`) REFERENCES `vps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `vps_ip_ibfk_2` FOREIGN KEY (`ip_id`) REFERENCES `ip` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


alter table server add column network varchar(255) null default null after vcenter_password;

alter table server add column version int(11) unsigned null default null after network;
alter table `server` add column second_network varchar(255) null default null after network;
alter table `ip` add column network tinyint(1) unsigned not null default 1 after is_public;
alter table `vps` add column `disk` varchar(255) null default null after `power`;
create table if not exists `iso` (

    id int(11) unsigned not null auto_increment,
    name varchar(255) not null,
    path varchar(255) not null,
    
    primary key(id)

) engine=innodb;
alter table server add column parent_id int(11) unsigned null default null after id;
update `setting` set `value` = 'auto' where `key` = 'api_url';
alter table os add column adapter varchar(255) null default null after password;
insert into setting (`key`, `value`) VALUES('terminate', '2');
alter table `vps` add column `snapshot` tinyint(1) unsigned not null default 2;
UPDATE `setting` SET `value` = 'https://server1.autovm.info/web/index.php/api/default' WHERE `key` = 'api_url';
alter table `datastore` add column `vsan` tinyint(1) unsigned not null default 1 after `is_default`;
alter table `vps` add column `hostname` varchar(255) null default null after `password`

