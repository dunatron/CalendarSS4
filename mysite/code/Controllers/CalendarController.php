<?php

use SilverStripe\View\Requirements;
use SilverStripe\View\ArrayData;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ArrayList;
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
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\Control\HTTPRequest;



class CalendarPage_Controller extends PageController
{

    public function init()
    {
        parent::init();
    }

    public function doInit()
    {
        //parent::init();
        parent::doInit();

    }

    public function ThemeDir()
    {
        return ThemeResourceLoader::inst()->getPath('calendar');
    }

    // Methods allowed to run on this controller
    private static $allowed_actions = array(
        'getEventsByDate',
        'getEventData'
    );

    public function getEventsByDate(HTTPRequest $request)
    {
        $postBody = $request->getBody();

        $decode = json_decode($postBody);

        error_log(var_export($decode, true));

        $d = $decode->data;
        error_log(var_export($d, true));

        $startingMonth = date('Y-m', strtotime($d->year.'-'.$d->month));
        $endingMonth = date('Y-m-t', strtotime($d->year.'-'.$d->month));

        error_log(var_export($startingMonth, true));


        $events = Event::get()->filter(array(
            'EventDate:GreaterThanOrEqual' => $startingMonth.'-01',
            'EventDate:LessThanOrEqual' => $endingMonth,
        ));

        $dateArray = array();

        foreach ($events as $e)
        {
            $eve = new stdClass();
            $eve->ID = $e->ID;
            $eve->EventDate = $e->EventDate;
            $eve->Title = $e->EventTitle;
            // If array key exists merge values
            if(array_key_exists($eve->EventDate, $dateArray))
            {
//                error_log('Key already exists');
//                error_log(var_export($eve->EventDate, true));
                $dateArray[$eve->EventDate] .= '<a class="Event" data-EID="'.$eve->ID.'" href="#" v-on:click="getEventData" data-toggle="modal" data-target="#eventModal">' .$eve->Title . '</a>';
//                $dateArray[$eve->EventDate] .= '<event></event>';
            } else {
                $dateArray[$eve->EventDate] = '<a class="Event" data-EID="'.$eve->ID.'"  href="#" v-on:click="getEventData" data-toggle="modal" data-target="#eventModal">' . $eve->Title . '</a>';
//                $dateArray[$eve->EventDate] = '<event></event>';
            }

        }

//        error_log(var_export($dateArray, true));

        return json_encode($dateArray);
    }


    public function getEventData(HTTPRequest $request)
    {
        $postBody = $request->getBody();

        $decode = json_decode($postBody);

        error_log(var_export('Black Hawk down', true));
        error_log(var_export($decode, true));


        return json_encode('hello');
    }

}