import $ from 'jquery';

import detailView from './ajaxMap-places-detail-view';
import {getAddress} from './utilitys';

import markerInfoWindow from './map-marker-info-window';

const _ = {
    cache: {},
    markup: {
        address: (addressJson) => {
            let address =
                '<div class="infoWindowAddress"><div class="infoWindowStreet">' + addressJson.address + '</div>' +
                '<div class="infoWindowZip">' + addressJson.zip + '</div><div class="infoWindowCity">' + addressJson.city + '</div>' +
                '</div>';

        },
        categoryList: (categories) => {
            var list;

            if (categories) {
                list = '<div><ul class="placeCategories">';
                $.each(categories, function() {
                    list += '<li>' + this.title + '</li>';
                });
                list += '</ul></div>';
            }

            return list;
        },
        content: (data) => {
            const place = data.place,
                categoryList = data.categoryList,
                address = data.address;

            let content = '';

            content += (place.title) ? '<h4 class="infoWindowTitle">' + place.title + '</h4>' : '';
            content += (place.icon) ?
                '<img width="120px" class="infoWindowImage" src="' + place.icon + '"/>' : '';

            //'<p class="infoWindowDescription">' + place.description + '</p>';
            content += categoryList ? categoryList : '';
            content += address ? address : '';
            /*
             *  special for ext. browser see below - should be changed to use own content
             */
            content += '<div class="browserHelper"><a class="more detail-view" href="#">mehr</a></div>';

            return content;
        }
    },
    getAddress: (place) => {
        return new Promise(function(resolve, reject) {
            const markup = _.markup.address;

            if (place.address) {

                return resolve(markup(place.address));
            }

            return getAddress(place.uid).then(function(address) {
                place.address = address;

                return resolve(markup(address));
            });
        });
    },


    initCache: () => {
        _.cache.$body = $('body');
        _.cache.$moreDetailView = $('.more.detail-view');

    },
    checkCache: () => {
        if (_.cache.$body) {
            return;
        }

        _.initCache();
    }

};

const infoWindow = {
    /**
     * Renders the info window content for a place
     *
     * @param place
     * @returns {string|*}
     */
    getInfoWindowContent: function(place) {
        return new Promise((resolve, reject) => {
            return _.getAddress(place).then((addressMarkup) => {

                /**
                 * @todo make content rendering configurable, add link for overlay with additional info
                 */
                // build a list of place's categories
                const listMarkup = _.markup.categoryList(place.categories);

                const data = {
                    addressMarkup,
                    listMarkup,
                    place
                };

                return resolve(_.markup.content(data));
            });
        });
    },
    createOnClick: (mapEntry, place) => function() {
        _.checkCache();

        const map = mapEntry.googleMap,
            infoWindow = mapEntry.infoWindow;

        markerInfoWindow.getInfoWindowContent(place).then(function(content) {

            infoWindow.setContent(content);


            //888 should be multiple?
            _.cache.$body.append('<div id="detailView"><a id="overlay-close" style="display: inline;"></a><div class="inner"></div></div>');

            $('#detailView').data('placeId', place.key);

            infoWindow.open(map, this);
        });

        google.maps.event.addListener(infoWindow, 'domready', function() {

            _.cache.$moreDetailView
                .unbind('click')
                .bind('click', (function(event) {
                    event.preventDefault();

                    //TODO: refactor without data-attribute
                    detailView.open('infoWindow', -1);
alert('wrwerwerwerw map-marker-info-window')
                    event.stopPropagation();
                    return false;
                }));
        });
    }
};

export default infoWindow;
