# Upgrading

The framework-agnostic variant API is intentionally breaking. Older releases are available through their existing Git tags.

## Configuration changes

Old configuration maps stored a CSS-like key and used the YAML value as its CMS label:

```yaml
width:
  width-50: '50%'
  width-100: '100%'
```

New configuration uses module-owned neutral keys and maps them to exact project classes:

```yaml
width_variants:
  half: 'layout-width-half'
  full: 'layout-width-full'
```

Rename all extension configuration properties according to the [extension reference](styling-extensions.md).

## Stored values

Existing framework-specific stored values are not converted automatically. Projects upgrading existing content must provide an explicit content migration appropriate to their database and release process, for example:

- `width-25` or `col-md-3` to `quarter`
- `width-50` or `col-md-6` to `half`
- `width-75` or `col-md-9` to `three-quarters`
- `width-100` or `col-md-12` to `full`
- `left`, `top` to `start`
- `right`, `bottom` to `end`
- `middle` to `center`
- `xlarge` to `full` for height

Test the migration against a database backup and verify rendered templates before deployment.

Sprite assets and `StylingOptionsetField.js` are no longer used. CMS icons are CSS-driven.
