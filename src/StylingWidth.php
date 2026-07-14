<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Concerns\ResolvesStylingVariants;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingWidth extends Extension
{
    use ResolvesStylingVariants;

    /**
     * @config
     */
    private static array $db = [
        'Width' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Width';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Widths';

    /**
     * @config
     *
     * @var array
     */
    private static array $width_variants = [];

    /**
     * @return array<string, string>
     */
    private function getWidthDefinitions(): array
    {
        return [
            'quarter' => _t(StylingWidth::class . '.QUARTER', '25%'),
            'half' => _t(StylingWidth::class . '.HALF', '50%'),
            'three-quarters' => _t(StylingWidth::class . '.THREE_QUARTERS', '75%'),
            'full' => _t(StylingWidth::class . '.FULL', '100%'),
        ];
    }

    public function getStylingWidthNice(?string $key): string
    {
        return $this->getWidthDefinitions()[$key] ?? $key ?? '';
    }

    public function getStylingWidthData(): ArrayData
    {
        return ArrayData::create([
            'Label' => StylingWidth::$singular_name,
            'Value' => $this->getStylingWidthNice($this->getOwner()->Width),
        ]);
    }

    /**
     * @return string
     */
    public function getWidthVariant(): string
    {
        return $this->getConfiguredVariantClass('width_variants', $this->getOwner()->Width);
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $width = $this->getEnabledVariantOptions('width_variants', $this->getWidthDefinitions());
        if ($width && count($width) > 1) {
            $fields->addFieldToTab(
                'Root.Styling',
                StylingOptionsetField::create('Width', _t(StylingWidth::class . '.WIDTH', 'Width Size'), $width)
            );
        } else {
            $fields->removeByName('Width');
        }

        return $fields;
    }

    public function onAfterPopulateDefaults(): void
    {
        $default = $this->getDefaultVariantKey('width_variants', $this->getWidthDefinitions());
        if ($default !== null) {
            $this->getOwner()->Width = $default;
        }
    }
}
