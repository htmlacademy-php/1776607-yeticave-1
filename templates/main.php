<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">

        <?php foreach ($categories as $category): ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= esc($category) ?></a>
            </li>
        <?php endforeach; ?>

    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">

        <?php foreach ($lots as $lot): ?>
            <?php [$hoursLeft, $minutesLeft, $secondsLeft] = getDateTimeRange((string) ($lot['expires_at'] ?? '')); ?>
            <?php $timerClass = $hoursLeft < 1 ? 'timer timer--finishing' : 'timer'; ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= esc($lot['image'] ?? '') ?>" width="350" height="260" alt="<?= esc($lot['name'] ?? '') ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= esc($lot['category'] ?? '') ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= esc($lot['name'] ?? '') ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= format_price($lot['price'] ?? 0); ?></span>
                        </div>
                        <div class="lot__timer <?= esc($timerClass) ?>">
                            <?= sprintf('%02d:%02d:%02d', $hoursLeft, $minutesLeft, $secondsLeft) ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>

    </ul>
</section>
