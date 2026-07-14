# Custom CSS Example

## Element class

```php
<?php

namespace App\Elements;

use DNADesign\Elemental\Models\ElementContent;

class ContentElement extends ElementContent
{
    private static string $table_name = 'ContentElement';
}
```

## YAML

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

## Template

```ss
<article class="content-element $WidthVariant $TextAlignVariant">
    $HTML
</article>
```
## CSS

```css
.content-width-half { width: 50%; }
.content-width-full { width: 100%; }
.content-text-start { text-align: start; }
.content-text-center { text-align: center; }
```

## Output

```html
<article class="content-element content-width-half content-text-center">
    ...
</article>
```
