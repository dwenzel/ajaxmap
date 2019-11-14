import $ from 'jquery';
import locationSearch from './ui-location-search'

//radialSearch.init(mapEntry);

const _ = {
    selectors: {
        radialSearch: '.c-radial-search'
    },
    cache: {
        $filterPlaces: null
    },
    initByMapEntry: (mapEntry) => {
        locationSearch.init(mapEntry);
    },
    init: () => {
        _.cache.$filterPlaces = $('input[name=filterPlaces]');

        $('body').append('<div id="overlayDetailHelper">');

        _.reset();
    },
    reset: () => {
        _.cache.$filterPlaces.val('');
    }
}

export default {
    init: _.init,
    initByMapEntry: _.initByMapEntry,
    reset: _.reset
}
