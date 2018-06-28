<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingVerticalAlign extends DataExtension
{
    private static $db = [
        'VerAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Vertical Align';

    /**
     * @var string
     */
    private static $plural_name = 'Vertical Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static $veralign = [];

    public function getStylingVerticalAlignNice($key)
    {
        return (!empty($this->owner->config()->get('veralign')[$key])) ? $this->owner->config()->get('veralign')[$key] : $key;
    }

    public function getStylingVerticalAlignData()
    {
        return ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingVerticalAlignNice($this->owner->VerAlign),
       ]);
    }

    /**
     * @return string
     */
    public function getVerAlignVariant()
    {
        $veralign = $this->owner->VerAlign;
        $veraligns = $this->owner->config()->get('veralign');

        if (isset($veraligns[$veralign])) {
            $veralign = strtolower($veralign);
        } else {
            $veralign = '';
        }

        return 'veralign-'.$veralign;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('VerAlign');
        $veralign = $this->owner->config()->get('veralign');
        if ($veralign && count($veralign) > 1) {
            $fields->addFieldsToTab(
                'Root.Styling',
                StylingOptionsetField::create('VerAlign', _t(__CLASS__.'.VERTICALALIGN', 'Vertical Align'), $veralign)
            );
        }

        return $fields;
    }

    public function populateDefaults()
    {
        if ($this->owner->config()->get('stop_veralign_inheritance')) {
            $veralign = $this->owner->config()->get('veralign', Config::UNINHERITED);
        } else {
            $veralign = $this->owner->config()->get('veralign');
        }

        $veralign = key($veralign);
        $this->owner->VerAlign = $veralign;

        parent::populateDefaults();
    }
}
