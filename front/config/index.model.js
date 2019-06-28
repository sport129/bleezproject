'use strict'

// see http://vuejs-templates.github.io/webpack for documentation.
const path = require('path')

module.exports = {
  build: {
    env: require('./prod.env'),
    index: path.resolve(__dirname, '../dist/index.html'),
    assetsRoot: path.resolve(__dirname, '../dist'),
    assetsSubDirectory: 'static',
    assetsPublicPath: '/',
    productionSourceMap: true,
    // --
    productionGzip: false,
    productionGzipExtensions: ['js', 'css'],
   
    // --
    bundleAnalyzerReport: process.env.npm_config_report
  },
  dev: {
    env: require('./dev.env'),
    host: '127.0.0.1', // HOST
    port: 9014, // APP PORT
    autoOpenBrowser: true,
    assetsSubDirectory: 'static',
    assetsPublicPath: '/',
    proxyTable: {},
    // --
    cssSourceMap: false
  }
}