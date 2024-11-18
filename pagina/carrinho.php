<?php
session_start();
include "../DB/db_conn.php";
include("../DB/categoria.php");
$categorias = categorias($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>DH-COMMERCE</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

  <!-- Bootstrap -->
  <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />

  <!-- Slick -->
  <link type="text/css" rel="stylesheet" href="../css/slick.css" />
  <link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />

  <!-- nouislider -->
  <link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />

  <!-- Font Awesome Icon -->
  <link rel="stylesheet" href="../css/font-awesome.min.css">

  <!-- Custom stylesheet -->
  <link type="text/css" rel="stylesheet" href="../css/style.css" />
  <link type="text/css" rel="stylesheet" href="../css/accountbtn.css" />

  <!-- Custom Styles -->
  <link type="text/css" rel="stylesheet" href="../css/custom-style.css" />
</head>

<body>
  <!-- HEADER -->
  <header>
    <!-- TOP HEADER -->
    <div id="top-header">
      <div class="container">
        <ul class="header-links pull-right">
          <?php if (isset($_SESSION['user_id'])): ?>
            <div class="dropdownn">
              <a href="#" class="dropdownn">
                <i class="fa fa-user-o"></i> Bem-vindo, <?= htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8') ?>
              </a>
              <div class="dropdownn-content">
                <a href="../pagina/perfil.php"><i class="fa fa-user-circle"></i> Meu Perfil</a>
                <a href="../DB/logout.php"><i class="fa fa-sign-out"></i> Sair</a>
              </div>
            </div>
          <?php else: ?>
            <div class="dropdownn">
              <a href="#" class="dropdownn">
                <i class="fa fa-user-o"></i> Minha Conta
              </a>
              <div class="dropdownn-content">
                <a href="../pagina/login.php"><i class="fa fa-sign-in"></i> Login</a>
                <a href="../pagina/cadastrarPag.php"><i class="fa fa-user-plus"></i> Registrar</a>
              </div>
            </div>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
      <div class="container">
        <div class="row">
          <!-- LOGO -->
          <div class="col-md-3">
            <div class="header-logo">
              <a href="../pagina/index.php" class="logo">
                <font style="font-style:normal; font-size: 33px;color: aliceblue;font-family: serif">
                  DH-COMMERCE
                </font>
              </a>
            </div>
          </div>
          <!-- /LOGO -->

          <!-- SEARCH BAR -->
          <div class="col-md-6">
            <div class="header-search">
              <form action="../pagina/resultados.php" method="GET" style="display: flex; align-items: center;">
                <select class="input-select" name="categoria" style="margin-right: 10px;">
                  <option value="0">Selecione a categoria</option>
                  <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                      <option value="<?= htmlspecialchars($categoria['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($categoria['titulo'], ENT_QUOTES, 'UTF-8') ?>
                      </option>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <option value="">Nenhuma categoria cadastrada</option>
                  <?php endif; ?>
                </select>
                <input class="input" id="search" name="busca" type="text" placeholder="Busque aqui" style="flex: 1; margin-right: 10px;">
                <button type="submit" id="search_btn" class="search-btn" style="padding: 10px 20px;">Buscar</button>
              </form>
            </div>
          </div>
          <!-- /SEARCH BAR -->

          <!-- ACCOUNT -->
          <div class="col-md-3 clearfix">
            <div class="header-ctn">
              <!-- Cart -->
              <div class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-shopping-cart"></i>
                  <span>Carrinho</span>
                  <div class="badge qty">0</div>
                </a>
                <div class="cart-dropdown">
                  <div class="cart-list" id="cart_product"></div>
                  <div class="cart-btns">
                    <a href="../DB/carrinho.php"><i class="fa fa-edit"></i> Editar Carrinho</a>
                  </div>
                </div>
              </div>
              <!-- /Cart -->

              <!-- Menu Toggle -->
              <div class="menu-toggle">
                <a href="#">
                  <i class="fa fa-bars"></i>
                  <span>Menu</span>
                </a>
              </div>
              <!-- /Menu Toggle -->
            </div>
          </div>
          <!-- /ACCOUNT -->
        </div>
      </div>
    </div>
    <!-- /MAIN HEADER -->
  </header>
  <!-- /HEADER -->

  <section class="section">
    <div class="container-fluid">	
      <div id="cart_checkout"></div>
    </div>
  </section>	

  <!-- FOOTER -->
  <footer id="footer">
    <div class="section">
      <div class="container">
        <div class="row">
          <!-- About Us -->
          <div class="col-md-3 col-xs-6">
            <div class="footer">
              <h3 class="footer-title">Sobre Nós</h3>
              <ul class="footer-links">
                <li><a href="https://www.google.com.br/maps/place/R.+Fernando+Zanata,+133+-+Jardim+Angelica,+Crici%C3%BAma+-+SC,+88804-790/@-28.7039959,-49.4034159,18z/data=!4m6!3m5!1s0x9521824dca064e6f:0x8a7042ee67ecf190!8m2!3d-28.7039959!4d-49.4021284!16s%2Fg%2F11fzz9yylw?entry=ttu&g_ep=EgoyMDI0MTExMy4xIKXMDSoASAFQAw%3D%3D"><i class="fa fa-map-marker"></i>Brazil, Santa Catarina, Criciúma, R. Fernando Zanata, 133 - Jardim Angelica</a></li>
                <li><a href="#"><i class="fa fa-phone"></i>+55 (48) 99876-3244</a></li>
                <li><a href="mailto:hachemihafyane@gmail.com?subject=Contato comercial&body="><i class="fa fa-envelope-o"></i>hachemihafyane@gmail.com</a></li>
              </ul>
            </div>
          </div>
          <!-- /About Us -->

          <!-- Categories -->
          <div class="col-md-3 col-xs-6">
  <div class="footer">
    <h3 class="footer-title">Categorias</h3>
    <ul class="footer-links">
      <?php if (!empty($categorias)): ?>
        <?php foreach ($categorias as $categoria): ?>
          <li>
            <a href="categoria.php?id=<?= htmlspecialchars($categoria['id'], ENT_QUOTES, 'UTF-8') ?>">
              <?= htmlspecialchars($categoria['titulo'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          </li>
        <?php endforeach; ?>
      <?php else: ?>
        <li><a href="#">Nenhuma categoria disponível</a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>


          <!-- Payments -->
          <div class="col-md-6 text-center" style="margin-top:80px;">
            <ul class="footer-payments">
              <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
              <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
              <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
              <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
            </ul>
            <span class="copyright">
              &copy; <?= date('Y') ?> DH-Commerce. Todos os direitos reservados.
            </span>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- /FOOTER -->

  <!-- Scripts -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/slick.min.js"></script>
  <script src="js/nouislider.min.js"></script>
  <script src="js/jquery.zoom.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/actions.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <script src="js/script.js"></script>
  <script src="../js/custom-scripts.js"></script>
</body>
</html>
