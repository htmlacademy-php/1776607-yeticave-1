<?php

/**
 * @var array $lot
 * @var array $categories
 */

[$hoursLeft, $minutesLeft, $secondsLeft] = getDateTimeRange((string) ($lot['expires_at'] ?? ''));
$timerClass = 'lot-item__timer timer' . ($hoursLeft < 1 ? ' timer--finishing' : '');
$timerValue = $hoursLeft > 0
    ? sprintf('%02d:%02d', $hoursLeft, $minutesLeft)
    : sprintf('%02d:%02d', $minutesLeft, $secondsLeft);
$currentPrice = (int) ($lot['current_price'] ?? $lot['initial_price'] ?? 0);
$minBet = $currentPrice + (int) ($lot['bet_step'] ?? 0);
?>
<?= include_template('nav.php', compact('categories')) ?>
<section class="lot-item container">
    <h2><?= esc($lot['name'] ?? '') ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= esc($lot['image_url'] ?? '') ?>" width="730" height="548" alt="<?= esc($lot['name'] ?? '') ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= esc($lot['category_name'] ?? '') ?></span></p>
            <p class="lot-item__description"><?= esc($lot['description'] ?? '') ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="<?= esc($timerClass) ?>">
                    <?= esc($timerValue) ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= esc(formatPrice($currentPrice)) ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= esc(formatPrice($minBet)) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
