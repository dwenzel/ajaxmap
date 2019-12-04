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
    constructor(mapEntry, radius) {
        this.$select = mapEntry.$sideBar.find('.am-radial-search select');

        if (radius) {
            const $findEl = this.$select.find('[value="' + radius + '"]');
            $findEl.attr("selected", true);
        }
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
    constructor(mapEntry, location) {
        this.mapEntry = mapEntry;
        this.$input = mapEntry.$sideBar.find('.am-location-search input');

        this.autoSuggest = this.setUpAutoSuggest();
        // Set the data fields to return when the user selects a place.
        this.autoSuggest.setFields(
            ['address_components', 'geometry', 'icon', 'name']);
        location && this.$input.attr('value', location)

    }

    setUpAutoSuggest() {
        const configAutosuggest = this.mapEntry.settings.autosuggest.options;



        const options = Object.assign(
            {}, {"country": 'de'},{

                //types: ['(cities)']
            }, configAutosuggest
        );

        const autocomplete = new google.maps.places.Autocomplete(this.$input[0], options);
        autocomplete.bindTo('bounds', this.mapEntry.googleMap);

        return autocomplete;
    }

    addValToQuery(search) {
        const placeData = this.$input.val();//this.autoSuggest.getPlace();
        //alert(this.$input.val())
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
        this.$sendButton = $(_.sendButtonSelector);
        this.$sendButton.on('click', this.sendDatas());

        if (this.mapEntry.searchField) {
            const search = this.mapEntry.search;
            const radius = search.radius;
            const location = search.location;

            radius && (this.radialSelect = new RadialSelect(this.mapEntry, search.radius));
            location && (this.autoSuggestSearch = new AutoSuggestSearch(this.mapEntry, search.location));
        }
    }

    sendDatas() {
        const that = this;

        return function(event) {
            event.preventDefault();

            let search = {};
            that.radialSelect.addValToQuery(search);
            that.autoSuggestSearch.addValToQuery(search);

            search = JSON.stringify(search);

            if (that.oldSearchData === search) {
                return;
            }

            const data = that.mapEntry.defaultAjaxData;
            data.search = search;

            /*debug simulate ajax map listplaces
            data.action = that.aa++ % 2 === 0 ? 'listPlaces2' : 'listPlaces';
             */

            that.oldSearchData = data.search;
            places.loadFromData(that.mapEntry, data);
        };
    }
}

export default {
    init: (mapEntry) => {
        new LocationSearch(mapEntry).init();
    }
};
