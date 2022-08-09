const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const LWCWebpackPlugin = require('lwc-webpack-plugin')
const path = require('path')
const TerserJSPlugin = require('terser-webpack-plugin')
const AssetsPlugin = require('assets-webpack-plugin')
const autoprefixer = require('autoprefixer')
const webpack = require('webpack')

module.exports = (env) => {
    const IS_DEV = env.development
    const publicPath = IS_DEV ? '' : '/wp-content/themes/krasnagorka/src/'
    const settins = {
        entry: {
            booking: './frontend/booking.js'
        },
        optimization: {
            minimize: true,
            minimizer: [new TerserJSPlugin()]
        },
        stats: {
            children: true,
            errorDetails: true
        },
        devServer: {
            overlay: true,
            // contentBase: publicPath,
            proxy: {
                '/': {
                    target: 'https://krasnagorka.by/',
                    changeOrigin: true
                }
            }
        },
        output: {
            path: path.resolve(__dirname, './../src'),
            publicPath: publicPath,
            filename: `javascript/[name].[hash].min.js`,
            chunkFilename: 'javascript/[name]' + (IS_DEV ? '.js' : '.[hash].min.js')
        },
        mode: env.production ? 'production' : 'development',
        module: {
            rules: [
                {
                    test: /\.m?js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: [['@babel/preset-env']],
                            plugins: ['@babel/plugin-transform-runtime']
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
                                sourceMap: true,
                                additionalData: (content, loaderContext) => {
                                    // const { resourcePath, rootContext } = loaderContext;
                                    // const relativePath = path.relative(rootContext, resourcePath);
                                    return content;
                                }
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
                                outputPath: IS_DEV ? './frontend/icons/' : `/icons/`,
                                name: '[name].[hash:6].[ext]',
                                publicPath: IS_DEV ? '/frontend/icons/' : `${publicPath}icons/`
                            }
                        }
                    ]
                }
            ]
        },
        plugins: [
            new HtmlWebpackPlugin({
                title: 'Booking page',
                filename: `booking.html`,
                template: './frontend/booking.pug',
                chunks: ['booking']
            }),
            new LWCWebpackPlugin(),
            new webpack.DefinePlugin({
                DEBUG_MODE: true
            }),
        ],
        resolve: {
            alias: {
                lwc: require.resolve('@lwc/engine'),
                img: path.join(__dirname, '/assets/img')
            }
        }
    }

    if (!IS_DEV) {
        settins.plugins.splice(0, 0, new CleanWebpackPlugin())
        settins.plugins.push(
            new AssetsPlugin({
                filename: 'assets.json',
                path: path.resolve(__dirname, './../src')
            })
        )
    }
    return settins
}
