# Silverstripe Elemental Stylings

[![Latest Stable Version](https://poser.pugx.org/fractas/elemental-stylings/v/stable)](https://packagist.org/packages/fractas/elemental-stylings)
[![Total Downloads](https://poser.pugx.org/fractas/elemental-stylings/downloads)](https://packagist.org/packages/fractas/elemental-stylings)
[![License](https://poser.pugx.org/fractas/elemental-stylings/license)](https://packagist.org/packages/fractas/elemental-stylings)

Framework-agnostic styling controls for [Silverstripe Elemental](https://github.com/dnadesign/silverstripe-elemental). Editors select a small set of visual variants in the CMS while each Element maps neutral stored keys to the CSS classes used by its project.

![Element Styling controls](docs/images/overview-block-stylings-ss6.png)

## Requirements

- PHP 8.3 or newer
- Silverstripe CMS 6.2 or newer
- Silverstripe Elemental 6.0 or newer

## Installation

```bash
composer require fractas/elemental-stylings
vendor/bin/sake dev/build flush=1
```

## Quick start

Configure only the extensions and neutral variants required by an Element. YAML values are returned unchanged by the corresponding template getters and may contain multiple classes.

```yaml
App\Elements\ContentElement:
  extensions:
    - Fractas\ElementalStylings\StylingTextAlign
    - Fractas\ElementalStylings\StylingWidth

  text_align_variants:
    start: 'content-text-start'
    center: 'content-text-center'

  width_variants:
    half: 'content-width-half'
    full: 'content-width-full'
```

The CMS stores only `start`, `center`, `half`, or `full`. Templates receive the configured project classes:

```ss
<section class="$WidthVariant $TextAlignVariant">
    $HTML
</section>
```

```html
<section class="content-width-half content-text-center">
    ...
</section>
```

## Documentation

- [Configuration](docs/en/configuration.md)
- [Styling extensions and canonical keys](docs/en/styling-extensions.md)
- [Template usage](docs/en/template-usage.md)
- [CMS screenshots](docs/en/screenshots.md)
- Examples:
  - [Custom CSS](docs/en/examples/custom-css.md)
  - [Bootstrap 5](docs/en/examples/bootstrap-5.md)
  - [Tailwind CSS](docs/en/examples/tailwind-css.md)
- [Upgrading](docs/en/upgrading.md)
- [Development](docs/en/development.md)

## Screenshots

An Elemental page with selected styling metadata visible in the collapsed Element summary:

![Elemental page editor with styling metadata](docs/images/overview-page-editor-ss6.png)

Editing an Element beside the live page preview:

![Element content and live preview](docs/images/overview-element-content-ss6.png)

The Element actions menu exposes Styling as its own section:

![Element actions with Styling](docs/images/overview-element-actions-ss6.png)

The Styling section presents every enabled neutral variant as a visual option:

![Element Styling controls](docs/images/overview-block-stylings-ss6.png)

Selected styling metadata remains visible when the Element is collapsed:

![Selected Element styling metadata](docs/images/overview-gridfield-stylings-ss6.png)

See the [CMS screenshot gallery](docs/en/screenshots.md) for focused views of every control group.

## Support

Please [create an issue](https://github.com/fractaslabs/silverstripe-elemental-stylings/issues) for reproducible bugs or missing functionality.
