<?php

namespace Fractas\ElementalStylings\Forms;

use Override;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Requirements;

class StylingOptionsetField extends OptionsetField
{
    #[Override]
    public function Field($properties = []): DBHTMLText
    {
        $options = [];
        $odd = false;

        foreach ($this->getSourceEmpty() as $value => $title) {
            $odd = !$odd;
            $options[] = $this->getFieldOption($value, $title, $odd);
        }

        $properties = array_merge($properties, [
            'Options' => ArrayList::create($options),
        ]);

        Requirements::css('fractas/elemental-stylings:client/dist/css/cms.css');

        return FormField::Field($properties);
    }
}
