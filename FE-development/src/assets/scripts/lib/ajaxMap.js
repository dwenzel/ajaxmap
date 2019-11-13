const ajaxProxyPort = require('../../../../_config-proxy-port.json').ajaxProxyPort;

import map  from './ajaxMap-map'

import mapLayers  from './map-layers'
import regions from './ajaxMap-regions'
import places from './ajaxMap-places'
import autoSuggest from './map-auto-suggest'
import locationTypes from './ajaxMap-locationTypes'
import fancyTreeRenderer from './fancytree-renderer'

import {inserScriptTag} from './utilitys'
import ui from '../lib/ajaxMap-ui';

let ajaxMap;
class AjaxMap {
    constructor(mapEntry) {
        this.mapEntry = mapEntry;

        mapEntry.instance = this;
        mapEntry.layers = [];//88 maybe whle init?
        this.$mapEl = null;
    }
}

const _ = {
    initMap: (mapEntry, locationTypesResonse) => {

        locationTypes.init(mapEntry, locationTypesResonse);

        mapLayers.buildStatic(mapEntry);

        regions.init(mapEntry)

        places.init(mapEntry)

        autoSuggest(mapEntry);
        //radialSearch.init(mapEntry);

        fancyTreeRenderer.category(mapEntry);
        fancyTreeRenderer.placeGroup(mapEntry);
    },
    initAllMaps: () => {
        return new Promise(function(resolve, reject) {
            const mapStore = ajaxMap.configData.mapStore;

            ajaxMap.maps = mapStore.map((mapEntry) => {
                const ajaxMapInstance = new AjaxMap(mapEntry);

                map.build(mapEntry).then((response) => {

                    _.initMap(mapEntry)
                });

                ajaxMap.lookUp[mapEntry.id] = ajaxMapInstance;
                return ajaxMapInstance;
            });
        })
    }
};

ajaxMap = {//    TODO:
    //set public methods and vars.
    //eg:config data :settings.placeTree.renderItemFunction
    basePath: '',
    lookUp: {},//object of instances
    maps: [],//array of ajax-map object

    ///////////
    ajaxServerPath: //replace #### dont delete this! its for the build process
    'http://localhost:' + ajaxProxyPort,
    //end-replace //#### dont delete this! its for the build process
    //////////

    configData: null,
    init: function(configData) {
        const url = 'https://maps.googleapis.com/maps/api/js?key=' +
            configData.mapSettings.keys.googleMap + '&libraries=places';

        ajaxMap.configData = configData;

        inserScriptTag(url).then(() => {
            ajaxMap.configData = configData;

            _.initAllMaps();

            ui.init();
        }, console.error)
    }
};

export
default
ajaxMap;
