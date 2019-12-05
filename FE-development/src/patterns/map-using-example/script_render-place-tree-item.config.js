const hbs = require('handlebars')

const fs = require('fs');

const template = fs.readFileSync(__dirname + '/card.example.template.hbs', 'UTF-8');


//--> fields of "card --> https://frs.plan.io/issues/14065

const func = `
    window.ajaxMapConfig = window.ajaxMapConfig|| {};
    
    window.ajaxMapConfig.renderPlaceTreesItem = function(placeInstance) {
   
    // console.log(placeInstance);

    var placeData=placeInstance.placeData;

    return \`${template}\`;
 }`;

module.exports = {
    context: {
        renderPlaceTreesItemFunction: '<script>' + func + '</script>'
    }
};
