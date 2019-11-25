import $ from 'jquery';
import search from './ui-suggestion-and-location-search';
import {trapFocus} from './ajax-map-trap-focus';


//radialSearch.init(mapEntry);

const _sel = {
    radialSearch: '.am-radial-search',
    sbIsOpen: 'ajax-map--sb-is-open'
};

const _cache = {
    $map: $('.js-ajax-map'),
    $filterPlaces: $('input[name="filterPlaces"]'),
    $amSidebarTrigger: $('.js-ajax-map-sb-trigger'),
    $amSidebar: $('.js-ajax-map-sidebar'),

};

/**
 * TODO desc DEG
 * @param mapEntry
 * some events on map are per map , ajax map could have n- submaps
 * this ist the perMap initaliser
 */
export function initByMapEntry(mapEntry) {
    search.init(mapEntry);
}

/**
 * initialize default ui map
 */
function init() {

    // @TODO DEG wozu benötigen wir das?
    //@eho noch von DWE! ich weiss es nicht-> detail overlay oder so
    //der unrefactored code ist in ajaxMap-places-detail-view.js gesetzt
    $('body').append('<div id="overlayDetailHelper">');

    //TODO:@eho muss alles  per map sein
    resetFilterPlacesInput();
    updateSidebarLayoutSetup();

    // eventhandlers on map
    _bind();
}


/**
 * reset filterPlacesInput
 */
function resetFilterPlacesInput() {
    _cache.$filterPlaces.val('');
}

/**
 * eventhandler on map
 * @private
 */
function _bind() {
    _cache.$amSidebarTrigger.on('click', _toggleSidebar);

    $(document).on('keyup', function(ev) {
        if(ev.keyCode === 27 || ev.which === 27) {
            if(_cache.$amSidebar.find(document.activeElement)) {
                amCloseSidebar();
                _cache.$amSidebarTrigger.focus();
            }
        }
    });
}

/**
 * open ore close sidebar
 * @private
 */
function _toggleSidebar() {
    if (_cache.$map.hasClass(_sel.sbIsOpen)) {
        amCloseSidebar();
    } else {
        amOpenSidebar();
    }
}

/**
 * initialize sidebar scrollwrapper size
 * Todo initialize after fancytree was rendered
 * @private
 */
function updateSidebarLayoutSetup() {
    let sbScrollWrapper = _cache.$amSidebar.find('.am__sb__scroll-wrapper'),
        sbScrollWrapperInner = _cache.$amSidebar.find('.am__sb__scroll-wrapper__inner'),
        mapHeight = _cache.$map.outerHeight(),
        sbFilterHeight = _cache.$amSidebar.find('.am__sb__filter').outerHeight(),
        sbFooterHeight = _cache.$amSidebar.find('.am__sb__footer').outerHeight(),
        sbScrollWrapperHeight;

    sbScrollWrapperHeight = mapHeight - sbFilterHeight - sbFooterHeight;

    if(sbScrollWrapperHeight < 200) {
        _cache.$amSidebar.addClass('scroll-it');
    } else {
        _cache.$amSidebar.removeClass('scroll-it');
        sbScrollWrapper.css('height', sbScrollWrapperHeight);

        if(sbScrollWrapperInner.outerHeight() > sbScrollWrapperHeight) {
            $(sbScrollWrapper).addClass('show-scrollbar');
        } else {
            $(sbScrollWrapper).removeClass('show-scrollbar');
        }
    }
}

/**
 * open sidebar
 * => not private, perhabs we use it in another functions
 */
function amOpenSidebar() {
    _cache.$map.addClass(_sel.sbIsOpen);
    trapFocus(_cache.$amSidebar[0]);
}

/**
 * close sidebar
 * => not private, perhabs we use it in another functions
 */
function amCloseSidebar() {
    _cache.$map.removeClass(_sel.sbIsOpen);
}

export default {
    init,
    initByMapEntry,
    resetFilterPlacesInput
};
