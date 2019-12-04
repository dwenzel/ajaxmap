const hbs = require('handlebars')

const fs = require('fs');

const template = fs.readFileSync(__dirname + '/card.example.template.hbs', 'UTF-8');


//--> fields of "card --> https://frs.plan.io/issues/14065

const func = `
    window.ajaxMapConfig = window.ajaxMapConfig|| {};
    
    window.ajaxMapConfig.renderPlaceTreesItem = function(placeInstance) {
    // console.log(placeInstance);

    var placeData=placeInstance.placeData;
//console.log(placeData)
    var title=placeData.title || 'no* title';
    var subline=placeData.content && 'no* subline'

    var text=placeData.text && 'no* tex'
    var pageUrl=placeData.pageUrl &&'no pageUrl';


  // console.log(placeData.locationType.title);

    return \`${template}\`;
 }`;

module.exports = {
    context: {
        renderPlaceTreesItemFunction: '<script>' + func + '</script>'
    }
};
