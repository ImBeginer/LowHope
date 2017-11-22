var request = require('request'),
  moment = require('moment'),
  schedule = require('node-schedule'),
  coin_model = new(require('./../models/coinModel.js'))();

module.exports = {
  getData: function(pusher, connection) {
    schedule.scheduleJob('* * * * *', function() {
      request('https://api.coindesk.com/v1/bpi/currentprice.json',
        function(error, response, body) {
          if (!error && response.statusCode === 200) {
            body = JSON.parse(body);
            var data = {
              price: body.bpi.USD.rate_float,
              update_at: moment().format("YYYY-MM-DD HH:mm")
            };

            pusher.trigger('bitcoin_rate', 'broadcasting', data);

            coin_model.insertCoinRate(connection, data, function(result) {
              console.log(JSON.stringify(data) + " === Added!\n");
            });
          }
        }
      );
    })
  }
}