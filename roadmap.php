<?php
$pageTitle = 'NotYVOS Roadmap';
$pageDescription = 'NotYVOS development roadmap with completed, active and planned phases.';
$currentPage = 'roadmap';
$canonicalUrl = 'http://notyvos.gt.tc/Roadmap/';

$defaultPhases = [
    ['01','Kernel Foundation','Native x86-64 kernel foundation, boot path, interrupts, CPU/SMP and core kernel services.','completed'],
    ['02','Memory Management','PMM, VMM, paging, higher-half mappings and kernel heap foundation.','completed'],
    ['03','Scheduler','Task scheduling, execution infrastructure and process isolation foundation.','completed'],
    ['04','Storage Foundation','VFS, initramfs and the initial NYFS storage path.','completed'],
    ['05','Graphics Foundation','Graphics HAL, framebuffer rendering and compositor foundation.','completed'],
    ['06','Desktop Foundation','Desktop shell, windows, Explorer, Settings, dialogs and core interaction.','completed'],
    ['07','PS3 Runtime Foundation','PS3 ABI, PPU/SPU execution, DMA, JIT and RSX runtime foundations.','completed'],
    ['08','GameRunner Foundation','GameRunner integration with the PS3 runtime and native graphics services.','completed'],
    ['09','Image Decoders','BMP, PNG, GIF, ICO and JPEG support in the native image pipeline.','completed'],
    ['10','SVG + Icons','SVG rendering and native desktop icon infrastructure.','completed'],
    ['11','TrueType','Native TrueType rendering and the Inter desktop font path.','completed'],
    ['12','Explorer 10G','Explorer grid/details view, breadcrumbs and real VFS file operations.','completed'],
    ['13','Clipboard + Dialogs','Global clipboard routing, text/file transfers and desktop dialogs.','completed'],
    ['14','GameRunner Integration','Game session lifecycle, configuration persistence and NYFS save-data integration.','completed'],
    ['15','USB + Unified Input','xHCI, USB enumeration, HID keyboard/mouse, mass storage and unified input.','completed'],
    ['16','Networking','Ethernet, ARP, IPv4, ICMP, UDP, TCP, DHCP, DNS and socket foundations.','completed'],
    ['17','Wi-Fi','Native wireless networking, device management and desktop integration.','working'],
    ['18','Bluetooth','Bluetooth transport and supported input-device integration.','soon'],
    ['19','NYFS Maturity','Journaling, crash recovery, scaling and filesystem integrity improvements.','soon'],
    ['20','Firewall','Native firewall policy, filtering and Settings integration.','soon'],
    ['21','NotYFirm','Native firmware domain and the next-stage boot/runtime boundary.','soon']
];

$roadmapPath = __DIR__ . '/roadmap.json';
$roadmap = is_file($roadmapPath) ? json_decode((string)file_get_contents($roadmapPath), true) : null;
$phases = is_array($roadmap['phases'] ?? null) ? $roadmap['phases'] : [];

if (count($phases) < 21) {
    $phases = [];
    foreach ($defaultPhases as $phase) {
        $phases[] = ['id'=>$phase[0], 'name'=>$phase[1], 'description'=>$phase[2], 'status'=>$phase[3]];
    }
}

$currentPhase = '17';
foreach ($phases as $phase) {
    if (($phase['status'] ?? '') === 'working') {
        $currentPhase = (string)($phase['id'] ?? '17');
        break;
    }
}

$current = null;
foreach ($phases as $phase) {
    if ((string)($phase['id'] ?? '') === $currentPhase) {
        $current = $phase;
        break;
    }
}

$completedCount = count(array_filter($phases, static fn($phase) => ($phase['status'] ?? '') === 'completed'));
require __DIR__ . '/includes/header.php';
?>
<main class="roadmap-page" data-roadmap-current="<?= htmlspecialchars($currentPhase, ENT_QUOTES, 'UTF-8') ?>">
<section class="page-hero section-shell roadmap-hero">
  <span class="eyebrow">DEVELOPMENT ROADMAP</span>
  <h1>NotYVOS, phase by phase.</h1>
  <p>Track the operating system from its native kernel foundations through networking, wireless support, filesystem maturity and the next firmware boundary.</p>
  <div class="roadmap-current"><span class="roadmap-current-dot"></span><span>PHASE <?= htmlspecialchars($currentPhase) ?> · <?= htmlspecialchars(strtoupper($current['name'] ?? 'WI-FI')) ?></span></div>
</section>

<section class="section-shell section roadmap-section">
  <div class="roadmap-head">
    <div class="section-heading">
      <span class="eyebrow">PROGRESS</span>
      <h2>Roadmap</h2>
      <p><?= $completedCount ?> of <?= count($phases) ?> phases are complete. Phase <?= htmlspecialchars($currentPhase) ?> is the active engineering target.</p>
    </div>
    <div class="roadmap-legend">
      <span class="roadmap-legend-item"><span class="roadmap-legend-check">✓</span> Completed</span>
      <span class="roadmap-legend-item"><span class="roadmap-legend-working"></span> Working</span>
      <span class="roadmap-legend-item"><span class="roadmap-legend-planned"></span> Planned</span>
    </div>
  </div>

  <div class="roadmap-timeline">
<?php foreach ($phases as $phase):
    $status = in_array(($phase['status'] ?? ''), ['completed','working','soon'], true) ? $phase['status'] : 'soon';
    $id = (string)($phase['id'] ?? '');
    $statusLabel = $status === 'completed' ? 'COMPLETED' : ($status === 'working' ? 'WORKING' : 'PLANNED');
    $marker = $status === 'completed' ? '✓' : ($status === 'working' ? '●' : '—');
?>
    <article class="roadmap-phase roadmap-phase-<?= htmlspecialchars($status) ?><?= $status === 'working' ? ' roadmap-phase-active' : '' ?>" id="roadmap-phase-<?= htmlspecialchars($id) ?>" data-phase="<?= htmlspecialchars($id) ?>" data-status="<?= htmlspecialchars($status) ?>">
      <div class="roadmap-phase-marker"><?= $marker ?></div>
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

<section class="section-shell section roadmap-source">
  <div class="section-heading">
    <span class="eyebrow">CANONICAL DATA</span>
    <h2>One roadmap source.</h2>
    <p>The roadmap is maintained in <code>roadmap.json</code>. The page contains a safe built-in fallback so the public timeline never becomes empty when a remote or file request fails.</p>
    <a class="button secondary" href="https://github.com/NotY215/NotYVOS-Web/blob/main/roadmap.json" target="_blank" rel="noopener">Open roadmap.json ↗</a>
  </div>
</section>
</main>
<script src="/assets/js/roadmap.js?v=<?= rawurlencode(date('YmdHi')) ?>" defer></script>
<?php require __DIR__ . '/includes/footer.php'; ?>