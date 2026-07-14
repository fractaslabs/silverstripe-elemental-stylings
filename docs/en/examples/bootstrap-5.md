# Bootstrap 5 Example

The module does not install Bootstrap. This example assumes Bootstrap 5 is already provided by the project.

## YAML

```yaml
App\Elements\ContentElement:
  extensions:
    - Fractas\ElementalStylings\StylingHorizontalAlign
    - Fractas\ElementalStylings\StylingTextAlign
    - Fractas\ElementalStylings\StylingWidth

  horizontal_align_variants:
    start: 'd-flex justify-content-start'
    center: 'd-flex justify-content-center'
    end: 'd-flex justify-content-end'

  text_align_variants:
    start: 'text-start'
    center: 'text-center'
    end: 'text-end'

  width_variants:
    quarter: 'col-12 col-md-3'
    half: 'col-12 col-md-6'
    three-quarters: 'col-12 col-md-9'
    full: 'col-12'
```

## Template

```ss
<div class="row $HorAlignVariant">
    <article class="$WidthVariant $TextAlignVariant">
        $HTML
    </article>
</div>
```

## Output

```html
<div class="row d-flex justify-content-center">
    <article class="col-12 col-md-6 text-center">
        ...
    </article>
</div>
```

See the official [Bootstrap flex utilities](https://getbootstrap.com/docs/5.3/utilities/flex/) and [grid documentation](https://getbootstrap.com/docs/5.3/layout/grid/).
