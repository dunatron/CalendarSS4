<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 30/01/17
 * Time: 11:28 AM
 */

use SilverStripe\Dev\BuildTask;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\ArrayData;
use SilverStripe\Dev\Debug;
use SilverStripe\Assets\Image;


class AddEventFindaEvents extends BuildTask
{
    // Guide for array conversion ->http://array.include-once.org/
    // Guide for array conversion ->http://array.include-once.org/

    protected $title = 'Add event finda events';

    protected $description = 'populate happ database with event finda events';

    public $apiUserName = 'whatshappnz';

    public $apiUserPass = '78nvbw7qn29x';




    //public $apiURL = 'http://api.eventfinda.co.nz/v2/events.json?rows=20&session:(timezone,datetime_start)&q=concert&order=popularity&location=126';


    //public $apiURL = 'http://api.eventfinda.co.nz/v2/events.json?rows=20&session:(timezone,datetime_start)&q=concert&order=popularity';
    public function apiURL()
    {
        $conf = SiteConfig::current_site_config();
        $baseQ = $conf->BaseQuery;
        $locationQ = $conf->LocationQuery;
        $Query = $baseQ .= $locationQ;
        return $Query;
    }

    /*
     * Generate number of api calls needed. Page has 20 events/rows
     */
    public function getOffsetPages($collection)
    {
        $count = $collection->{'@attributes'}->count;
        echo '<p>Event Count:' . $count . '</p>';
        $offset = $count / 20;
        $ceiling = ceil($offset);
        return $ceiling;
    }

    public function StoreEvents($collection)
    {
        foreach ($collection->events as $event) {

            echo '<p>' . $event->id . '</p>';
            // Check if we have this event already
            if (Event::get_by_finda_id('Event', $event->id) == false) {
                //create a new event
                $isNewEvent = true;
                $newEvent = Event::create();
                $newEvent->EventFindaID = $event->id;
                echo '<p style="color:green;">' . $event->name . ' created</p>';
            } else {
                //receive and update existing event
                $newEvent = Event::get_by_finda_id('Event', $event->id);
                $isNewEvent = false;
                echo '<p style="color:orange;">' . $event->name . ' updated</p>';
            }

            $newEvent->EventTitle = $event->name;
            $newEvent->EventFindaURL = $event->url;
            $newEvent->EventDescription = $event->description;
            $newEvent->CalendarPageID = 1;
            $newEvent->EventApproved = 1;
            $newEvent->IsEventFindaEvent = 1;
            $newEvent->EventVenue = $event->location->name;
            // venue name
            $newEvent->LocationText = $event->location->summary;
            // Location Summary
            $newEvent->LocationLat = $event->point->lat;
            // Lat address
            $newEvent->LocationLat = $event->point->lat;
            // Lon address
            $newEvent->LocationLon = $event->point->lng;
            // Event Date
            $newEvent->EventDate = $event->datetime_start;
            // Start Time
            $newEvent->StartTime = $event->datetime_start;
            // Finish Time
            $newEvent->FinishTime = $event->datetime_end;

            // Try store website if we have one. (just get the first site)
            if (!empty($event->web_sites->web_sites)) {
                $newEvent->TicketWebsite = $event->web_sites->web_sites[0]->url;
            }

            $newEvent->write(); // Must write event before we store image(or we dont know the events id)

            /**
             * Run only when event is new to our db
             * Check for new SubTag
             * Store Images
             * Check for new EventRestriction
             */
            if($isNewEvent == true){
                $images = $event->images->images;
                $eventID = $newEvent->ID;
                // ToDo create check if is new image. If not dont run store images function
                //$storeImage = $this->storeEventImage($images, $eventID);
                $this->storeEventImage($images, $eventID);

                // Check for tags
                if(isset ($event->category)){
                    $checkTag = $this->checkTag($event->category->name);
                    var_dump($checkTag->check);
                    if($checkTag->check == false){
                        $this->createTag($checkTag->tag);
                    }
                    $newEvent->EventTags =  $checkTag->tag;
                    $newEvent->write();

                }
                // Check for restrictions
                if (isset ($event->restrictions)){
                    $checkRestriction = $this->checkRestriction($event->restrictions);
                    if($checkRestriction->check == false){
                        $restrictionID = $this->createRestriction($checkRestriction->restriction);
                    } else {
                        $restrictions = EventRestriction::get()->filter(array(
                            "Description"   => $checkRestriction->restriction
                        ));
                        foreach ($restrictions as $r){
                            $restrictionID = $r->ID;
                        }
                    }
                    $newEvent->Restriction =  $restrictionID;
                    $newEvent->write();
                }

            }else {
                //continue;
            }
        }
    }

    // Check if tag is in the db
    public function checkTag($tag)
    {
        $tagToCheck = $tag;
        $dbTags = SubTag::get();
        $tagArray = array();
        foreach ($dbTags as $t){
            array_push($tagArray, $t->Title);
        }

        if (in_array($tagToCheck, $tagArray)){
            echo ('Tag is already in db');
            $data = new ArrayData(array(
                'check' => true,
                'SubTag' => $tagToCheck
            ));
        } else {
            echo ('we must add the tag');
            echo($tagToCheck);
            $data = new ArrayData(array(
               'check' => false,
                'SubTag' => $tagToCheck
            ));
        }
        return $data;

    }

    public function createTag($tagName)
    {
        $t = SubTag::create();
        $t->Title = $tagName;
        $t->write();
        echo ('New SubTag: '.$t->Title.' has been created <br />');
        return;
    }

    /*
     * check if restriction is in database
     */
    public function checkRestriction($restriction)
    {
        $restrictionToCheck = $restriction;
        $dbRestrictions = EventRestriction::get();
        $restrictionArray = array();
        foreach ($dbRestrictions as $r){
            array_push($restrictionArray, $r->Description);
        }

        if (in_array($restrictionToCheck, $restrictionArray)){
            $data = new ArrayData(array(
                'check' =>  true,
                'restriction'   =>  $restrictionToCheck
            ));
        } else {
            $data = new ArrayData(array(
                'check' =>  false,
                'restriction'   =>  $restrictionToCheck
            ));
        }
        return $data;
    }

    /**
     * Create A restriction SubTag
     */
    public function createRestriction($restriction)
    {
        $r = EventRestriction::create();
        $r->Description = $restriction;
        $r->write();
        echo ('New Restriction: '.$r->Description.' has been created <br />');
        return $r->ID;
    }

    /*
     * stores parsed images into event with the parsed id
     */
    public function storeEventImage($images, $eventID)
    {

        foreach ($images as $image) {
            $file = Image::create();
            echo '<h3>' . $image->id . "</h3>";
            // iterate over the transforms collection of transforms
            $imageQuality=0;
            $currQuality=0;
            foreach ($image->transforms->transforms as $transform) {
                if($transform->transformation_id == 7){
                    $currQuality=5;
                }elseif($transform->transformation_id == 27) {
                    $currQuality=4;
                }
                elseif($transform->transformation_id == 8) {
                    $currQuality=3;
                }
                elseif($transform->transformation_id == 2) {
                    $currQuality=2;
                }
                elseif($transform->transformation_id == 15) {
                    $currQuality=1;
                }
                if($currQuality > $imageQuality){
                    $imageQuality = $currQuality;
                    $checkImageExists = $this->checkRemoteFile($transform->url); //returns true or false
                    if($checkImageExists == true){
                        echo '<p>Image exists</p>';
                        // ToDo | try 27 elseif
                        $rawFileName = $transform->url;
                        if(strpos($rawFileName, '?') !== false){
                            $fileName = substr($rawFileName, 0, strpos($rawFileName, "?"));
                        } else {
                            $fileName = $rawFileName;
                        }
                        if(!empty($fileName) ){
                            $file->Title = 'eventFinda-Img';
                            $file->URL = $fileName;
                            $file->transformation_id = $transform->transformation_id;
                            Debug::show($file->Name);
                            Debug::show($file->Filename);
                            // associate file with event
                            $file->EventID = $eventID;
                        }

                    }else {
                        echo '<p>No Image</p>';
                    }
                }
            }
            $file->write();
        }
        return;
    }

    /*
     * Check if image exists via header, i.e it wont download the file
     */
    public function checkRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(curl_exec($ch)!==FALSE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /*
     * Default collection i.e 20 rows, no offset
     */
    public function getCollection()
    {
        $process = curl_init($this->apiURL());
        curl_setopt($process, CURLOPT_USERPWD, $this->apiUserName . ":" . $this->apiUserPass);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($process);

        $collection = json_decode($return);
        return $collection;
    }

    /*
     * Generate a collection from query input
     */
    public function dynamicCollection($query)
    {
        $process = curl_init($query);
        curl_setopt($process, CURLOPT_USERPWD, $this->apiUserName . ":" . $this->apiUserPass);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($process);

        $collection = json_decode($return);
        return $collection;
    }

    /*
     * Dynamic query which will add the offset vale
     */
    public function dynaQuery($count)
    {
        $addOffset = $count * 20;
        $rawQuery = $this->apiURL();
        $query = $rawQuery .= '&offset=' . $addOffset;
        return $query;
    }

    public function run($request)
    {
        $this->apiURL();
        $collection = $this->getCollection();
        $offset = $this->getOffsetPages($collection);

        echo '<h1>' . $offset . '</h1>';

        for ($i = 0; $i <= $offset; $i++) {
            $query = $this->dynaQuery($i);
            $c = $this->dynamicCollection($query);
            $this->StoreEvents($c);
        }
        echo '<h1 style="color:green;">Events all stored/updated'.'</h1>';
    }

    /**
     *  Lists all of the locations/Regions in NZ | 15 in total on 30th Jan 2017
     *  http://api.eventfinda.co.nz/v2/locations.xml?rows=1&levels=2&fields=location:(id,url_slug,name,children)
     *
     * Northland = 1
     * Auckland = 2
     * The Coromandel = 41
     * [Hawke's Bay / Gisborne] = 6
     * Waikato = 3
     * Bay of Plenty = 4
     * Taranaki = 7
     * Manawatu / Whanganui = 9
     * Wellington Region = 11
     * Nelson / Tasman = 12
     * Marlborough = 13
     * West Coast = 14
     * Canterbury = 15
     * Otago = 17
     * Southland = 18
     *
     */

    /**
     * This below one will give us the children for the regions
     * http://api.eventfinda.co.nz/v2/locations.xml?rows=1&levels=3&fields=location:(id,url_slug,name,children)
     */

    /**
     * This guy is pulling 20 events from the Otago region with dunedin as its child which has id of 126
     * http://api.eventfinda.co.nz/v2/events.xml?rows=20&session:(timezone,datetime_start)&q=concert&order=popularity&location=126
     */


}