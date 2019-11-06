const _={
    getBasePath: () => {
        if(_.basePath){
            return _.basePath;
        }

        const basePath = window.location.protocol + "//" + window.location.host + "/";
        const webkitPath = window.location.origin + "/";

        _.basePath = !window.location.origin ? basePath : webkitPath;

        return _.basePath;
    },
}

const layers = {
    update: function(mapEntry, layerIds) {
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
    add: function(newLayerData, mapEntry) {
        //        88
        if (!mapEntry.layers[newLayerData.key]) {

            var layerUrl = _.getBasePath() + newLayerData.file,

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
        const layerUrl = _.getBasePath() + layerData.file;

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
