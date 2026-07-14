# Development

Install development dependencies and run the local checks:

```bash
composer update
composer lint
composer analyse
composer test
```

Module integration tests must run inside a supported `silverstripe/installer` project so the project `Page` class and Elemental page extension are available. The GitHub Actions workflow delegates supported-version setup to `silverstripe/gha-ci`.

Before proposing a release:

```bash
composer validate --strict
composer audit --locked
git diff --check
```

Browser verification must use a real Silverstripe CMS 6 installation with Elemental 6. Capture real CMS output rather than reconstructed mockups.

In that installer, link this module as a Composer path repository with development autoloading enabled, start ChromeDriver, and run:

```bash
SS_BASE_URL=http://127.0.0.1:8000 vendor/bin/behat @elemental-stylings
```

The browser suite creates a real Elemental page and content block, opens the Element action menu, selects **Styling**, verifies every configured canonical option, and writes a successful CMS screenshot to `artifacts/screenshots/elemental-styling-controls.png`.
