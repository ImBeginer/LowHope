var request = require('request'),
  moment = require('moment'),
  schedule = require('node-schedule'),
  coin_model = new(require('./../models/coinModel.js'))(),
  game_model = new(require('./../models/gameModel.js'))(),
  pusher = require('./../third-partyservice/pusher.js'),
  ss = require('simple-statistics'),
  sysgame_end_date, bit_data; 

class DataController{
  getData() {
    //get end date of active system game
    game_model.get_end_date_sys_game()
    .then((game)=>{
      sysgame_end_date = new Date(game.END_DATE).getTime();
    });
    //update time of new day
    schedule.scheduleJob('15 0 0 * * *', ()=>{
      game_model.get_end_date_sys_game()
      .then((game)=>{
        sysgame_end_date = new Date(game.END_DATE).getTime();
      });
    });
    // get coin data for calculating
    coin_model.getCoinRate()
    .then((res)=>{
      bit_data =  JSON.parse(JSON.stringify(res));
      bit_data = bit_data.map(Object.values);
      //get data from coindesk
      schedule.scheduleJob('* * * * *', () => {
        request('https://api.coindesk.com/v1/bpi/currentprice.json',
          function (error, response, body) {
            if (!error && response.statusCode === 200) {
              body = JSON.parse(body);
              bit_data.push([(new Date()).getTime(), body.bpi.USD.rate_float]);
              let ss_result = ss.linearRegression(bit_data),
                  price_preiction = ss.linearRegressionLine(ss_result)(sysgame_end_date);
                  
              let data = {
                price: body.bpi.USD.rate_float,
                update_at: moment().format("YYYY-MM-DD HH:mm")
              };
              //pusher
              pusher.trigger('bitcoin_rate', 'broadcasting', {
                price: data.price,
                update_at: data.update_at,
                price_preiction: price_preiction
              });
              //add data to db
              coin_model.insertCoinRate(data)
              .then((result) => {
                console.log('* Bitcoin rate: $ ' + data.price + ' at ' + data.update_at + " FOUND!\n");
              })
              .catch(err => console.log(err));
            }
            else {
              console.log('\n****************************************************************************');
              console.log('*                                                                          *');
              console.log('*    Unable to get bitcoin data. Plesase check your API or network! (>‿ ♥) *');
              console.log('*                                                                          *');
              console.log('****************************************************************************\n');
            }
          }
        );
      })
    });
  }
}

module.exports = DataController;