/**
 * Created by d.eggermann on 30.10.19.
 */

import $ from 'jquery';
import MarkerClusterer from '@google/markerclusterer';
const helpers = {

    /**
     * Searches all children for an attribute in their data property
     * and returns a unique array of keys for this attribute
     *
     * @param treeNodes
     * @param name
     * @return Array
     */
    getKeysByAttribute: function(treeNodes, name) {
        var lookUp = {};

        return treeNodes.filter((node) => {
            const attribute = node.data[name];

            if (attribute) {
                if (attribute.hasOwnProperty('key')
                    && !lookUp[attribute.key]) {

                    return lookUp[attribute.key] = true;
                }

                return false;
            } else {
                console.error('not refactored')

                if (attribute instanceof Array) {
                    for (var i = 0, k = attribute.length; i < k; i++) {
                        if (attribute[i].hasOwnProperty('key') && keys.indexOf(attribute[i].key) < 0) {
                            keys.push(attribute[i].key);
                        }
                    }
                }
            }
        }).map(node => node.data[name].key)
    },
    getLocationType: (mapEntry, typeId) =>
        mapEntry.locationTypes.filter(
            (item) => item.key === typeId
        )[0]
    ,
    getSelectedKeys: (selector) => {
        /*        var tree = $(selector).fancytree('getTree'),
         selectedKeys = [];
         if (typeof tree.getSelectedNodes === 'function') {
         var selectedNodes = tree.getSelectedNodes();

         selectedKeys = $.map(selectedNodes, function(node) {
         console.log(node)

         return parseInt(node.key);
         });
         }


         return selectedKeys;*/

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
            throw new Error('no map [lat,long]');
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
        });
    },
    getMarkerClusterer: (map, markerClusterer) => {

        return new MarkerClusterer(map, [], markerClusterer);
    },

    //https://stackoverflow.com/questions/7997627/google-maps-how-to-get-the-distance-between-two-point-in-metre/7997732#7997732
    //calculates distance between two points in km's
    calcDistance: (bounds, places) => {
        const pBoundsCenter = bounds.getCenter();

        places.forEach((p) => {
            const distInKm = (google.maps.geometry.spherical.computeDistanceBetween(pBoundsCenter, p.LatLong) / 1000).toFixed(2);
            p.placeData.distanceToCenter = distInKm;
        });

    },
    fitBounds: (mapEntry, places) => {
        var bounds = new google.maps.LatLngBounds();

        places.forEach((place) => {
            var locationLatLng =
                new google.maps.LatLng(place.marker.position.lat(), place.marker.position.lng());
            bounds.extend(locationLatLng);
        });

        mapEntry.googleMap.fitBounds(bounds);
        return bounds;
    },
    createGooglMap: (response, $el) => {

        helpers.setDimension($el, response);
        const mapType = helpers.getMapType(response.type);
        const mapStyle = helpers.getMapStyle(response.type);

        let mapCenter = helpers.getLatLong(response.mapCenter);

        //        alert(response.initialZoom)
        //        todo:response.initialZoom is set to 7?!!
        response.initialZoom = 13;
        //        response.hideTypeControl=true;//!true,  how they are set ?!!
        // streetViewControl:?
        //build map
        return new google.maps.Map(
            $el[0], {

                zoom: response.initialZoom,
                center: mapCenter,

                mapTypeId: mapType,
                mapTypeControl: !response.hideTypeControl,
                mapTypeControlOptions: {
                    //  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                fullscreenControl: !response.hideFullscreenControl,
                streetViewControl: !response.hideStreetViewControl,
                styles: mapStyle,
                disableDefaultUI: response.disableDefaultUI,
                //                mapTypeId: google.maps.MapTypeId.HYBRID
            });
    },
    //setZoom:()={}
};

export const getKeysByAttribute = helpers.getKeysByAttribute;
export const getLocationType = helpers.getLocationType;
export const getSelectedKeys = helpers.getSelectedKeys;
export const getLatLong = helpers.getLatLong;
export const fitBounds = helpers.fitBounds;
export const calcDistance = helpers.calcDistance;

export default helpers;
