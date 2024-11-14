<?php

function produtos($conn){
    $sql = 'SELECT * FROM produtos ORDER BY id DESC';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0){  
        $produtos = $stmt->fetchAll();
    }else{  
        $produtos = 0;
    }
    return $produtos;
}

function editProdutos($conn,$id){
    $sql = 'SELECT * FROM produtos WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    if($stmt->rowCount() > 0){  
        $produto = $stmt->fetch();
    }else{  
        $produto = 0;
    }
    return $produto;
}

function search_produtos($conn, $key) {
    $sql = "SELECT * FROM produtos WHERE titulo LIKE ? OR descricao LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["%$key%", "%$key%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    


