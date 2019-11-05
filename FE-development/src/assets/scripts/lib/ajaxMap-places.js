import ajaxMap from './ajaxMap'
import $ from 'jquery';
import treeRenderer  from './fancytree-renderer.js'

import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';

const _ = {
    updatePlaces: (mapNumber, clearSelected) => {
        var mapEntry = ajaxMap.lookUp[mapNumber],
            treeSelector = _.treeSelector + mapEntry.id;

        if (typeof clearSelected != 'undefined') {
            var tree = $(treeSelector).fancytree('getTree');

            tree.clearFilter();
            tree.visit(function(node) {
                node.setSelected(false);
            });
        }

        var selectedPlaceKeys = getSelectedKeys(treeSelector);
        if (selectedPlaceKeys.length) {

            showSelectedPlaces(mapEntry, selectedPlaceKeys);

        } else {

            showMatchingPlaces(mapEntry);
        }
    },

    togglePlace: (event, data) => {
        var mapNumber = getMapNumber(data.tree.data.mapId),
            mapEntry = mapStore[mapNumber],
            mapMarkers = mapEntry.markers || [],
            infoWindow = mapEntry.infoWindow;

        if (!data.node.selected) {
            data.node.setSelected(true);
            if (mapEntry.settings.placesTree.toggleInfoWindowOnSelect) {
                for (var i = 0, j = mapMarkers.length; i < j; i++) {
                    var marker = mapMarkers[i];
                    if (marker.place.key == data.node.key) {
                        var content = ajaxMap.getInfoWindowContent(marker.place);
                        infoWindow.setContent(content);
                        infoWindow.open(mapEntry.map, marker);
                    }
                }
            }
        } else {
            data.node.setSelected(false);
            infoWindow.close();
        }

        data.node.setActive(false);
        updatePlaces(data.tree.data.mapNumber);
    },
    clickResetButton: function(e) {
        $(resetFilterButtonSelector).click(places.resetButtonClick).attr("disabled", true);
        $("input[name=filterPlaces]").val("");
        $("span#matches").text("");

        placesTree.clearFilter();
    },
    setEvents: (placesTree) => {
        const resetFilterButtonSelector = "button#btnResetPlacesFilter";

        $(resetFilterButtonSelector).click(function(e) {
            $("input[name=filterPlaces]").val("");
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
    init: (mapInstance) => {
        const mapEntry = mapInstance.mapEntry;

        return new Promise(function(resolve, reject) {
            $.ajax({
                url: ajaxMap.ajaxServerPath,
                type: 'GET',
                data: {
                    'id': ajaxMap.configData.mapSettings.pageId,
                    'api': 'map',
                    'action': 'listPlaces',
                    'mapId': mapEntry.id
                },
                dataType: "json",
                success: function(result) {
                    // store places
                    mapInstance.places = result;

                    if (result.length) {

                        var placesTree = treeRenderer.places(mapEntry, result);

                        _.setEvents(placesTree);
                        _.updatePlaces(mapEntry.id);
                    }
                }
            })
        })
    }
}

const places = {
    init: _.init,
    treeSelector: '#ajaxMapPlacesTree',
    togglePlace:_.togglePlace
};

export default places;
