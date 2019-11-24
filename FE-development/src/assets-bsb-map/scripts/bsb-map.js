const _ = {
    BSB_ajaxMapConfigData: () => {
return;
        //hold the api for ajaxmap
        window.ajaxMapConfig = {};

        //function will be fired by clicking on a marker
        //gets the mapEntry and the place
        window.ajaxMapConfig.onMarkerClick = function(mapEntry, place) {
            const treeNode = place.placeInstance.treeNode//has all domNodes

            console.log(treeNode);
            //  $('#tablediv').scrollTop($('#' + id).offset().top);
        }

        //function to render the markup
        //gets the data
        window.ajaxMapConfig.renderPlaceTreesItem = (data) => {
            // const mapId = data.source.mapId

            //  console.log(data.node.data);

            let markup = 'hello' + data.node.data.address;

            return markup;
        }

    }
};

_.BSB_ajaxMapConfigData();



