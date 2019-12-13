import '@babel/polyfill';

import $ from 'jquery';
import ajaxMap from './lib/ajaxMap';

import customFunction from './costum-functions';

import '../../../dist/css/main.css';


import 'jquery.fancytree/dist/skin-lion/ui.fancytree.css';


$(document).ready(function() {
    customFunction();

    if (!window.mapStore || !(window.mapStore instanceof Array)) {
        // console.log('no mapstore', window.mapStore);
        return;
    }

    const configData = {
        mapSettings: window.mapSettings,
        mapStore: window.mapStore
    };

    ajaxMap.init(configData); //initialize all maps
});
