function createMarker(mapEntry, mapNumber, place) {
    var map = mapEntry.map,
        currType = place.locationType.key,
        tmpCenter = place.geoCoordinates.split(","),
        currLatlng = new google.maps.LatLng(parseFloat(tmpCenter[0]), parseFloat(tmpCenter[1]));

    var mapMarker = new google.maps.Marker({
        position: currLatlng,
        map: map,
        title: place.title
    });
    if (currType) {
        mapMarker.setIcon(getLocationType(mapEntry, currType).icon);
    }
    mapMarker.mapNumber = mapNumber;
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

};

export default marker;
