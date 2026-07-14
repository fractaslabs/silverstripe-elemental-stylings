# Styling Extensions

Every extension owns its canonical keys, translated CMS labels, field behavior, and visual icon semantics. Projects select a subset and map it to their own classes.

| Extension | Configuration | Stored field | Template API | Canonical keys |
|---|---|---|---|---|
| `StylingWidth` | `width_variants` | `Width` | `$WidthVariant` | `quarter`, `half`, `three-quarters`, `full` |
| `StylingHeight` | `height_variants` | `Height` | `$HeightVariant` | `small`, `medium`, `large`, `full` |
| `StylingHorizontalAlign` | `horizontal_align_variants` | `HorAlign` | `$HorAlignVariant` | `start`, `center`, `end` |
| `StylingVerticalAlign` | `vertical_align_variants` | `VerAlign` | `$VerAlignVariant` | `start`, `center`, `end` |
| `StylingTextAlign` | `text_align_variants` | `TextAlign` | `$TextAlignVariant` | `start`, `center`, `end` |
| `StylingSize` | `size_variants` | `Size` | `$SizeVariant` | `small`, `medium`, `large`, `extra-large` |
| `StylingStyle` | `style_variants` | `Style` | `$StyleVariant` | `default`, `light`, `dark` |
| `StylingLimit` | `limit_variants` | `Limit` | `$LimitVariant` | `three`, `six`, `twelve` |

Alignment uses logical `start` and `end` values instead of physical `left` and `right`, making the stored content suitable for both LTR and RTL designs.

Width labels are `25%`, `50%`, `75%`, and `100%`. Limit labels are `3 items`, `6 items`, and `12 items`. Labels are owned by the module and can be translated through Silverstripe's standard i18n system.
