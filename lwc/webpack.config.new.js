const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const LwcWebpackPlugin = require('lwc-webpack-plugin')
const path = require('path')
const TerserJSPlugin = require('terser-webpack-plugin')
var AssetsPlugin = require('assets-webpack-plugin')
const webpack = require('webpack')

// const BUILD_PATH = './../force-app/main/default/staticresources/build_uk'

module.exports = (env) => {
    const PUBLIC_PATH = env.development ? '' : '/wp-content/themes/krasnagorka/src/'

    const settings = {
        mode: env.production ? 'production' : 'development',
        entry: {
            cookie: './frontend/cookie.js',
            booking: './frontend/booking.js',
            taplink: './frontend/taplink.js',
            tab_events: './frontend/tab_events.js'
        },
        optimization: {
            minimize: true,
            minimizer: [new TerserJSPlugin()]
        },
        stats: {
            children: true,
            errorDetails: true
        },
        // devServer: {
        //     overlay: true,
        //     // contentBase: publicPath,
        //     proxy: {
        //         '/': {
        //             target: 'https://krasnagorka.by/',
        //             changeOrigin: true
        //         }
        //     }
        // },
        // devServer: {
        //     static: {
        //         directory: path.join(__dirname, 'public')
        //     },
        //     compress: true,
        //     port: 9000
        // },
        output: {
            path: path.resolve(__dirname, './../src'),
            publicPath: PUBLIC_PATH,
            filename: `javascript/[name].[fullhash].min.js`,
            chunkFilename: 'javascript/[name]' + (env.development ? '.js' : '.[fullhash].min.js')
        },
        module: {
            rules: [
                {
                    test: /\.(?:js|mjs|cjs)$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            targets: 'defaults',
                            presets: [['@babel/preset-env']]
                        }
                    }
                },
                {
                    test: /\.pug$/,
                    loader: 'pug-loader',
                    options: {
                        pretty: true
                    }
                },
                {
                    test: /\.(css|scss)$/,
                    exclude: /(node_modules)/,
                    use: [
                        'style-loader',
                        'css-loader',
                        'resolve-url-loader',
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                            }
                        }
                    ]
                },
                {
                    test: /\.(svg|png|jp(e*)g|svg|gif)$/,
                    type: 'asset/resource',
                    generator: {
                        filename: env.development
                            ? './frontend/icons/[name].[ext]'
                            : `icons/[name].[contenthash:6].[ext]`,
                        publicPath: env.development ? '' : PUBLIC_PATH
                    }
                },
                {
                    test: /\.(woff|woff2|eot|ttf|otf)$/,
                    type: 'asset/resource',
                    generator: {
                        filename: env.development
                            ? './frontend/icons/[name].[ext]'
                            : `icons/[name].[contenthash:6].[ext]`,
                        publicPath: env.development ? '' : PUBLIC_PATH
                    }
                }
            ]
        },
        plugins: [
            new HtmlWebpackPlugin({
                title: 'Cookie page',
                filename: `cookie.html`,
                inject: 'body',
                template: './frontend/cookie.pug',
                chunks: ['cookie']
            }),
            new HtmlWebpackPlugin({
                title: 'Booking page',
                inject: 'body',
                filename: `booking.html`,
                template: './frontend/booking.pug',
                chunks: ['booking']
            }),
            new HtmlWebpackPlugin({
                title: 'Taplink page',
                filename: `taplink.html`,
                inject: 'body',
                template: './frontend/taplink.pug',
                chunks: ['taplink']
            }),
            new HtmlWebpackPlugin({
                title: 'Tab Events',
                filename: `tab-events.html`,
                inject: 'body',
                template: './frontend/tab_events.pug',
                chunks: ['tab_events']
            }),
            new LwcWebpackPlugin(),
            new webpack.DefinePlugin({
                DEBUG_MODE: true
            })
        ],
        resolve: {
            alias: {
                lwc: require.resolve('@lwc/engine'),
                img: path.join(__dirname, '/frontend/icons'),
                core: path.join(__dirname, '/frontend/core'),
                '@styles': path.resolve(__dirname, './frontend/common')
            }
        }
    }

    if (env.production) {
        settings.plugins.splice(0, 0, new CleanWebpackPlugin())
        settings.plugins.push(
            new AssetsPlugin({
                filename: 'assets.json',
                path: path.resolve(__dirname, './../src'),
                includeAllFileTypes: false,
                fileTypes: ['js']
            })
        )
    }
    return settings
}
