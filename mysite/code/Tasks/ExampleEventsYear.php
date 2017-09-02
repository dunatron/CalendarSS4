<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/12/16
 * Time: 1:20 PM
 */

use SilverStripe\Dev\BuildTask;

class ExampleEventsYear extends BuildTask
{
    protected $title = 'Example Events Year Populate';

    protected $description = 'Task to populate the current Year with 1200 example events';

    public function run($request)
    {
        for($i = 0; $i <= 1200; $i++)
        {
            $e = new Event();
            $e->EventTitle = $this->generateRandomString();
            $e->EventDate = $this->RandomDate();
            $e->EventApproved = 1;
            $e->write();
            echo('<div>===============================</div>');
            echo('<div>Title:'.$e->EventTitle .'</div>');
            echo('<div>Date:'.$e->EventDate.'</div>');
            echo('<div>Approved:'.$e->EventApproved.'</div>');
        }
    }

    /**
     * Generate a random Date
     */
    public function RandomDate()
    {
        // random year
        $year= mt_rand(1000, date("Y"));
        // Today's year
        $currYear = date('Y');
        // random month
        $month= mt_rand(1, 12);
        // today's month
        $currMonth = date('M');
        // Random Day
        $day= mt_rand(1, 28);

        $randomDate = $currYear . "-" . $month . "-" . $day;

        return $randomDate;
    }

    /**
     * Generate random string
     */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}