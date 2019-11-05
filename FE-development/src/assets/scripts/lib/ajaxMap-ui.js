import $ from 'jquery';


const _ = {
    cache: {
        $filterPlaces:null
    },
    init: () => {
        _.cache.$filterPlaces = $('input[name=filterPlaces]');


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
