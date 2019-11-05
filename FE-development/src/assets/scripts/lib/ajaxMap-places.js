import ajaxMap from './ajaxMap'
import $ from 'jquery';
import treeRenderer  from './fancytree-renderer.js'

import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';

import filter  from './ajaxMap-filter-places'

const _ = {
    updatePlaces: (mapNumber, clearSelected) => {
        var mapEntry = ajaxMap.lookUp[mapNumber],
            treeSelector = '#ajaxMapPlacesTree' + mapEntry.id;

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
    }
    ,
    updatePlacesTree: (mapId, children) => {
        var selector = '#ajaxMapPlacesTree' + mapId;
        var rootNode = $(selector).fancytree('getRootNode');

        console.log(rootNode,'rootNode')

        rootNode.removeChildren();
        rootNode.addChildren(children);

        var compare = function(a, b) {
            a = a.title.toLowerCase();
            b = b.title.toLowerCase();
            return a > b ? 1 : a < b ? -1 : 0;
        };

        rootNode.sortChildren(compare, false);
        updateFilter(rootNode.tree);
    },


    init: function() {

        const mapEntry = this.mapEntry;
        const that=this;

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
                    that.places = result;

                    if (result.length) {
                        treeRenderer.places(mapEntry, result);

                        _.updatePlaces(mapEntry.id);
                    }
                }
            })
        })
    }
}

const places = {
    init: _.init,
    updatePlacesTree:_.updatePlacesTree

};

export default places;
