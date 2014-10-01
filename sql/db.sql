--
-- Database: `iocome_db`
--
CREATE DATABASE `iocome_db`;

USE `iocome_db`;
-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_modified_on` datetime NOT NULL,
  `last_modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `user_id`, `parent_id`, `name`, `description`, `created_on`, `created_by`, `last_modified_on`, `last_modified_by`) VALUES
(44, 1, 5, '123213', '213232', '2014-05-28 13:41:05', 1, '2014-05-28 13:41:05', 1),
(42, 1, 1, 'ddasddsad', '544355345345', '2014-05-26 16:53:30', 1, '2014-06-11 18:39:14', 1),
(41, 1, 5, 'yyyy', 'ewqew', '2014-05-26 16:53:30', 1, '2014-05-26 16:53:30', 1),
(43, 1, 5, 'yyyy', 'ewqew', '2014-05-28 13:41:05', 1, '2014-05-28 13:41:05', 1),
(39, 1, 0, 'yyyy', 'ewqew', '2014-05-26 16:53:20', 1, '2014-05-26 16:53:20', 1),
(45, 1, 5, 'yyyy', 'ewqew', '2014-06-11 18:37:30', 1, '2014-06-11 18:37:30', 1),
(47, 2, 0, 'test', '[ string ]', '2014-07-21 12:44:56', 2, '2014-07-21 12:44:56', 2),
(48, 2, 0, 'test', '[ string ]', '2014-07-21 12:45:12', 2, '2014-07-21 12:45:12', 2),
(49, 2, 0, '[ string ]', '[ string ]', '2014-07-21 12:45:17', 2, '2014-07-21 12:51:41', 1),
(50, 2, 0, 'test11', '[ string ]', '2014-07-21 12:45:51', 2, '2014-07-21 12:45:51', 2),
(51, 2, 0, 'test22', '[ string ]', '2014-07-21 12:45:51', 2, '2014-07-21 12:45:51', 2),
(52, 2, 0, '[ string ]', '[ string ]', '2014-07-21 12:45:51', 2, '2014-07-23 08:20:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction_data`
--

CREATE TABLE IF NOT EXISTS `tbl_transaction_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `description` text,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_modified_on` datetime NOT NULL,
  `last_modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tbl_transaction_data`
--

INSERT INTO `tbl_transaction_data` (`id`, `user_id`, `date`, `description`, `created_on`, `created_by`, `last_modified_on`, `last_modified_by`) VALUES
(14, 1, '2014-05-01 00:00:00', 'sdfdsfsfdf', '2014-05-26 18:53:14', 1, '2014-05-26 18:53:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_transaction_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_data_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `type` enum('1','2') NOT NULL,
  `time` time DEFAULT NULL,
  `nominal` float NOT NULL,
  `description` text,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_modified_on` datetime NOT NULL,
  `last_modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_transaction_detail`
--

INSERT INTO `tbl_transaction_detail` (`id`, `transaction_data_id`, `category_id`, `type`, `time`, `nominal`, `description`, `created_on`, `created_by`, `last_modified_on`, `last_modified_by`) VALUES
(7, 14, 39, '2', NULL, 3900, 'kkkkk', '2014-05-26 18:53:14', 1, '2014-05-26 18:53:14', 1),
(6, 14, 41, '1', NULL, 20000, 'wwwwww', '2014-05-26 18:53:14', 1, '2014-05-26 18:53:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_login_time` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `last_modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `name`, `email`, `last_login_time`, `created_on`, `last_modified_on`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Administrator', 'a', '2014-07-17 10:47:53', '2014-06-11 16:48:00', '2014-07-16 15:51:25'),
(2, 'a', '202cb962ac59075b964b07152d234b70', 'DDaaaaa', 'aaaaccccc', '2014-07-23 07:17:42', '2014-07-16 11:15:04', '2014-07-16 16:05:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_group`
--

CREATE TABLE IF NOT EXISTS `tbl_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'as admin',
  `name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `last_modified_by` int(11) NOT NULL,
  `last_modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_group_member`
--

CREATE TABLE IF NOT EXISTS `tbl_user_group_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'as member',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;