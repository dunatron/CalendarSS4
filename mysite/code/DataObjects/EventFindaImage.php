<?php

use SilverStripe\ORM\DataObject;

class EventFindaImage extends DataObject
{
    private static $has_one = array(
        'Event' =>  'Event'
    );

    private static $db = array(
        'Title' => 'Text',
        'URL'   =>  'Text',
        'transformation_id' => 'Int'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        return $fields;
    }
}
