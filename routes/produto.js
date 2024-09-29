const express = require('express')
const router = express.Router()
const {database} = require('../config/helper')

router.get('/', function(req,res,next){
    
    let page = (req.query.page !== undefined && req.query.page !== 0) ? req.query.page : 1
    const limit = (req.query.limit !== undefined && req.query.limit !== 0) ? req.query.limit : 10
    let startValue;
    let endValue;
    if(page > 0){
        startValue = (page * limit) - limit;
        endValue = page * limit
    }else{
        startValue = 0
        endValue = 10
    }

    database.table('produtos as p')
        .join([{
            table:'categorias as c',
            on: 'c.id = p.categoria_id'
        }])
        withFields(['c.titulo as categoria',
                    'p.titulo as nome',
                    'p.preco',
                    'p.quantidade',
                    'p.imagem',
                    'p.id'
        ])
        .slice(startValue, endValue)
        .short({id: .1})
        .getAll()
        .then(prods => {
            if(prods.length > 0){
                res.status(200).json({
                    count: prods.length,
                    products:prods  
                })       
            }else{
                res.json({message:'Nenhum produto encontrado'})
            }
        }).catch(err => console.log(err))

})

module.exports = router