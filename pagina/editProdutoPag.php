<?php
  session_start();
  if(isset($_SESSION["user_id"]) && $_SESSION["user_email"] && $_SESSION['user_tipo'] === 'Admin') {    
    if(!isset($_GET['id'])) {
        header('Location: ../pagina/admin.php');
        exit();
    }
    // if($produto == 0){
    //     header('Location: ../pagina/admin.php');
    //     exit();
    // }
    $id = $_GET['id'];
    include("../DB/db_conn.php");
    include("../DB/categoria.php");
    include("../DB/produto.php");
    $categorias = categorias($conn);
    $produto = editProdutos($conn,$id);
   
  ?>
  <!DOCTYPE html>
  <html lang="pt-br">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Editar Produto</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
      <h class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="../pagina/admin.php">DH-COMMERCE ADMIN</a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index.php"
                  >Loja <span class="sr-only">(current)</span></a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="addProduto.php">Adicionar Produto</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="addCategoria.php">Adicionar Categoria</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../DB/logout.php">Logout</a>
              </li>
            </ul>
          </div>
        </nav>
        </nav>  
        <form action="../DB/editarProduto.php" enctype="multipart/form-data" method="post" class="shadow p-4 rounded mt-5" style="width:90%;max-width: 50rem ;">
        <?php 
          if(isset($_GET['error'])){
        ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($_GET['error']) ?>
        </div>
        <?php
          }else if(isset($_GET['success'])){
        ?>
              <div class="alert alert-success" role="alert">
          <?php echo htmlspecialchars($_GET['success']) ?>
        </div>
              <?php } ?>
          <h1 class="text-center pb-5 display-4 fs-3">
              Editar Produto
          </h1>
          <input type="hidden" name="idProduto" value="<?= $produto['id']?>">
          <div class="mb-3">
              <label class="form-label">Nome do produto</label>
              <input type="text" class="form-control" name="nomeProduto" value="<?= $produto['titulo'] ?>">
          </div>
          <div class="mb-3">
              <label class="form-label">Categoria do produto</label>
              <select name="categoriaProduto" class="form-control">
                     <?php
                          if($categorias == 0){ ?>
                              <option value="1">Nenhuma categoria cadastrada</option> 
                      <?php   }else{
                      foreach($categorias as $categoria){ 
                        if($produto['categoria_id'] == $categorias['id']){ ?>
                          <option value="<?= $categoria['id'] ?>"><?= $categoria['titulo'] ?></option>
                      <?php } } } ?>
                      <?php
                          if($categorias == 0){ ?>
                              <option value="1">Nenhuma categoria cadastrada</option> 
                      <?php   }else{
                      foreach($categorias as $categoria){ ?>
                          <option value="<?= $categoria['id'] ?>"><?= $categoria['titulo'] ?></option>
                      <?php } } ?>
              </select>
          </div>
          <div class="mb-3">
              <label class="form-label">Descrição do Produto</label>
              <textarea name="descricaoProduto" class="form-control" value="<?= $produto['descricao'] ?>"><?= $produto['descricao'] ?></textarea>
          </div>
          <div class="mb-3">
              <label class="form-label">Quantidade do produto</label>
              <input type="number" class="form-control" name="quantidadeProduto" value="<?= $produto['quantidade'] ?>">
          </div>
          <div class="mb-3">
              <label class="form-label">Preço do produto</label>
              <input type="number" class="form-control" name="precoProduto" value="<?= $produto['preco'] ?>">
          </div>
          <div class="mb-3">
              <label class="form-label  ">Insira a imagem do produto</label>
              <input type="text" hidden value="<?= $produto['file'] ?>" name="imgAtual">
              <input type="file" class="form-control" name="imgProduto" value="<?= $produto['file'] ?>">
              <a href="../uploads/file/<?= $produto['file'] ?>" class='link-dark'>Imagem atual</a>
          </div>
          <button type="submit" class="btn btn-primary">Atualizar produto</button>
        </form>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
  </html>
  <?php    
 }else{
  if($_SESSION['user_tipo'] !== 'Admin'){
    header("Location: ../pagina/index.php");
  exit();
  }else{
  header("Location: ../pagina/login.php");
  exit();
}
}
  ?>