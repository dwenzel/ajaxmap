import {getLocationType} from './map-helpers'
import mapHelpers from './map-helpers'
import infoWindow from './map-marker-info-window'

function create(mapEntry, place) {
    var map = mapEntry.googleMap,
        currType = place.locationType && place.locationType.key,
        currLatlng = mapHelpers.getLatLong(place.geoCoordinates);

    var mapMarker = new google.maps.Marker({
        position: currLatlng,
        map: map,
        title: place.title
    });

    if (currType) {
        const locationTyp=getLocationType(mapEntry, currType)
        mapMarker.setIcon(locationTyp.icon);
    }

    mapMarker.mapNumber = mapEntry.id;
    mapMarker.place = place;

    // add click function
    google.maps.event.addListener(mapMarker, 'click',
        infoWindow.createOnClick(mapEntry, place));

    return mapMarker;
}

const marker = {
    create
};

export default marker;
