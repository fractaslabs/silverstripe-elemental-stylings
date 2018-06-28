# SilverStripe Elemental Stylings


## Introduction

This module extends a [SilverStripe Elemental Blocks](https://github.com/silverstripe/silverstripe-elemental-blocks) to enhance its functionalities with predefined sets of Classes of Styling elements.

Predefined Styling classes:
- **StylingHeight** - changes a height of a Block
- **StylingHorizontalAlign** - changes a horizontal alignment of a Block
- **StylingStyle** _(extended from Core module)_ - special enhancements for a class extended from Core module
- **StylingTextAlign** - changes a text alignment inside of a Block
- **StylingVerticalAlign** - changes a vertical alignment of a Block
- **StylingWidth** - changes a width of a Block _(example uses Bootstrap Grid syntax)_

The module provides basic markup for each of the stylings but you have an option to edit and/or replace those predefined styles.

For a more detailed overview of using this module, please see [the user help documentation](docs/en/index.md).


## Requirements

* SilverStripe CMS ^4.0
* SilverStripe Elemental Blocks ^2.0


## Installation

- Install a module via Composer
```
composer require fractas/elemental-stylings
```
- Follow an instructions for installation of Elemental Blocks module
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
- Add an desired styles based on your preferences, see Configuration example
- Build and flush your project


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


## Screenshots

Updated GridField with preview of applied stylings:
![GridFieldStylings](docs/images/overview-gridfield-stylings.png?v=2)


Styling tab of a Block with icons for specific styles:
![BlockStylings](docs/images/overview-block-stylings.png?v=2)


## Reporting Issues

Please [create an issue](https://github.com/fractaslabs/silverstripe-elemental-stylings/issues) for any bugs you've found, or features you're missing.

## Credits

Styling icons from IcoMoon - Free by [IcoMoon](https://icomoon.io/app)
