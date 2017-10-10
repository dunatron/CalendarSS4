<?php

use SilverStripe\View\Requirements;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\Form;
use SilverStripe\Control\Session;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Upload;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Email\Email;


class PageController extends ContentController
{

    private static $casting = [
        'SvgHtml' => 'HTMLText'
    ];

    /**
     * An array of actions that can be accessed via a request. Each array element should be an action name, and the
     * permissions or conditions required to allow the user to access it.
     *
     * <code>
     * array (
     *     'action', // anyone can access this action
     *     'action' => true, // same as above
     *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
     *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
     * );
     * </code>
     *
     * @var array
     */
    private static $allowed_actions = array(
        'HappSearchForm',
        'searchHappEvents',
        'HappEventForm',
        'processHappEvent',
        'storeNewEvents',
        'getHappSecondaryTags',
        'UploadFormImages',
        'getTicketOptionTemplate',
        'storeEvent',
        'getMainCategoryOptions'
    );

    public function doInit()
    {
        //parent::init();
        parent::doInit();
        Requirements::clear();

        $themeFolder = $this->ThemeDir();
        Requirements::set_write_js_to_body(false);

        //Requirements::combine_files('scripts.js', $JSFiles);
        Requirements::javascript($themeFolder . '/dist/vendor.bundle.js');
        Requirements::javascript($themeFolder . '/dist/bootstrap.bundle.js');
        Requirements::javascript('https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit');
        Requirements::javascript($themeFolder . '/dist/app.bundle.js');

    }

    public function ThemeDir()
    {
        return ThemeResourceLoader::inst()->getPath('calendar');
    }

    public function storeEvent(HTTPRequest $request)
    {
        $vars = $request->getBody();
        $data = json_decode($vars);

        // Send email to client & user
        $this->SendNewEventEmail('no-reply@server.com', 'test@test.com', 'test', $data);

        // Create New Event here and then return a response to react and axios
        return json_encode([
            'Success'   =>  true,
            'ServerMessage' =>  'My Test Title will be dynamic',
            'EmailTo'   =>  $data->email
        ]);
    }

    public function SendNewEventEmail($from, $to, $subject, $data)
    {
        // Only send email if 'EnquiryFormEmail' has been set in the CMS.
        if (isset($from) && !empty($from)) {

            $eventData = $this->setNewEventData($data);

            // create new email object
            $email = new Email();
            $email
                ->setHTMLTemplate('NewEventEmailTemplate')
                ->setData($eventData)
                ->setFrom($from)
                ->setTo($to)
                ->setSubject($subject);
            // send email
            $email->send();
        }

    }


    public function setNewEventData($data)
    {
        $templateArr = [];

        foreach($data as $key => $value)
        {
            $templateArr[$key] = $value;
        }

        return $templateArr;
    }

    public function getMainCategoryOptions()
    {
        $tags = HappTag::get();
        $optionsArr = [];

        foreach ($tags as $t)
        {
            $option = new stdClass();
            $option->value=$t->ID;
            $option->label=$t->Title;
            array_push($optionsArr, $option);
        }

        return json_encode($optionsArr);
    }

    public function processHappEvent($data, $form)
    {

        $tagIDS = [];
        $tags = $data['EventTags'];

        foreach ($tags as $key => $value) {
            array_push($tagIDS, $value);
        }
        $tagsAsString = implode(",", $tagIDS);

        $pageID = Session::get('CALID');
        $event = new Event();

        $event->update($data);
        $event->EventTags = $tagsAsString;
        $event->CalendarPageID = $pageID;
        $event->write();

        // Using the Form instance you can get / set status such as error messages.
        $form->sessionMessage("Successful!", 'good');

        // After dealing with the data you can redirect the user back.
        return $this->redirectBack();
    }

    public function storeNewEvents(HTTPRequest $request)
    {
        //error_log(var_export('Event Submitted to server', true));
        $vars = $request->getBody();
        $decode = json_decode($vars);

        $d = $decode->Data;
        error_log(var_export($d, true));

        // Image IDS
        $filesIdArr = array();

        // Title
        if (isset($d->Title)) {
            $submittedTitle = $d->Title;
        }

        // Description
        if (isset($d->Description)) {
            $submittedDescription = $d->Description;
        }

        if (isset($d->SecondaryTag)) {
            $submittedSecondaryTagID = $d->SecondaryTag;
        }

        // Address Data
        if (isset($d->placeData)) {
            if (isset($d->placeData->formatted_address)) {
                $submittedLocationText = $d->placeData->formatted_address;
            }
            if (isset($d->placeData->geometry->location))
            {
                $submittedLatitude = $d->placeData->geometry->location->lat;
                $submittedLongitude = $d->placeData->geometry->location->lng;
            }
        }


        // Restriction
        if (isset($d->Restriction)) {
            $submittedRestriction = $d->Restriction;
        }

        // IsFree
        if (isset($d->HasTickets)) {
            if($d->HasTickets === 'yes') {
                $isEventFree = false;
            } elseif ($d->HasTickets === 'no') {
                $isEventFree = true;
            }
        }

        // BookingWebsite
        if (isset($d->BookingWebsite)) {
            $submittedBookingWebsite = $d->BookingWebsite;
        }

        // SpecLocation
        if (isset($d->specLocation)) {
            $submittedSpecialLocation = $d->specLocation;
        }

        // SpecEntry
        if (isset($d->specEntry)) {
            $submittedSpecialEntry = $d->specEntry;
        }


        // Extract files Id's from their arrays
        foreach ($d->files as $F)
        {
            // Loop the arrays even thought its only one array,
            // we need Just the ID from this
            foreach ($F as $k=>$v)
            {
                //error_log('THE Value');
                //error_log(var_export($v, true));
                array_push($filesIdArr, $v);
            }
        }

        // Create a new Event for each date object in Dates
        foreach ($d->Dates as $date) {

            $new = Event::create();

            // EventTitle
            if (isset($submittedTitle)) {
                $new->EventTitle = $submittedTitle;
            }

            // EventDescription
            if (isset($submittedDescription)) {
                $new->EventDescription = $submittedDescription;
            }

            // SecondaryTag
            if (isset($submittedSecondaryTagID)) {
                $new->SecondaryTagID = $submittedSecondaryTagID;
            }

            // LocationText
            if (isset($submittedLocationText)) {
                $new->LocationText = $submittedLocationText;
            }

            // LocationLat
            if (isset($submittedLatitude)) {
                $new->LocationLat = $submittedLatitude;
            }

            // LocationLon
            if (isset($submittedLongitude)) {
                $new->LocationLon = $submittedLongitude;
            }


            // EventDate
            if (isset($date->DateObject->EventDate)) {
                $rawDate = $date->DateObject->EventDate;

                $d = new DBDate($rawDate);

                // Output the microseconds.
                $d->format('y-m-d'); // 012345

                $new->EventDate = $d->name;
            }

            // StartTime
            if (isset($date->DateObject->StartTime)) {
                $new->StartTime = $date->DateObject->StartTime;
            }

            // FinishTime
            if (isset($date->DateObject->EndTime)) {
                $new->FinishTime = $date->DateObject->EndTime;
            }

            // Restriction
            if (isset($submittedRestriction)) {
                $new->Restriction = $submittedRestriction;
            }

            // IsFree
            if (isset($isEventFree)) {
                $new->IsFree = $isEventFree;
            }

            // BookingWebsite
            if (isset($submittedBookingWebsite)) {
                $new->BookingWebsite = $submittedBookingWebsite;
            }

            // SpecialLocation
            if (isset($submittedSpecialLocation)) {
                $new->SpecialLocation = $submittedSpecialLocation;
            }

            // SpecialEntry
            if (isset($submittedSpecialEntry)) {
                $new->SpecialEntry = $submittedSpecialEntry;
            }


            $new->write();

            // Assign The submitted images to each Event create from Dates
            if (!empty($filesIdArr))
            {
                error_log('THE ARRAY');
                error_log(var_export($filesIdArr, true));
                foreach ($filesIdArr as $FID)
                {
                    $newEventImage = Image::get()->byID($FID);

                    $newEventImage->write();

                    $new->EventImages()->add($newEventImage);

                    // Approve
                    $new->EventApproved = true;

                    $new->write();
                }
            }

        }




        die('DOING STUFF');
    }

    public function UploadFormImages(HTTPRequest $request)
    {
        $files = $request->postVars();

        //error_log(var_export($request, true));
        //error_log(var_export($files, true));
        // TMP STORAGE.

        // Hold all the images, Generate some sort of unique session.

        // When form submits check to see if we have any images waiting in here. If we do take them and store them in the right place & folder
        $Year = date('Y');
        $Month = date('M');

        // Find or Make the Folder Year
        $yearFolder = Folder::find_or_make('Uploads/' . $Year);

        $makeDirectory = 'Uploads/' . $Year . '/' . $Month;

        $folderPath = Folder::find_or_make($makeDirectory);

        $uploadedImageIDS = array();

        foreach ($files as $file) {
            $upload = Upload::create();
//            $image = new Image();
            $image = Image::create();
            $image->ShowInSearch = 0;
            //$fileSelfie->setFilename()
            $upload->loadIntoFile($file, $image, $makeDirectory);

            //error_log(var_export($image->ID, true));

            array_push($uploadedImageIDS, $image->ID);

        }

        return json_encode($uploadedImageIDS);
    }

    public function HappSearchForm()
    {
        $searchField = TextField::create('keyword', 'Keyword search')->setAttribute('placeholder', 'Key-word search...');

        $collapseAdvancedToggle = LiteralField::create('AdvancedToggle', '<button data-toggle="collapse" data-target="#advancedSearch" id="advancedToggle">Advanced Search</button>');
        $advancedStart = LiteralField::create('advancedStart', '<div id="advancedSearch" class="collapse">');

        $pastOrFuture = OptionsetField::create('PastOrFuture', 'Select Past or Future filter', array(
            "1" => "Past",
            "2" => "Future",
            "3" => "ALL"
        ), $value = 2);

        $prioritiseTextOrDate = OptionsetField::create('DateOrText', 'prioritise keyword or closest date', array(
            "1" => DBDate::class,
            "2" => "Keyword"
        ), $value = 2);

        $advancedEnd = LiteralField::create('advancedEnd', '</div>');
        $fields = FieldList::create(
            $searchField,
            $collapseAdvancedToggle,
            $advancedStart,
            $pastOrFuture,
            $prioritiseTextOrDate,
            $advancedEnd
        );
        $actions = FieldList::create(
            FormAction::create('searchHappEvents', 'Search')->addExtraClass('happ_btn')->setAttribute('id', 'falseSearchHappEvents')
        );

        $form = Form::create($this, 'HappSearchForm', $fields, $actions)->addExtraClass('happ-search-form');
        return $form;
    }

    /**
     * Do Happ search based on keyword, and advanced options
     * {Keyword, PastFuture, DateOrText}
     */
    public function searchHappEvents($data, $form = '')
    {
        //https://github.com/silverstripe/silverstripe-fulltextsearch/blob/master/docs/en/Solr.md
        $Search = '';
        $PastFutureQuery = 'EventDate:LessThan';
        $PastFutureDate = date('Y-m-d', strtotime(date('Y-m-d') . " -1 day"));

        if (isset($data['Keyword'])) {
            $Search = $data['Keyword'];
        }
        /**
         * For excluding events based on advanced search results
         */
        if (isset($data['PastFuture'])) {
            $yesterday = date('Y-m-d', strtotime(date('Y-m-d') . " -1 day"));
            $today = date('Y-m-d', strtotime(date('Y-m-d')));
            // exclude past events
            if ($data['PastFuture'] == 2) {
                $PastFutureQuery = 'EventDate:LessThan';
                $PastFutureDate = $yesterday;
            } // exclude events greater than today
            elseif ($data['PastFuture'] == 1) {
                $PastFutureQuery = 'EventDate:GreaterThan';
                $PastFutureDate = $today;
            } elseif ($data['PastFuture'] == 3) {
                $PastFutureQuery = 'EventTitle';
                $PastFutureDate = 'Pornography';
            }
        }

        /**
         * Search Index
         */
        $index = new HappIndex();
        $query = new SearchQuery();
        $query->inClass('Event');

        $query->search($Search);

        $params = array(
            'hl' => 'true'
        );
        $results = $index->search($query, -1, 20, $params); // third param is the amount of results in one go -1 not working. I think 9000 is a good base ;) ;) ;)

        $results->spellcheck;

        $ResultsList = ArrayList::create();
        $resultsIDArr = array();
        foreach ($results->Matches as $r) {
            {
                $ResultsList->add($r);
                array_push($resultsIDArr, $r->ID);
            }
        }

        $finalResults = '';
        /**
         * Determine what results set to use
         */
        if (isset($data['DateOrText'])) {
            // prioritise closest dates at the top
            if ($data['DateOrText'] == 1) {
                $finalResults = $events = Event::get()
                    ->byIDs($resultsIDArr)
                    ->where('EventApproved', 'TRUE')
                    ->exclude(array(
                        $PastFutureQuery => $PastFutureDate
                    ))
                    ->sort('ABS(UNIX_TIMESTAMP() - UNIX_TIMESTAMP(EventDate))');
            } // prioritise keyword at the top
            elseif ($data['DateOrText'] == 2) {
                $finalResults = $events = Event::get()
                    ->byIDs($resultsIDArr)
                    ->where('EventApproved', 'TRUE')
                    ->exclude(array(
                        $PastFutureQuery => $PastFutureDate
                    ));
            }
        }

        // If results list is empty, try a partial match
        if (empty($finalResults)) {
            if ($data['DateOrText'] == 1) {
                $finalResults = Event::get()
                    ->where('EventApproved', 'TRUE')
                    ->filter(array(
                        'EventTitle:PartialMatch' => $Search,
                        'EventDescription:PartialMatch' => $Search,
                    ))
                    ->limit(20)
                    ->exclude(array(
                        $PastFutureQuery => $PastFutureDate
                    ))
                    ->sort('ABS(UNIX_TIMESTAMP() - UNIX_TIMESTAMP(EventDate))');
            } elseif ($data['DateOrText'] == 2) {
                $finalResults = Event::get()
                    ->where('EventApproved', 'TRUE')
                    ->exclude(array(
                        $PastFutureQuery => $PastFutureDate
                    ))
                    ->limit(20)
                    ->filter(array(
                        'EventTitle:PartialMatch' => $Search,
                        'EventDescription:PartialMatch' => $Search,
                    ));
            }
        }

        $searchData = ArrayData::create(array(
            'Results' => $finalResults,
            'KeyWord' => $data['Keyword'],
        ));

        return $this->owner->customise($searchData)->renderWith('Search_Results');
    }

    public function getHappTags()
    {
        $tagArr = array();
        $Tags = HappTag::get();

        foreach ($Tags as $tag) {
            $tagArr[$tag->ID] = $tag->Title;
        }

//        $trimArr = array();
//
//        /**
//         *  Remove white spaces from the end of string for each value & key in array
//         */
//        array_walk($regionArr, function (&$key,$value) use (&$trimArr){
//            $trimArr[rtrim($key)] = rtrim($value);
//        });
//
//        /**
//         * Remove duplicates from array()
//         */
//        $uniqueArr = array_unique($trimArr);

        return $tagArr;
    }

    public function allHappTags()
    {
        return HappTag::get();
    }

    public function allSecondaryTags()
    {
        return SecondaryTag::get();
    }


    public function getSecondaryTags()
    {
        $tagArr = array();
        $Tags = SecondaryTag::get();

        foreach ($Tags as $tag) {
            $tagArr[$tag->ID] = $tag->Title;
        }

        return $tagArr;
    }

    public function getHappSecondaryTags(HTTPRequest $request)
    {
        $requestVars = $request->postVars();

        $HappTagID = $requestVars['HappTagID'];

        $Tags = SecondaryTag::get()->filter(array(
            'HappTagID' => $HappTagID
        ));

        $tagArr = array();
        foreach ($Tags as $t) {
            $tagArr[$t->ID] = $t->Title;
        }

        return json_encode($tagArr);

        return $tagArr;
    }

    public function getTicketOptionTemplate(HTTPRequest $req)
    {

        $vars = $req->getBody();
        $decode = json_decode($vars);

        error_log(var_export($decode, true));


        //echo $data->renderWith('AjaxFunds');
        return $this->renderWith('TicketOptions');
        //return $this->owner->customise($data)->renderWith('Page_results');
    }



    public function getCalendarSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/calendar.svg');
    }

    public function getAddEventSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/add_event_icon_1.svg');
    }

    public function getFilterSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/filter_icon_1.svg');
    }

    public function getLoopSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/loop.svg');
    }

    public function getSearchSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/search_icon.svg');
    }

    public function getCloseSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/search_icon.svg');
    }

}
