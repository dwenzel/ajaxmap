import ajaxMap from './ajaxMap'
import places from './ajaxMap-places'
import filter  from './ajaxMap-filter-places'

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
            var mapNumber = getMapNumber(data.tree.options.cookieId.split('fancyTree' + action)[1]);
            ajaxMap.updatePlaces(mapNumber, true);
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



}

const renderTree = {
    places: (mapEntry, children) => {
        var mapNumber = mapEntry.id,
            map = mapEntry.map;

        //@dirk? ist this per map or general
        const placesTreeConfig = mapEntry.settings.placesTree ? mapEntry.settings.placesTree
            : ajaxMap.configData.mapSettings.settings.placesTree;

        var settings = {
            cookieId: 'fancyTreePlaces' + mapEntry.id,
            selectMode: placesTreeConfig.selectMode,
            source: {
                mapNumber: mapNumber,
                mapId: mapEntry.id,
                map: map,
                children: []
            },
            icon: placesTreeConfig.icon,
            extensions: placesTreeConfig.extensions,
            quicksearch: placesTreeConfig.quicksearch,
            filter: placesTreeConfig.filter,
            activate: function(event, data) {
                _.togglePlace(event, data);
            }
        };

        const selector = '#ajaxMapPlacesTree' + mapEntry.id
        $(selector).fancytree(settings);
        //
        var placesTree = $(selector).fancytree('getTree'),
            resetFilterButtonSelector = "button#btnResetPlacesFilter";

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

        places.updatePlacesTree(mapEntry.id, children);
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
        var selector = '#ajaxMapLocationTypesTree' + mapEntry.id,
            options = mapEntry.settings.locationTypeTree,
            settings = {
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

        $(selector).fancytree(settings);
    }
};

export default renderTree;
