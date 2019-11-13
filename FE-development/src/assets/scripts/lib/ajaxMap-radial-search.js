import $ from 'jquery';
import treeRenderer  from './fancytree-renderer'
import {inserScriptTag} from './utilitys'

import ajaxMap from './ajaxMap'

const _ = {
    apiAlreadyloaded: false,
    selector: '.c-radial-search',
    loadApi: () => {
        if (_.apiAlreadyloaded) {
            return Promise.resolve()
        }

        _.apiAlreadyloaded = true;
        console.log('ajaxMap.configData.mapSettings.keys', ajaxMap.configData.mapSettings.keys)
        const key = ajaxMap.configData.mapSettings.keys.googlePlaces;

        const url = 'https://maps.googleapis.com/maps/api/js?key=' + key + '&libraries=places';

        return inserScriptTag(url)
    },
    ui: () => {

    },
}

const radialSearch = {
    init: (mapEntry) => {
        // alert(mapEntry.settings.radiusSearch)

        if (!mapEntry.radiusSearch) {
            return
        }

       /* _.loadApi().then(() => {
            _.ui(mapEntry);

            return;
        }, console.error)*/

    }
}

export default radialSearch;
