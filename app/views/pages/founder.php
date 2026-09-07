<?php
$profile=content('founder');
$hasVerifiedProfile=(bool)($profile['name']||$profile['photo']||$profile['short_bio']||$profile['full_story']||$profile['expertise']||$profile['achievements']||$profile['programs']||$profile['media']);
$displayName=$profile['name'] ?: 'Founder profile';
$title=$displayName;
$eyebrow='Founder profile';
$intro=$profile['short_bio'] ?: 'SkillsPark is preparing a verified founder profile.';
$breadcrumbs=[['label'=>'Home','url'=>'/'],['label'=>'Founder','url'=>'/founder']];
require ROOT_PATH . '/app/views/components/page-hero.php';
?>
<?php if($hasVerifiedProfile): ?>
<section class="section"><div class="container founder-layout"><div><?php if($profile['photo']): ?><img class="founder-photo" src="<?= h(url($profile['photo'])) ?>" alt="<?= h($profile['photo_alt']) ?>" width="720" height="900"><?php else: ?><div class="founder-placeholder founder-placeholder--large" aria-label="Founder photograph has not been supplied"><?= icon('person') ?></div><?php endif; ?></div><div><p class="eyebrow"><?= h($profile['headline']) ?></p><h2>From teaching technology to building technology.</h2><p class="standfirst"><?= h($profile['journey']) ?></p><?php if($profile['full_story']): ?><div class="prose"><p><?= nl2br(h($profile['full_story'])) ?></p></div><?php endif; ?><?php if($profile['availability']): ?><div class="availability"><h3>Available for</h3><?php foreach($profile['availability'] as $item): ?><span><?= h($item) ?></span><?php endforeach; ?></div><?php endif; ?></div></div></section>
<?php if($profile['expertise']): ?><section class="section section--soft"><div class="container"><div class="section-heading"><p class="eyebrow">Areas of expertise</p><h2>Professional focus.</h2></div><ul class="feature-list"><?php foreach($profile['expertise'] as $item): ?><li><?= icon('check') ?><span><?= h($item) ?></span></li><?php endforeach; ?></ul></div></section><?php endif; ?>
<?php $ctaTitle='Invite the founder to speak, train or consult.'; $ctaText='Share the audience, topic, location and intended outcome so availability can be discussed.'; require ROOT_PATH . '/app/views/components/cta.php'; ?>
<?php else: ?>
<section class="section"><div class="container narrow"><p class="eyebrow">Profile verification</p><h2>A verified founder profile is being prepared.</h2><p class="standfirst">Until biographical details, media and availability are confirmed, SkillsPark shares its work and education technology platform through the pages below.</p><div class="button-row"><a class="button" href="<?= h(url('/about')) ?>">About SkillsPark</a><a class="button button--outline" href="<?= h(url('/edixpark')) ?>">Explore EdixPark</a></div></div></section>
<?php endif; ?>
<section class="section section--navy"><div class="container story-block__grid"><div><p class="eyebrow">SkillsPark</p><h2>Developing people and helping organizations apply technology.</h2><a class="text-link text-link--light" href="<?= h(url('/about')) ?>">About SkillsPark <?= icon('arrow') ?></a></div><div><p class="eyebrow">EdixPark</p><h2>Building digital infrastructure for education.</h2><a class="text-link text-link--light" href="<?= h(url('/edixpark')) ?>">Explore EdixPark <?= icon('arrow') ?></a></div></div></section>
