<?php
session_start();
if(isset($_SESSION["user_id"]) && $_SESSION["user_email"] && $_SESSION['user_tipo'] === 'Admin') {    
  include("../DB/db_conn.php");
  include("../DB/produto.php");
  include("../DB/categoria.php");
  $produtos = produtos($conn);
  $categorias = categorias($conn);
  $key = isset($_GET['key']) ? $_GET['key'] : '';
  if ($key) {
    $produtos = search_produtos($conn, $key);
  } else {
    $produtos = produtos($conn);
  }

?>

  <!DOCTYPE html>
  <html lang="pt-br">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DH-COMMERCE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>

  <body>
    <h class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="admin.php">DH-COMMERCE ADMIN</a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Loja <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="addProduto.php">Adicionar Produto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="addCategoria.php">Adcionar Categoria</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../DB/logout.php">Logout</a>
            </li>
          </ul>
          </form>
        </div>
      </nav>
      <form action="admin.php" method="get" style="width: 100%; max-width: 30rem;" class="my-5">
      <div class="input-group">
        <input type="text" name="key" class="form-control" placeholder="Pesquisar produto" aria-label="Pesquisar produto" value="<?= htmlspecialchars($key) ?>">
        <div class="input-group-append">
          <button class="input-group-text btn btn-primary"><img src="../icons/pesquisarIcon.png" alt="Pesquisar" width="20"></button>
        </div>
      </div>
    </form>
      <?php
      if (isset($_GET['error'])) {
      ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($_GET['error']) ?>
        </div>
      <?php
      } else if (isset($_GET['success'])) {
      ?>
        <div class="alert alert-success" role="alert">
          <?php echo htmlspecialchars($_GET['success']) ?>
        </div>
      <?php } ?>
      <?php if ($produtos != 0) { ?>

        <h4 class="mt-5">Todos os produtos</h4>
        <table class="table table-bordered shadow">
          <thead>
            <tr>
              <th>#</th>
              <th>Nome do produto</th>
              <th>Categoria</th>
              <th>Descrição</th>
              <th>Preço</th>
              <th>Quantidade</th>
              <th>Imagem</th>
              <th>Acão</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            foreach ($produtos as $produto) {
              $i++;
            ?>
              <tr>
                <td><?= $i ?></td>
                <td><?= $produto['titulo'] ?></td>
                <td>
                  <?php
                  if ($categorias == 0) {
                    echo 'Não definido';
                  } else {
                    foreach ($categorias as $categoria) {
                      if ($categoria['id'] == $produto['categoria_id']) {
                        echo $categoria['titulo'];
                      }
                    }
                  }
                  ?>



                </td>
                <td><?= $produto['descricao'] ?></td>
                <td>R$ <?= $produto['preco'] ?></td>
                <td><?= $produto['quantidade'] ?></td>
                <td><img src="../uploads/file/<?= $produto['file'] ?>" alt="mouse" height="100px" width="100px"></td>
                <td>
                  <a href="editProdutoPag.php?id=<?= $produto['id'] ?>" class="btn btn-warning">Edit</a>
                  <a href="../DB/deletarProduto.php?id=<?= $produto['id'] ?>" class="btn btn-danger">Delete</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
      <?php if ($categorias == 0) { ?>

      <?php  } else { ?>

        <h4 class="mt-5">Todas as categorias</h4>
        <table class="table table-bordered shadow">
          <thead>
            <tr>
              <th>#</th>
              <th>Categoria</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $c = 0;
            foreach ($categorias as $categoria) {
              $c++;
            ?>
              <tr>
                <td><?= $c ?></td>
                <td><?= $categoria['titulo'] ?></td>
                <td>
                  <a href="editCategoriaPag.php?id=<?= $categoria['id'] ?>" class="btn btn-warning">Edit</a>
                  <a href="../DB/deletarCategoria.php?id=<?= $categoria['id'] ?>" class="btn btn-danger">Delete</a>
                </td>
              </tr>
            <?php  } ?>
          </tbody>
        </table>
      <?php  } ?>
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