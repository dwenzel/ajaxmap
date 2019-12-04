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
    constructor(mapEntry, radius, sendData) {
        this.$select = mapEntry.$sideBar.find('.am-radial-search select');
        this.sendData = sendData;
        this.onSelectRadius();

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

    onSelectRadius() {
        const _this = this;

        // this.$select.one('keyup', _this.sendData);
        this.$select.change(_this.sendData)
    }
}

class AutoSuggestSearch {
    constructor(mapEntry, location, sendDatas) {
        this.mapEntry = mapEntry;
        this.$input = mapEntry.$sideBar.find('.am-location-search input');

        this.autoSuggest = this.setUpAutoSuggest();
        // Set the data fields to return when the user selects a place.
        this.autoSuggest.setFields(
            ['address_components', 'name']);
        location && this.$input.attr('value', location)
        this.onSelectPlace();

        this.sendDatas = sendDatas;
    }

    onSelectPlace() {

        this.autoSuggest.addListener('place_changed',this.sendDatas);
        // _this.$select.one('keyup', _this.sendDatas);
    }

    setUpAutoSuggest() {
        const configAutosuggest = this.mapEntry.settings
            && this.mapEntry.settings.autosuggest
            && this.mapEntry.settings.autosuggest.options;

        const options = Object.assign({},
            {componentRestrictions: {country: "de"}},
            configAutosuggest || {}
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

        this.aa = 0;//debug

    }

    init() {
        this.$sendButton = $(_.sendButtonSelector);

        this.$sendButton.on('click', this.sendDatas());

        if (this.mapEntry.searchField || true/*turn of map settings schow or hide search*/) {
            const search = this.mapEntry.search;
            const radius = search && search.radius;
            const location = search && search.location;

            const sendData = this.sendDatas();
            this.radialSelect = new RadialSelect(this.mapEntry, radius, sendData);
            this.autoSuggestSearch = new AutoSuggestSearch(this.mapEntry, location, sendData);
        }
    }

    sendDatas() {
        const _this = this;

        return function() {
            let search = {};
            _this.radialSelect.addValToQuery(search);
            _this.autoSuggestSearch.addValToQuery(search);

            if (_this.oldSearchData === search) {
                return;
            }

            const data = _this.mapEntry.defaultAjaxData;
            data.search = search;

            /*debug simulate ajax map listplaces
             data.action = _this.aa++ % 2 === 0 ? 'listPlaces2' : 'listPlaces';
             */

            _this.oldSearchData = data.search;
            places.loadFromData(_this.mapEntry, data);
        };
    }
}

export default {
    init: (mapEntry) => {
        new LocationSearch(mapEntry).init();
    }
};
