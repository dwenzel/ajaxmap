const _ = {
    inputSelector: '',
}

const autoSuggest = {
    setUp: () => {
        var input = document.getElementById('searchTextField');

        var options = {
            bounds: defaultBounds,
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
