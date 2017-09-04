/* jshint node: true */
// 'use strict';
/* global $, jQuery, happLoader*/


// import 'webpack-jquery-ui';

require('bootstrap-loader');
// require('webpack-jquery-ui');
require('webpack-jquery-ui/css');

require('webpack-jquery-ui/draggable');
require('webpack-jquery-ui/droppable');
require('webpack-jquery-ui/resizable');
require('webpack-jquery-ui/selectable');
require('webpack-jquery-ui/sortable');

const axios = require('axios');
import './sass/app.scss';

// svg.js
import 'svg.js';
import HappLogoAnimation from './components/logo/happ-logo';


// import VueAddEvent from './components/calendar';

$(document).ready(function () {
    var baseCal = require('./components/jquery.calendario');
    var mainCal = require('./components/main');
    require('./components/modal/modal');
    HappLogoAnimation();
});
