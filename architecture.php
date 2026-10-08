<?php
$pageTitle = 'NotYVOS Architecture';
$pageDescription = 'Explore the NotYVOS boot, kernel, graphics, storage and PS3 runtime architecture.';
$currentPage = 'architecture';
$canonicalUrl = 'http://notyvos.gt.tc/Architecture/';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero section-shell">
  <span class="eyebrow">SYSTEM ARCHITECTURE</span>
  <h1>From firmware handoff to desktop.</h1>
  <p>The architecture is split into clear domains so kernel, storage, graphics and runtime work can evolve without becoming one giant subsystem. Canonical facts live in the main repository docs.</p>
</section>

<section class="section-shell section">
  <div class="architecture-flow reveal">
    <div>UEFI</div><b>→</b>
    <div>Limine</div><b>→</b>
    <div>_start</div><b>→</b>
    <div>kernel_main</div><b>→</b>
    <div>scheduler + userland</div>
  </div>
</section>

<section class="section-shell section" id="kernel">
  <div class="section-heading">
    <span class="eyebrow">01 / KERNEL</span>
    <h2>CPU, memory and processes</h2>
    <p>Four-level x86-64 paging, higher-half kernel, per-process PML4, ELF64 loading, fork/wait/exec and uaccess-protected syscalls form the execution foundation.</p>
  </div>
  <div class="card-grid three">
    <article class="feature-card">
      <h3>CPU platform</h3>
      <p>GDT, TSS, IDT, ISR, PIC, PIT, LAPIC, per-CPU state and SMP bring-up.</p>
    </article>
    <article class="feature-card">
      <h3>Memory</h3>
      <p>Physical and virtual memory management, kernel heap, executable memory arena and user address spaces.</p>
    </article>
    <article class="feature-card">
      <h3>Processes</h3>
      <p>ELF64 loading, per-process page tables, fork, wait, exec, brk, mmap and file descriptors.</p>
    </article>
  </div>
</section>

<section class="section-shell section tinted" id="storage">
  <div class="section-heading">
    <span class="eyebrow">02 / STORAGE</span>
    <h2>VFS, initramfs and NYFS</h2>
    <p>VFS provides the VNode namespace and file-descriptor layer. Initramfs is a Limine-loaded ustar archive at /. NYFS is the persistent block-backed filesystem at /disk.</p>
  </div>
  <div class="card-grid three">
    <article class="feature-card">
      <h3>VFS</h3>
      <p>Path lookup, VNodes, per-task FileTable and stable read/write/seek surface.</p>
    </article>
    <article class="feature-card">
      <h3>Initramfs</h3>
      <p>ustar archive mounted at root for early userland and static assets.</p>
    </article>
    <article class="feature-card">
      <h3>NYFS</h3>
      <p>512-byte superblock, 64-entry file table, create/read/write/unlink. Development-grade; journaling is Phase 19.</p>
    </article>
  </div>
</section>

<section class="section-shell section" id="graphics">
  <div class="split">
    <div class="section-heading">
      <span class="eyebrow">03 / GRAPHICS</span>
      <h2>Graphics API → HAL → compositor</h2>
      <p>The desktop uses a software framebuffer path with a graphics abstraction that keeps drawing code separate from presentation. TrueType text feeds the compositor via draw_text.</p>
    </div>
    <div class="diagram-card">
      <div class="diagram-node">Desktop apps</div>
      <div class="diagram-arrow">↓</div>
      <div class="diagram-node">Graphics API</div>
      <div class="diagram-arrow">↓</div>
      <div class="diagram-node">HAL / backend</div>
      <div class="diagram-arrow">↓</div>
      <div class="diagram-node">Compositor → framebuffer</div>
    </div>
  </div>
  <div class="card-grid three" style="margin-top:28px">
    <article class="feature-card">
      <h3>Compositor</h3>
      <p>Background, taskbar, Start menu, windows, Alt-Tab, snap layouts, toasts and context menus.</p>
    </article>
    <article class="feature-card">
      <h3>TrueType</h3>
      <p>Inter Regular parser, 4× coverage rasterizer, per-face glyph cache and anti-aliased text.</p>
    </article>
    <article class="feature-card">
      <h3>Decoders</h3>
      <p>BMP, PNG, GIF, ICO and JPEG feed Image Viewer and the graphics pipeline.</p>
    </article>
  </div>
</section>

<section class="section-shell section tinted" id="ps3">
  <div class="section-heading">
    <span class="eyebrow">04 / PS3 RUNTIME</span>
    <h2>A separate compatibility-oriented execution path</h2>
    <p>PS3 binaries are identified and parsed, then supported PowerPC code can run through the interpreter or the baseline x86-64 JIT. RSX provides a software compatibility path for graphics commands.</p>
  </div>
  <div class="card-grid four">
    <article class="mini-card"><strong>PPU</strong><span>PowerPC decoder, interpreter and JIT</span></article>
    <article class="mini-card"><strong>SPU</strong><span>Local store and mailbox foundations</span></article>
    <article class="mini-card"><strong>DMA</strong><span>Cell-style queue and synchronization</span></article>
    <article class="mini-card"><strong>RSX</strong><span>FIFO, raster, textures, depth and mipmaps</span></article>
  </div>
</section>

<section class="section-shell section" id="devices">
  <div class="section-heading">
    <span class="eyebrow">05 / DEVICES</span>
    <h2>Native drivers and input</h2>
  </div>
  <div class="card-grid three">
    <article class="feature-card">
      <h3>Storage &amp; power</h3>
      <p>ACPI table discovery and power control; AHCI block storage.</p>
    </article>
    <article class="feature-card">
      <h3>Network &amp; audio</h3>
      <p>Intel e1000 detection/initialization; HDA audio initialization. Production stack is Phase 16.</p>
    </article>
    <article class="feature-card">
      <h3>Input</h3>
      <p>PS/2 keyboard/mouse, USB xHCI, HID and mass storage, unified input facade.</p>
    </article>
  </div>
</section>

<section class="section-shell section">
  <div class="section-heading">
    <span class="eyebrow">SOURCE DOCUMENTS</span>
    <h2>Go deeper</h2>
    <p>Canonical architecture diagrams, data-flow Mermaid sources and decision records live in the main project repository.</p>
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:18px">
      <a class="button secondary" href="https://github.com/NotY215/NotYVOS/blob/main/docs/architecture.md" target="_blank" rel="noopener">architecture.md ↗</a>
      <a class="button secondary" href="https://github.com/NotY215/NotYVOS/blob/main/docs/data%20flow.md" target="_blank" rel="noopener">data flow.md ↗</a>
      <a class="button secondary" href="/Documentation/" rel="noopener">Full documentation →</a>
    </div>
  </div>
</section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
