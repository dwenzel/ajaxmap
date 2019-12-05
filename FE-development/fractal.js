'use strict';

const _fractalServerPort = 2222;

const path = require('path');
const packageJSON = require('./package.json');
const fractal = require('@frctl/fractal').create();
const fractalTheme = require('@frctl/mandelbrot');
const dataGlobal = require('./src/data/global');
const handlebarsLayouts = require('handlebars-layouts');
const ajaxProxyPort = packageJSON.project.ajaxProxyPort;

/**
 * set fractal project metadata based on values in package.json
 */
fractal.set('project.title', packageJSON.project.title);
fractal.set('project.version', packageJSON.version);

/**
 * Using handlebars-layouts (https://www.npmjs.com/package/handlebars-layouts)
 */
const engineInstance = fractal.components.engine();
handlebarsLayouts.register(engineInstance.handlebars);

/**
 * fractal components related configuration
 */
fractal.components.set('path', path.join(__dirname, './src/patterns'));
fractal.components.set('label', 'Patterns');

/**
 * set default context for components
 */

const local = process.env.APP_ENV === 'development' ? 'http://localhost:' + _fractalServerPort : '';
const ajaxPath = process.env.APP_ENV === 'development' ? 'http://localhost:' + ajaxProxyPort + '/' : '/index.php';

fractal.components.set('default.context', Object.assign(dataGlobal, {
    publicPath: local + packageJSON.project.publicPath,
    ajaxProxyPath: ajaxPath
}));

/**
 * Default preview template
 */
fractal.components.set('default.preview', '@preview');

/**
 * fractal docs related configuration
 */
fractal.docs.set('path', path.join(__dirname, './src/docs'));

/**
 * fractal webUI related configuration
 */
// set static path for webpack generated assets
fractal.web.set('static.path', path.join(__dirname, './dist'));
// match static path with production environment path for static assets
fractal.web.set('static.mount', packageJSON.project.publicPath || '/');
// set deploy path for fractal project
fractal.web.set('builder.dest', path.join(__dirname, './public'));
// enable browser-sync server for fractal
fractal.web.set('server.sync', true);
// override browser-sync configuration for docker support
fractal.web.set('server.syncOptions', {
    socket: {
        domain: '\' + location.protocol + \'//\' + location.hostname + (location.port ? \':\'+location.port : \'\') + \''
    },
    port: _fractalServerPort,
    open: false,
    online: false,
    notify: false
});
// override fractal theme settings
fractal.web.theme(fractalTheme({
    skin: 'black'
}));

module.exports = fractal;
