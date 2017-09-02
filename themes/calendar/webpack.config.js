/* jshint node: true */

const webpack = require('webpack');
const path = require('path');
const jquery = require('jquery');

const srcPath = path.join(__dirname, '/src/');
const distPath = path.join(__dirname, '/dist/');

// const Vue = require('vue');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

// https://webpack.github.io/docs/code-splitting.html

const isProd = process.env.NODE_ENV === 'production'; // true or false

const bootstrapEntryPoints = require('./webpack.bootstrap.config');

const bootstrapConfig = isProd ? bootstrapEntryPoints.prod : bootstrapEntryPoints.dev;

// Analyze my chunky bits so i can scrub them
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

module.exports = {

  watch: false,
  cache: false, // turn on for prod
  devtool: '#cheap-module-eval-source-map',
  context: srcPath,

  entry: {
    app: './app.js',
    vendor: ['jquery', 'vue'],
    bootstrap: bootstrapConfig,
  },

  output: {
    path: path.resolve(__dirname, './dist'),
    publicPath: '/themes/calendar/dist/',
    filename: '[name].bundle.js',
    library: 'jquery',
  },

  resolve: {
    modules: ['node_modules'],
  },

  plugins: [

        // Doing the more manual approach with entry of vendor. Remember to cashe the vendor output file
    new webpack.ProvidePlugin({
      // $: 'jquery',
      // jQuery: 'jquery',
        $: "jquery",
        jQuery: "jquery",
        "window.jQuery": "jquery'",
        "window.$": "jquery"
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor',
      filename: 'vendor.bundle.js',
      minChunks: 2,
    }),

    new webpack.optimize.ModuleConcatenationPlugin(),

    new BundleAnalyzerPlugin({
            // Can be `server`, `static` or `disabled`.
            // In `server` mode analyzer will start HTTP server to show bundle report.
            // In `static` mode single HTML file with bundle report will be generated.
            // In `disabled` mode you can use this plugin to just generate Webpack Stats JSON file by setting `generateStatsFile` to `true`.
      analyzerMode: 'static',
            // Host that will be used in `server` mode to start HTTP server.
      analyzerHost: '127.0.0.1',
            // Port that will be used in `server` mode to start HTTP server.
      analyzerPort: 8888,
            // Path to bundle report file that will be generated in `static` mode.
            // Relative to bundles output directory.
      reportFilename: 'report.html',
            // Module sizes to show in report by default.
            // Should be one of `stat`, `parsed` or `gzip`.
            // See "Definitions" section for more information.
      defaultSizes: 'parsed',
            // Automatically open report in default browser
      openAnalyzer: true,
            // If `true`, Webpack Stats JSON file will be generated in bundles output directory
      generateStatsFile: false,
            // Name of Webpack Stats JSON file that will be generated if `generateStatsFile` is `true`.
            // Relative to bundles output directory.
      statsFilename: 'stats.json',
            // Options for `stats.toJson()` method.
            // For example you can exclude sources of your modules from stats file with `source: false` option.
            // See more options here: https://github.com/webpack/webpack/blob/webpack-1/lib/Stats.js#L21
      statsOptions: null,
            // Log level. Can be 'info', 'warn', 'error' or 'silent'.
      logLevel: 'info',
    }),

  ],


  module: {

    rules: [
      {
        test: /\.js$/,
        exclude: [/node_modules/],
        use: [{
          loader: 'babel-loader',
          options: { presets: ['es2015', 'stage-2'] },
        }],
      },

      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader'], //Loaders are processed in reverse array order. That means css-loader will run before style-loader.
      },
      {
        test: /\.(sass|scss)$/,
        use: [
          'style-loader',
          'css-loader',
          'sass-loader',
        ],
      },
      {
        test: /\.vue$/,
        use: [
          'vue-loader',
        ],
      },

            // Loaders for other file types go here
            { test: /\.(woff|woff2|ttf|eot|svg|gif|png)(\?v=[a-z0-9]\.[a-z0-9]\.[a-z0-9])?$/, loader: 'url-loader?limit=100000&name=fonts/[name].[ext]' },
    ],

    loaders: [
            // Bootstrap 3
            { test: /bootstrap-sass[\/\\]assets[\/\\]javascripts[\/\\]/, loader: 'imports-loader?jQuery=jquery' },

    ],


  },

};
