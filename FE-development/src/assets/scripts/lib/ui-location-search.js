import $ from 'jquery';
import {ajaxCall} from './utilitys'
import ajaxMap from './ajaxMap'
import places from './ajaxMap-places'

const _ = {
    locationInputSelector: '#locationSearch',
    radialSearchSelectSelector: '#radialSelect',
    $radialSelect: {},
    initSubmit: (mapEntry) => {
        const get$sendButton = $(_.inputSelector + mapEntry.id + ' button[type="submit"]');

        get$sendButton.onClick(_.getNewPlaces(mapEntry));
    },
    getNewPlaces: (mapEntry) => {

        return () => {
            const searchRadius = radialSearch.getRadius(),
                location = getLocation();

            const data = {
                searchRadius,
                location,
                'id': ajaxMap.configData.mapSettings.pageId,
                'api': 'map',
                'action': 'listPlaces',
                'mapId': mapEntry.id
            };

            return ajaxCall(data).then((places) => {
                /*                TODO:
                map markers

                 */

                places.filterByActiveKeys(mapEntry, places)
            })
        }
    }

}

const autoSuggest = {
    setUp: (mapId, map) => {
        const input = $(_.locationInputSelector + mapId)[0];

        var germanBounds = new google.maps.LatLngBounds(
            google.maps.LatLng(5.98865807458, 47.3024876979),
            google.maps.LatLng(15.0169958839, 54.983104153))

        const options = {
            bounds: germanBounds,//https://gist.github.com/graydon/11198540/revisions,
            strictBounds: true,
            types: ['(cities)'],
            componentRestrictions: {country: 'de'}
        };

        const autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.bindTo('bounds', map);

    }
};

const radialSearch = {
    getValue: id => _.$radialSelect[id].val(),
    setUp: (id) => {
        _.$radialSelect[id] = $(_.radialSearchSelectSelector + id);

        //   $select.onChange()
    }
}

export default {
    init: (mapEntry) => {

        if (mapEntry.searchField) {
            autoSuggest.setUp(mapEntry.id, mapEntry.googleMap);
        }

        if (mapEntry.textSearch) {
            radialSearch.setUp(mapEntry.id);
        }
    }
};
