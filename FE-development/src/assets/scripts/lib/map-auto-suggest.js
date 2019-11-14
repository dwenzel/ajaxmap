import $ from 'jquery';


const _ = {
    inputSelector: '#suggest',
}

const autoSuggest = {
    setUp: (map) => {
        const input = $(_.inputSelector)[0];

        var germanBounds = new google.maps.LatLngBounds(
            google.maps.LatLng(5.98865807458, 47.3024876979),
            google.maps.LatLng(15.0169958839, 54.983104153))



        const options = {
            bounds: germanBounds,//https://gist.github.com/graydon/11198540/revisions,
            strictBounds:true,
            types: ['(cities)'],
            componentRestrictions: {country: 'de'}
        };

        const autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.bindTo('bounds', map);

    },
    init: (mapEntry) => {

        if (!mapEntry.searchField) {
            return
        }
console.log(mapEntry.googleMap)
        autoSuggest.setUp(mapEntry.googleMap);
    }
};

export default autoSuggest.init;
