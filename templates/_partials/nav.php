<?php

/**
 * @var array $categories
 */
?>
<nav class="nav">
    <ul class="nav__list container">

        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="markup/all-lots.html"><?= esc($category['name'] ?? '') ?></a>
            </li>
        <?php endforeach; ?>

    </ul>
</nav>
