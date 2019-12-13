import $ from 'jquery';
import places from './ajaxMap-places';
import treeRenderer from './fancytree-renderer';
import markers from './map-marker';

const _ = {
    sendButtonSelector: '.am-location-search button[type="submit"]',
    locationInputSelector: '#locationSearch',
    radialSearchSelectSelector: '#radialSelect',

    checkInputVal: (inputVal) => {
        inputVal = inputVal.trim();

        if (inputVal.length) {
            return true;
        }

        return false;
    }
};

class RadialSelect {
    constructor(mapEntry, radius, sendData) {
        this.$select = mapEntry.$sideBar.find('.am-radial-search select');
        this.sendData = sendData;
        this.onSelectRadius();

        if (radius) {

            const $findEl = this.$select.find('[value="' + radius + '"]');
            $findEl.attr('selected', true);
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
        this.$select.change(_this.sendData);
    }

    reset() {
        this.$select.val('0');
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
        location && this.$input.attr('value', location);
        this.onSelectPlace();

        this.sendDatas = sendDatas;
    }

    onSelectPlace() {
        let _this = this;

        this.autoSuggest.addListener('place_changed', () => {
            const newPlace = _this.autoSuggest.getPlace();
            let $input = _this.$input,
                isMessage = $(this.$input)
                    .closest('.am-form__group')
                    .find('.am-form__description');

            if (typeof newPlace.address_components === 'undefined') {
                let firstItem = document.querySelectorAll('.pac-item')[0],
                    firstItemContent,
                    firstValues;

                // if first item
                if (firstItem) {
                    // delete error message
                    deletePlacesAutoSuggestError($input);

                    firstItemContent = firstItem.children,
                        firstValues = [];

                    // get values
                    for (var i = 0, len = firstItemContent.length; i < len; i++) {
                        if (firstItemContent[i].innerText) {
                            firstValues.push(firstItemContent[i].innerText);
                        }
                    }

                    // set value and submit form
                    $input.val(firstValues.join(', '));
                    this.sendDatas();
                } else {
                    // if any item show error message
                    showPlacesAutoSuggestError($input);
                }
            } else {
                // delete error message
                deletePlacesAutoSuggestError($input);

                // is all fine, submit form
                this.sendDatas();
            }

            /*if (!newPlace) {
                return;
            }

            if (Object.keys(newPlace).length <= 1) {
                return;
            }

            this.sendDatas();*/

            /**
             * build and show error message
             */
            function showPlacesAutoSuggestError($input) {
                let $msg,
                    $inputGroup = $input.closest('.am-form__group');

                // delete error message
                deletePlacesAutoSuggestError($input);

                $msg = $('<span>Für Ihre Eingabe wurde nichts gefunden.</span>');
                $msg.addClass('am-form__description');
                $msg.addClass('u-typo:s');
                $msg.attr('id', 'input-text-consultant-stopper-description');

                $inputGroup.addClass('is-error');
                $inputGroup.append($msg);
            }
        });

        // importent deactivate native supmit per enter
        _this.$input.on('keypress', function(e) {
            if (e.which == 13 || e.key == 13) {
                e.preventDefault();
            }
        });

        // delete error message
        // if places autosuggest has children,
        // or value is empty
        _this.$input.on('keyup', function(e) {
            if (e.target.value === '' || document.querySelectorAll('.pac-item').length > 0) {
                deletePlacesAutoSuggestError(_this.$input);
            }
        });

        /**
         * delete error message
         */
        function deletePlacesAutoSuggestError($input) {
            let $inputGroup = $input.closest('.am-form__group'),
                isMessage = $inputGroup.find('.am-form__description');

            $inputGroup.removeClass('is-error');

            // remove massage if user choose place onselect
            if (isMessage) {
                isMessage.remove();
            }
        }
    }

    setUpAutoSuggest() {
        const configAutosuggest = this.mapEntry.settings
            && this.mapEntry.settings.autosuggest
            && this.mapEntry.settings.autosuggest.options;

        const options = Object.assign({},
            {componentRestrictions: {country: 'de'}},
            configAutosuggest || {}
        );

        const autocomplete = new google.maps.places.Autocomplete(this.$input[0], options);
        autocomplete.bindTo('bounds', this.mapEntry.googleMap);

        return autocomplete;
    }

    addValToQuery(search) {
        const placeData = this.$input.val(); //this.autoSuggest.getPlace();
        const inputVal = _.checkInputVal(this.$input.val());

        if (!placeData || !inputVal) {
            return;
        }

        search.location = placeData;
    }

    reset() {
        this.autoSuggest.set('place', null);
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

        mapEntry.radialSelect = this.radialSelect;
    }

    init() {
        this.$sendButton = $(_.sendButtonSelector);
        this.$sendButton.on('click', this.sendDatas());

        const $form = this.mapEntry.$sideBar.find('.am-form'),
            $resetButton = this.mapEntry.$sideBar.find('.am-link'),
            _this = this;

        $resetButton.on('click', (e) => {
            e.preventDefault();

            const data = _this.mapEntry.defaultAjaxData;
            _this.mapEntry.afterInit = false;
            places.loadFromData(_this.mapEntry, data);

            _this.autoSuggestSearch.reset();

            markers.setActiveMarkerToNormal(_this.mapEntry);
            treeRenderer.clearSelected(_this.mapEntry.placesTree);
        });

        // TODO DEG this.mapEntry.searchField || true <= this is not a nice condition
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
            // alert()
            _this.radialSelect.addValToQuery(search);
            _this.autoSuggestSearch.addValToQuery(search);

            if (_this.oldSearchData === search) {
                return;
            }

            const data = Object.assign({}, _this.mapEntry.defaultAjaxData);
            data.search = search;

            /*debug simulate ajax map listplaces
             data.action = _this.aa++ % 2 === 0 ? 'listPlaces2' : 'listPlaces';
             */
            treeRenderer.clearSelected(_this.mapEntry.placesTree);
            _this.oldSearchData = data.search;
            places.loadFromData(_this.mapEntry, data);
        };
    }
}

class Spinner {
    constructor(mapEntry) {
        this.$mapWrapper = mapEntry.$map.closest('.js-ajax-map');

        const $resultWrapper = this.$mapWrapper.find('.am__sb__scroll-wrapper');
        const $spinner = $('<div class="am-loader">' +
            '<div class="am-loader__spinner"></div>' +
            '<span>Daten werden geladen</span>' +
            '</div>');

        $resultWrapper.append($spinner);
    }

    activate() {
        this.$mapWrapper.addClass('am-loading');
    }

    disable() {
        this.$mapWrapper.removeClass('am-loading');
    }

}

export default {
    init: (mapEntry) => {
        new LocationSearch(mapEntry).init();
        mapEntry.spinner = new Spinner(mapEntry);
    }
};


