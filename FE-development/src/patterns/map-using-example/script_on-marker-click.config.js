
const onMarkerClickTemplateFunction = function(mapEntry, place, $) {
   // place.placeInstance.panToSelf();

    const treeNode = place.placeInstance.treeNode//has all domNodes

    treeNode.setSelected(true)

    //  var ulEl = treeNode.parent.ul;
    //  var liEl = treeNode.li;

    treeNode.li.scrollIntoView({// caniuse :78% /use polyfill : https://github.com/iamdustan/smoothscroll
        behavior: "smooth",
        block: "end",
        inline: "nearest"
    });
}.toString();

const onMarkerClick = `
    window.ajaxMapConfig = window.ajaxMapConfig|| {};
    window.ajaxMapConfig.onMarkerClick=${onMarkerClickTemplateFunction};`;

module.exports = {
    context: {
        onMarkerClick: '<script>' + onMarkerClick + '</script>'
    }
};