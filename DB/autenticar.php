<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {

    include "./db_conn.php";
    include "validacao.php";

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validação dos campos vazios
    vazio($email, "Email", "../pagina/login.php", "error", "");
    vazio($password, "Password", "../pagina/login.php", "error", "");

    // Consulta para verificar o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();
        $user_id = $user["id"];
        $user_email = $user["email"];
        $user_password = $user["senha"];
        $user_tipo = $user["tipo"];  // Capturando o tipo de usuário
        $user_nome = $user["nome_usuario"];

        if ($email === $user_email) {
            // Verifica se a senha é correta
            if (password_verify($password, $user_password)) {
                $_SESSION["user_id"] = $user_id;
                $_SESSION["user_email"] = $user_email;
                $_SESSION["user_tipo"] = $user_tipo;
                $_SESSION["user_nome"] = $user_nome;

                // Redireciona de acordo com o tipo de usuário
                if ($user_tipo === 'Admin') {
                    header("Location: ../pagina/admin.php");
                } else {
                    header("Location: ../pagina/index.php");
                }
                exit();
            }
        }

        $em = 'A senha ou o email estão incorretos';
        header("Location: ../pagina/login.php?error=$em");
    } else {
        $em = 'A senha ou o email estão incorretos';
        header("Location: ../pagina/login.php?error=$em");
    }
} else {
    header("Location: ../pagina/login.php");
}
