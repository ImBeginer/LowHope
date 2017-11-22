var mysql = require('mysql');
var connection = mysql.createConnection({
	host: "35.185.45.47",
	user: "lowhope",
	password: "p123",
	port: 3306,
	database: "lowhope_db",
	multipleStatements: true,
	dateStrings: true
});

module.exports = connection;