const root = document.querySelector('.docs-war');
const content = document.querySelector('#docs-content');
const links = Array.from(document.querySelectorAll('.docs-link'));
const search = document.querySelector('#docs-search');
const progress = document.querySelector('#docs-progress');

function sectionLinks() {
  links.forEach(link => {
    link.addEventListener('click', event => {
      const target = document.getElementById(link.dataset.section);
      if (!target) return;
      event.preventDefault();
      history.replaceState(null, '', '#' + target.id);
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
  document.querySelectorAll('[data-jump]').forEach(link => {
    link.addEventListener('click', event => {
      const target = document.getElementById(link.dataset.jump);
      if (!target) return;
      event.preventDefault();
      history.replaceState(null, '', '#' + target.id);
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
}

function observer() {
  const sections = Array.from(document.querySelectorAll('.docs-section[id]'));
  const io = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        links.forEach(link =>
          link.classList.toggle('active', link.dataset.section === entry.target.id)
        );
      }
    });
  }, { rootMargin: '-18% 0px -65% 0px' });
  sections.forEach(section => io.observe(section));

  const updateProgress = () => {
    const max = document.documentElement.scrollHeight - window.innerHeight;
    if (progress) progress.textContent = (max > 0 ? Math.round(window.scrollY / max * 100) : 0) + '%';
  };
  window.addEventListener('scroll', updateProgress, { passive: true });
  updateProgress();
}

function filter() {
  if (!search) return;
  search.addEventListener('input', () => {
    const q = search.value.trim().toLowerCase();
    links.forEach(button => {
      const section = document.getElementById(button.dataset.section);
      const text = ((button.textContent || '') + ' ' + (section ? section.textContent : '')).toLowerCase();
      button.hidden = !!q && text.indexOf(q) === -1;
    });
  });
}

function cssAnimations() {
  const items = Array.from(document.querySelectorAll(
    '.docs-hero-card,.docs-section,.docs-panel,.decision-card,.road-row,.diagram-frame,.docs-chart'
  ));
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    items.forEach(item => item.classList.add('docs-visible'));
    return;
  }
  const io = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('docs-visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08 });
  items.forEach((item, index) => {
    item.style.setProperty('--docs-delay', Math.min(index * 0.018, 0.32) + 's');
    io.observe(item);
  });
}

async function loadOptionalLibraries() {
  const results = await Promise.allSettled([
    import('https://cdn.jsdelivr.net/npm/mermaid@11.4.1/dist/mermaid.esm.min.mjs'),
    import('https://cdn.jsdelivr.net/npm/chart.js@4.5.1/+esm'),
    import('https://cdn.jsdelivr.net/npm/gridjs@6.2.0/+esm'),
    import('https://cdn.jsdelivr.net/npm/cytoscape@3.30.4/+esm')
  ]);

  const mermaidMod = results[0].status === 'fulfilled' ? results[0].value : null;
  const mermaid = mermaidMod ? (mermaidMod.default || mermaidMod) : null;
  const Chart = results[1].status === 'fulfilled' ? results[1].value.Chart : null;
  const Grid = results[2].status === 'fulfilled' ? results[2].value.Grid : null;
  const cytoscape = results[3].status === 'fulfilled' ? (results[3].value.default || results[3].value) : null;

  if (mermaid) await diagrams(mermaid);
  if (Chart) charts(Chart);
  if (Grid) tableEnhancement(Grid);
  if (cytoscape) liveGraph(cytoscape);
}

async function diagrams(mermaid) {
  mermaid.initialize({
    startOnLoad: false,
    securityLevel: 'loose',
    theme: 'base',
    themeVariables: {
      background: '#05080d',
      primaryColor: '#162538',
      primaryTextColor: '#eaf7ff',
      primaryBorderColor: '#39c7ff',
      lineColor: '#d7a93b',
      secondaryColor: '#321a20',
      tertiaryColor: '#0b1724',
      fontFamily: 'Inter, system-ui, sans-serif',
      fontSize: '14px',
      nodeBorder: '#39c7ff',
      mainBkg: '#162538',
      clusterBkg: '#0b1724',
      titleColor: '#eaf7ff',
      edgeLabelBackground: '#0a1520'
    },
    flowchart: {
      htmlLabels: true,
      curve: 'basis',
      padding: 16,
      nodeSpacing: 40,
      rankSpacing: 50,
      useMaxWidth: true
    },
    sequence: {
      useMaxWidth: true,
      mirrorActors: false,
      messageMargin: 30
    }
  });

  const nodes = Array.from(document.querySelectorAll('pre.mermaid, .mermaid'));
  for (const node of nodes) {
    try {
      const graphDef = (node.textContent || '').trim();
      if (!graphDef) continue;

      const id = 'mermaid-' + Math.random().toString(36).slice(2, 11);
      const { svg } = await mermaid.render(id, graphDef);

      const wrapper = document.createElement('div');
      wrapper.className = 'mermaid-output';
      wrapper.innerHTML = svg;

      node.replaceWith(wrapper);
    } catch (error) {
      console.warn('Mermaid render failed:', error);
      const err = document.createElement('div');
      err.className = 'diagram-error';
      err.textContent = 'Diagram failed to render. Check console for details.';
      node.replaceWith(err);
    }
  }
}

function charts(Chart) {
  const canvas = document.querySelector('#roadmap-chart');
  if (!canvas) return;
  const labels = [
    'Kernel', 'Memory', 'Scheduler', 'NYFS', 'Graphics', 'RSX',
    'PPU/SPU/DMA/JIT', 'Desktop UI', 'Decoders', 'SVG/Icons', 'TrueType'
  ];
  const values = [92, 95, 85, 55, 85, 65, 70, 70, 90, 85, 75];
  new Chart(canvas, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Implementation level',
        data: values,
        backgroundColor: 'rgba(57, 199, 255, 0.35)',
        borderColor: '#39c7ff',
        borderWidth: 1,
        borderRadius: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      indexAxis: 'y',
      plugins: { legend: { display: false } },
      scales: {
        x: {
          beginAtZero: true,
          max: 100,
          ticks: { callback: v => v + '%', color: '#8da5b8' },
          grid: { color: 'rgba(112,171,207,0.12)' }
        },
        y: {
          ticks: { color: '#c5d7e5' },
          grid: { display: false }
        }
      }
    }
  });
}

function tableEnhancement(Grid) {
  document.querySelectorAll('.docs-table').forEach(table => {
    const headers = Array.from(table.querySelectorAll('thead th')).map(x => x.textContent.trim());
    const rows = Array.from(table.querySelectorAll('tbody tr')).map(row =>
      Array.from(row.children).map(x => x.textContent.trim())
    );
    const host = document.createElement('div');
    host.className = 'docs-grid-table';
    table.replaceWith(host);
    new Grid({
      columns: headers,
      data: rows,
      search: true,
      sort: true,
      pagination: { limit: 8 }
    }).render(host);
  });
}

function liveGraph(cytoscape) {
  const host = document.querySelector('.docs-final');
  if (!host) return;
  const graph = document.createElement('div');
  graph.className = 'docs-mini-graph';
  graph.innerHTML = '<div class="graph-label">LIVE SUBSYSTEM MAP</div><div id="docs-cyto"></div>';
  host.before(graph);
  cytoscape({
    container: graph.querySelector('#docs-cyto'),
    elements: [
      { data: { id: 'kernel', label: 'KERNEL' } },
      { data: { id: 'memory', label: 'MEMORY' } },
      { data: { id: 'sched', label: 'SCHEDULER' } },
      { data: { id: 'vfs', label: 'VFS' } },
      { data: { id: 'nyfs', label: 'NYFS' } },
      { data: { id: 'gfx', label: 'GRAPHICS' } },
      { data: { id: 'desktop', label: 'DESKTOP' } },
      { data: { id: 'game', label: 'GAMERUNNER' } },
      { data: { id: 'rsx', label: 'RSX' } },
      { data: { source: 'kernel', target: 'memory' } },
      { data: { source: 'kernel', target: 'sched' } },
      { data: { source: 'kernel', target: 'vfs' } },
      { data: { source: 'vfs', target: 'nyfs' } },
      { data: { source: 'kernel', target: 'gfx' } },
      { data: { source: 'gfx', target: 'desktop' } },
      { data: { source: 'kernel', target: 'game' } },
      { data: { source: 'game', target: 'rsx' } },
      { data: { source: 'rsx', target: 'gfx' } }
    ],
    style: [
      {
        selector: 'node',
        style: {
          label: 'data(label)',
          color: '#eaf7ff',
          'background-color': '#12324a',
          'border-color': '#39c7ff',
          'border-width': 2,
          'font-size': 10,
          'text-valign': 'center',
          'text-halign': 'center',
          width: 'label',
          height: 'label',
          padding: '10px',
          shape: 'roundrectangle'
        }
      },
      {
        selector: 'edge',
        style: {
          width: 2,
          'line-color': '#8f6d24',
          'target-arrow-color': '#8f6d24',
          'target-arrow-shape': 'triangle',
          'curve-style': 'bezier'
        }
      }
    ],
    layout: { name: 'cose', animate: true, padding: 40 }
  });
}

sectionLinks();
observer();
filter();
cssAnimations();
loadOptionalLibraries().catch(() => {});
