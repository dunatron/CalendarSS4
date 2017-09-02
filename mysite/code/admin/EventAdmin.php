<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/12/16
 * Time: 2:11 PM
 */

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldDataColumns;


class EventAdmin extends ModelAdmin
{
    /**
     * @var array
     */
    private static $managed_models = array('Event');

    /**
     * @var string
     */
    private static $url_segment = "calendar-events";

    /**
     * @var string
     */
    private static $menu_title = "Events";

//    public function getList()
//    {
//        $list = parent::getList();
////        if($this->modelClass == 'Event'){
////            $list = $list->exclude('EventApproved', 1);
////        }
//        return $list;
//    }
//
//    public function getIsApproved()
//    {
//        $check = '';
//        if($this->EventApproved == 1){
//            $check = 'Yes';
//        }else {
//            $check = 'No';
//        }
//        return $check;
//    }
//
//    /**
//     * @param null $id
//     * @param null $fields
//     * @return \Form
//     */
//    public function getEditForm($id = null, $fields = null)
//    {
//        $form = parent::getEditForm($id, $fields);
//
//        $gridField = $form->Fields()
//            ->fieldByName($this->sanitiseClassName($this->modelClass));
//
//        $config = $gridField->getConfig();
//
//        $config->getComponentByType(GridFieldPaginator::class)->setItemsPerPage(20);
//        $config->getComponentByType(GridFieldDataColumns::class)
//            ->setDisplayFields(array(
//                'EventTitle'  => 'EventTitle',
//                'EventVenue'    =>  'EventVenue',
//                'LocationText' => 'LocationText',
//                'EventDate' => 'EventDate',
//                'IsApproved' => 'EventApproved'
//            ));
//
//        return $form;
//    }


}