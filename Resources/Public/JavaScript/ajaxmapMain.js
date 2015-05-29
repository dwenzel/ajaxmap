var basePath; // base path for resources like icons and kml files

$(function () {
	if (!window.location.origin) {
		basePath = window.location.protocol + "//" + window.location.host + "/";
	}
	else {
		// for webkit browsers
		basePath = window.location.origin + "/";
	}

	// initialize all maps
	if (typeof mapStore !== "undefined" && mapStore instanceof Array) {
		initAllMaps();
	}
});

function initAllMaps() {
	// init all maps
	for (mapNumber in mapStore) {
		initMap(mapNumber);
	}
}

function createMap(response, mapEntry) {
	var map;

	// prepare data
	mapContainer = document.getElementById('ajaxMapContainer_Map' + mapEntry.id);
	$(mapContainer).height(response.height).width(response.width);
	tmpCenter = (response.mapCenter).split(",");
	mapCenter = new google.maps.LatLng(parseFloat(tmpCenter[0]), parseFloat(tmpCenter[1]));

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

	if (response.type = "0" && response.mapStyle) {
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
	mapEntry.regions = response.regions;

	// info window
	mapEntry.infoWindow = new google.maps.InfoWindow(
		{
			maxWidth: 370
		}
	);
}
function initMap(mapNumber) {

	mapEntry = mapStore[mapNumber];

	//get map data
	$.ajax({
		url: "index.php",
		type: "GET",
		data: {
			'eID': "ajaxMap",
			request: {
				'pluginName': "Map",
				'controller': "Map",
				'action': "item",
				'arguments': {
					'task': 'buildMap',
					'mapId': mapEntry.id,
					'pageId': pageId
				}
			}
		},
		dataType: "json",
		success: function (response) {
			createMap(response, mapEntry);
			// regions selector
			if (mapEntry.regions.length) {
				mapEntry.layers = {};
				mapEntry.regions.forEach(function(region){
					addLayer(region, mapEntry);
					if (region.children.length) {
						region.children.forEach(function(childRegion){
							addLayer(childRegion, mapEntry);
						});
					}
				});
				renderRegionTree(mapEntry);
			}
			// location types Selector
			if (mapEntry.locationTypes.length) {
				renderLocationTypesTree(mapEntry.id, mapEntry.locationTypes);
				initLocationTypesSelector(mapEntry);
			}

			// placeGroups tree
			renderCategoryTree(mapEntry.id);
			renderPlaceGroupTree(mapEntry.id);
			initPlaces(mapEntry);
			$('body').append('<div id="overlayDetailHelper"></div>');

		},

		error: function (error) {
			//@todo get localized error message
			alert("Sorry! Unable to load map data.");
		}
	});
}

function initLocationTypesSelector(mapEntry) {
	// find selector by map id	
	mapId = mapEntry.id;
	var currLocationTypes = mapEntry.locationTypes;
	//remove empty option (since fluid doesn't build a select without option)
	for (var type in currLocationTypes) {
		$("<option/>").val(currLocationTypes[type].key).text(currLocationTypes[type].title).appendTo("#ajaxMapLocationTypesSelector" + mapId);
	}
	// set on change function for location types selector
	$("#ajaxMapLocationTypesSelector" + mapId).change(function (mapEntry) {
		mapNumber = getMapNumber(this.id.split("ajaxMapLocationTypesSelector")[1]);
		updatePlaces(mapNumber);
	})
}

/**
 *
 * @param mapNumber
 * @param layerIds
 */
function updateLayers(mapNumber, layerIds) {
	var mapEntry = mapStore[mapNumber];
	var existingLayers = mapEntry.layers;
	if (typeof (existingLayers) !== 'undefined') {
		var existingKeys = Object.keys(existingLayers);
		for(var i=0; i<existingKeys.length; i++) {
			var key = existingKeys[i];
			if (layerIds.indexOf(key)>-1) {
				mapEntry.layers[key].setMap(mapEntry.map);
			} else {
				mapEntry.layers[key].setMap(null);
			}
		}
	}
}

function addLayer(newLayerData, mapEntry) {

	if (typeof(mapEntry.layers[newLayerData.key]) === 'undefined') {
		layerUrl = basePath + newLayerData.file;

		layerOptions = {
			clickable: newLayerData.clickable,
			preserveViewport: newLayerData.preserveViewport,
			suppressInfoWindows: newLayerData.suppressInfoWindows
		};
		newLayer = new google.maps.KmlLayer(layerUrl, layerOptions);
		if (typeof(newLayer) !== 'undefined') {
			//newLayer.setMap(mapEntry.map);
			mapEntry.layers[newLayerData.key] = newLayer;
		}
	}
}

function getRegion(mapNumber, layerId) {
	if (mapStore[mapNumber] && mapStore[mapNumber].regions.length) {
		regions = mapStore[mapNumber].regions;
		return $.grep(regions, function (obj) {
			if (obj.key === layerId) {
				return true
			} else {
				if (obj.children.lenght) {
					//iterate over children (recursive ...)
				}
			}
		})[0];
	}
}
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
 * @param string  select
 * @param int > mapId
 */

/**
 * Renders a dynaTree
 * fetches json data by ajax call
 *
 * @param select Selector for node
 * @param action Ajax eID action name
 * @param mapId
 */
function renderTreeAjax(select, action, mapId) {
	$(select).dynatree({
		//debugLevel: 2,
		persist: true,
		checkbox: true,
		cookieId: "dynaTree" + action + mapId,
		selectMode: 3,
		onSelect: function (flag, node) {
			var mapNumber = getMapNumber(node.tree.options.cookieId.split('dynaTree' + action)[1]);
			updatePlaces(mapNumber);
		},
		initAjax: {
			url: "index.php",
			type: "GET",
			dataType: "json",
			data: {
				'eID': "ajaxMap",
				request: {
					'pluginName': "Map",
					'controller': "Map",
					'action': action,
					'arguments': {
						'mapId': mapId
					}
				}
			}
		}
	}).data('mapId', mapId);
}

/**
 * Renders a region tree. Data for tree is
 * fetched via Ajax call
 * @param mapEntry
 */
function renderRegionTree(mapEntry) {
	$('#ajaxMapRegionsTree' + mapEntry.id).dynatree(
		{
			persist: false,
			checkbox: true,
			cookieId: 'dynaTreeRegions' + mapEntry.id,
			selectMode: 3, //hierarchical select
			children: mapEntry.regions,
			onSelect: function(flag, node) {
				var mapNumber = getMapNumber(node.tree.options.cookieId.split('dynaTreeRegions')[1]);
				var selectedNodes = node.tree.getSelectedNodes();
				var selectedKeys = $.map(selectedNodes, function(node){
					return node.data.key;
				});
				updateLayers(mapNumber, selectedKeys);
				updatePlaces(mapNumber);
			}
		}
	);
}

/**
 * Renders a category tree. Data for tree is
 * fetched via Ajax call
 *
 * @param mapId
 */
function renderCategoryTree(mapId) {
	renderTreeAjax(
		'#ajaxMapCategoryTree' + mapId,
		"ajaxListCategories",
		mapId);
}

/**
 * Renders a tree of place groups. Data for tree is
 * fetched via Ajax call
 *
 * @param mapId
 */
function renderPlaceGroupTree(mapId) {
	renderTreeAjax(
		'#ajaxMapPlaceGroupTree' + mapId,
		"ajaxListPlaceGroups",
		mapId);
}

/**
 * Renders a tree of places. Data for tree is
 * fetched via Ajax call
 *
 * @param mapId Unique id of map to which the tree belongs
 * @param children Object containing tree objects
 */
function renderPlacesTree(mapId, children) {
	var selector = '#ajaxMapPlacesTree' + mapId;
	var settings = {
		persist: true,
		cookieId: "dynaTreePlaces" + mapId,
		selectMode: 2,
		children: children
	};
	$(selector).dynatree(settings);
}

/**
 * Renders a tree of places. Data for tree is
 * fetched via Ajax call
 *
 * @param mapId Unique id of map to which the tree belongs
 * @param children Object containing tree objects
 */
function renderLocationTypesTree(mapId, children) {
	var selector = '#ajaxMapLocationTypesTree' + mapId;
	var settings = {
		persist: true,
		checkbox: true,
		cookieId: "dynaTreeLocationTypes" + mapId,
		selectMode: 1,
		children: children,
		onSelect: function(flag, node) {
			var mapNumber = getMapNumber(node.tree.options.cookieId.split('dynaTreeLocationTypes')[1]);
			updatePlaces(mapNumber);
		}

	};
	$(selector).dynatree(settings);
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
			'eID': "ajaxMap",
			request: {
				'pluginName': "Map",
				'controller': "Map",
				'action': "ajaxListPlaces",
				'arguments': {
					'mapId': mapEntry.id
				}
			}
		},
		dataType: "json",
		success: function (result) {
			mapNumber = getMapNumber(mapEntry.id);
			// store places
			mapStore[mapNumber].places = result;

			if (result.length) {
				renderPlacesTree(mapId, result);
				//update places (set marker)
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
	var address;
	$.ajax({
		url: "index.php",
		type: "GET",
		data: {
			'eID': "ajaxMap",
			request: {
				'extensionName': "Ajaxmap",
				'pluginName': "Map",
				'controller': "Map",
				'action': "item",
				'arguments': {
					'task': 'getAddress',
					'placeId': placeId
				}
			}
		},
		dataType: "json",
		success: function (result) {
			address = result;
		}
	});
	return address;
}

function createMarker(mapEntry, mapNumber, place){
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
		mapMarker.setIcon = getLocationType(mapEntry, currType).markerIcon;
	}
	mapMarker.mapNumber = mapNumber;
	mapMarker.place = place;
	// add click function
	google.maps.event.addListener(mapMarker, 'click', function () {
		map = this.getMap();
		infoWindow = mapStore[this.mapNumber].infoWindow;
		/**
		 * @todo move content setup to function and make it configurable
		 * add link for overlay with additional info
		 */
		// build a list of place's categories
		if (this.place.categories) {
			var list = '<div><ul class="placeCategories">';
			$.each(this.place.categories, function () {
				list += '<li>' + this.title + '</li>';
			});
			list += '</ul></div>';
		}
		/**
		 * @todo - wrapping could be done by helper or server
		 *  it should be possible too to configure content of infoWindow by TyoScript
		 */
		var addressJson = this.place.address;
		if (typeof addressJson == 'undefined') {
			// fetch address data from server
			addressJson = getAddress(this.place.uid);
		}
		if (addressJson) {
			var address = '';
			address += '<div class="infoWindowAddress"><div class="infoWindowStreet">' + addressJson.address + '</div>' +
			'<div class="infoWindowZip">' + addressJson.zip + '</div><div class="infoWindowCity">' + addressJson.city + '</div>' +
				//'<div class="infoWindowPhone">' + addressJson.phone + '</div>' +
				//'<div class="infowWindoMobile">' + addressJson.mobile + '</div>' +
				//'<div class="infoWindowFax">' + addressJson.fax + '</div>' +

				//'<a class="infoWindowWeb" href="http://' +addressJson.www +'">' + addressJson.www +'</a>' +
			'</div>';
			/*	$.each(addressJson, function(key, value){
			 if(value != null){
			 address += '<div>' + value + '</div>';
			 }

			 })*/
			// store address when fetched for the first time and reuse it
			this.place.address = addressJson;
		}
		content = '';
		content += (this.place.title) ? '<h4 class="infoWindowTitle">' + this.place.title + '</h4>' : "";
		//content +=(addressJson.tx_kecontacts_function)?'<div class="infoWindowType">' + addressJson.tx_kecontacts_function + '</div>': "";
		content += (this.place.icon) ?
		'<img width="120px" class="infoWindowImage" src="' + this.place.icon + '"/>' : "";
		//'<p class="infoWindowDescription">' + this.place.description + '</p>';
		content += (list) ? list : "";
		content += (address) ? address : "";
		/*
		 *  special for ext. browser see below - should be changed to use own content
		 */
		content += '<div class="browserHelper"><a class="more" href="#">mehr</a></div>';
		$('body').append('<div id="detailView"><a id="overlay-close" style="display: inline;"></a><divclass="inner"></div></div>');
		$('#detailView').attr('placeId', this.place.uid);
		infoWindow.
			setContent(content);
		google.maps.event.addListener(infoWindow, 'domready', function () {
				// remove old handler and add new
				$('.more').unbind("click").bind("click", (function (event) {
						event.preventDefault();
						openDetailView(
							"infoWindow", -1);
						// prevent double event occurrence
						event.stopPropagation();
					}));
			});
		infoWindow.open(map, this);
		/*
		 *  this is kind of a hack to bring ajaxMap and extension browser together
		 *  and should be moved to custom js
		 */
		//ajaxifySingleLinks($('.browserHelper'));

	});
	return mapMarker;
}

/*
 *  update display of places
 *  to be used on initial setup of map and each time when
 *  selection changes
 *  (triggerd by changing select field for location type
 *  and selection in dynatree
 *  @todo add filter for regions (overlays from kml files)
 */
function updatePlaces(mapNumber) {
	var mapEntry = mapStore[mapNumber],
		map = mapEntry.map,
		mapId = mapEntry.id,
		mapPlaces = mapEntry.places,
		mapMarkers = mapEntry.markers || [],
		selectedLocationTypeKeys = getSelectedKeys('#ajaxMapLocationTypesTree' + mapId),
		selectedCategoryKeys = getSelectedKeys('#ajaxMapCategoryTree' + mapId),
		selectedRegionKeys = getSelectedKeys('#ajaxMapRegionsTree' + mapId),
		selectedPlaceGroupsKeys = getSelectedKeys('#ajaxMapPlaceGroupTree' + mapId);

	// get selected location type. This should be one or none
	if (selectedLocationTypeKeys.length) {
		selectedLocationType = selectedLocationTypeKeys[0];
	}

	// add markers for all places
	for (var i = 0, j = mapEntry.places.length; i < j; i++) {
		var place = mapPlaces[i],
			marker = mapMarkers[i];
		if (!mapMarkers[i]) {
			// marker does not exist, create it
			mapMarkers[i] = createMarker(mapEntry, mapNumber, place);
		} else {
			var hasAnActiveCategory = 0;
			var hasAnActiveRegion = 0;
				if (marker.place.categories) {
					$.each(marker.place.categories, function () {
						hasAnActiveCategory = ($.inArray(parseInt(this.key), selectedCategoryKeys) > -1);
						return (!hasAnActiveCategory);
					});
				}

			if (selectedRegionKeys.length && marker.place.regions) {
				$.each(marker.place.regions, function () {
					hasAnActiveRegion = ($.inArray(parseInt(this.key), selectedRegionKeys) > -1);
					return (!hasAnActiveRegion);
				});
			}

			if (
				(place.locationType.key == selectedLocationType || !selectedLocationTypeKeys.length)
				&& (hasAnActiveCategory || !selectedCategoryKeys.length)
				&& (hasAnActiveRegion || !selectedRegionKeys.length)) {
				marker.setMap(map);
			}
			else {
				marker.setMap(null);
			}
		}

	}
	mapEntry.markers = mapMarkers;
}

function openDetailView(caller, placeId) {
	switch (caller) {
		case "infoWindow":
			placeId = $('#detailView').attr('placeId');
			break;
		case "listView":
			//placeId= ;
			break;
		default:
			break;
	}
	var singleContent;

	if (placeId) {
		url = basePath + "verband/unsere-mitglieder/?tx_browser_pi1%5BshowUid%5D=" + placeId;
		var dataString = 'type=0&tx_browser_pi1[segment]=list';
		/*$.ajax({
		 url: url,
		 type: "GET",
		 //async: false,
		 data: dataString,
		 dataType: "html",
		 success: function(result){
		 singleContent= result;
		 $('#detailView .inner').append(singleContent);
		 $('#detailView').fadeIn('400');
		 $('#overlayDetailHelper').height($(document).height()).fadeIn('400');
		 $('#overlay-close').click(function(){
		 $('#detailView').fadeOut('500');
		 $('#overlayDetailHelper').fadeOut('500');
		 $('#detailView .inner').contents().remove();
		 });
		 }
		 });*/
		$.ajax({
			url: "index.php",
			type: "GET",
			data: {
				'eID': "ajaxMap",
				request: {
					'controller': "Place",
					'pluginName': "Map",
					'action': 'ajaxShow',
					'arguments': {'placeId': placeId}
				}
			},
			dataType: "json",
			success: function (result) {
				singleContent = result;
				$('#detailView .inner').append(singleContent);
				$('#detailView').fadeIn('400');
				$('#overlayDetailHelper').height($(document).height()).fadeIn('400');
				$('#overlay-close').click(function () {
					$('#detailView').fadeOut('500');
					$('#overlayDetailHelper').fadeOut('500');
					$('#detailView .inner').contents().remove();
				});
			}
		});
	}
}

function getSelectedKeys(selector) {
	var selectedNodes = $(selector).dynatree('getSelectedNodes');
	return $.map(selectedNodes, function (node) {
		return parseInt(node.data.key);
	});
}