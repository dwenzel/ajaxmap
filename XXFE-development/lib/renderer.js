const cheerio = require('cheerio'),
    fs = require('fs');

const proxy = require('./proxy')

const markupPath = __dirname + '/markup.html';

function read(path) {
    return fs.readFileSync(path, 'utf-8')
}

function save(path, str) {
    return fs.writeFileSync(path, str)
}

const injextScriptUrl = function(path, proxyPort) {
    const script = read(path);
    const sourceMap = read(path);

    const toReplace = 'index.php';//ajax-url
    const proxUrl = 'http://localhost:' + proxyPort;

    return script.split(toReplace).join(proxUrl);// + '?url=' + toReplace);
};

const renderIndex = function(injectedScript) {
    let html = read(markupPath);
    var $ = cheerio.load(html);

    injectedScript = `<script src="">${injectedScript}</script>`

    $('body').append(injectedScript);

    save('./src/index.html', $.html())
};

const renderIndex2 = function(injectedScript, config) {
    /*render as <script src=""*/
    let html = read(markupPath);
    var $ = cheerio.load(html);

    const scriptTag = `<script src="http://localhost:${config.proxyPort}/ajaxmap.bundle.js"></script>`
    $('body').append(scriptTag);

    save('./src/index.html', $.html())

    save('./src/' + 'ajaxmap.bundle.js', injectedScript)
};
//<script src="myscripts.js"></script>
module.exports = {
    init: (config) => {
        fs.createReadStream(config.ajaxMapSourceMapPath).pipe(fs.createWriteStream('./src/ajaxmap.bundle.js.map'))

        const injectedScript = injextScriptUrl(config.ajaxMapPath, config.proxyPort);

        if (!proxy.started) {
            proxy.start(config);
            proxy.started = true;
        }

        //    renderIndex(injectedScript, config);
        renderIndex2(injectedScript, config);
    }
};
