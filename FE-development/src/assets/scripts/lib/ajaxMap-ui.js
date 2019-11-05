import $ from 'jquery';


const _ = {
    cache: {
        $filterPlaces:null
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
    reset: _.reset
}
