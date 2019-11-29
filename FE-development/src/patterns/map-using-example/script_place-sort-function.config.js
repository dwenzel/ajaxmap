const placeSortFunction= function(a, b) {
    //Todo Postleitzahl

    console.log(a)
    a = parseInt(a.data.address.zip);
    b = parseInt(b.data.address.zip);
    return a > b ? 1 : a < b ? -1 : 0;
}.toString();

const placeSortFunctionWrapper = `
    window.ajaxMapConfig = window.ajaxMapConfig|| {};
    window.ajaxMapConfig.placeSortFunction=${placeSortFunction};`;

module.exports = {
    context: {
        placeSortFunction: '<script>' + placeSortFunctionWrapper + '</script>'
    }
};
