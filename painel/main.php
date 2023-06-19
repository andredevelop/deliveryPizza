<?php 
	if(isset($_GET['loggout'])){
		Painel::loggout();
	}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Painel de controle | <?php echo $_SESSION['nome'] ?></title>
	<!-- font open sans -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- metatags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
	<!-- icone site -->
	<link rel="shortcut icon" type="image-x/png" href="favicon.ico">
	<!-- charset -->
	<meta charset="utf-8">
	<!-- font awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/d76df92ddf.js" crossorigin="anonymous"></script>
	<link href="<?php echo INCLUDE_PATH ?>css/all.css" rel="stylesheet">
	<!-- estilo -->
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL; ?>css/painel_style.css">
	<!-- icone site -->
	<link rel="shortcut icon" type="image-x/png" href="<?php echo INCLUDE_PATH ?>favicon.ico">
</head>
<body>

<aside class="sidebar sideBar-color">
	<div class="user-img">
		<?php 
			if($_SESSION['img'] == ''){
		?>
			<i class="far fa-user icone-user-empty"></i>
		<?php }else{ ?>
			<!-- puxa a img do banco de dados pelo nome e se ela tive no upload ela vai aparecer -->
			<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $_SESSION['img'] ?>">
		<?php } ?>

		<div class="name-user">
			<p><i class="far fa-heart icon-color"></i> <?php echo $_SESSION['nome']; ?></p>
			<p><?php echo pegaCargo($_SESSION['cargo']); ?></p>
		</div><!-- name-user -->
	</div><!-- user-img -->

	<div class="side-menus">
		<a <?php selecionadoMenu('editar-usuario'); ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-usuario"><i class="fas fa-user-alt icon-color"></i> EDITAR USUÁRIO</a>
		<a <?php selecionadoMenu('adicionar-usuario'); ?> <?php verificaPermissaoMenu(2); ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-usuario"><i class="fas fa-user-plus icon-color"></i> ADD USUÁRIO</a>
		<a <?php selecionadoMenu('adicionar-tecnologias'); ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-tecnologias"><i class="fa-solid fa-triangle-exclamation icon-color"></i> AVISOS</a>
		<a <?php selecionadoMenu('adicionar-projeto'); ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-projeto"><i class="fa-solid fa-utensils icon-color"></i> PRODUTOS</a>
		<a <?php selecionadoMenu('depoimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>depoimentos"><i class="fas fa-comments icon-color"></i> DEPOIMENTOS</a>
		<a <?php selecionadoMenu('config-geral'); ?> href="<?php echo INCLUDE_PATH_PAINEL; ?>config-geral"><i class="fas fa-sliders-h icon-color"></i> CONFIG. GERAL</a>
	</div><!-- side-menus -->

	<div class="box-switch">
		<input type="checkbox" id="switch" name="mode">
	</div><!-- box-switch -->
</aside><!-- sidebar -->

<main class="main-painel fundo-main">
	<header class="header-main-color">
		<i class="fa fa-bars color-texto icone-menu"></i>
		<div class="btn-log">
			<a <?php if(@$_GET['url'] == ''){ ?> style="background-color: #ebebee;" <?php } ?> class="color-texto" href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fas fa-home"></i> Pagina inicial</a>
			<a class="color-texto" href="<?php echo INCLUDE_PATH_PAINEL ?>?loggout"><i class="fas fa-sign-out-alt"></i> Sair</a>
		</div><!-- btn-log -->
	</header><!-- header-main-color -->

	<?php 
		Painel::carregarPagina();
	?>

</main>

<div class="clear"></div>

<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/function.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.mask.js"></script>
</body>
</html>