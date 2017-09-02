/* jshint node: true */
// 'use strict';


// import 'webpack-jquery-ui';

require('bootstrap-loader');
// require('webpack-jquery-ui');
require('webpack-jquery-ui/css');

require('webpack-jquery-ui/draggable');
require('webpack-jquery-ui/droppable');
require('webpack-jquery-ui/resizable');
require('webpack-jquery-ui/selectable');
require('webpack-jquery-ui/sortable');

var baseCal = require('./components/jquery.calendario');
var mainCal = require('./components/main');
require('./components/modal/modal');

const axios = require('axios');
import './sass/app.scss';

// import VueAddEvent from './components/calendar';
//
// VueAddEvent();

// $(".Event").on("click", function(evt) {
//     console.log("clicked in jQuery")
//     $("#site-wrapper").triggerHandler("customEvent.jq.namespaces")
// })

// DOn't use for es6 silly
// $(document).ready(function () {
//     VueAddEvent();
// });
