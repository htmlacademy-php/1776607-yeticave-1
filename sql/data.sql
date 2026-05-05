-- Выбор базы данных для заполнения предустановленными данными.
USE yeticave;

-- Начальное заполнение справочника категорий.
INSERT INTO categories (name, slug) VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Разное', 'other');

-- Тестовый пользователь/автор.
INSERT INTO users (email, name, password_hash, contact_info) VALUES
  ('author@yeticave.test', 'Автор лотов', '$2y$10$examplehashforseeddatayeticave', 'Напишите автору через email.'),
  ('buyer@yeticave.test', 'Покупатель', '$2y$10$examplehashforseeddatayeticave', 'Связаться с покупателем можно по email.');

-- Начальное заполнение лотов из data.php.
INSERT INTO lots (
  name,
  description,
  image_url,
  initial_price,
  expires_at,
  bet_step,
  author_id,
  category_id
) VALUES
  (
    '2014 Rossignol District Snowboard',
    'Сноуборд 2014 Rossignol District Snowboard.',
    'img/lot-1.jpg',
    10999,
    '2026-05-01 23:59:59',
    500,
    1,
    1
  ),
  (
    'DC Ply Mens 2016/2017 Snowboard',
    'Сноуборд DC Ply Mens сезона 2016/2017.',
    'img/lot-2.jpg',
    159999,
    '2026-05-02 23:59:59',
    500,
    1,
    1
  ),
  (
    'Крепления Union Contact Pro 2015 года размер L/XL',
    'Крепления Union Contact Pro 2015 года, размер L/XL.',
    'img/lot-3.jpg',
    8000,
    '2026-05-03 23:59:59',
    500,
    1,
    2
  ),
  (
    'Ботинки для сноуборда DC Mutiny Charcoal',
    'Ботинки для сноуборда DC Mutiny Charcoal.',
    'img/lot-4.jpg',
    10999,
    '2026-05-04 23:59:59',
    500,
    1,
    3
  ),
  (
    'Куртка для сноуборда DC Mutiny Charcoal',
    'Куртка для сноуборда DC Mutiny Charcoal.',
    'img/lot-5.jpg',
    7500,
    '2026-05-05 23:59:59',
    500,
    1,
    4
  ),
  (
    'Маска Oakley Canopy',
    'Маска Oakley Canopy.',
    'img/lot-6.jpg',
    5400,
    '2026-05-06 23:59:59',
    500,
    1,
    6
  );

-- Начальное заполнение ставок.
INSERT INTO bets (price, user_id, lot_id, created_at) VALUES
  (11499, 2, 1, '2026-04-25 10:15:00'),
  (11999, 2, 1, '2026-04-26 12:40:00'),
  (12499, 2, 1, '2026-04-27 18:05:00'),
  (165000, 2, 2, '2026-04-28 09:30:00'),
  (8500, 2, 3, '2026-04-29 14:20:00');
