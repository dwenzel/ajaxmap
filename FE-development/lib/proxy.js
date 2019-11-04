/**
 * Created by d.eggermann on 03.12.18.
 */

const request = require('request');
const express = require('express');
const path = require('path'),
    fs = require('fs');

const app = express();

app.use(function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});

function readJson(name) {
    const jsonStr= fs.readFileSync(__dirname + '/json/' + name + '.json', 'utf-8')

    return JSON.parse(jsonStr);
}

const proxy = {
    start: (config) => {
        const port = config.proxyPort ? config.proxyPort : 7722;

        app.get('/ajaxmap.bundle.js', function(req, res) {
            fs.createReadStream(__dirname+'/../src/ajaxmap.bundle.js').pipe(res);
        });
        app.get('/ajaxmap.bundle.js.map', function(req, res) {
            fs.createReadStream(__dirname + '/../src/ajaxmap.bundle.js.map').pipe(res);
        });

        app.get('/', function(req, res) {
            let params = req.query;

            console.log('-->', params)
            res.json(readJson(params.action))
            //            return request.get(param).pipe(res);
        })

        //app.use(express.static(path.join(__dirname + '/publicationBrowsePdf')))

        app.listen(port, function() {
                console.log('use http://localhost:' + port + '')
            }
        );
    }
};

module.exports = proxy;
