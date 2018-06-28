<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingTextAlign extends DataExtension
{
    private static $db = [
        'TextAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Text Align';

    /**
     * @var string
     */
    private static $plural_name = 'Text Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static $textalign = [];

    public function getStylingTextAlignNice($key)
    {
        return (!empty($this->owner->config()->get('textalign')[$key])) ? $this->owner->config()->get('textalign')[$key] : $key;
    }

    public function getStylingTextAlignData()
    {
        return ArrayData::create([
               'Label' => self::$singular_name,
               'Value' => $this->getStylingTextAlignNice($this->owner->TextAlign),
           ]);
    }

    /**
     * @return string
     */
    public function getTextAlignVariant()
    {
        $textalign = $this->owner->TextAlign;
        $textaligns = $this->owner->config()->get('textalign');

        if (isset($textaligns[$textalign])) {
            $textalign = strtolower($textalign);
        } else {
            $textalign = '';
        }

        return 'textalign-'.$textalign;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('TextAlign');
        $textalign = $this->owner->config()->get('textalign');
        if ($textalign && count($textalign) > 1) {
            $fields->addFieldsToTab(
                'Root.Styling',
                StylingOptionsetField::create('TextAlign', _t(__CLASS__.'.TEXTALIGN', 'Text Align'), $textalign)
            );
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $textalign = $this->owner->config()->get('textalign');
        $textalign = key($textalign);

        $this->owner->TextAlign = $textalign;

        parent::populateDefaults();
    }
}
