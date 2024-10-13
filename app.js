const express = require('express');
const path = require('path');
const cookieParser = require('cookie-parser');
const logger = require('morgan');
const cors = require('cors');

// Inicializando o app
const app = express();

// Definindo as rotas (isso deve vir depois da inicialização do app)
const produtoRouter = require('./routes/produto');
const pedidoRouter = require('./routes/pedidos');

// Middlewares
app.use(cors({
    origin: "*",
    methods: ['GET', 'POST', 'PATCH', 'PUT', 'DELETE'],
    allowedHeaders: 'Content-type, Authorization, Origin, X-Requested-With, Accept'
}));

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

// Rotas
app.use('/api/produto', produtoRouter);
app.use('/api/pedidos', pedidoRouter);

module.exports = app;
