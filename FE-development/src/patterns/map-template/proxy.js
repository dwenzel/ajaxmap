/**
 * Created by d.eggermann on 03.12.18.
 */

const request = require('request');
const express = require('express');
const path = require('path'),
    fs = require('fs');

const app = express();

app.use(express.static(__dirname+'/../../../../dist/public'))

app.use(function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});

function readJson(name) {
    const jsonStr = fs.readFileSync(__dirname + '/json/' + name + '.json', 'utf-8')

    return JSON.parse(jsonStr);
}

const proxy = {

    started: false,
    start: (proxyPort) => {
        if (proxy.started) {
            return;
        }

        proxy.started = true;
        const port = proxyPort;

        app.get('/', function(req, res,next) {
            let params = req.query;

            if(!params){
                next();
            }

            //https://stg.typo3.bsb.321.works/beratung/bsb-beratungsnetz/index.php

            console.log('-->', params)
            res.json(readJson(params.action))
        })

        app.listen(port, function() {
                console.log('******proxy: ','http://localhost:' + proxyPort + ' ******')
            }
        );
    }
};

module.exports = proxy;
