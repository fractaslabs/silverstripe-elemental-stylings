<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Concerns\ResolvesStylingVariants;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingHorizontalAlign extends Extension
{
    use ResolvesStylingVariants;

    /**
     * @config
     */
    private static array $db = [
        'HorAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Horizontal Align';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Horizontal Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static array $horizontal_align_variants = [];

    /** @return array<string, string> */
    private function getHorizontalAlignDefinitions(): array
    {
        return [
            'start' => _t(StylingHorizontalAlign::class . '.START', 'Start'),
            'center' => _t(StylingHorizontalAlign::class . '.CENTER', 'Center'),
            'end' => _t(StylingHorizontalAlign::class . '.END', 'End'),
        ];
    }

    public function getStylingHorizontalAlignNice(?string $key): string
    {
        return $this->getHorizontalAlignDefinitions()[$key] ?? $key ?? '';
    }

    public function getStylingHorizontalAlignData(): ArrayData
    {
        return ArrayData::create([
            'Label' => StylingHorizontalAlign::$singular_name,
            'Value' => $this->getStylingHorizontalAlignNice($this->getOwner()->HorAlign),
        ]);
    }

    /**
     * @return string
     */
    public function getHorAlignVariant(): string
    {
        return $this->getConfiguredVariantClass('horizontal_align_variants', $this->getOwner()->HorAlign);
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $fields->removeByName('HorAlign');
        $horalign = $this->getEnabledVariantOptions(
            'horizontal_align_variants',
            $this->getHorizontalAlignDefinitions()
        );
        if ($horalign && count($horalign) > 1) {
            $fields->addFieldToTab(
                'Root.Styling',
                StylingOptionsetField::create(
                    'HorAlign',
                    _t(StylingHorizontalAlign::class . '.HORIZONTALALIGN', 'Horizontal Align'),
                    $horalign
                )
            );
        }

        return $fields;
    }

    public function onAfterPopulateDefaults(): void
    {
        $default = $this->getDefaultVariantKey(
            'horizontal_align_variants',
            $this->getHorizontalAlignDefinitions()
        );
        if ($default !== null) {
            $this->getOwner()->HorAlign = $default;
        }
    }
}
