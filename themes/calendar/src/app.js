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
// REACT
import React from 'react';
import ReactDOM from 'react-dom';
import AddEventForm from './components/forms/AddEventForm';
// import Multistep from 'react-multistep';
//
// import { steps } from './components/addform/index';

// const steps = [
//     {name: 'StepOne', component: <StepOne>},
//     {name: 'StepTwo', component: <StepTwo>},
//     {name: 'StepThree', component: <StepThree>},
//     {name: 'StepFour', component: <StepFour>},
// ];
// class App extends React.Component {
//   render() {
//     return (
//             <div className="container">
//             <div>
//             <Multistep initialStep={1} steps={steps} />
//             </div>
//             <div className="container app-footer">
//             <h6>Press 'Enter' or click on progress bar for next step.</h6>
//         Code is on <a href="https://github.com/Srdjan/react-multistep" target="_blank">github</a>
//             </div>
//             </div>
//     );
//   }
// }

$(document).ready(function () {
  var baseCal = require('./components/jquery.calendario');
  var mainCal = require('./components/main');
  require('./components/modal/modal');
  HappLogoAnimation();
  // ReactDOM.render(<AddEventForm title="Add Event"/>, document.getElementById('ReactAddEventForm'));
    // ReactDOM.render(<Multistep showNavigation={true} steps={steps} />, document.getElementById('ReactAddEventForm'));

  ReactDOM.render(<AddEventForm />, document.getElementById('ReactAddEventForm'));
});
