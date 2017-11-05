var mysql = require('mysql');
var connection = mysql.createConnection({
	// host: "mysql8.db4free.net",
	// user: "hotaru",
	// password: "lowhope12345",
	// port: 3307,
	// database: "lowhope_capstone",
	host: "localhost",
	user: "root",
	password: "p123",
	//port: 3307,
	database: "lowhope_db",
	multipleStatements: true,
	dateStrings: true
});

module.exports = connection;