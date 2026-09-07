<?php

declare(strict_types=1);

// evidence_status is an internal editorial control: verified, needs_details,
// needs_media, needs_permission or draft. It is never displayed publicly.
return [
    'areas' => [
        ['id' => 'international-partnerships', 'title' => 'International Partnerships', 'summary' => 'Training relationships that connect SkillsPark with institutions beyond Nigeria, published with careful verification.', 'icon' => 'handshake', 'published' => true, 'sort_order' => 1],
        ['id' => 'learner-entrepreneurship', 'title' => 'Learner Entrepreneurship', 'summary' => 'Practical learning that participants can apply to independent work, enterprise and new opportunities.', 'icon' => 'transform', 'published' => true, 'sort_order' => 2],
        ['id' => 'women-youth-skills', 'title' => 'Women & Youth Skills', 'summary' => 'Accessible creative and technology learning that supports young people in applying useful skills.', 'icon' => 'learn', 'published' => true, 'sort_order' => 3],
        ['id' => 'siwes-practical-training', 'title' => 'SIWES & Practical Training', 'summary' => 'Hands-on technology exposure that helps students connect academic learning with practical work.', 'icon' => 'code', 'published' => true, 'sort_order' => 4],
        ['id' => 'community-learning', 'title' => 'Community Learning', 'summary' => 'Free classes, workshops and online tutorials that make practical technology learning more accessible.', 'icon' => 'learn', 'published' => true, 'sort_order' => 5],
        ['id' => 'technology-solutions', 'title' => 'Technology Solutions', 'summary' => 'Design and development support for organizations creating useful technology products and digital solutions.', 'icon' => 'products', 'published' => true, 'sort_order' => 6],
    ],
    'stories' => [
        ['id' => 'dubai-training-collaboration', 'title' => 'International training partnership with Aptech Computer Training, Dubai', 'category' => 'Partnerships', 'summary' => 'In October 2024, SkillsPark entered into a strategic training partnership with Aptech Computer Training in Dubai.', 'url' => '/work/partnerships', 'evidence_status' => 'verified', 'verification_needed' => [], 'published' => true, 'sort_order' => 1],
        ['id' => 'advista-hub-outcome', 'title' => 'From learning digital skills to building Advista Hub', 'category' => 'Learner Entrepreneurship', 'summary' => 'A learner trained through SkillsPark later established Advista Hub, an advertising-focused platform using practical digital skills.', 'url' => '/work/case-studies/advista-hub-learner-outcome', 'evidence_status' => 'needs_details', 'verification_needed' => ['Learner identity and publication permission', 'Programme details', 'Launch date', 'Testimonial'], 'published' => true, 'sort_order' => 2],
        ['id' => 'women-hardware-skills', 'title' => 'Practical hardware skills creating everyday opportunities', 'category' => 'Practical Skills', 'summary' => 'SkillsPark has trained women in practical computer hardware maintenance, and some now help people solve everyday computer problems from home.', 'url' => '/work#practical-hardware-skills', 'evidence_status' => 'needs_details', 'verification_needed' => ['Programme dates and details', 'Participant permission for individual stories'], 'published' => true, 'sort_order' => 3],
        ['id' => 'community-access', 'title' => 'Learning beyond the classroom', 'category' => 'Community Learning', 'summary' => 'Free classes, practical workshops and online tutorials help more people learn at their own pace and keep developing useful skills.', 'url' => '/insights#tutorials', 'evidence_status' => 'needs_details', 'verification_needed' => ['Dates and programme records', 'Workshop details'], 'published' => true, 'sort_order' => 4],
        ['id' => 'practical-training', 'title' => 'Practical technology training', 'category' => 'Practical Learning', 'summary' => 'SkillsPark has delivered software and hardware classes for children and adults, using guided practice and hands-on work.', 'url' => '/work/case-studies', 'evidence_status' => 'verified', 'verification_needed' => [], 'published' => true, 'sort_order' => 5],
        ['id' => 'siwes-training', 'title' => 'Practical experience for SIWES students', 'category' => 'SIWES', 'summary' => 'SkillsPark has provided SIWES students with hands-on technology exposure and practical learning.', 'url' => '/training/students-and-graduates', 'evidence_status' => 'needs_details', 'verification_needed' => ['Institutions', 'Dates', 'Placement duration', 'Student counts and permissions'], 'published' => true, 'sort_order' => 6],
        ['id' => 'organization-technology-work', 'title' => 'Technology work for organizations', 'category' => 'Technology Solutions', 'summary' => 'SkillsPark also supports organizations with the design and development of technology products, websites and digital solutions.', 'url' => '/services/technology-and-software', 'evidence_status' => 'needs_media', 'verification_needed' => ['Approved project media', 'Client identities and publication permission', 'Verified project outcomes'], 'published' => true, 'sort_order' => 7],
    ],
    'tutorials' => [
        ['label' => 'Watch tutorial 1', 'url' => 'https://youtu.be/wB-Gs_zpPDo?si=9kFFZp_Pz8ZFYxEv'],
        ['label' => 'Watch tutorial 2', 'url' => 'https://youtu.be/FLK1X4-xmLM?si=14eTZI-_WG7UuNjv'],
    ],
];
