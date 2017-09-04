<?php

use SilverStripe\CMS\Model\SiteTree;

class Page extends SiteTree
{

    private static $db = array();

    private static $casting = [
        'getSearchSVG' => 'HTMLText',
        'getAddEventSVG'    =>  'HTMLText',
        'getFilterSVG' => 'HTMLText',
        'getClockSVG' => 'HTMLText',
        'getTicketSVG' => 'HTMLText',
        'getRestrictSVG' => 'HTMLText',
        'getLocationSVG' => 'HTMLText',
        'getCalendarSVG' => 'HTMLText',
        'getCloseSVG' => 'HTMLText',
        'getLoopSVG' => 'HTMLText'
    ];

    private static $has_one = array();

}