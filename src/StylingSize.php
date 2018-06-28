<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingSize extends DataExtension
{
    private static $db = [
        'Size' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Size';

    /**
     * @var string
     */
    private static $plural_name = 'Sizes';

    /**
     * @config
     *
     * @var array
     */
    private static $size = [];

    public function getStylingSizeNice($key)
    {
        return (!empty($this->owner->config()->get('size')[$key])) ? $this->owner->config()->get('size')[$key] : $key;
    }

    public function getStylingSizeData()
    {
        return ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingSizeNice($this->owner->Size),
       ]);
    }

    /**
     * @return string
     */
    public function getSizeVariant()
    {
        $size = $this->owner->Size;
        $sizes = $this->owner->config()->get('size');

        if (isset($sizes[$size])) {
            $size = strtolower($size);
        } else {
            $size = '';
        }

        return 'size-'.$size;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $size = $this->owner->config()->get('size');
        if ($size && count($size) > 1) {
            $fields->addFieldsToTab('Root.Styling', DropdownField::create('Size', _t(__CLASS__.'.SIZE', 'Size'), $size));
        } else {
            $fields->removeByName('Size');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $size = $this->owner->config()->get('size');
        $size = reset($size);

        $this->owner->Size = $size;

        parent::populateDefaults();
    }
}
