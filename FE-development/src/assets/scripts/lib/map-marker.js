import {getLocationType} from './map-helpers';
import mapHelpers from './map-helpers';
import infoWindow from './map-marker-info-window';
import $ from 'jquery';
import {amOpenSidebar} from './ui';

let _zIndexCnt = 0;

function addMarkerClickFunction(mapEntry, place, marker) {
    return function() {

        setActiveMarkerToNormal(mapEntry);
        if (/*window.ajaxMapConfig && the error is your friend */window.ajaxMapConfig.onMarkerClick) {
            window.ajaxMapConfig.onMarkerClick(mapEntry, place);
        }

        marker.setActive();
        amOpenSidebar();

        /** for debug info win
         mapEntry.activeMarker && mapEntry.activeMarker.setNormal();
         infoWindow.createOnClick();

         **/
    };
}

function iterateZindex(marker) {
    marker.setZIndex(google.maps.Marker.MAX_ZINDEX + _zIndexCnt++);
}

function create(mapEntry, place) {
    var map = mapEntry.googleMap,
        currType = place.locationType && place.locationType.key,
        currLatlng = mapHelpers.getLatLong(place.geoCoordinates);

    if (currType) {
        var mapMarker = new google.maps.Marker({
            position: currLatlng,
            map: map,
            title: place.title
        });

        const locationTyp = getLocationType(mapEntry, currType);

        mapMarker.icons = {
            icon: locationTyp.icon,
            iconActive: locationTyp.iconActive
        };

        mapMarker.setActive = function() {
            mapEntry.activeMarker = mapMarker;
            mapMarker.setIcon(mapMarker.icons.iconActive);
            iterateZindex(mapMarker);
            // console.log('setActive')
        };

        mapMarker.setNormal = function() {
            mapEntry.activeMarker = null;
            mapMarker.setIcon(mapMarker.icons.icon);

            // console.log('++++++++++','setNormal')
        };

        mapMarker.setNormal();
    }

    mapMarker.mapNumber = mapEntry.id;
    mapMarker.place = place;

    // add click function
    const clickFunction = addMarkerClickFunction(mapEntry, place, mapMarker);
    google.maps.event.addListener(mapMarker, 'click', clickFunction);

    // add dbl-click
    google.maps.event.addListener(marker, 'dblclick', function(e) {
        window.open(place.placeData.address.profileLink, '_blank');
    });

    return mapMarker;
}

/*object to handle the marker-visibility of old places.
thr updates maker iterate over all registered places, so tht this with setActive to false,
will just nullify the icon but not have to rebuild
 */
function TurnOfOnBuffer(mapEntry) {
    this.buffer = (mapEntry.places||[]).reduce((prev, oldPlace) => {
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

function setActiveMarkerToNormal(mapEntry) {
    if (mapEntry.activeMarker) {
        mapEntry.activeMarker.setNormal();
    }
}

const marker = {
    create,
    TurnOfOnBuffer,
    setActiveMarkerToNormal,
    iterateZindex
};

export default marker;
