<?php
session_start();
include "../DB/db_conn.php"; // Conexão ao banco usando PDO
include("../DB/categoria.php");
$categorias = categorias($conn);
// Verifica se o ID do produto foi passado na URL
if (isset($_GET['p'])) {
    $produtoId = (int)$_GET['p'];

    // Consulta para buscar informações do produto pelo ID
    $query = "SELECT p.id, p.titulo, p.descricao, p.preco, p.file AS imagem, c.titulo AS categoria 
              FROM produtos p 
              JOIN categorias c ON p.categoria_id = c.id 
              WHERE p.id = :produtoId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o produto foi encontrado
    if (!$produto) {
        echo "Produto não encontrado!";
        exit;
    }
} else {
    echo "Produto inválido!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DH-COMMERCE</title>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="../css/slick.css" />
	<link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />

	<!-- Nouislider -->
	<link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />

	<!-- Font Awesome -->
	<link rel="stylesheet" href="../css/font-awesome.min.css">

	<!-- Custom Styles -->
	<link type="text/css" rel="stylesheet" href="../css/style.css" />
	<link type="text/css" rel="stylesheet" href="../css/accountbtn.css" />

	<style>
		/* Personalização de estilos */
		#navigation {
			background: linear-gradient(to right, #F9D423, #FF4E50);
		}

		#header {
			background: linear-gradient(to right, #061161, #780206);
		}

		#top-header {
			background: linear-gradient(to right, #190A05, #870000);
		}

		#footer {
			background: linear-gradient(to right, #348AC7, #7474BF);
			color: #1E1F29;
		}

		.footer-links li a {
			color: #1E1F29;
		}

		.mainn-raised {
			margin: -7px 0px 0px;
			border-radius: 6px;
			box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
		}

		.dropdownn>a {
			color: white;
			font-weight: bold;
			text-decoration: none;
		}

		.dropdownn>a:hover {
			color: #f0f0f0;
		}

		.dropdownn-content {
			background-color: #333;
			border: 1px solid #555;
		}

		.dropdownn-content a {
			color: white;
			padding: 10px 15px;
			display: block;
			text-decoration: none;
		}

		.dropdownn-content a:hover {
			background-color: #555;
			color: #f0f0f0;
		}
	</style>
</head>

<body>
	<!-- HEADER -->
	<header>
		<!-- TOP HEADER -->
		<div id="top-header">
			<div class="container">
				<ul class="header-links pull-right">
					<?php
					if (isset($_SESSION['user_id'])) : ?>
						<div class="dropdownn">
							<a href="#" class="dropdownn"><i class="fa fa-user-o"></i> Bem-vindo, <?= htmlspecialchars($_SESSION["user_nome"]) ?></a>
							<div class="dropdownn-content">
								<a href="../pagina/perfil.php"><i class="fa fa-user-circle"></i> Meu Perfil</a>
								<a href="../DB/logout.php"><i class="fa fa-sign-out"></i> Sair</a>
							</div>
						</div>
					<?php else : ?>
						<div class="dropdownn">
							<a href="#" class="dropdownn"><i class="fa fa-user-o"></i> Minha Conta</a>
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
							<form action="../pagina/resultados.php" method="GET">
								<select class="input-select" name="categoria">
									<option value="0">Selecione a categoria</option>
									<?php if ($categorias) : ?>
										<?php foreach ($categorias as $categoria) : ?>
											<option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['titulo']) ?></option>
										<?php endforeach; ?>
									<?php else : ?>
										<option value="1">Nenhuma categoria cadastrada</option>
									<?php endif; ?>
								</select>
								<input class="input" id="search" name="busca" type="text" placeholder="Busque aqui">
								<button type="submit" id="search_btn" class="search-btn">Buscar</button>
							</form>
						</div>
					</div>
					<!-- /SEARCH BAR -->

					<!-- ACCOUNT -->
					<div class="col-md-3 clearfix">
						<div class="header-ctn">
							<!-- Cart -->
							<div class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-shopping-cart"></i>
									<span>Carrinho</span>
									<div class="badge qty">0</div>
								</a>
								<div class="cart-dropdown">
									<div class="cart-list" id="cart_product"></div>
									<div class="cart-btns">
										<a href="../pagina/carrinho.php"><i class="fa fa-edit"></i> Editar Carrinho</a>
									</div>
								</div>
							</div>
							<!-- /Cart -->

							<!-- Menu Toggle -->
							<div class="menu-toggle">
								<a href="#"><i class="fa fa-bars"></i><span>Menu</span></a>
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

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Imagem do produto -->
                <img src="../uploads/file/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['titulo']) ?>" class="img-fluid" style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="col-md-6">
                <!-- Informações do produto -->
                <h1><?= htmlspecialchars($produto['titulo']) ?></h1>
                <p class="text-muted">Categoria: <?= htmlspecialchars($produto['categoria']) ?></p>
                <h3 class="text-danger">R$<?= htmlspecialchars($produto['preco']) ?></h3>
                <p><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>
                <button class="btn btn-primary btn-lg mt-3">Adicionar ao Carrinho</button>
            </div>
        </div>
    </div>
</body>

</html>