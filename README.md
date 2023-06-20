# SilverStripe Elemental Stylings
[![Latest Stable Version](https://poser.pugx.org/fractas/elemental-stylings/v/stable)](https://packagist.org/packages/fractas/elemental-stylings)
[![Total Downloads](https://poser.pugx.org/fractas/elemental-stylings/downloads)](https://packagist.org/packages/fractas/elemental-stylings)
[![Latest Unstable Version](https://poser.pugx.org/fractas/elemental-stylings/v/unstable)](https://packagist.org/packages/fractas/elemental-stylings)
[![License](https://poser.pugx.org/fractas/elemental-stylings/license)](https://packagist.org/packages/fractas/elemental-stylings)


## Introduction

This module extends a [SilverStripe Elemental Blocks](https://github.com/dnadesign/silverstripe-elemental) to enhance its functionalities with predefined sets of Classes of Styling elements.

Predefined Styling classes:
- **StylingHeight** - changes a height of a Block
- **StylingHorizontalAlign** - changes a horizontal alignment of a Block
- **StylingLimit** - changes a limit of a Block
- **StylingSize** - changes a size of a Block
- **StylingStyle** _(extended from Core module)_ - special enhancements for a class extended from Core module
- **StylingTextAlign** - changes a text alignment inside of a Block
- **StylingVerticalAlign** - changes a vertical alignment of a Block
- **StylingWidth** - changes a width of a Block _(example uses Bootstrap Grid syntax)_

The module provides basic markup for each of the stylings but you have an option to edit and/or replace those predefined styles.


## Requirements

* SilverStripe CMS ^4.0 || ^5.0
* SilverStripe Elemental Blocks ^4.0 || ^5.0


## Installation

- Install a module via Composer
```
composer require fractas/elemental-stylings
```
- Follow an instructions for installation of [Elemental Blocks module](https://github.com/dnadesign/silverstripe-elemental#installation)
- Apply a desired Styling Class extension on Block class _(ie. ElementContent that ships with Core module)_
**mysite/\_config/elements.yml**
```yaml
  DNADesign\Elemental\Models\ElementContent:
    extensions:
      - Fractas\ElementalStylings\StylingHeight
      - Fractas\ElementalStylings\StylingHorizontalAlign
      - Fractas\ElementalStylings\StylingStyle
      - Fractas\ElementalStylings\StylingTextAlign
      - Fractas\ElementalStylings\StylingVerticalAlign
      - Fractas\ElementalStylings\StylingWidth
```
- Add an desired styles based on your preferences, see [Configuration example](#full-configuration-example)
- Optionaly, you can require basic CSS stylings provided with this module to your controller class like:
  **mysite/code/PageController.php**
  ```php
      Requirements::css('fractas/elemental-stylings:client/dist/css/stylings.css');
  ```
- Build and flush your project ```vendor/bin/sake dev/build flush=1```


## Full configuration example

This is a sample configuration for use of Stylings classes in YML configuration.  

**mysite/\_config/elements.yml**

```yaml
DNADesign\Elemental\Models\ElementContent:
  extensions:
    - Fractas\ElementalStylings\StylingHeight
    - Fractas\ElementalStylings\StylingHorizontalAlign
    - Fractas\ElementalStylings\StylingStyle
    - Fractas\ElementalStylings\StylingTextAlign
    - Fractas\ElementalStylings\StylingVerticalAlign
    - Fractas\ElementalStylings\StylingWidth
  styles:
    light: 'Light background color with Dark text'
    dark: 'Dark background color with White text'
  textalign:
    left: 'Left'
    right: 'Right'
    center: 'Center'
  horalign:
    left: 'Left'
    right: 'Right'
    center: 'Center'
  veralign:
    top: 'Top'
    middle: 'Middle'
    bottom: 'Bottom'
  height:
    small: 'Small'
    medium: 'Medium'
    large: 'Large'
  width:
    col-sm-6: '50%'
    col-sm-4: '33.33%'
    col-sm-12: '100%'
```

## Implementation example: 'Text with Image' Element

* New Element class file: [ElementContentImage.php](https://gist.github.com/jelicanin/20d11104a89fd9ea3a1e69b8bc91824b)
* New Element template file: [ElementContentImage.ss](https://gist.github.com/jelicanin/aec741745d417e9047efbf25bf93245d)


## Screenshots

Updated GridField with preview of applied stylings:
![GridFieldStylings](docs/images/overview-gridfield-stylings.png?v=2)


Styling tab of a Block with icons for specific styles:
![BlockStylings](docs/images/overview-block-stylings.png?v=2)


## Reporting Issues

Please [create an issue](https://github.com/fractaslabs/silverstripe-elemental-stylings/issues) for any bugs you've found, or features you're missing.


## License

See [License](LICENSE)


## Credits

Styling icons from IcoMoon - Free by [IcoMoon](https://icomoon.io/app)
