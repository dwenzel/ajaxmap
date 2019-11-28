import $ from 'jquery';
import {ajaxCall} from './utilitys';
import ajaxMap from './ajaxMap';
import places from './ajaxMap-places';

const _ = {
    sendButtonSelector: '.am-location-search button[type="submit"]',
    locationInputSelector: '#locationSearch',
    radialSearchSelectSelector: '#radialSelect',

    checkInputVal: (inputVal) => {
        inputVal = inputVal.trim();

        if (inputVal.length) {
            return true;
        }

        return false
    }
};

class RadialSelect {
    constructor(mapEntry) {
        this.$select = mapEntry.$sideBar.find('.am-radial-search select');
    }

    addValToQuery(search) {
        let selectetVal = this.$select.val();

        if (!selectetVal) {
            return;
        }

        search.radius = selectetVal;
    }
}

class AutoSuggestSearch {
    constructor(mapEntry) {
        this.mapEntry = mapEntry;
        this.$input = mapEntry.$sideBar.find('.am-location-search input');

        this.autoSuggest = this.setUpAutoSuggest();
    }

    setUpAutoSuggest() {
        const configAutosuggest = this.mapEntry.settings.autosuggest.options;

        const options = Object.assign(
            {}, {
                types: ['(cities)']
            }, configAutosuggest
        );

        const autocomplete = new google.maps.places.Autocomplete(this.$input[0], options);
        autocomplete.bindTo('bounds', this.mapEntry.googleMap);

        return autocomplete;
    }

    addValToQuery(search) {
        const placeData = this.autoSuggest.getPlace();

        const inputVal = _.checkInputVal(this.$input.val());

        if (!placeData || !inputVal) {
            return;
        }

        search.location = placeData;
    }
}

class LocationSearch {
    constructor(mapEntry) {
        this.mapEntry = mapEntry;
        this.mapId = mapEntry.id;

        this.oldSearchData = {};

        //the ui Elements
        this.autoSuggestSearch;
        this.radialSelect;

        this.$sendButton;

        this.aa = 0;//debug
    }

    init() {
        /*  if (this.mapEntry.searchField) {
         this.autoSuggestSearch = new AutoSuggestSearch(this.mapEntry);
         }*/
        if (!this.mapEntry.radiusSearch) {
            return
        }

        this.radialSelect = new RadialSelect(this.mapEntry);
        this.autoSuggestSearch = new AutoSuggestSearch(this.mapEntry);

        this.$sendButton = $(_.sendButtonSelector);
        this.$sendButton.on('click', this.sendDatas());

        /*
         if (this.autoSuggestSearch || this.radialSelect) {
         this.$sendButton = $(_.sendButtonSelector);
         this.$sendButton.on('click', this.sendDatas(this));
         }*/
    }

    sendDatas() {
        const that = this;
        return function(event) {
            event.preventDefault();

            /* queryParams.search={
             raduis,
             location
             }*/

            //  that.autoSuggestSearch && that.autoSuggestSearch.addValToQuery(queryParams);
            //    that.radialSelect && that.radialSelect.addValToQuery(queryParams);

            let search = {};
            that.radialSelect.addValToQuery(search)
            that.autoSuggestSearch.addValToQuery(search);

            if (JSON.stringify(that.oldSearchData) === JSON.stringify(search)) {
                return;
            }

            /*  if (!Object.keys(search).length) {
             alert('nothing selected');
             return;
             }*/

//            console.log('#++#+#+#+#+#+', search)

            var action = that.aa++ % 2 === 0 ? 'listPlaces2' : 'listPlaces';

            const data = {
                search: JSON.stringify(search),
                'id': ajaxMap.configData.mapSettings.pageId,
                'api': 'map',
                'action': action,//'listPlaces2',
                'mapId': that.mapEntry.id
            };

            that.oldSearchData = search;
            places.loadFromData(that.mapEntry, data);
        };
    }
}

export default {
    init: (mapEntry) => {
        new LocationSearch(mapEntry).init();
    }
};
