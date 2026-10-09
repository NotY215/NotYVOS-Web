# Website Hosting Sync

The canonical website source is this repository: `NotY215/NotYVOS-Web`.
The public-host copy is `NotY215/Web-host/NotYvos/`.

## Asset loading

Host HTML pages load CSS and JavaScript from jsDelivr URLs pointing to this repository's `main` branch. This avoids maintaining separate copies of shared CSS and JavaScript in the host repository.

## Automatic HTML sync

The workflow at `.github/workflows/sync-host.yml` copies the root HTML pages to the host repository when those pages change. The host's `.htaccess` and `sitemap.xml` are intentionally maintained in the host repository because they contain hosting-specific routes and sitemap entries.

The workflow requires a repository secret before it can push changes:

1. Create a fine-grained personal access token with access limited to `NotY215/Web-host` and **Contents: Read and write** permission.
2. Open this repository's **Settings → Secrets and variables → Actions**.
3. Add a repository secret named `WEB_HOST_TOKEN` with that token as its value.
4. Run **Actions → Sync website pages to host repository → Run workflow** to test the first sync.

Do not put the token in source code, commit it to a file, or share it publicly.

## Page mapping

| Source page | Host file |
|---|---|
| `index.html` | `NotYvos/index.html` |
| `about.html` | `NotYvos/About.html` |
| `architecture.html` | `NotYvos/Architecture.html` |
| `documentation.html` | `NotYvos/Documentation.html` |
| `roadmap.html` | `NotYvos/Roadmap.html` |
| `updates.html` | `NotYvos/Updates.html` |
| `faq.html` | `NotYvos/FAQ.html` |
| `developer.html` | `NotYvos/Developer.html` |
| `ppsx3.html` | `NotYvos/ppsx3.html` |

The workflow transforms local asset paths to shared CDN URLs while copying pages. The host-specific route rules and sitemap are not overwritten.
