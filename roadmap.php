<?php
$pageTitle = 'NotYVOS Roadmap';
$pageDescription = 'Current NotYVOS roadmap, delivered phases, queued work and explicit exclusions.';
$currentPage = 'roadmap';
$canonicalUrl = 'http://notyvos.gt.tc/Roadmap/';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero section-shell">
  <span class="eyebrow">ROADMAP</span>
  <h1>Delivered, active and queued.</h1>
  <p>Phases 01–16 are complete. Phase 17 is currently in progress. Later phases remain queued.</p>
</section>

<section class="section-shell section">
  <div class="roadmap-legend">
    <span class="legend done">Finished</span>
    <span class="legend working">Working</span>
    <span class="legend soon">Soon</span>
  </div>
  <div class="timeline">
<?php
$items = [
  ['01', 'Kernel Foundation', 'done'],
  ['02', 'Memory Management', 'done'],
  ['03', 'Scheduler', 'done'],
  ['04', 'Storage Foundation', 'done'],
  ['05', 'Graphics Foundation', 'done'],
  ['06', 'Desktop Foundation', 'done'],
  ['07', 'PS3 Runtime Foundation', 'done'],
  ['08', 'GameRunner Foundation', 'done'],
  ['09', 'Image Decoders', 'done'],
  ['10', 'SVG + Icons', 'done'],
  ['11', 'TrueType', 'done'],
  ['12', 'Explorer 10G', 'done'],
  ['13', 'Clipboard + Dialogs', 'done'],
  ['14', 'GameRunner Integration', 'done'],
  ['15', 'USB + Unified Input', 'done'],
  ['16', 'Networking', 'done'],
  ['17', 'Wi-Fi', 'working'],
  ['18', 'Bluetooth', 'soon'],
  ['19', 'NYFS Maturity', 'soon'],
  ['20', 'Firewall', 'soon'],
  ['21', 'NotYVFirm', 'soon'],
];
foreach ($items as [$phase, $name, $status]):
?>
    <article class="timeline-item <?= $status ?>">
      <div class="timeline-dot"></div>
      <div>
        <span class="phase"><?= htmlspecialchars($phase) ?></span>
        <h3><?= htmlspecialchars($name) ?></h3>
        <span class="status"><?= htmlspecialchars(strtoupper($status)) ?></span>
      </div>
    </article>
<?php endforeach; ?>
  </div>
</section>

<section class="section-shell section tinted">
  <div class="section-heading">
    <span class="eyebrow">CURRENT MILESTONE</span>
    <h2>Phase 17: Wi-Fi</h2>
    <p>Phases 01–16 are complete. Phase 17 is the current active engineering phase, focused on the native Wi-Fi driver, wireless management and desktop integration.</p>
  </div>
</section>

<section class="section-shell section">
  <div class="section-heading">
    <span class="eyebrow">EXPLICIT EXCLUSIONS</span>
    <h2>Not on the current roadmap</h2>
    <p>Windows PE/Win32 compatibility, Brave validation and VLC validation are explicitly excluded from the current queue.</p>
  </div>
</section>

<section class="section-shell section">
  <div class="section-heading">
    <span class="eyebrow">CANONICAL SOURCE</span>
    <h2>Always check the main roadmap for implementation detail.</h2>
    <a class="button secondary" href="https://github.com/NotY215/NotYVOS/blob/main/docs/roadmap.md" target="_blank" rel="noopener">Open roadmap.md ↗</a>
  </div>
</section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
