import treeRenderer  from './fancytree-renderer'
import places from'./ajaxMap-places'
import $ from 'jquery';


const mapLocationTypes = {
    treeSelector: '#ajaxMapLocationTypesTree',
    ui: function(mapEntry) {
        const currLocationTypes = mapEntry.locationTypes,
            mapId = mapEntry.id;

        //remove empty option (since fluid doesn't build a select without option)
        for (var type in currLocationTypes) {

            $('<option/>').val(currLocationTypes[type].key)
            .text(currLocationTypes[type].title)
            .appendTo($(mapLocationTypes.treeSelector + mapId));
        }

        // set on change function for location types treeSelector
        $(mapLocationTypes.treeSelector + mapId).change(function() {
            places.updatePlaces(mapId);
        });
    },
    init: function(mapEntry, locationTypes) {

        if (locationTypes) {
            mapEntry.locationTypes = locationTypes;

            mapLocationTypes.ui(mapEntry);
            treeRenderer.locationTypes(mapEntry);
        }
    }
}

export default mapLocationTypes;