var request = require('request'),
  moment = require('moment'),
  schedule = require('node-schedule'),
  coin_model = new(require('./../models/coinModel.js'))(),
  pusher = require('./../third-partyservice/pusher.js'); 

class DataController{
  getData() {
    schedule.scheduleJob('* * * * *', function() {
      request('https://api.coindesk.com/v1/bpi/currentprice.json',
        function(error, response, body) {
          if (!error && response.statusCode === 200) {
            body = JSON.parse(body);
            let data = {
              price: body.bpi.USD.rate_float,
              update_at: moment().format("YYYY-MM-DD HH:mm")
            };

            pusher.trigger('bitcoin_rate', 'broadcasting', data);

            coin_model.insertCoinRate(data)
            .then((result)=>{
              console.log('* Bitcoin rate: $ '+ data.price + ' at ' + data.update_at + " FOUND!\n");
            })
            .catch(err => console.log(err));
          }
          else{
            console.log('\n****************************************************************************');
            console.log('*                                                                          *');
            console.log('*    Unable to get bitcoin data. Plesase check your API or network! (>‿ ♥) *');
            console.log('*                                                                          *');
            console.log('****************************************************************************\n');
          }
        }
      );
    })
  }
}

module.exports = DataController;