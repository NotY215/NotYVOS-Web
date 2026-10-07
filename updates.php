<?php
$pageTitle='Updates | NotYVOS';
$pageDescription='Screenshots and visual development updates from the NotYVOS project.';
$currentPage='updates';
$canonicalUrl='http://notyvos.gt.tc/Updates/';
require __DIR__.'/includes/header.php';

$files = glob(__DIR__.'/Updates/*.{png,jpg,jpeg,webp,gif}', GLOB_BRACE) ?: [];
usort($files, function($a,$b) {
    return strnatcasecmp(basename($b), basename($a));
});
?>
<main>
<section class="page-hero section-shell">
<span class="eyebrow">PROJECT UPDATES</span>
<h1>Updates from the build.</h1>
<p>This page shows visual progress through screenshots stored directly in the website repository.</p>
</section>
<section class="section-shell section">
<div class="section-heading">
<span class="eyebrow">SCREENSHOTS</span>
<h2>Recent development snapshots</h2>
<p>Drop screenshots into the <code>Updates/</code> folder in GitHub. The site automatically lists supported image files here, newest numbered updates first.</p>
</div>
<?php if (!$files): ?>
<div class="empty-state"><strong>No screenshots yet.</strong><span>Add numbered images such as <code>1.png</code>, <code>2.png</code> or <code>3.webp</code> to <code>Updates/</code>.</span></div>
<?php else: ?>
<div class="updates-grid">
<?php foreach ($files as $file):
$name=basename($file);
$src='/Updates/'.rawurlencode($name);
?>
<article class="update-card reveal">
<a href="<?= htmlspecialchars($src) ?>" target="_blank" rel="noopener">
<img src="<?= htmlspecialchars($src) ?>" alt="NotYVOS update <?= htmlspecialchars(pathinfo($name, PATHINFO_FILENAME)) ?>" loading="lazy">
</a>
<div class="update-caption"><strong>Update <?= htmlspecialchars(pathinfo($name, PATHINFO_FILENAME)) ?></strong><span><?= htmlspecialchars($name) ?></span></div>
</article>
<?php endforeach; ?>
</div>
<?php endif; ?>
</section>
</main>
<?php require __DIR__.'/includes/footer.php'; ?>