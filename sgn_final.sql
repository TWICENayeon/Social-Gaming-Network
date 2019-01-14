-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2019 at 04:28 PM
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
(20, 1, '2018-12-12', '22:19:55', 'Creator'),
(21, 1, '2018-12-12', '23:15:32', ''),
(23, 1, '2018-12-12', '23:38:13', ''),
(22, 1, '2018-12-12', '23:38:45', ''),
(20, 2, '2018-10-09', '10:00:00', 'Creator');

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
(2, '', 0),
(3, '', 0),
(4, '', 0),
(5, '', 0);

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
(0, 21, 0),
(0, 20, 0),
(2, 21, 1),
(2, 20, 0),
(3, 22, 1),
(3, 20, 0),
(4, 20, 0),
(4, 24, 0),
(5, 20, 0),
(5, 23, 0);

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
(0, 2, 21, '2018-12-12', '23:58:43', 'Hello Kyle'),
(0, 3, 22, '2018-12-12', '23:59:24', 'Yo Kyle'),
(0, 2, 20, '2018-12-13', '07:34:37', 'Hey There :)'),
(0, 3, 20, '2018-12-13', '07:34:47', 'What\'s up?'),
(0, 3, 22, '2018-12-13', '07:37:57', 'Nothing much, how are you?'),
(0, 2, 20, '2018-12-13', '08:20:44', 'Let us watch TwitchPlaysPokemon'),
(0, 3, 20, '2018-12-13', '08:25:38', 'I am good');

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
(1, 'First Tournament', 'Let us celebrate with the first event with a Christmas Eve tournament!', '2018-12-24', '17:00:00', 0),
(2, 'Past event', 'All in the past', '2018-10-10', '10:00:00', 0);

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
(1, 21, 20, '2018-12-12', 2, 1),
(2, 22, 20, '2018-12-12', 3, 1),
(3, 20, 24, '2018-12-13', 4, 1),
(4, 20, 23, '2018-12-13', 5, 1);

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
(1, 'Cool Guys of SGN', '', '2018-12-12', 0),
(2, 'Pineapple Corp', '', '2018-12-12', 0);

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
(1, 1);

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
(0, 20, 0, 1, 'blueprint_sun.jpg'),
(1, 1, 0, 0, 'blueprint_sun.jpg'),
(0, 20, 0, 0, 'blueprint_sun.jpg'),
(0, 20, 1, 0, 'cow.jpg'),
(0, 20, 1, 1, 'cow.jpg'),
(0, 23, 1, 0, 'tropical.jpg'),
(0, 23, 1, 1, 'blueprint_sun.jpg'),
(0, 22, 1, 1, 'blueprint_sun.jpg'),
(0, 22, 1, 0, 'synthwave-cover.jpg'),
(1, 2, 1, 0, 'tropical.jpg'),
(0, 21, 1, 0, 'lion.jpg'),
(0, 22, 0, 0, ''),
(1, 3, 1, 0, 'blueprint_sun.jpg'),
(0, 24, 1, 1, 'blueprint_sun.jpg'),
(0, 24, 1, 0, 'blueprint_sun.jpg'),
(1, 1, 1, 0, 'lion.jpg');

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
(20, 1, 1, '2018-12-12', '22:17:46'),
(21, 1, 0, '2018-12-12', '23:15:27'),
(22, 1, 1, '2018-12-12', '23:34:49'),
(23, 2, 1, '2018-12-12', '23:37:15'),
(23, 1, 0, '2018-12-12', '23:38:04'),
(20, 2, 0, '2018-12-13', '08:26:31');

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
(2, 1, 1, 21, 'Come join -Pioneers of SGN-', 1, '2018-12-12', '23:13:34'),
(3, 2, 20, 21, 'kyleChang has accepted your friend request', 1, '2018-12-12', '23:13:52'),
(7, 1, 2, 20, 'Come join -Pineapple Corp-', 1, '2018-12-12', '23:37:23'),
(8, 1, 1, 23, 'Come join -Pioneers of SGN-', 1, '2018-12-12', '23:37:52'),
(9, 0, 20, 22, 'kyleChang wants to be your friend', 1, '2018-12-12', '23:52:44'),
(10, 0, 20, 21, 'kyleChang wants to be your friend', 1, '2018-12-12', '23:52:54'),
(11, 0, 23, 20, 'sAhmed wants to be your friend', 1, '2018-12-12', '23:53:15'),
(12, 2, 21, 20, 'kKim has accepted your friend request', 1, '2018-12-12', '23:53:34'),
(13, 0, 20, 21, 'kyleChang wants to be your friend', 1, '2018-12-12', '23:56:41'),
(14, 2, 21, 20, 'kKim has accepted your friend request', 1, '2018-12-12', '23:56:54'),
(15, 2, 22, 20, 'dWong has accepted your friend request', 1, '2018-12-12', '23:59:18'),
(16, 0, 24, 20, 'tester wants to be your friend', 1, '2018-12-13', '08:19:05'),
(17, 1, 1, 24, 'Come join -Cool Guys of SGN-', 0, '2018-12-13', '08:21:54'),
(18, 2, 20, 24, 'kChang has accepted your friend request', 0, '2018-12-13', '08:26:10'),
(19, 2, 20, 23, 'kChang has accepted your friend request', 0, '2018-12-13', '08:26:20');

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
(1, 0, 20, 0, 20, 'kChang\'s very first post!', '2018-12-12', '22:11:16', 0),
(2, 1, 20, 0, 20, ':o What an accomplishment', '2018-12-12', '22:11:31', 0),
(3, 0, 20, 2, 1, 'Event post', '2018-12-12', '23:02:02', 0),
(4, 0, 20, 0, 21, 'Hello Kim!', '2018-12-12', '23:14:02', 0),
(5, 4, 20, 0, 21, 'Replying on Kim\'s wall', '2018-12-12', '23:14:35', 0),
(6, 0, 22, 0, 22, 'Is this working?', '2018-12-12', '23:35:11', 0),
(7, 0, 22, 0, 20, 'Hey kyle!', '2018-12-12', '23:35:26', 0),
(8, 0, 23, 0, 20, ':o', '2018-12-12', '23:36:06', 0),
(9, 0, 21, 0, 21, 'My own post', '2018-12-12', '23:58:17', 0),
(10, 0, 22, 2, 1, 'This tournament will be hype!', '2018-12-13', '00:08:17', 0),
(11, 0, 24, 0, 24, 'Hey there', '2018-12-13', '08:18:37', 0),
(12, 11, 24, 0, 24, 'Hey Hey there', '2018-12-13', '08:18:47', 0),
(13, 0, 24, 0, 20, 'Hey kChang', '2018-12-13', '08:19:21', 0);

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
(20, 1, 1),
(22, 7, 1),
(24, 12, 1),
(20, 13, 1);

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
(1, 1, 'Christmas Eve Tournament', '2018-12-24', '18:00:00', 1, 'twitchplayspokemon');

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
(1, 1, 1, 1, 22, 22, 23),
(2, 1, 2, 1, 20, 20, 21),
(3, 1, 1, 2, 20, 22, 20),
(4, 1, 0, 0, 0, 20, NULL);

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
(1, 20, 3),
(1, 21, 4),
(1, 23, 2),
(1, 22, 1);

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
(20, 'kChang@mail.com', 'alpha', 'password', 'Kyle', 'Chang', '2018-12-12', 0, 0),
(21, 'kKim@mail.com', 'kKim', 'password', 'Kevin', 'Kim', '2018-12-12', 0, 0),
(22, 'dWong@mail.com', 'dWong', 'password', 'Deryck', 'Wong', '2018-12-12', 0, 0),
(23, 'sahmed@mail.com', 'sAhmed', 'password', 'Saif', 'Ahmed', '2018-12-12', 0, 0),
(24, 'tester@mail', 'tester', 'password', 'Test', 'Era', '2018-12-13', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_groups`
--
ALTER TABLE `chat_groups`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`friendship_id`);

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
-- AUTO_INCREMENT for table `chat_groups`
--
ALTER TABLE `chat_groups`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `friendship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `tournament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tournament_matches`
--
ALTER TABLE `tournament_matches`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

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
