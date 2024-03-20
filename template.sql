CREATE TABLE `player` (
  `player_id` int(11) NOT NULL PRIMARY KEY,
  `name` varchar(255) DEFAULT NULL,
  `highestscore` decimal(65,16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

