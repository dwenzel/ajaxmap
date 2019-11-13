import $ from 'jquery';

import ajaxMap from './ajaxMap'

import mapHelpers from './map-helpers'

const _map = {
    containerSelector: '#ajaxMapContainer_Map',

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
    mapToDefaultSettings: (mapEntry, response) => {

        const $el = $(_map.containerSelector + mapEntry.id),
            googleMap = mapHelpers.createGooglMap(response, $el);

        const infoWindow = mapHelpers.getInfoWindow();
        const markerClusterer = mapHelpers.getMarkerClusterer(googleMap, mapEntry.markerClusterer);

        const regions = response.regions || [];
        const staticLayers = response.staticLayers || [];
        const locationTypes = response.locationTypes || [];

        Object.assign(mapEntry, response, {
            googleMap,
            regions,
            staticLayers,
            markerClusterer,
            infoWindow,
            locationTypes
        });
    },
    build(mapEntry) {
        const settings = mapEntry.settings;

        return new Promise(function(resolve, reject) {
            _map.getMapData(mapEntry)
            .then((response) => {
                _map.mapToDefaultSettings(mapEntry, response)

                return resolve(response)
            }, reject);
        });
    }
};

export default {build: _map.build};
