# SkillsPark content guide

Content is stored in PHP arrays under `app/content/`. Keep values as plain data, escape output in views with `h()`, use stable lowercase slugs, and set `published` to `false` until facts and permissions are verified. Run `php scripts/validate.php` after every content change.

## Add a service

Edit `app/content/services.php` and copy a complete record. Required page fields are `title`, `slug`, `icon`, `summary`, `problem`, `customers`, `deliverables`, `approach`, `process`, `faqs`, `published`, `sort_order`, `seo_title` and `seo_description`.

```php
[
    'title' => 'Service title',
    'slug' => 'service-title',
    'icon' => 'code',
    'summary' => 'One clear sentence.',
    'problem' => 'The problem this solves.',
    'customers' => ['Schools', 'Businesses'],
    'deliverables' => ['Discovery', 'Working deliverable', 'Handover'],
    'approach' => 'How SkillsPark works responsibly.',
    'process' => $commonProcess,
    'faqs' => [['q' => 'Question?', 'a' => 'Verified answer.']],
    'featured' => false,
    'published' => false,
    'sort_order' => 20,
    'seo_title' => 'Service Title | SkillsPark',
    'seo_description' => 'Specific search description.'
],
```

The route becomes `/services/service-title` automatically.

## Add a training program

Add to the `programs` array in `app/content/training.php`:

```php
[
    'title' => 'Program title',
    'slug' => 'program-title',
    'summary' => 'What participants will learn and why it matters.',
    'audience' => 'Verified intended audience',
    'skills' => ['Skill one', 'Skill two'],
    'featured' => false,
    'published' => false,
    'sort_order' => 20,
],
```

The detail URL is `/training/program/program-title`. Do not add schedules, prices or certifications until confirmed.

## Add a case study

Add to `app/content/projects.php`. Keep optional unverified fields empty; the template hides them.

```php
[
    'title' => 'Verified project title', 'slug' => 'verified-project-title',
    'category' => 'Web development', 'date' => '', 'location' => '',
    'objective' => 'Verified objective.', 'challenge' => 'Verified challenge.',
    'approach' => 'What SkillsPark did.',
    'services' => ['Web design'], 'technologies' => ['PHP'],
    'outcomes' => [], 'metrics' => [], 'testimonial' => '',
    'image' => '', 'gallery' => [], 'video' => '',
    'related_service' => 'web-design-and-development',
    'featured' => false, 'published' => false, 'sort_order' => 20,
    'seo_title' => 'Project | SkillsPark Work',
    'seo_description' => 'Verified project summary.'
],
```

Allowed categories include Training, Software, Web development, Business transformation, Creative media, 3D and animation, Hardware, Partnerships, Community programs and EdixPark.

## Add a gallery album or image

Gallery records live in `app/content/gallery.php`. Use a shared `album` value to group images. Put originals outside the public folder for safekeeping, then create WebP/AVIF derivatives with `scripts/optimize-images.sh`. Place approved web files under `public/assets/images/gallery/`.

```php
[
    'id' => 'stable-media-id',
    'album' => 'Program album name',
    'title' => 'Public title',
    'category' => 'Children’s programs',
    'type' => 'image', // image or video
    'image' => '/assets/images/gallery/file.webp',
    'srcset' => '/assets/images/gallery/file-720.webp 720w, /assets/images/gallery/file-1440.webp 1440w',
    'video_url' => '',
    'alt' => 'Objective description of the visible content.',
    'caption' => 'Public caption with no private data.',
    'date' => 'Verified date', 'location' => 'Verified location',
    'consent_confirmed' => true,
    'subject_type' => 'adult', // adult, minor, mixed or none
    'photographer' => 'Verified credit', 'image_owner' => 'Verified owner',
    'internal_permission_note' => 'Private evidence; never rendered.',
    'published' => false, 'sort_order' => 20,
],
```

Before publishing, inspect certificates, screens, IDs and records for personal information. For minors, record appropriate guardian or institutional permission. `consent_confirmed: false` always prevents public rendering.

## Add a partner

Edit `app/content/partners.php`. Supply a verified name, scope, permission, location and public summary before setting `published` to `true`. The Dubai example is intentionally unpublished and must not be used as a factual public profile until every detail is verified.

## Add an achievement

Edit `app/content/achievements.php`:

```php
['id'=>'stable-id','title'=>'Verified milestone','category'=>'Community','date'=>'Verified date','summary'=>'Factual description.','published'=>false,'sort_order'=>20],
```

Do not add awards, counts, approvals or outcomes without evidence.

## Add a testimonial

Edit `app/content/testimonials.php` only after approval:

```php
[
    'id' => 'speaker-project', 'quote' => 'Approved quotation.',
    'name' => 'Verified name', 'role' => 'Verified role',
    'organization' => 'Verified organization',
    'consent_confirmed' => true, 'published' => false, 'sort_order' => 10,
],
```

## Update the founder profile

Edit `app/content/founder.php`. Add the verified name, photograph path, accessible alt text, biographies, expertise, achievements, programs, social HTTPS URLs and media. Empty sections hide. Do not infer qualifications or achievements.

## Update EdixPark

Edit `app/content/edixpark.php`. Verify current product capabilities before changing the area descriptions. Buttons render only when a valid HTTPS URL is supplied.

## Contact, WhatsApp and social links

Copy `config/local.example.php` to `config/local.php`. Update `contact.email`, `contact.phone` and `contact.whatsapp`. WhatsApp is digits only, including country code, for example `2348012345678`. Configure social profiles in `app/content/site.php` only with verified HTTPS URLs.

## Mission and vision

Edit `mission` and `vision` in `app/content/site.php`. Comments identify the supplied wording as a draft pending founder confirmation.

## Official logo replacement

Preserve the original source outside `public/`. Create approved derivatives and replace:

- `public/assets/brand/skillspark-wordmark.svg`
- `public/assets/brand/skillspark-wordmark-light.svg` (only if an approved monochrome treatment is possible)
- `public/assets/brand/favicon.svg`
- `public/assets/brand/apple-touch-icon.svg`
- `public/assets/brand/social-card.svg`

Keep the existing SVG dimensions or update matching `width` and `height` attributes in the layout to prevent layout shift.

## Generate the sitemap

The live `/sitemap.xml` route is dynamic. To create a static copy for inspection:

```bash
php scripts/generate-sitemap.php
```

Run validation afterward. A static `public/sitemap.xml` will take precedence when served directly, so regenerate it after route changes or remove it and use the dynamic route.
