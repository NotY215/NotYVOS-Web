# NotYVOS Website

Public source for the NotYVOS website.

The main project was rewritten on 15 October 2026 as a Linux/Buildroot appliance that boots into a PS3-style XMB interface. Website descriptions should follow the current [NotYVOS README](https://github.com/NotY215/NotYVOS/blob/main/README.md) and [roadmap](https://github.com/NotY215/NotYVOS/blob/main/ROADMAP.md), not older pages describing the previous native-kernel desktop, NYFS, or integrated PS3 runtime direction.

## Pages

- `index.html`: project overview and current rewrite status
- `about.html`: goals and project boundaries
- `architecture.html`: Linux/Buildroot boot and SDL2 XMB session flow
- `documentation.html`: current build, architecture, controls and known limitations
- `roadmap.html` + `roadmap.json`: Phase 0 through Phase 8+ roadmap snapshot
- `updates.html`: visual history with a note that older screenshots may show the previous implementation
- `faq.html`: current project answers and known gaps
- `developer.html`: developer profile and public repository activity
- `ppsx3.html`: separate PPSX33 recompiler project profile; PPSX33 is not the current NotYVOS appliance runtime

## Assets

- `assets/css/`: site styling
- `assets/js/`: navigation, developer metrics and page scripts
- `Updates/`: static development screenshots

## Synchronization rule

The NotYVOS repository is canonical for implementation facts. Update the main repository documentation first, then synchronize these public pages. Clearly label planned features as planned; do not describe media playback, networking, sound, bootable ISO/VDI packaging or PS3 game execution as implemented until verified in the current codebase.

The public page source is hosted in this repository. The separately managed hosting repository is not modified by changes here unless its own deployment/synchronization workflow does so.

Live site: https://notyvos.gt.tc/

Main project: https://github.com/NotY215/NotYVOS
PPSX33: https://github.com/NotY215/PPSX33
