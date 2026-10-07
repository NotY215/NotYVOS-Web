<?php
$nav=['home'=>['Home','index.php'],'about'=>['About','about.php'],'architecture'=>['Architecture','architecture.php'],'docs'=>['Docs','docs.php'],'roadmap'=>['Roadmap','roadmap.php'],'faq'=>['FAQ','faq.php'],'developer'=>['Developer','developer.php']];
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#06101c"><meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'NotYVOS operating system project website.') ?>"><meta name="robots" content="index,follow">
<title><?= htmlspecialchars($pageTitle ?? 'NotYVOS') ?></title>
<link rel="icon" href="https://raw.githubusercontent.com/NotY215/NotYVOS/main/Assets/Neon%20Blue%20NotYVOS%20Tech%20Logo.png">
<link rel="stylesheet" href="assets/css/style.css"><script defer src="assets/js/app.js"></script></head>
<body><div class="site-bg" aria-hidden="true"><span></span><span></span><span></span></div>
<header class="site-header"><div class="nav-shell">
<a class="brand" href="index.php"><img src="https://raw.githubusercontent.com/NotY215/NotYVOS/main/Assets/Neon%20Blue%20NotYVOS%20Tech%20Logo.png" alt=""><span>NotYVOS</span></a>
<button class="menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false"><span></span><span></span><span></span></button>
<nav class="main-nav" id="main-nav"><?php foreach($nav as $key=>[$label,$url]): ?><a class="<?= $currentPage===$key?'active':'' ?>" href="<?= $url ?>"><?= htmlspecialchars($label) ?></a><?php endforeach; ?><a class="github-link" href="https://github.com/NotY215/NotYVOS" target="_blank" rel="noopener">GitHub ↗</a></nav>
</div></header>