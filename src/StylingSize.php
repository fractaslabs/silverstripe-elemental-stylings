<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Concerns\ResolvesStylingVariants;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingSize extends Extension
{
    use ResolvesStylingVariants;

    /**
     * @config
     */
    private static array $db = [
        'Size' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Size';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Sizes';

    /**
     * @config
     *
     * @var array
     */
    private static array $size_variants = [];

    /** @return array<string, string> */
    private function getSizeDefinitions(): array
    {
        return [
            'small' => _t(StylingSize::class . '.SMALL', 'Small'),
            'medium' => _t(StylingSize::class . '.MEDIUM', 'Medium'),
            'large' => _t(StylingSize::class . '.LARGE', 'Large'),
            'extra-large' => _t(StylingSize::class . '.EXTRA_LARGE', 'Extra large'),
        ];
    }

    public function getStylingSizeNice(?string $key): string
    {
        return $this->getSizeDefinitions()[$key] ?? $key ?? '';
    }

    public function getStylingSizeData(): ArrayData
    {
        return ArrayData::create([
            'Label' => StylingSize::$singular_name,
            'Value' => $this->getStylingSizeNice($this->getOwner()->Size),
        ]);
    }

    /**
     * @return string
     */
    public function getSizeVariant(): string
    {
        return $this->getConfiguredVariantClass('size_variants', $this->getOwner()->Size);
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $size = $this->getEnabledVariantOptions('size_variants', $this->getSizeDefinitions());
        if ($size && count($size) > 1) {
            $fields->addFieldToTab(
                'Root.Styling',
                StylingOptionsetField::create('Size', _t(StylingSize::class . '.SIZE', 'Size'), $size)
            );
        } else {
            $fields->removeByName('Size');
        }

        return $fields;
    }

    public function onAfterPopulateDefaults(): void
    {
        $default = $this->getDefaultVariantKey('size_variants', $this->getSizeDefinitions());
        if ($default !== null) {
            $this->getOwner()->Size = $default;
        }
    }
}
