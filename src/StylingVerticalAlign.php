<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Concerns\ResolvesStylingVariants;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingVerticalAlign extends Extension
{
    use ResolvesStylingVariants;

    /**
     * @config
     */
    private static array $db = [
        'VerAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Vertical Align';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Vertical Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static array $vertical_align_variants = [];

    /** @return array<string, string> */
    private function getVerticalAlignDefinitions(): array
    {
        return [
            'start' => _t(StylingVerticalAlign::class . '.START', 'Start'),
            'center' => _t(StylingVerticalAlign::class . '.CENTER', 'Center'),
            'end' => _t(StylingVerticalAlign::class . '.END', 'End'),
        ];
    }

    public function getStylingVerticalAlignNice(?string $key): string
    {
        return $this->getVerticalAlignDefinitions()[$key] ?? $key ?? '';
    }

    public function getStylingVerticalAlignData(): ArrayData
    {
        return ArrayData::create([
            'Label' => StylingVerticalAlign::$singular_name,
            'Value' => $this->getStylingVerticalAlignNice($this->getOwner()->VerAlign),
        ]);
    }

    /**
     * @return string
     */
    public function getVerAlignVariant(): string
    {
        return $this->getConfiguredVariantClass('vertical_align_variants', $this->getOwner()->VerAlign);
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $fields->removeByName('VerAlign');
        $veralign = $this->getEnabledVariantOptions(
            'vertical_align_variants',
            $this->getVerticalAlignDefinitions()
        );
        if ($veralign && count($veralign) > 1) {
            $fields->addFieldToTab(
                'Root.Styling',
                StylingOptionsetField::create(
                    'VerAlign',
                    _t(StylingVerticalAlign::class . '.VERTICALALIGN', 'Vertical Align'),
                    $veralign
                )
            );
        }

        return $fields;
    }

    public function onAfterPopulateDefaults(): void
    {
        $default = $this->getDefaultVariantKey(
            'vertical_align_variants',
            $this->getVerticalAlignDefinitions()
        );
        if ($default !== null) {
            $this->getOwner()->VerAlign = $default;
        }
    }
}
