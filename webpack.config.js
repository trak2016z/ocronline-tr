const webpack = require('webpack');
const path = require('path');
const autoprefixer = require('autoprefixer');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    context : __dirname + '/frontend/js',
    entry   : [
        'jquery',
        'tether',
        'bootstrap-loader',
        __dirname + '/frontend/js/app.js',

    ],
    output  : {
        path      : __dirname + '/web/assets/',
        publicPath: '/assets/',
        filename  : '[name].min.js',
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoErrorsPlugin(),
        new ExtractTextPlugin( 'bundle.css' ),
        new webpack.ProvidePlugin({
            "window.Tether": "tether"
        }),
    ],
    module: {
        loaders: [
        { test: /\.css$/, loaders: [ 'style', 'css', 'postcss' ] },
        { test: /\.scss$/, loaders: [ 'style', 'css', 'postcss', 'sass' ] },
        {
            test: /\.woff2?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
            loader: "url?limit=10000"
        },
        {
            test: /\.(ttf|eot|svg)(\?[\s\S]+)?$/,
            loader: 'file'
        },

        // Use one of these to serve jQuery for Bootstrap scripts:

        // Bootstrap 4
        { test: /bootstrap\/dist\/js\/umd\//, loader: 'imports?jQuery=jquery' },

        ],
    },

    postcss: [ autoprefixer ],
};