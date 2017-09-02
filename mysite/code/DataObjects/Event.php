<?php
/**
 * Created by PhpStorm.
 * User: Heath
 * Date: 16/04/16
 * Time: 12:27 AM
 */

use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TimeField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridField;


class Event extends DataObject {

    public function Link($action = 'show') {
        return Controller::join_links('my-controller', $action, $this->ID);
    }

    public function getShowInSearch() {
        return 1;
    }

    private static $has_one = array(
        'SecondaryTag'  =>  'SecondaryTag'
    );

    private static $has_many = array(
        'Tickets' => 'Ticket',
        'EventFindaImages'  =>  'EventFindaImage'
    );

    private static $many_many = array(
        'EventImages'   =>  Image::class
    );

    private static $summary_fields = array(
        'EventTitle' => 'EventTitle',
        'EventVenue'    =>  'EventVenue',
        'LocationText' => 'LocationText',
        'EventDate' => 'EventDate',
        'IsApproved' => 'Approved status'
    );

    public function getIsApproved()
    {
        $check = '';
        if($this->EventApproved == 1){
            $check = 'Yes';
        }else {
            $check = 'No';
        }
        return $check;
    }

    private static $db = array(
        'EventTitle' => 'Varchar(100)',
        'EventVenue' => 'Varchar(100)',
        'LocationText' => 'Text',
        'LocationLat' => 'Varchar(100)', // Find a better data type
        'LocationLon' => 'Varchar(100)',
        'SpecLocation'  =>  'Text',
        'EventDescription' => 'HTMLText',
        'EventDate' => 'Date',
        'StartTime' => 'Time',
        'FinishTime' => 'Time',
        'EventApproved' => 'Boolean',
        'IsFree'    =>  'Boolean',
        'BookingWebsite'    =>  'Text',
        'TicketWebsite' => 'Text',
        'TicketPhone' => 'Varchar(30)',
        'Restriction' => 'Text',
        'SpecEntry' =>  'Text',
        'AccessType' => 'Text',
        'IsEventFindaEvent' =>  'Boolean',
        'EventFindaID'  =>  'Int',
        'EventFindaURL' =>  'Text',
    );

    private static $searchable_fields = array(
        'EventTitle',
        'EventDate',
        'EventApproved',
        'EventVenue',
        'LocationText'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();

        // EventTitle
        $fields->addFieldToTab('Root.Main', TextField::create('EventTitle', 'Title:')
            ->setDescription('e.g <strong>Little johnys bakeoff</strong>'));
        //EventVenue
        $fields->addFieldToTab('Root.Main', TextField::create('EventVenue', 'Venue:')
            ->setDescription('e.g <strong>Entertainment Centre</strong>'));
        // LocationText
        $fields->addFieldToTab('Root.Main', TextField::create('LocationText', 'Location:')
            ->setDescription('e.g <strong>182 Bowmar Rd, Waimumu 9774, New Zealand</strong>'));
        // LocationLat
        $fields->addFieldToTab('Root.Main', NumericField::create('LocationLat', 'Location latitude:')
            ->setDescription('e.g <strong>-46.1326615</strong>'));
        // LocationLon
        $fields->addFieldToTab('Root.Main', NumericField::create('LocationLon', 'Location longitude:')
            ->setDescription('e.g <strong>168.89592100000004</strong>'));
        $fields->addFieldToTab('Root.Main', DateField::create('EventDate', DBDate::class)
            ->setDescription('Date for the event'));
        // StartTime
        $fields->addFieldToTab('Root.Main', TimeField::create('StartTime')
            ->setDescription('Start time for the event format-><strong>18:00:00</strong>'));

        // FinishTime
        $fields->addFieldToTab('Root.Main', TimeField::create('FinishTime')
            ->setDescription('Finish time for the event format-><strong>18:01:00</strong>')
            ->setAttribute('autocomplete', 'on'));

        // Type
        $fields->addFieldToTab('Root.Main', CheckboxField::create('EventApproved', 'Event Approved')
            ->setDescription('Check to display this event on the calendar'));

        // Ticket website
        $fields->addFieldToTab('Root.Main', TextField::create('TicketWebsite', 'Ticket Website')
            ->setDescription('URL where tickets for this event can be purchased from'));

        // Ticket phone
        $fields->addFieldToTab('Root.Main', TextField::create('TicketPhone', 'Ticket Phone')
            ->setDescription('Number to call to buy tickets'));

        // BookingWebsite
        $fields->addFieldToTab('Root.Main', TextField::create('BookingWebsite', 'Booking Website URL')
            ->setDescription('Booking website URL'));

        // EventDescription
        $fields->addFieldToTab('Root.Main', TextareaField::create('EventDescription', 'Description')
            ->setDescription('The real description field'));

        // Restrictions
        $fields->addFieldToTab('Root.Main', new DropdownField(
            'Restriction',
            'Choose A Restriction Type',
            EventRestriction::get()->map('ID', 'Description')->toArray(),
            null,
            true
        ));

        // Access Type
        $acc = new AccessTypeArray();
        $fields->addFieldToTab('Root.Main', $acc->getAccessValues());

        // IsEventFindaEvent
        $fields->addFieldToTab('Root.EventFinda', CheckboxField::create('IsEventFindaEvent', 'Is EventFinda Event')
            ->setDescription('Leave this checked if event has come from event finda'));

        // EventFindaID
        $fields->addFieldToTab('Root.EventFinda', TextField::create('EventFindaID', 'Id for event finda'));

        // EventFindaURL
        $fields->addFieldToTab('Root.EventFinda', TextField::create('EventFindaURL', 'Absolute url for event')
            ->setDescription('If this event was generated by event finda this field will contain a value'));

        // Tags for calendar
        $fields->addFieldToTab('Root.EventFindaImages', GridField::create(
            'EventFindaImages',
            'Event Finda Images on page',
            $this->EventFindaImages(),
            GridFieldConfig_RecordEditor::create()
        ));

        $fields->addFieldToTab('Root.EventImages', $eventImages = UploadField::create('EventImages'));
        //Set allowed upload extensions
        $eventImages->getValidator()->setAllowedExtensions(array('png', 'gif', 'jpg', 'jpeg'));
        // Create Folder for images
        $Year = date('Y');
        $Month = date('M');
        $makeDirectory = 'Uploads/' . $Year . '/' . $Month;
        $eventImages->setFolderName($makeDirectory);
        //$eventImages->setFolderName('event-Images');

        return $fields;
    }

    public static function get_by_finda_id($callerClass, $id, $cache = true) {
        if(!is_numeric($id)) {
            user_error("DataObject::get_by_finda_id passed a non-numeric ID #$id", E_USER_WARNING);
        }

        // Check filter column
        if(is_subclass_of($callerClass, DataObject::class)) {
            $baseClass = DataObject::getSchema()->baseDataClass($callerClass);
            $column = "\"$baseClass\".\"EventFindaID\"";
        } else{
            // This simpler code will be used by non-DataObject classes that implement DataObjectInterface
            $column = '"EventFindaID"';
        }
        $column = '"EventFindaID"';

        // Relegate to get_one
        return DataObject::get_one($callerClass, array($column => $id), $cache);
    }

}