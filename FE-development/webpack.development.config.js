const merge = require('webpack-merge');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const webpackConfig = require('./webpack.config');

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
        new StyleLintPlugin()
    ]
});
