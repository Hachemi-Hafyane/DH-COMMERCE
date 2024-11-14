<?php
session_start();
if(isset($_SESSION["user_id"]) && $_SESSION["user_email"] && $_SESSION['user_tipo'] === 'Admin') {   

    include("../DB/db_conn.php");
    include("../DB/arquivoUpload.php");
    include("../DB/validacao.php");
    include("../DB/produto.php");

    if (isset($_POST['idProduto']) && 
        isset($_POST['nomeProduto']) && 
        isset($_POST['categoriaProduto']) &&
        isset($_POST['descricaoProduto']) &&
        isset($_POST['quantidadeProduto']) &&
        isset($_POST['precoProduto']) &&
        isset($_POST['imgAtual'])) {

        $idProduto = $_POST['idProduto'];
        $nomeProduto = $_POST['nomeProduto'];
        $categoriaProduto = $_POST['categoriaProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidadeProduto = $_POST['quantidadeProduto'];
        $precoProduto = $_POST['precoProduto'];
        $imgAtual = $_POST['imgAtual'];

        // Validação de campos vazios
        vazio($nomeProduto, "Nome do produto", "../pagina/editProdutoPag.php", "id=$idProduto&error", "");
        vazio($categoriaProduto, "Categoria do produto", "../pagina/editProdutoPag.php", "id=$idProduto&error", "");
        vazio($descricaoProduto, "Descrição do produto", "../pagina/editProdutoPag.php", "id=$idProduto&error", "");
        vazio($quantidadeProduto, "Quantidade do produto", "../pagina/editProdutoPag.php", "id=$idProduto&error", "");
        vazio($precoProduto, "Preço do produto", "../pagina/editProdutoPag.php", "id=$idProduto&error", "");

        $allowed_img_exs = array("jpg", "jpeg", "png");
        $path = 'file';

        // Verificação de imagem
        if (!empty($_FILES['imgProduto']['name'])) {
            $produtoLink = arquivoUpload($_FILES['imgProduto'], $allowed_img_exs, $path);

            if ($produtoLink['status'] == "error") {
                $errorMsg = $produtoLink['data'];
                header("Location: ../pagina/editProdutoPag.php?error=$errorMsg&id=$idProduto");
                exit;
            } else {
                // Deleta a imagem antiga
                unlink("../uploads/file/$imgAtual");
                $imgAtual = $produtoLink['data'];
            }
        }

        // Atualiza os dados do produto
        $sql = "UPDATE produtos SET 
                    titulo = ?, 
                    descricao = ?, 
                    preco = ?, 
                    quantidade = ?, 
                    categoria_id = ?, 
                    file = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([$nomeProduto, $descricaoProduto, $precoProduto, $quantidadeProduto, $categoriaProduto, $imgAtual, $idProduto]);

        // Verifica o sucesso da atualização
        if ($res) {
            $msgSuccess = "Atualização realizada com sucesso";
            header("Location: ../pagina/editProdutoPag.php?success=$msgSuccess&id=$idProduto");
        } else {
            $msgErr = "Erro na atualização do produto";
            header("Location: ../pagina/editProdutoPag.php?error=$msgErr&id=$idProduto");
        }
        exit();
    } else {
        header("Location: ../pagina/admin.php");
        exit();
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
