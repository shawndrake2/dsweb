const path = require('path')

const getJsPath = () => {
  return path.resolve(__dirname, '../', 'public', 'assets', 'js')
}

module.exports = {
  mode: 'development',
  entry: `${getJsPath()}/main.js`,
  output: {
    path: path.resolve(getJsPath(), 'dist'),
    filename: 'main.bundle.js'
  },
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js'
    },
    extensions: ['*', '.js', '.vue', '.json']
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      },
      {
        test: /\.scss$/,
        use: [
          'vue-style-loader',
          'css-loader',
          'sass-loader'
        ]
      },
      {
        test: /\.css$/,
        loader: ['style-loader', 'css-loader']
      }
    ]
  }
}
