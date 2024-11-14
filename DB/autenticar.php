<?php
session_start();

if(isset($_POST['email']) && isset($_POST['password'])){

    include "./db_conn.php";

    include "validacao.php";

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $texto = "Email";
    $caminho = "../pagina/login.php";
    $ms = "error";
    vazio($email, $texto,$caminho, $ms, "");

    $texto = "Password";
    $caminho = "../pagina/login.php";
    $ms = "error";
    vazio($password, $texto,$caminho, $ms, "");

    $sql = "SELECT * FROM usuarios WHERE email=?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    if($stmt->rowCount() === 1){
        $user = $stmt->fetch();
        $user_id = $user["id"];
        $user_email = $user["email"];
        $user_password = $user["senha"];
        if($email === $user_email){
            if(password_verify($password,$user_password)){
               $_SESSION["user_id"] = $user_id;
               $_SESSION["user_email"] = $user_email;
               $_SESSION["user_password"] = $user_password;
               header("Location: ../pagina/admin.php");
            }
        }else{
            $em = 'A senha ou o email estão incorretos';
             header("Location: ../pagina/login.php?error=$em");
        }
    }else{
        $em = 'A senha ou o email estão incorretos';
        header("Location: ../pagina/login.php?error=$em");
    }

}else{
    header("Location: ../pagina/login.php");
}