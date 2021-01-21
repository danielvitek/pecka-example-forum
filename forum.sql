CREATE TABLE `thread` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `thread` (`id`, `name`, `title`, `author`, `date_created`) VALUES
(1, '6009f68eb872d-moje-prvn---vl--kno--1', 'Moje první vlákno #1', 'prvni@danielvitek.me', '2021-01-21 22:47:58'),
(2, '6009f69c88104-druh---vl--kno', 'Druhé vlákno', 'druhy@danielvitek.me', '2021-01-21 22:48:12'),
(3, '6009f6ac270d4-t--et---vl--kno--3', 'Třetí Vlákno #3', 'treti@danielvitek.me', '2021-01-21 22:48:28');


CREATE TABLE `thread_post` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `thread_post` (`id`, `thread_id`, `author`, `content`, `date_created`) VALUES
(1, 1, 'prvni@danielvitek.me', 'Zakládám zde svoje první vlákno!', '2021-01-21 22:47:58'),
(2, 2, 'druhy@danielvitek.me', 'Druhé vlákno', '2021-01-21 22:48:12'),
(3, 3, 'treti@danielvitek.me', 'Třetí vlákno', '2021-01-21 22:48:28'),
(4, 1, 'kontakt@danielvitek.me', 'Odpovídám na první vlákno!', '2021-01-21 22:48:49'),
(5, 1, 'prvni@danielvitek.me', 'Tak to je super!', '2021-01-21 22:48:57');


ALTER TABLE `thread`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `thread_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`);

ALTER TABLE `thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `thread_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `thread_post`
  ADD CONSTRAINT `thread_post_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
