# PPSX33 Architecture

## Repository boundaries

- [PPSX33](https://github.com/NotY215/PPSX33) owns compiler/runtime code, build instructions, implementation status, and compatibility evidence.
- [PPSX33-Web](https://github.com/NotY215/PPSX33-Web) owns public website HTML, shared CSS/JavaScript, assets, and public documentation.
- [Web-host/PPSX33](https://github.com/NotY215/Web-host/tree/main/PPSX33) is the hosting adapter, not the canonical page-content source.

```mermaid
flowchart LR
  CORE[PPSX33 source] -->|status and evidence| WEB[PPSX33-Web]
  WEB -->|HTML and assets| HOST[Web-host router]
  HOST --> LIVE[ppsx33.xo.je]
  CORE --> BUILD[Native Windows build] --> RT[PS3RT runtime]
  RT --> EVIDENCE[Logs, tests, per-title records]
  EVIDENCE -->|verified claims only| WEB
```

## Recompilation pipeline

```mermaid
flowchart TD
  ELF[Decrypted ELF] --> LOAD[ELF loader and guest memory]
  LOAD --> ANALYSE[Analysis and control-flow recovery]
  ANALYSE --> LIFTER[PPU decoder and lifter]
  LIFTER --> CPP[Generated C++]
  CPP --> BUILD[Native build and runtime linkage]
  BUILD --> RUN[Guest execution]
  RUN --> HLE[LV2 / PRX / NID services]
  RUN --> SPU[SPU / MFC / DMA]
  RUN --> RSX[RSX / GCM] --> D3D[Direct3D 11 backend]
  HLE --> TEST[Tests and evidence]
  SPU --> TEST
  D3D --> TEST
```

## Runtime sequence (PlantUML)

```plantuml
@startuml
actor Developer
participant Frontend
participant "ELF loader" as Loader
participant "PPU lifter" as Lifter
participant "Native toolchain" as Toolchain
participant PS3RT
participant "HLE / SPU / RSX" as Services
participant Evidence
Developer -> Frontend: Select decrypted ELF
Frontend -> Loader: Validate and map input
Loader -> Lifter: Code regions and metadata
Lifter -> Toolchain: Generated C++ project
Toolchain -> PS3RT: Native executable and runtime
PS3RT -> Services: Guest calls and device operations
Services --> PS3RT: Results, events, faults
PS3RT -> Evidence: Trace and observed outcome
@enduml
```

## Dependency graph (Graphviz DOT)

```dot
digraph PPSX33 {
  rankdir=LR;
  node [shape=box, style="rounded"];
  ELF -> Loader -> Analysis -> PPULifter -> GeneratedCPP -> NativeBuild -> PS3RT;
  PS3RT -> LV2HLE; PS3RT -> PRX; PS3RT -> SPUMFC; PS3RT -> RSXGCM -> D3D11;
  LV2HLE -> Validation; PRX -> Validation; SPUMFC -> Validation; D3D11 -> Validation;
}
```

## Correctness boundaries

| Boundary | Required evidence | Invalid inference |
| --- | --- | --- |
| ELF loading | Validated segments, entry point, imports | File opened means all layouts work |
| PPU lifting | Decoder/semantic tests and generated-code checks | Lift count proves semantic correctness |
| Native build | Reproducible build and link results | Compilation proves guest execution |
| HLE/PRX | Module tests and observed call paths | Resolved NID means full API semantics |
| SPU/MFC/DMA | Ordering, tag, atomic and scheduler tests | Stub or assist path is complete |
| RSX/GCM | Title-authored commands and shader output | Diagnostic triangle proves game rendering |
| Compatibility | Repeatable boot and gameplay evidence | Window or one log line proves playability |

Consult the [canonical roadmap](https://github.com/NotY215/PPSX33/blob/main/ROADMAP.md) for the live critical path. PPSX33 accepts decrypted ELF input; input decryption is out of scope.
