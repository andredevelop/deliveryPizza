<?php include('config.php'); ?>
<?php Site::updateUsuarioOnline(); ?>
<?php Site::contadorVisitas(); ?>
<?php
//para selecionar as coisas da tabela para o index exeto projetos e serviços
	$chamada = Painel::selecionarTudo('tb_site.config');
	foreach ($chamada as $key => $value) {

	}

?>
<!-- fazer o resto do sobre -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $value['titulo']; ?></title>
	<!-- font open sans -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
	<!-- metatags -->
	<meta name="description" content="Desenvolvedor fullstack brasileiro e legitimamente cearense e pronto para solucionar seu problema! Acesse, e veja o que posso fazer por você e seu negócio."/>
	<meta name="keywords" content="ande duarte pacajus programador desenvolvedor de site site como fazer como fazer um site mesmo você tipo criar jogo web mobile aplicativo loja virtual pizzaria delivery" />
	<meta name="author" content="Francisco André - Dev. Web, mobile">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
	<!-- icone site -->
	<link rel="shortcut icon" type="image-x/png" href="<?php echo INCLUDE_PATH ?>favicon.ico">
	<!-- charset -->
	<meta charset="utf-8">
	<!-- font awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
	<script src="https://kit.fontawesome.com/d76df92ddf.js" crossorigin="anonymous"></script>
	<link href="<?php echo INCLUDE_PATH ?>css/all.css" rel="stylesheet"/>
	<!-- estilo -->
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/jquery.fancybox.css"/>
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/style.css"/>
</head>
<body>

<?php 
	$produtos = Painel::selecionarTudo('tb_site.produtos');
	foreach ($produtos as $key => $value) {

}
	
	if(isset($_GET['mycar'])){
		
		$idProduto = (int) $_GET['mycar'];
		if(isset($produtos[$idProduto])){
			if(isset($_SESSION['mycar'][$idProduto])){
				$_SESSION['mycar'][$idProduto]['quantidade']++;
			}else{
				$_SESSION['mycar'][$idProduto] = array('quantidade'=>1,'nome'=>$produtos[$idProduto]['nome'],'preco'=>$produtos[$idProduto]['preco']);
			}
			echo "<script>alert('Produto adicionado ao carrinho, dá uma conferida no icone de carrinho de compras!')</script>";
			echo '<script>location.href="'.INCLUDE_PATH.'"</script>';
		}else{
			die('O item que está tentando adicionar não existe. Volte ao inicio da página');
		}
	}
?>

<section class="carrinho">
	<div class="container">
		<div class="carroWraper">
			<i class="fa-solid fa-square-xmark"></i>
			
			<h4>Produtos:</h4>

			<?php 
                 if(isset($_GET['remover'])){
					$idRemover = (int)$_GET['remover'];

					if(isset($_SESSION['mycar'][$idRemover]) & $_SESSION['mycar'][$idRemover]['quantidade'] > 1){

						$_SESSION['mycar'][$idRemover]['quantidade']--;

					}else if(isset($_SESSION['mycar'][$idRemover]) & $_SESSION['mycar'][$idRemover]['quantidade'] <= 1){

						unset($_SESSION['mycar'][$idRemover]);
					}

					echo '<script>location.href="'.INCLUDE_PATH.'"</script>';
				}
				
				$valorF = Painel::selecionarTudo('tb_admin.frete');

				foreach ($valorF as $key => $value) {

					$frete = $value['valor'];
				}

				$total = 0;
				if(!isset($_SESSION['mycar'])){
					echo '<h4>Primeiro adicione um item ao carrinho 😁😋</h4>';
				}else{
					foreach($_SESSION['mycar'] as $key =>$value){
					$total += $value['preco']*$value['quantidade'];
			?>
			<p>Nome: <?php echo $value['nome'] ?> -> Unidades: (<?php echo $value['quantidade'] ?>) -> Preço: R$ <?php echo number_format(($value['quantidade']*$value['preco']),2,',','.');?> <a href="?remover=<?php echo $key ?>"><i class="fa-solid fa-trash-can"></i></a></p>
			<?php }} ?>

			<h4>Frete:</h4>
			<p>R$ <?php echo number_format($frete,2,',','.')?></p>
			<h4>Total à pagar:</h4>	
			<p><?php if($total != '0'){ echo 'R$ '.number_format($total+$frete,2,',','.'); }?></p>

			
			<form method="post">
				<h4>Meio de pagamento:</h4>
				<select name="opcao_pagamento" class="meioPagamento">
					<option value="Cartão">Cartão</option>
					<option value="PIX">PIX</option>
					<option value="Dinheiro">Dinheiro</option>
				</select><!-- meio pagamento -->

				<div class="troco">
					<h4>Insira seu dinheiro:</h4>
					<input type="number" name="troco" placeholder="Insira o valor que tem em mão para obter troco">
				</div><!-- troco -->
				
				<h4>Insira seu endereço:</h4>
				<input required type="text" name="endereco">
				<h4>Observações:</h4>
				<textarea placeholder="Escreva aqui uma observação caso queira. Exemplo: sem orégano" name="obs"></textarea>
				<input type="submit" name="acao" value="Confirme o pedido" class="btnPadrao2">
			</form>
			

			<div class="finalPedido">
				<?php 

					if(isset($_POST['acao'])){
						if(!isset($_SESSION['mycar'])){
							echo '<script>alert("Você precisa adicionar itens ao carrinho")</script>';
							echo '<script>location.href="'.INCLUDE_PATH.'"</script>';
						}

						$metodoPagamento = $_POST['opcao_pagamento'];
						$endereco = $_POST['endereco'];
						$observacao = $_POST['obs'];

						$troco = $_POST['troco'];
						$_SESSION['troco'] = $troco;


						$_SESSION['endereco'] = $endereco;
						$_SESSION['observacao'] = $observacao;
						$_SESSION['troco'] = $troco;
						$_SESSION['tipo_pagamento'] = $metodoPagamento;
						
						echo '<script>location.href="'.INCLUDE_PATH.'fim.php"</script>';
					}
				
				?>
			 	
			</div><!-- finalPedido -->

		</div><!-- carroWraper -->
	</div><!-- container -->
</section><!-- carrinho -->

<header id="home">
	<i class="fas fa-bars right"></i><!-- menu mobile tn -->
		<div class="container">
			<nav class="menu-desktop">
				<ul>
					<li><a href="#home">Home</a></li>
					<li><a href="#cardapio">Cardápio</a></li>
					<li><i class="fa-solid fa-cart-shopping">
                        <?php 
							if(!isset($_SESSION['mycar'])){
                                echo 0;
							}else{
								echo array_sum(array_column($_SESSION['mycar'], 'quantidade'));
							}
						?>
                    </i></li>
				</ul>
			</nav>
			
			<div class="logo-wraper">
				<a href="home"><img src="<?php echo INCLUDE_PATH; ?>image/logo.png"></a>
			</div>
            
			<nav class="menu-mobile">
				<ul>
					<li><i class="fa-solid fa-cart-shopping">
                        <?php
							if(!isset($_SESSION['mycar'])){
                                echo 0;
							}else{
								echo array_sum(array_column($_SESSION['mycar'], 'quantidade'));
							}
						?>
                        </i></li>
				</ul>
			</nav><!-- menu mobile -->
			<div class="clear"></div>
		</div><!-- container -->
</header><!-- header -->

<section class="aviso">
	<?php 
		$aviso = Painel::selecionarTudo('tb_site.aviso');
		foreach ($aviso as $key => $value) {
	?>
	<h3><i class="fa-solid fa-triangle-exclamation"></i> <?php echo $value['descricao'] ?></h3>
	<?php } ?>
</section><!-- aviso -->

<section class="cardapio" id="cardapio">


	<div class="container">

        <form method="post" class="buscaProduto">
            <input type="text" name="buscar" placeholder="Faça uma busca pelo produto...">
            <input type="submit" name="busca" value="Buscar!">
        </form><!-- buscar produto -->

		<div class="produtoWraper">
			<?php
                $query = '';
				if(isset($_POST['busca']) && $_POST['busca'] == 'Buscar!'){
					$nome = $_POST['buscar'];
					if($nome == ''){
						$query = '';
					}else{
						$query = "WHERE nome LIKE '%$nome%' OR descricao LIKE '%$nome%'";
					}
				}
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.produtos` $query");
				$sql->execute();
				$produtos = $sql->fetchAll();

				if($query != ''){
					echo '<div style="width:100%;" class="padding:8px;"><p>Foram encontrados <b>'.count($produtos).'</b> resultado(s)</p></div>';
				}
                
				foreach ($produtos as $key => $value) {
			?>
			<div class="produtoSingle">
				<a id="imgComida" href="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']?>"><img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']?>"></a>
				<h4><?php echo $value['nome']?></h4>
				<h4>R$ <?php echo number_format($value['preco'],2,',','.')?></h4>

				<input type="button" data-id="show" class="btnPadrao" value="Descrição">

				<a class="btnPadrao" href="?mycar=<?php echo $value['id']-1 ?>">Adicionar ao carrinho</a>

				<div class="descricao">
					<i class="fa-solid fa-xmark close"></i>
					<p><?php echo $value['descricao']?></p>
				</div><!-- descricao -->
			</div><!-- produtoSingle -->
			<?php } ?>

		</div><!-- produtoWraper -->
	</div><!-- container -->

</section><!-- cardapio -->

<section class="depoimentos">
	<div class="container">
		
	</div><!-- container -->
</section><!-- depoimentos -->

<footer>
	<div class="container">

		<div class="direitos">
			<img src="<?php echo INCLUDE_PATH ?>/image/logo.png">
			<p>Todos os direitos Reservados</p>
			<p>Desenvolvido por <a style="text-decoration:none;color:white" target="_blank" href="https://www.instagram.com/duartcode/">{DUARTCODE}</a></p>
			<p>Pacajus - Ceará - Brasil</p>			
		</div><!-- direitos -->

		<div class="linkUtil">
			<h3>Links Úteis</h3>
			<a href="#home">Home</a>
			<a href="#cardapio">Cardápio</a>
			<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
		</div><!-- link util -->

	</div><!-- container -->
</footer>


<script src="<?php echo INCLUDE_PATH ?>js/jquery.js"></script>
<script src="<?php echo INCLUDE_PATH ?>js/jquery.fancybox.js"></script>
<script src="<?php echo INCLUDE_PATH ?>js/jquery.mask.js"></script>
<script src="<?php echo INCLUDE_PATH ?>js/functions.js"></script>
<script type="text/javascript">
	//para poder atualizar pagina sem enviar formulario
	if ( window.history.replaceState ) {
 	 window.history.replaceState( null, null, window.location.href );
}
</script>
</body>
</html>