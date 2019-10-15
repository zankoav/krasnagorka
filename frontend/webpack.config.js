const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const LWCWebpackPlugin = require('lwc-webpack-plugin');
const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const AssetsPlugin = require('assets-webpack-plugin');
const autoprefixer = require('autoprefixer');

module.exports = env => {
    const IS_DEV = env.MODE === 'development';
    const settins = {
        devtool: IS_DEV ? 'inline-source-map' : 'none',
        devServer: {
            contentBase: path.resolve(__dirname, 'public'),
            proxy: {
                '/': {
                    target: 'http://localhost:3000',
                    changeOrigin: true
                }
            }
        },
        entry: {
            booking: './templates/booking.js'
        },
        output: {
            path: path.resolve(__dirname, 'public'),
            filename: 'javascript/[name].[hash].min.js',
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
                                    ? './icons/'
                                    : '/public/icons/',
                                name: '[name].[hash:6].[ext]',
                                publicPath: IS_DEV
                                    ? '/public/icons/'
                                    : '/icons/'
                            }
                        }
                    ]
                }
            ]
        },
        plugins: [
            new LWCWebpackPlugin({
                namespace: {
                    z: path.resolve('./components')
                }
            }),
            new ExtractTextPlugin({
                filename: 'stylesheets/[name].[hash].min.css',
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
                path: path.resolve(__dirname, 'public/')
            })
        );
    }

    if (IS_DEV) {
        settins.plugins.splice(
            0,
            0,
            new HtmlWebpackPlugin({
                title: 'Booking form page',
                filename: `booking.html`,
                template: './templates/booking.pug',
                chunks: ['booking']
            })
        );
    }

    return settins;
};
