/**
 * Created by d.eggermann on 30.10.19.
 */
import $ from 'jquery';

import ajaxMap from './ajaxMap';

export class ElBuffer {//not in use
    constructor() {
        this.buffer = {};
    }

    getEl(selector) {
        const el = this.buffer[selector];

        return el ? el : function() {
                this.buffer[selector] = el;
                return el;
            };
    }
}

export const ajaxCall = (data) => {
    return new Promise(function(resolve, reject) {
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: ajaxMap.ajaxServerPath,
            data,
            success: resolve,
            error: reject
        });
    });
};

export const sort = {
    aplhabetic: {
        asc: (a, b) => {
            a = a.title.toLowerCase();
            b = b.title.toLowerCase();
            return a > b ? 1 : a < b ? -1 : 0;
        }
    },
    nummeric: {
        asc: (a, b) => {
            //Todo Postleitzahl
            a = a.title.toLowerCase();
            b = b.title.toLowerCase();
            return a > b ? 1 : a < b ? -1 : 0;
        }
    }
};

export const inserScriptTag = (src) => {

    return new Promise(function(resolve, reject) {
        var script = document.createElement('script');
        script.src = src;
        script.async = true;
        script.onload = resolve;
        script.onerror = reject;

        var entry = document.getElementsByTagName('script')[0];
        entry.parentNode.insertBefore(script, entry);
    });
};
/**
 * get address for a single place
 * @param placeId
 * @return json
 */
export const getAddress = (placeId) => {
    const data = {
        'id': ajaxMap.configData.mapSettings.pageId,
        'api': 'map',
        'action': 'getAddress',
        'placeId': placeId
    };

    return ajaxCall(data);
};

