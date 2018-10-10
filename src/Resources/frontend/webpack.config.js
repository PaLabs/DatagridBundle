const webpack = require('webpack');
const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('./../public/')
    .setPublicPath('/public')
    .addEntry('app', './src/js/main')
    .addStyleEntry('styles', './src/less/main.less')
    .enableLessLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
   // .enableVersioning()
;

module.exports = Encore.getWebpackConfig();