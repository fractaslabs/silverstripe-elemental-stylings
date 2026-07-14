<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Concerns\ResolvesStylingVariants;
use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingLimit extends Extension
{
    use ResolvesStylingVariants;

    /**
     * @config
     */
    private static array $db = [
        'Limit' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Limit';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Limits';

    /**
     * @config
     *
     * @var array
     */
    private static array $limit_variants = [];

    /** @return array<string, string> */
    private function getLimitDefinitions(): array
    {
        return [
            'three' => _t(StylingLimit::class . '.THREE', '3 items'),
            'six' => _t(StylingLimit::class . '.SIX', '6 items'),
            'twelve' => _t(StylingLimit::class . '.TWELVE', '12 items'),
        ];
    }

    public function getStylingLimitNice(?string $key): string
    {
        return $this->getLimitDefinitions()[$key] ?? $key ?? '';
    }

    public function getStylingLimitData(): ArrayData
    {
        return ArrayData::create([
           'Label' => StylingLimit::$singular_name,
           'Value' => $this->getStylingLimitNice($this->getOwner()->Limit),
        ]);
    }

    /**
     * @return string
     */
    public function getLimitVariant(): string
    {
        return $this->getConfiguredVariantClass('limit_variants', $this->getOwner()->Limit);
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $limit = $this->getEnabledVariantOptions('limit_variants', $this->getLimitDefinitions());
        if ($limit && count($limit) > 1) {
            $fields->addFieldToTab(
                'Root.Styling',
                StylingOptionsetField::create('Limit', _t(StylingLimit::class . '.LIMIT', 'Limit'), $limit)
            );
        } else {
            $fields->removeByName('Limit');
        }

        return $fields;
    }

    public function onAfterPopulateDefaults(): void
    {
        $default = $this->getDefaultVariantKey('limit_variants', $this->getLimitDefinitions());
        if ($default !== null) {
            $this->getOwner()->Limit = $default;
        }
    }
}
