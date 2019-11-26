const fs = require('fs');

const onMarkerClickTemplate = function(mapEntry, place, $) {
    const treeNode = place.placeInstance.treeNode//has all domNodes

    treeNode.setSelected(true)

    //    var ulEl = treeNode.parent.ul;
    //  var liEl = treeNode.li;

    treeNode.li.scrollIntoView({
        behavior: "smooth",
        block: "end",
        inline: "nearest"
    });
}.toString();

const onMarkerClick = `function (){
    window.ajaxMapConfig = window.ajaxMapConfig|| {};
    window.ajaxMapConfig.onMarkerClick=${onMarkerClickTemplate};
}`;

module.exports = {
    context: {
        onMarkerClick: '<script>(' + onMarkerClick + ')()</script>'
    }
}
