# Configuration

Each Element defines its own enabled styling variants. There is no global CSS framework profile and no runtime framework selection.

```yaml
App\Elements\HeroElement:
  extensions:
    - Fractas\ElementalStylings\StylingHeight
    - Fractas\ElementalStylings\StylingTextAlign
    - Fractas\ElementalStylings\StylingWidth

  height_variants:
    large: 'hero-height-large'
    full: 'hero-height-full'

  text_align_variants:
    start: 'hero-text-start'
    center: 'hero-text-center'

  width_variants:
    half: 'hero-width-half'
    full: 'hero-width-full'
```

## Configuration rules

- Map keys are canonical neutral values stored in the database.
- Map values are exact CSS class strings returned to templates.
- A class string may contain multiple utilities and responsive variants.
- Only configured canonical keys are available in the CMS.
- YAML order controls CMS option order.
- The first configured canonical key is the default for new records.
- Unknown keys are ignored instead of being offered as misleading CMS options.
- Removing a configured key does not silently rewrite existing content. A removed stored value resolves to an empty class string until the content is updated or migrated.
- An optionset with one configured value is hidden because the single value is applied automatically.

Run a flush after changing configuration:

```bash
vendor/bin/sake dev/build flush=1
```

The configuration is standard Silverstripe class configuration and can be defined independently for every Element type. See the [Silverstripe Configuration API](https://docs.silverstripe.org/en/6/developer_guides/configuration/configuration/) for inheritance and YAML merge rules.
