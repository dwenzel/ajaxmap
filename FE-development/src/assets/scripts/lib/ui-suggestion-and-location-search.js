import $ from 'jquery';
import {ajaxCall} from './utilitys'
import ajaxMap from './ajaxMap'
import places from './ajaxMap-places'

const _ = {
    sendButtonSelector: '.c-location-search button[type="submit"]',
    locationInputSelector: '#locationSearch',
    radialSearchSelectSelector: '#radialSelect',
    getNewPlaces: (search, mapEntry) => {

        const data = {
            search,
            'id': ajaxMap.configData.mapSettings.pageId,
            'api': 'map',
            'action': 'listPlaces2',
            'mapId': mapEntry.id
        };

        places.loadFromData(mapEntry, data)
    },
    setUpAutoSuggest: (mapEntry) => {
        const mapId = mapEntry.id,
            map = mapEntry.googleMap,
            input = $(_.locationInputSelector + mapId)[0];

        const configAutosuggest = mapEntry.settings.autosuggest.options;

        const options = Object.assign({}, {
            types: ['(cities)']
        }, configAutosuggest);

        const autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.bindTo('bounds', map);

        return autocomplete;
    }
};

class RadialSelect {
    constructor(mapEntry) {
        this.$selectEl = $(_.radialSearchSelectSelector + mapEntry.mapId);
    }

    addValToQuery(queryParams) {
        let selectetVal = this.$selectEl.val();

        if (selectetVal === -1) {
            return;
        }

        queryParams.radius = selectetVal;
    }
}

class AutoSuggestSearch {
    constructor(mapEntry) {
        this.autoSuggest = _.setUpAutoSuggest(mapEntry);
    }

    addValToQuery(queryParams) {
        queryParams.location = this.autoSuggest.getPlace();
    }
}

class LocationSearch {
    constructor(mapEntry) {
        this.mapEntry = mapEntry;
        this.mapId = mapEntry.id;

        //the ui Elements
        this.autoSuggestSearch
        this.radialSelect;

        this.$sendButton;
    }

    init() {
        if (this.mapEntry.searchField) {
            this.autoSuggestSearch = new AutoSuggestSearch(this.mapEntry);

        }

        if (this.mapEntry.textSearch) {
            this.radialSelect = new RadialSelect();
        }

        if (this.autoSuggestSearch || this.radialSelect) {
            this.$sendButton = $(_.sendButtonSelector);
            this.$sendButton.show(800);
            this.$sendButton.on('click', this.sendDatas(this))
        }
    }

    sendDatas() {
        const that = this;
        return function() {
            let queryParams = {}

            that.autoSuggestSearch && that.autoSuggestSearch.addValToQuery(queryParams);
            that.radialSelect && that.radialSelect.addValToQuery(queryParams);

            _.getNewPlaces(queryParams, that.mapEntry);
        }
    }
}

export default {
    init: (mapEntry) => {
        new LocationSearch(mapEntry).init();
    }
};
