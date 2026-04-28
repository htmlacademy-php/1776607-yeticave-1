-- Создание базы данных проекта.
CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

-- Выбор базы данных, в которой будут создаваться таблицы.
USE yeticave;

-- Временное отключение проверки внешних ключей нужно, чтобы удалить связанные таблицы в любом порядке.
SET FOREIGN_KEY_CHECKS = 0;

-- Удаление старых таблиц перед повторным созданием схемы.
DROP TABLE IF EXISTS bets;
DROP TABLE IF EXISTS lots;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- Возвращаем проверку внешних ключей перед созданием новых таблиц.
SET FOREIGN_KEY_CHECKS = 1;

-- Категории лотов: название показывается пользователю, символьный код используется для CSS-классов.
CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128) NOT NULL,
  code VARCHAR(64) NOT NULL,
  UNIQUE INDEX uq_categories_name (name),
  UNIQUE INDEX uq_categories_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Пользователи сайта: регистрационные данные, контакты и данные для авторизации.
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(255) NOT NULL,
  name VARCHAR(128) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  contacts TEXT NOT NULL,
  UNIQUE INDEX uq_users_email (email),
  INDEX idx_users_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Лоты аукциона: описание товара, цена, срок завершения и связи с автором, победителем и категорией.
CREATE TABLE lots (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  image VARCHAR(255) NOT NULL,
  initial_price DECIMAL(10, 2) UNSIGNED NOT NULL,
  expires_at DATETIME NOT NULL,
  bet_step DECIMAL(10, 2) UNSIGNED NOT NULL,
  author_id INT UNSIGNED NOT NULL,
  winner_id INT UNSIGNED NULL,
  category_id INT UNSIGNED NOT NULL,
  INDEX idx_lots_name (name),
  INDEX idx_lots_description (description(255)),
  INDEX idx_lots_author_id (author_id),
  INDEX idx_lots_winner_id (winner_id),
  INDEX idx_lots_category_id (category_id),
  CONSTRAINT fk_lots_author FOREIGN KEY (author_id) REFERENCES users (id),
  CONSTRAINT fk_lots_winner FOREIGN KEY (winner_id) REFERENCES users (id),
  CONSTRAINT fk_lots_category FOREIGN KEY (category_id) REFERENCES categories (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ставки пользователей по лотам: фиксируют сумму, пользователя и выбранный лот.
CREATE TABLE bets (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  amount DECIMAL(10, 2) UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  lot_id INT UNSIGNED NOT NULL,
  INDEX idx_bets_user_id (user_id),
  INDEX idx_bets_lot_id (lot_id),
  CONSTRAINT fk_bets_user FOREIGN KEY (user_id) REFERENCES users (id),
  CONSTRAINT fk_bets_lot FOREIGN KEY (lot_id) REFERENCES lots (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Начальное заполнение справочника категорий.
INSERT INTO categories (name, code) VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Разное', 'other');
