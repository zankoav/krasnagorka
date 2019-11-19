const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const LWCWebpackPlugin = require('lwc-webpack-plugin');
const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const AssetsPlugin = require('assets-webpack-plugin');
const autoprefixer = require('autoprefixer');


module.exports = env => {
    const IS_DEV = env.MODE === 'development';
    const publicPath = IS_DEV ? '' :'/wp-content/themes/krasnagorka/src/';
    const settins = {
        devtool: IS_DEV ? 'inline-source-map' : 'none',
        // devServer: {
        //     contentBase: path.resolve(__dirname, './../src'),
        //     proxy: {
        //         '/': {
        //             target: 'http://localhost:3000',
        //             changeOrigin: true
        //         }
        //     }
        // },
        entry: {
            booking: './frontend/booking.js'
        },
        output: {
            path: path.resolve(__dirname, './../src'),
            publicPath: publicPath,
            filename: `javascript/[name].[hash].min.js`,
            chunkFilename:
            'javascript/[name]' + (IS_DEV ? '.js' : '.[hash].min.js'),
            library: '[name]'
        },
        mode: env.MODE,
        module: {
            rules: [
                {
                    test: /\.pug$/,
                    loader: 'pug-loader',
                    options: {
                        pretty: true
                    }
                },
                {
                    test: /\.scss$/,
                    exclude: /(node_modules)/,
                    use: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: [
                            {
                                loader: 'css-loader'
                            },
                            {
                                loader: 'postcss-loader',
                                options: {
                                    plugins: () => [autoprefixer]
                                }
                            },
                            {
                                loader: 'resolve-url-loader'
                            },
                            {
                                loader: 'sass-loader',

                                options: {
                                    sourceMap: true
                                }
                            }
                        ]
                    })
                },
                // Image Loader
                {
                    test: /\.(jpg|png|svg|gif)$/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                outputPath: IS_DEV
                                    ? './frontend/icons/'
                                    : `/icons/`,
                                name: '[name].[hash:6].[ext]',
                                publicPath: IS_DEV
                                    ? '/frontend/icons/'
                                    : `${publicPath}icons/`
                            }
                        }
                    ]
                },
                // Font Loader
                {
                    test: /\.(eot|ttf|woff|woff2)$/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                outputPath: IS_DEV
                                    ? './frontend/fonts/'
                                    : './fonts/',
                                name: '[name].[hash:6].[ext]',
                                publicPath: IS_DEV
                                    ? '/frontend/fonts/'
                                    : `${publicPath}fonts/`
                            }
                        }
                    ]
                }
            ]
        },
        plugins: [
            new LWCWebpackPlugin({
                namespace: {
                    z: path.resolve('./frontend/components')
                }
            }),
            new ExtractTextPlugin({
                filename: `stylesheets/[name].[hash].min.css`,
                disable: false,
                allChunks: false
            })
        ],
        resolve: {
            alias: {
                lwc: require.resolve('@lwc/engine')
            }
        }
    };

    if (!IS_DEV) {
        settins.plugins.splice(0, 0, new CleanWebpackPlugin());
        settins.plugins.push(
            new AssetsPlugin({
                filename: 'assets.json',
                path: path.resolve(__dirname, './../src')
            })
        );
    }

    if (IS_DEV) {
        settins.plugins.splice(
            0,
            0,
            new HtmlWebpackPlugin({
                title: 'Booking page',
                filename: `booking.html`,
                template: './frontend/booking.pug',
                chunks: ['booking']
            })
        );
    }

    return settins;
};
