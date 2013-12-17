-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2013 at 09:13 AM
-- Server version: 5.5.30-30.1
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `illyagor_patientUpdate`
--
CREATE DATABASE IF NOT EXISTS `illyagor_patientUpdate` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `illyagor_patientUpdate`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` varchar(255) NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name` (`cat_name`),
  UNIQUE KEY `cat_name_2` (`cat_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_description`) VALUES
(1, 'first Catagory', 'some random category'),
(2, 'other cat', 'some other cat'),
(3, 'sdfgsd ', 'dzfb ds hd');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `title`, `text`) VALUES
(1, 'Hello World!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sapien eros, lacinia eu, consectetur vel, dignissim et, massa. Praesent suscipit nunc vitae neque. Duis a ipsum. Nunc a erat. Praesent nec libero. Phasellus lobortis, velit sed pharetra imperdiet, justo ipsum facilisis arcu, in eleifend elit nulla sit amet tellus. Pellentesque molestie dui lacinia nulla. Sed vitae arcu at nisl sodales ultricies. Etiam mi ligula, consequat eget, elementum sed, vulputate in, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `patient_id` int(8) NOT NULL AUTO_INCREMENT,
  `patient_num` int(8) NOT NULL,
  `patient_dateContacted` date NOT NULL,
  `patient_subjectNum` int(8) NOT NULL,
  `patient_initial` varchar(30) NOT NULL,
  `patient_fName` varchar(255) NOT NULL,
  `patient_lName` varchar(255) NOT NULL,
  `patient_phone` varchar(255) NOT NULL,
  `patient_firstAtt` varchar(10) NOT NULL,
  `patient_secondAtt` varchar(10) NOT NULL,
  `patient_thirdAtt` varchar(10) NOT NULL,
  `patient_dateScreened` date NOT NULL,
  `patient_show` varchar(10) NOT NULL,
  `patient_comment` text NOT NULL,
  `patient_dateEnroll` date NOT NULL,
  `patient_dateScreeFail` date NOT NULL,
  `patient_failCriteria` varchar(255) NOT NULL,
  `patient_consent` varchar(10) NOT NULL,
  `patient_status` varchar(255) NOT NULL,
  `patient_site` int(8) NOT NULL,
  `patient_PDFform` varchar(255) NOT NULL,
  PRIMARY KEY (`patient_id`),
  KEY `patient_site` (`patient_site`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_num`, `patient_dateContacted`, `patient_subjectNum`, `patient_initial`, `patient_fName`, `patient_lName`, `patient_phone`, `patient_firstAtt`, `patient_secondAtt`, `patient_thirdAtt`, `patient_dateScreened`, `patient_show`, `patient_comment`, `patient_dateEnroll`, `patient_dateScreeFail`, `patient_failCriteria`, `patient_consent`, `patient_status`, `patient_site`, `patient_PDFform`) VALUES
(33, 1, '2012-05-17', 12, 'as', 'add', 'ssss', '123-123-1234', 'BA', '', '', '2012-05-16', '', '', '2012-05-08', '0000-00-00', '', '', 'ENROLLED', 5, ''),
(32, 0, '0000-00-00', 0, '', '', '', '', 'VM', '', '', '0000-00-00', '', '', '2012-05-16', '0000-00-00', '', '', 'ENROLLED', 6, ''),
(31, 6, '0000-00-00', 0, '', '', '', '', 'VM', 'BA', '', '0000-00-00', '', '', '2012-05-22', '0000-00-00', '', '', 'ENROLLED', 6, ''),
(28, 0, '0000-00-00', 0, '', '', '', '', 'VM', '', '', '2012-05-17', 'on', '', '2012-05-16', '0000-00-00', '', 'on', 'ENROLLED', 6, ''),
(27, 0, '0000-00-00', 0, '', '', '', '', 'VM', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'FOLLOWUP', 6, ''),
(29, 4, '0000-00-00', 0, 'sdfa', 'saef', 'sdfas', '222-222-2222', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 6, ''),
(30, 5, '0000-00-00', 0, '', '', '', '', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 6, ''),
(37, 1, '0000-00-00', 0, '', '', '', '', 'UM', '', '', '0000-00-00', '', '', '2012-05-15', '0000-00-00', '', '', 'ENROLLED', 8, ''),
(26, 1, '0000-00-00', 0, '', '', '', '', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 6, ''),
(34, 2, '2012-05-18', 456, 'ig', 'ill', 'gor', '222-222-2222', 'LM', 'DNC', '', '0000-00-00', '', '', '0000-00-00', '2012-05-16', 'FAil', '', 'FAILED', 5, ''),
(35, 3, '2012-05-05', 789, 'qw', 'qqqq', 'wwwww', '999-999-9999', 'LM', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'FOLLOWUP', 5, ''),
(36, 4, '2012-05-14', 234, 'rt', 'sgsd', 'tttt', '888-888-8888', '', '', '', '0000-00-00', 'on', '', '0000-00-00', '2012-05-22', 'sdrgsdgadg', '', 'FAILED', 5, ''),
(38, 5, '2012-05-16', 123, 'fg', 'ffff', 'ggggg', '333-333-3333', 'VM', '', '', '0000-00-00', '', '', '2012-05-21', '0000-00-00', '', '', 'ENROLLED', 5, ''),
(39, 6, '2012-05-08', 234, 'rt', 'rrrr', 'ttttt', '444-444-4444', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 5, ''),
(40, 1, '0000-00-00', 0, 'fsdg', 'sdag', 'sadg', '123-123-1234', 'BA', 'VM', '', '2012-02-07', 'on', '', '0000-00-00', '2012-02-07', 'FAIL FROM OSDI', 'on', 'FAILED', 9, ''),
(41, 2, '0000-00-00', 0, 'qwr', 'qwr', 'qwr', '123-123-1234', 'LM', 'LM', 'NE', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'FOLLOWUP', 9, ''),
(42, 3, '0000-00-00', 0, 'sadf', 'fsdf', 'sdf', '222-222-2222', 'BA', 'BA', '', '2012-02-22', 'on', '', '0000-00-00', '2012-02-22', 'FAIL FROM OSDI', 'on', 'FAILED', 9, ''),
(43, 4, '0000-00-00', 0, 'dfg', 'dfg', 'dfg', '204 275 4520', 'BA', 'NI', '', '2012-02-23', '', 'HAS NOT YET RESCHEDULED', '0000-00-00', '0000-00-00', '', '', 'FOLLOWUP', 9, ''),
(44, 5, '0000-00-00', 0, '', '', '', '', 'BA', 'UM', '', '2012-02-28', 'on', '', '0000-00-00', '2012-02-28', 'NON COMPLIANCE #3', 'on', 'FAILED', 9, ''),
(45, 8, '2012-03-02', 284, 'A-R', 'Abiel', 'Roche', '204 452 6626', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 6, ''),
(46, 2, '2012-05-14', 123, 'df', 'ddddd', 'fffff', '222-222-2222', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 8, ''),
(48, 4, '2012-05-14', 123, 'ty', 'ttttt', 'yyyyy', '222-222-2222', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 8, 'xmpc1jea4h'),
(47, 3, '2012-05-15', 123, 'ooooo', 'oooo', 'ooooo', '222-222-2222', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 8, ''),
(49, 7, '2012-05-23', 564, 'rt', 'rrrr', 'ttttt', '222-222-2222', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 5, 'kgkt6saxuk'),
(50, 9, '2012-05-15', 0, 'dddd', 'ddd', 'ffff', '222-222-2222', '', '', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 'CONTACT', 6, 'zcp2rlmlws');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(8) NOT NULL AUTO_INCREMENT,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  `post_topic` int(8) NOT NULL,
  `post_by` int(8) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_topic` (`post_topic`),
  KEY `post_by` (`post_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_content`, `post_date`, `post_topic`, `post_by`) VALUES
(1, 'first topic', '2012-04-27 12:27:08', 1, 1),
(2, 'sagafbs sdf', '2012-04-27 12:28:33', 2, 2),
(3, 'dfbgsdfb\r\n', '2012-04-27 12:54:51', 2, 2),
(4, 'dvxd vzsdgszg zsgszd gsz sgs z', '2012-04-27 12:55:00', 2, 2),
(5, 'wgsargsdhsd hsd', '2012-04-27 12:56:04', 2, 2),
(6, 'cfbxdf sdfh sdfh s sdf sd hsd hsd h', '2012-04-27 12:57:01', 2, 2),
(7, 'dxbnxcnfn', '2012-04-27 16:29:00', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(8) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(30) NOT NULL,
  `site_study` varchar(255) NOT NULL,
  `site_address` varchar(255) NOT NULL,
  `site_phone` varchar(30) NOT NULL,
  `site_fax` varchar(30) NOT NULL,
  `site_user` int(8) NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `site_user` (`site_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`site_id`, `site_name`, `site_study`, `site_address`, `site_phone`, `site_fax`, `site_user`) VALUES
(6, 'Vancouver', 'Dry Eye', '123 Fake St.', '111-222-3333', '123-123-1234', 2),
(8, 'dffd', 'fdfd', 'fdfd', '289 597 0106', '905 886 1648', 6),
(9, 'The Winnipeg Clinic', 'DED Study', '425 Saint Mary Avenue,Winnipeg, Manitoba R3C 0N2', '204-957-3390', '204-942-2044', 7),
(5, 'CCCT', 'RA', '8054 Yonge', '289-597-0106', '289-597-0106', 4);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `topic_id` int(8) NOT NULL AUTO_INCREMENT,
  `topic_subject` varchar(255) NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_cat` varchar(8) NOT NULL,
  `topic_by` int(8) NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `topic_cat` (`topic_cat`),
  KEY `topic_by` (`topic_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_subject`, `topic_date`, `topic_cat`, `topic_by`) VALUES
(1, 'first', '2012-04-27 12:27:08', '2', 1),
(2, 'some other', '2012-04-27 12:28:33', '2', 2),
(3, 'vfgn', '2012-04-27 16:29:00', '2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `usersL`
--

CREATE TABLE IF NOT EXISTS `usersL` (
  `usersL_id` int(8) NOT NULL AUTO_INCREMENT,
  `usersL_name` varchar(30) NOT NULL,
  `usersL_pass` varchar(255) NOT NULL,
  `usersL_email` varchar(255) NOT NULL,
  `usersL_date` datetime NOT NULL,
  `usersL_level` int(8) NOT NULL,
  PRIMARY KEY (`usersL_id`),
  UNIQUE KEY `usersL_name` (`usersL_name`),
  UNIQUE KEY `usersL_name_2` (`usersL_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `usersL`
--

INSERT INTO `usersL` (`usersL_id`, `usersL_name`, `usersL_pass`, `usersL_email`, `usersL_date`, `usersL_level`) VALUES
(1, 'admin', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'admin@admin.com', '2012-04-30 13:09:36', 1),
(2, 'user', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'user@user.com', '2012-04-30 13:10:54', 0),
(3, 'otherUser', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'user@user.com', '2012-04-30 15:42:36', 0),
(4, 'illya', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test@test.com', '2012-05-02 14:15:52', 1),
(5, 'BobJoe', '836babddc66080e01d52b8272aa9461c69ee0496', 'hi@there.com', '2012-05-02 14:20:43', 0),
(6, 'oksana', 'c8176b6a462c84c5435af1efff869f56cfff4ea4', 'oksana_to@yahoo.ca', '2012-05-03 19:04:15', 0),
(7, 'Winnepeg', '8bcee9ce06560f1f591c28b9d42333c69833846a', 'test@test.com', '2012-05-04 12:53:05', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
