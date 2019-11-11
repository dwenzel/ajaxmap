const proxy = require('./proxy');

const ajaxProxyPort= require('../../../_config-proxy-port.json').ajaxProxyPort;
proxy.start(ajaxProxyPort);


const googleApiKey = require(process.env.HOME + '/config-data/bsb-config').googleApiKey;

const map = {
    settings: {
        keys: {
            googleMap: googleApiKey
        },
        "id": "1",
        "infoWindow": "",
        "kmlLayer": "",
        "locationTypes": [],
        "map": "",
        "marker": [],
        "placeGroups": "",
        "places": "",
        "regions": "",
        "settings": {
            "markerClusterer": {"imagePath": "typo3conf\/ext\/ajaxmap\/Resources\/Public\/Icons\/Cluster\/m"},
            "regionTree": {
                "minExpandLevel": 3,
                "selectMode": 3,
                "icons": false,
                "checkbox": true,
                "extensions": ["filter", "glyph"],
                "glyph": {
                    "preset": "awesome4",
                    "map": {
                        "folder": "fa-folder",
                        "folderOpen": "fa-folder-open"
                    }
                },
                "filter": {
                    "autoApply": true,
                    "mode": "hide"
                }
            },
            "categoryTree": {
                "icons": false,
                "extensions": ["filter", "glyph"],
                "glyph": {
                    "preset": "awesome4",
                    "map": {
                        "folder": "fa-folder",
                        "folderOpen": "fa-folder-open"
                    }
                },
                "filter": {
                    "autoApply": true,
                    "mode": "hide"
                }
            },
            "placeGroupTree": {
                "checkbox": true,
                "icons": false,
                "extensions": ["filter", "glyph"],
                "glyph": {
                    "preset": "awesome4",
                    "map": {
                        "folder": "fa-folder",
                        "folderOpen": "fa-folder-open"
                    }
                },
                "filter": {
                    "autoApply": true,
                    "mode": "hide"
                }
            },
            "locationTypeTree": {
                "checkbox": true,
                "icons": false,
                "selectMode": 1,
                "extensions": ["filter", "glyph"],
                "glyph": {
                    "preset": "awesome4",
                    "map": {
                        "folder": "fa-folder",
                        "folderOpen": "fa-folder-open"
                    }
                },
                "filter": {
                    "autoApply": true,
                    "mode": "hide"
                }
            },
            "placesTree": {
                "toggleInfoWindowOnSelect": true,
                "selectMode": 1,
                "icons": false,
                "extensions": ["filter"],
                "quicksearch": true,
                "filter": {
                    "autoApply": true,
                    "mode": "hide"
                },
                "updateFilters": {
                    "locationType": {"treeName": "ajaxMapLocationTypesTree"},
                    "categories": {"treeName": "ajaxMapCategoryTree"},
                    "regions": {
                        "treeName": "ajaxMapRegionsTree",
                        "updateLayers": true
                    },
                    "placeGroups": {"treeName": "ajaxMapPlaceGroupTree"}
                }
            }
        },
        "pageId": 149
    }
};

module.exports = {

    context: {
        map: JSON.stringify(map.settings)
    }
};
