# Tailwind CSS Example

The module does not install Tailwind CSS. This example assumes Tailwind is already built by the project.

## YAML

```yaml
App\Elements\ContentElement:
  extensions:
    - Fractas\ElementalStylings\StylingHorizontalAlign
    - Fractas\ElementalStylings\StylingTextAlign
    - Fractas\ElementalStylings\StylingWidth

  horizontal_align_variants:
    start: 'flex justify-start'
    center: 'flex justify-center'
    end: 'flex justify-end'

  text_align_variants:
    start: 'text-start'
    center: 'text-center'
    end: 'text-end'

  width_variants:
    quarter: 'w-full md:w-1/4'
    half: 'w-full md:w-1/2'
    three-quarters: 'w-full md:w-3/4'
    full: 'w-full'
```

## Template

```ss
<div class="$HorAlignVariant">
    <article class="$WidthVariant $TextAlignVariant">
        $HTML
    </article>
</div>
```

## Output

```html
<div class="flex justify-center">
    <article class="w-full md:w-1/2 text-center">
        ...
    </article>
</div>
```

## Class detection

Tailwind generates classes it can detect as complete static tokens in source files. Classes present only in Silverstripe YAML may not be detected automatically. Tailwind CSS 4 projects can explicitly include the configured utilities in their main stylesheet:

```css
@import "tailwindcss";
@source inline("flex justify-start justify-center justify-end text-start text-center text-end w-full md:w-1/4 md:w-1/2 md:w-3/4");
```

Keep this list synchronized with the classes used in Element YAML configuration. See Tailwind's official [class detection documentation](https://tailwindcss.com/docs/detecting-classes-in-source-files).
