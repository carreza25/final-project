CREATE DATABASE `final`;

CREATE TABLE `journal`
(
    `id`        int(11) NOT NULL AUTO_INCREMENT,
    `mood`      varchar(80) NOT NULL,
    `entry`     text NOT NULL,
    `date`      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    primary key (`id`)
);