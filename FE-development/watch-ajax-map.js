const watch = require('node-watch')

const renderer = require('./lib/renderer')

const config = {
    ajaxMapDistPath: __dirname + '/../Resources/Public/Dist',
    ajaxMapPath: __dirname + '/../Resources/Public/Dist/ajaxmap.bundle.js',
    ajaxMapSourceMapPath: __dirname + '/../Resources/Public/Dist/ajaxmap.bundle.js.map',
    proxyPort: 7722
};

watch(config.ajaxMapPath, {recursive: false}, function(evt, name) {
    renderer.init(config)
});

renderer.init(config)
