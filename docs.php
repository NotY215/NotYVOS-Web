<?php $pageTitle='NotYVOS Documentation';$pageDescription='Interactive NotYVOS documentation with live Markdown, Mermaid, D2, Markmap, tables, code highlighting and charts.';$currentPage='docs';$canonicalUrl='http://notyvos.gt.tc/Docs/';require __DIR__.'/includes/header.php'; ?>
<main class="docs-page">
<link rel="stylesheet" href="/assets/css/docs.css">
<section class="page-hero section-shell docs-hero"><span class="eyebrow">DOCUMENTATION</span><h1>The documentation is rendered here.</h1><p>Read the canonical NotYVOS documentation without leaving the website. Markdown is rendered in the browser, diagrams are interactive, tables are searchable, code is highlighted and supported visual formats are rendered with their native libraries.</p></section>
<section class="section-shell docs-app" id="notyvos-docs" data-doc-default="architecture.md">
  <aside class="docs-sidebar" aria-label="Documentation navigation">
    <div class="docs-sidebar-head"><strong>NotYVOS Docs</strong><span id="docs-count">Loading…</span></div>
    <label class="docs-search"><span>Search docs</span><input id="docs-filter" type="search" placeholder="Find a document..." autocomplete="off"></label>
    <nav id="docs-nav" class="docs-nav"></nav>
  </aside>
  <div class="docs-main">
    <div class="docs-toolbar">
      <div><span class="docs-status-dot" id="docs-status-dot"></span><span id="docs-status">Loading documentation engine…</span></div>
      <div class="docs-toolbar-actions"><button type="button" class="docs-button" id="docs-copy-link">Copy document link</button><button type="button" class="docs-button" id="docs-top">Top</button></div>
    </div>
    <article class="docs-reader" id="docs-reader" aria-live="polite"><div class="docs-loading"><span></span><span></span><span></span><p>Loading canonical documentation…</p></div></article>
  </div>
</section>
<section class="section-shell section docs-dashboard">
  <div class="section-heading"><span class="eyebrow">LIVE VISUALS</span><h2>Subsystem state at a glance</h2><p>This chart is driven by the current roadmap values and rendered with Chart.js. Markdown tables in the documents are upgraded to searchable Grid.js tables.</p></div>
  <div class="docs-chart-card"><canvas id="docs-state-chart" aria-label="NotYVOS subsystem completion chart"></canvas></div>
</section>
<section class="section-shell section tinted docs-engine">
  <div class="section-heading"><span class="eyebrow">DOCUMENTATION ENGINE</span><h2>Native rendering, not GitHub redirects.</h2><p>Mermaid diagrams render directly in the reader. D2 uses its WebAssembly renderer, Markmap renders roadmap outlines, Cytoscape powers graph views, Chart.js handles quantitative graphs, Grid.js enhances tables, Highlight.js handles source code and KaTeX handles mathematics when present.</p></div>
  <div class="card-grid four">
    <article class="mini-card"><strong>Markdown</strong><span>Marked + DOMPurify</span></article>
    <article class="mini-card"><strong>Diagrams</strong><span>Mermaid + D2 + Markmap</span></article>
    <article class="mini-card"><strong>Data</strong><span>Grid.js + Chart.js</span></article>
    <article class="mini-card"><strong>Code</strong><span>Highlight.js + TypeScript</span></article>
  </div>
</section>
<script type="module" src="/assets/js/docs.js"></script>
</main><?php require __DIR__.'/includes/footer.php'; ?>