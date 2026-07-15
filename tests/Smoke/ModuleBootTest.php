<?php

namespace Fractas\ElementalStylings\Tests\Smoke;

use DNADesign\Elemental\Models\BaseElement;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use Fractas\ElementalStylings\StylingLimit;
use Fractas\ElementalStylings\StylingHeight;
use Fractas\ElementalStylings\StylingHorizontalAlign;
use Fractas\ElementalStylings\StylingSize;
use Fractas\ElementalStylings\StylingStyle;
use Fractas\ElementalStylings\StylingTextAlign;
use Fractas\ElementalStylings\StylingVerticalAlign;
use Fractas\ElementalStylings\StylingWidth;
use Fractas\ElementalStylings\Tests\Fixtures\TestElement;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;

class ModuleBootTest extends SapphireTest
{
    protected static $extra_dataobjects = [
        TestElement::class,
    ];

    protected static $required_extensions = [
        TestElement::class => [
            StylingHeight::class,
            StylingHorizontalAlign::class,
            StylingLimit::class,
            StylingSize::class,
            StylingStyle::class,
            StylingTextAlign::class,
            StylingVerticalAlign::class,
            StylingWidth::class,
        ],
    ];

    public function testModuleBootsWithElementalSix(): void
    {
        $element = TestElement::create();

        $this->assertInstanceOf(BaseElement::class, $element);
        $this->assertTrue($element->hasMethod('getHeightVariant'));
        $this->assertTrue($element->hasMethod('getWidthVariant'));
    }

    public function testWidthUsesNeutralKeyAndReturnsConfiguredClasses(): void
    {
        TestElement::config()->set('width_variants', [
            'half' => 'w-full md:w-1/2',
            'full' => 'w-full',
        ]);

        $element = TestElement::create();

        $this->assertSame('half', $element->Width);
        $this->assertSame('50%', $element->getStylingWidthNice($element->Width));
        $this->assertSame('w-full md:w-1/2', $element->getWidthVariant());
    }

    public function testConfiguredOptionKeysPopulateAsDefaults(): void
    {
        $config = TestElement::config();
        $config->set('height_variants', ['large' => 'min-h-96', 'full' => 'min-h-screen']);
        $config->set('horizontal_align_variants', ['center' => 'flex justify-center', 'end' => 'flex justify-end']);
        $config->set('limit_variants', ['three' => 'limit-three', 'six' => 'limit-six']);
        $config->set('size_variants', ['small' => 'text-sm', 'large' => 'text-lg']);
        $config->set('style_variants', ['default' => 'theme-default', 'dark' => 'theme-dark']);
        $config->set('text_align_variants', ['start' => 'text-start', 'center' => 'text-center']);
        $config->set('vertical_align_variants', ['start' => 'items-start', 'end' => 'items-end']);
        $config->set('width_variants', ['quarter' => 'w-1/4', 'full' => 'w-full']);

        $element = TestElement::create();

        $this->assertSame('large', $element->Height);
        $this->assertSame('center', $element->HorAlign);
        $this->assertSame('three', $element->Limit);
        $this->assertSame('small', $element->Size);
        $this->assertSame('default', $element->Style);
        $this->assertSame('start', $element->TextAlign);
        $this->assertSame('start', $element->VerAlign);
        $this->assertSame('quarter', $element->Width);

        $this->assertSame('min-h-96', $element->getHeightVariant());
        $this->assertSame('flex justify-center', $element->getHorAlignVariant());
        $this->assertSame('limit-three', $element->getLimitVariant());
        $this->assertSame('text-sm', $element->getSizeVariant());
        $this->assertSame('theme-default', $element->getStyleVariant());
        $this->assertSame('text-start', $element->getTextAlignVariant());
        $this->assertSame('items-start', $element->getVerAlignVariant());
        $this->assertSame('w-1/4', $element->getWidthVariant());
    }

    public function testUnknownAndRemovedWidthVariantsAreNotResolved(): void
    {
        TestElement::config()->set('width_variants', [
            'custom' => 'custom-width',
            'half' => 'w-1/2',
        ]);

        $element = TestElement::create();

        $this->assertSame('half', $element->Width);

        $element->Width = 'full';
        $this->assertSame('', $element->getWidthVariant());
    }

    public function testEveryCanonicalVariantResolvesItsConfiguredClasses(): void
    {
        $cases = [
            ['height_variants', 'Height', 'getHeightVariant', ['small', 'medium', 'large', 'full']],
            ['horizontal_align_variants', 'HorAlign', 'getHorAlignVariant', ['start', 'center', 'end']],
            ['limit_variants', 'Limit', 'getLimitVariant', ['three', 'six', 'twelve']],
            ['size_variants', 'Size', 'getSizeVariant', ['small', 'medium', 'large', 'extra-large']],
            ['style_variants', 'Style', 'getStyleVariant', ['default', 'light', 'dark']],
            ['text_align_variants', 'TextAlign', 'getTextAlignVariant', ['start', 'center', 'end']],
            ['vertical_align_variants', 'VerAlign', 'getVerAlignVariant', ['start', 'center', 'end']],
            ['width_variants', 'Width', 'getWidthVariant', ['quarter', 'half', 'three-quarters', 'full']],
        ];

        foreach ($cases as [$configName, $fieldName, $getter, $keys]) {
            $configured = [];
            foreach ($keys as $key) {
                $configured[$key] = sprintf('%s-class', $key);
            }
            TestElement::config()->set($configName, $configured);

            $element = TestElement::create();
            foreach ($keys as $key) {
                $element->$fieldName = $key;
                $this->assertSame(sprintf('%s-class', $key), $element->$getter());
            }
        }
    }

    public function testEveryConfiguredVisualVariantUsesTheStylingOptionsetField(): void
    {
        $config = TestElement::config();
        $config->set('limit_variants', ['three' => 'limit-three', 'six' => 'limit-six']);
        $config->set('size_variants', ['small' => 'size-small', 'large' => 'size-large']);
        $config->set('style_variants', ['default' => 'style-default', 'dark' => 'style-dark']);

        $element = TestElement::create();
        $extensions = [
            StylingLimit::class => 'Limit',
            StylingSize::class => 'Size',
            StylingStyle::class => 'Style',
        ];

        foreach ($extensions as $extensionClass => $fieldName) {
            $fields = FieldList::create(TabSet::create('Root'));
            $extension = new $extensionClass();
            $extension->setOwner($element);
            $extension->updateCMSFields($fields);

            $this->assertInstanceOf(
                StylingOptionsetField::class,
                $fields->dataFieldByName($fieldName),
                sprintf('%s should use the visual styling optionset control', $fieldName)
            );
        }
    }
}
