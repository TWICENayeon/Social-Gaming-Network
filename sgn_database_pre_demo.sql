-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2018 at 11:04 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgn_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `ad_id` int(11) NOT NULL,
  `ad_company` varchar(256) NOT NULL,
  `ad_registration_date` date NOT NULL,
  `ad_registration_time` time NOT NULL,
  `ad_content` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`ad_id`, `ad_company`, `ad_registration_date`, `ad_registration_time`, `ad_content`) VALUES
(1, 'Riot Games', '2018-08-13', '10:35:04', 'Play LoL now for free!');

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `attendee_id` int(11) NOT NULL,
  `attended_event_id` int(11) NOT NULL,
  `registration_date` date NOT NULL,
  `registration_time` time NOT NULL,
  `attendee_role` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`attendee_id`, `attended_event_id`, `registration_date`, `registration_time`, `attendee_role`) VALUES
(1, 1, '2018-08-13', '09:55:41', 'Creator'),
(3, 2, '2018-08-13', '09:55:56', 'Creator'),
(2, 1, '2018-08-13', '09:56:35', 'Attendee'),
(13, 16, '2018-08-19', '14:21:56', 'Creator'),
(10, 17, '2018-08-19', '14:32:55', 'Creator'),
(4, 21, '2018-08-19', '14:56:41', 'Creator'),
(4, 22, '2018-08-19', '15:00:02', 'Creator'),
(1, 21, '2018-09-09', '17:24:49', ' Attendee '),
(1, 23, '2018-10-21', '16:59:54', 'Creator'),
(1, 24, '2018-10-21', '17:02:48', 'Creator'),
(1, 25, '2018-10-21', '17:03:53', 'Creator'),
(1, 26, '2018-10-21', '17:06:58', 'Creator'),
(1, 27, '2018-10-21', '19:59:03', 'Creator'),
(1, 28, '2018-10-27', '22:08:45', 'Creator'),
(2, 28, '2018-10-28', '12:49:46', ' Attendee '),
(1, 29, '2018-11-13', '13:57:58', 'Creator'),
(1, 30, '2018-11-13', '14:05:10', 'Creator'),
(1, 32, '2018-11-30', '10:32:41', ''),
(1, 31, '2018-11-30', '21:54:36', ''),
(1, 33, '2018-12-02', '17:06:32', 'Creator'),
(1, 34, '2018-12-11', '23:10:08', 'Creator'),
(1, 35, '2018-12-11', '23:13:59', 'Creator'),
(6, 34, '2018-12-11', '23:43:57', ''),
(6, 35, '2018-12-11', '23:43:59', ''),
(1, 36, '2018-12-12', '16:15:50', 'Creator'),
(4, 37, '2018-12-12', '16:28:10', 'Creator');

-- --------------------------------------------------------

--
-- Table structure for table `bug_list`
--

CREATE TABLE `bug_list` (
  `bug_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `bug_description` varchar(4096) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bug_list`
--

INSERT INTO `bug_list` (`bug_id`, `reporter_id`, `bug_description`) VALUES
(1, 1, 'No bugs here!');

-- --------------------------------------------------------

--
-- Table structure for table `chat_groups`
--

CREATE TABLE `chat_groups` (
  `chat_id` int(11) NOT NULL,
  `chat_name` varchar(128) NOT NULL,
  `esport_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_groups`
--

INSERT INTO `chat_groups` (`chat_id`, `chat_name`, `esport_id`) VALUES
(1, '', 0),
(7, 'beta\'s League of Legends Chat Room', 1),
(8, '', 0),
(11, '', 0),
(12, '', 0),
(40, '', 0),
(41, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_group_members`
--

CREATE TABLE `chat_group_members` (
  `chat_id` int(11) NOT NULL,
  `chat_member_id` int(11) NOT NULL,
  `new_message` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_group_members`
--

INSERT INTO `chat_group_members` (`chat_id`, `chat_member_id`, `new_message`) VALUES
(1, 1, 0),
(1, 2, 1),
(8, 1, 0),
(8, 5, 0),
(11, 17, 1),
(11, 1, 0),
(12, 10, 1),
(12, 1, 0),
(40, 6, 1),
(40, 1, 0),
(41, 4, 0),
(41, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_group_messages`
--

CREATE TABLE `chat_group_messages` (
  `chat_message_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `chat_writer_id` int(11) NOT NULL,
  `chat_write_date` date NOT NULL,
  `chat_write_time` time NOT NULL,
  `chat_message` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_group_messages`
--

INSERT INTO `chat_group_messages` (`chat_message_id`, `chat_id`, `chat_writer_id`, `chat_write_date`, `chat_write_time`, `chat_message`) VALUES
(1, 1, 1, '2018-11-05', '23:42:17', 'Hello beta'),
(2, 1, 1, '2018-11-05', '23:44:48', 'Bye beta'),
(3, 1, 1, '2018-11-05', '23:45:02', 'Another try Beta'),
(4, 1, 2, '2018-11-05', '23:46:06', 'Why is this not working'),
(5, 1, 2, '2018-11-05', '23:54:55', 'New chat!'),
(6, 1, 1, '2018-11-06', '14:25:00', 'Semi-functional Chat'),
(7, 1, 1, '2018-11-06', '15:37:09', 'Kaboom, baby'),
(8, 1, 1, '2018-11-06', '16:05:44', 'Is real time chat working?'),
(9, 1, 1, '2018-11-06', '16:22:07', 'Is this real time chat actually working now?'),
(11, 1, 1, '2018-11-08', '08:59:05', 'Live chat is live'),
(12, 1, 1, '2018-11-08', '08:59:46', 'Everyone is dead'),
(13, 1, 1, '2018-11-09', '09:34:41', 'Beta should be able to see this message in his window'),
(14, 1, 2, '2018-11-09', '09:36:19', 'Alpha should be able to see this message in alpha window'),
(15, 1, 1, '2018-12-08', '16:29:15', 'Chatting functionality online'),
(19, 12, 1, '2018-12-08', '16:34:00', 'Chatting with India'),
(20, 8, 1, '2018-12-08', '16:42:39', 'Hello echo! The input field should clear!'),
(22, 8, 1, '2018-12-08', '16:55:30', 'Echo\'s new_message status should be set to true'),
(23, 8, 5, '2018-12-08', '17:17:06', 'Hey alpha, you should get a message from me'),
(24, 1, 1, '2018-12-10', '19:16:05', 'chatting functionality back online'),
(25, 1, 1, '2018-12-10', '19:16:05', ''),
(26, 8, 1, '2018-12-10', '20:57:29', 'Echo me'),
(27, 11, 1, '2018-12-10', '21:14:24', 'A new message for \"new\"'),
(28, 11, 1, '2018-12-10', '21:15:25', 'Another new message'),
(29, 11, 1, '2018-12-10', '21:15:47', 'Clear input'),
(30, 11, 1, '2018-12-10', '21:15:59', 'a new input cleared'),
(31, 1, 1, '2018-12-11', '22:56:42', 'Test chat to bob'),
(32, 1, 1, '2018-12-11', '22:57:11', 'Another test chat to bob'),
(33, 12, 1, '2018-12-11', '23:00:38', 'Hopefully chat gets refreshed this time'),
(34, 12, 1, '2018-12-11', '23:01:20', 'One more time'),
(35, 11, 1, '2018-12-11', '23:43:02', 'Test sidebar chat'),
(36, 40, 6, '2018-12-11', '23:57:15', 'Hey alpha, thanks for the friend invite'),
(37, 40, 6, '2018-12-11', '23:57:47', 'Fast refresh'),
(38, 40, 6, '2018-12-11', '23:57:54', 'Very fast'),
(39, 40, 1, '2018-12-12', '16:14:12', 'i hope this works'),
(40, 1, 1, '2018-12-12', '16:23:22', 'Friend chat snek');

-- --------------------------------------------------------

--
-- Table structure for table `esports`
--

CREATE TABLE `esports` (
  `esport_id` int(11) NOT NULL,
  `esport_name` varchar(128) NOT NULL,
  `esport_stream_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esports`
--

INSERT INTO `esports` (`esport_id`, `esport_name`, `esport_stream_name`) VALUES
(1, 'League of Legends', 'Riot Games'),
(2, 'Counter-Strike: Global Offensive', 'ESL_CSGO'),
(3, 'Dota 2', 'ESL_DOTA2'),
(4, 'StarCraft 2', 'ESL_SC2'),
(5, 'Overwatch', 'ESL_Overwatch'),
(6, 'Heroes of the Storm', 'ESL_Heroes');

-- --------------------------------------------------------

--
-- Table structure for table `esport_articles`
--

CREATE TABLE `esport_articles` (
  `article_id` int(11) NOT NULL,
  `esport_id` int(11) NOT NULL,
  `article_title` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `esport_articles`
--

INSERT INTO `esport_articles` (`article_id`, `esport_id`, `article_title`) VALUES
(1, 1, 'Article Title');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(256) NOT NULL,
  `event_description` varchar(1024) DEFAULT NULL,
  `event_start_date` date NOT NULL,
  `event_start_time` time NOT NULL,
  `event_privacy` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `event_start_date`, `event_start_time`, `event_privacy`) VALUES
(1, 'Party @ SGN', 'A party at SGN', '2008-12-18', '20:26:00', 0),
(2, 'Scam @ SGN', 'A scam at SGN', '2008-12-18', '20:26:00', 0),
(4, 'Party 2.0 @ SGN', 'A second private party at SGN', '2018-08-13', '18:00:00', 1),
(5, 'Privacy @ SGN', 'SGN Privacy', '2018-08-17', '09:30:41', 1),
(6, 'new event name', 'new event description', '2018-08-17', '15:30:04', 1),
(16, 'Learning ABCs', 'We learn the ABCs', '2018-08-19', '14:21:56', 0),
(17, 'Event I', 'Event for India', '2018-08-19', '14:32:55', 0),
(21, 'Delta Event', 'Event of Delta', '2018-08-19', '14:56:41', 0),
(22, 'Private Delta Event', 'Private Event of Delta', '2018-08-19', '15:00:02', 1),
(23, 'October 21 16:58', 'asd', '0000-00-00', '16:58:00', 0),
(24, 'oct 21 5 PM ', 'October 21st, 5 PM', '0000-00-00', '22:00:00', 0),
(25, 'oct 21 5:03 PM ', 'October 21st, 5 PM', '0000-00-00', '22:00:00', 0),
(26, 'oct 21 5:06 PM ', 'October 21st, 5 PM', '2018-10-21', '22:00:00', 0),
(27, '8 PM Party', 'Party at 8 PM', '2018-10-21', '20:00:00', 0),
(28, 'New Event Name', 'New Event Description', '2018-11-12', '15:00:00', 0),
(29, 'BRAND NEW TOURNAMENT EVENT', 'NOW WITH A TOURNAMENT', '2018-11-13', '17:00:00', 1),
(30, 'ANOTHER NEW TOURNAMENT EVENT', 'ANOTHER TOURNAMENT', '2018-11-15', '18:00:00', 1),
(31, 'Test Tournament Adding', 'Add Tournament button should show up', '2020-11-21', '20:26:00', 0),
(32, 'Test Event', '', '2018-12-24', '18:00:00', 0),
(33, 'Description Testing', 'Description Input', '2222-02-22', '14:22:00', 0),
(34, 'Test Event for test group', 'Test description for test event for test group', '2222-02-22', '14:22:00', 0),
(35, 'Reset Event Creation Form', 'RESET FORM NOW!!!', '2018-12-12', '00:00:00', 0),
(36, 'Snek party', 'Snek appreciation party', '5555-05-25', '17:55:00', 0),
(37, 'delta squad out', 'Delta squad has received a critical mission from Santa Claus to deliver presents. ', '2019-12-25', '20:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `friendship_id` int(11) NOT NULL,
  `friend_id_1` int(11) NOT NULL,
  `friend_id_2` int(11) NOT NULL,
  `friendship_start_date` date NOT NULL,
  `chat_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`friendship_id`, `friend_id_1`, `friend_id_2`, `friendship_start_date`, `chat_id`, `active`) VALUES
(6, 1, 2, '2018-11-04', 1, 1),
(7, 1, 5, '2018-11-24', 8, 1),
(10, 17, 1, '2018-12-02', 11, 1),
(11, 10, 1, '2018-12-05', 12, 1),
(12, 6, 1, '2018-12-11', 40, 1),
(13, 4, 1, '2018-12-12', 41, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(256) NOT NULL,
  `group_description` varchar(1024) DEFAULT NULL,
  `group_creation_date` date NOT NULL,
  `group_privacy` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_description`, `group_creation_date`, `group_privacy`) VALUES
(1, 'NSS', 'A squad at SGN', '2018-08-12', 0),
(2, 'SGN FRAUD', 'A fraud at SGN', '2018-08-12', 0),
(5, 'Another New Group Name', 'New Group description', '2018-08-17', 0),
(6, 'Neo-neo Group 2', 'My second neo-neo group', '2018-08-17', 1),
(7, 'Pokemon Group', 'All bout Pokemon', '2018-08-17', 1),
(8, 'Learn the ABC', 'learning abc', '2018-08-19', 0),
(9, 'Group I', 'Group for India', '2018-08-19', 0),
(10, 'Delta Group', 'Group of Delta', '2018-08-19', 0),
(11, 'Private Delta Group', 'Private Group of Delta', '2018-08-19', 1),
(12, 'New Test Group', '', '2018-11-30', 0),
(13, 'Test picture upload', '', '2018-11-30', 0),
(14, 'Another picture upload test', '', '2018-11-30', 0),
(15, 'Should work now', '', '2018-11-30', 0),
(16, 'Should work now now', '', '2018-11-30', 0),
(17, 'ddd', '', '2018-12-01', 0),
(18, 'New Group Name', '', '2018-12-11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `group_events`
--

CREATE TABLE `group_events` (
  `hosting_group_id` int(11) NOT NULL,
  `hosted_event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_events`
--

INSERT INTO `group_events` (`hosting_group_id`, `hosted_event_id`) VALUES
(1, 1),
(2, 2),
(1, 4),
(1, 5),
(10, 21),
(11, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(5, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(18, 34),
(18, 35),
(18, 36),
(10, 37);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `owner_type` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `currently_set` tinyint(1) NOT NULL,
  `image_type` int(11) NOT NULL,
  `image_name` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`owner_type`, `owner_id`, `currently_set`, `image_type`, `image_name`) VALUES
(0, 2, 0, 0, 'rockruff.jpg'),
(0, 2, 0, 1, 'ecllipse.PNG'),
(0, 2, 0, 0, 'Charizard.jpg'),
(0, 2, 0, 0, 'Charizard.jpg'),
(1, 1, 0, 0, 'jolteon.jpg'),
(2, 28, 1, 1, 'favorite_pokemons.jpg'),
(0, 1, 0, 1, 'fetch_posts_dash.PNG'),
(0, 1, 0, 1, 'ajax_chat.PNG'),
(0, 1, 0, 1, 'tournament_table.PNG'),
(0, 1, 0, 1, 'tournament_page_two.PNG'),
(0, 1, 0, 1, 'Charizard.jpg'),
(0, 1, 0, 0, 'zorark.png'),
(0, 1, 0, 0, 'fennekin.jpg'),
(0, 1, 0, 0, 'charizard_approves.jpg'),
(0, 1, 0, 0, 'seal.jpg'),
(0, 2, 0, 0, 'charizard_approves.jpg'),
(0, 2, 0, 1, 'tournament_page_two.PNG'),
(0, 2, 0, 0, 'jolteon.jpg'),
(0, 2, 1, 0, 'Arbys_Charizard.jpg'),
(0, 1, 0, 0, 'hanzo.gif'),
(0, 1, 1, 0, '28699259_1816485175079443_2675891289850318410_o.jpg'),
(0, 1, 0, 1, 'xv6_disk_layout.PNG'),
(0, 1, 0, 1, 'Charizard.jpg'),
(0, 1, 0, 0, 'dragon_goblet.jpg'),
(0, 1, 0, 0, 'rockruff.jpg'),
(1, 1, 0, 0, 'structure_guide.PNG'),
(1, 1, 1, 0, 'jolteon.jpg'),
(1, 5, 1, 0, 'favorite_pokemons.jpg'),
(1, 12, 1, 0, 'charizard_approves.jpg'),
(1, 15, 0, 0, '802.11 IEEE.PNG'),
(1, 16, 1, 0, 'lopunny.jpg'),
(0, 2, 1, 1, 'favorite_pokemons.jpg'),
(1, 15, 1, 0, '8values.png'),
(0, 1, 0, 1, 'hanzo.gif'),
(0, 1, 0, 1, 'Charizard.jpg'),
(1, 18, 0, 0, 'tournament_page_two.PNG'),
(1, 18, 0, 0, 'starting_merge.PNG'),
(0, 1, 0, 0, 'fetch_posts_dash.PNG'),
(0, 1, 1, 1, 'rockruff.jpg'),
(1, 18, 1, 0, '28699259_1816485175079443_2675891289850318410_o.jpg'),
(0, 4, 0, 1, '28699259_1816485175079443_2675891289850318410_o.jpg'),
(0, 4, 0, 1, 'backtrace.PNG'),
(0, 4, 0, 1, 'japan.PNG'),
(0, 4, 0, 1, 'rockruff.jpg'),
(0, 4, 0, 1, 'hanzo.gif'),
(0, 4, 0, 1, 'ecllipse.PNG'),
(0, 4, 1, 1, 'hanzo.gif'),
(0, 4, 1, 0, 'charizard_approves.jpg'),
(0, 5, 1, 1, 'backtrace.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `member_id` int(11) NOT NULL,
  `of_group_id` int(11) NOT NULL,
  `membership_role` int(11) NOT NULL,
  `membership_start_date` date NOT NULL,
  `membership_start_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`member_id`, `of_group_id`, `membership_role`, `membership_start_date`, `membership_start_time`) VALUES
(1, 1, 1, '2018-08-12', '20:30:53'),
(3, 2, 1, '2018-08-13', '09:35:26'),
(2, 1, 0, '2018-08-13', '11:06:44'),
(2, 2, 0, '2018-08-13', '11:06:53'),
(1, 5, 1, '2018-08-17', '14:21:55'),
(13, 8, 1, '2018-08-19', '14:07:24'),
(10, 9, 1, '2018-08-19', '14:31:11'),
(4, 10, 1, '2018-08-19', '14:52:57'),
(4, 11, 1, '2018-08-19', '14:58:41'),
(4, 1, 0, '2018-09-01', '10:20:16'),
(2, 5, 0, '2018-11-07', '16:22:45'),
(3, 1, 1, '2018-11-08', '16:13:49'),
(1, 12, 0, '2018-11-30', '22:31:31'),
(1, 13, 1, '2018-11-30', '22:34:11'),
(1, 14, 1, '2018-11-30', '22:35:04'),
(1, 15, 1, '2018-11-30', '22:35:49'),
(1, 16, 1, '2018-11-30', '22:37:44'),
(1, 17, 1, '2018-12-01', '15:16:10'),
(1, 2, 0, '2018-12-02', '18:19:40'),
(17, 1, 0, '2018-12-03', '11:01:17'),
(9, 5, 0, '2018-12-05', '10:36:17'),
(9, 15, 0, '2018-12-05', '10:45:19'),
(1, 18, 1, '2018-12-11', '23:02:03'),
(6, 18, 1, '2018-12-11', '23:43:30'),
(6, 2, 0, '2018-12-11', '23:53:54'),
(6, 10, 0, '2018-12-12', '00:15:36'),
(1, 10, 0, '2018-12-12', '16:23:11'),
(4, 5, 0, '2018-12-12', '16:24:07');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_type` int(11) NOT NULL,
  `invitation_to_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `message` varchar(4096) NOT NULL,
  `resolved_status` tinyint(4) DEFAULT '0',
  `date_created` date NOT NULL,
  `time_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_type`, `invitation_to_id`, `recipient_id`, `message`, `resolved_status`, `date_created`, `time_created`) VALUES
(1, 1, 1, 3, 'COME JOIN -SGN SQUAD-', 0, '2018-11-08', '14:54:16'),
(8, 1, 10, 1, 'COME JOIN -DELTA GROUP-', 1, '2018-11-20', '13:48:58'),
(10, 1, 1, 1, 'COME JOIN -SGN SQUAD-', 1, '2018-11-20', '13:52:11'),
(12, 0, 5, 1, 'echo would like to be your friend', 1, '2018-11-24', '11:38:37'),
(16, 0, 1, 17, 'alpha wants to be your friend', 1, '2018-12-02', '20:33:56'),
(17, 0, 1, 17, 'alpha wants to be your friend', 1, '2018-12-02', '20:37:38'),
(20, 0, 1, 17, 'alpha wants to be your friend', 1, '2018-12-02', '20:52:08'),
(21, 0, 1, 17, 'alpha wants to be your friend', 1, '2018-12-02', '20:55:04'),
(22, 2, 17, 17, 'new has declined your friend request', 1, '2018-12-02', '20:55:18'),
(23, 0, 1, 17, 'alpha wants to be your friend', 1, '2018-12-02', '20:57:34'),
(24, 2, 17, 1, 'new has declined your friend request', 1, '2018-12-02', '20:57:54'),
(26, 2, 17, 1, 'new has accepted your friend request', 1, '2018-12-02', '21:00:39'),
(28, 0, 1, 17, 'alpha wants to be your friend', 1, '2018-12-02', '21:40:42'),
(29, 2, 17, 1, 'new has accepted your friend request', 1, '2018-12-02', '21:40:57'),
(30, 1, 1, 17, 'Come join -NSS-', 1, '2018-12-03', '10:52:00'),
(31, 1, 5, 9, 'Come join -Another New Group Name-', 1, '2018-12-05', '10:29:37'),
(32, 1, 5, 9, 'Come join -Another New Group Name-', 1, '2018-12-05', '10:32:06'),
(33, 1, 5, 9, 'Come join -Another New Group Name-', 1, '2018-12-05', '10:34:36'),
(34, 1, 5, 10, 'Come join -Another New Group Name-', 1, '2018-12-05', '10:37:14'),
(35, 1, 17, 9, 'Come join -ddd-', 1, '2018-12-05', '10:41:28'),
(36, 1, 9, 1, 'Come join -Group I-', 1, '2018-12-05', '10:42:35'),
(37, 0, 1, 10, 'alpha wants to be your friend', 1, '2018-12-05', '10:44:08'),
(38, 2, 10, 1, 'india has accepted your friend request', 1, '2018-12-05', '10:44:23'),
(39, 1, 15, 9, 'Come join -Should work now-', 1, '2018-12-05', '10:45:01'),
(40, 1, 13, 9, 'Come join -Test picture upload-', 1, '2018-12-05', '10:45:45'),
(41, 1, 1, 9, 'Come join -NSS-', 0, '2018-12-05', '10:50:39'),
(42, 2, 1, 5, 'alpha has declined your friend request', 0, '2018-12-11', '17:13:27'),
(43, 1, 18, 10, 'Come join -Alpha Testing group-', 0, '2018-12-11', '23:02:40'),
(44, 0, 1, 6, 'alpha wants to be your friend', 1, '2018-12-11', '23:30:55'),
(45, 1, 18, 6, 'Come join -Alpha Testing group-', 1, '2018-12-11', '23:31:45'),
(46, 2, 6, 1, 'foxtrot has declined your friend request', 0, '2018-12-11', '23:44:36'),
(47, 0, 1, 6, 'alpha wants to be your friend', 1, '2018-12-11', '23:44:56'),
(48, 2, 6, 1, 'foxtrot has accepted your friend request', 0, '2018-12-11', '23:53:05'),
(49, 1, 18, 10, 'Come join -New Group Name-', 0, '2018-12-12', '16:16:13'),
(50, 0, 1, 4, 'alpha wants to be your friend', 1, '2018-12-12', '16:21:26'),
(51, 1, 5, 4, 'Come join -Another New Group Name-', 1, '2018-12-12', '16:23:53'),
(52, 2, 4, 1, 'delta has accepted your friend request', 0, '2018-12-12', '16:24:12');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `parent_post_id` int(11) NOT NULL,
  `poster_id` int(11) NOT NULL,
  `wall_type` int(11) NOT NULL,
  `wall_owner_id` int(11) NOT NULL,
  `post_text` varchar(1024) NOT NULL,
  `post_date` date NOT NULL,
  `post_time` time NOT NULL,
  `post_votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `parent_post_id`, `poster_id`, `wall_type`, `wall_owner_id`, `post_text`, `post_date`, `post_time`, `post_votes`) VALUES
(13, 0, 1, 0, 1, 'Hello, World! This is the very first post on SGN', '2018-08-16', '23:46:42', 0),
(14, 0, 1, 1, 1, 'Alpha post on SGN SQUAD group page', '2018-08-16', '23:49:27', 0),
(15, 0, 1, 2, 1, 'Alpha post on Party @ SGN group page', '2018-08-16', '23:53:09', 0),
(17, 0, 1, 0, 3, 'Hello Charlie the Traitor', '2018-08-16', '23:57:37', 0),
(18, 0, 1, 2, 1, 'Alpha second post on page', '2018-08-17', '10:39:05', 0),
(19, 0, 1, 1, 1, 'Alpha second post on SGN  SQUAD page', '2018-08-17', '10:59:44', 0),
(20, 0, 3, 0, 3, 'Alpha, it is a pleasure to meet you', '2018-08-17', '11:00:07', 0),
(21, 0, 3, 1, 2, 'This is my Fraud!', '2018-08-17', '11:00:17', 0),
(22, 0, 3, 2, 2, 'Time to Scam!', '2018-08-17', '11:00:25', 0),
(23, 0, 3, 1, 1, 'Charlie was here   >:P', '2018-08-17', '11:00:41', 0),
(24, 0, 3, 2, 1, 'This party is a sham >:P', '2018-08-17', '11:00:53', 0),
(25, 0, 1, 2, 6, 'Wow, new event page first post', '2018-08-17', '15:30:21', 0),
(26, 0, 2, 1, 1, 'Beta post', '2018-08-17', '16:02:09', 0),
(27, 0, 2, 2, 4, 'Party 2.0 at SGN by Beta', '2018-08-17', '16:03:21', 0),
(28, 0, 13, 1, 8, 'A', '2018-08-19', '14:07:36', 0),
(32, 0, 13, 2, 16, 'ABC learning time!', '2018-08-19', '14:27:09', 0),
(33, 13, 13, 0, 1, 'Hey alpha, abc-man here', '2018-08-19', '14:27:36', 0),
(34, 0, 10, 2, 17, 'Event I first post', '2018-08-19', '14:33:04', 0),
(35, 0, 1, 2, 17, 'Alpha post', '2018-08-19', '14:38:53', 0),
(36, 0, 4, 2, 21, 'Delta post on Delta event', '2018-08-19', '14:56:48', 0),
(37, 0, 1, 2, 21, 'Alpha post on Delta event', '2018-08-19', '14:57:05', 0),
(38, 13, 1, 0, 1, 'india', '2018-09-09', '16:28:46', 0),
(41, 0, 1, 0, 10, 'Alpha post to India page', '2018-09-09', '16:41:19', 0),
(42, 0, 1, 0, 1, 'Type stuff', '2018-10-28', '15:47:12', 0),
(43, 0, 1, 0, 3, 'Type stuff', '2018-10-28', '15:47:28', 0),
(44, 0, 1, 0, 2, 'Type a post', '2018-11-04', '16:50:22', 0),
(45, 0, 1, 2, 25, 'This event has been long past :(', '2018-11-09', '11:25:01', 0),
(46, 0, 1, 0, 1, 'New Alpha Post on November 9th', '2018-11-09', '17:45:32', 0),
(47, 46, 1, 0, 1, 'A reply to my post on Nov 9th', '2018-11-09', '17:45:55', 0),
(48, 46, 2, 0, 1, 'Beta Reply on November 9th', '2018-11-09', '17:48:19', 0),
(49, 26, 2, 1, 1, 'Reply to Beta post', '2018-11-09', '17:58:12', 0),
(50, 24, 2, 2, 1, 'This party is not a sham >:(', '2018-11-09', '18:03:52', 0),
(51, 46, 1, 0, 1, 'Replying to my own post', '2018-11-10', '15:33:13', 0),
(52, 0, 1, 2, 1, 'No post', '2018-11-10', '16:47:45', 0),
(53, 0, 1, 2, 1, 'What the heck', '2018-11-10', '16:48:20', 0),
(54, 0, 1, 0, 1, 'Brand new post!', '2018-11-10', '16:52:22', 0),
(55, 0, 1, 0, 1, 'Another new post', '2018-11-10', '17:01:16', 0),
(56, 55, 1, 0, 1, 'Reply to \"Another new post\"', '2018-11-10', '17:14:19', 0),
(57, 53, 1, 2, 1, 'What', '2018-11-11', '12:25:29', 0),
(58, 53, 1, 2, 1, 'the', '2018-11-11', '12:25:33', 0),
(59, 53, 1, 2, 1, 'heck', '2018-11-11', '12:25:39', 0),
(60, 0, 1, 2, 28, 'New post for \"New Event Name\"', '2018-11-11', '15:21:58', 0),
(61, 44, 1, 0, 2, 'Reply to may own post', '2018-11-11', '23:01:56', 0),
(62, 0, 1, 0, 2, 'Another new post', '2018-11-11', '23:02:14', 0),
(64, 0, 2, 0, 1, 'Tester Beta Here', '2018-11-17', '09:08:46', 0),
(65, 0, 18, 4, 18, 'What\'s going on', '2018-11-17', '21:58:02', 0),
(67, 0, 18, 0, 18, 'What\'s curr', '2018-11-17', '22:07:06', 0),
(68, 0, 18, 0, 18, 'Another\'s another post!', '2018-11-17', '22:17:32', 0),
(69, 0, 18, 0, 18, 'Yet another one!', '2018-11-17', '22:18:41', 0),
(70, 0, 18, 0, 18, 'Why the alert?', '2018-11-17', '22:19:07', 0),
(71, 0, 18, 0, 18, 'No more alerts', '2018-11-17', '22:19:47', 0),
(72, 0, 1, 0, 1, 'Waluigi Dream is Dead', '2018-11-20', '10:51:42', 0),
(73, 0, 2, 0, 2, 'Test post', '2018-11-20', '11:46:53', 0),
(74, 0, 1, 0, 1, 'Are you sure', '2018-11-20', '14:43:34', 0),
(81, 0, 1, 0, 1, 'Yes, I am sure', '2018-11-21', '12:48:05', 0),
(82, 0, 1, 0, 1, 'Wow, what the heck', '2018-11-21', '12:50:56', 0),
(83, 82, 1, 0, 1, 'undefined', '2018-11-21', '13:04:05', 0),
(84, 82, 1, 0, 1, 'undefined', '2018-11-21', '13:06:28', 0),
(85, 82, 1, 0, 1, 'undefined', '2018-11-21', '13:07:26', 0),
(86, 82, 1, 0, 1, 'undefined', '2018-11-21', '13:08:20', 0),
(87, 82, 1, 0, 1, 'Work again', '2018-11-21', '13:08:42', 0),
(88, 81, 1, 0, 1, 'Dynamic Replying', '2018-11-22', '19:05:22', 0),
(89, 0, 1, 0, 1, 'Hello Vinny', '2018-11-22', '20:08:55', 0),
(90, 89, 1, 0, 1, 'What whsat', '2018-11-22', '20:09:04', 0),
(91, 82, 1, 0, 1, 'What', '2018-11-22', '21:04:35', 0),
(92, 89, 1, 0, 1, 'What the heck', '2018-11-23', '14:50:26', 0),
(93, 89, 1, 0, 1, 'Why does this work?', '2018-11-23', '14:55:30', 0),
(95, 0, 1, 0, 1, 'New createPost function works', '2018-11-27', '20:03:49', 0),
(96, 95, 1, 0, 1, 'New createPost function for reply works', '2018-11-27', '20:04:09', 0),
(97, 0, 1, 0, 1, 'Still working', '2018-11-27', '20:23:19', 0),
(98, 97, 1, 0, 1, 'Again, still working', '2018-11-27', '20:23:27', 0),
(99, 0, 1, 0, 1, 'Revert working', '2018-11-27', '20:26:08', 0),
(100, 99, 1, 0, 1, 'Revert reply works', '2018-11-27', '20:26:17', 0),
(119, 0, 1, 2, 31, 'What the Post', '2018-11-27', '23:26:31', 0),
(120, 0, 1, 2, 31, 'Scattered', '2018-11-27', '23:27:04', 0),
(121, 0, 1, 2, 31, 'Why is this not working?', '2018-11-27', '23:28:30', 0),
(122, 0, 1, 2, 31, 'Inserting into body', '2018-11-27', '23:29:29', 0),
(131, 0, 1, 0, 1, 'App', '2018-11-28', '12:15:42', 0),
(132, 131, 1, 0, 1, 'App reply', '2018-11-28', '12:15:50', 0),
(134, 0, 1, 0, 1, 'Creating post on own wall', '2018-12-01', '22:26:06', 0),
(138, 0, 1, 0, 1, 'Alpha\'s post on alpha\'s wall', '2018-12-01', '22:33:36', 0),
(139, 0, 1, 0, 2, 'Alpha\'s post on Bob\'s wall', '2018-12-01', '22:33:57', 0),
(140, 138, 1, 0, 1, 'Alpha\'s reply to Alpha\'s Post on Alpha\'s Wall', '2018-12-02', '16:01:42', 0),
(141, 134, 1, 0, 1, 'The box should clear when I reply', '2018-12-02', '16:05:14', 0),
(142, 0, 1, 0, 17, 'Hello \"new\"!', '2018-12-02', '18:28:34', 0),
(143, 0, 1, 0, 17, 'New post on new wall', '2018-12-02', '19:16:41', 0),
(144, 95, 1, 0, 1, 'Waluigi dream is dead', '2018-12-02', '19:20:24', 0),
(145, 0, 1, 0, 7, 'Posting on gamma\'s dashboard that was loaded through friends list', '2018-12-08', '13:18:42', 0),
(146, 0, 1, 2, 32, 'Event Post!', '2018-12-11', '17:14:17', 0),
(147, 0, 1, 2, 32, 'Another Event Post!', '2018-12-11', '17:15:39', 0),
(148, 0, 1, 2, 32, 'Third event post!', '2018-12-11', '17:16:31', 0),
(149, 0, 1, 2, 32, 'Fourth event post!', '2018-12-11', '17:17:14', 0),
(150, 0, 1, 2, 32, 'Tournament Post', '2018-12-11', '22:02:58', 0),
(151, 0, 1, 0, 1, 'Testing post', '2018-12-11', '22:55:56', 0),
(152, 151, 1, 0, 1, 'Testing Reply to testing post', '2018-12-11', '22:56:06', 0),
(153, 64, 1, 0, 1, 'Testing on Bob\'s post on my wall', '2018-12-11', '22:56:25', 0),
(154, 0, 1, 2, 35, 'Event test post', '2018-12-11', '23:24:46', 0),
(156, 155, 1, 0, 6, 'TEST REPLY TO FOXHOUND', '2018-12-11', '23:31:19', 0),
(157, 0, 1, 0, 1, 'www.facebook.com', '2018-12-12', '14:29:09', 0),
(158, 157, 1, 0, 1, 'I like sneks', '2018-12-12', '16:11:27', 0),
(159, 0, 1, 0, 1, 'More sneks', '2018-12-12', '16:11:43', 0),
(160, 0, 1, 2, 36, 'I hope event posts work snek~~', '2018-12-12', '16:20:51', 0),
(161, 0, 1, 0, 4, 'Sneks have landed from the plane', '2018-12-12', '16:22:54', 0),
(162, 0, 4, 0, 1, 'Delta squad devotes its existence to our snek overlords.', '2018-12-12', '16:28:54', 0),
(163, 0, 5, 0, 5, 'echo . . . echo ... ec', '2018-12-12', '16:58:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_votes`
--

CREATE TABLE `post_votes` (
  `voter_id` int(11) NOT NULL,
  `voted_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post_votes`
--

INSERT INTO `post_votes` (`voter_id`, `voted_id`, `value`) VALUES
(1, 26, 1),
(1, 24, 1),
(1, 74, 1),
(1, 64, 1),
(1, 56, 1),
(1, 78, 1),
(1, 79, 1),
(1, 87, 1),
(1, 120, 1),
(1, 121, 1),
(1, 83, 1),
(1, 89, 1),
(1, 99, 1),
(1, 155, 1),
(1, 154, 1),
(1, 160, 1);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `requestor_id` int(11) NOT NULL,
  `requestor_username` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`owner_id`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE `tournaments` (
  `tournament_id` int(11) NOT NULL,
  `host_event_id` int(11) NOT NULL,
  `tournament_name` varchar(1024) NOT NULL,
  `tournament_date` date NOT NULL,
  `tournament_time` time NOT NULL,
  `started` tinyint(1) NOT NULL,
  `twitch_stream` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`tournament_id`, `host_event_id`, `tournament_name`, `tournament_date`, `tournament_time`, `started`, `twitch_stream`) VALUES
(5, 28, 'New Tournament', '2018-10-28', '15:30:00', 1, ''),
(6, 30, 'Tournament Arc', '2018-11-15', '19:00:00', 0, ''),
(7, 29, 'TOURNAMENT ARC EP 2', '2018-11-13', '18:00:00', 0, ''),
(8, 31, '222', '2222-02-22', '14:22:00', 1, 'twitchplayspokemon'),
(71, 32, 'iou', '2222-02-22', '14:22:00', 1, 'twitchplaysdesertgolf'),
(72, 36, 'Snek Battle- sneks only', '0000-00-00', '18:00:00', 1, 'twitchplayspokemon');

-- --------------------------------------------------------

--
-- Table structure for table `tournament_matches`
--

CREATE TABLE `tournament_matches` (
  `match_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `relative_match_id` int(11) NOT NULL,
  `round` int(11) NOT NULL,
  `winner` int(1) NOT NULL,
  `participant_1_id` int(11) DEFAULT NULL,
  `participant_2_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tournament_matches`
--

INSERT INTO `tournament_matches` (`match_id`, `tournament_id`, `relative_match_id`, `round`, `winner`, `participant_1_id`, `participant_2_id`) VALUES
(1, 5, 1, 1, 1, 1, 2),
(2, 5, 2, 1, 0, 3, 4),
(3, 5, 1, 3, 0, NULL, 5),
(4, 5, 1, 2, 0, 1, NULL),
(13, 8, 1, 1, 3, 3, 5),
(14, 8, 2, 1, 1, 1, 2),
(15, 8, 1, 3, 1, 1, 4),
(16, 8, 1, 2, 1, 3, 1),
(17, 8, 0, 0, 0, 1, NULL),
(18, 71, 1, 1, 1, 1, 4),
(19, 71, 2, 1, 2, 3, 2),
(20, 71, 1, 2, 1, 1, 2),
(21, 71, 0, 0, 0, 1, NULL),
(22, 72, 1, 1, 1, 1, 4),
(23, 72, 2, 1, 2, 3, 2),
(24, 72, 1, 2, 1, 1, 2),
(25, 72, 0, 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tournament_participants`
--

CREATE TABLE `tournament_participants` (
  `tournament_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tournament_participants`
--

INSERT INTO `tournament_participants` (`tournament_id`, `participant_id`, `ordering`) VALUES
(5, 1, 1),
(5, 2, 2),
(5, 3, 3),
(5, 4, 4),
(5, 5, 5),
(6, 1, 1),
(8, 2, 4),
(8, 3, 1),
(8, 1, 3),
(8, 4, 5),
(8, 5, 2),
(71, 2, 4),
(71, 3, 3),
(71, 4, 2),
(71, 1, 1),
(72, 1, 1),
(72, 2, 4),
(72, 3, 3),
(72, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `creation_date` date NOT NULL,
  `posts_articles` tinyint(1) NOT NULL,
  `online` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `first_name`, `last_name`, `creation_date`, `posts_articles`, `online`) VALUES
(1, 'boomalpha@email.com', 'alpha', 'alpha', 'neo', 'alpha', '2018-08-12', 1, 0),
(2, 'beta@mail.com', 'bob', 'ateb', 'Bet', 'A', '2018-08-12', 1, 0),
(3, 'charlie@mail.com', 'Charlie', 'Eilrahc', 'Char', 'Lie', '2018-08-12', 1, 0),
(4, 'delta@mail.com', 'snek 2.0', 'atled', 'snek', '2.o', '2018-08-13', 0, 0),
(5, 'echo@mail.com', 'echo', 'ohce', 'Ech', 'O', '2018-08-13', 0, 0),
(6, 'foxtrot@mail.com', 'foxtrot', 'tortxof', 'Fox', 'Trot', '2018-08-13', 0, 0),
(7, 'gamma@mail.com', 'gamma', 'ammag', 'Gam', 'Ma', '2018-08-13', 0, 0),
(8, 'golf@mail.com', 'golf', 'flog', 'Gol', 'F', '2018-08-13', 0, 0),
(9, 'hotel@mail.com', 'hotel', 'letoh', 'Ho', 'Tel', '2018-08-13', 0, 0),
(10, 'india@mail.com', 'india', 'aidni', 'Ind', 'Ia', '2018-08-13', 0, 0),
(13, 'abc@mail.com', 'abc', 'cba', 'ab', 'c', '2018-08-19', 0, 0),
(14, 'bub@mail.com', 'bub', 'bub', 'bub', 'bub', '2018-09-09', 0, 0),
(17, 'new@mail.com', 'new', 'new', 'new', 'new', '2018-11-17', 0, 0),
(18, 'another@mail.com', 'another', 'another', 'Anthony', 'Theo', '2018-11-17', 0, 0),
(19, 'new_user@mail.com', 'new_user', 'new_user', 'new', 'user', '2018-11-20', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD KEY `attendee_id` (`attendee_id`),
  ADD KEY `attended_event_id` (`attended_event_id`);

--
-- Indexes for table `bug_list`
--
ALTER TABLE `bug_list`
  ADD PRIMARY KEY (`bug_id`),
  ADD KEY `reporter_id` (`reporter_id`);

--
-- Indexes for table `chat_groups`
--
ALTER TABLE `chat_groups`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `chat_group_members`
--
ALTER TABLE `chat_group_members`
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `chat_member_id` (`chat_member_id`);

--
-- Indexes for table `chat_group_messages`
--
ALTER TABLE `chat_group_messages`
  ADD PRIMARY KEY (`chat_message_id`),
  ADD KEY `chat_writer_id` (`chat_writer_id`),
  ADD KEY `chat_group_id` (`chat_id`);

--
-- Indexes for table `esports`
--
ALTER TABLE `esports`
  ADD PRIMARY KEY (`esport_id`,`esport_name`);

--
-- Indexes for table `esport_articles`
--
ALTER TABLE `esport_articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`friendship_id`),
  ADD KEY `friend_id_1` (`friend_id_1`),
  ADD KEY `friend_id_2` (`friend_id_2`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `group_events`
--
ALTER TABLE `group_events`
  ADD KEY `hosting_group_id` (`hosting_group_id`),
  ADD KEY `hosted_event_id` (`hosted_event_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD KEY `owner_id_fk` (`owner_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD KEY `member_id` (`member_id`),
  ADD KEY `of_group_id` (`of_group_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `poster_id` (`poster_id`),
  ADD KEY `wall_owner_id` (`wall_owner_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requestor_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`tournament_id`),
  ADD KEY `host_event_id` (`host_event_id`);

--
-- Indexes for table `tournament_matches`
--
ALTER TABLE `tournament_matches`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `tournament_id` (`tournament_id`),
  ADD KEY `participant_1_id` (`participant_1_id`),
  ADD KEY `participant_2_id` (`participant_2_id`);

--
-- Indexes for table `tournament_participants`
--
ALTER TABLE `tournament_participants`
  ADD KEY `participant_id` (`participant_id`),
  ADD KEY `the_tournament_id` (`tournament_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `USERS_USERNAME_EMAIL` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bug_list`
--
ALTER TABLE `bug_list`
  MODIFY `bug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat_groups`
--
ALTER TABLE `chat_groups`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `chat_group_messages`
--
ALTER TABLE `chat_group_messages`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `esports`
--
ALTER TABLE `esports`
  MODIFY `esport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `esport_articles`
--
ALTER TABLE `esport_articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `friendship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `tournament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tournament_matches`
--
ALTER TABLE `tournament_matches`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `attended_event_id` FOREIGN KEY (`attended_event_id`) REFERENCES `events` (`event_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `attendee_id` FOREIGN KEY (`attendee_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `bug_list`
--
ALTER TABLE `bug_list`
  ADD CONSTRAINT `reporter_id` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `chat_group_members`
--
ALTER TABLE `chat_group_members`
  ADD CONSTRAINT `chat_id` FOREIGN KEY (`chat_id`) REFERENCES `chat_groups` (`chat_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_member_id` FOREIGN KEY (`chat_member_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `chat_group_messages`
--
ALTER TABLE `chat_group_messages`
  ADD CONSTRAINT `chat_group_id` FOREIGN KEY (`chat_id`) REFERENCES `chat_groups` (`chat_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_writer_id` FOREIGN KEY (`chat_writer_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `friend_id_1` FOREIGN KEY (`friend_id_1`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `friend_id_2` FOREIGN KEY (`friend_id_2`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `group_events`
--
ALTER TABLE `group_events`
  ADD CONSTRAINT `hosted_event_id` FOREIGN KEY (`hosted_event_id`) REFERENCES `events` (`event_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hosting_group_id` FOREIGN KEY (`hosting_group_id`) REFERENCES `groups` (`group_id`) ON UPDATE CASCADE;

--
-- Constraints for table `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `member_id` FOREIGN KEY (`member_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `of_group_id` FOREIGN KEY (`of_group_id`) REFERENCES `groups` (`group_id`) ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `recipient_id` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `poster_id` FOREIGN KEY (`poster_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD CONSTRAINT `host_event_id` FOREIGN KEY (`host_event_id`) REFERENCES `events` (`event_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tournament_matches`
--
ALTER TABLE `tournament_matches`
  ADD CONSTRAINT `participant_1_id` FOREIGN KEY (`participant_1_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_2_id` FOREIGN KEY (`participant_2_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`tournament_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tournament_participants`
--
ALTER TABLE `tournament_participants`
  ADD CONSTRAINT `participant_id` FOREIGN KEY (`participant_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `the_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`tournament_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
