/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/global.scss');
//require ('bootstrap');


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
 var $ = require('jquery');
//global.$ = global.jQuery = $
console.log('Hello coco Webpack Encore! Edit me in assets/js/app.js');
var greet = require('./greet');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');
/*
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
*/
$(document).ready(function() {
    $('body').prepend('<h1>'+greet('jill')+'</h1>');
});
