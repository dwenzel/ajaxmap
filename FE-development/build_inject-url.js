/**
 * Created by d.eggermann on 17.09.19.
 */

const fs = require('fs');
const ajaxProxyPort = require('./_config-proxy-port.json').ajaxProxyPort;
const buildetScriptPath = './dist/js/main.js'
const handletScriptPath = '/Users/d.eggermann/Projekte/ajaxmap-ssh/Resources/Public/Dist/ajaxmap.bundle.js'

function read(path) {
    return fs.readFileSync(path, 'utf-8')
}

function save(path, str) {
    return fs.writeFileSync(path, str)
}

function injextScriptUrl(path, ajaxProxyPort) {
    let script = read(path);
    /* Xscript="//replace mm \nmn\n dfsdf \n //end-replace"

     Xscript=`  ajaxServerPath:
     //replace
     'http://localhost:' + ajaxProxyPort,
     //end-replace
     configData: null,`
     //console.log(script)

     //  script= script.replace((/  |\r\n|\n|\r/gm), "");
     */
    var patt = /(\/\/replace.*\/\/end-replace)/s;// build:change\*\/.*/;//\/\*build:change\*\//;///\*end-build:change\*\//i;


    var matches = script.match(patt);
    console.log(matches[1]);


    const withReplace = "'index.php',";//ajax-url
    const toReplace = matches[1];// "'http://localhost:' + ajaxProxyPort'";//http://localhost:' + ajaxProxyPort;

    return script.split(toReplace).join(withReplace);
};

function init() {
    const script = injextScriptUrl(buildetScriptPath, ajaxProxyPort);
    save(handletScriptPath, script)
};

init()
