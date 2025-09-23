CREATE TABLE `users`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` TEXT NULL,
    `last_name` TEXT NULL,
    `email` TEXT NOT NULL,
    `username` TEXT NOT NULL,
    `password` TEXT NOT NULL,
    `phone_number` BIGINT NULL,
    `dna` BIGINT NULL,
    `bank_number` BIGINT NULL,
    `bsn_number` BIGINT NULL,
    `address` TEXT NULL,
    `address_number` BIGINT NULL,
    `postcode` BIGINT NULL,
    `city` BIGINT NULL
);
CREATE TABLE `videos`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `filename` TEXT NOT NULL,
    `likes` BIGINT UNSIGNED NOT NULL DEFAULT 0,
    `comments` BIGINT UNSIGNED NOT NULL DEFAULT 0,
    `saves` BIGINT UNSIGNED NOT NULL DEFAULT 0,
    `shares` BIGINT UNSIGNED NOT NULL DEFAULT 0
);
CREATE TABLE `comments`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `video_id` BIGINT UNSIGNED NOT NULL,
    `comment` TEXT NOT NULL,
    `likes` BIGINT UNSIGNED NOT NULL DEFAULT 0
);
CREATE TABLE `likes`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `target_type` ENUM('video', 'comment') NOT NULL DEFAULT 'video',
    `target_id` BIGINT UNSIGNED NOT NULL
);
CREATE TABLE `saves`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `video_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL
);
ALTER TABLE
    `comments` ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);
ALTER TABLE
    `saves` ADD CONSTRAINT `saves_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);
ALTER TABLE
    `likes` ADD CONSTRAINT `likes_target_id_foreign_1` FOREIGN KEY(`target_id`) REFERENCES `comments`(`id`);
ALTER TABLE
    `saves` ADD CONSTRAINT `saves_video_id_foreign` FOREIGN KEY(`video_id`) REFERENCES `videos`(`id`);
ALTER TABLE
    `likes` ADD CONSTRAINT `likes_target_id_foreign_2` FOREIGN KEY(`target_id`) REFERENCES `videos`(`id`);
ALTER TABLE
    `comments` ADD CONSTRAINT `comments_video_id_foreign` FOREIGN KEY(`video_id`) REFERENCES `videos`(`id`);
ALTER TABLE
    `likes` ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);