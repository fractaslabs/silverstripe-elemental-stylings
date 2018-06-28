<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingWidth extends DataExtension
{
    private static $db = [
        'Width' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Width';

    /**
     * @var string
     */
    private static $plural_name = 'Widths';

    /**
     * @config
     *
     * @var array
     */
    private static $width = [];

    public function getStylingWidthNice($key)
    {
        return (!empty($this->owner->config()->get('width')[$key])) ? $this->owner->config()->get('width')[$key] : $key;
    }

    public function getStylingWidthData()
    {
        return ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingWidthNice($this->owner->Width),
       ]);
    }

    /**
     * @return string
     */
    public function getWidthVariant()
    {
        $width = $this->owner->Width;
        $widths = $this->owner->config()->get('width');

        if (isset($widths[$width])) {
            $width = strtolower($width);
        } else {
            $width = '';
        }

        return $width;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $width = $this->owner->config()->get('width');
        if ($width && count($width) > 1) {
            $fields->addFieldsToTab('Root.Styling', StylingOptionsetField::create('Width', _t(__CLASS__.'.WIDTH', 'Width Size'), $width));
        } else {
            $fields->removeByName('Width');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $width = $this->owner->config()->get('width');
        $width = reset($width);

        $this->owner->Width = $width;

        parent::populateDefaults();
    }
}
