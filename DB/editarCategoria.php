
<?php
session_start();
if(isset($_SESSION["user_id"]) && $_SESSION["user_email"]) {    
    include("../DB/db_conn.php");
    if(isset($_POST['nomeCategoria']) && isset($_POST['idCategoria'])){
    $nomeCat = $_POST['nomeCategoria'];
    $idCat = $_POST['idCategoria']; 
        if(empty($nomeCat)){
        $msgErr = "O campo categoria está vazio";   
        header("Location: ../pagina/editCategoriaPag.php?error=$msgErr&id=$idCat");
        exit();
        }else{
            $sql = "UPDATE categorias SET titulo = ? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$nomeCat,$idCat]);
            if($res){
                $msgSuccess = "Atualização realizada com sucesso";   
                header("Location: ../pagina/editCategoriaPag.php?success=$msgSuccess&id=$idCat");
                exit();
            }else{
                $msgErr = "Ocorreu erro na atualização da categoria";   
                header("Location: ../pagina/editCategoriaPag.php?error=$msgErr&id=$idCat");
                exit();
            }
        }
    }else{
    header("Location: ../pagina/admin.php");
    }

}else{
    header("Location: ../pagina/login.php");
    exit();
}

