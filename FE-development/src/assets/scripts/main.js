import $ from 'jquery';
import ajaxMap from './lib/ajaxMap';

import '../../../dist/css/main.css'

$(document).ready(function() {

    if (!mapStore || !(mapStore instanceof Array)) {
        console.log(' no mapstore', mapStore)
        return;
    }

    const configData = {
        mapSettings: mapSettings.settings,
        mapStore: window.mapStore
    }

    ajaxMap.init(configData);//initialize all maps

});

