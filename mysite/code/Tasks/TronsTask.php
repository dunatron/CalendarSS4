<?php
/**
 * Created by PhpStorm.
 * User: Heath
 * Date: 13/07/16
 * Time: 8:12 PM
 */

use SilverStripe\Dev\BuildTask;

class TronsTask extends BuildTask {



    protected $title = "TRON Get Events API";

    protected $description = "Get Api Data e.g shity old Event Finder Events, and convert them to happ event data to use (not implemented yet)";

    public function run($request) {
        $events = $this->getAllEvents();
        foreach($events as $e)
        {
            echo "===================================</br>";
            echo "ID: " . $e->ID . "</br>";
            echo "Title: " . $e->Title . "</br>";
            echo "Created: " . $e->Created . "</br>";
            echo "Location: " . $e->LocationText . "</br>";
            echo "Lat: " . $e->LocationLat . "</br>";
            echo "Lon: " . $e->LocationLon . "</br>";
            echo "Approved: " . $e->Approved . "</br>";
        }

    }


    /*
     * @return all Events
     */
    public function getAllEvents()
    {
        $events = Event::get();

        return $events;
    }

}