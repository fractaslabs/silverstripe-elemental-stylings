<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingStyle extends DataExtension
{
    /**
     * @var string
     */
    private static $singular_name = 'Style';

    /**
     * @var string
     */
    private static $plural_name = 'Styles';

    /**
     * @config
     *
     * @var array
     */
    private static $style = [];

    public function getStylingStyleNice($key)
    {
        return (!empty($this->owner->config()->get('styles')[$key])) ? $this->owner->config()->get('styles')[$key] : $key;
    }

    public function getStylingStyleData()
    {
        return ArrayData::create([
               'Label' => self::$singular_name,
               'Value' => $this->getStylingStyleNice($this->owner->Style),
           ]);
    }

    public function getStylingTitleData()
    {
        return ArrayData::create([
               'Label' => 'Title',
               'Value' => $this->owner->obj('ShowTitle')->Nice(),
           ]);
    }

    /**
     * @return string
     */
    public function updateStyleVariant(&$style)
    {
        if (isset($style)) {
            $style = strtolower($style);
        } else {
            $style = '';
        }
        $style = 'style-'.$style;

        return $style;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $style = $this->owner->config()->get('styles');
        if ($style && count($style) > 1) {
            $fields->addFieldsToTab('Root.Styling', DropdownField::create('Style', _t(__CLASS__.'.STYLE', 'Style'), $style));
        } else {
            $fields->removeByName('Style');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $style = $this->owner->config()->get('styles');
        $style = array_key_first($style);

        $this->owner->Style = $style;

        parent::populateDefaults();
    }
}
