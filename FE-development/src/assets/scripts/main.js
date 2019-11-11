import $ from 'jquery';
import ajaxMap from './lib/ajaxMap';

import '../../../dist/css/main.css'
import {css} from 'jquery.fancytree/dist/skin-awesome/ui.fancytree.min.css';

import {library, dom} from '@fortawesome/fontawesome-svg-core'

// import folder icons for tree
import {
    faCaretDown as fasCaretDown,
    faCaretRight as fasCaretRight,
    faFile as fasFile,
    faFolder as fasFolder,
    faFolderOpen as fasFolderOpen,
    faSquare as fasSquare

} from '@fortawesome/free-solid-svg-icons';



import {
    faFile as farFile,
    faFolder as farFolder,
    faFolderOpen as farFolderOpen,
    faSquare as farSquare
} from '@fortawesome/free-regular-svg-icons';

// Add icons to library
library.add(
    fasCaretDown,
    fasCaretRight,
    fasFile,
    fasFolder,
    fasFolderOpen,
    fasSquare,
    farFile,
    farFolder,
    farFolderOpen,
    farSquare
);

$(document).ready(function() {

    if (!mapStore || !(mapStore instanceof Array)) {
        console.log(' no mapstore', mapStore)
        return;
    }

    const configData = {
        mapSettings: window.mapSettings,
        mapStore: window.mapStore
    }

    ajaxMap.init(configData);//initialize all maps
})



