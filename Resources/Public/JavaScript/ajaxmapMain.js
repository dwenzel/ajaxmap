var ajaxMapsArray = []; // contains all ajax maps 
var regionsSelectorsStore = []; // contains region selectors - each belonging to one map
var categoryTreeStore =[]; // contains trees - each belonging to one map
var locationTypesSelectorsStore = []; // contains location types - each belonging to one map
var basePath; // base path for resources like icons and kml files
$(document).ready(function() {
	if (!window.location.origin){
		basePath = window.location.protocol+"//"+window.location.host +"/";
	}
	else{
		// for webkit browsers
		basePath = window.location.origin + "/";
	}
	//console.log('ajaxmap');
	// init stores for maps, selectors and trees
	initStores();
	// initialize all maps
	initAllMaps();
	//redefineAjaxifySingleLinks();
});

function initStores(){
	//search for and build an array with all map ids
	$('[name="tx_ajaxmap_map[txAjaxmapStore][mapId]"]').each(function(){
		
		currId = $(this).attr('value');
		markerArr = [];
		//init map store
		ajaxMapsArray.push({
			"id":currId, "map":"", 
			"regions": "", 
			"kmlLayer": "", 
			"categories" : "", 
			"locationTypes": "",
			"infoWindow": "",
			"places": "",
			"marker": markerArr
		});
		
		//init region selector store
		regionsSelectorsStore.push({"id" : currId});
		
		//init category tree store
		categoryTreeStore.push({"id": currId})

		// init location type selector store
		locationTypesSelectorsStore.push({"id": currId, "markerIcon": ""});
	})
}

function initAllMaps(){
	// init all maps
	for (mapNumber in ajaxMapsArray){
		initMap(mapNumber);
		//initRegionsSelector(mapNumber);
	};
}
function initAllRegionsSelectors(){
	for (selectorNumber in regionsSelectorsStore){
		initRegionsSelector(selectorNumber);
	}
}
function initMap(mapNumber){
	
	mapEntry = ajaxMapsArray[mapNumber];
	var map = '';
	
	//get map data
	$.ajax({
	    url: "index.php",
	    type: "GET",   
	    data: {
	    	'eID': "ajaxMap", 
		    'extensionName': "Ajaxmap",
	        'pluginName': "Map",
	        'controllerName': "Map",
	        'actionName': "item",
	        'arguments': {
	        	'task': 'buildMap',
	        	'mapId': mapEntry.id
	        	} 
	    },
	    dataType: "json",
	    success: function(response) {
		    	// prepare data
		    	mapContainer = document.getElementById('ajaxMapContainer_Map' + mapEntry.id);
		    	$(mapContainer).height(response.height).width(response.width);
		    	tmpCenter = (response.center).split(",");
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
		    	
		    	if(response.type = "0"){
		    		mapStyle = $.parseJSON('[' + response.style + ']');
		    	}
		    	
		    	//build map
		    	map = new google.maps.Map(
		    			mapContainer, {
		    				zoom: response.zoom,
		    				center: mapCenter,
		    				mapTypeId: mapType,
		    				styles: mapStyle,
		    	            disableDefaultUI: response.disableDefaultUI
		    				});
		    	
		    	// store map in array
		    	ajaxMapsArray[mapNumber].map = map;
		    	// store regions
		    	ajaxMapsArray[mapNumber].regions = response.regions;
		    	// store location types
		    	ajaxMapsArray[mapNumber].locationTypes = response.locationTypes;
		    	// info window
		    	
		    	ajaxMapsArray[mapNumber].infoWindow = new google.maps.InfoWindow({
		    		maxWidth: 370,
		    		 
		    	});
		    	// regions selector
		    	if (ajaxMapsArray[mapNumber].regions.length){
			    	initRegionsSelector(mapNumber);
			    	
			    	// display first region
			    	updateLayer(mapNumber, ajaxMapsArray[mapNumber].regions[0].uid);
			    	$('select#ajaxMapRegionsSelector' + mapId).change(function () {
			    	    currMapId = this.id.split('ajaxMapRegionsSelector')[1];
			    		updateLayer(getMapNumber(currMapId), parseInt($(this).val()));
			    	  });
		    	}
		    	// location types Selector
		    	if (ajaxMapsArray[mapNumber].locationTypes.length){
		    		initLocationTypesSelector(mapNumber);
		    	}
		    	
		    	// category tree
		    	renderDynaTree(mapEntry.id);
		    	initPlaces(mapId);
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
	mapId = regionsSelectorsStore[mapNumber].id;

	// get regions for map
	var currRegions = ajaxMapsArray[mapNumber].regions;
	//remove empty option (since fluid is unable to build a select without option)
	$('select#ajaxMapRegionsSelector' + mapId).children('option').remove();
	for(region in currRegions){
		$("<option/>").val(currRegions[region].uid).text(currRegions[region].title).appendTo("#ajaxMapRegionsSelector" + mapId);
	};
}

function initLocationTypesSelector(mapNumber){
	// find selector by map id	
	mapId = locationTypesSelectorsStore[mapNumber].id;
	
	var currLocationTypes = ajaxMapsArray[mapNumber].locationTypes;
	//remove empty option (since fluid doesn't build a select without option)
	for(type in currLocationTypes){
		$("<option/>").val(currLocationTypes[type].key).text(currLocationTypes[type].title).appendTo("#ajaxMapLocationTypesSelector" + mapId);
	};
	// set on change function for location types selector
	$("#ajaxMapLocationTypesSelector" + mapId).change(function(mapNumber){
		mapNumber = getMapNumber(this.id.split("ajaxMapLocationTypesSelector")[1]);
		//console.log('change location type', mapNumber);
		updatePlaces(mapNumber);
	})
}

function updateLayer(mapNumber, layerId){
	if(ajaxMapsArray[mapNumber]){
		
		//get map for current map number
		map = ajaxMapsArray[mapNumber].map;
		
		// get layer for current map number
		mapLayer = ajaxMapsArray[mapNumber].kmlLayer;
		
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
		ajaxMapsArray[mapNumber].kmlLayer = mapLayer;
		/*google.maps.event.addListener(mapLayer, "defaultviewport_changed", 
		        function() {console.log('NE', this.getDefaultViewport().getNorthEast(), 'SW', this.getDefaultViewport().getSouthWest())}
		);*/
	}
}
function getLayer(mapNumber, layerId){
	if(ajaxMapsArray[mapNumber] && ajaxMapsArray[mapNumber].regions.length){
		regions = ajaxMapsArray[mapNumber].regions;
		return $.grep(regions, function(obj) { return obj.uid === layerId})[0];
	}
}
function getMapNumber(mapId){
	for (var i =0; i< ajaxMapsArray.length; i++){
		if(ajaxMapsArray[i].id == mapId){
			return i;
		}
	};
}

function getLocationType(mapNumber, typeId){
	for (var i=0; i<ajaxMapsArray[mapNumber].locationTypes.length; i++){
		if (ajaxMapsArray[mapNumber].locationTypes[i].key == typeId){
			return ajaxMapsArray[mapNumber].locationTypes[i];
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
            //debugger;
            //window.console.log("Selected keys: " + selectedKeys);
            
        },
		initAjax: {
			url: "index.php",
		    type: "GET",
		    dataType: "json",
		    data: {
		    		'eID': "ajaxMap", 
			    'extensionName': "Ajaxmap",
		        'pluginName': "Map",
		        'controllerName': "Map",
		        'actionName': "item",
		        'arguments': {
		        	'task': 'loadCategories',
		        	'mapId': mapId
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
		    'extensionName': "Ajaxmap",
	        'pluginName': "Map",
	        'controllerName': "Map",
	        'actionName': "item",
	        'arguments': {
	        	'task': 'loadPlaces',
	        	'mapId': mapEntry.id
	        	} 
	    },
	    dataType: "json",
	    success: function(result){
		    //	console.log(result);
		    mapNumber = getMapNumber(mapId);
	    		// store places
		    	ajaxMapsArray[mapNumber].places = result;
		    	
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
	    async: false,
	    data: {
	    	'eID': "ajaxMap", 
		    'extensionName': "Ajaxmap",
	        'pluginName': "Map",
	        'controllerName': "Map",
	        'actionName': "item",
	        'arguments': {
	        	'task': 'getAddress',
	        	'mapId': mapEntry.id,
	        	'placeId': placeId
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
		map = ajaxMapsArray[mapNumber].map;
		mapId = ajaxMapsArray[mapNumber].id;
		
		// get layer for current map number
		mapPlaces = ajaxMapsArray[mapNumber].places;
		//console.log(mapPlaces);
		//get marker for map
		mapMarker = ajaxMapsArray[mapNumber].marker;
		locationSelectorSelected = 'select#ajaxMapLocationTypesSelector' + mapId + ' option:selected';
		actLocationType = $(locationSelectorSelected).val();
		//console.log('activ LocationType ',actLocationType);
		treeSelect = "#ajaxMapCategoryTree" + mapId;
        var selectedNodes = $(treeSelect).dynatree("getSelectedNodes");
        var selectedKeys = $.map(selectedNodes, function(node){
            return node.data.key;
        });
		// add markers for all places
		for(var i=0,j=ajaxMapsArray[mapNumber].places.length; i<j; i++){
			
			if (!mapMarker[i]) {
				currType = parseInt(mapPlaces[i].type);
				if (currType){
					currIcon = getLocationType(mapNumber, currType).markerIcon;					
				}
				tmpCenter = mapPlaces[i].geo_coordinates.split(",");
				currLatlng = new google.maps.LatLng(parseFloat(tmpCenter[0]),parseFloat(tmpCenter[1]));
				mapMarker[i] = new google.maps.Marker({
					position: currLatlng,
					map: map,
					title: mapPlaces[i].title,
					icon: currIcon
				});
				mapMarker[i].mapNumber = mapNumber;
				mapMarker[i].place = mapPlaces[i];
				// add click function 
				google.maps.event.addListener(mapMarker[i], 'click', function() {
					map = this.getMap();
					infoWindow =ajaxMapsArray[this.mapNumber].infoWindow;
										 
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
						addressJson = getAddress(ajaxMapsArray[mapNumber].id, this.place.uid);
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
			 console.log('hat marker', mapPlaces[i].type);	
			}
			
		};
		//set marker for map
		ajaxMapsArray[mapNumber].marker = mapMarker;
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
		$.ajax({
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
		});		
	}
}

/*
 * redefine function from extension browser
 * 
 */
/*function redefineAjaxifySingleLinks () {
	if (window['ajaxifySingleLinks']){
		window['ajaxifySingleLinks']= function  () {
		  //alert('redefined!');
		  console.log('redefined');
		}
	}
}
function split_querystring_to_object(query) {  
	var queryString = {};  
	query.split("?").pop().split("&").forEach(function (prop) {  
		var item = prop.split("=");  
		queryString[item.shift()] = item.shift();                                                                                                                                                                                                                                              
	});  
	return queryString;  
}
*/