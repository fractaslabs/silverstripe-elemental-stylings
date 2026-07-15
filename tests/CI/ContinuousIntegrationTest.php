<?php

namespace Fractas\ElementalStylings\Tests\CI;

use PHPUnit\Framework\TestCase;

class ContinuousIntegrationTest extends TestCase
{
    public function testOfficialCiRunsAndPublishesTheBrowserSuite(): void
    {
        $root = dirname(__DIR__, 2);
        $workflow = file_get_contents($root . '/.github/workflows/ci.yml');
        $behat = file_get_contents($root . '/behat.yml');

        $this->assertIsString($workflow);
        $this->assertIsString($behat);
        $this->assertStringContainsString('uses: silverstripe/gha-ci/.github/workflows/ci.yml@v2', $workflow);
        $this->assertStringContainsString('endtoend: true', $workflow);
        $this->assertStringContainsString("screenshot_path: '%paths.base%/artifacts/screenshots'", $behat);
    }

    public function testPhpUnitSuiteIdentifierIsAcceptedByOfficialCi(): void
    {
        $phpunit = file_get_contents(dirname(__DIR__, 2) . '/phpunit.xml.dist');

        $this->assertIsString($phpunit);
        $this->assertMatchesRegularExpression('/<testsuite name="[a-zA-Z0-9_-]+">/', $phpunit);
    }

    public function testBrowserSuiteCreatesElementsThroughTheOfficialFixturePattern(): void
    {
        $feature = file_get_contents(dirname(__DIR__, 2) . '/tests/Behat/features/styling-controls.feature');

        $this->assertIsString($feature);
        $this->assertStringContainsString(
            'a "page" "Styling Page" with a "Styled block" content element',
            $feature
        );
    }
}
