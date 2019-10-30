const path = require('path'),
settings = require('./settings');

module.exports = {
  entry: {
    App: settings.themeLocation + "js/scripts.js"
  },
  output: {
    path: path.resolve(__dirname, settings.themeLocation + "js"),
    filename: "scripts-bundled.js"
  },
  module: {
    // loaders:[
    //   {test: /\.css$/, loader: "style!css" },
    //   {test: /\.(jpe?g|png|gif$)/i, loader:"file"},
    // ],
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ],
  },
  // plugins: [
  //   new webpack.ProvidePlugin({
  //       "$": "jquery",
  //       "jQuery" : "jquery",
  //       "window.jQuery": "jquery",
  //   })
  // ],
  // resolve : {
  //   alias: {
  //     // bind version of jquery-ui
  //     "jquery-ui": "jquery-ui/ui/version.js",      
  //     // bind to modules;
  //     modules: path.join(__dirname, "node_modules")
  //   }
  // },
  mode: 'development'
}