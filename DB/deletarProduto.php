<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["user_email"]) {
    include("../DB/db_conn.php");

    // Verifica se o ID do produto foi passado pela URL
    if (isset($_GET['id'])) {
        $idProduto = $_GET['id'];

        try {
            // Preparando a exclusão do produto no banco de dados
            $sql = "DELETE FROM produtos WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$idProduto]);

            if ($res) {
                $msgSuccess = "Produto deletado com sucesso!";
                header("Location: ../pagina/admin.php?success=$msgSuccess");
                exit();
            } else {
                $msgErr = "Erro ao tentar deletar o produto.";
                header("Location: ../pagina/admin.php?error=$msgErr");
                exit();
            }
        } catch (PDOException $e) {
            $msgErr = "Erro no banco de dados: " . $e->getMessage();
            header("Location: ../pagina/admin.php?error=$msgErr");
            exit();
        }
    } else {
        header("Location: ../pagina/admin.php?error=ID do produto não encontrado.");
        exit();
    }
} else {
    header("Location: ../pagina/login.php");
    exit();
}
?>
