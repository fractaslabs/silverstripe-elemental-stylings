<?php

namespace Fractas\ElementalStylings\Tests\Behat\Context;

use DNADesign\Elemental\Models\ElementalArea;
use DNADesign\Elemental\Models\ElementContent;
use SilverStripe\CMS\Tests\Behaviour\FixtureContext as CmsFixtureContext;

/**
 * Creates Elemental fixtures through the same relation used by Elemental's browser suite.
 */
class FixtureContext extends CmsFixtureContext
{
    /**
     * @Given /(?:the|a) "([^"]+)" "([^"]+)" (?:with|has) a "([^"]+)" content element with "(.*)" content/
     */
    public function createContentElement(
        string $type,
        string $pageTitle,
        string $elementTitle,
        string $elementContent
    ): void {
        $elementalArea = $this->getElementalArea($type, $pageTitle);
        $element = $this->getFixtureFactory()->createObject(ElementContent::class, $elementTitle, [
            'Title' => $elementTitle,
            'HTML' => $elementContent,
        ]);

        $elementalArea->Elements()->add($element);
    }

    private function getElementalArea(string $type, string $pageTitle): ElementalArea
    {
        $pageClass = $this->convertTypeToClass($type);
        $page = $this->getFixtureFactory()->get($pageClass, $pageTitle)
            ?: $this->getFixtureFactory()->createObject($pageClass, $pageTitle);

        return $page->ElementalArea();
    }
}
