let webpack = require("webpack");
var ExtractTextPlugin = require("extract-text-webpack-plugin");
let path = require('path');
let node_modules_dir = path.resolve(__dirname, 'node_modules');

let config = {
    entry: {
        app: "./src/js/main",
        styles: './src/less/main.less'
    },
    output: {
        path: path.join(__dirname, '../public/'),
        filename: "[name].js"
    },
    resolve: {
        modulesDirectories: ['node_modules', './src/js']
    },
    devtool: 'source-map',
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: [node_modules_dir],
                loader: "babel-loader",
                query: {
                    presets: ["es2015"],
                    plugins: ['transform-runtime']
                }
            },
            {
                test: /\.less$/,
                loader: ExtractTextPlugin.extract("style-loader", "css-loader!less-loader")
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin("[name].css")
        // new webpack.optimize.DedupePlugin(),
        // new webpack.optimize.UglifyJsPlugin({
        //     mangle: false,
        //     sourceMap: false
        // })
    ],
    externals: {
        jquery: 'jQuery'
    }
};


module.exports = config;