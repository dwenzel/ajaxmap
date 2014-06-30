var basePath; // base path for resources like icons and kml files
jQuery(document).ready(function($) {
	if (!window.location.origin){
		basePath = window.location.protocol+"//"+window.location.host +"/";
	}
	else{
		// for webkit browsers
		basePath = window.location.origin + "/";
	}

	// initialize all maps
	if(typeof mapStore !== "undefined" && mapStore instanceof Array) {
		initAllMaps();
	}
});

function initAllMaps(){
	// init all maps
	for (mapNumber in mapStore){
		initMap(mapNumber);
		//initRegionsSelector(mapNumber);
	};
}
function initAllRegionsSelectors(){
	for (selectorNumber in regionStore){
		initRegionsSelector(selectorNumber);
	}
}
function initMap(mapNumber){
	
	mapEntry = mapStore[mapNumber];
	var map = '';
	
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
	    success: function(response) {
		    	// prepare data
		    	mapContainer = document.getElementById('ajaxMapContainer_Map' + mapEntry.id);
		    	$(mapContainer).height(response.height).width(response.width);
		    	tmpCenter = (response.mapCenter).split(",");
		    	mapCenter = new google.maps.LatLng(parseFloat(tmpCenter[0]), parseFloat(tmpCenter[1]));
		    	
		    	switch(response.type){
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
		    	
		    	if(response.type = "0" && response.mapStyle){
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
		    	mapStore[mapNumber].map = map;
		    	// store regions
		    	mapStore[mapNumber].regions = response.regions;

		    	// info window
		    	mapStore[mapNumber].infoWindow = new google.maps.InfoWindow({
		    		maxWidth: 370,
		    		 
		    	});
		    	// regions selector
		    	if (mapStore[mapNumber].regions.length){
			    	initRegionsSelector(mapNumber);
			    	
			    	// display first region
			    	updateLayer(mapNumber, mapStore[mapNumber].regions[0].uid);
			    	$('select#ajaxMapRegionsSelector' + mapId).change(function () {
			    	    currMapId = this.id.split('ajaxMapRegionsSelector')[1];
			    		updateLayer(getMapNumber(currMapId), parseInt($(this).val()));
			    	  });
		    	}
		    	// location types Selector
		    	if (mapStore[mapNumber].locationTypes.length){
		    		initLocationTypesSelector(mapNumber);
		    	}
		    	
		    	// category tree
		    	renderDynaTree(mapEntry.id);
		    	initPlaces(mapStore[mapNumber].id);
		    	$('body').append('<div id="overlayDetailHelper"></div>');
		    		
	    },
	
	    error: function(error) {
	    	//@todo get localized error message 
	    		alert("Sorry! Unable to load map data.");
	    }
	});
};

function initRegionsSelector(mapNumber){
	// find selector by map id	
	mapId = regionStore[mapNumber].id;

	// get regions for map
	var currRegions = mapStore[mapNumber].regions;
	//remove empty option (since fluid is unable to build a select without option)
	$('select#ajaxMapRegionsSelector' + mapId).children('option').remove();
	for(region in currRegions){
		$("<option/>").val(currRegions[region].uid).text(currRegions[region].title).appendTo("#ajaxMapRegionsSelector" + mapId);
	};
}

function initLocationTypesSelector(mapNumber){
	// find selector by map id	
	mapId = mapStore[mapNumber].id
	var currLocationTypes = mapStore[mapNumber].locationTypes;
	//remove empty option (since fluid doesn't build a select without option)
	for(type in currLocationTypes){
		$("<option/>").val(currLocationTypes[type].key).text(currLocationTypes[type].title).appendTo("#ajaxMapLocationTypesSelector" + mapId);
	};
	// set on change function for location types selector
	$("#ajaxMapLocationTypesSelector" + mapId).change(function(mapNumber){
		mapNumber = getMapNumber(this.id.split("ajaxMapLocationTypesSelector")[1]);
		updatePlaces(mapNumber);
	})
}

function updateLayer(mapNumber, layerId){
	if(mapStore[mapNumber]){
		
		//get map for current map number
		map = mapStore[mapNumber].map;
		
		// get layer for current map number
		mapLayer = mapStore[mapNumber].kmlLayer;
		
		// get data for new layer
		newLayerData = getLayer(mapNumber, layerId);
		layerUrl = basePath + newLayerData.file;
		layerOptions = {
			clickable: newLayerData.clickable,
			preserveViewport: newLayerData.preserveViewport,
			suppressInfoWindows: newLayerData.suppressInfoWindows
		};
		if(mapLayer !=""){
			mapLayer.setMap(null);
		}
		mapLayer = new google.maps.KmlLayer(layerUrl, layerOptions);
		mapLayer.setMap(map);
		mapStore[mapNumber].kmlLayer = mapLayer;
	}
}
function getLayer(mapNumber, layerId){
	if(mapStore[mapNumber] && mapStore[mapNumber].regions.length){
		regions = mapStore[mapNumber].regions;
		return $.grep(regions, function(obj) { return obj.uid === layerId})[0];
	}
}
function getMapNumber(mapId){
	for (var i =0; i< mapStore.length; i++){
		if(mapStore[i].id == mapId){
			return i;
		}
	};
}

function getLocationType(mapNumber, typeId){
	for (var i=0; i<mapStore[mapNumber].locationTypes.length; i++){
		if (mapStore[mapNumber].locationTypes[i].key == typeId){
			return mapStore[mapNumber].locationTypes[i];
		}
	}
}

/*
 * render a dynatree 
 * fetches json data by ajax call
 * @param int > mapId
 */
function renderDynaTree(mapId){
	select = '#ajaxMapCategoryTree' + mapId;
	$(select).dynatree({
		persist: true,
		checkbox: true,
		cookieId: "dynatree" + mapId,
		selectMode: 3,
		onSelect: function(flag, node) {
			var mapNumber = getMapNumber(node.tree.options.cookieId.split('dynatree')[1]);
			var selectedNodes = node.tree.getSelectedNodes();
			var selectedKeys = $.map(selectedNodes, function(node){
					return node.data.key;
				});
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
					'action': "item",
					'arguments': {
						'task': 'loadCategories',
						'mapId': mapId,
						'pid': pageId
					}
				}
			}
		}
	}).data('mapId', mapId);
	
}

/**
 * get locations for a single Map
 * @param mapId 
 */
function initPlaces (mapId) {
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
						'mapId': mapEntry.id,
						'pageId': pageId
	        }
				}
	    },
	    dataType: "json",
	    success: function(result){
		    mapNumber = getMapNumber(mapId);
	    		// store places
		    	mapStore[mapNumber].places = result;
		    	
		    	if(result.length){
			    	//update places (set marker)
			    	updatePlaces(mapNumber);    		
		    	}
	    }
	})
}

/**
 * get address for a single place
 * @param mapId 
 * @param placeId
 * @return json
 */
function getAddress(mapId, placeId) {
	var address;
	$.ajax({
		url: "index.php",
	    type: "GET",
	    //async: false,
	    data: {
	    	'eID': "ajaxMap", 
		    request: {
					'extensionName': "Ajaxmap",
	        'pluginName': "Map",
	        'controller': "Map",
	        'action': "item",
	        'arguments': {
	        	'task': 'getAddress',
	        	'mapId': mapEntry.id,
	        	'placeId': placeId
	        }
				}
	    },
	    dataType: "json",
	    success: function(result){
	    		address= result;
	    }
	})
	return address;
}
/*
 *  update display of places
 *  to be used on initial setup of map and each time when 
 *  selection changes 
 *  (triggerd by changing select field for location type
 *  and selection in dynatree
 *  @todo add filter for regions (overlays from kml files)
 */
function updatePlaces(mapNumber){
	//get map for current map number
		map = mapStore[mapNumber].map;
		mapId = mapStore[mapNumber].id;
		
		// get layer for current map number
		mapPlaces = mapStore[mapNumber].places;
		//get marker for map
		mapMarker = mapStore[mapNumber].marker;
		locationSelectorSelected = 'select#ajaxMapLocationTypesSelector' + mapId + ' option:selected';
		actLocationType = $(locationSelectorSelected).val();
		treeSelect = "#ajaxMapCategoryTree" + mapId;
        var selectedNodes = $(treeSelect).dynatree("getSelectedNodes");
        var selectedKeys = $.map(selectedNodes, function(node){
            return node.data.key;
        });
		// add markers for all places
		for(var i=0,j=mapStore[mapNumber].places.length; i<j; i++){
			
			if (!mapMarker[i]) {
				currType = parseInt(mapPlaces[i].type);
				tmpCenter = mapPlaces[i].geo_coordinates.split(",");
				currLatlng = new google.maps.LatLng(parseFloat(tmpCenter[0]),parseFloat(tmpCenter[1]));
				mapMarker[i] = new google.maps.Marker({
					position: currLatlng,
					map: map,
					title: mapPlaces[i].title,
				});
				if (currType){
					mapMarker[i].setIcon = getLocationType(mapNumber, currType).markerIcon;					
				}
				mapMarker[i].mapNumber = mapNumber;
				mapMarker[i].place = mapPlaces[i];
				// add click function 
				google.maps.event.addListener(mapMarker[i], 'click', function() {
					map = this.getMap();
					infoWindow =mapStore[this.mapNumber].infoWindow;
										 
					/*
					 * @todo move content setup to function and make it configurable
					 * add link for overlay with additional info
					 */
					
					// build a list of place's categories
					if(this.place.category != "0"){
						var list = '<div class"accordion"><h4>Produkte</h4>'+ 
							'<ul class="placeCategories">';
						$.each(this.place.category, function(){
							list += '<li>' + this.title + '</li>';
						})
						list += '</ul></div>';
					}
					
					/*
					 * @todo - wrapping could be done by helper or server
					 *  it should be possible too to configure content of infoWindow by TyoScript 
					 */
					var addressJson;
					// has an address already?
					if(this.place.address){
						addressJson = this.place.address;
					}
					else {
						// fetch address data from server
						addressJson = getAddress(mapStore[mapNumber].id, this.place.uid);
					}
					if (addressJson){
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
					content +=(this.place.title)? '<h4 class="infoWindowTitle">' + this.place.title + '</h4>': "";
					content +=(addressJson.tx_kecontacts_function)?'<div class="infoWindowType">' + addressJson.tx_kecontacts_function + '</div>': "";
					content +=(this.place.icon)? '<img width="120px" class="infoWindowImage" src="' + this.place.icon + '"/>': ""; 
							//'<p class="infoWindowDescription">' + this.place.description + '</p>';
					//content += (list)? list:"";
					content +=(address)? address: "";
					
					/*
					 *  special for ext. browser see below - should be changed to use own content
					 */ 
					content += '<div class="browserHelper"><a class="more" href="#">mehr</a></div>';
					$('body').append('<div id="detailView"><a id="overlay-close" style="display: inline;"></a><div class="inner"></div></div>');
					$('#detailView').attr('placeId', this.place.uid);
					infoWindow.setContent(content);
					google.maps.event.addListener(infoWindow, 'domready', function() {
							// remove old handler and add new
      						$('.more').unbind("click").bind("click", (function(event){
      							event.preventDefault();
      							openDetailView("infoWindow", -1);
      							// prevent double event occurrence
      							event.stopPropagation();
      							//alert('klick');
      						}));
					});
					/***/
					infoWindow.open(map, this);
					/*
					 *  this is kind of a hack to bring ajaxMap and extension browser together
					 *  and should be moved to custom js
					 */
					//ajaxifySingleLinks($('.browserHelper'));
					
				});
			} 
			else {
				var hasSelectedKeys = -1;
				if (selectedKeys == 0){
					hasSelectedKeys = 1
				}
				else {
					$.each(mapMarker[i].place.category, function(){
						hasSelectedKeys = $.inArray(parseInt(this.uid), selectedKeys);
						return (hasSelectedKeys == -1)? true : false;
					});
				}
				
				if ((mapPlaces[i].type == actLocationType || actLocationType==0) && hasSelectedKeys !=-1) {
					mapMarker[i].setMap(map);				}
				else {
					mapMarker[i].setMap(null);
				}
			}
			
		};
		//set marker for map
		mapStore[mapNumber].marker = mapMarker;
}

function openDetailView(caller, placeId){
	switch (caller){
		case "infoWindow":
		placeId = $('#detailView').attr('placeId');
		break;
		case "listView":
		//placeId= ;
		break 
		default : break;
	} 
	var singleContent;
	
	if(placeId){
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
						'action': 'ajaxShow',
						'arguments': {'uid': placeId}
					}
				},
		    dataType: "json",
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
		});
	}
}

