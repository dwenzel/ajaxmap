import ajaxMap from './ajaxMap'
import places from './ajaxMap-places'
import locationTypes from './ajaxMap-locationTypes'
import filter  from './ajaxMap-places-filter'
import {sort}  from './utilitys'

import $ from 'jquery';

import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';

/**
 * Renders a fancyTree
 * fetches json data by ajax call
 *
 * @param select Selector for node
 * @param action Ajax eID action name
 * @param mapId
 * @param settings Optional settings
 */
function renderTreeAjax(select, action, mapId, settings) {

    var localSettings = {
        checkbox: true,
        cookieId: "fancyTree" + action + mapId,
        selectMode: 3,
        select: function(event, data) {

            pla.updatePlaces(mapNumber, true);
        },
        source: {
            url: "index.php",
            type: "GET",
            dataType: "json",
            data: {
                'id': mapSettings.pageId,
                'api': "map",
                'action': action,
                'mapId': mapId
            }
        }
    };
    if (typeof settings === 'object') {
        for (var property in settings) {
            if (settings.hasOwnProperty(property)) {
                localSettings[property] = settings[property];
            }
        }
    }

    $(select).fancytree(localSettings).data('mapId', mapId);
}

const _ = {

    getPlaceTreeSettings: (mapEntry) => {
        //@dirk? ist this per map or general
        const placesTreeConfig = mapEntry.settings.placesTree ? mapEntry.settings.placesTree
            : ajaxMap.configData.mapSettings.settings.placesTree;

        return {
            cookieId: 'fancyTreePlaces' + mapEntry.id,
            selectMode: placesTreeConfig.selectMode,
            source: {
                mapNumber: mapEntry.id,//88??
                mapId: mapEntry.id,
                map: mapEntry.googleMap,
                children: []
            },
            icon: placesTreeConfig.icon,
            extensions: placesTreeConfig.extensions,
            quicksearch: placesTreeConfig.quicksearch,
            filter: placesTreeConfig.filter,
            activate: places.showSoloPlace(mapEntry)
        };

    }
};

export const updateTree = {
    places: (mapEntry, children) => {
        var selector =
            fancytreeSelector.places + mapEntry.id;

        var $rootNode =
            $(selector).fancytree('getRootNode');

        $rootNode.removeChildren();
        $rootNode.addChildren(children);
        $rootNode.sortChildren(sort.aplhabetic.asc, false);

        filter.update($rootNode, mapEntry);
    }
}

export const fancytreeSelector = {
    locationType: '#ajaxMapLocationTypesTree',
    category: '#ajaxMapCategoryTree',
    regions: '#ajaxMapRegionsTree',
    placeGroup: '#ajaxMapPlaceGroupTree',
    places:'#ajaxMapPlacesTree'
}

const renderTree = {
    places: (mapEntry, children) => {
        const $placeTree = $(fancytreeSelector.places + mapEntry.id);
        const settings = _.getPlaceTreeSettings(mapEntry);

        $placeTree.fancytree(settings);

        updateTree.places(mapEntry, children);

        var placesTree = $placeTree.fancytree('getTree');
        return placesTree
    },

    category: (mapEntry) => {
        renderTreeAjax(
            '#ajaxMapCategoryTree' + mapEntry.id,
            "listCategories",
            mapEntry.id,
            mapEntry.settings.categoryTree
        );
    },
    placeGroup: function(mapEntry) {
        renderTreeAjax(
            '#ajaxMapPlaceGroupTree' + mapEntry.id,
            "listPlaceGroups",
            mapEntry.id,
            mapEntry.settings.placeGroupTree
        );
    },
    regions: (mapEntry) => {
        var options = mapEntry.settings.regionTree;

        $('#ajaxMapRegionsTree' + mapEntry.id).fancytree(
            {
                checkbox: options.checkbox,
                cookieId: 'fancyTreeRegions' + mapEntry.id,
                minExpandLevel: options.minExpandLevel,
                selectMode: options.selectMode,
                source: mapEntry.regions,
                filter: options.filter,
                extensions: options.extensions,
                glyph: options.glyph,
                icon: options.icons,
                select: function(event, data) {
                    var mapNumber = getMapNumber(data.tree.options.cookieId.split('fancyTreeRegions')[1]);
                    var selectedNodes = data.tree.getSelectedNodes();
                    var selectedKeys = $.map(selectedNodes, function(node) {
                        return node.key;
                    });
                    ajaxMap.updateLayers(mapNumber, selectedKeys);
                    updatePlaces(mapNumber, true);
                }
            }
        );
    },
    locationTypes: function(mapEntry) {

        var options = mapEntry.settings.locationTypeTree;

        const settings = {
            checkbox: options.checkbox,
            cookieId: "fancyTreeLocationTypes" + mapEntry.id,
            selectMode: options.selectMode,
            extensions: options.extensions,
            glyph: options.glyph,
            filter: options.filter,
            source: mapEntry.locationTypes,
            select: function(flag, node) {
                var mapNumber = getMapNumber(node.tree.options.cookieId.split('fancyTreeLocationTypes')[1]);

                updatePlaces(mapNumber, true);
            }

        };

        const selector = locationTypes.treeSelector + mapEntry.id;
        $(selector).fancytree(settings);
    }
};

export default renderTree;
