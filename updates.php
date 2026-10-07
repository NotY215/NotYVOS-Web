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
<p>A visual record of the operating system as it evolves.</p>
</section>
<section class="section-shell section">
<div class="section-heading">
<span class="eyebrow">SCREENSHOTS</span>
<h2>Recent development snapshots</h2>
<p>Recent visual development snapshots.</p>
</div>
<?php if (!$files): ?>
<div class="empty-state"><strong>No updates published yet.</strong><span>Development screenshots will appear here.</span></div>
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