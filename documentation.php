<?php
$pageTitle = 'NotYVOS Documentation';
$pageDescription = 'The complete NotYVOS technical documentation, architecture, decisions, roadmap, subsystem reference and interactive diagrams.';
$currentPage = 'docs';
$canonicalUrl = 'http://notyvos.gt.tc/Documentation/';
require __DIR__ . '/includes/header.php';

$sections = [
    'overview' => ['Overview', 'Project'],
    'architecture' => ['Architecture', 'Core'],
    'boot' => ['Boot & Kernel', 'Core'],
    'memory' => ['Memory & Scheduler', 'Core'],
    'storage' => ['Storage & NYFS', 'Core'],
    'graphics' => ['Graphics & Desktop', 'Graphics'],
    'ps3' => ['PS3 Runtime', 'PS3'],
    'game' => ['GameRunner', 'PS3'],
    'toolchain' => ['Build & Toolchain', 'Development'],
    'testing' => ['Testing', 'Development'],
    'fonts' => ['Fonts & Text', 'Graphics'],
    'screens' => ['Screenshots', 'Visuals'],
    'roadmap' => ['Roadmap', 'Project'],
    'decisions' => ['Architecture Decisions', 'Decisions'],
    'security' => ['Security & Firmware', 'Security'],
    'dataflow' => ['Data Flow', 'Visuals'],
];

$decisions = [
 ['ADR-0001','Use Limine as the boot protocol','Limine is the selected bootloader protocol because it provides a modern, documented handoff into the native x86-64 kernel while keeping early boot code small.'],
 ['ADR-0002','Use Clang + LLVM for the kernel toolchain','The kernel is built around the Clang/LLVM toolchain so C++ can remain the primary implementation language while retaining LLVM diagnostics and code-generation infrastructure.'],
 ['ADR-0003','AGPL-3 license','The project uses AGPL-3 for the operating-system source and hosted modifications, with third-party components remaining under their own licenses.'],
 ['ADR-0004','C++ is the primary language','C++ is the primary native implementation language. C, assembly, linker scripts and small utility languages remain allowed where the platform boundary requires them.'],
 ['ADR-0005','PS3 firmware isolation','PS3 firmware is treated as developer-supplied firmware data and is kept isolated from the public source distribution. The build path can connect it to GameRunner without making the firmware part of the repository distribution.'],
 ['ADR-0006','No Sony keys embedded','The project does not embed or distribute Sony private keys or other protected signing material. Developer-owned runtime material remains outside the public source tree.'],
 ['ADR-0007','Windows compatibility is a later boundary','Windows executable compatibility is deliberately separated from the native OS core. The old compatibility milestone is not treated as a prerequisite for the native kernel and desktop roadmap.'],
 ['ADR-0008','Reserved domains are not created yet','Future network domains and services are documented as reserved names rather than represented as existing services.'],
 ['ADR-0009','Inter is the default UI font','Inter is the default TrueType UI font because the renderer already supports TrueType and Inter provides a consistent readable desktop baseline.'],
];

$roadmap = [
 ['0-10','Frozen foundation','Kernel, memory, scheduler, storage foundations, graphics, RSX work, GameRunner foundations, decoders, desktop foundations, SVG/icon work and the initial TrueType renderer are delivered.','done'],
 ['11','TrueType','Inter-Regular is the default font and the TrueType renderer is integrated into the desktop text path.','done'],
 ['12','Explorer 10G','Explorer receives the next-generation desktop file-browser milestone and the related shell/UI integration.','done'],
 ['13','Clipboard and dialogs','Clipboard infrastructure, dialogs and desktop interaction primitives are integrated.','done'],
 ['14','GameRunner','GameRunner receives the next native PS3 runtime integration milestone.','next'],
 ['15','USB and unified input','USB input and the unified input path cover the current controller/keyboard/mouse foundation.','done'],
 ['16','Networking','Native network stack and network device integration.','queued'],
 ['17','Wi-Fi','Wireless networking built on top of the network layer.','queued'],
 ['18','Bluetooth','Bluetooth transport and supported input-device integration.','queued'],
 ['19','NYFS','NYFS receives the next storage and filesystem milestone after the hardware/network work.','queued'],
 ['20','Firewall','Host/network firewall policy and enforcement.','queued'],
 ['21','NotYVFirm','NotYVOS firmware/service layer milestone.','queued'],
];

$subsystems = [
 ['Kernel','92%','x86-64 kernel foundation, interrupt path, core services and current init-program debugging.'],
 ['Memory','95%','Physical/virtual memory management and heap foundations.'],
 ['Scheduler','85%','Task scheduling and execution infrastructure.'],
 ['NYFS','55%','Native filesystem work remains active.'],
 ['Graphics','85%','Graphics API/HAL and desktop rendering foundation.'],
 ['RSX','65%','PS3 RSX graphics work including the current delivered rendering path.'],
 ['PPU/SPU/DMA/JIT','70%','PS3 CPU/runtime translation and execution infrastructure.'],
 ['Desktop UI','70%','Compositor, shell, Explorer, dialogs and desktop interaction.'],
 ['Decoders','90%','BMP, PNG, GIF, ICO and JPEG support delivered.'],
 ['SVG + icons','85%','SVG/icon rendering and desktop icon infrastructure.'],
 ['TrueType','75%','TrueType renderer with Inter integration.'],
];

$diagram = [
 'boot' => "flowchart TD
    A[UEFI / Firmware] --> B[Limine]
    B --> C[x86-64 Kernel Entry]
    C --> D[CPU + SMP]
    D --> E[Memory Manager]
    E --> F[Scheduler]
    F --> G[Kernel Services]
    G --> H[VFS]
    H --> I[NYFS]
    G --> J[Graphics HAL]
    J --> K[Compositor]
    K --> L[Desktop / Explorer]",
 'runtime' => "flowchart LR
    A[GameRunner] --> B[PS3 ABI]
    B --> C[PPU]
    B --> D[SPU]
    C --> E[JIT / Translator]
    D --> F[DMA]
    C --> G[RSX]
    G --> H[Graphics HAL]
    H --> I[Compositor]",
 'data' => "flowchart TD
    RTC[RTC / CMOS] --> READ[rtc read]
    READ --> CLOCK[System clock]
    CLOCK --> COMP[Compositor]
    INPUT[USB / Unified Input] --> EVENT[Input events]
    EVENT --> DESKTOP[Desktop / Explorer]
    VFS[VFS] --> NYFS[NYFS]
    NYFS --> FILES[Files]
    FILES --> EXPLORER[Explorer]
    SYSCALL[Syscalls] --> VFS
    SYSCALL --> MEMORY[Memory manager]
    SYSCALL --> GRAPHICS[Graphics HAL]",
 'ps3' => "flowchart TD
    GAME[GameRunner] --> ABI[PS3 ABI]
    ABI --> PPU[PPU execution]
    ABI --> SPU[SPU execution]
    PPU --> JIT[JIT / translation]
    SPU --> DMA[DMA]
    PPU --> RSX[RSX]
    DMA --> RSX
    RSX --> HAL[Graphics HAL]
    HAL --> COMP[Compositor]",
];

$heroCards = [
 ['01','NATIVE CORE','x86-64 kernel','Native kernel, memory, scheduler, services and storage foundations.'],
 ['02','GRAPHICS','RSX + desktop','Graphics HAL, compositor, SVG/icons and TrueType rendering.'],
 ['03','PS3','GameRunner','PPU, SPU, DMA, JIT and RSX runtime architecture.'],
 ['04','PROJECT','Roadmap','Delivered foundation plus the active networking and firmware queue.'],
];
?>
<main class="docs-page docs-war">
<section class="docs-hero">
  <div class="docs-stars" aria-hidden="true"></div>
  <div class="docs-runes" aria-hidden="true">ᛉ　ᛏ　ᛟ　ᚾ　ᛁ　ᛋ　ᛏ　ᚱ　ᚨ　ᚾ</div>
  <div class="section-shell docs-hero-inner">
    <div class="docs-kicker"><span>NOTYVOS</span><i></i><span>PS3 // TECHNICAL CODEX</span></div>
    <h1>THE ARCHITECTURE<br><em>BEHIND NOTYVOS</em></h1>
    <p class="docs-hero-copy">A complete native x86-64 operating-system reference covering the kernel, memory, scheduler, NYFS, graphics, desktop, PS3 runtime, GameRunner, toolchain, decisions and roadmap.</p>
    <div class="docs-hero-actions">
      <button class="docs-primary" data-jump="overview">Open Documentation</button>
      <button class="docs-secondary" data-jump="architecture">View Architecture</button>
    </div>
    <div class="docs-hero-cards">
      <?php foreach ($heroCards as $c): ?>
      <article class="docs-hero-card"><small><?=htmlspecialchars($c[0])?></small><span><?=htmlspecialchars($c[1])?></span><h3><?=htmlspecialchars($c[2])?></h3><p><?=htmlspecialchars($c[3])?></p></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="docs-shell section-shell">
  <aside class="docs-index">
    <div class="docs-index-title"><span>CODEX</span><b id="docs-progress">0%</b></div>
    <div class="docs-search"><input id="docs-search" type="search" placeholder="Search the codex..." aria-label="Search documentation"></div>
    <nav id="docs-index-nav">
      <?php $lastGroup=''; foreach ($sections as $id=>$s): if($s[1]!==$lastGroup): $lastGroup=$s[1]; echo '<div class="docs-group">'.htmlspecialchars($lastGroup).'</div>'; endif; ?>
      <button class="docs-link" data-section="<?=htmlspecialchars($id)?>"><span></span><?=htmlspecialchars($s[0])?></button>
      <?php endforeach; ?>
    </nav>
    <div class="docs-index-foot"><span>STATUS</span><strong><i></i> DOCUMENTATION ONLINE</strong></div>
  </aside>

  <div class="docs-content" id="docs-content">
    <section class="docs-section" id="overview" data-title="Overview">
      <div class="docs-eyebrow">01 · PROJECT</div><h2>What is NotYVOS?</h2>
      <p>NotYVOS is a native x86-64 operating system project built around its own kernel, memory manager, scheduler, filesystem, graphics stack, desktop environment and PS3 runtime research. The project is not a themed Linux distribution. Its core objective is a native platform where the low-level execution path, storage path, rendering path and runtime services are controlled by the project.</p>
      <div class="docs-callout"><b>Design rule</b><span>Native first. Compatibility layers are boundaries around the OS, not the definition of the OS.</span></div>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">PLATFORM</span><h3>x86-64 native target</h3><p>The kernel and desktop are designed around the x86-64 execution environment, with SMP, virtual memory, interrupts, native storage and graphics services forming the base.</p></article>
        <article class="docs-panel"><span class="panel-tag">RUNTIME</span><h3>PS3-oriented subsystem</h3><p>GameRunner models PS3 execution through PPU, SPU, DMA, JIT and RSX components rather than making the PS3 runtime the kernel itself.</p></article>
      </div>
      <div class="docs-table-wrap"><table class="docs-table"><thead><tr><th>Layer</th><th>Responsibility</th><th>Current direction</th></tr></thead><tbody>
      <tr><td>Boot</td><td>Firmware handoff and kernel entry</td><td>Limine-based boot path</td></tr>
      <tr><td>Kernel</td><td>CPU, memory, scheduling and system services</td><td>Native x86-64</td></tr>
      <tr><td>Storage</td><td>VFS and NYFS</td><td>Native filesystem</td></tr>
      <tr><td>Graphics</td><td>HAL, compositor, RSX integration</td><td>Native rendering</td></tr>
      <tr><td>Desktop</td><td>Explorer, dialogs, clipboard, input</td><td>Active integration</td></tr>
      <tr><td>PS3</td><td>PPU, SPU, DMA, JIT, RSX, GameRunner</td><td>Runtime integration</td></tr>
      </tbody></table></div>
    </section>

    <section class="docs-section" id="architecture">
      <div class="docs-eyebrow">02 · CORE</div><h2>System Architecture</h2>
      <p>The architecture is layered. Boot establishes the kernel environment, the kernel owns execution and resource primitives, VFS and NYFS own storage, the graphics layer owns rendering, the compositor presents the desktop, and GameRunner consumes runtime services without replacing the kernel.</p>
      <div class="diagram-frame"><div class="diagram-title"><span>LIVE MERMAID</span><b>Native boot to desktop</b></div><pre class="mermaid"><?=htmlspecialchars($diagram['boot'])?></pre></div>
      <div class="docs-grid three">
        <article class="docs-panel"><span class="panel-tag">BOOT</span><h3>UEFI → Limine</h3><p>Limine v12.9.0 supplies the framebuffer, memory map, HHDM, SMP/MP, module and RSDP information consumed by the native kernel.</p></article>
        <article class="docs-panel"><span class="panel-tag">KERNEL</span><h3>Execution core</h3><p>CPU/SMP, four-level paging, higher-half mappings, PMM, VMM, heap, scheduler, syscalls and user-fault isolation form the execution foundation.</p></article>
        <article class="docs-panel"><span class="panel-tag">USER SPACE</span><h3>Desktop services</h3><p>ELF processes, VFS, initramfs, NYFS, shell, Explorer, Settings, clipboard, input and GameRunner sit above explicit service boundaries.</p></article>
      </div>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">PROCESS MODEL</span><h3>ELF64 + per-process PML4</h3><p>The ELF loader validates ELF64/x86-64 files, maps PT_LOAD segments into newly allocated user pages, creates a user stack and records the process entry and stack addresses. fork clones user-visible mappings into a child address space. Processes retain parent/child links, file tables, working-directory state, exit status and reaping state.</p></article>
        <article class="docs-panel"><span class="panel-tag">UACCESS</span><h3>Kernel/user memory boundary</h3><p>Syscalls enter through the x86-64 assembly entry path and are dispatched by the kernel. User pointers pass through the uaccess layer instead of being trusted directly. Current operations include process control, file operations, directory enumeration, mmap, exec, heap extension, time/sleep, signal/termination and NYFS file creation/removal.</p></article>
      </div>
      <div class="docs-grid three">
        <article class="docs-panel"><span class="panel-tag">DEVICES</span><h3>Native device domains</h3><p>Implemented domains include ACPI, AHCI, Intel e1000 detection/initialization, HDA audio initialization, PS/2 keyboard/mouse and LAPIC/per-CPU/SMP infrastructure.</p></article>
        <article class="docs-panel"><span class="panel-tag">FILESYSTEM</span><h3>VFS + initramfs + NYFS</h3><p>VFS provides a VNode namespace and file-descriptor layer. The initramfs is a Limine-loaded ustar archive mounted at /. NYFS is mounted at /disk and currently uses a 512-byte superblock, fixed 64-entry file table and following data sectors.</p></article>
        <article class="docs-panel"><span class="panel-tag">IMAGE PIPELINE</span><h3>Decode → pixel buffer → compositor</h3><p>BMP, PNG, GIF, ICO and JPEG decoders feed Image Viewer and the Graphics API. The resulting pixels travel through the compositor to the framebuffer.</p></article>
      </div>
    </section>

    <section class="docs-section" id="boot">
      <div class="docs-eyebrow">03 · CORE</div><h2>Boot, Kernel and Init</h2>
      <p>The boot path is intentionally explicit: firmware, boot protocol, kernel entry, processor setup, memory setup, scheduler and system services. Current development includes init-program debugging before the next major GameRunner integration milestone.</p>
      <ol class="docs-steps">
        <li><b>1 · UEFI</b><span>Firmware loads the Limine boot environment.</span></li>
        <li><b>2 · Limine</b><span>Loads notyvos-kernel.elf and configured modules.</span></li>
        <li><b>3 · Boot requests</b><span>Framebuffer, memory-map, HHDM, SMP/MP, module and RSDP information is made available.</span></li>
        <li><b>4 · _start</b><span>Kernel entry establishes the entry stack and transfers to kernel_main.</span></li>
        <li><b>5 · kernel_main</b><span>Serial output, framebuffer console and logging become available.</span></li>
        <li><b>6 · CPU + memory</b><span>CPU features, PMM, VMM, kernel heap and executable memory arena initialize.</span></li>
        <li><b>7 · devices</b><span>ACPI, AHCI, e1000, HDA, LAPIC/per-CPU and SMP domains initialize.</span></li>
        <li><b>8 · NYFS</b><span>NYFS mounts on the first available block device; development formatting occurs if no valid superblock exists.</span></li>
        <li><b>9 · initramfs</b><span>The Limine module is parsed as ustar and mounted at /. NYFS is attached as /disk.</span></li>
        <li><b>10 · compositor</b><span>Framebuffer console switches into buffered desktop rendering.</span></li>
        <li><b>11 · graphics</b><span>Software and VBE graphics backends register and initialize.</span></li>
        <li><b>12 · PS3 runtime</b><span>Translation cache and RSX state initialize, followed by decoder, ELF, PPU, SPU, DMA, JIT and RSX self-tests.</span></li>
        <li><b>13 · scheduler</b><span>The task scheduler is initialized.</span></li>
        <li><b>14 · init.elf</b><span>init.elf is loaded as an x86-64 user process with its own address space and user stack.</span></li>
        <li><b>15 · interrupts</b><span>Interrupts are enabled and the scheduler starts init.</span></li>
        <li><b>16 · shell</b><span>The user shell becomes the primary interactive userland process.</span></li>
      </ol>
      <div class="docs-callout"><b>ISO modules</b><span>Current boot media supplies <code>notyvos-kernel.elf</code>, <code>init.elf</code> and <code>initramfs.tar</code>. An optional converted wallpaper can also be included.</span></div>
    </section>

    <section class="docs-section" id="memory">
      <div class="docs-eyebrow">04 · CORE</div><h2>Memory and Scheduler</h2>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">MEMORY · 95%</span><h3>PMM / VMM / heap</h3><p>Physical memory management, virtual address management and dynamic allocation form the resource layer used by kernel services and higher-level components.</p></article>
        <article class="docs-panel"><span class="panel-tag">SCHEDULER · 85%</span><h3>Task execution</h3><p>The scheduler provides the execution boundary required for kernel work, services and future user programs. Init-program debugging remains an active milestone.</p></article>
      </div>
      <div class="diagram-frame"><div class="diagram-title"><span>DATA PATH</span><b>Execution and memory dependency</b></div><pre class="mermaid">flowchart LR
CPU[CPU / SMP] --> SCHED[Scheduler]
SCHED --> TASK[Tasks]
TASK --> SYSCALL[Syscalls]
SYSCALL --> MEM[Virtual Memory]
MEM --> HEAP[Kernel Heap]
MEM --> USER[User Address Space]</pre></div>
    </section>

    <section class="docs-section" id="storage">
      <div class="docs-eyebrow">05 · CORE</div><h2>Storage, VFS and NYFS</h2>
      <p>VFS is the service-facing filesystem abstraction while NYFS is the native filesystem implementation. Explorer talks to the filesystem through this boundary rather than reaching directly into block-level details.</p>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">VFS</span><h3>Stable service boundary</h3><p>Kernel services and applications use a consistent filesystem interface, keeping the concrete filesystem implementation replaceable.</p></article>
        <article class="docs-panel"><span class="panel-tag">NYFS · 55%</span><h3>Native filesystem</h3><p>NYFS remains an active roadmap area. The filesystem milestone follows the current hardware and network integration queue.</p></article>
      </div>
      <div class="diagram-frame"><pre class="mermaid">flowchart LR
APP[Application / Explorer] --> SYSCALL[Syscalls]
SYSCALL --> VFS[VFS]
VFS --> NYFS[NYFS]
NYFS --> BLOCK[Storage backend]</pre></div>
    </section>

    <section class="docs-section" id="graphics">
      <div class="docs-eyebrow">06 · GRAPHICS</div><h2>Graphics, RSX and Desktop</h2>
      <p>The graphics stack separates hardware-facing work from the compositor and desktop. SVG, icons and TrueType are integrated above the graphics foundation. RSX work belongs to the PS3-oriented graphics/runtime side and connects back through the graphics abstraction.</p>
      <div class="docs-grid three">
        <article class="docs-panel"><span class="panel-tag">GRAPHICS · 85%</span><h3>HAL / API</h3><p>Rendering services exposed to desktop components and runtime integrations.</p></article>
        <article class="docs-panel"><span class="panel-tag">RSX · 65%</span><h3>PS3 GPU path</h3><p>RSX execution and rendering work for the PS3 runtime side.</p></article>
        <article class="docs-panel"><span class="panel-tag">UI · 70%</span><h3>Compositor</h3><p>Desktop composition, windows, text, icons and visual presentation.</p></article>
      </div>
      <div class="diagram-frame"><pre class="mermaid">flowchart TD
API[Graphics API] --> HAL[Graphics HAL]
HAL --> RSX[RSX]
HAL --> COM[Compositor]
FONT[TrueType] --> COM
SVG[SVG / Icons] --> COM
COM --> DESKTOP[Desktop UI]</pre></div>
    </section>

    <section class="docs-section" id="ps3">
      <div class="docs-eyebrow">07 · PS3</div><h2>PS3 Runtime Architecture</h2>
      <p>The PS3 runtime is decomposed into execution domains rather than treated as one monolithic emulator. PPU execution, SPU execution, DMA, JIT/translation and RSX form separate responsibilities connected through runtime interfaces.</p>
      <div class="diagram-frame"><div class="diagram-title"><span>LIVE GRAPH</span><b>GameRunner execution path</b></div><pre class="mermaid"><?=htmlspecialchars($diagram['ps3'])?></pre></div>
      <div class="docs-table-wrap"><table class="docs-table"><thead><tr><th>Component</th><th>Role</th><th>Boundary</th></tr></thead><tbody>
      <tr><td>GameRunner</td><td>Runtime orchestration</td><td>OS services / PS3 ABI</td></tr>
      <tr><td>PPU</td><td>PowerPC execution</td><td>JIT / translator</td></tr>
      <tr><td>SPU</td><td>Synergistic processor execution</td><td>SPU runtime / DMA</td></tr>
      <tr><td>DMA</td><td>Data movement</td><td>SPU / memory / RSX</td></tr>
      <tr><td>RSX</td><td>Graphics processing</td><td>Graphics HAL</td></tr>
      </tbody></table></div>
    </section>

    <section class="docs-section" id="game">
      <div class="docs-eyebrow">08 · PS3</div><h2>GameRunner</h2>
      <p>GameRunner is the application/runtime boundary that connects PS3-oriented execution to NotYVOS services. The architecture keeps firmware and protected material outside the public source distribution while allowing a developer build to provide the required runtime input.</p>
      <div class="docs-callout"><b>Firmware rule</b><span>Developer firmware can be connected by the build/runtime path. The public project does not distribute protected firmware or Sony signing keys.</span></div>
      <div class="diagram-frame"><pre class="mermaid">flowchart LR
PPC[PPU PC] --> CACHE[Translation cache]
CACHE -->|miss| EMIT[x86-64 emitter]
EMIT --> ARENA[Executable arena]
ARENA --> BLOCK[Native block]
BLOCK --> TRAMP[JIT trampoline]
TRAMP --> CPU[x86-64 CPU]
CACHE -->|hit| BLOCK
BLOCK --> NEXT[Next PPC PC]
NEXT --> CACHE</pre></div>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">PPU STATE</span><h3>Register context</h3><p>The PPU context contains GPR/FPR state, PC, LR, CTR, XER and CR plus memory and syscall callbacks.</p></article>
        <article class="docs-panel"><span class="panel-tag">JIT</span><h3>Baseline translation path</h3><p>The JIT looks up the current PPC PC, translates a supported basic block on a cache miss, emits x86-64 machine code into executable memory, enters it through the trampoline and falls back to the interpreter for unsupported instructions and the current syscall boundary.</p></article>
      </div>
      <div class="docs-callout"><b>RSX status</b><span>The delivered compatibility path includes FIFO command processing, rasterization, vertex/index buffers, depth/scissor state, smooth shading, texture binding, UVs, perspective correction, wrapping and mipmap/LOD sampling. Full method and shader coverage remain outside the current boundary.</span></div>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">ABI</span><h3>PS3 ABI boundary</h3><p>Runtime code consumes an explicit PS3 ABI layer instead of depending directly on arbitrary kernel internals.</p></article>
        <article class="docs-panel"><span class="panel-tag">CELL</span><h3>cellFs direction</h3><p>PS3 filesystem semantics connect toward the native storage layer through the runtime boundary.</p></article>
      </div>
    </section>

    <section class="docs-section" id="toolchain">
      <div class="docs-eyebrow">09 · DEVELOPMENT</div><h2>Build and Toolchain</h2>
      <p>The project uses C++ as the primary implementation language with Clang/LLVM as the kernel-oriented compiler toolchain. Assembly and linker scripts are used where the architecture requires direct machine-level control.</p>
      <div class="docs-grid three">
        <article class="docs-panel"><span class="panel-tag">C++</span><h3>Primary language</h3><p>Kernel and core native implementation.</p></article>
        <article class="docs-panel"><span class="panel-tag">LLVM</span><h3>Compiler infrastructure</h3><p>Clang diagnostics and LLVM code generation ecosystem.</p></article>
        <article class="docs-panel"><span class="panel-tag">LOW LEVEL</span><h3>Assembly + linker</h3><p>Boot entry, ABI details and final image construction.</p></article>
      </div>
      <pre class="docs-code"><code>build/
  kernel/
  memory/
  scheduler/
  storage/
  graphics/
  desktop/
  gamerunner/
docs/
  decisions/
  diagrams/</code></pre>
    </section>

    <section class="docs-section" id="testing">
      <div class="docs-eyebrow">10 · DEVELOPMENT</div><h2>Testing and Validation</h2>
      <p>Testing is layered so a failure can be isolated to boot, kernel, subsystem, desktop or runtime integration. Native tests and build validation are preferred over treating the complete ISO as the only test target.</p>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">BUILD</span><h3>Static validation</h3><p>Compiler diagnostics, linker validation, source checks and build reproducibility.</p></article>
        <article class="docs-panel"><span class="panel-tag">RUNTIME</span><h3>Boot validation</h3><p>Kernel startup, init program, filesystem, graphics and GameRunner milestones are validated independently.</p></article>
      </div>
    </section>

    <section class="docs-section" id="fonts">
      <div class="docs-eyebrow">11 · GRAPHICS</div><h2>Fonts and Text Rendering</h2>
      <p>NotYVOS includes a native TrueType renderer. Inter-Regular is the default UI font. Text rendering feeds the compositor and is treated as part of the desktop graphics stack rather than a browser dependency.</p>
      <div class="diagram-frame"><pre class="mermaid">flowchart LR
FONT[Inter TrueType] --> PARSE[TrueType parser]
PARSE --> GLYPH[Glyph outlines]
GLYPH --> RASTER[Rasterization]
RASTER --> COM[Compositor]
COM --> SCREEN[Display]</pre></div>
    </section>

    <section class="docs-section" id="screens">
      <div class="docs-eyebrow">12 · VISUALS</div><h2>NotYVOS Visual Archive</h2>
      <p>Selected project images are served from the public NotYVOS website repository. They provide visual context for the documentation without replacing the technical descriptions and diagrams.</p>
      <div class="docs-visual-grid">
        <figure class="docs-visual">
          <img src="https://raw.githubusercontent.com/NotY215/NotYVOS-Web/main/Updates/1.png" alt="NotYVOS development screenshot" loading="lazy" decoding="async">
          <figcaption>Development snapshot · NotYVOS desktop and runtime work</figcaption>
        </figure>
        <figure class="docs-visual">
          <img src="https://raw.githubusercontent.com/NotY215/NotYVOS-Web/main/Updates/2.png" alt="NotYVOS development screenshot" loading="lazy" decoding="async">
          <figcaption>Development snapshot · graphics and system integration</figcaption>
        </figure>
      </div>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">SOURCE</span><h3>Public website repository</h3><p>Images are kept in the main NotYVOS website source so the host layer does not become a second content repository.</p></article>
        <article class="docs-panel"><span class="panel-tag">DIAGRAMS</span><h3>Architecture remains authoritative</h3><p>Mermaid diagrams and written sections remain the primary technical reference. Screenshots are supporting visual evidence only.</p></article>
      </div>
    </section>

    <section class="docs-section" id="roadmap">
      <div class="docs-eyebrow">13 · PROJECT</div><h2>Roadmap</h2>
      <p>The roadmap is ordered. A later milestone assumes the earlier foundation is delivered. The current queue separates the active GameRunner work from the upcoming network, storage and firmware milestones.</p>
      <div class="roadmap-list">
      <?php foreach($roadmap as $r): ?>
        <article class="road-row"><div class="road-phase"><?=htmlspecialchars($r[0])?></div><div><h3><?=htmlspecialchars($r[1])?></h3><p><?=htmlspecialchars($r[2])?></p></div><span class="road-status <?=$r[3]?>"><?=htmlspecialchars(strtoupper($r[3]))?></span></article>
      <?php endforeach; ?>
      </div>
      <div class="docs-chart"><canvas id="roadmap-chart"></canvas></div>
    </section>

    <section class="docs-section" id="decisions">
      <div class="docs-eyebrow">14 · DECISIONS</div><h2>Architecture Decision Records</h2>
      <p>These decisions are part of the technical contract of the project. They explain why major boundaries exist and prevent later documentation from silently redefining the architecture.</p>
      <div class="decision-grid">
      <?php foreach($decisions as $d): ?>
        <article class="decision-card"><div class="decision-no"><?=htmlspecialchars($d[0])?></div><h3><?=htmlspecialchars($d[1])?></h3><p><?=htmlspecialchars($d[2])?></p></article>
      <?php endforeach; ?>
      </div>
    </section>

    <section class="docs-section" id="security">
      <div class="docs-eyebrow">15 · SECURITY</div><h2>Security, Firmware and Distribution Boundaries</h2>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">PUBLIC SOURCE</span><h3>No protected signing material</h3><p>Protected Sony signing keys and equivalent private material are not embedded in the public repository.</p></article>
        <article class="docs-panel"><span class="panel-tag">FIRMWARE</span><h3>Developer supplied</h3><p>PS3 firmware is treated as developer-provided input to the runtime/build environment and is not presented as a publicly distributed project asset.</p></article>
      </div>
      <div class="docs-callout"><b>Compatibility boundary</b><span>Windows executable compatibility is not allowed to redefine the native kernel architecture. It is a separate compatibility concern with its own milestone boundary.</span></div>
    </section>

    <section class="docs-section" id="dataflow">
      <div class="docs-eyebrow">16 · VISUALS</div><h2>Complete Data Flow</h2>
      <p>The following diagram connects the important desktop data paths: clock data, input, storage, syscalls and graphics.</p>
      <div class="diagram-frame"><div class="diagram-title"><span>LIVE MERMAID</span><b>Subsystem data flow</b></div><pre class="mermaid"><?=htmlspecialchars($diagram['data'])?></pre></div>
      <div class="docs-grid two">
        <article class="docs-panel"><span class="panel-tag">CLOCK</span><h3>RTC → compositor</h3><p>RTC/CMOS data becomes system clock state and is exposed to the compositor for desktop time presentation.</p></article>
        <article class="docs-panel"><span class="panel-tag">INPUT</span><h3>USB → unified input</h3><p>Input devices feed the unified input path before desktop components consume input events.</p></article>
      </div>
    </section>

    <section class="docs-section docs-final">
      <div class="docs-eyebrow">END OF CODEX</div><h2>Build the system, not just the interface.</h2>
      <p>This page is intentionally authored as PHP data and HTML rather than acting as a GitHub Markdown reader. The documentation is part of the website itself.</p>
      <button class="docs-primary" data-jump="overview">Return to beginning</button>
    </section>
  </div>
</section>
</main>
<script type="module" src="/assets/js/docs.js"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>