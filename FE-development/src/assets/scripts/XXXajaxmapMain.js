import $ from 'jquery';
import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';

import MarkerClusterer from '@google/markerclusterer'
import {css} from 'jquery.fancytree/dist/skin-awesome/ui.fancytree.min.css';

import '../css/main.scss';

import {library, dom} from '@fortawesome/fontawesome-svg-core'

// import folder icons for tree
import {
    faCaretDown as fasCaretDown,
    faCaretRight as fasCaretRight,
    faFile as fasFile,
    faFolder as fasFolder,
    faFolderOpen as fasFolderOpen,
    faSquare as fasSquare

} from '@fortawesome/free-solid-svg-icons';

import {
    faFile as farFile,
    faFolder as farFolder,
    faFolderOpen as farFolderOpen,
    faSquare as farSquare
} from '@fortawesome/free-regular-svg-icons';

// Add icons to library
library.add(
    fasCaretDown,
    fasCaretRight,
    fasFile,
    fasFolder,
    fasFolderOpen,
    fasSquare,
    farFile,
    farFolder,
    farFolderOpen,
    farSquare
);

var ajaxMap = {};
// Replace any existing <i> tags with <svg> and set up a MutationObserver to
// continue doing this as the DOM changes.

(function($) {

    var basePath; // base path for resources like icons and kml files
    if (!window.location.origin) {
        basePath = window.location.protocol + "//" + window.location.host + "/";
    } else {
        // for webkit browsers
        basePath = window.location.origin + "/";
    }

    /****************
     * PUBLIC METHODS
     ****************/

    /**
     * Initializes all maps from mapStore
     */
    this.initAllMaps = function() {
        // init all maps
        for (var entry = 0; entry < mapStore.length; entry++) {
            initMap(mapStore[entry]);
        }
    };

    /**
     *
     * @param mapNumber
     * @param layerIds
     */
    this.updateLayers = function(mapNumber, layerIds) {
        var mapEntry = mapStore[mapNumber];
        var existingLayers = mapEntry.layers;
        if (typeof (existingLayers) !== 'undefined') {
            var existingKeys = Object.keys(existingLayers);
            for (var i = 0; i < existingKeys.length; i++) {
                var key = existingKeys[i];
                if (layerIds.indexOf(parseInt(key)) > -1) {
                    mapEntry.layers[key].setMap(mapEntry.map);
                } else {
                    mapEntry.layers[key].setMap(null);
                }
            }
        }
    };
    /**
     * Renders the info window content for a place
     *
     * @param place
     * @returns {string|*}
     */
    this.getInfoWindowContent = function(place) {
        /**
         * @todo make content rendering configurable, add link for overlay with additional info
         */
        // build a list of place's categories
        if (place.categories) {
            var list = '<div><ul class="placeCategories">';
            $.each(place.categories, function() {
                list += '<li>' + this.title + '</li>';
            });
            list += '</ul></div>';
        }
        /**
         * @todo - wrapping could be done by helper or server
         *  it should be possible too to configure content of infoWindow by TyoScript
         */
        var addressJson = place.address;
        if (typeof addressJson == 'undefined') {
            // fetch address data from server
            addressJson = getAddress(place.uid);
        }
        if (addressJson) {
            var address = '';
            address += '<div class="infoWindowAddress"><div class="infoWindowStreet">' + addressJson.address + '</div>' +
                '<div class="infoWindowZip">' + addressJson.zip + '</div><div class="infoWindowCity">' + addressJson.city + '</div>' +
                '</div>';
            // store address when fetched for the first time and reuse it
            place.address = addressJson;
        }
        let content = '';
        content += (place.title) ? '<h4 class="infoWindowTitle">' + place.title + '</h4>' : "";
        content += (place.icon) ?
            '<img width="120px" class="infoWindowImage" src="' + place.icon + '"/>' : "";
        //'<p class="infoWindowDescription">' + place.description + '</p>';
        content += (list) ? list : "";
        content += (address) ? address : "";
        /*
         *  special for ext. browser see below - should be changed to use own content
         */
        content += '<div class="browserHelper"><a class="more detail-view" href="#">mehr</a></div>';
        $('body').append('<div id="detailView"><a id="overlay-close" style="display: inline;"></a><div class="inner"></div></div>');
        $('#detailView').data('placeId', place.key);

        return content;
    };

    this.openDetailView = function(caller, placeId) {
        switch (caller) {
            case "infoWindow":
                placeId = $('#detailView').data('placeId');
                break;
            case "listView":
                break;
            default:
                break;
        }

        if (placeId) {
            var path = $(location).attr('href');
            if (path.indexOf('?') > -1) {
                path = path + '&type=1441916976';
            } else {
                path = path + '?type=1441916976';
            }

            $.ajax({
                url: path,
                context: $('#detailView .inner'),
                data: {
                    tx_ajaxmap_map: {
                        'controller': "Place",
                        'action': 'ajaxShow',
                        'placeId': placeId
                    }
                }
            })
            .done(function(data) {
                this.html(data);
                $('#detailView').fadeIn('400');
                $('#overlayDetailHelper').height($(document).height()).fadeIn('400');
                $('#overlay-close').click(function() {
                    $('#detailView').fadeOut('500');
                    $('#overlayDetailHelper').fadeOut('500');
                    $('#detailView .inner').contents().remove();
                });
            });
        }
    }

    /*******************************
     * PRIVATE METHODS & PROPERTIES
     *******************************/

    /**
     * Creates a map
     *
     * @param response
     * @param mapEntry
     */
    function createMap(response, mapEntry) {
        var map,
            mapType,
            mapStyle;

        // prepare data
        let mapContainer = document.getElementById('ajaxMapContainer_Map' + mapEntry.id);
        $(mapContainer).height(response.height).width(response.width);
        const tmpCenter = (response.mapCenter).split(",");
        let mapCenter = new google.maps.LatLng(parseFloat(tmpCenter[0]), parseFloat(tmpCenter[1]));

        switch (response.type) {
            case "2":
                mapType = google.maps.MapTypeId.SATELLITE;
                break;
            case "3":
                mapType = google.maps.MapTypeId.HYBRID;
                break;
            case "4":
                mapType = google.maps.MapTypeId.TERRAIN;
                break;
            default:
                // 0 - 'Styled Map' and 1 - 'Road Map' will become ROADMAP
                mapType = google.maps.MapTypeId.ROADMAP;
                break;
        }

        if (response.type === "0" && response.mapStyle) {
            mapStyle = $.parseJSON('[' + response.mapStyle + ']');
        } else {
            mapStyle = '';
        }

        //build map
        map = new google.maps.Map(
            mapContainer, {
                zoom: response.initialZoom,
                center: mapCenter,
                mapTypeId: mapType,
                styles: mapStyle,
                disableDefaultUI: response.disableDefaultUI
            });

        // store map in array
        mapEntry.map = map;
        // store regions
        mapEntry.regions = response.regions || [];
        mapEntry.staticLayers = response.staticLayers || [];

        // info window
        mapEntry.infoWindow = new google.maps.InfoWindow(
            {
                maxWidth: 370
            }
        );

        // marker clusterer
        mapEntry.markerClusterer = new MarkerClusterer(map, [], mapEntry.settings.markerClusterer);

    }

    /**
     * Initializes a map by may entry
     *
     * @param mapEntry
     */
    function initMap(mapEntry) {
        //get map data
        $.ajax({
            url: "index.php",
            type: "GET",
            data: {
                'id': mapSettings.pageId,
                'api': "map",
                'action': 'buildMap',
                'mapId': mapEntry.id
            },
            dataType: "json",
            success: function(response) {
                createMap(response, mapEntry);

                // regions selector
                if (mapEntry.regions.length) {
                    mapEntry.layers = {};

                    mapEntry.regions.forEach(function(region) {
                        ajaxMap.addLayer(region, mapEntry);
                        if (region.children.length) {
                            region.children.forEach(function(childRegion) {
                                ajaxMap.addLayer(childRegion, mapEntry);
                            });
                        }
                    });
                    renderRegionTree(mapEntry);
                }
                if (mapEntry.staticLayers.length) {
                    mapEntry.staticLayers.forEach(function(staticLayer) {
                        ajaxMap.addStaticLayer(staticLayer, mapEntry);
                        if (staticLayer.children.length) {
                            staticLayer.children.forEach(function(childRegion) {
                                ajaxMap.addStaticLayer(childRegion, mapEntry);
                            });
                        }
                    });
                }

                // location types Selector
                if (response.locationTypes.length) {
                    mapEntry.locationTypes = response.locationTypes;
                    renderLocationTypesTree(mapEntry);
                    initLocationTypesSelector(mapEntry);
                }

                // placeGroups tree
                renderCategoryTree(mapEntry);
                renderPlaceGroupTree(mapEntry);
                initPlaces(mapEntry);
                $('body').append('<div id="overlayDetailHelper"></div>');
            },

            error: function(error) {
                //@todo get localized error message
                alert("Sorry! Unable to load map data.");
            }
        });
    }

    function initLocationTypesSelector(mapEntry) {
        // find selector by map id
        var mapId = mapEntry.id,
            currLocationTypes = mapEntry.locationTypes;
        //remove empty option (since fluid doesn't build a select without option)
        for (var type in currLocationTypes) {
            $("<option/>").val(currLocationTypes[type].key).text(currLocationTypes[type].title).appendTo("#ajaxMapLocationTypesSelector" + mapId);
        }
        // set on change function for location types selector
        $("#ajaxMapLocationTypesSelector" + mapId).change(function() {
            var mapNumber = getMapNumber(this.id.split("ajaxMapLocationTypesSelector")[1]);
            updatePlaces(mapNumber);
        })
    }

    /**
     * Adds a layer to the map. The layer will appear in the regions tree
     * too and can be switched on and off
     *
     * @param newLayerData
     * @param mapEntry
     */
    this.addLayer = function(newLayerData, mapEntry) {
        if (typeof (mapEntry.layers[newLayerData.key]) === 'undefined') {
            var layerUrl = basePath + newLayerData.file,
                layerOptions = {
                    clickable: newLayerData.clickable,
                    preserveViewport: newLayerData.preserveViewport,
                    suppressInfoWindows: newLayerData.suppressInfoWindows
                },
                newLayer = new google.maps.KmlLayer(layerUrl, layerOptions);
            if (typeof (newLayer) !== 'undefined') {
                mapEntry.layers[newLayerData.key] = newLayer;
            }
        }
    };

    /**
     * Adds a static layer to the map. I.e. the layer will not
     * appear in the regions tree and will permanently visible
     *
     * @param newLayerData
     * @param mapEntry
     */
    this.addStaticLayer = function(newLayerData, mapEntry) {
        var layerUrl = basePath + newLayerData.file,
            layerOptions = {
                clickable: newLayerData.clickable,
                preserveViewport: newLayerData.preserveViewport,
                suppressInfoWindows: newLayerData.suppressInfoWindows
            },
            newLayer = new google.maps.KmlLayer(layerUrl, layerOptions);
        newLayer.setMap(mapEntry.map);
    };

    function getMapNumber(mapId) {
        for (var i = 0; i < mapStore.length; i++) {
            if (mapStore[i].id == mapId) {
                return i;
            }
        }
    }

    function getLocationType(mapEntry, typeId) {
        for (var i = 0; i < mapEntry.locationTypes.length; i++) {
            if (mapEntry.locationTypes[i].key == typeId) {
                return mapEntry.locationTypes[i];
            }
        }
    }

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
                updatePlaces(mapNumber, true);
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

    /**
     * Renders a region tree. Data for tree is
     * fetched via Ajax call
     * @param mapEntry
     */
    function renderRegionTree(mapEntry) {
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
    }

    /**
     * Renders a category tree. Data for tree is
     * fetched via Ajax call
     *
     * @param mapEntry
     */
    function renderCategoryTree(mapEntry) {
        renderTreeAjax(
            '#ajaxMapCategoryTree' + mapEntry.id,
            "listCategories",
            mapEntry.id,
            mapEntry.settings.categoryTree
        );
    }

    /**
     * Renders a tree of place groups. Data for tree is
     * fetched via Ajax call
     *
     * @param mapEntry
     */
    function renderPlaceGroupTree(mapEntry) {
        renderTreeAjax(
            '#ajaxMapPlaceGroupTree' + mapEntry.id,
            "listPlaceGroups",
            mapEntry.id,
            mapEntry.settings.placeGroupTree
        );
    }

    /**
     * Renders a tree of places from given data
     *
     * @param mapEntry Map entry to which the tree belongs
     * @param children Object containing tree objects
     */
    function renderPlacesTree(mapEntry, children) {
        var selector = '#ajaxMapPlacesTree' + mapEntry.id,
            mapNumber = getMapNumber(mapEntry.id),
            map = mapEntry.map;

        var settings = {
            cookieId: "fancyTreePlaces" + mapEntry.id,
            selectMode: mapEntry.settings.placesTree.selectMode,
            source: {
                mapNumber: mapNumber,
                mapId: mapEntry.id,
                map: map,
                children: []
            },
            icon: mapEntry.settings.placesTree.icons,
            extensions: mapEntry.settings.placesTree.extensions,
            quicksearch: mapEntry.settings.placesTree.quicksearch,
            filter: mapEntry.settings.placesTree.filter,
            activate: function(event, data) {
                togglePlace(event, data);
            }
        };
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

        updatePlacesTree(mapEntry.id, children);
    }

    /**
     * Activates a place in the map
     * Handler for activate event of nodes in the places tree (result list)
     *
     * @param event
     * @param data
     */
    function togglePlace(event, data) {
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

    function updatePlacesTree(mapId, children) {
        var selector = '#ajaxMapPlacesTree' + mapId;
        var rootNode = $(selector).fancytree('getRootNode');
        rootNode.removeChildren();
        rootNode.addChildren(children);

        rootNode.sortChildren(utilitys.sort.asc, false);
        updateFilter(rootNode.tree);
    }

    /**
     * Updates all filter (trees)
     * Determines for all nodes in all filter trees whether
     * they should be shown.
     * A node in a filter tree should be visible if at least
     * one node in the result tree (placesTree) has the
     * according option (for instance if it belongs to a region)
     *
     * @param placesTree The places tree
     * @return void
     */
    function updateFilter(placesTree) {
        var mapId = placesTree.data.mapId,
            mapNumber = getMapNumber(mapId),
            mapEntry = mapStore[mapNumber],
            filters = mapEntry.settings.placesTree.updateFilters;
        $.each(filters, function(filterName, filter) {
            var treeSelector = '#' + filter.treeName + mapId;
            var tree = $(treeSelector).fancytree('getTree'),
                children = placesTree.getRootNode().children,
                placeKeys = getKeysByAttribute(children, filterName);
            filterTree(tree, placeKeys);
            if (filterName === 'regions' && filter.updateLayers) {
                var selectedKeys = getSelectedKeys(treeSelector);
                ajaxMap.updateLayers(mapNumber, selectedKeys);
            }
        });
    }

    /**
     * Searches all children for an attribute in their data property
     * and returns a unique array of keys for this attribute
     *
     * @param children
     * @param name
     * @return Array
     */
    function getKeysByAttribute(children, name) {
        var keys = [];
        $.each(children, function(index, child) {
            if (child.data.hasOwnProperty(name)) {
                var attribute = child.data[name];
                if (attribute !== undefined &&
                    attribute !== null &&
                    attribute.hasOwnProperty('key') && !keys[attribute.key]) {
                    keys.push(attribute.key);
                } else {
                    if (attribute instanceof Array) {
                        for (var i = 0, k = attribute.length; i < k; i++) {
                            if (attribute[i].hasOwnProperty('key') && keys.indexOf(attribute[i].key) < 0) {
                                keys.push(attribute[i].key);
                            }
                        }
                    }
                }
            }
        });

        return keys;
    }

    /**
     * Filters a tree by a unique array of keys
     * A node will be visible if its key is in the this array
     *
     * @param tree Fancy tree
     * @param keys Unique array of keys
     */
    function filterTree(tree, keys) {
        const options = {autoExpand: true};
        tree.filterNodes(function(node) {
            return (keys.indexOf(parseInt(node.key)) != -1);
        }, options);
    }

    /**
     * Renders a tree of places. Data for tree is
     * fetched via Ajax call
     *
     * @param mapEntry Unique id of map to which the tree belongs
     */
    function renderLocationTypesTree(mapEntry) {
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

    /**
     * get locations for a single Map
     * @param mapEntry
     */
    function initPlaces(mapEntry) {
        $.ajax({
            url: "index.php",
            type: "GET",
            data: {
                'id': mapSettings.pageId,
                'api': "map",
                'action': "listPlaces",
                'mapId': mapEntry.id
            },
            dataType: "json",
            success: function(result) {
                var mapNumber = getMapNumber(mapEntry.id);
                // store places
                mapStore[mapNumber].places = result;

                if (result.length) {
                    renderPlacesTree(mapEntry, result);
                    updatePlaces(mapNumber);
                }
            }
        })
    }

    /**
     * get address for a single place
     * @param placeId
     * @return json
     */
    function getAddress(placeId) {
        var address = {};
        $.ajax({
            url: "index.php",
            type: "GET",
            data: {
                'id': mapSettings.pageId,
                'api': "map",
                'action': "getAddress",
                'placeId': placeId
            },
            dataType: "json",
            success: function(result) {
                address = result;
            }
        });
        return address;
    }

    function createMarker(mapEntry, mapNumber, place) {
        var map = mapEntry.map,
            currType = place.locationType.key,
            tmpCenter = place.geoCoordinates.split(","),
            currLatlng = new google.maps.LatLng(parseFloat(tmpCenter[0]), parseFloat(tmpCenter[1]));

        var mapMarker = new google.maps.Marker({
            position: currLatlng,
            map: map,
            title: place.title
        });
        if (currType) {
            mapMarker.setIcon(getLocationType(mapEntry, currType).icon);
        }
        mapMarker.mapNumber = mapNumber;
        mapMarker.place = place;
        // add click function
        google.maps.event.addListener(mapMarker, 'click', function() {
            var map = this.getMap(),
                infoWindow = mapStore[this.mapNumber].infoWindow,
                content = ajaxMap.getInfoWindowContent(this.place);

            infoWindow.setContent(content);
            google.maps.event.addListener(infoWindow, 'domready', function() {
                $('.more.detail-view').unbind("click").bind("click", (function(event) {
                    event.preventDefault();
                    ajaxMap.openDetailView(
                        "infoWindow", -1);
                    event.stopPropagation();
                }));
            });
            infoWindow.open(map, this);

        });
        return mapMarker;
    }

    /**
     * Shows places which match all constraints
     * defined by region, place group, location type or category selector
     *
     * @param mapEntry
     */
    function showMatchingPlaces(mapEntry) {
        var map = mapEntry.map,
            mapId = mapEntry.id,
            mapPlaces = mapEntry.places,
            selectedPlaces = [],
            clusterer = mapEntry.markerClusterer,
            mapMarkers = mapEntry.markers || [],
            selectedLocationTypeKeys = getSelectedKeys('#ajaxMapLocationTypesTree' + mapId),
            selectedCategoryKeys = getSelectedKeys('#ajaxMapCategoryTree' + mapId),
            selectedRegionKeys = getSelectedKeys('#ajaxMapRegionsTree' + mapId),
            selectedPlaceGroupKeys = getSelectedKeys('#ajaxMapPlaceGroupTree' + mapId),
            selectedLocationType = 0;

        // get selected location type. This should be one or none
        if (selectedLocationTypeKeys.length) {
            selectedLocationType = selectedLocationTypeKeys[0];
        }

        clusterer.removeMarkers(mapMarkers);

        // add markers for all places
        for (var i = 0, j = mapPlaces.length; i < j; i++) {
            var place = mapPlaces[i],
                marker = mapMarkers[i];
            if (!mapMarkers[i]) {
                // marker does not exist, create it
                mapMarkers[i] = createMarker(mapEntry, getMapNumber(mapId), place);
            } else {
                var hasAnActiveCategory = 0,
                    hasAnActiveRegion = 0,
                    hasAnActivePlaceGroup = 0;

                if (selectedCategoryKeys && marker.place.categories) {
                    $.each(marker.place.categories, function() {
                        hasAnActiveCategory = ($.inArray(parseInt(this.key), selectedCategoryKeys) > -1);
                        return (!hasAnActiveCategory);
                    });
                }

                if (selectedRegionKeys.length && marker.place.regions) {
                    $.each(marker.place.regions, function() {
                        hasAnActiveRegion = ($.inArray(parseInt(this.key), selectedRegionKeys) > -1);
                        return (!hasAnActiveRegion);
                    });
                }

                if (selectedPlaceGroupKeys.length && marker.place.placeGroups) {
                    $.each(marker.place.placeGroups, function() {
                        hasAnActivePlaceGroup = ($.inArray(parseInt(this.key), selectedPlaceGroupKeys) > -1);
                        return (!hasAnActivePlaceGroup);
                    });
                }

                if (
                    (place.locationType.key == selectedLocationType || !selectedLocationTypeKeys.length)
                    && (hasAnActiveCategory || !selectedCategoryKeys.length)
                    && (hasAnActiveRegion || !selectedRegionKeys.length)
                    && (hasAnActivePlaceGroup || !selectedPlaceGroupKeys.length)) {
                    marker.setMap(map);
                    selectedPlaces[selectedPlaces.length] = place;
                } else {
                    marker.setMap(null);
                }
            }
        }

        //   clusterer.addMarkers(mapMarkers);

        // update only if mapEntry is already initialized
        if (typeof mapEntry.markers != 'undefined') {
            updatePlacesTree(mapId, selectedPlaces);
        }
        mapEntry.markers = mapMarkers;
    }

    /**
     * Shows places from a list of selected places
     *
     * @param mapEntry
     * @param selectedPlaceKeys
     * @returns {*}
     */
    function showSelectedPlaces(mapEntry, selectedPlaceKeys) {
        var map = mapEntry.map,
            mapId = mapEntry.id,
            mapPlaces = mapEntry.places,
            clusterer = mapEntry.markerClusterer,
            mapMarkers = mapEntry.markers || [];

        for (var i = 0, j = mapPlaces.length; i < j; i++) {
            var place = mapPlaces[i],
                marker = mapMarkers[i];
            if (!mapMarkers[i]) {
                // marker does not exist, create it
                mapMarkers[i] = createMarker(mapEntry, getMapNumber(mapId), place);
            } else {
                marker.setMap(null);
                clusterer.removeMarker(marker);
            }
        }
        clusterer.addMarkers(mapMarkers);

        mapMarkers.forEach(
            function(element) {
                if ($.inArray(element.place.key, selectedPlaceKeys) > -1) {
                    element.setMap(map);
                }
            });
    }

    /**
     *  update display of places
     *  to be used on initial setup of map and each time when
     *  selection changes
     *  (triggered by changing select field for location type
     *  and selection in fancyTree)
     */
    function updatePlaces(mapNumber, clearSelected) {
        var mapEntry = mapStore[mapNumber],
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
    }

    function getSelectedKeys(selector) {
        var tree = $(selector).fancytree('getTree'),
            selectedKeys = [];
        if (typeof tree.getSelectedNodes === 'function') {
            var selectedNodes = tree.getSelectedNodes();
            selectedKeys = $.map(selectedNodes, function(node) {
                return parseInt(node.key);
            });
        }
        return selectedKeys;
    }
}).apply(ajaxMap, [$]);

$(function() {
    // initialize all maps
    if (typeof mapStore !== "undefined" && mapStore instanceof Array) {
        ajaxMap.initAllMaps();
        //alert('33')

        $("input[name=filterPlaces]").val("");
    }
});

