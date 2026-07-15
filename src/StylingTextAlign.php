<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Concerns\ResolvesStylingVariants;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingTextAlign extends Extension
{
    use ResolvesStylingVariants;

    /**
     * @config
     */
    private static array $db = [
        'TextAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Text Align';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Text Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static array $text_align_variants = [];

    /** @return array<string, string> */
    private function getTextAlignDefinitions(): array
    {
        return [
            'start' => _t(StylingTextAlign::class . '.START', 'Start'),
            'center' => _t(StylingTextAlign::class . '.CENTER', 'Center'),
            'end' => _t(StylingTextAlign::class . '.END', 'End'),
        ];
    }

    public function getStylingTextAlignNice(?string $key): string
    {
        return $this->getTextAlignDefinitions()[$key] ?? $key ?? '';
    }

    public function getStylingTextAlignData(): ArrayData
    {
        return ArrayData::create([
               'Label' => StylingTextAlign::$singular_name,
               'Value' => $this->getStylingTextAlignNice($this->getOwner()->TextAlign),
           ]);
    }

    /**
     * @return string
     */
    public function getTextAlignVariant(): string
    {
        return $this->getConfiguredVariantClass('text_align_variants', $this->getOwner()->TextAlign);
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $fields->removeByName('TextAlign');
        $textalign = $this->getEnabledVariantOptions('text_align_variants', $this->getTextAlignDefinitions());
        if ($textalign && count($textalign) > 1) {
            $fields->addFieldToTab(
                'Root.Styling',
                StylingOptionsetField::create(
                    'TextAlign',
                    _t(StylingTextAlign::class . '.TEXTALIGN', 'Text Align'),
                    $textalign
                )
            );
        }

        return $fields;
    }

    public function onAfterPopulateDefaults(): void
    {
        $default = $this->getDefaultVariantKey('text_align_variants', $this->getTextAlignDefinitions());
        if ($default !== null) {
            $this->getOwner()->TextAlign = $default;
        }
    }
}
