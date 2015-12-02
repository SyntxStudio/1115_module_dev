/**
 * Created by Petar on 26.11.2015.
 */
(function () {
    'use strict';
    // first setter
angular
    .module('myApp', [])
    .controller('someController', function(){
        this.flag = true;
        this.text = '';
    });

})();
