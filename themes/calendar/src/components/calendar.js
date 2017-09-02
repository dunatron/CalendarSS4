import Vue from '../../node_modules/vue/dist/vue.esm.js';
import axios from 'axios';
/* jslint browser: true*/
/* global $, jQuery, happLoader*/
/* eslint no-alert: "error"*/

Vue.component('event', {

  template: '<li>test component</li>',

});

export default function VueAddEvent() {
  let cal = null;
  let Month = null;
  let Year = null;

  let AddEventForm = new Vue({
    el: '#site-wrapper',
    components: {},
    name: 'Add-Event',
    data: {
      Events: [],
      CurrEvent: {
        Title: '',
        ID: null,
      },
    },

    watch: {
      // a computed getter
      Events() {
        // `this` points to the vm instance
        cal.setData(this.Events);

        $('.Event').on('click', function (evt) {
          let EventID = $(this).attr('data-EID');
          // console.log('party too' + evt.attr('data-EID'));
          console.log('The Events ID ' + EventID);
          // this.getEventData();
          //   this.$emit('getEventData', 'site-wrapper');
        });

        // this.$emit('getEventData', 'site-wrapper');
      },
    },


    beforeMount() {
    },

    mounted() {
      cal = $('#calendar').calendario();
      Month = $('#custom-month').html(cal.getMonthName());
      Year = $('#custom-year').html(cal.getYear());

      this.getEvents();
    },

    methods: {

      getEvents() {
        axios.post('/calendarfunction/getEventsByDate', {
          data: {
            month: cal.getMonthName(),
            year: cal.getYear(),
          },
        })
            .then(response => {
                // JSON responses are automatically parsed.
              this.Events = response.data;
              // cal.setData(this.Events);
            })
            .catch(function (error) {
              alert(error);
            });

        this.$nextTick(function () {
          console.log('next tick exasdf');
          this.thisToo();
        });
      },

      thisToo() {
        $('.Event').on('click', function (evt) {
          let EventID = $(this).attr('data-EID');
          console.log('Next Tick EID' + EventID);
        });
      },

      prevMonth() {
        cal.gotoPreviousMonth(this.updateMonthYear);
        this.getEvents();
      },

      nextMonth() {
        cal.gotoNextMonth(this.updateMonthYear);
        this.getEvents();
      },

      currentMonth() {
        cal.gotoNow(this.updateMonthYear);
        this.getEvents();
      },

      updateMonthYear() {
        Month.html(cal.getMonthName());
        Year.html(cal.getYear());
      },

      getEventData() {
        console.log('trying to get event dta');
      },

    },

  });
}
