<?php
session_start();
include("db_conn.php");

if (isset($_POST['nome_usuario']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['primeiro_nome']) && isset($_POST['ultimo_nome']) && isset($_POST['data_nasc'])) {
    $nome_usuario = $_POST['nome_usuario'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Encriptação da senha
    $primeiro_nome = $_POST['primeiro_nome'];
    $ultimo_nome = $_POST['ultimo_nome'];
    $data_nasc = $_POST['data_nasc'];
    $tipo = 'Usuario'; // Definindo o tipo padrão como 'Usuario'

    try {
        $query = "INSERT INTO usuarios (nome_usuario, email, senha, primeiro_nome, ultimo_nome, data_nasc, tipo) VALUES (:nome_usuario, :email, :senha, :primeiro_nome, :ultimo_nome, :data_nasc, :tipo)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome_usuario', $nome_usuario);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':primeiro_nome', $primeiro_nome);
        $stmt->bindParam(':ultimo_nome', $ultimo_nome);
        $stmt->bindParam(':data_nasc', $data_nasc);
        $stmt->bindParam(':tipo', $tipo);

        if ($stmt->execute()) {
            header("Location: ../pagina/login.php?success=Cadastro realizado com sucesso!");
        } else {
            header("Location: ../pagina/cadastro.php?error=Erro ao cadastrar. Tente novamente.");
        }
    } catch (PDOException $e) {
        header("Location: ../pagina/cadastro.php?error=Erro no banco de dados: " . $e->getMessage());
    }
} else {
    header("Location: ../pagina/cadastro.php?error=Preencha todos os campos.");
}
?>
