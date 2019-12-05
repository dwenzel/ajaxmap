import $ from 'jquery';
import search from './ui-search';
import {trapFocus} from './ajax-map-trap-focus';

const _sel = {
    radialSearch: '.am-radial-search',
    sbIsOpen: 'ajax-map--sb-is-open'
};

const _cache = {
    $map: $('.js-ajax-map'),
    $filterPlaces: $('input[name="filterPlaces"]'),
    $amSidebarTrigger: $('.js-ajax-map-sb-trigger'),
    $amSidebar: $('.js-ajax-map-sidebar'),
    $amResultList: $('.am-results__list'),
    $amFilter: $('.am__sb__filter'),
    $generateDropdowns: $('.js-am-generate-dropdown')
};

/**
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

    // generate dropdown
    if (_cache.$generateDropdowns) {
        _cache.$generateDropdowns.each(function(i, el) {
            _initGenerateDropdown(el);
        });
    }
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
        if (ev.keyCode === 27 || ev.which === 27) {
            if (_cache.$amSidebar.find(document.activeElement)) {
                amCloseSidebar();
                _cache.$amSidebarTrigger.focus();
            }
        }
    });

    $(window).on('resize', updateSidebarLayoutSetup);
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
        mapHeight = _cache.$map.outerHeight(),
        sbFilterHeight = _cache.$amSidebar.find('.am__sb__filter').outerHeight(),
        sbFooterHeight = _cache.$amSidebar.find('.am__sb__footer').outerHeight(),
        sbScrollWrapperHeight;


    sbScrollWrapperHeight = mapHeight - sbFilterHeight - sbFooterHeight;
    sbScrollWrapper.css('height', sbScrollWrapperHeight);
}

/**
 * generate native select options
 * trigger selecetion on fancytree list
 * @param dropdown (jso)
 * @private
 */
function _initGenerateDropdown(dropdown) {
    let referenceList = $(dropdown).attr('data-list'),
        select = $(dropdown).find('select'),
        $list = $('#' + referenceList);

    $('#' + referenceList).on('renderLocationType', function() {
        let listItems = $list.find('li');

        if ($list) {
            listItems.each(function(i, item) {
                let title = $(item).find('.fancytree-title').text(),
                    option = '<option>' + title + '</option>';

                // append option to select
                $(select).append(option);
            });
        }

        // if selection change trigger on fancytree list
        $(select).on('change', function() {
            // -1 because of invaid option "choose option"
            let selIndex = $(this)[0].selectedIndex - 1;

            if (selIndex >= 0) {
                $(listItems[selIndex]).find('.fancytree-checkbox').trigger('click');
            } else {
                _resetFancyTreeList($list)
            }
        });
    });
}

/**
 * reset fancy tree filter option
 * @param $list (jQuery Object)
 * @private
 */
function _resetFancyTreeList($list) {
    let activeItems = $list.find('[aria-selected="true"]');

    activeItems.each(function(i, item) {
        $(item).find('.fancytree-checkbox').trigger('click');
    });
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
