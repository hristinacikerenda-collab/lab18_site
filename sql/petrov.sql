-- Лабораторна 18: база даних сайту (MySQL / MariaDB, кодування utf8mb4)
-- Імпорт: phpMyAdmin -> Імпорт, або  mysql -u root < sql/petrov.sql
SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS `petrov` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SET NAMES utf8mb4;
USE `petrov`;

DROP TABLE IF EXISTS `p_articles`, `p_sections`, `p_menu`, `p_banners`, `p_users`;

CREATE TABLE `p_sections` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `meta_desc` VARCHAR(255) NOT NULL,
  `meta_key` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `p_articles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `section_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `meta_desc` VARCHAR(255) NOT NULL,
  `meta_key` VARCHAR(255) NOT NULL,
  `intro_text` TEXT NOT NULL,
  `full_text` TEXT NOT NULL,
  `date` INT UNSIGNED NOT NULL,
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `p_menu` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `link` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `p_banners` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `code` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `p_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `login` VARCHAR(70) NOT NULL UNIQUE,
  `password` CHAR(32) NOT NULL,
  `regdate` INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `p_sections` (`id`,`title`,`meta_desc`,`meta_key`,`description`) VALUES
(1,'Стрічкові функції мови PHP','Стрічкові функції PHP, рядки, explode, printf','стрічкові функції, рядки, php','Функціонал мови PHP підтримує безліч функцій для роботи з рядками. Стрічкові функції призначені для виконання різних маніпуляцій зі стрічками й не потребують підключення додаткових бібліотек.'),
(2,'Математичні функції PHP','Математичні функції PHP, abs, rand, round','математичні функції, abs, rand, php','Математичні функції PHP дозволяють виконувати обчислення над числами: від модуля й округлення до генерації випадкових значень і переведення між системами числення.'),
(3,'Функції дати і часу','Функції дати і часу PHP, date, time, mktime','дата, час, date, time, php','Функції дати й часу PHP дозволяють отримати поточний час сервера, відформатувати дату та перетворити її в мітку часу Unix.');

INSERT INTO `p_articles` (`id`,`section_id`,`title`,`meta_desc`,`meta_key`,`intro_text`,`full_text`,`date`) VALUES
(1,1,'Функція explode','Функція explode - довідник PHP','explode, розбиття рядка','Функція <b>explode</b> - розбиває рядок на підрядки.','<p>Функція <b>explode</b> - розбиває рядок на підрядки.</p><p>Синтаксис: <code>array explode(string $separator, string $string [, int $limit])</code>. Повертає масив рядків, отриманих розбиттям рядка <i>string</i> за допомогою роздільника <i>separator</i>.</p><p>Приклад: <code>explode(" ", "функція PHP розбиває рядок")</code> поверне масив із чотирьох слів.</p>',1794003744),
(2,1,'Функція printf','Функція printf - довідник PHP','printf, форматований вивід','Функція <b>printf</b> - записує відформатований рядок у потік.','<p>Функція <b>printf</b> - записує відформатований рядок у потік.</p><p>Рядок формату складається зі звичайних символів (за винятком %), які копіюються в результуючий рядок, і описувачів перетворень, кожен з яких замінюється на один із параметрів. Це відноситься до функцій fprintf(), sprintf() і printf().</p>',1794003114),
(3,1,'Функція count_chars','Функція count_chars - довідник PHP','count_chars, символи рядка','Функція <b>count_chars</b> - повертає інформацію про символи, що входять в рядок.','<p>Функція <b>count_chars</b> - повертає інформацію про символи, що входять в рядок.</p><p>Підраховує кількість входжень кожного байта зі значенням 0..255 в рядок і повертає її в різних режимах (параметр <i>mode</i> від 0 до 4).</p>',1794005794),
(4,1,'Функція strlen','Функція strlen - довідник PHP','strlen, довжина рядка','Функція <b>strlen</b> - повертає довжину рядка.','<p>Функція <b>strlen</b> - повертає довжину рядка.</p><p>Для рядків у кодуванні UTF-8 функція рахує <i>байти</i>, а не символи. Для коректного підрахунку кирилиці використовуйте <code>mb_strlen()</code>.</p>',1793901790),
(5,2,'Функція abs','Функція abs - довідник PHP','abs, модуль числа','Функція <b>abs</b> - модуль числа.','<p>Функція <b>abs</b> - модуль числа.</p><p>Якщо аргумент є від\'ємним, повертає його, помноженим на -1; інакше повертає сам аргумент. Приклад: <code>abs(-4.2)</code> поверне 4.2.</p>',1794007211),
(6,2,'Функція rand','Функція rand - довідник PHP','rand, випадкове число','Функція <b>rand</b> - генерує випадкове число.','<p>Функція <b>rand</b> - генерує випадкове число.</p><p>Якщо викликана без аргументів, повертає псевдовипадкове ціле число від 0 до getrandmax(). Із параметрами <i>min</i> і <i>max</i> повертає число з указаного діапазону включно.</p>',1794006308),
(7,2,'Функція base_convert','Функція base_convert - довідник PHP','base_convert, системи числення','Функція <b>base_convert</b> - конвертує число між різними базами.','<p><b>base_convert</b> - конвертує число між різними базами.</p><p>Повертає рядок, що містить число number, представлене з базою tobase.</p><p>База, в якій number дається, специфікується в frombase. І frombase, і tobase повинні бути в діапазоні від 2 до 36 включно. Цифри в числах з базою вище 10 будуть представлені буквами a-z, де a означає 10, b означає 11 і z означає 35.</p>',1794005562),
(8,2,'Функція round','Функція round - довідник PHP','round, округлення','Функція <b>round</b> - округлює число до заданої точності.','<p>Функція <b>round</b> - округлює число з плаваючою крапкою.</p><p>Приклад: <code>round(3.14159, 2)</code> поверне 3.14. Параметр <i>precision</i> може бути й від\'ємним: <code>round(1241757, -3)</code> дає 1242000.</p>',1793796000),
(9,3,'Функція date','Функція date - довідник PHP','date, форматування дати','Функція <b>date</b> - форматує системну дату/час.','<p>Функція <b>date</b> - форматує системну дату/час.</p><p>Повертає рядок, відформатований згідно з переданим шаблоном. Приклад: <code>date("Y-m-d H:i:s")</code> поверне, наприклад, 2026-11-24 10:36:00.</p>',1794009063),
(10,3,'Функція time','Функція time - довідник PHP','time, мітка часу','Функція <b>time</b> - повертає поточну мітку часу Unix.','<p>Функція <b>time</b> - повертає кількість секунд, що минули з 1 січня 1970 року (мітка часу Unix).</p><p>Саме цю мітку ми зберігаємо в базі даних як дату реєстрації користувача й дату публікації статті.</p>',1793697330),
(11,3,'Функція mktime','Функція mktime - довідник PHP','mktime, мітка часу','Функція <b>mktime</b> - повертає мітку часу Unix для заданої дати.','<p>Функція <b>mktime</b> - повертає мітку часу Unix для вказаної дати.</p><p>Приклад: <code>mktime(0, 0, 0, 12, 31, 2026)</code> поверне мітку часу для опівночі 31 грудня 2026 року.</p>',1793606400);

INSERT INTO `p_menu` (`title`,`link`) VALUES
('Головна сторінка','index.php'),
('Стрічкові функції мови PHP','index.php?view=section&id=1'),
('Математичні функції PHP','index.php?view=section&id=2'),
('Функції дати і часу','index.php?view=section&id=3');

INSERT INTO `p_banners` (`code`) VALUES
('Порада №1:<br>Чиста структура шаблонів'),
('Порада №2:<br>Поділ логіки й вигляду');
