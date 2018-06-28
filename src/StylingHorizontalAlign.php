<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingHorizontalAlign extends DataExtension
{
    private static $db = [
        'HorAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Horizontal Align';

    /**
     * @var string
     */
    private static $plural_name = 'Horizontal Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static $horalign = [];

    public function getStylingHorizontalAlignNice($key)
    {
        return (!empty($this->owner->config()->get('horalign')[$key])) ? $this->owner->config()->get('horalign')[$key] : $key;
    }

    public function getStylingHorizontalAlignData()
    {
        return ArrayData::create([
               'Label' => self::$singular_name,
               'Value' => $this->getStylingHorizontalAlignNice($this->owner->HorAlign),
           ]);
    }

    /**
     * @return string
     */
    public function getHorAlignVariant()
    {
        $horalign = $this->owner->HorAlign;
        $horaligns = $this->owner->config()->get('horalign');

        if (isset($horaligns[$horalign])) {
            $horalign = strtolower($horalign);
        } else {
            $horalign = '';
        }

        return 'horalign-'.$horalign;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('HorAlign');
        $horalign = $this->owner->config()->get('horalign');
        if ($horalign && count($horalign) > 1) {
            $fields->addFieldsToTab(
                'Root.Styling',
                StylingOptionsetField::create('HorAlign', _t(__CLASS__.'.HORIZONTALALIGN', 'Horizontal Align'), $horalign)
            );
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $horalign = $this->owner->config()->get('horalign');
        $horalign = key($horalign);

        $this->owner->HorAlign = $horalign;

        parent::populateDefaults();
    }
}
