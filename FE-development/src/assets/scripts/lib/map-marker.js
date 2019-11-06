import {getLocationType} from './map-helpers'

function create(mapEntry, place) {
    var map = mapEntry.googleMap,
        currType = place.locationType.key,
        tmpCenter = place.geoCoordinates.split(','),
        currLatlng = new google.maps.LatLng(parseFloat(tmpCenter[0]), parseFloat(tmpCenter[1]));

    var mapMarker = new google.maps.Marker({
        position: currLatlng,
        map: map,
        title: place.title
    });

    console.log(mapEntry,'map', map)
    console.log('########')

    if (currType) {
        const locationTyp=getLocationType(mapEntry, currType)
        mapMarker.setIcon(locationTyp.icon);
    }

    mapMarker.mapNumber = mapEntry.id;
    mapMarker.place = place;
    // add click function
    google.maps.event.addListener(mapMarker, 'click', function() {
        var map = this.getMap(),
            infoWindow = mapStore[this.mapNumber].infoWindow,
            content = ajaxMap.getInfoWindowContent(this.place);



        infoWindow.setContent(content);
        google.maps.event.addListener(infoWindow, 'domready', function() {
            $('.more.detail-view').unbind("click").bind("click", (function(event) {
                event.preventDefault();
                ajaxMap.openDetailView(
                    "infoWindow", -1);
                event.stopPropagation();
            }));
        });
        infoWindow.open(map, this);

    });

    return mapMarker;
}

const marker = {
    create
};

export default marker;
