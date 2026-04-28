-- Создание базы данных проекта.
CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_0900_ai_ci;

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
  name VARCHAR(64) NOT NULL,
  slug VARCHAR(64) NOT NULL,
  UNIQUE INDEX uq_categories_name_slug (name, slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Пользователи сайта: регистрационные данные, контакты и данные для авторизации.
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(255) NOT NULL,
  name VARCHAR(128) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  contact_info TEXT NOT NULL,
  UNIQUE INDEX uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Лоты аукциона: описание товара, цена, срок завершения и связи с автором, победившей ставкой и категорией.
CREATE TABLE lots (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  initial_price INT UNSIGNED NOT NULL,
  expires_at DATETIME NOT NULL,
  bet_step INT UNSIGNED NOT NULL,
  author_id INT UNSIGNED NOT NULL,
  winner_bet_id INT UNSIGNED NULL,
  category_id INT UNSIGNED NOT NULL,
  FULLTEXT INDEX ft_lots_name_description (name, description),
  INDEX idx_lots_author_id (author_id),
  INDEX idx_lots_winner_bet_id (winner_bet_id),
  INDEX idx_lots_category_id (category_id),
  CONSTRAINT fk_lots_author FOREIGN KEY (author_id) REFERENCES users (id),
  CONSTRAINT fk_lots_category FOREIGN KEY (category_id) REFERENCES categories (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Ставки пользователей по лотам: фиксируют сумму, пользователя и выбранный лот.
CREATE TABLE bets (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  amount INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  lot_id INT UNSIGNED NOT NULL,
  INDEX idx_bets_user_id (user_id),
  INDEX idx_bets_lot_id (lot_id),
  CONSTRAINT fk_bets_user FOREIGN KEY (user_id) REFERENCES users (id),
  CONSTRAINT fk_bets_lot FOREIGN KEY (lot_id) REFERENCES lots (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Связь лота с победившей ставкой добавляется после создания ставок, чтобы избежать ошибки из-за циклической зависимости таблиц.
ALTER TABLE lots
  ADD CONSTRAINT fk_lots_winner_bet FOREIGN KEY (winner_bet_id) REFERENCES bets (id);
