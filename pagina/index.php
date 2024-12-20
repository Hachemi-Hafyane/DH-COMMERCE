<?php
session_start();
include "../DB/db_conn.php"; // Conexão ao banco usando PDO
include("../DB/categoria.php");
$categorias = categorias($conn); // Obtém categorias do banco
$start = isset($_GET['start']) ? (int)$_GET['start'] : 61; // Valor padrão 1
$end = isset($_GET['end']) ? (int)$_GET['end'] : 71; // Valor padrão 10 (exemplo)
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
	<!-- /HEADER -->

	<!-- PRODUCTS -->
	<div class="container mainn-raised mt-4">
		<div class="row">
			<?php
			$query = "SELECT p.id, p.titulo, p.preco, p.file AS imagem, c.titulo AS categoria 
	   FROM produtos p 
	   JOIN categorias c ON p.categoria_id = c.id 
	   WHERE p.id BETWEEN :start AND :end";
			$stmt = $conn->prepare($query);
			// Passando os parâmetros corretamente
			$stmt->bindParam(':start', $start, PDO::PARAM_INT);
			$stmt->bindParam(':end', $end, PDO::PARAM_INT);
			$stmt->execute();
			$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if ($produtos) :
				foreach ($produtos as $produto) : ?>
					<p></p>
					<P></P>
					<P></P>
					<P></P>
					<div class="col-md-4 mb-4">
						<div class="card h-100 shadow-sm">
							<a href="product.php?p=<?= htmlspecialchars($produto['id']) ?>">
								<?php
								$imagePath = "../uploads/file/" . htmlspecialchars($produto['imagem'], ENT_QUOTES, 'UTF-8');
								?>
								<a href="produtoPag.php?p=<?= htmlspecialchars($produto['id']) ?>">
									<img src="<?= $imagePath ?>"
										class="card-img-top"
										alt="<?= htmlspecialchars($produto['titulo'], ENT_QUOTES, 'UTF-8') ?>"
										style="max-height: 200px; object-fit: cover;">
								</a>

							</a>
							<P></P>
							<P></P>
							<P></P>
							<div class="card-body">
								<h5 class="card-title text-uppercase"><?= htmlspecialchars($produto['titulo']) ?></h5>
								<p class="card-text text-muted"><?= htmlspecialchars($produto['categoria']) ?></p>
								<h6 class="text-danger">R$<?= htmlspecialchars($produto['preco']) ?></h6>
							</div>
							<div class="card-footer bg-transparent border-0">
								<button class="btn btn-primary btn-block add-to-cart-btn" pid="<?= htmlspecialchars($produto['id']) ?>">
									<i class="fa fa-shopping-cart"></i> Adicionar ao Carrinho
								</button>
							</div>
						</div>
					</div>
				<?php endforeach;
			else : ?>
				<p></p>
				<p></p>

				<div class="col-12">
					<p class="text-center">Nenhum produto disponível no momento.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- /PRODUCTS -->
</body>

</html>