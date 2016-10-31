var path = require("path");
var webpack = require("webpack");
module.exports = {
  module: {
    loaders: [
      { test: /\.json$/,   loader: "json-loader" },
      { test: /\.coffee$/, loader: "coffee-loader" },
      { test: /\.css$/,    loader: "style-loader!css-loader" },
      { test: /\.less$/,   loader: "style-loader!css-loader!less-loader" },
      { test: /\.html$/,   loader: "raw" }
    ]
  },
  bail: true,
  cache: true,
  entry: {
    init: './src/Morenware/DutilsBundle/Resources/client/app/init.coffee',
    filemanager: './src/Morenware/DutilsBundle/Resources/client/filemanager/filemanager.coffee'
  },
  output: {
    path: './web/client/js/app',
    filename: '[name].js'
  },
   plugins: [
    new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /de|fr|hu/)
    ],
  resolve: {
            alias: {
                moment: path.join(__dirname, "node_modules/moment/moment.js")
            },

            extensions: ['', '.js', '.coffee']

        }


};
