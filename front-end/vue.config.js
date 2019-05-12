module.exports = {
  devServer: {
    proxy: 'http://13.209.125.223/',
    headers:{
      "Access-Control-Allow-Origin":"*",
      "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
      "Access-Control-Allow-Headers": "X-Requested-With, content-type, Authorization"
    }
  }
}
