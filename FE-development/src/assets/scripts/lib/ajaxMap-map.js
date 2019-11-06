import $ from 'jquery';

import ajaxMap from './ajaxMap'

import mapHelpers from './map-helpers'

const _map = {

    getMapData: (mapEntry) => {
        const data = {
            'id': ajaxMap.configData.mapSettings.pageId,
            'api': "map",
            'action': 'buildMap',
            'mapId': mapEntry.id
        };

        return new Promise(function(resolve, reject) {
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: ajaxMap.ajaxServerPath,
                data,
                success: resolve,
                error: reject
            })
        })
    },

    build(mapEntry) {
        const
            settings = mapEntry.settings;

        return new Promise(function(resolve, reject) {
            _map.getMapData(mapEntry)
            .then((response) => {

                const $el = $('#ajaxMapContainer_Map' + mapEntry.id);

                const googleMap = mapHelpers.createGooglMap(response, $el);

                const infoWindow = mapHelpers.getInfoWindow();
                const markerClusterer = mapHelpers.getMarkerClusterer(googleMap, mapEntry.markerClusterer);
                const regions = response.regions || [];
                const staticLayers = response.staticLayers || [];
                const key = settings.googleApiKey;

                Object.assign(mapEntry, {
                    googleMap,
                    regions,
                    staticLayers,
                    markerClusterer,
                    infoWindow,
                    key
                });

                resolve(response)

            }, reject);
        });
    },
    panTo: (mapId) => {
        "use strict";
        //) console.log(mapCenter, '*****************')//http://jsfiddle.net/fqt7L/1/
    },
};

export default {build: _map.build};
