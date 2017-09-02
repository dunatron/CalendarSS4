/* jshint node: true */
'use strict';

var gulp = require('gulp'),
  webpack = require('webpack'),
  webpackStream = require('webpack-stream'),
  config = require('./webpack.config');

gulp.task('default', function () {
  return gulp.src('src/app.js')
        .pipe(webpackStream(config, webpack))
        .pipe(gulp.dest('dist/'));
});
