<?php

namespace Fractas\ElementalStylings\Tests\Integration;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use Fractas\ElementalStylings\Tests\Fixtures\TestElementalPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Versioned\Versioned;

class ElementalPageIntegrationTest extends SapphireTest
{
    protected static $required_extensions = [
        TestElementalPage::class => [
            ElementalPageExtension::class,
        ],
    ];

    protected static $extra_dataobjects = [
        TestElementalPage::class,
    ];

    public function testWritingElementalPageCreatesUsableArea(): void
    {
        Versioned::set_stage(Versioned::DRAFT);

        $page = TestElementalPage::create(['Title' => 'Elemental stylings integration']);

        $this->assertSame(0, (int) $page->ElementalAreaID);

        $page->write();

        $this->assertGreaterThan(0, (int) $page->ElementalAreaID);
        $this->assertTrue($page->ElementalArea()->exists());
    }
}
