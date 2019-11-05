'use strict';

const path = require('path');
const packageJSON = require('./package.json');
const CssExtractPlugin = require('mini-css-extract-plugin');
const IconfontWebpackPlugin = require('iconfont-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const Fiber = require('fibers');



module.exports = {
    target: 'web',
    mode: (process.env.APP_ENV === 'production') ? 'production' : 'development',
    devtool: (process.env.APP_ENV === 'production') ? false : 'inline-source-map',

    entry: {
        main: [
            path.resolve(__dirname, './src/assets/scripts/main.js'),
            path.resolve(__dirname, './src/assets/styles/main.scss')
        ]
    },

    output: {
        path: path.resolve(__dirname, './dist'),
        publicPath: packageJSON.project.publicPath,
        filename: 'js/[name].js'
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                use: 'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: CssExtractPlugin.loader
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            minimize: process.env.APP_ENV === 'production',
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            ident: 'postcss',
                            plugins: (loader) => [
                                require('autoprefixer')({
                                    cascade: true
                                }),
                                require('postcss-discard-comments')(),
                                new IconfontWebpackPlugin(loader)
                            ],
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'resolve-url-loader',
                        options: {
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            implementation: require('sass'),
                            sourceMap: true,
                            fiber: Fiber
                        }
                    }
                ]
            },
            {
                test: /\.svg$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[path]/[name].[ext]',
                            context: 'src/assets/vectors/',
                            outputPath: '/vectors/'
                        }
                    },
                    {
                        loader: 'svgo-loader',
                        options: {
                            plugins: [
                                {removeViewBox: false}
                            ]
                        }
                    }
                ]
            },
            {
                test: /\.(woff|woff2)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[path]/[name].[ext]',
                            context: 'src/assets/fonts/',
                            outputPath: '/fonts/'
                        }
                    }
                ]
            }
        ]
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './src')
        }
    },
    plugins: [
        new CssExtractPlugin({
            filename: 'css/[name].css'
        }),
        new CopyPlugin([
            {
                from: path.resolve(__dirname, './src/public'),
                to: path.resolve(__dirname, './dist/public'),
            }
        ]),

    ]
};
