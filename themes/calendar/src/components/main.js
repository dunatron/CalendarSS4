/* jshint node: true */
/* jslint browser: true*/
/* global $, jQuery, happLoader*/
import axios from 'axios';

var codropsEvents = {
  '2017-08-28': '<a @click="getEventData" href="http://tympanus.net/codrops/2012/11/23/three-script-updates/">Three Script Updates</a>',
  '11-21-2017': '<a href="http://tympanus.net/codrops/2012/11/21/adaptive-thumbnail-pile-effect-with-automatic-grouping/">Adaptive Thumbnail Pile Effect with Automatic Grouping</a>',
};

$(function () {
  var cal = $('#calendar').calendario({
      onDayClick($el, $contentEl, dateProperties) {
        for (var key in dateProperties) {
          console.log(key + ' = ' + dateProperties[key]);
        }
      },

      // caldata: initialData,
    }),
    $month = $('#custom-month').html(cal.getMonthName()),
    $year = $('#custom-year').html(cal.getYear());

  function getEvents() {
    axios.post('/calendarfunction/getEventsByDate', {
      data: {
        month: cal.getMonthName(),
        year: cal.getYear(),
      },
    })
            .then(response => {
                // JSON responses are automatically parsed.
              let TheEvents = response.data;
              console.log(TheEvents);
              cal.setData(TheEvents);
            })
            .catch(function (error) {
              alert(error);
            });
      // EventClickListner();
  }

  // function getEventData() {
  //   axios.post('/calendarfunction/getEventData', {
  //     data: {
  //       month: cal.getMonthName(),
  //       year: cal.getYear(),
  //     },
  //   })
  //           .then(response => {
  //               // JSON responses are automatically parsed.
  //             let TheEvents = response.data;
  //             console.log(TheEvents);
  //             cal.setData(TheEvents);
  //           })
  //           .catch(function (error) {
  //             alert(error);
  //           });
  // }

  $('#custom-next').on('click', function () {
    cal.gotoNextMonth(updateMonthYear);
    console.log('wtf is going on here mate');
      // probs have to wait
    getEvents();
  });
  $('#custom-prev').on('click', function () {
    cal.gotoPreviousMonth(updateMonthYear);
    // cal.setData(codropsEvents);
      // probs have to wait
    getEvents();
      // EventClickListner();
  });
  $('#custom-current').on('click', function () {
    cal.gotoNow(updateMonthYear);
    // probs have to wait
    getEvents();
  });

  function updateMonthYear() {
    $month.html(cal.getMonthName());
    $year.html(cal.getYear());
  }


  // getEvents();

  let initialData = getEvents();


  cal.setData(initialData);


    /**
     * Event Stuff
     */

    // function EventClickListner()
    // {
    //     $('.Event').on('click', function() {
    //         console.log('event has been clicked');
    //         let EventID = $(this).attr('data-EID');
    //         console.log(EventID);
    //     });
    // }
    //
    // EventClickListner();



    // you can also add more data later on. As an example:
    /*
     someElement.on( 'click', function() {

     cal.setData( {
     '03-01-2013' : '<a href="#">testing</a>',
     '03-10-2013' : '<a href="#">testing</a>',
     '03-12-2013' : '<a href="#">testing</a>'
     } );
     // goes to a specific month/year
     cal.goto( 3, 2013, updateMonthYear );

     } );
     */
});
