const knex = require('knex')({
    client: 'mysql2',
    connection: {
        host: 'localhost',
        port: 3306,
        user: 'root',
        password: '', // seu password aqui
        database: 'dh_commerce'
    }
});

module.exports = {
    database: knex
};
