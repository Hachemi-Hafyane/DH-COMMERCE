const mysql = require('mysql2');

// Criando a conexão com o banco de dados
let conn = mysql.createConnection({
    host: 'localhost',
    port: 3306,
    user: 'root',
    password: '', // use 'password' no lugar de 'pass'
    database: 'dh_commerce'
});

// Conectando ao banco de dados
conn.connect((err) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados:', err);
        return;
    }
    console.log('Conectado ao banco de dados');
});

// Exportando a conexão para ser utilizada em outros lugares
module.exports = {
    database: conn
};
