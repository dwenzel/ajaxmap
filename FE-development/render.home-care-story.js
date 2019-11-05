/**
 * Created by d.eggermann on 17.09.19.
 */
const cheerio = require('cheerio'),
    fs = require('fs'),
    CleanCSS = require('clean-css'),
    UglifyJS = require('uglify-js'),
    minify = require('html-minifier').minify;

function read(path) {
    return fs.readFileSync(path, 'utf-8')
}

const path = {
    css: __dirname + '/dist/css/main.css',
    js: __dirname + '/dist/js/main.js',
    component: __dirname + '/public/components/render/home-care-story.html'
};

const assetsHandling = {
    css: () => {
        let css = read(path.css);
        var minimized = new CleanCSS().minify(css);

        return '<style>' + minimized.styles
            + '</style>';
    },
    jsInline: () => {
        let code = read(path.js);
        var options = {warnings: true};
        var result = UglifyJS.minify(code, options);

        return '<script>' + result.code
            + '</script>';
    },
    jsFile: () => {
        let code = read(path.js);
        var options = {warnings: true};
        var toSave = UglifyJS.minify(code, options).code;

        const fileName = 'care-story-partial.js';

        fs.writeFile(__dirname + '/' + fileName, toSave, () => console.log('saved ' + fileName))
    },
    cssFile: () => {
        let css = read(path.css);
        var minimized = new CleanCSS().minify(css).styles;
        const fileName = 'care-story-partial.css';

        fs.writeFile(__dirname + '/' + fileName, minimized, () => console.log('saved ' + fileName))
    },
    component: () => {
        let html = read(path.component);

        //var result = UglifyJS.minify(code, options)
        var $ = cheerio.load(html);

    //    let css = assetsHandling.css();

        //   $('.c-story-container').prepend(css);

        assetsHandling.jsFile();
        assetsHandling.cssFile();
        // $('.c-story-container').append(js);

        var htmlOpt = {
            collapseWhitespace: true,
            removeTagWhitespace: true
        }

        const toSave = minify($('main').html(), htmlOpt);

        fs.writeFile(__dirname + '/care-story-partial.html', toSave, () => {
            console.log('saved care-story-partial')
            return html;
        })

        $('body').append('<script type="application/javascript" src="./care-story-partial.js"></script>')
        const toSaveHtml = minify($.html(), htmlOpt);

        fs.writeFile(__dirname + '/care-story.html', toSaveHtml, () => {
            console.log('saved care-story')
            return html;
        })
    }
}

module.exports = () => {
};
assetsHandling.component();
