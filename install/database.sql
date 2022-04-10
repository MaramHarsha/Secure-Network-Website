DROP TABLE IF EXISTS `psec_bad-words`;
DROP TABLE IF EXISTS `psec_bans`;
DROP TABLE IF EXISTS `psec_bans-country`;
DROP TABLE IF EXISTS `psec_bans-other`;
DROP TABLE IF EXISTS `psec_bans-ranges`;
DROP TABLE IF EXISTS `psec_dnsbl-databases`;
DROP TABLE IF EXISTS `psec_ip-whitelist`;
DROP TABLE IF EXISTS `psec_file-whitelist`;
DROP TABLE IF EXISTS `psec_live-traffic`;
DROP TABLE IF EXISTS `psec_logins`;
DROP TABLE IF EXISTS `psec_logs`;
DROP TABLE IF EXISTS `psec_pages-layolt`;

-- --------------------------------------------------------

CREATE TABLE `psec_bad-words` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `word` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `psec_bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autoban` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `psec_bans-country` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `psec_bans-other` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `psec_bans-ranges` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `ip_range` char(19) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `psec_dnsbl-databases` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `database` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `psec_dnsbl-databases` (`id`, `database`) VALUES
(1, 'sbl.spamhaus.org'),
(2, 'xbl.spamhaus.org');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `psec_ip-whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `psec_file-whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `path` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `psec_live-traffic` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `useragent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os_code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_type` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'XX',
  `request_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bot` tinyint(1) NOT NULL DEFAULT '0',
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uniquev` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `psec_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `successful` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `psec_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `ip` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `browser_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `os_code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'XX',
  `region` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `city` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `latitude` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `longitude` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unknown',
  `useragent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `referer_url` varchar(255) COLLATE utf8mb4_unicode_ci NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `psec_pages-layolt` (
  `id` int(11) NOT NULL AUTO_INCREMENT primary key,
  `page` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `psec_pages-layolt` (`id`, `page`, `text`) VALUES
(1, 'Banned', 'You are banned and you cannot continue to the website'),
(2, 'Blocked', 'Malicious request was detected'),
(3, 'Proxy', 'Access to the website via Proxy, VPN, TOR is not allowed (Disable Browser Data Compression if you have it enabled)'),
(4, 'Spam', 'You are in the Blacklist of Spammers and you cannot continue to the website'),
(5, 'Banned_Country', 'Sorry, but your country is banned and you cannot continue to the website'),
(6, 'Blocked_Browser', 'Access to the website through your Browser is not allowed, please use another Internet Browser'),
(7, 'Blocked_OS', 'Access to the website through your Operating System is not allowed'),
(8, 'Blocked_ISP', 'Your Internet Service Provider is blacklisted and you cannot continue to the website'),
(9, 'Blocked_RFR', 'Your referrer url is blocked and you cannot continue to the website');