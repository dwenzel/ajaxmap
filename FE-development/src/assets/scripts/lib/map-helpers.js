/**
 * Created by d.eggermann on 30.10.19.
 */

import $ from 'jquery';
import MarkerClusterer from '@google/markerclusterer'

const helpers = {
        getLocationType: (mapEntry, typeId) =>
            mapEntry.locationTypes.filter(
                (item) =>item.key === typeId
            )
        ,
        getSelectedKeys: (selector) => {
            const tree = $(selector).fancytree('getTree');

            return typeof tree.getSelectedNodes === 'function' ?
                tree.getSelectedNodes().map((node) => parseInt(node.key)) :
                [];
        },
        setDimension: ($mapEl, response) => {
            $mapEl.height(response.height).width(response.width);
        },
        getLatLong: (coordsStr) => {
            if (!coordsStr) {
                throw new Error('no map [lat,long]')
            }

            const coords = coordsStr.split(',').map((part) => parseFloat(part));

            return new google.maps.LatLng(coords[0], coords[1]);
        },
        getMapType: (type) => {

            switch (type) {
                case '2':
                    return google.maps.MapTypeId.SATELLITE;
                case '3':
                    return google.maps.MapTypeId.HYBRID;
                case '4':
                    return google.maps.MapTypeId.TERRAIN;

                default:
                    // 0 - 'Styled Map' and 1 - 'Road Map' will become ROADMAP
                    return google.maps.MapTypeId.ROADMAP;
            }
        }
        ,
        getMapStyle: (response) => {
            if (response.type === '0' && response.mapStyle) {

                return $.parseJSON('[' + response.mapStyle + ']');
            }

            return '';
        },
        getInfoWindow: () => {
            return new google.maps.InfoWindow({
                    maxWidth: 370
                }
            );
        },
        getMarkerClusterer: (map, markerClusterer) => {

            return new MarkerClusterer(map, [], markerClusterer)
        },
        createGooglMap: (response, $el) => {

            helpers.setDimension($el, response);
            const mapType = helpers.getMapType(response.type);
            const mapStyle = helpers.getMapStyle(response.type);

            let mapCenter = helpers.getLatLong(response.mapCenter);

            //build map
            return new google.maps.Map(
                $el[0], {
                    zoom: response.initialZoom,
                    center: mapCenter,
                    mapTypeId: mapType,
                    styles: mapStyle,
                    disableDefaultUI: response.disableDefaultUI
                });
        }
    }
    ;

export const getLocationType = helpers.getLocationType;
export const getSelectedKeys = helpers.getSelectedKeys;
export const getLatLong = helpers.getLatLong;

export default helpers;
