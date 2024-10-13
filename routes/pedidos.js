const express = require('express');
const router = express.Router();
const { database } = require('../config/helpers'); // Importando o 'database'

// Rota para obter todos os pedidos
router.get('/', async (req, res) => {
    const query = `
        SELECT p.id, prod.titulo AS nome, prod.descricao, prod.preco, u.nome_usuario
        FROM detalhes_pedidos AS dp
        JOIN pedidos AS p ON p.id = dp.pedido_id
        JOIN produtos AS prod ON prod.id = dp.produto_id
        JOIN usuarios AS u ON u.id = p.usuario_id
        ORDER BY p.id ASC
    `;

    try {
        const results = await database.raw(query);
        if (results[0].length > 0) {
            res.status(200).json(results[0]);
        } else {
            res.json({ message: 'Nenhum pedido encontrado' });
        }
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: 'Erro ao buscar pedidos' });
    }
});

// Rota para obter detalhes de um pedido por ID
router.get('/:id', async (req, res) => {
    const pedidoId = req.params.id; // Capturando o ID da URL
    console.log(`Pedido ID recebido: ${pedidoId}`); // Log para ver o ID capturado

    const query = `
        SELECT p.id, prod.titulo AS nome, prod.descricao, prod.preco, u.nome_usuario
        FROM detalhes_pedidos AS dp
        JOIN pedidos AS p ON p.id = dp.pedido_id
        JOIN produtos AS prod ON prod.id = dp.produto_id
        JOIN usuarios AS u ON u.id = p.usuario_id
        WHERE p.id = ?
    `;

    try {
        const results = await database.raw(query, [pedidoId]); // Usando o ID capturado na consulta
        console.log(`Resultados para pedido ${pedidoId}:`, results[0]); // Log para ver o resultado da consulta

        if (results[0].length > 0) {
            res.status(200).json(results[0]); // Retornando os resultados
        } else {
            res.status(404).json({ message: `Nenhum pedido encontrado para o ID ${pedidoId}` }); // Pedido não encontrado
        }
    } catch (err) {
        console.error(err); // Log para erros
        res.status(500).json({ error: 'Erro ao buscar o pedido' }); // Retornando erro
    }
});

// Rota para criar um novo pedido
router.post('/novo', async (req, res) => {
    const { usuario_id, produtos } = req.body;

    if (usuario_id !== null && usuario_id > 0 && !isNaN(usuario_id)) {
        try {
            // Criar o novo pedido
            const insertPedidoQuery = `INSERT INTO pedidos (usuario_id) VALUES (?)`;
            const result = await database.raw(insertPedidoQuery, [usuario_id]);
            const novoPedidoId = result[0].insertId;

            // Inserir detalhes do pedido para cada produto
            for (const p of produtos) {
                const produtoId = p.id;
                const noCarrinho = p.noCarrinho;

                // Buscar quantidade do produto no estoque
                const queryProduto = `SELECT quantidade FROM produtos WHERE id = ?`;
                const data = await database.raw(queryProduto, [produtoId]);

                if (data[0].length === 0) {
                    console.error(`Produto com ID ${produtoId} não encontrado.`);
                    continue;
                }

                let quantidadeAtual = data[0][0].quantidade;

                if (quantidadeAtual > 0) {
                    quantidadeAtual -= noCarrinho;
                    if (quantidadeAtual < 0) quantidadeAtual = 0;
                } else {
                    quantidadeAtual = 0;
                }

                // Inserir o detalhe do pedido
                const insertDetalheQuery = `INSERT INTO detalhes_pedidos (pedido_id, produto_id, quantidade) VALUES (?, ?, ?)`;
                await database.raw(insertDetalheQuery, [novoPedidoId, produtoId, noCarrinho]);

                // Atualizar a quantidade do produto
                const updateProdutoQuery = `UPDATE produtos SET quantidade = ? WHERE id = ?`;
                await database.raw(updateProdutoQuery, [quantidadeAtual, produtoId]);
            }

            res.json({
                message: `Pedido realizado com sucesso com ID ${novoPedidoId}`,
                success: true,
                pedido_id: novoPedidoId,
                produtos: produtos,
            });
        } catch (err) {
            console.error(err);
            res.json({ message: 'Falha ao criar novo pedido', success: false });
        }
    } else {
        res.json({ message: 'Novo pedido falhou', success: false });
    }
});

// Rota de simulação de pagamento
router.post('/pagamento', (req, res) => {
    setTimeout(() => {
        res.status(200).json({ success: true });
    }, 3000);
});

module.exports = router;
