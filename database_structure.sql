SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databas: `packagedat_main`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `packagedata_delete_requests`
--

CREATE TABLE IF NOT EXISTS `packagedata_delete_requests` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected','') CHARACTER SET utf8 NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `packagedata_forwards`
--

CREATE TABLE IF NOT EXISTS `packagedata_forwards` (
  `package_id` int(11) NOT NULL,
  `nr_of_forwards` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `packagedata_forwards_ips`
--

CREATE TABLE IF NOT EXISTS `packagedata_forwards_ips` (
  `package_id` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `packagedata_keywords`
--

CREATE TABLE IF NOT EXISTS `packagedata_keywords` (
  `id` int(11) NOT NULL,
  `keyword` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `packagedata_packages`
--

CREATE TABLE IF NOT EXISTS `packagedata_packages` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `display_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('published','pending','superseded','trash') CHARACTER SET utf8 NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `url` varchar(200) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `description_rendered` text CHARACTER SET utf8,
  `examples` text CHARACTER SET utf8,
  `examples_rendered` text CHARACTER SET utf8,
  `has_examples` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `packagedata_packages_keywords`
--

CREATE TABLE IF NOT EXISTS `packagedata_packages_keywords` (
  `package_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `packagedata_sessions`
--

CREATE TABLE IF NOT EXISTS `packagedata_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `packagedata_delete_requests`
--
ALTER TABLE `packagedata_delete_requests`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `packagedata_forwards`
--
ALTER TABLE `packagedata_forwards`
  ADD PRIMARY KEY (`package_id`);

--
-- Index för tabell `packagedata_keywords`
--
ALTER TABLE `packagedata_keywords`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `packagedata_packages`
--
ALTER TABLE `packagedata_packages`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `packagedata_sessions`
--
ALTER TABLE `packagedata_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `packagedata_delete_requests`
--
ALTER TABLE `packagedata_delete_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT för tabell `packagedata_keywords`
--
ALTER TABLE `packagedata_keywords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT för tabell `packagedata_packages`
--
ALTER TABLE `packagedata_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
