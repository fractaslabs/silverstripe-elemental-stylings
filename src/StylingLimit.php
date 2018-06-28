<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingLimit extends DataExtension
{
    private static $db = [
        'Limit' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Limit';

    /**
     * @var string
     */
    private static $plural_name = 'Limits';

    /**
     * @config
     *
     * @var array
     */
    private static $limit = [];

    public function getStylingLimitNice($key)
    {
        return (!empty($this->owner->config()->get('limit')[$key])) ? $this->owner->config()->get('limit')[$key] : $key;
    }

    public function getStylingLimitData()
    {
        return ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingLimitNice($this->owner->Limit),
       ]);
    }

    /**
     * @return string
     */
    public function getLimitVariant()
    {
        $limit = $this->owner->Limit;
        $limits = $this->owner->config()->get('limit');

        if (isset($limits[$limit])) {
            $limit = strtolower($limit);
        } else {
            $limit = '';
        }

        return 'limit-'.$limit;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $limit = $this->owner->config()->get('limit');
        if ($limit && count($limit) > 1) {
            $fields->addFieldsToTab('Root.Styling', DropdownField::create('Limit', _t(__CLASS__.'.LIMIT', 'Limit'), $limit));
        } else {
            $fields->removeByName('Limit');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $limit = $this->owner->config()->get('limit');
        $limit = reset($limit);

        $this->owner->Limit = $limit;

        parent::populateDefaults();
    }
}
