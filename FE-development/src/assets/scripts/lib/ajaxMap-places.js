import $ from 'jquery';

import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';

import ajaxMap from './ajaxMap'
import placesFilter from './ajaxMap-places-filter'
import treeRenderer  from './fancytree-renderer'
import markerInfoWindow from './map-marker-info-window'
import {getSelectedKeys, getLatLong} from './map-helpers'

import {fancytreeSelector} from './fancytree-renderer'
import {ajaxCall} from './utilitys'
class Place {
    constructor(mapEntry, placeData) {
        this.mapEntry = mapEntry;
        this.placeData = placeData;
        this.LatLong = getLatLong(placeData.geoCoordinates);
        this.active = true;
    }

    panToSelf() {
        this.mapEntry.googleMap.panTo(this.LatLong)
    }
}

const _ = {
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
    },
    updatePlaces: (mapEntry, clearSelected) => {
        var treeSelector = fancytreeSelector.places + mapEntry.id;

        if (clearSelected) {
            var tree = $(treeSelector).fancytree('getTree');

            tree.clearFilter();
            tree.visit(function(node) {

                node.setSelected(false);
            });
        }

        var selectedPlaceKeys = getSelectedKeys(treeSelector);

        if (selectedPlaceKeys.length) {
            //from select a place in list
            placesFilter.showSelectedPlaces(mapEntry, selectedPlaceKeys);

        } else {

            placesFilter.showMatchingPlaces(mapEntry);
        }
    },
    showSoloPlace: (mapEntry) => {
        return (event, data) => {
            var mapMarkers = mapEntry.markers || [],
                infoWindow = mapEntry.infoWindow;

            if (!data.node.selected) {
                data.node.setSelected(true);

                if (mapEntry.settings.placesTree.toggleInfoWindowOnSelect) {
                    for (var i = 0, j = mapMarkers.length; i < j; i++) {

                        var marker = mapMarkers[i];

                        if (marker.place.key === data.node.key) {

                            markerInfoWindow.getInfoWindowContent(marker.place)
                            .then((content) => {

                                infoWindow.setContent(content);
                                infoWindow.open(mapEntry.map, marker);
                            });

                        }
                    }
                }
            } else {

                data.node.setSelected(false);
                infoWindow.close();
            }

            data.node.setActive(false);

            _.updatePlaces(mapEntry);

            //  console.log(data.node.data.placeInstance.panToSelf(),'++++++++++')


            data.node.data.placeInstance.panToSelf()
            //  placeInstance.up
        }
    },
    setEvents: (placesTree) => {
        const resetFilterButtonSelector = "button#btnResetPlacesFilter";

        $(resetFilterButtonSelector).click(function(e) {
            $("input[name=filterPlaces]").val('');
            $("span#matches").text("");
            placesTree.clearFilter();
        }).attr("disabled", true);

        $("input[name=filterPlaces]").keyup(function(e) {
            var n,
                opts = {},
                match = $(this).val();

            if (e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === "") {
                $(resetFilterButtonSelector).click();
                return;
            }
            // Pass a string to perform case insensitive matching
            n = placesTree.filterNodes(match, opts);
            $(resetFilterButtonSelector).attr("disabled", false);
            $("span#matches").text(n);
        }).focus();
    },
    init: (mapEntry) => {
        const data = {
            'id': ajaxMap.configData.mapSettings.pageId,
            'api': 'map',
            'action': 'listPlaces',
            'mapId': mapEntry.id
        };

        mapEntry.placeInstances = {};

        ajaxCall(data).then(function(result) {

            if (result.length) {
                mapEntry.places = result;
                mapEntry.places.forEach((placeData, index) => {
                    // store places
                    const placeInstance = new Place(mapEntry, placeData);
                    placeData.placeInstance= placeInstance;
                    mapEntry.placeInstances[placeData.key] = placeInstance;
                });

                const placesTree = treeRenderer.places(mapEntry, result);

                placesTree.rootNode.children.forEach((treeNode, i) => {
                    mapEntry.places[i].treeNode = treeNode;
                });

                _.setEvents(placesTree);
                _.updatePlaces(mapEntry);
            }
        })
    }
}

const places = {
    init: _.init,
    filterByActiveKeys: _.filterByActiveKeys,
    showSoloPlace: _.showSoloPlace,
    update: _.updatePlaces
};

export default places;
