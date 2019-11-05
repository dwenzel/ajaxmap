import treeRenderer  from './fancytree-renderer'
import places from'./ajaxMap-places'

const _ = {
    selector: '#ajaxMapLocationTypesSelector'
}

const mapLocationTypes = {
    ui: function() {
        const currLocationTypes = this.mapEntry.locationTypes,
            mapId = this.mapEntry;

        //remove empty option (since fluid doesn't build a select without option)
        for (var type in currLocationTypes) {

            $('<option/>').val(currLocationTypes[type].key)
            .text(currLocationTypes[type].title)
            .appendTo($(selector + mapId));
        }

        // set on change function for location types selector
        $(selector + mapId).change(function() {
            places.updatePlaces(mapId);
        });
    },
    init: function(locationTypes) {

        if (locationTypes.length) {
            const mapEntry = this.mapEntry;

            mapEntry.locationTypes = locationTypes;

            mapLocationTypes.ui();
            treeRenderer.locationTypes(mapEntry);
        }
    }
}

export default mapLocationTypes;
