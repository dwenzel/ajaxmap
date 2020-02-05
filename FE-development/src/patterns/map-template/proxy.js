/**
 * Created by d.eggermann on 03.12.18.
 */

const request = require('request');
const express = require('express');
const path = require('path'),
    fs = require('fs');

const app = express();

app.use(express.static(__dirname + '/../../../../dist/public'))

app.use(function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});

function readJson(name) {
    const jsonStr = fs.readFileSync(__dirname + '/json/' + name + '.json', 'utf-8')

    return JSON.parse(jsonStr);
}
const proxyUrl = 'https://stg.typo3.bsb.321.works/beratung/bsb-beratungsnetz/index.php';
const proxy = {

    started: false,
    start: (proxyPort) => {
        if (proxy.started) {
            return;
        }

        proxy.started = true;
        const port = proxyPort;

        app.get('/XX', function(req, res) {
            let params = req.query;
            var i = req.url.indexOf('?');
            var query = req.url.substr(i + 1);

            console.log('-->', query);
            request.get(proxyUrl + '?' + query).pipe(res);
        });

        app.get('/', function(req, res, next) {
            let params = req.query;

            if (!params) {
                next();
            }

            //https://stg.typo3.bsb.321.works/beratung/bsb-beratungsnetz/index.php
            //return  res.status(400).json({error: 'message'})

            console.log('-->', params);
            res.json(readJson(params.action));
        });

        app.listen(port, function() {
                console.log('******proxy: ', 'http://localhost:' + proxyPort + ' ******')
            }
        );
    }
};

module.exports = proxy;
