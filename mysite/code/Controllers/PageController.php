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
        'getTicketOptionTemplate'
    );

    public function doInit()
    {
        //parent::init();
        parent::doInit();
        Requirements::clear();

        $themeFolder = $this->ThemeDir();

        // Set the folder to our theme so that relative image paths work
        //Requirements::set_combined_files_folder($themeFolder . '/combinedfiles');

        $JSFiles = array(
            //$themeFolder . '/dist/bootstrap.bundle.js',
            $themeFolder . '/dist/app.bundle.js'
        );

//        $CSSFiles = array(
//            //$themeFolder . '/css/base-styles.css',
//            $themeFolder . '/css/Calendar-Core.css',
//            $themeFolder . '/css/homepage.css',
//            $themeFolder . '/css/main.css'
//        );

        // Combine css files
        //Requirements::combine_files('styles.css', $CSSFiles);

        //Requirements::combine_files('scripts.js', $JSFiles);
        Requirements::javascript($themeFolder . '/dist/vendor.bundle.js');
        Requirements::javascript('https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit');
        Requirements::javascript($themeFolder . '/dist/app.bundle.js');

    }

    public function ThemeDir()
    {
        return ThemeResourceLoader::inst()->getPath('calendar');
    }

    public function HappEventForm()
    {
        /**
         * NOTE: The ->setRightTitle is being used in a custom form template and by Vue.
         * It is using it to match the Vue Title and to check for validation.
         */
        //-----> Start Step One
        $stepOneStart = LiteralField::create('StepOneStart', '<div id="StepOne" class="form-step">');

        $bootstrapDate = LiteralField::create('BootstrapDatePicker', '<div class="Bootstrap__DatePicker"></div>');
        $calendarOptions = LiteralField::create('CalendarOptions', '<div class="Calendar__Options">
<span id="CalendarSingle" class="Higlight__Option">Single</span>
<!--<span id="CalendarReccuring">Recurring</span>-->
<span id="CalendarMultiDay">Multi Day</span></div> ');
        $date = DateField::create('EventDate', 'Date of the event');
        $startTime = TextField::create('StartTime', 'Event start time');
        $finishTime = TextField::create('FinishTime', 'Event finish time');
        $generateDates = LiteralField::create('GenerateDates', '<div class="clearfix"></div><div @click="generateDates" class="Generate__Dates"><p class="generate_date_text">Generate Dates</p></div>');

        $generatedDates = LiteralField::create('GeneratedDates', '<ul class="Event__Dates">
    <li class="Date__Object" v-for="Date in Dates">
        <span class="Date">{{ Date.DateObject.EventDate }}</span>
        <input type="time" class="Generated__Time" v-bind:value="Date.DateObject.StartTime" v-model="Date.DateObject.StartTime">
        <input type="time" class="Generated__Time" v-bind:value="Date.DateObject.EndTime" v-model="Date.DateObject.EndTime">
    </li>
</ul>');

        $StepOneNext = LiteralField::create('StepOneNext', '<div v-show="Dates[0]" class="add-event-controls"><div @click="stepOneForwardProgress" id="StepOneNext" class="add-event-next"><span>next</span></div></div>');

        $stepOneEnd = LiteralField::create('StepOneEnd', '</div>');
        //-----> End Step One


        //-----> Start Step Two
        $stepTwoStart = LiteralField::create('StepTwoStart', '<div id="StepTwo" class="form-step field-hidden clearfix">');

        $stepTwoWrapStart = LiteralField::create('','<div class="step-content-wrap clearfix">');
        $stepTwoLeft = CompositeField::create(
        // Title
            $Title = TextField::create('Title', 'What is the name of your event?')
                ->setAttribute('required', true)
                ->setAttribute('v-model', 'Title')
                ->setAttribute('v-validate.initial', '{ rules: "required|min:5|max:80", arg: "Title", scope: "validateAddEvent" }')
//            ->setAttribute('data-vv-rules', 'required|min:5|max:80')
                ->setRightTitle('Title')
                ->setAttribute('placeholder', 'e.g. Dunedin comedy night'),

            // Description
            $Description = TextareaField::create('Description', 'Write a brief description of your event')
                ->setAttribute('required', true)
                ->setAttribute('v-model', 'Description')
                ->setAttribute('v-validate.initial', '{ rules: "required|min:5|max:500", arg: "Description", scope: "validateAddEvent" }')
//            ->setAttribute('data-vv-rules', 'required|min:10')
                ->setRightTitle('Description')
                ->setAttribute('placeholder','e.g A night of local dunedin comedians, A collection of the best from around Dunedin coming together for one night only come on down for a night of fun filled laughter at the Fortune Theatre'),

            $MainTag = DropdownField::create('HappTag', 'Choose Main Tag',
                $this->getHappTags())
                ->addExtraClass('search')
                ->setAttribute('data-style', 'btn-primary')
                ->setAttribute('title', 'Choose a primary tag')
                ->setAttribute('v-model', 'HappTag'),

            $SecondaryTag = DropdownField::create('SecondaryTag', 'Choose Secondary Tag',
                $this->getSecondaryTags())
                ->addExtraClass('search')
                ->setAttribute('data-style', 'btn-primary')
                ->setAttribute('title', 'Choose a secondary tag')
                ->setAttribute('disabled', 'disabled')
                ->setAttribute('v-model', 'SecondaryTag')
        )->addExtraClass('Left');

        $stepTwoRight = CompositeField::create(
        // Vue Clip : https://www.youtube.com/watch?v=84_SwbPWjKo
        // https://www.npmjs.com/package/vue-clip
        // https://npm.runkit.com/vue-clip
            $vueClip = LiteralField::create('VueClip', '<vue-clip :options="options" :on-added-file="fileAdded" :on-complete="complete">
<template slot="clip-uploader-action" scope="props">
<div class="uploader-action" v-bind:class="{dragging: props.dragging}">
<div class="dz-message">
Drop and drag files here or click to browse
</template>
<template slot="clip-uploader-body" scope="props">
<div class="uploader-files">
<div class="uploader-file" v-for="file in props.files">
<div class="file-avatar">
<img v-bind:src="file.dataUrl" alt="" class="img-responsive">
</div>
<div class="file-details">
<div class="file-name">
    {{ file.name }}
</div>
<div class="file-progress" v-if="file.status !== \'error\' && file.status !== \'success\' ">
<span class="progress-indicator" v-bind:style="{width: file.progress}"></span>
</div>
<div class="file-meta">
<span class="file-size">{{ file.size }}</span>
<span class="file-status">{{ file.status }}</span>
<span class="file-status">{{ file.errorMessage }}</span>
</div>
</div>

</div>
</div>
</template>
</vue-clip>')
        )->addExtraClass('Right');

        $stepTwoWrapEnd = LiteralField::create('','</div>');

        $StepTwoBack = LiteralField::create('StepTwoBack', '<div class="add-event-controls"><div @click="stepTwoBackProgress" id="StepTwoBack" class="add-event-back"><span>back</span></div>');
        $StepTwoNext = LiteralField::create('StepTwoNext', '<div @click="stepTwoForwardProgress"
            v-show="fields.$validateAddEvent && fields.$validateAddEvent.Title.dirty && fields.$validateAddEvent.Description.dirty && !errors.has(\'validateAddEvent.Title\') && !errors.has(\'validateAddEvent.Description\') "
            id="StepTwoNext" class="add-event-next"><span>next</span></div></div>');


        $stepTwoEnd = LiteralField::create('StepTwoEnd', '</div>');
        //-----> End Step Two


        //-----> Start Step Three

        $stepThreeStart = LiteralField::create('StepThreeStart', '<div id="StepThree" class="form-step field-hidden">');
        $stepThreeWrapStart = LiteralField::create('','<div class="step-content-wrap clearfix">');
        $stepThreeLeft = CompositeField::create(
            $venueName = TextField::create('EventVenue', 'What is the name of the venue?'),

            $vueGoogleMap = LiteralField::create('VueMap', '
<label for="map" class="left">What is the street address/location</label>
 <vue-google-autocomplete
                    id="map"
                    Type="establishment"
                    classname="vue-autocomplete"
                    placeholder="231 Stuart Street, Dunedin, New Zealand"
                    v-on:placechanged="getAddressData"
                    country="NZ" 
                    style="width: 100%"
                >
                </vue-google-autocomplete>'),

            //$mapData = LiteralField::create('MapData', '<h1 v-text="address"></h1>');
            $map = LiteralField::create('googleMap', '<div v-show="address.latitude" id="addEventMap" style="width: 100%; height: 400px;"></div>')
        )->addExtraClass('Left');
        $stepThreeRight = CompositeField::create(
//            TextField::create('SpecialLocationInstructions')
            LiteralField::create('', '<button id="spec-location-btn" class="spec__btn">Add...</button><p style="text-align: center;">(special location instructions)</p>'),
            CompositeField::create(
                LiteralField::create('', $this->getCloseSVG()),
                TextField::create('SpecialLocationInstructions')
                    ->setAttribute('v-model', 'specLocation')
            )->addExtraClass('special-location-wrapper')->addExtraClass('special-close')
        )->addExtraClass('Right');


        $stepThreeWrapEnd = LiteralField::create('','</div>');

        $StepThreeBack = LiteralField::create('StepThreeBack', '<div class="add-event-controls"><div @click="stepThreeBackProgress" id="StepThreeBack" class="add-event-back"><span>back</span></div>');
        $StepThreeNext = LiteralField::create('StepThreeNext', '<div @click="stepThreeForwardProgress" id="StepThreeNext" class="add-event-next"><span>next</span></div></div>');

        $stepThreeEnd = LiteralField::create('StepThreeEnd', '</div>');
        //-----> End Step Three


        //-----> Start Step Four

        $stepFourStart = LiteralField::create('StepFourStart', '<div id="StepFour" class="form-step field-hidden">');
        $stepFourWrapStart = LiteralField::create('','<div class="step-content-wrap clearfix">');
        $stepFourLeft = CompositeField::create(
        // Restriction
            $restrictions = DropdownField::create('Restriction',
                'Restrictions for event',
                EventRestriction::get()->map('ID', 'Description')->toArray(),
                null,
                true
            )
                ->setAttribute('v-model', 'Restriction')
                ->setAttribute('v-validate.initial', '{ rules: "required", arg: "Restriction", scope: "validate-add-event" }')
//            ->setAttribute('data-vv-rules', 'required')
                ->setRightTitle('Restriction')
                ->setAttribute('title', 'Select entry restriction...')
                ->addExtraClass('search'),

            $hasTicketHeader = HeaderField::create('Does your event have tickets?', 'ummm'),

            $ticketOptions = LiteralField::create('', '<div class="notsopretty success">
  <input type="radio" value="yes" v-model="HasTickets"> 
  <label class="ticket__check"><i class="default"></i> Yes</label>
</div>
<div class="notsopretty success">
  <input type="radio" value="no" v-model="HasTickets"> 
  <label class="ticket__check"><i class="default"></i> No</label>
</div>
'),

            TextField::create('BookingWebsite', 'BookingWebsite')
                ->setAttribute('placeholder', 'Copy and paste the direct URL to purchase tickets')
                ->setAttribute('v-show', 'HasTickets === "yes"')
                ->setAttribute('v-model', 'BookingWebsite')

        )->addExtraClass('Left');
        $stepFourRight = CompositeField::create(
            LiteralField::create('', '<button id="spec-entry-btn" class="spec__btn">Add...</button><p style="text-align: center;">(special entry instructions)</p>'),
            CompositeField::create(
                LiteralField::create('', $this->getCloseSVG()),
                TextField::create('SpecialEntryInstructions')
                    ->setAttribute('v-model', 'specEntry')
            )->addExtraClass('special-entry-wrapper')->addExtraClass('special-close')

        )->addExtraClass('Right');


        $stepFourWrapEnd = LiteralField::create('','</div>');

        $StepFourBack = LiteralField::create('StepFourBack', '<div class="add-event-controls"><div @click="stepFourBackProgress" id="StepFourBack" class="add-event-back"><span>back</span></div>');
        $StepFourNext = LiteralField::create('StepFourNext', '<div @click="stepFourForwardProgress" id="StepFourNext" class="add-event-next"><span>next</span></div></div>');

        $stepFourEnd = LiteralField::create('StepFourEnd', '</div>');
        //-----> End Step Four


        $ticket = CheckboxField::create('HasTickets', 'Check if event has tickets')
            ->setAttribute('id', 'hasTickets')
            ->setAttribute('v-model', 'HasTickets');

        $detailsNext = LiteralField::create('detailsNextBtn', '<div @click="detailsForwardProgress" v-show="!errors.has(\'validate-add-event.Title\') && !errors.has(\'validate-add-event.Description\') " class="add-event-controls"><div id="detailsNextBtn" class="add-event-next"><span>next</span></div></div>');


        //--> Ticket Step
        $ticketStart = LiteralField::create('TicketStart', '<div id="ticket-step" class="form-step field-hidden">');

        //$restrictionError = LiteralField::create('restrictionError', '<p class="text-danger" v-if="errors.has(\'Restriction\')">{{ errors.first(\'Restriction\') }}</p>');

        $acc = new AccessTypeArray();
        $acc->getAccessValues();
        $ticketBack = LiteralField::create('ticketBackBtn', '<div class="add-event-controls"> <div id="ticketBackBtn"  @click="ticketBackProgress" class="add-event-back"><span>back</span></div>');
        $ticketNext = LiteralField::create('ticketNextBtn', '<div v-show="!errors.has(\'validate-add-event.Restriction\')" id="ticketNextBtn" @click="ticketForwardProgress" class="add-event-next"><span>next</span></div></div>');

        $access = $acc->getAccessValues();
        $ticketEnd = LiteralField::create('TicketEnd', '</div>');

        //--> Ticket Website (Option 5 is selected for radio option field)
        $ticWebStart = LiteralField::create('TicWebStart', '<div id="ticket-web-step" class="form-step field-hidden">');
        $website = TextField::create('TicketWebsite', 'Ticket website');
        $phone = TextField::create('TicketPhone', 'Ticket provider phone number');
        $ticketWebBack = LiteralField::create('ticketWebBack', '<div class="add-event-controls"><div @click="websiteBackProgress" id="ticketWebBack" class="add-event-back"><span>back</span></div>');
        $ticketWebNext = LiteralField::create('ticketWebNext', '<div @click="websiteForwardProgress" id="ticketWebNext" class="add-event-next"><span>next</span></div></div>');
        $ticWebEnd = LiteralField::create('TicWebEnd', '</div>');

        $locationStart = LiteralField::create('LocationStart', '<div id="location-step" class="form-step field-hidden">');
        $locationField = TextField::create('LocationText')->setAttribute('id', 'addEventAddress');
        $locLat = HiddenField::create('LocationLat', 'Location Latitude')->setAttribute('id', 'addEventLat');
        $locLong = HiddenField::create('LocationLon', 'Location Longitude')->setAttribute('id', 'addEventLon');
        $locRadius = HiddenField::create('LocationRadius', 'Radius of the event')->setAttribute('id', 'addEventRadius');


        $locationBack = LiteralField::create('LocationBack', '<div class="add-event-controls"><div @click="locationBackProgress" id="locationBack" class="add-event-back"><span>back</span></div>');
        $locationNext = LiteralField::create('LocationNext', '<div @click="locationForwardProgress" id="locationNext" class="add-event-next"><span>next</span></div></div>');
        $locationEnd = LiteralField::create('LocationEnd', '</div>');

        //--> Date Step
        $dateStart = LiteralField::create('DateStart', '<div id="date-step" class="form-step field-hidden">');

        $dateEnd = LiteralField::create('DateEnd', '</div>');

        //--> Finish Step
        $finishStepStart = LiteralField::create('finishStepStart', '<div id="finish-step" class="form-step field-hidden">');

        $evaluateData = LiteralField::create('EvaluateFormData', '<h1>Hello Tron</h1>');

        $finishBack = LiteralField::create('FinishBack', '<div class="add-event-controls"><div id="finishBack" @click="finishBackProgress" class="add-event-back"><span>back</span></div></div>');

        $finishStepEnd = LiteralField::create('finishStepEnd', '</div>');

        //--> Global elements
        $formProgress = LiteralField::create('formProgress', '<radial-progress-bar :diameter="100"
                       :completed-steps="completedSteps"
                       :total-steps="totalSteps"
                       :animate-speed="animateSpeed"
                       :stroke-width="strokeWidth"
                       :start-color="startColor"
                       :stop-color="stopColor"
                       :inner-stroke-color="innerStrokeColor"
                       >
<p>{{ completedSteps }}/{{ totalSteps }}</p>
<p>Steps</p>
  </radial-progress-bar>');

        $fields = new FieldList(
            $stepOneStart, $bootstrapDate, $calendarOptions, $startTime, $finishTime, $generateDates, $generatedDates, $StepOneNext, $stepOneEnd,
            $stepTwoStart, $stepTwoWrapStart, $stepTwoLeft, $stepTwoRight, $stepTwoWrapEnd, $StepTwoBack, $StepTwoNext, $stepTwoEnd,
            $stepThreeStart, $stepThreeWrapStart, $stepThreeLeft, $stepThreeRight, $stepThreeWrapEnd, $StepThreeBack, $StepThreeNext, $stepThreeEnd,
            $stepFourStart, $stepFourWrapStart, $stepFourLeft, $stepFourRight, $stepFourWrapEnd, $StepFourBack, $StepFourNext, $stepFourEnd
        );


        $actions = new FieldList(
            FormAction::create('processHappEvent', 'Submit')
                ->addExtraClass('field-hidden happ_btn')
                ->setAttribute('id', 'submitHappEvent')
                ->setAttribute('@click.prevent', 'submitNewEvents')
//                ->setAttribute('@click.prevent', 'onSubmit')
                ->setUseButtonTag(true)
                ->setTemplate('RecaptchaSubmit')
        );

        $actions->push(
        //ResetFormAction::create('ClearAction', 'Clear')
            FormAction::create('ClearAction', 'Clear')->setAttribute('type', 'reset')
        );

        $required = RequiredFields::create(array(
            'EventTitle'
        ));

        $form = Form::create($this, 'HappEventForm', $fields, $actions, $required)->addExtraClass('happ-add-event-form');
        $form->setTemplate('AddEventTemplate');
        $form->setAttribute('data-vv-scope', 'validate-add-event')->disableSecurityToken();

        /**
         * Recaptcha Options
         * https://developers.google.com/recaptcha/docs/display#render_param
         */

//        $data = Session::get("FormData.{$form->getName()}.data");

        $data = PageController::curr()->getRequest()->getSession()->get("FormData.{$form->getName()}.data");


        return $data ? $form->loadDataFrom($data) : $form;
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

    public function getSearchSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/menu/search_icon.svg');
    }

    public function getAddEventSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/menu/add_event_icon_1.svg');
    }

    public function getFilterSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/menu/filter_icon_1.svg');
    }

    // SVG
    // Clock SVG
    public function getClockSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/clock.svg');
    }

    // Ticket SVG
    public function getTicketSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/ticket.svg');
    }

    // Restrict SVG
    public function getRestrictSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/restrict.svg');
    }

    // Location SVG
    public function getLocationSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/location.svg');
    }

    // Calendar SVG
    public function getCalendarSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/calendar.svg');
    }

    // Close SVG
    public function getCloseSVG()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('../' . $theme . '/svg/close.svg');
    }

}
