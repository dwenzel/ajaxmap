import $ from 'jquery';

import treeRenderer  from './fancytree-renderer'


const _={
    selector:'.c-radial-search'
}


const radialSearch = {

    ui:()=>{


    },


    init: (mapEntry) => {
        radialSearch.initUi(mapEntry)

        return new Promise(function(resolve, reject) {
            $.ajax({
                url: ajaxMap.ajaxServerPath,
                type: 'GET',
                data: {
                    'id': ajaxMap.configData.mapSettings.pageId,
                    'api': 'map',
                    'action': 'listPlaces',
                    'mapId': mapEntry.id
                },
                dataType: "json",
                success: function(result) {
                    // store places
                    mapEntry.places = result;

                    if (result.length) {
                        treeRenderer.places(mapEntry, result);

                        _.updatePlaces(mapEntry);
                    }
                }
            })
        })
    }
}

export default radialSearch.init;
