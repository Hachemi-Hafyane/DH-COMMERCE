<?php 

function categorias($conn){
    $sql = "SELECT * FROM categorias";
    $stmt = $conn ->prepare( $sql );
    $stmt->execute();
    if($stmt->rowCount() > 0){
        $categorias = $stmt->fetchAll();
    }else{
        $categorias = 0;
    }
    return $categorias;
}


function editarCategorias($conn,$id){
    $sql = "SELECT * FROM categorias WHERE id=?";
    $stmt = $conn ->prepare( $sql );
    $stmt->execute([$id]);
    if($stmt->rowCount() > 0){
        $categoria = $stmt->fetch();
    }else{
        $categoria = 0;
    }
    return $categoria;
}