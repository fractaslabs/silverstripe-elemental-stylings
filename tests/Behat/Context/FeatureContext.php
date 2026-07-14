<?php

namespace Fractas\ElementalStylings\Tests\Behat\Context;

use DNADesign\Elemental\Models\ElementContent;
use PHPUnit\Framework\Assert;
use SilverStripe\Assets\Filesystem;
use SilverStripe\BehatExtension\Context\SilverStripeContext;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Versioned\Versioned;

class FeatureContext extends SilverStripeContext
{
    /**
     * @Given the :type :title has a fully configured styling element
     */
    public function createFullyConfiguredStylingElement(string $type, string $title): void
    {
        Assert::assertSame('page', $type);

        Versioned::set_stage(Versioned::DRAFT);
        $page = SiteTree::get()->filter('Title', $title)->first();

        Assert::assertNotNull($page, sprintf('Page "%s" exists', $title));
        Assert::assertGreaterThan(0, (int) $page->ElementalAreaID, 'Page has an ElementalArea');

        ElementContent::create([
            'Title' => 'Styled block',
            'HTML' => '<p>Element styling browser test</p>',
            'ParentID' => $page->ElementalAreaID,
            'Sort' => 1,
        ])->write();
    }

    /**
     * @Then the :field styling control should offer :variants
     */
    public function assertStylingControlVariants(string $field, string $variants): void
    {
        $page = $this->getSession()->getPage();
        $radioSelector = sprintf('input[name="%1$s"], input[name$="_%1$s"]', $field);
        $radios = $page->findAll('css', $radioSelector);

        if ($radios) {
            $actual = [];
            foreach ($radios as $radio) {
                foreach (explode(' ', (string) $radio->getAttribute('class')) as $class) {
                    if (str_starts_with($class, 'option-val--')) {
                        $actual[] = substr($class, strlen('option-val--'));
                    }
                }
            }
        } else {
            $selectSelector = sprintf('select[name="%1$s"], select[name$="_%1$s"]', $field);
            $select = $page->find('css', $selectSelector);
            Assert::assertNotNull($select, sprintf('%s styling control exists', $field));
            $actual = array_map(
                static fn ($option): string => (string) $option->getAttribute('value'),
                $select->findAll('css', 'option')
            );
        }

        Assert::assertSame(explode(',', $variants), $actual, sprintf('%s styling variants', $field));
    }

    /**
     * @Then I save a CMS screenshot as :filename
     */
    public function saveCmsScreenshot(string $filename): void
    {
        Assert::assertSame(basename($filename), $filename, 'Screenshot filename is safe');

        $session = $this->getSession();
        $session->resizeWindow(1800, 1800, 'current');
        $session->executeScript(<<<'JS'
            document.documentElement.style.zoom = '0.68';
            window.scrollTo(0, 0);
            for (const element of document.querySelectorAll('*')) {
                element.scrollTop = 0;
            }
            JS);

        $directory = (string) $this->getScreenshotPath();
        Filesystem::makeFolder($directory);
        file_put_contents($directory . '/' . $filename, $session->getScreenshot());
    }
}
