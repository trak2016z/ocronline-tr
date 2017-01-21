const webpack = require('webpack');
const path = require('path');
const autoprefixer = require('autoprefixer');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    context: __dirname + '/frontend/js',
    entry: [
        'jquery',
        'tether',
        'font-awesome-webpack',
        'bootstrap-loader',
        
        __dirname + '/frontend/js/app.js',

    ],
    output: {
        path: __dirname + '/web/assets/',
        publicPath: '/assets/',
        filename: '[name].min.js',
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoErrorsPlugin(),
        new ExtractTextPlugin('bundle.css'),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery",
            "window.Tether": "tether",
            Tooltip: "exports?Tooltip!bootstrap/js/dist/tooltip",
            Alert: "exports?Alert!bootstrap/js/dist/alert",
            Button: "exports?Button!bootstrap/js/dist/button",
            Carousel: "exports?Carousel!bootstrap/js/dist/carousel",
            Collapse: "exports?Collapse!bootstrap/js/dist/collapse",
            Dropdown: "exports?Dropdown!bootstrap/js/dist/dropdown",
            Modal: "exports?Modal!bootstrap/js/dist/modal",
            Popover: "exports?Popover!bootstrap/js/dist/popover",
            Scrollspy: "exports?Scrollspy!bootstrap/js/dist/scrollspy",
            Tab: "exports?Tab!bootstrap/js/dist/tab",
            Tooltip: "exports?Tooltip!bootstrap/js/dist/tooltip",
            Util: "exports?Util!bootstrap/js/dist/util",
        }),
    ],
    module: {
        loaders: [
            { test: /\.css$/, loaders: ['style', 'css', 'postcss'] },
            { test: /\.scss$/, loaders: ['style', 'css', 'postcss', 'sass'] },
            {
                test: /\.woff2?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                loader: "url-loader?limit=10000"
            },
            {
                test: /\.(ttf|eot|svg)(\?[\s\S]+)?$/,
                loader: 'file-loader'
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader"
            }

            // Use one of these to serve jQuery for Bootstrap scripts:

            // Bootstrap 4
            //{ test: /bootstrap\/dist\/js\/umd\//, loader: 'imports?jQuery=jquery' },

        ],
    },

    postcss: [autoprefixer],
};