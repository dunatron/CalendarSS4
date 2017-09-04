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
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\LabelField;


class HappSiteConfig extends DataExtension
{
    private static $db = array(
        'DefaultBGColor' => 'Varchar(25)',
        'UseGradient'   =>  'Boolean',
        'GradientBGColor1' => 'Varchar(25)',
        'GradientBGColor2' => 'Varchar(25)',
        'GradientBGColor3' => 'Varchar(25)',
        'GradientBGColor4' => 'Varchar(25)'
    );

    /*
     *
     * $c_cal_bg_gradient_1:$c_orange_light_1;
$c_cal_bg_gradient_2:$c_orange_light_2;
$c_cal_bg_gradient_3:$c_orange_main;
$c_cal_bg_gradient_4:$c_orange_dark_2;
     */

    private static $has_one = array(
        'HappLogo' => Image::class,
        'ClientLogo' => Image::class
    );

    public function updateCMSFields(FieldList $fields)
    {
        /**
         * Gradient colors for calendar background
         */
        $fields->addFieldToTab('Root.CalendarBase', CompositeField::create(
            $colorHeader = HeaderField::create('ColorHeader', 'Background colors for calendar gradient'),
            $defaultBackgroundColor = TextField::create('DefaultBGColor', 'Default Background color for calendar body'),

            $gradientLabel = LabelField::create('GradientColorLabel', 'Gradient colors for the calendar Background'),
            $test = CompositeField::create(
                $useGradient = CheckboxField::create('UseGradient', 'Check to use the gradient instead of the default base'),
                $backgroundColor1 = TextField::create('GradientBGColor1', 'Gradient 1')
                    ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'),
                $backgroundColor2 = TextField::create('GradientBGColor2', 'Gradient 2')
                    ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'),
                $backgroundColor3 = TextField::create('GradientBGColor3', 'Gradient 3')
                    ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)'),
                $backgroundColor4 = TextField::create('GradientBGColor4', 'Gradient 4')
                    ->setDescription('Please enter rgb or hex value as varchar e.g #425968 or rgba(66,89,104)')
            )

        ));

    }
}