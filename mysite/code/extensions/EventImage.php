<?php

use SilverStripe\ORM\DataExtension;

class EventImage extends DataExtension
{
    private static $db=array(
        'transformation_id' => 'Int'
    );

    private static $belongs_many_many = array(
        "HappEventImages"   =>  'Event'
    );

    public function setFilename($val) {
        $this->setField('Filename', $val);
    }
}