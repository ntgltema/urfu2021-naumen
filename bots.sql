-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 25 2021 г., 10:41
-- Версия сервера: 5.7.29-0ubuntu0.18.04.1
-- Версия PHP: 7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bots`
--

-- --------------------------------------------------------

--
-- Структура таблицы `naumen_questions`
--

CREATE TABLE `naumen_questions` (
  `id` int(11) NOT NULL,
  `field` text NOT NULL,
  `title` text NOT NULL,
  `keyboard` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `naumen_questions`
--

INSERT INTO `naumen_questions` (`id`, `field`, `title`, `keyboard`) VALUES
(1, 'city', 'Город в котором ты хочешь проходить стажировку', '{\n  \"inline_keyboard\": [\n    [\n      {\n        \"text\": \"Екатеринбург\",\n        \"callback_data\": \"Екатеринбург\"\n      }\n    ],\n    [\n      {\n        \"text\": \"Краснодар\",\n        \"callback_data\": \"Краснодар\"\n      }\n    ],\n    [\n      {\n        \"text\": \"Челябинск\",\n        \"callback_data\": \"Челябинск\"\n      }\n    ],\n    [\n      {\n        \"text\": \"Москва\",\n        \"callback_data\": \"Москва\"\n      }\n    ],\n    [\n      {\n        \"text\": \"Санкт-Петербург\",\n        \"callback_data\": \"Санкт-Петербург\"\n      }\n    ],\n    [\n      {\n        \"text\": \"Тверь\",\n        \"callback_data\": \"Тверь\"\n      }\n    ]\n  ],\n  \"one_time_keyboard\": false,\n  \"resize_keyboard\": true\n}'),
(2, 'fio', 'Полное ФИО', NULL),
(3, 'DOB', 'Дата рождения (дд.мм.гггг)', NULL),
(4, 'residence ', 'Город проживания', NULL),
(5, 'email', 'E-mail', NULL),
(6, 'phone', 'Tелефон для связи', NULL),
(7, 'workWeek', 'Сколько часов в неделю сможешь уделять стажировке?', '{\"inline_keyboard\":[[{\"text\":\"40 \\u0447\\u0430\\u0441\\u043e\\u0432 (\\u043f\\u043e\\u043b\\u043d\\u044b\\u0439 \\u0440\\u0430\\u0431\\u043e\\u0447\\u0438\\u0439 \\u0434\\u0435\\u043d\\u044c)\",\"callback_data\":\"40 \\u0447\\u0430\\u0441\\u043e\\u0432 (\\u043f\\u043e\\u043b\\u043d\\u044b\\u0439 \\u0440\\u0430\\u0431\\u043e\\u0447\\u0438\\u0439 \\u0434\\u0435\\u043d\\u044c)\"}],[{\"text\":\"> 30 \\u0447\\u0430\\u0441\\u043e\\u0432\",\"callback_data\":\"> 30 \\u0447\\u0430\\u0441\\u043e\\u0432\"}],[{\"text\":\"< 30 \\u0447\\u0430\\u0441\\u043e\\u0432\",\"callback_data\":\"< 30 \\u0447\\u0430\\u0441\\u043e\\u0432\"}]],\"one_time_keyboard\":false,\"resize_keyboard\":true}'),
(8, 'startWork', 'Когда сможешь приступить к стажировке?(дд.мм.гггг)', NULL),
(9, 'employment', 'Сможешь продолжать работу после окончания стажировки?', '{\"inline_keyboard\":[[{\"text\":\"\\u041d\\u0435\\u0442, \\u0442\\u043e\\u043b\\u044c\\u043a\\u043e \\u043d\\u0430 \\u043f\\u0435\\u0440\\u0438\\u043e\\u0434 \\u0441\\u0442\\u0430\\u0436\\u0438\\u0440\\u043e\\u0432\\u043a\\u0438\",\"callback_data\":\"\\u041d\\u0435\\u0442, \\u0442\\u043e\\u043b\\u044c\\u043a\\u043e \\u043d\\u0430 \\u043f\\u0435\\u0440\\u0438\\u043e\\u0434 \\u0441\\u0442\\u0430\\u0436\\u0438\\u0440\\u043e\\u0432\\u043a\\u0438\"}],[{\"text\":\"\\u0414\\u0430, \\u043f\\u043e\\u043b\\u043d\\u044b\\u0439 \\u0440\\u0430\\u0431\\u043e\\u0447\\u0438\\u0439 \\u0434\\u0435\\u043d\\u044c\",\"callback_data\":\"\\u0414\\u0430, \\u043f\\u043e\\u043b\\u043d\\u044b\\u0439 \\u0440\\u0430\\u0431\\u043e\\u0447\\u0438\\u0439 \\u0434\\u0435\\u043d\\u044c\"}],[{\"text\":\"\\u0414\\u0430, \\u043d\\u0435\\u043f\\u043e\\u043b\\u043d\\u044b\\u0439 \\u0440\\u0430\\u0431\\u043e\\u0447\\u0438\\u0439 \\u0434\\u0435\\u043d\\u044c\",\"callback_data\":\"\\u0414\\u0430, \\u043d\\u0435\\u043f\\u043e\\u043b\\u043d\\u044b\\u0439 \\u0440\\u0430\\u0431\\u043e\\u0447\\u0438\\u0439 \\u0434\\u0435\\u043d\\u044c\"}]],\"one_time_keyboard\":false,\"resize_keyboard\":true}'),
(10, 'eduType', 'Образование', '{\"inline_keyboard\":[[{\"text\":\"\\u0412\\u044b\\u0441\\u0448\\u0435\\u0435\",\"callback_data\":\"\\u0412\\u044b\\u0441\\u0448\\u0435\\u0435\"}],[{\"text\":\"\\u041d\\u0435\\u0437\\u0430\\u043a\\u043e\\u043d\\u0447\\u0435\\u043d\\u043d\\u043e\\u0435 \\u0432\\u044b\\u0441\\u0448\\u0435\\u0435\",\"callback_data\":\"\\u041d\\u0435\\u0437\\u0430\\u043a\\u043e\\u043d\\u0447\\u0435\\u043d\\u043d\\u043e\\u0435 \\u0432\\u044b\\u0441\\u0448\\u0435\\u0435\"}],[{\"text\":\"\\u0421\\u0440\\u0435\\u0434\\u043d\\u0435\\u0435 \\u043f\\u0440\\u043e\\u0444\\u0435\\u0441\\u0441\\u0438\\u043e\\u043d\\u0430\\u043b\\u044c\\u043d\\u043e\\u0435\",\"callback_data\":\"\\u0421\\u0440\\u0435\\u0434\\u043d\\u0435\\u0435 \\u043f\\u0440\\u043e\\u0444\\u0435\\u0441\\u0441\\u0438\\u043e\\u043d\\u0430\\u043b\\u044c\\u043d\\u043e\\u0435\"}]],\"one_time_keyboard\":false,\"resize_keyboard\":true}'),
(11, 'eduName', 'Название образовательного учреждения', NULL),
(12, 'eduStart', 'Год начала обучения', NULL),
(13, 'eduEnd', 'Год окончания обучения', NULL),
(14, 'eduFac', 'Специальность\\Факультет', NULL),
(15, 'exp', 'В каких проектах ты принимал участие (включая учебные проекты)?', NULL),
(16, 'expEdu', 'Участвовал ли ты в образовательных программах от Naumen? Если да – расскажи об этом подробнее', NULL),
(17, 'skills', 'Ключевые навыки', NULL),
(18, 'interests', 'Профессиональные интересы', NULL),
(19, 'book', 'Последняя прочитанная профессиональная книга', NULL),
(20, 'hobby', 'Как ты проводишь свободное время? Чем увлекаешься?', NULL),
(21, 'expectations', 'Что даст тебе прохождение практики в нашей компании?', NULL),
(22, 'position', 'Какую должность ты хочешь занять через 3-5 лет?', NULL),
(23, 'companyInfo', 'Как ты узнал о компании NAUMEN?', '{\n  \"inline_keyboard\": [\n    [\n      {\n        \"text\": \"Сайт компании\",\n        \"callback_data\": \"Сайт компании\"\n      },\n      {\n        \"text\": \"Реклама в интернете\",\n        \"callback_data\": \"Реклама в интернете\"\n      }\n    ],\n    [\n      {\n        \"text\": \"На сайте hh.ru\",\n        \"callback_data\": \"На сайте hh.ru\"\n      },\n      {\n        \"text\": \"Социальные сети\",\n        \"callback_data\": \"Социальные сети\"\n      }\n    ],\n    [\n      {\n        \"text\": \"От друзей или преподавателей\",\n        \"callback_data\": \"От друзей или преподавателей\"\n      },\n      {\n        \"text\": \"Афиши и стенды\",\n        \"callback_data\": \"Афиши и стенды\"\n      }\n    ],\n    [\n      {\n        \"text\": \"Образовательных программы\",\n        \"callback_data\": \"Образовательных программы\"\n      }\n    ]\n  ],\n  \"one_time_keyboard\": false,\n  \"resize_keyboard\": true\n}'),
(24, 'internshipInfo', 'Как ты узнал о стажировке в компании NAUMEN?', '{\n  \"inline_keyboard\": [\n    [\n      {\n        \"text\": \"Сайт компании\",\n        \"callback_data\": \"Сайт компании\"\n      },\n      {\n        \"text\": \"Реклама в интернете\",\n        \"callback_data\": \"Реклама в интернете\"\n      }\n    ],\n    [\n      {\n        \"text\": \"На сайте hh.ru\",\n        \"callback_data\": \"На сайте hh.ru\"\n      },\n      {\n        \"text\": \"Социальные сети\",\n        \"callback_data\": \"Социальные сети\"\n      }\n    ],\n    [\n      {\n        \"text\": \"От друзей или преподавателей\",\n        \"callback_data\": \"От друзей или преподавателей\"\n      },\n      {\n        \"text\": \"Афиши и стенды\",\n        \"callback_data\": \"Афиши и стенды\"\n      }\n    ],\n    [\n      {\n        \"text\": \"Образовательных программы\",\n        \"callback_data\": \"Образовательных программы\"\n      }\n    ]\n  ],\n  \"one_time_keyboard\": false,\n  \"resize_keyboard\": true\n}'),
(25, 'resume', 'Ссылка на резюме', '');

-- --------------------------------------------------------

--
-- Структура таблицы `naumen_trainee`
--

CREATE TABLE `naumen_trainee` (
  `id` int(11) NOT NULL,
  `city` text NOT NULL,
  `type` text NOT NULL,
  `name` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `task` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `naumen_trainee`
--

INSERT INTO `naumen_trainee` (`id`, `city`, `type`, `name`, `active`, `task`, `description`) VALUES
(1, 'Екатеринбург', 'Разработка', 'Стажер-разработчик Java', 1, 'https://www.naumen.ru/upload/medialibrary/966/Testovoe-zadanie-dlya-stazhyerov-2021-_Java_.pdf', 'На этой стажировке ты:\n1)Познакомишься с промышленной разработкой ПО\n2)Попробуешь разрабатывать новые фичи и поддерживать back-end сервисы бизнес-системы\n3)Будешь участвовать в улучшении кодовой базы продукта, попробуешь разрабатывать новые фичи на основе реальных бизнес-требований'),
(2, 'Екатеринбург', 'Тестирование', 'Стажер-тестировщик', 1, 'https://www.naumen.ru/upload/medialibrary/82c/Testovoe_zadanie_dlya_stazhyorov_2021_Testirovshchik.pdf', 'На этой стажировке ты будешь:\n1)выполнять функциональные ручные тесты при работе с задачами проектов\n2)составлять test-case и test-plan и поддерживать их в актуальном состоянии\n3)проводить регрессионное тестирование проектов по написанным test-case и ТЗ\n4)составлять отчеты о найденных ошибках в баг-трекере.\n'),
(3, 'Екатеринбург', 'Аналитика', 'Стажер-аналитик', 1, 'https://www.naumen.ru/upload/medialibrary/b63/Testovoe_zadanie_dlya_stazhyorov_2021_Analitik.pdf', 'На этой стажировке ты будешь:\n1)участвовать во внедрении и сопровождении реализованной функциональности в реальных проектах. В том числе — настройка через интерфейс, написание простых скриптов\n2)анализировать и обобщать требования пользователей программного обеспечения\n3)изучать функциональности существующих на рынке информационных систем\n4)разрабатывать постановки на реализацию функциональности разработчикам, используя результаты деятельности, описанной в трех предыдущих пунктах.\n'),
(4, 'Екатеринбург', 'Инженерия', 'Стажер технический писатель', 1, 'https://www.naumen.ru/upload/medialibrary/565/Testovoe_zadanie_dlya_stazhyerov_2021_Tekh_pisatel.pdf', 'На этой стажировке ты будешь:\n1)Разрабатывать и поддерживать пользовательскую документацию на платформу Naumen SMP и ее интерфейсы (web-приложение, мобильное приложение, web-портал) в системе MadCap Flare\n2)Форматировать выпускаемые документы внутри направления по предоставляемым шаблонам\n3)Взаимодействовать с аналитиками в рамках разработки документации\n'),
(5, 'Краснодар', 'Разработка', 'Стажер-разработчик Java', 1, 'https://www.naumen.ru/upload/medialibrary/966/Testovoe-zadanie-dlya-stazhyerov-2021-_Java_.pdf', 'На этой стажировке ты:\n1)Познакомишься с промышленной разработкой ПО\n2)Попробуешь разрабатывать новые фичи и поддерживать back-end сервисы бизнес-системы\n3)Будешь участвовать в улучшении кодовой базы продукта, попробуешь разрабатывать новые фичи на основе реальных бизнес-требований');

-- --------------------------------------------------------

--
-- Структура таблицы `naumen_users`
--

CREATE TABLE `naumen_users` (
  `id` int(11) NOT NULL,
  `telegram_id` int(11) NOT NULL,
  `mode` int(11) DEFAULT NULL,
  `last_message` bigint(20) NOT NULL,
  `city` text,
  `fio` text,
  `DOB` text,
  `residence` text,
  `email` text,
  `phone` text,
  `workWeek` text,
  `startWork` text,
  `employment` text,
  `eduType` text,
  `eduName` text,
  `eduStart` text,
  `eduEnd` text,
  `eduFac` text,
  `exp` text,
  `expEdu` text,
  `skills` text,
  `interests` text,
  `book` text,
  `hobby` text,
  `expectations` text,
  `position` text,
  `companyInfo` text,
  `internshipInfo` text,
  `resume` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `naumen_questions`
--
ALTER TABLE `naumen_questions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `naumen_trainee`
--
ALTER TABLE `naumen_trainee`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `naumen_users`
--
ALTER TABLE `naumen_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `naumen_questions`
--
ALTER TABLE `naumen_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `naumen_trainee`
--
ALTER TABLE `naumen_trainee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `naumen_users`
--
ALTER TABLE `naumen_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
