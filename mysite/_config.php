<?php

use SilverStripe\i18n\i18n;
use SilverStripe\Control\Director;
use SilverStripe\ORM\Connect\MySQLDatabase;

global $database;
$database = '';

require_once('conf/ConfigureFromEnv.php');

// Set the site locale
//i18n::set_locale('en_US');

/* OLD config, may have to play with location of require_once('conf/ConfigureFromEnv.php');
global $database;
$database = '';
require_once('conf/ConfigureFromEnv.php');
*/
// Set the site locale
i18n::set_locale('en_NZ');
//Config::inst()->update('i18n', 'date_format', 'dd.MM.YYYY');
//FulltextSearchable::enable();
//Event::add_extension("FulltextSearchable('EventTitle','EventDescription')");
//Solr::configure_server(array(
//    'host' => 'localhost',
//    'indexstore' => array(
//        'mode' => 'file',
//        'path' => BASE_PATH . '/.solr'
//    ),
//    'port'  =>  '8983'
//));
//SilverStripe\Assets\Image::add_extension('EventImage');