const express = require('express');
const router = express.Router();
const { database } = require('../config/helpers');

// Rota para listar produtos com paginação
router.get('/', async (req, res) => {
    let page = (req.query.page !== undefined && req.query.page !== 0) ? req.query.page : 1;
    const limit = (req.query.limit !== undefined && req.query.limit !== 0) ? req.query.limit : 10;
    let startValue = (page > 0) ? (page * limit) - limit : 0;

    try {
        const products = await database('produtos as p')
            .join('categorias as c', 'c.id', 'p.categoria_id')
            .select('c.titulo as categoria', 'p.titulo as nome', 'p.preco', 'p.quantidade', 'p.imagem', 'p.id')
            .limit(limit)
            .offset(startValue);

        if (products.length > 0) {
            res.status(200).json({
                count: products.length,
                products: products
            });
        } else {
            res.json({ message: 'Nenhum produto encontrado' });
        }
    } catch (error) {
        console.log(error);
        res.status(500).json({ message: 'Erro ao buscar produtos' });
    }
});

// Rota para obter detalhes de um produto pelo ID
router.get('/:produtoId', async (req, res) => {
    const produtoId = req.params.produtoId;

    try {
        const product = await database('produtos as p')
            .join('categorias as c', 'c.id', 'p.categoria_id')
            .select('c.titulo as categoria', 'p.titulo as nome', 'p.preco', 'p.quantidade', 'p.imagem', 'p.imagens', 'p.id')
            .where('p.id', produtoId)
            .first();

        if (product) {
            res.status(200).json(product);
        } else {
            res.json({ message: `Nenhum produto encontrado com o ID ${produtoId}` });
        }
    } catch (error) {
        console.log(error);
        res.status(500).json({ message: 'Erro ao buscar produto' });
    }
});

module.exports = router;
