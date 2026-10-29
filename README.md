# PPSX33 Website

Canonical source for the PPSX33 project website.

- Live website: https://ppsx33.xo.je/
- Project repository: https://github.com/NotY215/PPSX33
- Website repository: https://github.com/NotY215/PPSX33-Web
- Minimal hosting router: https://github.com/NotY215/Web-host/tree/main/PPSX33

## Source layout
- `index.html`: main landing page.
- `about.html`, `architecture.html`, `documentation.html`, `roadmap.html`, `updates.html`, `faq.html`, `developer.html`: supporting pages.
- `assets/css/`, `assets/js/`, and `assets/ts/`: site assets and TypeScript source.
- `robots.txt`, `sitemap.xml`, and `.htaccess`: site metadata and development-server routing.

There is no separate `ppsx3.html` page. The homepage is `index.html`.

## Accuracy
PPSX33 is an experimental PlayStation 3 full-recompilation project, not a complete PS3 emulator. Static lifting and translation counts do not establish semantic correctness, bootability, or playability. The canonical project README and roadmap are the source of truth.

## Hosting
The `PPSX33/` folder in [Web-host](https://github.com/NotY215/Web-host/tree/main/PPSX33) contains only the PHP renderer, routing configuration, README, robots file and sitemap. HTML and assets are fetched from this repository.
