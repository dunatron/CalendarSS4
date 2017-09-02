<?php
/**
 * Created by PhpStorm.
 * User: heathdunlop
 * Date: 24/08/17
 * Time: 6:36 PM
 */

use SilverStripe\Dev\SapphireTest;
/**
 * Test our property business logic.
 */
class PropertyTest extends SapphireTest
{

    // vendor/bin/phpunit ./mysite/ -d memory_limit=2G
    public function setUp()
    {
        parent::setUp();
    }
    /**
     * Check that we can get Events
     */
    public function testGetEvents()
    {
        // Create a property with an available date.
        $events = Event::get();
        $this->assertTrue($events->count() > 1);
    }



}