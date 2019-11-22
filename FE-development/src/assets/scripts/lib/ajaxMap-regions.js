import treeRenderer  from './fancytree-renderer.js'
import layers from './map-layers'

function init(mapEntry) {
const regions= mapEntry.regions;

    if (regions) {
        regions.forEach(function(region) {

            layers.add(region, mapEntry);

            if (region.children.length) {

                region.children.forEach(function(childRegion) {
                    layers.add(childRegion, mapEntry);
                });
            }
        });

        treeRenderer.regions(mapEntry);
    }
}

export default {
    init
};
