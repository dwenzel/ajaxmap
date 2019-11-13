const _ = {
    addPlaceListMarkup: () => {

        //hold the api for ajaxmap
        window.ajaxMapConfig = {};
        window.ajaxMapConfig.onMarkerClick = function(mapMarker, place) {
            console.log(place.treeNode)//has all domNodes
            //  $('#tablediv').scrollTop($('#' + id).offset().top);
            console.log('miao', place);
        }
    }
};

_.addPlaceListMarkup();



