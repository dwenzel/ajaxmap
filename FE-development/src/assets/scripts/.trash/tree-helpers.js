/**
 * Created by d.eggermann on 30.10.19.
 */

import $ from 'jquery';
import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';


import ajaxMap from './ajaxMap'

/**
 * Renders a fancyTree
 * fetches json data by ajax call
 *
 * @param select Selector for node
 * @param action Ajax eID action name
 * @param mapId
 * @param settings Optional settings
 */
export function renderTreeAjax ({select, action, mapId, settings}) {

    var localSettings = {
        checkbox: true,
        cookieId: "fancyTree" + action + mapId,
        selectMode: 3,
        select: function(event, data) {
            var mapNumber = getMapNumber(data.tree.options.cookieId.split('fancyTree' + action)[1]);
            ajaxMap.updatePlaces(mapNumber, true);
        },
        source: {
            url: "index.php",
            type: "GET",
            dataType: "json",
            data: {
                'id': mapSettings.pageId,
                'api': "map",
                'action': action,
                'mapId': mapId
            }
        }
    };
    if (typeof settings === 'object') {
        for (var property in settings) {
            if (settings.hasOwnProperty(property)) {
                localSettings[property] = settings[property];
            }
        }
    }
    $(select).fancytree(localSettings).data('mapId', mapId);
}
