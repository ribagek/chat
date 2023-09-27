const mix = require('laravel-mix')
const path = require('path')

require('./nova.mix')

mix
  .setPublicPath('dist')
  .js('resources/js/main.js', 'js/tool.js')
  .css('resources/css/tool.css', 'css')
  .vue({ version: 3 })
  .nova('mdeskorg/chat')
  .alias({
    '@utils': path.join(__dirname, 'resources/js/utils'),
    '@components': path.join(__dirname, 'resources/js/.shared-components'),
    '@icons': path.join(__dirname, 'resources/js/.icons'),
    '@plugins': path.join(__dirname, 'resources/js/.plugins'),
    '@queries': path.join(__dirname, 'resources/js/queries'),
  })
