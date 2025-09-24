CREATE USER 'prj_2025_2026_tle1_t2'@'localhost' IDENTIFIED BY 'leimaoru';
CREATE DATABASE IF NOT EXISTS `prj_2025_2026_tle1_t2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
GRANT ALL ON `prj_2025_2026_tle1_t2`.* TO 'prj_2025_2026_tle1_t2'@'localhost';
USE `prj_2025_2026_tle1_t2`;

CREATE TABLE `users`
(
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name`     TEXT            NULL,
    `last_name`      TEXT            NULL,
    `email`          TEXT            NOT NULL,
    `username`       TEXT            NOT NULL,
    `password`       TEXT            NOT NULL,
    `phone_number`   BIGINT          NULL,
    `dna`            BIGINT          NULL,
    `bank_number`    BIGINT          NULL,
    `bsn_number`     BIGINT          NULL,
    `address`        TEXT            NULL,
    `address_number` BIGINT          NULL,
    `postcode`       BIGINT          NULL,
    `city`           BIGINT          NULL
);
CREATE TABLE `videos`
(
    `id`       BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `filename` TEXT            NOT NULL,
    `likes`    BIGINT UNSIGNED NOT NULL DEFAULT 0,
    `comments` BIGINT UNSIGNED NOT NULL DEFAULT 0,
    `saves`    BIGINT UNSIGNED NOT NULL DEFAULT 0,
    `shares`   BIGINT UNSIGNED NOT NULL DEFAULT 0
);
CREATE TABLE `comments`
(
    `id`       BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id`  BIGINT UNSIGNED NOT NULL,
    `video_id` BIGINT UNSIGNED NOT NULL,
    `comment`  TEXT            NOT NULL,
    `likes`    BIGINT UNSIGNED NOT NULL DEFAULT 0
);
CREATE TABLE `likes`
(
    `id`          BIGINT UNSIGNED           NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id`     BIGINT UNSIGNED           NOT NULL,
    `target_type` ENUM ('video', 'comment') NOT NULL DEFAULT 'video',
    `target_id`   BIGINT UNSIGNED           NOT NULL
);
CREATE TABLE `saves`
(
    `id`       BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `video_id` BIGINT UNSIGNED NOT NULL,
    `user_id`  BIGINT UNSIGNED NOT NULL
);
ALTER TABLE
    `comments`
    ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE
    `saves`
    ADD CONSTRAINT `saves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE
    `likes`
    ADD CONSTRAINT `likes_target_id_foreign_1` FOREIGN KEY (`target_id`) REFERENCES `comments` (`id`);
ALTER TABLE
    `saves`
    ADD CONSTRAINT `saves_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`);
ALTER TABLE
    `likes`
    ADD CONSTRAINT `likes_target_id_foreign_2` FOREIGN KEY (`target_id`) REFERENCES `videos` (`id`);
ALTER TABLE
    `comments`
    ADD CONSTRAINT `comments_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`);
ALTER TABLE
    `likes`
    ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

INSERT INTO `videos` (`filename`)
VALUES ('video1'),
       ('video2'),
       ('video3'),
       ('video4'),
       ('video5'),
       ('video6'),
       ('video7'),
       ('video8'),
       ('video9'),
       ('video10'),
       ('video11'),
       ('video12'),
       ('video13'),
       ('video14'),
       ('video15'),
       ('video16'),
       ('video17'),
       ('video18'),
       ('video19'),
       ('video20'),
       ('video21'),
       ('video22'),
       ('video23'),
       ('video24'),
       ('video25'),
       ('video26'),
       ('video27'),
       ('video28'),
       ('video29'),
       ('video30'),
       ('video31'),
       ('video32'),
       ('video33'),
       ('video34'),
       ('video35'),
       ('video36'),
       ('video37'),
       ('video38'),
       ('video39'),
       ('video40'),
       ('video41'),
       ('video42');