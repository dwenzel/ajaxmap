const path = require('path');
var webpack = require("webpack");

module.exports = {
    entry: './Resources/Public/JavaScript/ajaxmapMain.js',
    output: {
        path: path.resolve(__dirname, 'Resources/Public/Dist'),
        filename: 'ajaxmap.bundle.js'
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: require.resolve('jquery'),
            jQuery: require.resolve('jquery')
        })
    ]
};
