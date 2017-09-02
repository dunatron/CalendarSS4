<?php

/**
 * Created by PhpStorm.
 * User: Heath
 * Date: 13/02/17
 * Time: 9:24 PM
 */

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;


class HappSiteConfig extends DataExtension
{
    private static $db = array(
        'ClientColor' => 'Varchar(20)',
        'SecondBarColor' => 'Varchar(20)',
        'MonthTxtColor' =>  'Varchar(20)',
        'MonthArrowsColor' =>  'Varchar(20)',
        'EventBackgroundColor' => 'Varchar(20)',
        'EventBackgroundHoverColor' => 'Varchar(20)',
        'LetterColor'   =>  'Varchar(20)',
        'LetterHoverColor'  =>  'Varchar(20)',
        'CurrentDayColor'   =>  'Varchar(20)',
        'DayNumberColor'   =>  'Varchar(20)',
        'CurrentDayBackground'  =>  'Varchar(20)',
        'MenuIconColors'    =>  'Varchar(20)',
        'CalendarPickerBGColor' =>  'Varchar(20)',
        'ModalLocationColor'    =>  'Varchar(20)',
        'EventModalIcoColors'   =>  'Varchar(20)',
        'SearchCloseBGColor'    =>  'Varchar(20)',
        'SearchCloseIcoColor'   =>  'Varchar(20)',
        'SearchBtnBGColor'    =>  'Varchar(20)',
        'SearchBtnIcoColor'   =>  'Varchar(20)',
        'ModalCloseBtnColor'    =>  'Varchar(20)',
        'ModalHeaderBGColor'    =>  'Varchar(20)',
        'ModalHeaderTxtColor'   =>  'Varchar(20)',
        'ModalBodyBGColor'  =>  'Varchar(20)',
        'ModalBodyTxtColor' =>  'Varchar(20)'
    );

    private static $has_one = array(
        'HappLogo' => Image::class,
        'ClientLogo' => Image::class
    );

    public function updateCMSFields(FieldList $fields)
    {

        /** Colors
         * ClientColor
         */
        $fields->addFieldToTab('Root.Colors',
            TextField::create('ClientColor', 'Client Color')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // SecondBarColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('SecondBarColor', 'second bar containing the days')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // MonthTxtColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('MonthTxtColor', 'Month Text color for top bar')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // MonthArrowsColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('MonthArrowsColor', 'Month Arrows Indicator Color')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // MenuIconColors
        $fields->addFieldToTab('Root.Colors',
            TextField::create('MenuIconColors', 'Color for the menu Icons, search, add, filter')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // EventBackgroundColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('EventBackgroundColor', 'event background color')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // EventBackgroundHoverColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('EventBackgroundHoverColor', 'event background hover stop')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // LetterColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('LetterColor', 'Letter Color for the events')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // LetterHoverColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('LetterHoverColor', 'Letter Hover Color for the events')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // CurrentDayColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('CurrentDayColor', 'Current Day number color')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // CurrentDayBackground
        $fields->addFieldToTab('Root.Colors',
            TextField::create('CurrentDayBackground', 'Background color for the current day')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        //DayNumberColor
        $fields->addFieldToTab('Root.Colors',
            TextField::create('DayNumberColor', 'Color for the day number on events')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        /* ADD EVENT MODAL */
        // CalendarPickerBGColor
        $fields->addFieldToTab('Root.AddEventModalColors',
            TextField::create('CalendarPickerBGColor', 'Background color for the calendar date picker')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        /* EVENT MODAL */
        // ModalLocationColor
        $fields->addFieldToTab('Root.EventModalColors',
            TextField::create('ModalLocationColor', 'Color For the Location Icon on the event modal')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // EventModalIcoColors
        $fields->addFieldToTab('Root.EventModalColors',
            TextField::create('EventModalIcoColors', 'Color for the icons on the event modal')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        /* SEARCH MODAL */
        // SearchCloseBGColor
        $fields->addFieldToTab('Root.SearchModalColors',
            TextField::create('SearchCloseBGColor', 'Color the search close background color')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // SearchCloseIcoColor
        $fields->addFieldToTab('Root.SearchModalColors',
            TextField::create('SearchCloseIcoColor', 'Color the search close Icon color')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // SearchBtnBGColor
        $fields->addFieldToTab('Root.SearchModalColors',
            TextField::create('SearchBtnBGColor', 'Color the search background Icon color')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));
        // SearchBtnIcoColor
        $fields->addFieldToTab('Root.SearchModalColors',
            TextField::create('SearchBtnIcoColor', 'Color the search Icon color')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        /**
         * Modal config
         */
        // ModalCloseBtnColor
        $fields->addFieldToTab('Root.Modals',
            TextField::create('ModalCloseBtnColor', 'Color for the close button on modals')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        // ModalHeaderBGColor
        $fields->addFieldToTab('Root.Modals',
            TextField::create('ModalHeaderBGColor', 'background color for the modal header')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        // ModalHeaderTxtColor
        $fields->addFieldToTab('Root.Modals',
            TextField::create('ModalHeaderTxtColor', 'Text color for the modal headers')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        // ModalBodyBGColor
        $fields->addFieldToTab('Root.Modals',
            TextField::create('ModalBodyBGColor', 'Background color for modal body')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        // ModalBodyTxtColor
        $fields->addFieldToTab('Root.Modals',
            TextField::create('ModalBodyTxtColor', 'Text color for modal body')
                ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'));

        // Logos
        $fields->addFieldToTab("Root.Logos",
            UploadField::create('HappLogo', 'Happ Logo')
                ->setDescription('The Happ Logo goes here')
                ->setFolderName('Logos')
        );
        $fields->addFieldToTab("Root.Logos",
            UploadField::create('ClientLogo', 'The client logo goes here')
                ->setDescription('Please put the client logo here')
                ->setFolderName('Logos')
        );

    }
}