<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Concerns\ResolvesStylingVariants;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingStyle extends Extension
{
    use ResolvesStylingVariants;

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Style';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Styles';

    /**
     * @config
     *
     * @var array
     */
    private static array $style_variants = [];

    /** @return array<string, string> */
    private function getStyleDefinitions(): array
    {
        return [
            'default' => _t(StylingStyle::class . '.DEFAULT', 'Default'),
            'light' => _t(StylingStyle::class . '.LIGHT', 'Light'),
            'dark' => _t(StylingStyle::class . '.DARK', 'Dark'),
        ];
    }

    public function getStylingStyleNice(?string $key): string
    {
        return $this->getStyleDefinitions()[$key] ?? $key ?? '';
    }

    public function getStylingStyleData(): ArrayData
    {
        return ArrayData::create([
            'Label' => StylingStyle::$singular_name,
            'Value' => $this->getStylingStyleNice($this->getOwner()->Style),
        ]);
    }

    public function getStylingTitleData(): ArrayData
    {
        return ArrayData::create([
            'Label' => 'Title',
            'Value' => $this->getOwner()->obj('ShowTitle')->Nice(),
        ]);
    }

    /**
     * @return string
     */
    public function updateStyleVariant(mixed &$style): string
    {
        $style = $this->getConfiguredVariantClass('style_variants', $this->getOwner()->Style);

        return $style;
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $style = $this->getEnabledVariantOptions('style_variants', $this->getStyleDefinitions());
        if ($style && count($style) > 1) {
            $fields->addFieldToTab(
                'Root.Styling',
                StylingOptionsetField::create('Style', _t(StylingStyle::class . '.STYLE', 'Style'), $style)
            );
        } else {
            $fields->removeByName('Style');
        }

        return $fields;
    }

    public function onAfterPopulateDefaults(): void
    {
        $default = $this->getDefaultVariantKey('style_variants', $this->getStyleDefinitions());
        if ($default !== null) {
            $this->getOwner()->Style = $default;
        }
    }
}
