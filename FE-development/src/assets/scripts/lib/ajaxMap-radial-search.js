import $ from 'jquery';
import treeRenderer  from './fancytree-renderer'
import {inserScriptTag} from './utilitys'

const _ = {
    selector: '.c-radial-search',
    loadApi: () => {
        const key = configData.mapSettings.keys.googleMap,
            url = 'https://maps.googleapis.com/maps/api/js?key=' + key + '&libraries=places';

        return inserScriptTag(url)
    },
    ui: () => {

    },
}

const radialSearch = {

    init: (mapEntry) => {
        loadApi.then(()=>{
            _.ui(mapEntry);

        })


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
