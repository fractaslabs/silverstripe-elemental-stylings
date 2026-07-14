<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Concerns\ResolvesStylingVariants;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingHeight extends Extension
{
    use ResolvesStylingVariants;

    /**
     * @config
     */
    private static array $db = [
        'Height' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Height';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Heights';

    /**
     * @config
     *
     * @var array
     */
    private static array $height_variants = [];

    /** @return array<string, string> */
    private function getHeightDefinitions(): array
    {
        return [
            'small' => _t(StylingHeight::class . '.SMALL', 'Small'),
            'medium' => _t(StylingHeight::class . '.MEDIUM', 'Medium'),
            'large' => _t(StylingHeight::class . '.LARGE', 'Large'),
            'full' => _t(StylingHeight::class . '.FULL', 'Full height'),
        ];
    }

    public function getStylingHeightNice(?string $key): string
    {
        return $this->getHeightDefinitions()[$key] ?? $key ?? '';
    }

    public function getStylingHeightData(): ArrayData
    {
        return ArrayData::create([
            'Label' => StylingHeight::$singular_name,
            'Value' => $this->getStylingHeightNice($this->getOwner()->Height),
        ]);
    }

    /**
     * @return string
     */
    public function getHeightVariant(): string
    {
        return $this->getConfiguredVariantClass('height_variants', $this->getOwner()->Height);
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $height = $this->getEnabledVariantOptions('height_variants', $this->getHeightDefinitions());
        if ($height && count($height) > 1) {
            $fields->addFieldToTab(
                'Root.Styling',
                StylingOptionsetField::create('Height', _t(StylingHeight::class . '.HEIGHT', 'Height Size'), $height)
            );
        } else {
            $fields->removeByName('Height');
        }

        return $fields;
    }

    public function onAfterPopulateDefaults(): void
    {
        $default = $this->getDefaultVariantKey('height_variants', $this->getHeightDefinitions());
        if ($default !== null) {
            $this->getOwner()->Height = $default;
        }
    }
}
