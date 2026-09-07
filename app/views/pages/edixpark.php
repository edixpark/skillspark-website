<?php $product = content('edixpark'); $website = safe_external_url($product['website']); ?>
<section class="edixpark-hero">
    <div class="container edixpark-hero__grid">
        <div>
            <p class="eyebrow">Education technology</p>
            <img class="edixpark-logo" src="<?= h(asset('images/edixpark/edixpark-logo.png')) ?>" width="1600" height="305" alt="EdixPark">
            <h1>Flexible digital infrastructure for schools.</h1>
            <p class="lead"><?= h($product['summary']) ?></p>
            <div class="button-row"><a class="button" href="<?= h($website) ?>" target="_blank" rel="noopener noreferrer" aria-label="Visit EdixPark.com (opens in a new tab)">Visit EdixPark.com <?= icon('arrow') ?></a><a class="button button--outline" href="#flexibility">Explore the platform</a></div>
        </div>
        <aside class="edixpark-hero__note"><p>Built within the SkillsPark technology ecosystem.</p><p>Designed as its own platform experience for schools.</p></aside>
    </div>
</section>
<section class="section"><div class="container story-block__grid"><div><p class="eyebrow">Relationship</p><h2>Built within SkillsPark. Designed as its own platform.</h2></div><div><p>SkillsPark develops technology, skills and digital solutions. EdixPark emerged from that ecosystem as a focused education product with its own product identity, administration, platform experience and dedicated website.</p><p>It is one of SkillsPark's technology products, not a SkillsPark service or training programme.</p></div></div></section>
<section class="section section--soft"><div class="container narrow center"><p class="eyebrow">Why EdixPark exists</p><h2 class="display-small">Schools do not all operate the same way.</h2><p>EdixPark is built around flexibility, so each institution can adapt its digital infrastructure to its own structure instead of being forced into one fixed operating model.</p></div></section>
<section class="section" id="flexibility"><div class="container"><div class="section-heading"><p class="eyebrow">Flexibility</p><h2>Built around the school, not the other way around.</h2></div><div class="edixpark-flexibility"><?php foreach ($product['flexibility'] as $index => $item): ?><article><span>0<?= h($index + 1) ?></span><h3><?= h($item['title']) ?></h3><p><?= h($item['summary']) ?></p></article><?php endforeach; ?></div></div></section>
<section class="section section--navy"><div class="container story-block__grid"><div><p class="eyebrow">Product milestone</p><h2>Launched 18 May 2026.</h2><p>EdixPark was developed as part of SkillsPark's expansion into education technology. Muhammad-Dayyib Idris, founder and CEO associated with both SkillsPark Tech Hub and EdixPark, contributed to its development.</p></div><div><p class="eyebrow">Distinct product operation</p><h2>One ecosystem, a dedicated platform.</h2><p>While EdixPark was built within the SkillsPark ecosystem, it operates as a distinct product platform with its own administration, product experience and dedicated web presence.</p><a class="text-link text-link--light" href="<?= h($website) ?>" target="_blank" rel="noopener noreferrer" aria-label="Visit EdixPark.com (opens in a new tab)">Visit EdixPark.com <?= icon('arrow') ?></a></div></div></section>
<script type="application/ld+json"><?= json_for_html(['@context'=>'https://schema.org','@type'=>'SoftwareApplication','name'=>'EdixPark','description'=>$product['summary'],'url'=>$website,'applicationCategory'=>'EducationApplication','provider'=>['@type'=>'Organization','name'=>'SkillsPark Tech Hub','url'=>url('/')]]) ?></script>
