<?php
$pageTitle = 'NotYVOS Roadmap';
$pageDescription = 'NotYVOS development roadmap with completed, active and planned phases.';
$currentPage = 'roadmap';
$canonicalUrl = 'http://notyvos.gt.tc/Roadmap/';
$roadmapPath = __DIR__ . '/roadmap.json';
$roadmap = is_file($roadmapPath) ? json_decode((string)file_get_contents($roadmapPath), true) : null;
$phases = is_array($roadmap['phases'] ?? null) ? $roadmap['phases'] : [];
$currentPhase = (string)($roadmap['currentPhase'] ?? '17');
$current = null;
foreach ($phases as $phase) {
    if ((string)($phase['id'] ?? '') === $currentPhase) {
        $current = $phase;
        break;
    }
}
if (!$current && $phases) $current = $phases[count($phases) - 1];
$completedCount = count(array_filter($phases, static fn($phase) => ($phase['status'] ?? '') === 'completed'));
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero section-shell roadmap-hero">
  <span class="eyebrow">DEVELOPMENT ROADMAP</span>
  <h1>NotYVOS, phase by phase.</h1>
  <p>Track the operating system from its native kernel foundations through networking, wireless support, filesystem maturity and the next firmware boundary.</p>
  <?php if ($current): ?>
  <div class="roadmap-current">
    <span class="roadmap-current-dot"></span>
    <span>PHASE <?= htmlspecialchars($currentPhase) ?> · <?= htmlspecialchars(strtoupper($current['name'])) ?></span>
  </div>
  <?php endif; ?>
</section>

<section class="section-shell section roadmap-section">
  <div class="roadmap-head">
    <div class="section-heading">
      <span class="eyebrow">PROGRESS</span>
      <h2>Roadmap</h2>
      <p><?= $completedCount ?> of <?= count($phases) ?> phases are complete. Phase <?= htmlspecialchars($currentPhase) ?> is the active engineering target.</p>
    </div>
    <div class="roadmap-legend" aria-label="Roadmap status legend">
      <span class="roadmap-legend-item"><span class="roadmap-legend-check">✓</span> Completed</span>
      <span class="roadmap-legend-item"><span class="roadmap-legend-working"></span> Working</span>
      <span class="roadmap-legend-item"><span class="roadmap-legend-planned"></span> Planned</span>
    </div>
  </div>

  <div class="roadmap-timeline" aria-label="NotYVOS development roadmap">
<?php foreach ($phases as $phase):
    $status = (string)($phase['status'] ?? 'soon');
    $id = (string)($phase['id'] ?? '');
    $statusLabel = $status === 'completed' ? 'COMPLETED' : ($status === 'working' ? 'WORKING' : 'PLANNED');
?>
    <article class="roadmap-phase roadmap-phase-<?= htmlspecialchars($status) ?><?= $status === 'working' ? ' roadmap-phase-active' : '' ?>" id="roadmap-phase-<?= htmlspecialchars($id) ?>">
      <div class="roadmap-phase-marker"><?= $status === 'completed' ? '✓' : ($status === 'working' ? '●' : '—') ?></div>
      <div class="roadmap-phase-body">
        <div class="roadmap-phase-top">
          <span class="roadmap-phase-number">PHASE <?= htmlspecialchars($id) ?></span>
          <span class="roadmap-phase-status"><?= $statusLabel ?></span>
        </div>
        <h3><?= htmlspecialchars($phase['name'] ?? '') ?></h3>
        <p><?= htmlspecialchars($phase['description'] ?? '') ?></p>
      </div>
    </article>
<?php endforeach; ?>
  </div>
</section>

<section class="section-shell section tinted roadmap-current-section">
  <div class="section-heading">
    <span class="eyebrow">CURRENT MILESTONE</span>
    <h2>Phase <?= htmlspecialchars($currentPhase) ?>: <?= htmlspecialchars($current['name'] ?? 'Wi-Fi') ?></h2>
    <p><?= htmlspecialchars($current['description'] ?? 'Native wireless networking, device management and desktop integration.') ?></p>
  </div>
</section>

<section class="section-shell section">
  <div class="section-heading">
    <span class="eyebrow">CANONICAL DATA</span>
    <h2>One roadmap source.</h2>
    <p>The roadmap is maintained in <code>roadmap.json</code>. The website renders that data instead of keeping a second phase list in the page template.</p>
    <a class="button secondary" href="https://github.com/NotY215/NotYVOS-Web/blob/main/roadmap.json" target="_blank" rel="noopener">Open roadmap.json ↗</a>
  </div>
</section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
