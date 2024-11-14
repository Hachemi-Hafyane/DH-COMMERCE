<?php
session_start();
if(isset($_SESSION["user_id"]) && $_SESSION["user_email"] && $_SESSION['user_tipo'] === 'Admin') {   
    include("../DB/db_conn.php");
    if(isset($_POST['nomeCategoria'])){
    $nomeCat = $_POST['nomeCategoria']; 
        if(empty($nomeCat)){
        $msgErr = "O campo categoria está vazio";   
        header("Location: ../pagina/addCategoria.php?error=$msgErr");
        exit();
        }else{
            $sql = "INSERT INTO categorias (titulo) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$nomeCat]);
            if($res){
                $msgSuccess = "Cadastro de categoria realizado com sucesso";   
                header("Location: ../pagina/addCategoria.php?success=$msgSuccess");
                exit();
            }else{
                $msgErr = "Ocorreu erro no cadastro da categoria";   
                header("Location: ../pagina/addCategoria.php?error=$msgErr");
                exit();
            }
        }
    }else{
    header("Location: ../pagina/admin.php");
    }

}else{
    if($_SESSION['user_tipo'] !== 'Admin'){
      header("Location: ../pagina/index.php");
    exit();
    }else{
    header("Location: ../pagina/login.php");
    exit();
  }
  }

