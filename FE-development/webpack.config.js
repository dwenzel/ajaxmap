const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

module.exports = {
    entry: __dirname + '/src/index.html',
    module: {
        rules: [
            {
                test: /\.html$/,
                use: 'raw-loader',
            }
        ]
    },
    watchOptions: {
        aggregateTimeout: 300,
        poll: 500
    },
    plugins: [
        new BrowserSyncPlugin({

            host: 'localhost',
            port: 3000,
            server: {baseDir: [__dirname + '/src']}
        })
    ]
}
