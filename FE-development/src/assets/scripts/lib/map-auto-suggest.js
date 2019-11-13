
const _ = {
    inputSelector: '',
}

const autoSuggest = {
    setUp: () => {
        const input = document.getElementById('searchTextField');
        var germanBounds = new google.maps.LatLngBounds(
            google.maps.LatLng(5.98865807458, 47.3024876979),
            google.maps.LatLng(15.0169958839, 54.983104153))

        const options = {
            bounds: germanBounds,//https://gist.github.com/graydon/11198540/revisions
            types: ['establishment']
        };

        const autocomplete = new google.maps.places.Autocomplete(input, options);
    },
    init: (mapEntry) => {
        if (!mapEntry.searchField) {
            return
        }

        autoSuggest.setUp();
    }
};

export default autoSuggest.init;
