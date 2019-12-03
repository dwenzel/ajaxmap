import {getLocationType} from './map-helpers';
import mapHelpers from './map-helpers';
import infoWindow from './map-marker-info-window';
import $ from 'jquery';
function addMarkerClickFunction(mapEntry, place) {
    return function() {

        if (/*window.ajaxMapConfig && the error is your friend */window.ajaxMapConfig.onMarkerClick) {
            window.ajaxMapConfig.onMarkerClick(mapEntry, place, $);
        }

        infoWindow.createOnClick();
    };
}

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
        const locationTyp = getLocationType(mapEntry, currType);
        mapMarker.setIcon(locationTyp.markerIcon);
    }

    mapMarker.mapNumber = mapEntry.id;
    mapMarker.place = place;

    // add click function
    const clickFunction = addMarkerClickFunction(mapEntry, place);

    google.maps.event.addListener(mapMarker, 'click', clickFunction);

    return mapMarker;
}

/*object to handle old PLaces not in new one includet*/
function TurnOfOnBuffer(mapEntry) {
    this.buffer = mapEntry.places.reduce((prev, oldPlace) => {
        prev[oldPlace.key] = oldPlace.placeInstance;
        return prev;
    }, {});

    this.evaluate = function() {
        for (var i in  this.buffer) {
            if (this.buffer[i]) {
                this.buffer[i].setActive(false);
            }
        }
    };
}

const marker = {
    create,
    TurnOfOnBuffer
};

export default marker;
