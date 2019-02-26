const fs = require('fs');
const path = require('path');
const webpack = require('webpack');

/**
 * This path assumes that Carbon Fields and the current template
 * are both in the `/vendor` directory inside your theme - change the path if needed.
 */
const root = path.resolve(__dirname, '../../htmlburger/carbon-fields');

if (!fs.existsSync(root)) {
  console.error('Could not find Carbon Fields folder.');
  process.exit(1);
  return;
}

module.exports = env => {
  const plugins = [
    new webpack.ProvidePlugin({
      jQuery: 'jquery',
    }),

    new webpack.DllReferencePlugin({
      sourceType: 'this',
      manifest: require(path.resolve(root, 'assets/dist/carbon.vendor.json')),
    }),

    new webpack.DllReferencePlugin({
      context: root,
      sourceType: 'this',
      manifest: require(path.resolve(root, 'assets/dist/carbon.core.json')),
    }),
  ];

  if (env.production) {
    plugins.push(new webpack.optimize.UglifyJsPlugin());
  }

  return {
    entry: './assets/js/bootstrap.js',

    output: {
      path: path.resolve(__dirname, 'assets/js'),
      filename: 'bundle.js',
    },

    module: {
      rules: [
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          loader: 'babel-loader',
          options: {
            cacheDirectory: true,
          },
        },
      ],
    },

    resolve: {
      extensions: ['.js', '.jsx', '.css'],
      modules: [
        path.resolve(__dirname, 'assets/js'),
        path.resolve(root, 'assets/js'),
        'node_modules',
      ],
    },

    plugins,

    externals: {
      jquery: 'jQuery',
    },

    devtool: '#cheap-module-eval-source-map',
  };
};
