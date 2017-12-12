var express = require('express'),
    router = express.Router(),
    coin_model = new(require('./../models/coinModel.js'));
router.get('/rate', function(req, res) {
	coin_model.getCoinRate()
	.then((result)=>{
		res.jsonp(result);
	})
	.catch(err => console.log(err));
});

module.exports = router;