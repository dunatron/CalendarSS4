<?php
use SilverStripe\ORM\DataObject;

class Ticket extends DataObject
{
    private static $has_one = array(
        'Event' => 'Event',
    );
    private static $db = array(
        'TicType' => 'Text',
        'TicPrice' => 'Currency'
    );

    private static $summary_fields = array(
        'TicType' => 'TicType',
        'TicPrice' => 'TicPrice'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        return $fields;
    }

}
