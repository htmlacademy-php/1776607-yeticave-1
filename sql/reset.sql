-- Выбор базы данных для сброса схемы.
USE yeticave;

-- Временное отключение проверки внешних ключей нужно, чтобы удалить связанные таблицы в любом порядке.
SET FOREIGN_KEY_CHECKS = 0;

-- Удаление старых таблиц перед повторным созданием схемы.
DROP TABLE IF EXISTS bets;
DROP TABLE IF EXISTS lots;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- Возвращаем проверку внешних ключей.
SET FOREIGN_KEY_CHECKS = 1;
