# NotYVOS Website

Public source repository for the NotYVOS website.

The live site is rendered by the separate private Web-host repository. This repository contains the public page source, documentation UI, CSS, JavaScript, TypeScript, screenshots, updates and website metadata.

## Layout

- `*.php` public page source consumed by the host renderer
- `assets/css/` site and documentation styling
- `assets/js/` browser runtime code
- `assets/ts/` TypeScript source and public type contracts
- `Updates/` development screenshots
- `docs.php` interactive documentation shell
- `package.json` documentation renderer packages
- `tsconfig.json` TypeScript configuration

## Documentation engine

The `/Docs/` page renders canonical Markdown from the main NotYVOS repository inside the website instead of redirecting readers to GitHub.

The browser renderer supports:

- Markdown with GFM tables
- Mermaid flow, sequence and other Mermaid diagrams
- D2 diagrams through the D2 WebAssembly renderer
- Markmap roadmap and hierarchy views
- Cytoscape graph blocks
- Chart.js quantitative graphs
- Grid.js searchable and sortable tables
- Highlight.js source highlighting
- KaTeX mathematics
- DOMPurify HTML sanitization
- Client-side document search and deep links

Canonical documentation remains in the main `NotY215/NotYVOS` repository. The website fetches it as source data and renders it locally in the documentation application.

## Development

Install the documentation packages with `npm install`.

Run TypeScript checking:

`npm run typecheck`

Build the typed documentation entrypoint:

`npm run build`

The production site uses the committed browser runtime in `assets/js/docs.js`. The TypeScript source in `assets/ts/docs.ts` defines the typed documentation contract.

Live site: http://notyvos.gt.tc/

Main project: https://github.com/NotY215/NotYVOS


## Project policies

- [Contributing](CONTRIBUTING.md)
- [Code of Conduct](CODE_OF_CONDUCT.md)
- [Security](SECURITY.md)
- [Support](SUPPORT.md)
- [Citation](CITATION.cff)
- [Governance](GOVERNANCE.md)
- [License](LICENSE.md)
