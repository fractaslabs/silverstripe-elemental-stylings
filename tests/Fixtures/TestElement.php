<?php

namespace Fractas\ElementalStylings\Tests\Fixtures;

use DNADesign\Elemental\Models\BaseElement;
use Fractas\ElementalStylings\StylingHeight;
use Fractas\ElementalStylings\StylingHorizontalAlign;
use Fractas\ElementalStylings\StylingLimit;
use Fractas\ElementalStylings\StylingSize;
use Fractas\ElementalStylings\StylingStyle;
use Fractas\ElementalStylings\StylingTextAlign;
use Fractas\ElementalStylings\StylingVerticalAlign;
use Fractas\ElementalStylings\StylingWidth;

class TestElement extends BaseElement
{
    private static string $table_name = 'ElementalStylingsTestElement';

    private static array $extensions = [
        StylingHeight::class,
        StylingHorizontalAlign::class,
        StylingLimit::class,
        StylingSize::class,
        StylingStyle::class,
        StylingTextAlign::class,
        StylingVerticalAlign::class,
        StylingWidth::class,
    ];

    public function getType(): string
    {
        return 'Elemental stylings test element';
    }
}
