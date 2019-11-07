import $ from 'jquery';
import ajaxMap from './lib/ajaxMap';

import '../../../dist/css/main.css'
import {css} from 'jquery.fancytree/dist/skin-awesome/ui.fancytree.min.css';

$(document).ready(function() {

    if (!mapStore || !(mapStore instanceof Array)) {
        console.log(' no mapstore', mapStore)
        return;
    }

    const configData = {
        mapSettings: window.mapSettings,
        mapStore: window.mapStore
    }

    ajaxMap.init(configData);//initialize all maps
})



