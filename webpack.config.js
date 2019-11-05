const path = require('path');
var webpack = require("webpack");

module.exports = {
    mode: 'production',
    entry: './Resources/Public/JavaScript/ajaxmapMain.js',
    module: {
        rules: [
            {
                test: /\.(png|jpe?g|gif)$/i,
                use: [
                    {
                        loader: 'file-loader',
                    },
                ],
            },
            {
                test: /\.(s*)css$/i,
                use: ['style-loader', 'css-loader', 'sass-loader'],
            }, /*
             test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
             use: [
             {
             loader: 'file-loader',
             options: {
             name: '[name].[ext]',
             outputPath: 'fonts/'
             }
             }
             ]
             },
             {
             test: /\.svg$/,
             loader: 'svg-inline-loader'
             }*/
        ],
    },
    output: {
        path: path.resolve(__dirname, 'Resources/Public/Dist'),
        filename: 'ajaxmap.bundle.js'
    },
    /*  plugins: [
     new webpack.ProvidePlugin({
     $: require.resolve('jquery'),
     //jQuery: require.resolve('jquery')
     })
     ],*/
    devtool: 'source-map'
};
