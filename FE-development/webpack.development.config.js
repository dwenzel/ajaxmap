const merge = require('webpack-merge');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const webpackConfig = require('./webpack.config');

const NodemonPlugin = require('nodemon-webpack-plugin'); // Ding

module.exports = merge(webpackConfig, {
    module: {
        rules: [
            {
                test: /\.js$/,
                use: [
                    {
                        loader: 'babel-loader'
                    },
                    {
                        loader: 'eslint-loader'
                    }
                ],
                exclude: /node_modules/
            }
        ]
    },
    plugins: [
        new StyleLintPlugin(),
        new NodemonPlugin({script: './build_inject-url.js'})
    ]
});
