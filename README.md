# PPSX33 Website

Canonical source for the PPSX33 project website.

- **Live website:** https://ppsx33.xo.je/
- **Project source:** https://github.com/NotY215/PPSX33
- **Website source:** https://github.com/NotY215/PPSX33-Web
- **Host-side router:** https://github.com/NotY215/Web-host/tree/main/PPSX33

## Site pages

| Page | Source | Purpose |
| --- | --- | --- |
| Home | `index.html` | Project summary and high-level status |
| About | `about.html` | Scope and compatibility expectations |
| Architecture | `architecture.html` | Recompilation pipeline and subsystem boundaries |
| Documentation | `documentation.html` | User and developer reference hub |
| Roadmap | `roadmap.html` | Summary linked to canonical roadmap |
| Updates | `updates.html` | Project updates |
| FAQ | `faq.html` | Common questions and limitations |
| Developer | `developer.html` | Developer profile |

## Repository layout

- `assets/css/`: shared styles.
- `assets/js/`: shared interactions and page scripts.
- `assets/ts/`: TypeScript source where applicable.
- `assets/`: static images and other assets.
- `robots.txt`, `sitemap.xml`, `.htaccess`: crawler metadata and routing support.
- `ARCHITECTURE.md`: detailed architecture notes and diagram sources.
- `DOCUMENTATION.md`: documentation map, evidence rules, and diagram conventions.

The homepage is `index.html`. There is no separate `ppsx3.html` page. This repository is PPSX33-only and must not contain NotYVOS branding or routes.

## Diagram formats

Keep diagrams as editable source text. Use Mermaid for flows and dependencies (compatible with Mermaid renderers such as Beautiful-mermaid), PlantUML for sequence/component views, Graphviz DOT for dependency graphs, Markwhen for milestone timelines, and Scrawl sketches for early design exploration. Automatic website rendering must not be claimed until a renderer is configured.

## Accuracy policy

PPSX33 is an experimental PlayStation 3 full-recompilation project, not a complete PS3 emulator. Static lifting and translation counts do not establish semantic correctness, bootability, or playability. The canonical project README and roadmap are the source of truth.

## Hosting boundary

The `PPSX33/` folder in [Web-host](https://github.com/NotY215/Web-host/tree/main/PPSX33) provides host-side routing and rendering. This repository owns page HTML and static assets. A website-source commit alone does not verify deployment.
