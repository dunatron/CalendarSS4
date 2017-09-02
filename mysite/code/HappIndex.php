<?php

//class HappIndex extends SolrIndex {
//    function init()
//    {
//        //https://github.com/silverstripe/silverstripe-fulltextsearch/blob/master/docs/en/Solr.md
//        $this->addClass('Event');
//        $this->addAllFulltextFields();
//        $this->addStoredField('EventTitle');
//        $this->addStoredField('LocationText');
//        $this->addStoredField('EventDescription');
//
//        $this->addBoostedField('EventTitle', null, array(), 3);
//        $this->addBoostedField('LocationText', null, array(), 2);
//        $this->addBoostedField('EventDescription', null, array(), 1.5);
//		//$this->setFieldBoosting('Event_SearchBoost', 2);
//
//    }
//}