<?php $nav = content('navigation'); $announcement = $site['announcement']; ?>
<?php if (($announcement['enabled'] ?? false) === true): ?>
<div class="announcement">
    <div class="container announcement__inner"><span><?= h($announcement['text']) ?></span><a href="<?= h(url($announcement['url'])) ?>"><?= h($announcement['label']) ?> <?= icon('arrow') ?></a></div>
</div>
<?php endif; ?>
<header class="site-header" data-header>
    <div class="container site-header__inner">
        <a class="brand" href="<?= h(url('/')) ?>" aria-label="SkillsPark Tech Hub home">
            <img src="<?= h(asset('brand/skillspark-wordmark.svg')) ?>" width="190" height="48" alt="SkillsPark Tech Hub">
        </a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
            <span class="nav-toggle__lines" aria-hidden="true"></span><span class="sr-only">Open menu</span>
        </button>
        <nav class="site-nav" id="site-nav" aria-label="Primary" data-nav>
            <ul>
                <?php foreach ($nav as $item): ?>
                <li class="<?= !empty($item['children']) ? 'has-menu' : '' ?>">
                    <a href="<?= h(url($item['url'])) ?>" <?= is_active($item['url']) ? 'aria-current="page"' : '' ?>><?= h($item['label']) ?></a>
                    <?php if (!empty($item['children'])): ?>
                    <button class="submenu-toggle" type="button" aria-expanded="false" aria-label="Show <?= h($item['label']) ?> menu"><?= icon('chevron') ?></button>
                    <ul class="submenu">
                        <?php foreach ($item['children'] as $child): ?><li><a href="<?= h(url($child['url'])) ?>"><?= h($child['label']) ?></a></li><?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <a class="button button--small" href="<?= h(url('/request-consultation')) ?>">Request a Consultation</a>
        </nav>
    </div>
</header>
