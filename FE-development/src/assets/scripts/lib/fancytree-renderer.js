import ajaxMap from './ajaxMap';
import places from './ajaxMap-places';
import layers from './map-layers';
import locationTypes from './ajaxMap-locationTypes';
import filter from './ajaxMap-places-filter';
import {sort} from './utilitys';

import $ from 'jquery';

import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';
import fastdom from 'fastdom';
export const fancytreeSelector = {
    locationType: '#ajaxMapLocationTypesTree',
    category: '#ajaxMapCategoryTree',
    regions: '#ajaxMapRegionsTree',
    placeGroup: '#ajaxMapPlaceGroupTree',
    places: '#ajaxMapPlacesTree'
};

/**
 * Renders a fancyTree
 * fetches json data by ajax call
 *
 * @param select Selector for node
 * @param action Ajax eID action name
 * @param mapId
 * @param settings Optional settings
 */
function renderTreeAjax($el, action, mapEntry, treeSettings) {
    const mapId = mapEntry.id;

    var localSettings = {
        checkbox: true,
        cookieId: 'fancyTree' + action + mapId,
        selectMode: 3,
        select: function(event, data) {
            places.update(mapEntry, true);
        },
        source: {
            url: ajaxMap.ajaxServerPath,
            type: 'GET',
            dataType: 'json',
            data: {
                'id': mapSettings.pageId,
                'api': 'map',
                'action': action,
                'mapId': mapId
            }
        }
    };

    if (typeof treeSettings === 'object') {
        for (var property in treeSettings) {
            if (treeSettings.hasOwnProperty(property)) {
                localSettings[property] = treeSettings[property];
            }
        }
    }

    $el.fancytree(localSettings).data('mapId', mapId);
}

const _ = {
    $getTreeEl: (id, mapId) => $(fancytreeSelector[id] + mapId),
    sort: (mapEntry, $placesRootNode) => {
        const defaultSortFkt = sort.aplhabeticLastName.asc;
        const customSortFkt = window.ajaxMapConfig.placeSortFunction;
        const radialVal = parseFloat(mapEntry.$sideBar.find('.am-radial-search select').val());

        /*bad magic --TODO make avaible outside, change sort by a field*/
        let sortFunction = (customSortFkt && radialVal) ? customSortFkt : defaultSortFkt;
        if (!mapEntry.afterInit) {
            mapEntry.afterInit = true;
            sortFunction = defaultSortFkt;
        }
        $placesRootNode.sortChildren(sortFunction, false);
    }
};

const renderTree = {
    update: {
        places: (mapEntry, children) => {
            const selector = fancytreeSelector.places + mapEntry.id,
                $placesRootNode = $(selector).fancytree('getRootNode');

            $placesRootNode.removeChildren();

            $placesRootNode.addChildren(children);

            //console.time('***********************')
            if (mapEntry) {
                _.sort(mapEntry, $placesRootNode);
            }

            filter.updateFilter($placesRootNode.children, mapEntry);
            //  console.timeEnd('***********************');

        }
    },
    places: (mapEntry, children) => {
        const mapId = mapEntry.id,
            $el = _.$getTreeEl('places', mapId);

        const placesTreeConfig = mapEntry.settings.placesTree ? mapEntry.settings.placesTree
            : ajaxMap.configData.mapSettings.settings.placesTree;

        const settings = {
            activate: places.showSoloPlace(mapEntry),
            autoScroll: true,
            cookieId: 'fancyTreePlaces' + mapId,
            extensions: placesTreeConfig.extensions,
            filter: placesTreeConfig.filter,
            icon: placesTreeConfig.icon,
            quicksearch: placesTreeConfig.quicksearch,
            selectMode: placesTreeConfig.selectMode,
            source: {
                mapNumber: mapId,//88??
                mapId: mapId,
                map: mapEntry.googleMap,
                children: []
            },
            renderTitle: (event, data) => {
                const placeInstance = data.node.data.placeInstance;
                placeInstance.treeNode = data.node;

                if (ajaxMapConfig.renderPlaceTreesItem) {

                    //console.log(placeInstance);
                    return ajaxMapConfig.renderPlaceTreesItem(placeInstance);
                }

                return null; // null is the default
            }
        };

        $el.fancytree(settings);

        /*
         $placeTree.renderNode = function(event, data) {
         alert('dffdffsaf')

         var node = data.node,
         $tdList = $(node.tr).find('>td');
         $tdList.eq(1).text(node.key);
         }
         */

        return $el.fancytree('getTree');
    },

    category: (mapEntry) => {
        const mapId = mapEntry.id,
            $el = _.$getTreeEl('category', mapId);

        if (!$el.length) {
            return;
        }

        renderTreeAjax(
            $el,
            'listCategories',
            mapEntry,
            mapEntry.settings.categoryTree,
        );
    },
    placeGroup: function(mapEntry) {

        const mapId = mapEntry.id,
            $el = _.$getTreeEl('placeGroup', mapId);

        if (!$el.length) {
            return;
        }

        renderTreeAjax(
            $el,
            'listPlaceGroups',
            mapEntry,
            mapEntry.settings.placeGroupTree
        );
    },
    regions: (mapEntry) => {

        const mapId = mapEntry.id,
            $el = _.$getTreeEl('regions', mapId);

        if (!$el.length) {
            return;
        }

        const options = mapEntry.settings.regionTree;

        $el.fancytree(
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
                    const selectedNodes = data.tree.getSelectedNodes();

                    const selectedKeys = $.map(selectedNodes, function(node) {
                        return node.key;
                    });

                    layers.update(mapEntry, selectedKeys);
                }
            }
        );
    },
    clearSelected: (tree) => {
        tree.clearFilter();

        tree.visit(function(node) {
            node.setSelected(false);
        });
    }
};

export default renderTree;
