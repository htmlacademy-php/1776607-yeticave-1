-- 1) Получить все категории.
SELECT id, name, slug
FROM categories;

-- 2) Получить самые новые, открытые лоты:
-- название, стартовая цена, ссылка на изображение, текущая цена, название категории.
SELECT
  l.name,
  l.initial_price,
  l.image_url,
  COALESCE(MAX(b.price), l.initial_price) AS current_price,
  c.name AS category_name
FROM lots AS l
JOIN categories AS c ON c.id = l.category_id
LEFT JOIN bets AS b ON b.lot_id = l.id
WHERE l.expires_at > NOW()
GROUP BY l.id
ORDER BY l.created_at DESC;

-- 3) Показать лот по его ID + название категории.
SELECT
  l.*,
  c.name AS category_name
FROM lots AS l
JOIN categories AS c ON c.id = l.category_id
WHERE l.id = ?;

-- 4) Обновить название лота по его идентификатору.
UPDATE lots
SET name = <name>
WHERE id = ?;

-- 5) Получить список ставок для лота по его идентификатору
-- с сортировкой по дате (сначала новые).
SELECT
  b.id,
  b.price,
  b.user_id,
  b.created_at
FROM bets AS b
WHERE b.lot_id = ?
ORDER BY b.created_at DESC;
