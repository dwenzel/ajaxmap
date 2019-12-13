import $ from 'jquery';
import ajaxMap from './ajaxMap';
import mapHelpers from './map-helpers';
import {ajaxCall} from './utilitys';

const _map = {
    containerSelector: '#ajaxMapContainer_Map',

    getMapData: (mapEntry) => {
        const data = {
            'id': ajaxMap.configData.mapSettings.pageId,
            'api': 'map',
            'action': 'buildMap',
            'mapId': mapEntry.id
        };

        return ajaxCall(data);
    },
    mapToDefaultSettings: (mapEntry, response) => {

        const $map = $(_map.containerSelector + mapEntry.id),
            googleMap = mapHelpers.createGooglMap(mapEntry,response, $map);

        const $mainWrapper = $map.closest('.am');
        const $sideBar = $mainWrapper.find('.am__sb');

        const infoWindow = mapHelpers.getInfoWindow();
       // const markerClusterer = mapHelpers.getMarkerClusterer(googleMap, mapEntry.markerClusterer);

        const regions = response.regions || [];
        const staticLayers = response.staticLayers || [];
        const locationTypes = response.locationTypes || [];

        return Object.assign({}, mapEntry, response, {
            $mainWrapper,
            $map,
            $sideBar,
            googleMap,
            regions,
            staticLayers,
         //   markerClusterer,
            infoWindow,
            locationTypes
        });
    },
    build(mapEntry) {
        return new Promise(function(resolve, reject) {
            _map.getMapData(mapEntry)
                .then((response) => {

                    return resolve(_map.mapToDefaultSettings(mapEntry, response));
                }, reject);
        });
    }
};

export default {build: _map.build};
