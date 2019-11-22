const path = require('path');
const fs = require('fs');
const SVGO = require('svgo');
const packageJSON = require('../../package.json');

const svgo = new SVGO({
    plugins: [
        {removeViewBox: false}
    ]
});

const svgsPath = path.resolve(__dirname, '../assets/svgs/');

/**
 * Recursive function to iterate through all svgs in /src/assets/svgs/.
 *
 * @param dir
 * @returns {Array} object svg
 */
function readDir(dir) {
    let list = [],
        files = fs.readdirSync(dir),
        stats;

    files.forEach(function (file) {
        stats = fs.lstatSync(path.join(dir, file));
        if (stats.isDirectory()) {
            list = list.concat(readDir(path.join(dir, file)));
        } else {
            let filePath = path.join(dir, file);

            if (path.extname(filePath) !== '.svg') return;

            list.push({
                title: path.relative(svgsPath, filePath).replace(/\//g, '-').replace('.svg', ''),
                markup: fs.readFileSync(filePath, 'utf8')
            });
        }
    });

    return list;
}

/**
 * Make svgs available to templates through global context.
 */
let svgs = function () {
    let svgs = {};

    if (!fs.existsSync(svgsPath) || !fs.readdirSync(svgsPath)) return;

    readDir(svgsPath).map((f) => {
        svgs[f.title] = svgo.optimize(f.markup).then((f) => f.data);
    });

    return svgs;
};

module.exports = {
    svgs: svgs(),
    title: packageJSON.project.title
};
