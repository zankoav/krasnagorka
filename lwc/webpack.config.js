const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const LWCWebpackPlugin = require('lwc-webpack-plugin');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const AssetsPlugin = require('assets-webpack-plugin');
const autoprefixer = require('autoprefixer');
const webpack = require('webpack');

module.exports = env => {
    const IS_DEV = env.MODE === 'development';
    const publicPath = IS_DEV ? '' : '/wp-content/themes/krasnagorka/src/';
    const settins = {
        devtool: IS_DEV ? 'inline-source-map' : 'none',
        entry: {
            booking: './frontend/booking.js'
        },
        optimization: {
            minimizer: [
                new TerserJSPlugin({}),
                new OptimizeCSSAssetsPlugin({})
            ],
        },
        // devServer: {
        //     overlay: true,
        //     contentBase: publicPath,
        //     proxy: {
        //         '/': {
        //             target: 'https://krasnagorka.by/',
        //             changeOrigin: true
        //         }
        //     }
        // },
        output: {
            path: path.resolve(__dirname, './../src'),
            publicPath: publicPath,
            filename: `javascript/[name].[hash].min.js`,
            chunkFilename:
                'javascript/[name]' + (IS_DEV ? '.js' : '.[hash].min.js')
        },
        mode: env.MODE,
        module: {
            rules: [
                {
                    test: /\.m?js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                [
                                    "@babel/preset-env"
                                ]
                            ],
                            plugins: [
                                "@babel/plugin-transform-runtime"
                            ]
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
                    test: /\.(css|sass|scss)$/,
                    exclude: /(node_modules)/,
                    use: [
                        {
                            loader: MiniCssExtractPlugin.loader
                        },
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
            new MiniCssExtractPlugin({
                filename: IS_DEV ? "stylesheets/[name].css" : "stylesheets/[name].[hash:6].min.css",
            }),
            new HtmlWebpackPlugin({
                title: 'Booking page',
                filename: `booking.html`,
                template: './frontend/booking.pug',
                chunks: ['booking']
            }),
            new LWCWebpackPlugin({
                namespace: {
                    z: path.resolve('./frontend/components')
                }
            }),
            // new webpack.DefinePlugin({
            //     DEBUG_MODE: 'ANY value'
            // }),
        ],
        resolve: {
            alias: {
                lwc: require.resolve('@lwc/engine'),
                img: path.join(__dirname, '/assets/img')
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
    return settins;
};
