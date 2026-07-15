# Template Usage

Variant getters return the configured class string exactly. They do not lowercase values, add prefixes, or assume a CSS framework.

```ss
<section class="$StyleVariant $HeightVariant $HorAlignVariant $VerAlignVariant $TextAlignVariant $WidthVariant">
    <div class="$SizeVariant">
        $HTML
    </div>
</section>
```

Given this Element configuration:

```yaml
App\Elements\ContentElement:
  width_variants:
    half: 'layout-column layout-column--half'
  text_align_variants:
    center: 'text-center'
```

the template receives:

```html
<section class="text-center layout-column layout-column--half">
    ...
</section>
```

If a stored key is no longer enabled, its getter returns an empty string. This prevents obsolete framework classes from leaking into rendered markup without silently changing saved content.

`$LimitVariant` is available for projects that represent a content limit with a class. The stored `Limit` value can also be used directly by Element application logic when selecting records.
