/**
 *   Webpack v4
 1. npm --version
 2. npm init -y
 3. npm install webpack webpack-cli --save-dev
 4. npm install babel-core babel-loader babel-preset-env --save-dev
 5. nano .babelrc
 {
     "presets": [
        "env"
      ]
 }
 6. npm install extract-text-webpack-plugin@next --save-dev
 7. npm install style-loader css-loader --save-dev
 8. npm install node-sass sass-loader --save-dev
 9. npm install postcss-loader autoprefixer --save-dev
 10. npm install resolve-url-loader --save-dev
 11. npm install file-loader --save-dev
 12. npm install assets-webpack-plugin --save-dev
 13. npm install webpack-dev-server --save-dev
 *
 */
const THEME_NAME = 'krasnagorka'

let entries = {
    home: './home.js',
    category: './category.js'
}

let pugs = {
    home: {
        title: 'home title'
    },
    category: {
        title: 'category title'
    }
}

const NODE_ENV = process.env.NODE_ENV
const DEV_MODE = NODE_ENV == 0
const WP = NODE_ENV == 2

const HtmlWebpackPlugin = require('html-webpack-plugin')
const path = require('path')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const AssetsPlugin = require('assets-webpack-plugin')
const autoprefixer = require('autoprefixer')
const rimraf = require('rimraf')

module.exports = {
    context: path.resolve(__dirname, 'assets/templates'),
    entry: entries,

    output: {
        path: path.resolve(__dirname, 'src'),
        publicPath: '/src/',
        filename: 'js/[name]' + (DEV_MODE ? '.js' : '.[hash].min.js'),
        chunkFilename: 'js/[name]' + (DEV_MODE ? '.js' : '.[hash].min.js'),
        library: '[name]'
    },
    optimization: {
        runtimeChunk: { name: 'common' },
        splitChunks: {
            cacheGroups: {
                default: false,
                commons: {
                    test: /\.(js|scss)$/,
                    chunks: 'all',
                    minChunks: 2,
                    name: 'common',
                    enforce: true
                }
            }
        }
    },
    devtool: DEV_MODE ? 'source-map' : false,
    devServer: {
        overlay: {
            warnings: true,
            errors: true
        }
    },
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
                test: /\.js$/,
                exclude: /node_modules\/(?!(dom7|ssr-window|swiper)\/).*/,
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.css$/,
                use: [
                    {
                        loader: 'style-loader'
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            minimize: true
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: [
                                autoprefixer({
                                    browsers: ['ie >= 10', 'last 3 version']
                                })
                            ],
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'resolve-url-loader'
                    }
                ]
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        {
                            loader: 'css-loader',
                            options: {
                                minimize: !DEV_MODE
                            }
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: [
                                    autoprefixer({
                                        browsers: ['ie >= 10', 'last 3 version']
                                    })
                                ],
                                sourceMap: true
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
                            outputPath: './icons/',
                            name: '[name].[hash:6].[ext]',
                            publicPath: WP
                                ? `/wp-content/themes/${THEME_NAME}/src/icons/`
                                : '/src/icons/'
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
                            outputPath: './fonts/',
                            name: '[name].[hash:6].[ext]',
                            publicPath: WP
                                ? `/wp-content/themes/${THEME_NAME}/src/fonts/`
                                : '/src/fonts/'
                        }
                    }
                ]
            },
            // Font Loader
            {
                test: /\.(mp4)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            outputPath: './video/',
                            name: '[name].[hash:6].[ext]',
                            publicPath: WP
                                ? `/wp-content/themes/${THEME_NAME}/src/video/`
                                : '/src/video/'
                        }
                    }
                ]
            }
        ]
    },
    plugins: [
        {
            apply: (compiler) => {
                if (!DEV_MODE) {
                    rimraf.sync(compiler.options.output.path)
                }
            }
        },
        new ExtractTextPlugin({
            filename: 'css/[name]' + (DEV_MODE ? '.css' : '.[hash].min.css'),
            disable: false,
            allChunks: true
        }),
        new AssetsPlugin({
            filename: 'assets.json',
            path: path.resolve(__dirname, 'src')
        })
    ]
}

initHtmlPugs()

function initHtmlPugs() {
    for (let page in pugs) {
        module.exports.plugins.push(
            new HtmlWebpackPlugin({
                title: pugs[page].title,
                filename: `${page}.html`,
                chunks: [page, 'common'],
                template: path.resolve(__dirname, 'assets/templates') + `/${page}.pug`,
            })
        )
    }
}
