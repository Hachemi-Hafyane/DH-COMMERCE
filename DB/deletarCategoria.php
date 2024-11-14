<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["user_email"]) {
    include("../DB/db_conn.php");

    // Verifica se o ID da categoria foi passado pela URL
    if (isset($_GET['id'])) {
        $idCategoria = $_GET['id'];

        try {
            // Preparando a exclusão da categoria no banco de dados
            $sql = "DELETE FROM categorias WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$idCategoria]);

            if ($res) {
                $msgSuccess = "Categoria deletada com sucesso!";
                header("Location: ../pagina/admin.php?success=$msgSuccess");
                exit();
            } else {
                $msgErr = "Erro ao tentar deletar a categoria.";
                header("Location: ../pagina/admin.php?error=$msgErr");
                exit();
            }
        } catch (PDOException $e) {
            $msgErr = "Erro no banco de dados: " . $e->getMessage();
            header("Location: ../pagina/admin.php?error=$msgErr");
            exit();
        }
    } else {
        header("Location: ../pagina/admin.php?error=ID da categoria não encontrado.");
        exit();
    }
} else {
    header("Location: ../pagina/login.php");
    exit();
}
?>
