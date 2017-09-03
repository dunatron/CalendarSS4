/**
 * Created by heathdunlop on 3/09/17.
 */
/**
 * Created by Heath on 16/02/17.
 */
/**
 * Created by admin on 8/02/17.
 */
export default function HappLogoAnimation() {
  var drawHapp = SVG('happSVGLogo').size('100%', '100%').attr({ position: 'relative', fill: 'none', stroke: '#231f20', 'stroke-width': '3px' });


  var happBox = drawHapp.viewbox(0, 0, 784, 228);

  var orangeBox_Timeout = 750;
  var H_timeout = 250;
  var Let_ani_speed = 0.5;
  var orange_box_ani_speed = 1;

// White Box
// var whiteBox = drawHapp.path('M391.262,195.586c0,17.498-14.188,31.683-31.683,31.683H32.433c-17.498,0-31.686-14.185-31.686-31.683V31.89c0-17.501,14.188-31.684,31.686-31.684h327.146c17.495,0,31.683,14.183,31.683,31.684V195.586L391.262,195.586z')
//     .attr({
//         class:'whiteBox',
//         stroke:'#FFF',
//         fill:'#FFF'
//     })
//     .attr({'stroke-miterlimit':10});
// letW
  var letW = drawHapp.path('M121.717,104.229l-19.015,46.589c-2.58,6.246-7.606,6.653-10.05,6.653c-3.668,0-8.014-1.9-9.643-5.841l-10.322-25.535L62.229,151.63c-1.495,3.668-5.026,5.841-8.692,5.841c-2.444,0-8.421-0.407-11.001-6.653L23.52,104.229c-2.309-5.566,0.409-11.679,5.841-13.987c5.568-2.31,11.814,0.271,13.988,5.839l10.594,25.941l9.915-24.178c1.495-3.667,5.026-5.839,8.83-5.839c3.667,0,7.198,2.173,8.692,5.839l9.915,24.178l10.593-25.941c2.173-5.568,8.557-8.148,13.99-5.839C121.309,92.549,124.026,98.662,121.717,104.229z')
        .attr({
          class: 'letW',
          stroke: '#FFFFFF',
          fill: '#FFFFFF',
          'stroke-miterlimit': 10,
        });
// letH
  var letH = drawHapp.path('M190.302,118.897v27.708c0,5.976-4.889,10.864-10.866,10.864c-5.975,0-10.864-4.89-10.864-10.864v-27.708c0-4.617-3.802-8.422-8.42-8.422c-4.481,0-8.285,3.805-8.285,8.422v27.708c0,5.976-4.889,10.864-10.866,10.864c-6.111,0-11.001-4.89-11.001-10.864V78.015c0-6.11,4.89-11.001,11.001-11.001c5.977,0,10.866,4.891,10.866,11.001v11.816c2.717-0.68,5.433-1.086,8.285-1.086C176.855,88.746,190.302,102.191,190.302,118.897z')
        .attr({
          class: 'letH',
          stroke: '#FFFFFF',
          fill: '#FFFFFF',
          'stroke-miterlimit': 10,
        });
// letA
  var letA = drawHapp.path('M265.954,99.747v47.538c0,5.567-4.617,10.187-10.188,10.187c-2.986,0-5.703-1.358-7.605-3.261c-5.16,2.717-10.729,4.346-16.977,4.346c-19.15,0-34.77-15.617-34.77-34.77c0-19.149,15.619-34.771,34.77-34.771c5.976,0,11.543,1.632,16.705,4.348c1.902-2.444,4.618-3.802,7.877-3.802C261.336,89.561,265.954,94.178,265.954,99.747z M244.358,123.786c0-7.333-5.842-13.174-13.175-13.174c-7.334,0-13.174,5.841-13.174,13.174c0,7.335,5.84,13.175,13.174,13.175C238.517,136.961,244.358,131.121,244.358,123.786z')
        .attr({
          class: 'letA',
          stroke: '#FFFFFF',
          fill: '#FFFFFF',
          'stroke-miterlimit': 10,
        });
// letT
  var letT = drawHapp.path('M317.154,146.605c0,5.976-4.89,10.864-10.865,10.864h-2.038c-16.027,0-27.435-12.632-27.435-28.386V78.83c0-5.975,4.889-10.865,10.865-10.865c5.978,0,10.865,4.891,10.865,10.865V89.56h9.915c5.297,0,9.508,4.21,9.508,9.509c0,5.16-4.21,9.37-9.508,9.37h-9.915v20.646c0,3.395,1.766,6.655,5.704,6.655h2.038C312.265,135.74,317.154,140.629,317.154,146.605z')
        .attr({
          class: 'letT',
          stroke: '#FFFFFF',
          fill: '#FFFFFF',
          'stroke-miterlimit': 10,
        });
// letS
  var letS = drawHapp.path('M350.7,107.49c-2.58-0.815-6.384-1.767-7.062,1.221c-0.68,2.717,4.211,4.075,6.247,4.483c4.075,0.814,8.015,3.124,10.866,6.247c6.248,6.52,7.607,16.842,4.075,24.991c-3.667,8.421-12.087,13.445-21.051,13.988c-5.026,0.271-15.483-1.086-19.693-6.655c-5.297-7.062-0.136-16.979,8.419-16.568c3.397,0.136,7.063,2.717,9.917,2.853c4.889,0.407,5.975-5.569,1.357-6.79c-8.558-2.582-14.806-5.978-18.742-13.855c-2.854-5.976-2.173-13.445,1.899-18.878c6.521-8.828,18.881-11.816,29.066-7.877c5.433,2.173,9.914,7.74,6.519,13.717C360.072,108.439,355.861,109.254,350.7,107.49z')
        .attr({
          class: 'letS',
          stroke: '#FFFFFF',
          fill: '#FFFFFF',
          'stroke-miterlimit': 10,
        });
// Orange Box
  var orangeBox = drawHapp.path('M783.253,195.586c0,17.498-14.187,31.683-31.683,31.683H424.424c-17.498,0-31.685-14.185-31.685-31.683V31.89c0-17.501,14.187-31.684,31.685-31.684H751.57c17.496,0,31.683,14.183,31.683,31.684V195.586z')
        .attr({
          class: 'orangeBox',
          stroke: '#FF6633',
          fill: '#FF6633',
        })
        .attr({ 'stroke-miterlimit': 10 });
// letH2
  var letH2 = drawHapp.path('M494.826,67.694v79.047c0,5.84-4.889,10.729-10.729,10.729c-5.976,0-10.729-4.89-10.729-10.729v-30.018H444.03v30.018c0,5.84-4.752,10.729-10.729,10.729c-5.839,0-10.728-4.89-10.728-10.729V67.694c0-5.841,4.889-10.73,10.728-10.73c5.979,0,10.729,4.89,10.729,10.73v30.015h29.338V67.694c0-5.841,4.754-10.73,10.729-10.73C489.938,56.964,494.826,61.854,494.826,67.694z')
        .attr({
          class: 'letH2',
          stroke: '#FFFFFF',
          fill: '#FFFFFF',
          'stroke-miterlimit': 10,
        });
// letA2
  var letA2 = drawHapp.path('M573.872,99.747v47.538c0,5.567-4.619,10.187-10.188,10.187c-2.986,0-5.703-1.358-7.605-3.261c-5.159,2.717-10.729,4.346-16.977,4.346c-19.15,0-34.771-15.617-34.771-34.77c0-19.149,15.619-34.771,34.771-34.771c5.976,0,11.543,1.632,16.705,4.348c1.901-2.444,4.617-3.802,7.877-3.802C569.253,89.561,573.872,94.178,573.872,99.747zM552.276,123.786c0-7.333-5.841-13.174-13.175-13.174c-7.335,0-13.175,5.841-13.175,13.174c0,7.335,5.84,13.175,13.175,13.175C546.438,136.961,552.276,131.121,552.276,123.786z')
        .attr({
          class: 'letA2',
          fill: '#FFFFFF',
          stroke: '#FFF',
        });
// letP
  var letP = drawHapp.path('M619.504,158.014c-4.618,0-9.1-0.95-13.175-2.58v12.631c0,5.84-4.754,10.729-10.729,10.729h-0.95c-5.434-0.271-9.914-4.754-9.914-10.322V99.747c0-5.568,4.616-10.187,10.186-10.187c3.124,0,5.705,1.223,7.605,3.26c5.025-2.715,10.866-4.347,16.979-4.347c19.15,0,34.771,15.618,34.771,34.771S638.654,158.014,619.504,158.014z M619.504,110.07c-7.335,0-13.175,5.839-13.175,13.174c0,7.334,5.84,13.174,13.175,13.174c7.334,0,13.174-5.84,13.174-13.174C632.678,115.909,626.838,110.07,619.504,110.07z')
        .attr({
          class: 'letP',
          fill: '#FFFFFF',
          stroke: '#FFF',
        });
// letP2
  var letP2 = drawHapp.path('M696.512,158.014c-4.617,0-9.1-0.95-13.175-2.58v12.631c0,5.84-4.754,10.729-10.729,10.729h-0.951c-5.433-0.271-9.914-4.754-9.914-10.322V99.747c0-5.568,4.617-10.187,10.186-10.187c3.124,0,5.705,1.223,7.605,3.26c5.026-2.715,10.866-4.347,16.979-4.347c19.15,0,34.771,15.618,34.771,34.771S715.662,158.014,696.512,158.014z M696.512,110.07c-7.335,0-13.175,5.839-13.175,13.174c0,7.334,5.84,13.174,13.175,13.174c7.334,0,13.174-5.84,13.174-13.174C709.686,115.909,703.846,110.07,696.512,110.07z')
        .attr({
          class: 'letP2',
          fill: '#FFFFFF',
          stroke: '#FFF',
        });

// letA2

// HAPP config
  var orangeBoxPath = document.querySelector('.orangeBox');// orangeBox conf
  var orangeBoxLength = orangeBox.length();
// H2
  var letH2Path = document.querySelector('.letH2');// letH conf
  var letH2Length = letH2.length();
// A2
  var letA2Path = document.querySelector('.letA2');// letH conf
  var letA2Length = letH2.length();
// P
  var letPPath = document.querySelector('.letP');// letH conf
  var letPLength = letP2.length();
// P2
  var letP2Path = document.querySelector('.letP2');// letH conf
  var letP2Length = letP2.length();

// WHATS config
  var letWPath = document.querySelector('.letW');// letW conf
  var letWLength = letW.length();
// H
  var letHPath = document.querySelector('.letH');// letH conf
  var letHLength = letH.length();
// A
  var letAPath = document.querySelector('.letA');// letH conf
  var letALength = letA.length();
// T
  var letTPath = document.querySelector('.letT');// letH conf
  var letTLength = letT.length();
// S
  var letSPath = document.querySelector('.letS');// letH conf
  var letSLength = letS.length();

  setupOrangeBox();
// WHATS setup
  setupLetW();
  setupLetH();
  setupLetA();
  setupLetT();
  setupLetS();
// HAPP setup
  setupLetH2();
  setupLetA2();
  setupLetP();
  setupLetP2();

    /**
     * Setup Letter Start points | WHATS
     */
  function setupLetW() {
        // Clear H & setup start
    letWPath.style.transition = letWPath.style.WebkitTransition = 'none';
    letWPath.style.strokeDasharray = letWLength + ' ' + letWLength;
    letWPath.style.strokeDashoffset = letWLength;
    letWPath.style.fill = 'none';
  }
  function setupLetH() {
        // Clear H & setup start
    letHPath.style.transition = letHPath.style.WebkitTransition = 'none';
    letHPath.style.strokeDasharray = letHLength + ' ' + letHLength;
    letHPath.style.strokeDashoffset = letHLength;
    letHPath.style.fill = 'none';
  }
  function setupLetA() {
        // Clear H & setup start
    letAPath.style.transition = letAPath.style.WebkitTransition = 'none';
    letAPath.style.strokeDasharray = letALength + ' ' + letALength;
    letAPath.style.strokeDashoffset = letALength;
    letAPath.style.fill = 'none';
  }
  function setupLetT() {
        // Clear H & setup start
    letTPath.style.transition = letTPath.style.WebkitTransition = 'none';
    letTPath.style.strokeDasharray = letTLength + ' ' + letTLength;
    letTPath.style.strokeDashoffset = letTLength;
    letTPath.style.fill = 'none';
  }
  function setupLetS() {
        // Clear H & setup start
    letSPath.style.transition = letSPath.style.WebkitTransition = 'none';
    letSPath.style.strokeDasharray = letSLength + ' ' + letSLength;
    letSPath.style.strokeDashoffset = letSLength;
    letSPath.style.fill = 'none';
  }

    /**
     * Setup Letter Start points | HAPP
     */
  function setupOrangeBox() {
        // Clear J & setup start
    orangeBoxPath.style.transition = orangeBoxPath.style.WebkitTransition = 'none';
    orangeBoxPath.style.strokeDasharray = orangeBoxLength + ' ' + orangeBoxLength;
    orangeBoxPath.style.strokeDashoffset = orangeBoxLength;
    orangeBoxPath.style.fill = 'none';
  }

  function setupLetH2() {
        // Clear H & setup start
    letH2Path.style.transition = letH2Path.style.WebkitTransition = 'none';
    letH2Path.style.strokeDasharray = letH2Length + ' ' + letH2Length;
    letH2Path.style.strokeDashoffset = letH2Length;
    letH2Path.style.fill = 'none';
  }
  function setupLetA2() {
        // Clear H & setup start
    letA2Path.style.transition = letA2Path.style.WebkitTransition = 'none';
    letA2Path.style.strokeDasharray = letA2Length + ' ' + letA2Length;
    letA2Path.style.strokeDashoffset = letA2Length;
    letA2Path.style.fill = 'none';
  }
  function setupLetP() {
        // Clear H & setup start
    letPPath.style.transition = letPPath.style.WebkitTransition = 'none';
    letPPath.style.strokeDasharray = letPLength + ' ' + letPLength;
    letPPath.style.strokeDashoffset = letPLength;
    letPPath.style.fill = 'none';
  }
  function setupLetP2() {
        // Clear H & setup start
    letP2Path.style.transition = letP2Path.style.WebkitTransition = 'none';
    letP2Path.style.strokeDasharray = letP2Length + ' ' + letP2Length;
    letP2Path.style.strokeDashoffset = letP2Length;
    letP2Path.style.fill = 'none';
  }


    /**
     * animate draw letters | WHATS
     */
  function animateLetW(callback) {
        // picks up the starting position before animating
    letWPath.getBoundingClientRect();
        // Define our transition
    letWPath.style.transition = letWPath.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letWPath.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }
  function animateLetH(callback) {
        // picks up the starting position before animating
    letHPath.getBoundingClientRect();
        // Define our transition
    letHPath.style.transition = letHPath.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letHPath.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }
  function animateLetA(callback) {
        // picks up the starting position before animating
    letAPath.getBoundingClientRect();
        // Define our transition
    letAPath.style.transition = letAPath.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letAPath.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }
  function animateLetT(callback) {
        // picks up the starting position before animating
    letTPath.getBoundingClientRect();
        // Define our transition
    letTPath.style.transition = letTPath.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letTPath.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }
  function animateLetS(callback) {
        // picks up the starting position before animating
    letSPath.getBoundingClientRect();
        // Define our transition
    letSPath.style.transition = letSPath.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letSPath.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }


    /**
     * animate draw letters | HAPP
     */
  function animateOrangeBox(callback) {
        // picks up the starting position before animating
    orangeBoxPath.getBoundingClientRect();
        // Define our transition
    orangeBoxPath.style.transition = orangeBoxPath.style.WebkitTransition =
            'stroke-dashoffset ' + orange_box_ani_speed + 's ease-out';
        // Go!
    orangeBoxPath.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, orangeBox_Timeout);
  }

  function animateLetH2(callback) {
        // picks up the starting position before animating
    letH2Path.getBoundingClientRect();
        // Define our transition
    letH2Path.style.transition = letH2Path.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letH2Path.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }

  function animateLetA2(callback) {
        // picks up the starting position before animating
    letA2Path.getBoundingClientRect();
        // Define our transition
    letA2Path.style.transition = letA2Path.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letA2Path.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }
  function animateLetP(callback) {
        // picks up the starting position before animating
    letPPath.getBoundingClientRect();
        // Define our transition
    letPPath.style.transition = letPPath.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letPPath.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }
  function animateLetP2(callback) {
        // picks up the starting position before animating
    letP2Path.getBoundingClientRect();
        // Define our transition
    letP2Path.style.transition = letP2Path.style.WebkitTransition =
            'stroke-dashoffset ' + Let_ani_speed + 's ease-out';
        // Go!
    letP2Path.style.strokeDashoffset = '0';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }

  animateLetW;
  animateLetH;
  animateLetA;
  animateLetT;
  animateLetS;

  animateOrangeBox;

  animateLetH2;
  animateLetA2;
  animateLetP;
  animateLetP2;

  animateLetW(function () {
    animateLetH(function () {
      animateLetA(function () {
        animateLetT(function () {
          animateLetS(function () {
            animateOrangeBox(function () {
              animateLetH2(function () {
                animateLetA2(function () {
                  animateLetP(function () {
                    animateLetP2(function () {
                        fillColor(function () {
                            if ($(window).width() < 880) {
                                if ($('.current-day').length) {
                                    animateToDay('.current-day');
                                  }
                              }
                          });
                      });
                  });
                });
              });
            });
          });
        });
      });
    });
  });


  function fillColor(callback) {
    orangeBoxPath.style.fill = 'FF6633';

        // WHATS
    letWPath.style.fill = '#FFF';

    letHPath.style.fill = '#FFF';
    letAPath.style.fill = '#FFF';
    letTPath.style.fill = '#FFF';
    letSPath.style.fill = '#FFF';
        // HAPP
    letH2Path.style.fill = '#FFF';
    letA2Path.style.fill = '#FFF';
    letPPath.style.fill = '#FFF';
    letP2Path.style.fill = '#FFF';
        // letP2Path.style.css ({'fill': '#FF6633', 'transition': 'fill 1s'});
        // remove stroke
    letWPath.style.stroke = 'none';
    letHPath.style.stroke = 'none';
    letAPath.style.stroke = 'none';
    letTPath.style.stroke = 'none';
    letSPath.style.stroke = 'none';
    letH2Path.style.stroke = 'none';
    letA2Path.style.stroke = 'none';
    letPPath.style.stroke = 'none';
    letP2Path.style.stroke = 'none';

    setTimeout(function () {
      callback();
    }, H_timeout);
  }

  function animateToDay(menuItem) {
    var NavbarHeight = 20;
    $('html, body').animate({
      scrollTop: $(menuItem).offset().top - NavbarHeight,
    }, 2000);
  }


    /**
     * Calculate polygon lengths
     * @param el
     * @returns {number}
     */
  function getPolygonLength(el) {
    var points = el.attr('points');
    points = points.split(' ');
    var x1 = null, x2, y1 = null, y2, lineLength = 0, x3, y3;
    for (var i = 0; i < points.length; i++) {
      var coords = points[i].split(',');
      if (x1 == null && y1 == null) {
        if (/(\r\n|\n|\r)/gm.test(coords[0])) {
          coords[0] = coords[0].replace(/(\r\n|\n|\r)/gm, '');
          coords[0] = coords[0].replace(/\s+/g, '');
        }

        if (/(\r\n|\n|\r)/gm.test(coords[1])) {
          coords[0] = coords[1].replace(/(\r\n|\n|\r)/gm, '');
          coords[0] = coords[1].replace(/\s+/g, '');
        }

        x1 = coords[0];
        y1 = coords[1];
        x3 = coords[0];
        y3 = coords[1];
      } else {
        if (coords[0] != '' && coords[1] != '') {
          if (/(\r\n|\n|\r)/gm.test(coords[0])) {
            coords[0] = coords[0].replace(/(\r\n|\n|\r)/gm, '');
            coords[0] = coords[0].replace(/\s+/g, '');
          }

          if (/(\r\n|\n|\r)/gm.test(coords[1])) {
            coords[0] = coords[1].replace(/(\r\n|\n|\r)/gm, '');
            coords[0] = coords[1].replace(/\s+/g, '');
          }

          x2 = coords[0];
          y2 = coords[1];

          lineLength += Math.sqrt(Math.pow((x2 - x1), 2) + Math.pow((y2 - y1), 2));

          x1 = x2;
          y1 = y2;
          if (i == points.length - 2) {
            lineLength += Math.sqrt(Math.pow((x3 - x1), 2) + Math.pow((y3 - y1), 2));
          }
        }
      }
    }
    return lineLength;
  }

    /**
     * calculate rect length
     * @param el
     * @returns {number}
     */
  function getRectLength(el) {
    var w = el.attr('width');
    var h = el.attr('height');

    return (w * 2) + (h * 2);
  }
}
