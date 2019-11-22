const request = require('request'),
    cheerio = require('cheerio'),
    fs = require('fs'),
    splitHtml = require('split-html'),
    fractal = require('@frctl/fractal');

const url = 'https://www.bundesgesundheitsministerium.de/index.php?id=4400/';

//const url = 'https://www.bundesgesundheitsministerium.de/404/';
var virtualPath = require(__dirname + '/../../../package.json').project.publicPath;

function addSrc() {
    var host = document.location.host;

    var script = document.createElement('script');
    script.src = 'http://' + host + 'virtualPath' + '/js/main.js';
    entry = document.getElementsByTagName('script')[0];

    entry.parentNode.insertBefore(script, entry);
    script.onload = function() {

        let link = document.createElement('link');
        link.rel = 'stylesheet';
        link.type = 'text/css'
        link.href = 'http://' + host + 'virtualPath' + '/css/main.css';
        var entry = document.getElementsByTagName('link')[0];
        entry.parentNode.insertBefore(link, entry);

        window.document.dispatchEvent(new Event("DOMContentLoaded", {
            bubbles: true,
            cancelable: true
        }));
    }
}

let srcScript = addSrc.toString();
srcScript = srcScript.replace(/virtualPath/g, virtualPath) + ';addSrc();'

const toReplace = [
    '.page-header'
]

module.exports = {
    context: {
        html: new Promise(function(resolve, reject) {

            if (false && fractal.bufferPage) {
                //                console.log('from buffer ******')
                return resolve(fractal.bufferPage)
            }

            request(url, function(error, response, body) {
                var $ = cheerio.load(body);

                //  $('base').remove();//attr('href','localhost:7120/')
                // $('head').append('<style>' + css + '</style>');
                $('body').append('<script>' + srcScript + '</script>');

                toReplace.forEach((selector) => {
                    $(selector).remove();
                })

                //$('.page-header').text(' ')

                body = $.html();
                var fragments = splitHtml(body, '.container.main');

                var docData = {
                    fragment_1: fragments[0],
                    fragment_3: fragments[2]
                };

                fractal.bufferPage = docData
                resolve(docData);
            });
        })
    }
};
