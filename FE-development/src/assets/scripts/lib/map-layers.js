const layers = {
    update: function(mapNumber, layerIds) {
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
    },
    add: function(newLayerData,mapEntry) {
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
    },
    addStatic: function(layerData, mapEntry) {
        const layerUrl = _basePath + layerData.file;

        const layerOptions = {
            clickable: layerData.clickable,
            preserveViewport: layerData.preserveViewport,
            suppressInfoWindows: layerData.suppressInfoWindows
        };

        const newLayer = new google.maps.KmlLayer(layerUrl, layerOptions);
        newLayer.setMap(mapEntry.map);
    },

    buildStatic: function(mapEntry) {
        const staticLayers = mapEntry.settings.staticLayers

        if (staticLayers) {
            staticLayers.forEach(function(staticLayer) {

                layers.addStatic(staticLayer, mapEntry);

                if (staticLayer.children.length) {
                    staticLayer.children.forEach(function(childRegion) {

                        layers.addStatic(childRegion, mapEntry);
                    });
                }
            });
        }
    }
};

export default layers;
