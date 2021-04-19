const path = require('path');
const fs = require('fs');
const webpack = require('webpack');
const LWCWebpackPlugin = require('lwc-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const AssetsPlugin = require("assets-webpack-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const TerserJSPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const autoprefixer = require('autoprefixer');

module.exports = env => {
    const IS_DEV = env.mode === 'development';
    const DEBUG_MODE = env.debug == '1';
    const publicPath = IS_DEV ? '/' : `./src`;
    const productionPrefix = IS_DEV ? '/' : '/wp-content/themes/krasnagorka/LS/frontend/src';

    const plugins = [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: IS_DEV ? "css/[name].css" : "css/[name].[hash:6].min.css",
        }),
        new HtmlWebpackPlugin({
            filename: "main_desktop.html",	
			title:'Main Desktop',
			inject: 'body',
			minify:false,
			chunks:['main_desktop'],
            template: path.resolve(__dirname, 'assets/desktop/main.pug')
        }),
		new HtmlWebpackPlugin({
            filename: "main_mobile.html",	
			title:'Main Mobile',
			inject: 'body',
			minify:false,
			chunks:['main_mobile'],
            template: path.resolve(__dirname, 'assets/mobile/main.pug')
        }),
        new LWCWebpackPlugin({
            namespace: {
                c: path.resolve('./assets/components')
            }
        }),
        new webpack.DefinePlugin({
            DEBUG_MODE: DEBUG_MODE
        })
    ];

    const output = {
        filename: IS_DEV ? 'js/[name].js' : 'js/[name].[hash:6].min.js',
        publicPath: publicPath,
        chunkFilename: IS_DEV ? 'js/[name].js' : 'js/[name].[hash:6].min.js'
    }

    if (!IS_DEV) {
        plugins.push(new AssetsPlugin({
            path: publicPath,
            filename: 'assets.json',
            prettyPrint: IS_DEV,
            processOutput: function (assets) {
                const result = {};
                for (const key in assets) {
                    if (key) {
                        result[key] = {
                            css: assets[key].css,
                            js: assets[key].js
                        }
                    }
                }
                return JSON.stringify(result);
            }
        }));

        output.path = path.resolve(__dirname, publicPath);
        output.publicPath = productionPrefix;
    }



    const config = {
        optimization: {
            minimizer: [
                new TerserJSPlugin({}),
                new OptimizeCSSAssetsPlugin({})
            ],
        },
        mode: env.mode || 'development',
        entry: {
            main_desktop: path.resolve(__dirname, 'assets/desktop/main.js'),
            main_mobile: path.resolve(__dirname, 'assets/mobile/main.js')
        },
        output: output,
        module: {
            rules: [
                {
                    test: /\.m?js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                "@babel/preset-env"
                            ],
                            plugins: [
                                "@babel/plugin-transform-runtime"
                            ]
                        }
                    }
                },
                {
                    test: /\.scss$/,
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
                                prependData: (loaderContext) => {
                                    const constants = fs.readFileSync('./assets/common/constants.scss', "utf8");
                                    const { resourcePath, rootContext } = loaderContext;
                                    const relativePath = path.relative(rootContext, resourcePath);
                                    if (relativePath.includes('common.scss')) {
                                        const reset = fs.readFileSync('./assets/common/reset.scss', "utf8");
                                        return `
                                            ${constants}
                                            ${reset}
                                        `;
                                    }
                                    return constants;
                                },
                                sourceMap: true
                            }
                        }
                    ]
                },
                {
                    test: /\.pug$/,
                    loader: "pug-loader",
                    options: {
                        pretty: IS_DEV
                    }
                },
                {
                    test: /\.(jpg|png|svg|gif)$/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: IS_DEV ? 'img/[name].[ext]' : 'img/[name].[hash:6].[ext]',
                                publicPath: IS_DEV ? publicPath : productionPrefix
                            }
                        }
                    ]
                }
            ]
        }, 
        devServer: {
            overlay: true,
            contentBase: publicPath,
            proxy: {
                '/': {
                    target: 'https://krasnagorka.by/',
                    changeOrigin: true
                }
            }
        },
        plugins: plugins,
        resolve: {
            alias: {
                lwc: require.resolve('@lwc/engine'),
                img: path.join(__dirname, '/assets/img')
            }
        }
    }

    return config;
};