import $ from 'jquery';
const ajaxProxyPort = require('../../../../package.json').project.ajaxProxyPort;

import map  from './ajaxMap-map'

import mapLayers  from './map-layers'
import regions from './ajaxMap-regions'
import places from './ajaxMap-places'
import locationTypes from './ajaxMap-locationTypes'
import fancyTreeRenderer from './fancytree-renderer'

import {inserScriptTag} from './utilitys'

import ui from '../lib/ajaxMap-ui';

class AjaxMap {
    constructor(mapEntry) {
        this.mapEntry = mapEntry;

        mapEntry.layers = null;
        this.places = null;
        this.$mapEl = null;
    }

    initPlaces() {
        places.init.call(this);
    }

    panTo(lat, long) {

    }
}

let ajaxMap;
const _ = {

    createBasePath: () => {
        const
            basePath =
                window.location.protocol + "//" + window.location.host + "/",
            webkitPath =
                window.location.origin + "/";

        return !window.location.origin ? basePath : webkitPath;
    },
    panTo: (mapId) => {
        "use strict";
        //) console.log(mapCenter, '*****************')//http://jsfiddle.net/fqt7L/1/
    },

    initAllMaps: () => {
        return new Promise(function(resolve, reject) {
            const mapStore = ajaxMap.configData.mapStore;

            ajaxMap.maps = mapStore.map((mapEntry) => {

                const ajaxMapInstance = new AjaxMap(mapEntry);

                map.build(mapEntry).then((response) => {
                    locationTypes.init(ajaxMapInstance, response.locationTypes);

                    mapLayers.buildStatic(mapEntry);

                    regions.build(mapEntry)

                    fancyTreeRenderer.category(mapEntry);
                    fancyTreeRenderer.placeGroup(mapEntry);

                    ajaxMapInstance.initPlaces();
                });



                //same as mapstore!!
                ajaxMap.lookUp[mapEntry.id] = ajaxMapInstance;

                return ajaxMapInstance;
            });

            $('body').append('<div id="overlayDetailHelper">');

        })
    }
};

ajaxMap = {
    lookUp: {},
    maps: [],//array of ajax-map object
    ajaxServerPath: 'http://localhost:' + ajaxProxyPort,//this path will be replaced bei build script: see readme.txt
    configData: null,

    init: function(configData) {
        const url = 'https://maps.googleapis.com/maps/api/js?key=' + configData.mapSettings.keys.googleMap

        inserScriptTag(url).then(() => {
            ajaxMap.configData = configData;

            _.initAllMaps()

           // ui.init();

            //Promise.all(ajaxMap.maps)
        }, console.error)
    }
};
export
default
ajaxMap;
