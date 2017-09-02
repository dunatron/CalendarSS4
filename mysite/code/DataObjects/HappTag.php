<?php
use SilverStripe\ORM\DataObject;

class HappTag extends DataObject
{

    private static $has_many = array(
        'SecondaryTags'   =>  'SecondaryTag'
    );

    private static $db = array(
        'Title' => 'Varchar(100)',
        'Description' => 'Text'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        return $fields;
    }

}