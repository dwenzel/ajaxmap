import $ from 'jquery';

import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';

import ajaxMap from './ajaxMap';
import placesFilter from './ajaxMap-places-filter';
import treeRenderer from './fancytree-renderer';
import markerInfoWindow from './map-marker-info-window';
import {getSelectedKeys, getLatLong} from './map-helpers';

import {fancytreeSelector} from './fancytree-renderer';
import {ajaxCall} from './utilitys';
import markers from './map-marker';

class Place {
    constructor(mapEntry, placeData) {
        this.mapEntry = mapEntry;
        this.placeData = placeData;
        this.LatLong = getLatLong(placeData.geoCoordinates);

        this.active = false;
        this.updateMarker = true;

        this.treeNode; ///full filled in render places tree renderTitle

        this.marker = markers.create(mapEntry, placeData);
    }

    setActive(activeState) {
        if (this.active !== activeState) {
            this.active = activeState;

            this.updateMarker = true;
        }
    }

    panToSelf() {
        this.mapEntry.googleMap.panTo(this.LatLong);
    }
}

const _ = {
    /*enableAllPlaces: (mapEntry) => {
     for (var i in mapEntry.placeInstances) {
     mapEntry.placeInstances[i].active = true;
     }
     },
     disableAllPlaces: (mapEntry) => {
     for (var i in mapEntry.placeInstances) {
     mapEntry.placeInstances[i].active = false;
     }
     },
     filterByActiveKeys: (mapEntry, placesResponse) => {
     _.disableAllPlaces(mapEntry);

     placesResponse.forEach((item) => {
     mapEntry.placeInstances[item.key].active = true;
     })
     },*/

    updatePlaces: (mapEntry, clearSelected) => {
        var treeSelector = fancytreeSelector.places + mapEntry.id;

        if (clearSelected) {
            const tree = $(treeSelector).fancytree('getTree');
            treeRenderer.clearSelected(tree);
        }

        var selectedPlaceKeys = getSelectedKeys(treeSelector);
        if (selectedPlaceKeys.length) {

            //from select a place in list /category? /pllacegroup
            placesFilter.showSelectedPlaces(mapEntry, selectedPlaceKeys);
        } else {
            placesFilter.showMatchingPlaces(mapEntry);
        }
    },
    showSoloPlace: (mapEntry) => (event, data) => {
        const placeInstance = data.node.data.placeInstance;
        const marker = placeInstance.marker;
        //zoom

        //placeInstance.panToSelf();
        //        mapEntry.googleMap.setZoom(13);//18??

        markers.setActiveMarkerToNormal(mapEntry);
        data.node.setActive(false);
        data.node.data.placeInstance.panToSelf();

        var mapMarkers = mapEntry.markers || [];
        const infoWindow = mapEntry.infoWindow;

        /*
         _.disableAllPlaces(mapEntry);
         data.node.data.placeInstance.active=true;
         when klicking on a place :: ehan already clicked toggle state
         */

        if (!data.node.selected) {

            data.node.setSelected(true);
            marker.setActive();
            markers.iterateZindex(marker);
            return;

            /* TODO: if (mapEntry.settings.placesTree.toggleInfoWindowOnSelect) {


             //  for (var i = 0, j = mapMarkers.length; i < j; i++) {

             //    var marker = mapMarkers[i];

             // if (marker.place.key === data.node.key) {
             const placeInstance = data.node.data.placeInstance;
             const marker = placeInstance.marker;

             markerInfoWindow.getInfoWindowContent(placeInstance.placeData)
             .then(content => {

             infoWindow.setContent(content);
             infoWindow.open(mapEntry.map, marker);
             });
             //}
             //}
             }*/
        } else {
            data.node.setSelected(false);
            // infoWindow.close();
        }

        _.updatePlaces(mapEntry);
    },
    setEvents: (placesTree) => {
        const resetFilterButtonSelector = 'button#btnResetPlacesFilter';

        $(resetFilterButtonSelector).click(function(e) {
            $('input[name=filterPlaces]').val('');
            $('span#matches').text('');
            placesTree.clearFilter();
        }).attr('disabled', true);

        $('input[name=filterPlaces]').keyup(function(e) {
            var n,
                opts = {},
                match = $(this).val();

            if (e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === '') {
                $(resetFilterButtonSelector).click();
                return;
            }
            // Pass a string to perform case insensitive matching
            n = placesTree.filterNodes(match, opts);
            $(resetFilterButtonSelector).attr('disabled', false);
            $('span#matches').text(n);
        }).focus();
    },
    isCenterInfo: (mapEntry, placeData) => {
        if (placeData.key === '_center') {
            //copy
            //  mapEntry.search.center = Object.assign({}, placeData);
            return true;
        }

        return false;
    },

    loadFromData: (mapEntry, data) => {

        // set loading
        mapEntry.spinner.activate()
        mapEntry.$map[0].dataset.loading = 'am-loading';
        mapEntry.$map[0].classList.remove('am-error');
        mapEntry.search = data;

        ajaxCall(data).then(function(result) {
            //  console.log('result', result)

            if (!mapEntry.places) {
                mapEntry.places = [];
            }

            let turnOfOnBuffer = new markers.TurnOfOnBuffer(mapEntry);
            mapEntry.places = [];

            if (result.length) {
                result.forEach((placeData, index) => {

                    if (_.isCenterInfo(mapEntry, placeData)) {
                        //data.radius
                        //delete result[index];

                        if (placeData.lat && placeData.lng) {
                            mapEntry.search.center =
                                new google.maps.LatLng(placeData.lat, placeData.lng);

                        }

                        return;
                    }

                    mapEntry.places[index] = placeData;

                    // store places
                    let placeInstance;
                    if (!mapEntry.placeInstances[placeData.key]) {
                        placeInstance = new Place(mapEntry, placeData);
                        placeData.placeInstance = placeInstance;

                        mapEntry.placeInstances[placeData.key] = placeInstance; //this is a register//

                    } else {
                        placeData = mapEntry.placeInstances[placeData.key].placeData;
                    }

                    turnOfOnBuffer.buffer[placeData.key] = false

                    mapEntry.places[index] = placeData;
                    mapEntry.$map[0].dataset.loading = null;

                    mapEntry.spinner.disable();
                });
            }

            turnOfOnBuffer.evaluate();
            turnOfOnBuffer = null;

            _.updatePlaces(mapEntry);
        }, (err) => {
            mapEntry.$map[0].dataset.loading = '';
            mapEntry.spinner.disable();
            console.error(err);
            mapEntry.$map[0].classList.add('am-error');
        });
    },
    defaultAjaxData: (mapEntry) => {
        return {
            'id': ajaxMap.configData.mapSettings.pageId,
            'api': 'map',
            'action': 'listPlaces',
            'mapId': mapEntry.id
        }
    },
    fitDatas: (mapEntry, defaultAjaxData) => {
        return mapEntry.search ?
            Object.assign({}, defaultAjaxData, {search: mapEntry.search}) : defaultAjaxData;
    },
    init: (mapEntry) => {
        //look up for not loading twice markers
        mapEntry.placeInstances = {};

        /*set default data for ajax call*/
        let defaultAjaxData = _.defaultAjaxData(mapEntry);
        mapEntry.defaultAjaxData = defaultAjaxData;

        /* create tree*/
        const placesTree = mapEntry.placesTree = treeRenderer.places(mapEntry, []);

        _.setEvents(placesTree);

        /* send Datas*/
        const data = _.fitDatas(mapEntry, defaultAjaxData);
        _.loadFromData(mapEntry, data);
    },
    placesTree: null
};

const places = {
    init: _.init,
    showSoloPlace: _.showSoloPlace,
    update: _.updatePlaces,
    loadFromData: _.loadFromData
};

export default places;
