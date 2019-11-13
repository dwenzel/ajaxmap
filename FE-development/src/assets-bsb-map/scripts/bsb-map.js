const _ = {
    addPlaceListMarkup: () => {

        //hold the api for ajaxmap
        window.ajaxMapConfig = {};


        //function will be fired by clicking on a marker
        //gets the mapEntry and the place
        window.ajaxMapConfig.onMarkerClick = function(mapEntry, place) {
           const treeNode = place.treeNode//has all domNodes
            //  $('#tablediv').scrollTop($('#' + id).offset().top);
        }

        //function to render the markup
        //gets the data
        window.ajaxMapConfig.renderPlaceTreesItem = (data) => {
           // const mapId = data.source.mapId

            console.log(data.node.data);

            let markup = data.node.data.address

            return markup;
        }

    }
};

_.addPlaceListMarkup();



