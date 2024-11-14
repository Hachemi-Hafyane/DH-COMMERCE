<?php
session_start();
include("../DB/validacao.php");
include("../DB/arquivoUpload.php");
if (isset($_SESSION["user_id"]) && $_SESSION["user_email"]) {
  include("../DB/db_conn.php");
  if (
    isset($_POST['nomeProduto']) &&
    isset($_POST['categoriaProduto']) &&
    isset($_POST['descricaoProduto']) &&
    isset($_POST['quantidadeProduto']) &&
    isset($_POST['precoProduto']) &&
    isset($_FILES['imgProduto'])
  ) {


    $nomeProd = $_POST['nomeProduto'];
    $categoriaProd = $_POST['categoriaProduto'];
    $descricaoProd = $_POST['descricaoProduto'];
    $quantidadeProd = $_POST['quantidadeProduto'];
    $precoProd = $_POST['precoProduto'];
    $imgProd = $_FILES['imgProduto'];
    $inputUsuario = "nome:" . $nomeProd . "&categoria=" . $categoriaProd . "&descricao=" . $descricaoProd . "&quantidade=" . $quantidadeProd . "&preco=" . $precoProd;

    $texto = "Nome do produto";
    $caminho = "../pagina/addProduto.php";
    $ms = "error";
    vazio($nomeProd, $texto, $caminho, $ms, $inputUsuario);

    $texto = "Categoria do produto";
    $caminho = "../pagina/addProduto.php";
    $ms = "error";
    vazio($categoriaProd, $texto, $caminho, $ms, $inputUsuario);

    $texto = "Descrição do produto";
    $caminho = "../pagina/addProduto.php";
    $ms = "error";
    vazio($descricaoProd, $texto, $caminho, $ms, $inputUsuario);

    $texto = "Quantidade do produto";
    $caminho = "../pagina/addProduto.php";
    $ms = "error";
    vazio($quantidadeProd, $texto, $caminho, $ms, $inputUsuario);

    $texto = "Prego do produto";
    $caminho = "../pagina/addProduto.php";
    $ms = "error";
    vazio($precoProd, $texto, $caminho, $ms, $inputUsuario);
    $allowed_img_exs = array("jpg", "jpeg", "png");
    $path = 'file';
    $produtoLink = arquivoUpload($imgProd, $allowed_img_exs, $path);

    if ($produtoLink['status'] == 'error') {
      $em = $produtoLink['data'];
      header("Location: ../pagina/addProduto.php?error=$em&$inputUsuario");
      exit;
    } else {
      $file_url = $produtoLink['data'];
      $sql = "INSERT INTO produtos (titulo,file,descricao,preco,quantidade,categoria_id) VALUES (?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$nomeProd,$file_url,$descricaoProd,$precoProd,$quantidadeProd,$categoriaProd]);
      if($stmt){
        $sm = "Cadastro realizado com sucesso";
        header("Location: ../pagina/addProduto.php?success=$sm");
      }else{
        $em = "Ocorreu erro no cadastro";
        header("Location: ../pagina/addProduto.php?error=$em");
      }
    }
  } else {
    header(header: "Location: ../pagina/admin.php");
  }
} else {
  header("Location: ../pagina/login.php");
  exit();
}
