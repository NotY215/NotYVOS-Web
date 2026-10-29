# PPSX33 Website Hosting

Canonical website source: [NotY215/PPSX33-Web](https://github.com/NotY215/PPSX33-Web).  
Minimal host router: [NotY215/Web-host/tree/main/PPSX33](https://github.com/NotY215/Web-host/tree/main/PPSX33).  
Live website: https://ppsx33.xo.je/

## How serving works
The host's `render.php` fetches page HTML from this repository's `main` branch and rewrites root-relative `/assets/...` links to the jsDelivr CDN for this repository. CSS, JavaScript, TypeScript source, images and all other site assets remain maintained here rather than duplicated on the host.

## Routes
- `/` → `index.html`
- `/About/` → `about.html`
- `/Architecture/` → `architecture.html`
- `/Documentation/` → `documentation.html`
- `/Roadmap/` → `roadmap.html`
- `/Updates/` → `updates.html`
- `/FAQ/` → `faq.html`
- `/Developer/` → `developer.html`

The former `ppsx3.html` page has been removed. Do not reintroduce the redundant PPSX33 navigation button.

## Changes
Edit source files in this repository. The host renderer uses a short-lived cache and stale-cache fallback. Host routing and SEO metadata are maintained in `NotY215/Web-host/PPSX33/`. No credentials or tokens belong in source control.
