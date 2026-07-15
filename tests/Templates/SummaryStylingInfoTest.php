<?php

namespace Fractas\ElementalStylings\Tests\Templates;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Model\ArrayData;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\SSViewer;

class SummaryStylingInfoTest extends SapphireTest
{
    public function testPlainDescriptionIsEscaped(): void
    {
        $html = SSViewer::create('SummaryStylingInfo')->process(ArrayData::create([
            'Description' => '<script>alert("unsafe")</script><p>Summary</p>',
        ]));

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringContainsString('&lt;p&gt;Summary&lt;/p&gt;', $html);
    }

    public function testTypedHtmlDescriptionKeepsIntentionalMarkup(): void
    {
        $html = SSViewer::create('SummaryStylingInfo')->process(ArrayData::create([
            'Description' => DBField::create_field('HTMLText', '<strong>Summary</strong>'),
        ]));

        $this->assertStringContainsString('<strong>Summary</strong>', $html);
    }
}
