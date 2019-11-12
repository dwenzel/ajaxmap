import $ from 'jquery';
import treeRenderer  from './fancytree-renderer'
import {inserScriptTag} from './utilitys'

import ajaxMap from './ajaxMap'

const _ = {
    apiAlreadyloaded: false,
    selector: '.c-radial-search',
    loadApi: () => {
        //todo generate places api key
        return Promise.resolve();

        if (_.apiAlreadyloaded) {

            return Promise.reject('googlemap places-api already Loaded')
        }
        _.apiAlreadyloaded = true;
        const key = ajaxMap.configData.mapSettings.keys.googleMap,
            url = 'https://maps.googleapis.com/maps/api/js?key=' + key + '&libraries=places';

        return inserScriptTag(url)
    },
    ui: () => {

    },
}

const radialSearch = {
    init: (mapEntry) => {

        _.loadApi().then(() => {

            //   _.ui(mapEntry);
            return;
        })

    }
}

export default radialSearch;
