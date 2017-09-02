<?php

use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;

/**
 * Created by PhpStorm.
 * User: heath
 * Date: 15/04/16
 * Time: 4:42 PM
 */
class CalendarPage extends Page
{
    private static $db = array();

    private static $casting = [
        'draw_calendar' => 'HTMLText'
    ];

    private static $has_one = array(
        'ClientLogo' => Image::class
    );

    private static $has_many = array();
    private static $can_be_root = true;

    //Get CMS Fields for events to add on calendar page
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.ClientLogo', $screenShot = UploadField::create('ClientLogo'));
        //Set allowed upload extensions
        $screenShot->getValidator()->setAllowedExtensions(array('png', 'gif', 'jpg', 'jpeg'));
        $screenShot->setFolderName('Client-Logos');


        return $fields;
    }

}

