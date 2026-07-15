<?php

namespace Fractas\ElementalStylings\Tests\Forms;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\View\Requirements;

class StylingOptionsetFieldTest extends SapphireTest
{
    protected function setUp(): void
    {
        parent::setUp();
        Requirements::clear();
    }

    public function testFieldRendersAccessibleCssDrivenOptions(): void
    {
        $field = StylingOptionsetField::create(
            'Width',
            'Width',
            ['quarter' => '25%', 'full' => '100%'],
            'quarter'
        );

        $html = $field->Field()->forTemplate();
        $css = array_keys(Requirements::backend()->getCSS());
        $javascript = array_keys(Requirements::backend()->getJavascript());

        $this->assertStringContainsString('data-styling-name="width"', $html);
        $this->assertStringContainsString('data-styling-value="quarter"', $html);
        $this->assertStringContainsString('aria-hidden="true"', $html);
        $this->assertNotEmpty(array_filter($css, fn (string $path) => str_contains($path, 'client/dist/css/cms.css')));
        $this->assertEmpty(
            array_filter($javascript, fn (string $path) => str_contains($path, 'StylingOptionsetField.js'))
        );
    }

    public function testCmsStylesRecogniseCanonicalWidthKeys(): void
    {
        $css = file_get_contents(dirname(__DIR__, 2) . '/client/dist/css/cms.css');

        $this->assertIsString($css);
        $this->assertStringContainsString('[data-styling-value="quarter"]', $css);
        $this->assertStringContainsString('[data-styling-value="half"]', $css);
        $this->assertStringContainsString('[data-styling-value="three-quarters"]', $css);
        $this->assertStringContainsString('[data-styling-value="full"]', $css);
    }

    public function testFullWidthStylesDoNotChangeTheFullHeightIconWidth(): void
    {
        $css = file_get_contents(dirname(__DIR__, 2) . '/client/dist/css/cms.css');

        $this->assertIsString($css);
        $this->assertStringContainsString(
            ':is([name="Width"], [name$="_Width"]).option-val--full + span::after',
            $css
        );
        $this->assertStringNotContainsString(
            '.stylingoptionset .option-val--full + span::after',
            $css
        );
    }

    public function testCmsStylesDefineScopedIconsForLimitSizeAndStyle(): void
    {
        $css = file_get_contents(dirname(__DIR__, 2) . '/client/dist/css/cms.css');

        $this->assertIsString($css);

        $selectors = [
            ':is([name="Limit"], [name$="_Limit"]).option-val--three + span::after',
            ':is([name="Limit"], [name$="_Limit"]).option-val--six + span::after',
            ':is([name="Limit"], [name$="_Limit"]).option-val--twelve + span::after',
            ':is([name="Size"], [name$="_Size"]).option-val--small + span::after',
            ':is([name="Size"], [name$="_Size"]).option-val--medium + span::after',
            ':is([name="Size"], [name$="_Size"]).option-val--large + span::after',
            ':is([name="Size"], [name$="_Size"]).option-val--extra-large + span::after',
            ':is([name="Style"], [name$="_Style"]).option-val--default + span::after',
            ':is([name="Style"], [name$="_Style"]).option-val--light + span::after',
            ':is([name="Style"], [name$="_Style"]).option-val--dark + span::after',
        ];

        foreach ($selectors as $selector) {
            $this->assertStringContainsString($selector, $css);
        }
    }

    public function testReactOptionCardsKeepLongLabelsAtTheSameHeight(): void
    {
        $css = file_get_contents(dirname(__DIR__, 2) . '/client/dist/css/cms.css');

        $this->assertIsString($css);
        $this->assertStringContainsString("width: 78px;\n  height: 78px;", $css);
        $this->assertStringNotContainsString('min-height: 78px;', $css);
        $this->assertStringContainsString(
            ':is([name="Size"], [name$="_Size"]).option-val--extra-large + span {',
            $css
        );
    }

    public function testCmsLoadsControlStylesBeforeAjaxFieldsRender(): void
    {
        $requirements = LeftAndMain::config()->get('extra_requirements_css') ?? [];

        $this->assertContains('fractas/elemental-stylings:client/dist/css/cms.css', $requirements);
    }
}
